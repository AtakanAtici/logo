<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();
        if ($request->has('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }
        if ($request->perpage && $request->perpage == 'all') {
            $orders = $query->get();
        } else {
            $orders = $query->paginate($request->perpage ?? 10);
        }

        $orders->map(function ($order) {
            $order->current = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', $order->current_id)->first();
            $order->stock = DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', $order->stock_id)->first();
        });

        return view('orders.list', compact('orders'));
    }

    function create()
    {
        $currents = DB::connection('logo')->table(generateTableName('CLCARD', true))
            ->where('CODE', '!=', 'ÿ')
            ->get();
        $stocks = DB::connection('logo')->table(generateTableName('ITEMS', true))
            ->where('CODE', '!=', 'ÿ')
            ->get();

        return view('orders.create', compact('currents', 'stocks'));
    }

    function detail($id)
    {
        $order = Order::find($id);
        $order->current = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', $order->current_id)->first();
        $order->items->map(function ($item) {
            $item->price_withput_tax = $item->total_price - $item->tax_amount;
            $item->stock = DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', $item->stock_code)->first();
        });

        return view('orders.detail', compact('order'));
    }

    function store(Request $request)
    {
        $request->validate([
            'current_id' => 'required',
            'order_date' => 'required',
            'status' => 'required',
        ]);

        $items_info = $request->items;
        $items_info = json_decode($items_info);


        if (!$request->code) {
            $request->code = 'ORD' . time();
        }


        DB::beginTransaction();
        $order = Order::create([
            'code' => $request->code,
            'current_id' => $request->current_id,
            'status_key' => $request->status,
            'order_date' => $request->order_date,
        ]);

        foreach ($items_info as $item) {
            $order->items()->create([
                'stock_code' => $item->stock_id,
                'per_price' => stringToDecimal($item->per_price),
                'quantity' => $item->quantity,
                'tax_percent' => $item->tax_percent,
                'tax_amount' => stringToDecimal($item->total_price) * stringToDecimal($item->tax_percent) / 100,
                'total_price' => stringToDecimal($item->total_price),
            ]);
        }

        $this->sendToLogo($order);

        DB::commit();

        return redirect()->back()->with('success', 'Sipariş Başarıyla Oluşturuldu');
    }

    function edit($id)
    {
        $order = Order::find($id);
        $currents = DB::connection('logo')->table(generateTableName('CLCARD', true))->get();
        $stocks = DB::connection('logo')->table(generateTableName('ITEMS', true))->get();
        $order->items->map(function ($item) {
            $item->stock = DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', $item->stock_code)->first();
        });
        return view('orders.edit', compact('order', 'currents', 'stocks'));
    }

    function update(Request $request)
    {
        // dd($request->all());
    }

    function xml($id)
    {
        $order = Order::find($id);
        $order->current = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', $order->current_id)->first();
        $items = $order->items;
        $xml = "<SALES_ORDERS>";
        $xml .= "<ORDER_SLIP DBOP='INS'>";
        $xml .= "<NUMBER>{$order->code}</NUMBER>";
        $xml .= "<DATE>".Carbon::parse($order->order_date)->format('d.m.Y')."</DATE>";
        $xml .= "<TIME></TIME>";
        $xml .= "<ARP_CODE>" . ($order->current != null ? $order->current->CODE : "") . "</ARP_CODE>"; //Cari kodu
        $xml .= "<TOTAL_DISCOUNTED>0</TOTAL_DISCOUNTED>";
        $xml .= "<TOTAL_VAT>{$order->items->sum('tax_amount')}</TOTAL_VAT>"; //Toplam KDV
        $xml .= "<TOTAL_GROSS>{$order->items->sum('total_price')}</TOTAL_GROSS>"; //Toplam Brüt vergi dahil
        $xml .= "<TOTAL_NET>{$order->items->sum('total_price')}</TOTAL_NET>"; //Toplam Net vergi hariç
        $xml .= "<RC_RATE>1</RC_RATE>"; //Kur 1
        $xml .= "<RC_NET>{$order->items->sum('total_price')}</RC_NET>"; //Net Kur (vergi dahil toplam yazılacak)
        $xml .= "<ORDER_STATUS>1</ORDER_STATUS>";
        $xml .= "<CREATED_BY>1</CREATED_BY>"; //Kullanıcı kodu
        $xml .= "<DATE_CREATED>".Carbon::parse($order->created_at)->format('d.m.Y')."</DATE_CREATED>"; //Oluşturulma tarihi
        $xml .= "<HOUR_CREATED>".Carbon::parse($order->created_at)->format('h')."</HOUR_CREATED>"; //Oluşturulma saati
        $xml .= "<MIN_CREATED>".Carbon::parse($order->created_at)->format('i')."</MIN_CREATED>"; //Oluşturulma dakikası
        $xml .= "<SEC_CREATED>".Carbon::parse($order->created_at)->format('s')."</SEC_CREATED>"; //Oluşturulma saniyesi
        $xml .= "<CURRSEL_TOTAL>2</CURRSEL_TOTAL>"; //genel döviz türü
        $xml .= "<DATA_REFERENCE>1</DATA_REFERENCE>";
        $xml .= "<TRANSACTIONS>";
        foreach ($order->items as $item) {
            $xml .= "<TRANSACTION>";
            $xml .= "<TYPE>0</TYPE>";
            $xml .= "<MASTER_CODE>{$item->stock_code}</MASTER_CODE>";
            $xml .= "<QUANTITY>{$item->quantity}</QUANTITY>";
            $xml .= "<PRICE>{$item->per_price}</PRICE>";
            $xml .= "<TOTAL>{$item->total_price}</TOTAL>";
            $xml .= "<VAT_RATE>{$item->tax_percent}</VAT_RATE>";
            $xml .= "<VAT_AMOUNT>{$item->tax_amount}</VAT_AMOUNT>";
            $xml .= "<VAT_BASE>1000</VAT_BASE>"; //kdv matrahı
            $xml .= "<UNIT_CODE>ADET</UNIT_CODE>"; //Birim
            $xml .= "<UNIT_CONV1>1</UNIT_CONV1>"; //çevrim katsayısı
            $xml .= "<UNIT_CONV2>1</UNIT_CONV2>"; //çevrim katsayısı
            $xml .= "<DUE_DATE></DUE_DATE>"; //tarih ama ne tarihi
            $xml .= "<CURR_PRICE>{$item->per_price}</CURR_PRICE>";
            $xml .= "<PC_PRICE>50</PC_PRICE>"; //fiyatlandırma dövizi
            $xml .= "<RC_XRATE>1</RC_XRATE>"; //raporlama döviz kuru
            $xml .= "<TOTAL_NET>{$item->total_price}</TOTAL_NET>";
            $xml .= "<DATA_REFERENCE>1</DATA_REFERENCE>";
            $xml .= "<DETAILS> </DETAILS>";
            $xml .= "<CAMPAIGN_INFOS>";
            $xml .= "<CAMPAIGN_INFO> </CAMPAIGN_INFO>";
            $xml .= "</CAMPAIGN_INFOS>";
            $xml .= "<DEFNFLDS> </DEFNFLDS>";
            $xml .= "<PRCLISTREF>7</PRCLISTREF>";
            $xml .= "</TRANSACTION>";
        }

        $xml .= "</TRANSACTIONS>";
        $xml .= "<ORGLOGOID/>";
        $xml .= "<DEFNFLDSLIST> </DEFNFLDSLIST>";
        $xml .= "<AFFECT_RISK>0</AFFECT_RISK>";
        $xml .= "</ORDER_SLIP>";
        $xml .= "</SALES_ORDERS>";

        return response($xml)->header('Content-Type', 'text/xml');
    }

    /*
    |----------------------------------------------------------------------------
    | Uygulanadaki bir siparişi logo veritabanına kayıt eder.
    |----------------------------------------------------------------------------
     */
    function sendToLogo(Order $order)
    {
        $sales_order = DB::connection('logo')->table(generateTableName('ORFICHE'))->get();
        $order->current = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', $order->current_id)->first();

        $inserted_id = DB::connection('logo')->table(generateTableName('ORFICHE'))->max('LOGICALREF') + 1;

        $total_vat = $order->items->sum('total_price') * $order->items->sum('tax_percent') / 100;
        $new_sales_order = [
            'LOGICALREF' => $inserted_id,
            'TRCODE' => 1, // verilen sipariş
            'FICHENO' => $order->code,
            'DATE_' => (string)Carbon::parse($order->order_date)->format('Y'),
            'TIME_' => (string)Carbon::parse($order->order_date)->format('h'),
            'CLIENTREF' => $order->current->LOGICALREF,
            'RECVREF' => 0,
            'ACCOUNTREF' => 0,
            'CENTERREF' =>0,
            'SOURCEINDEX' => 0,
            'SOURCECOSTGRP' => 0,
            'UPDCURR' => 0,
            'ADDDISCOUNTS' => 0,
            'TOTALDISCOUNTS' => 0,
            'TOTALDISCOUNTED' => 0,
            'ADDEXPENSES' => 0,
            'TOTALEXPENSES' => 0,
            'TOTALPROMOTIONS' => 0,
            'TOTALVAT' => $total_vat,
            'GROSSTOTAL' => $order->items->sum('total_price'),
            'NETTOTAL' => $order->items->sum('total_price') - $total_vat,
            'REPORTRATE' => 1,
            'REPORTNET' => $order->items->sum('total_price'),
            'EXTENREF' => 0,
            'PAYDEFREF' => 0,
            'PRINTCNT' => 0,
            'BRANCH' => 0,
            'DEPARTMENT' => 0,
            'STATUS' => 1,
            'TEXTINC' => 0,
            'SITEID' => 0,
            'RECSTATUS' => 1,
            'ORGLOGICREF' => 0,
            'FACTORYNR' => 0,
            'WFSTATUS' => 0,
            'SHIPINFOREF' => 0,
            'SENDCNT' => 0,
            'DLVCLIENT' => 0,
            'CANCELLED' => 0,
            'OFFERREF' => 0,
            'OFFALTREF' => 0,
            'TYP' => 0,
            'ALTNR' => 0,
            // 'ADVANCEPAYMEN' => 0,
            'TRCURR' => 0,
            'TRRATE' => 0,
            'TRNET' => 0,
            'PAYMENTTYPE' => 0,
            'ONLYONEPAYLINE' => 0,
            'OPSTAT' => 0,
            'WITHPAYTRANS' => 0,
            'PROJECTREF' => 0,
            'WFLOWCRDREF' => 0,
            // 'UPDCRCURR' => 0,
            'AFFECTCOLLATRL' => 0,
            'CAPIBLOCK_CREATEDBY' => 1,
            'CAPIBLOCK_CREADEDDATE' => (string)Carbon::now()->format('Y'),
            'CAPIBLOCK_CREATEDHOUR' => (string)Carbon::now()->format('H'),
            'CAPIBLOCK_CREATEDMIN' => (string)Carbon::now()->format('i'),
            'CAPIBLOCK_CREATEDSEC' => (string)Carbon::now()->format('s'),
            'GENEXCTYP' => '2',
        ];

        DB::beginTransaction();

        foreach ($order->items as $key => $item) {
            $inserted_id = DB::connection('logo')->table(generateTableName('ORFLINE'))->max('LOGICALREF') + 1;
            $new_sales_order_item = [
                'LOGICALREF' => $inserted_id,
                'ORDFICHEREF' => $new_sales_order['LOGICALREF'],
                'STOCKREF' => DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', $item->stock_code)->first()->LOGICALREF,
                'CLIENTREF' => $order->current->LOGICALREF,
                'AMOUNT' => $item->quantity,
                'LINETYPE' => 0,
                'PRICE' => $item->per_price,
                'TOTAL' => $item->total_price,
                'VAT' => $item->tax_percent,
                'VATAMNT' => $item->tax_amount,
                'LINENO_'=> $key+1,
                'TRCODE' => 2,
                'DATE_' => (string)Carbon::parse($order->order_date)->format('Y'),
                'TIME_' => (string)Carbon::parse($order->order_date)->format('H'),
                'VATMATRAH' => 1000,
            ];
            $sales_order_item = DB::connection('logo')->table(generateTableName('ORFLINE'))->insert($new_sales_order_item);
        }

        $sales_order = DB::connection('logo')->table(generateTableName('ORFICHE'))->insert($new_sales_order);
        DB::commit();

        return true;
    }
}
