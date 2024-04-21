<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrentController extends Controller
{
    function index()
    {
        $current_list = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('LOGICALREF', '!=', 1)->paginate(15);

        foreach ($current_list as $current) {
            $borcAlacak = DB::connection('logo')->table(generateTableName('CLTOTFIL'))->where('CARDREF', $current->LOGICALREF)->get();
            $current->borc = $borcAlacak->sum('DEBIT');
            $current->alacak = $borcAlacak->sum('CREDIT');
        }

        return view('current.list', compact('current_list'));
    }

    function detail($code) {
        $current = DB::connection('logo')->table(generateTableName('CLCARD', true))->where('CODE', $code)->first();
        $transactions = DB::connection('logo')->table(generateTableName('CLFLINE'))->where('CLIENTREF', $current->LOGICALREF)->get();


        foreach ($transactions as $transaction) {
            $transaction->tarih = date('d.m.Y', strtotime($transaction->DATE_));
            $transaction->hareket_turu = $transaction->TRCODE == 1 ? 'Satış' : 'Alış';
            $transaction->numara = $transaction->TRANNO;
            $transaction->belge_no = $transaction->DOCODE;
            $transaction->aciklama = $transaction->LINEEXP;
            $transaction->tutar = $transaction->AMOUNT;
            $transaction->kdv = $transaction->VATRATE;
            $transaction->kdv_tutar = $transaction->VATAMOUNT;
        }
        return view('current.detail', compact('current', 'transactions'));
    }
}
