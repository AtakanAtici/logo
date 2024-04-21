<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function index()
    {

        $currents = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', '!=', 'ÿ')->get();

        $currentInfo = [];

        foreach ($currents as $current) {
            
            $total_orders_price = Order::where('current_id', $current->CODE)->get();
            if(count($total_orders_price) == 0){
                continue;
            }
            $total = 0;
            foreach ($total_orders_price as $order) {
                $total += $order->items->sum('total_price');
            }

            $currentInfo[] = [
                'name' => $current->DEFINITION_,
                'price' => $total
            ];
        }

        return view('dashboard.index', compact('currentInfo'));
    }
}
