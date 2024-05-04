<?php

namespace App\Http\Controllers;

use App\Models\gudang;
use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pengembalianController extends Controller
{
    //
    public function generateBukti($tanggal, $id){
        // Parse the provided date
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);

        // Retrieve the top 1 BUKTI for the current year using Eloquent
        $topBukti = trnsales::select('BUKTI')
            ->where('KDTRN', '15')
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

    public function postPengembalian(Request $request){
        $jsonData = $request->json()->all();

        $tanggal = $jsonData['TANGGAL']; // "12-04-2024"
        $idSales = $jsonData['ID_SALES']; // "002"
        $idGudang = $jsonData['ID_GUDANG']; // "ooo"
        $idGudangTujuan = $jsonData['ID_GUDANG_TUJUAN'];
        $idDepo = $jsonData['ID_DEPO']; // "202404"
        $periode = $jsonData['PERIODE']; // "555"
        $dataArray = $jsonData['DATA'];
        $currentDateTime = date('Y-m-d H:i:s');
        // Start a transaction
        DB::beginTransaction();

        try {
            // Generate BUKTI
            $bukti = $this->generateBukti($tanggal,$idSales);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $nomor = 1; // Initialize the nomor counter

            $gudangTujuan = gudang::where('ID_GUDANG', $idGudangTujuan)
            ->value('NAMA');

            $gudangAsal = gudang::where('ID_GUDANG',$idGudang)
            ->value('NAMA');
            // Create trnsales record
            trnsales::create([

                'KDTRN' => '15',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $periode,
                'ID_GUDANG' => $idGudang,
                'ID_GUDANG_TUJUAN' => $idGudangTujuan,
                'ID_DEPO' => $idDepo,
                'ID_SALESMAN' => $idSales
            ]);

            trnsales::create([
                'KDTRN' => '05',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $periode,
                'ID_GUDANG' => $idGudangTujuan,
                'ID_DEPO' => $idDepo,
                'ID_SALESMAN' => $idSales
            ]);
            // Create trnjadi records
            for ($i = 0; $i < count($dataArray); $i++) {
                $item = $dataArray[$i];
                // dd($item[2]);
                trnjadi::create([
                    'KDTRN' => '15',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $idGudang,
                    'PERIODE' => $periode,
                    'KET01' => 'Pengembalian ke Gudang '.$request->gudang_tujuan.' - '.$gudangTujuan,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[2],
                    'ID_DEPO' => $idDepo,
                    'NOMOR' => $nomor, // Increment nomor for each item
                ]);

                trnjadi::create([
                    'KDTRN' => '05',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $idGudangTujuan,
                    'PERIODE' => $periode,
                    'KET01' => 'Terima dari Salesman '.$request->gudang_asal.' - '.$gudangAsal,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[2],
                    'ID_DEPO' => $idDepo,
                    'NOMOR' => $nomor, // Increment nomor for each item
                ]);
                $nomor++;
            }

            // Commit the transaction if all operations succeed
            DB::commit();

            // Return a success response
            return response()->json(['success'=> true, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();

            // Return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
