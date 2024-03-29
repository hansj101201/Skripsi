<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class pengeluaranBarangKanvasController extends Controller
{
    //
    public function index(){
        $trnsales = trnsales::where('KDTRN','30')->where('STATUS',0)->where('ID_DEPO', getIdDepo())->get();
        // dd($trnsales);
        $gudang = gudang::where('ID_DEPO', getIdDepo())->get();
        return view("layout.transaksi.kanvas.index", compact("gudang","trnsales"));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN','15')
        ->where('NOPERMINTAAN','!=','')
        ->join('gudang as G1', 'trnsales.ID_GUDANG', '=', 'G1.ID_GUDANG')
        ->join('salesman', 'trnsales.ID_GUDANG_TUJUAN', '=', 'salesman.ID_GUDANG')
        ->select('trnsales.*', 'G1.NAMA as NAMA_GUDANG', 'salesman.NAMA as NAMA_GUDANG_TUJUAN');

        // dd($trnsales);
        return DataTables::of($trnsales)
        ->addColumn('action', function ($row) {
            // Initialize the action buttons HTML
            $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#detailModal" data-bukti="'.$row->BUKTI.'" data-tanggal="'.$row->TANGGAL.'" data-nomorpermintaan="'.$row->NOPERMINTAAN.'" data-periode="'.$row->PERIODE.'"><span class="fas fa-eye"></span></button>';
            // Check if $row->jumlah is zero
            if ($row->JUMLAH == 0) {
                // If $row->jumlah is zero, add the delete button
                $actionButtons .= '&nbsp;<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            }
            // Return the action buttons HTML
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function fetchData($id){
        // dd($id);
        $trnsales = trnsales::join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
        ->select('trnsales.*', 'salesman.ID_GUDANG AS gudang_sales')
        ->where('trnsales.KDTRN', '30')
        ->where('trnsales.NOPERMINTAAN', $id)
        ->where('trnsales.STATUS', 0)
        ->get();

        // dd($trnsales);
        if($trnsales->isNotEmpty()){
            return response()->json($trnsales);
        } else {
            return response()->json(['error','message'=> 'Data tidak ditemukan'],404);
        }
    }

    public function fetchDetail($id, $periode){
        $trnjadi = trnjadi::where('KDTRN','30')
        ->where('BUKTI',$id)
        ->where('PERIODE',$periode)
        ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('trnjadi.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->get();

        return response()->json($trnjadi);
    }

    public function getDetail($bukti,$periode){
        $data = trnjadi::where('KDTRN','15')
        ->where('PERIODE', $periode)
        ->where('BUKTI',$bukti)
        ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('trnjadi.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->orderBy('NOMOR','asc')
        ->get();

        return response()->json($data);
    }

    public function generateBukti($tanggal){
        // Parse the provided date
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);

        // Retrieve the top 1 BUKTI for the current year using Eloquent
        $topBukti = trnsales::select('BUKTI')
            ->where('KDTRN', '15')
            ->where('NOPERMINTAAN','!=','')
            ->whereYear('TANGGAL', $Tanggal->format('Y')) // Filter by year
            ->orderByDesc('BUKTI') // Order by BUKTI in descending order
            ->first();

        // Extract and increment BUKTI if it exists, otherwise start from S000001
        if ($topBukti) {
            $nextBukti = intval(substr($topBukti->BUKTI, 1)) + 1;
            $formattedBukti = 'S' . str_pad($nextBukti, 5, '0', STR_PAD_LEFT);
        } else {
            $nextBukti = 1;
            $formattedBukti = 'S' . str_pad($nextBukti, 5, '0', STR_PAD_LEFT);
        }

        return $formattedBukti;
    }

    public function updateTrnsalesStatus($nopermintaan) {

        // Update the trnsales record where KDTRN is 30 and NOPERMINTAAN is equal to the value from the request
        trnsales::where('KDTRN', '30')
            ->where('NOPERMINTAAN', $nopermintaan)
            ->update(['STATUS' => 1]);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'trnsales STATUS updated successfully'], 200);
    }


    public function postTrnCanvas(Request $request){
        // $bukti = $this->generateBukti($request->tanggal);
        // dd($bukti);

        // dd($request->all());
        $currentDateTime = date('Y-m-d H:i:s');
        // Start a transaction
        DB::beginTransaction();

        try {
            // Generate BUKTI
            $bukti = $this->generateBukti($request->tanggal);
            // dd($request->nomorpo);


            // Format tanggal
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            // dd($data);
            // dd($data);
            $nomor = 1; // Initialize the nomor counter



            // Create trnsales record
            trnsales::create([
                'KDTRN' => '15',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang_asal,
                'ID_GUDANG_TUJUAN' => $request->gudang_tujuan,
                'ID_DEPO' => getIdDepo(),
                'NOPERMINTAAN' => $request->nopermintaan,
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);

            trnsales::create([
                'KDTRN' => '05',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang_tujuan,
                'ID_DEPO' => getIdDepo(),
                'NOPERMINTAAN' => $request->nopermintaan,
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);

            $this->updateTrnsalesStatus($request->nopermintaan);
            // Create trnjadi records
            foreach ($data as $item) {
                // dd($item[2]);
                trnjadi::create([
                    'KDTRN' => '15',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang_asal,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor++, // Increment nomor for each item
                ]);

                trnjadi::create([
                    'KDTRN' => '05',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang_tujuan,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor++, // Increment nomor for each item
                ]);
            }

            // Commit the transaction if all operations succeed
            DB::commit();

            // Return a success response
            return response()->json(['success'=> true, 'message' => 'Data Sudah Disimpan dengan No Bukti '. $bukti, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();

            // Return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postDetailTrnCanvas(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            // dd($data);
            foreach ($data as $item) {
                trnjadi::where('KDTRN', '15')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                ]);

                trnjadi::where('KDTRN', '05')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                ]);
            }
            DB::commit();

            // Mengembalikan respons JSON untuk memberi tahu klien bahwa pembaruan berhasil
            return response()->json(['success'=>true,'message' => 'Update successful']);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, rollback transaksi dan kirim respons kesalahan
            DB::rollBack();
            return response()->json(['success'=>false,'message' => 'Error occurred while updating data'], 500);
        }
    }
}
