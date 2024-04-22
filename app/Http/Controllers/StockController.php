<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    function index(Request $request)
    {
        $query = DB::connection('logo')->table(generateTableName('ITEMS', true))
        ->where('CODE', '!=', 'ÿ');

        if ($request->has('group_code') && $request->group_code != '0') {
            $query->where('STGRPCODE', $request->group_code);
        }

        $stock_list = $query->paginate(15);

        $all_stock = DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', '!=', 'ÿ')->get();

        $group_codes = [];
        foreach ($all_stock as $stock) {
            if (!in_array($stock->STGRPCODE, $group_codes))
            $group_codes[] = $stock->STGRPCODE;
        }
        return view('stock.list', compact('stock_list', 'group_codes'));

    }

    function getStock($code) {
        $stock = DB::connection('logo')->table(generateTableName('ITEMS', true))->where('CODE', $code)->first();
        $stock->price = DB::connection('logo')->table(generateTableName('PRCLIST', true))->where('CARDREF', $stock->LOGICALREF)->where('PTYPE', 1)->first()->PRICE ?? 0;
        return response()->json($stock);
    }
}
