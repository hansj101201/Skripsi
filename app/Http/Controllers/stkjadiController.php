<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class stkjadiController extends Controller
{
    //


    public function getSaldoBarang(Request $request){
        $tahun = substr($request->input('tanggal'), -4);
        $saldo = DB::table('stkjadi')
            ->select('SALDO')
            ->where('ID_GUDANG', $request->input('gudang'))
            ->where('ID_DEPO', getIdDepo())
            ->where('ID_BARANG', $request->input('barang_id'))
            ->where('TAHUN', $tahun)
            ->first();

            // dd($saldo);
        $saldoValue = $saldo ? $saldo->SALDO : 0;
        return response()->json($saldoValue);
    }
}
