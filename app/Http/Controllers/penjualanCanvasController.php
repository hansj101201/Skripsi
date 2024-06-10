<?php

namespace App\Http\Controllers;

use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class penjualanCanvasController extends Controller
{
    //
    public function generateBukti($tanggal, $id){
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);

        // Retrieve the top 1 BUKTI for the current year using Eloquent
        $topBukti = trnsales::select('BUKTI')
            ->where('KDTRN', '12')
            ->whereYear('TANGGAL', $Tanggal->format('Y')) // Filter by year
            ->where(DB::raw('LEFT(BUKTI, 3)'), $id) // Filter by LEFT(BUKTI, 3) = $id
            ->orderByDesc('BUKTI') // Order by BUKTI in descending order
            ->first();

        // Extract and increment BUKTI if it exists, otherwise start from S000001
        if ($topBukti) {
            $nextBukti = intval(substr($topBukti->BUKTI, 3)) + 1;
            $formattedBukti = $id . str_pad($nextBukti, 5, '0', STR_PAD_LEFT);
        } else {
            $nextBukti = 1;
            $formattedBukti = $id . str_pad($nextBukti, 5, '0', STR_PAD_LEFT);
        }

        return $formattedBukti;
    }

    public function getTanggalClosing(Request $request){
        $closing = DB::table('closing')
        ->where('ID_DEPO', $request->ID_DEPO)
        ->orderBy('TGL_CLOSING','desc')
        ->select('TGL_CLOSING')
        ->limit(1)
        ->get();

        return response()->json($closing);
    }

    public function postPenjualanCanvas(Request $request){


        $jsonData = $request->json()->all();

        // return response()->json($jsonData['KET01']);
        $tanggal = $jsonData['TANGGAL']; // "12-04-2024"
        $idSales = $jsonData['ID_SALES']; // "002"
        $idGudang = $jsonData['ID_GUDANG']; // "ooo"
        $idCustomer = $jsonData['ID_CUSTOMER'];
        $idDepo = $jsonData['ID_DEPO']; // "202404"
        $periode = $jsonData['PERIODE']; // "555"
        $dataArray = $jsonData['DATA'];
        $ket01 = $jsonData['KET01'];
        $diskon = $jsonData['DISCOUNT'];
        $jumlah = $jsonData['JUMLAH'];
        $netto = $jsonData['NETTO'];

        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $bukti = $this->generateBukti($tanggal, $idSales);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal, new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $nomor = 1; // Initialize the nomor counter
            trnsales::create([
                'KDTRN' => '12',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $periode,
                'ID_GUDANG' => $idGudang,
                'ID_CUSTOMER' => $idCustomer,
                'ID_DEPO' => $idDepo,
                'ID_SALESMAN' => $idSales,
                'DISCOUNT' => $diskon,
                'JUMLAH' => $jumlah,
                'NETTO' => $netto,
                'TGLENTRY' => $currentDateTime
            ]);

            for ($i = 0; $i < count($dataArray); $i++) {
                $item = $dataArray[$i];
                trnjadi::create([
                    'KDTRN' => '12',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $idGudang,
                    'PERIODE' => $periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[3],
                    'HARGA' => $item[2],
                    'JUMLAH' => $item[4],
                    'ID_DEPO' => $idDepo,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor++, // Increment nomor for each item
                    'KET01' => $ket01,
                ]);
            }
            DB::commit();
            return response()->json(['success'=> true, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
