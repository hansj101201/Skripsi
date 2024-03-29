<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\gudang;
use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class penyesuaianController extends Controller
{
    //
    public function index(){
        $gudang = gudang::where('ID_DEPO',getIdDepo())->get();
        $barang = barang::all();
        return view("layout.transaksi.penyesuaian.index", compact('gudang','barang'));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN', '09')
        ->join('gudang','trnsales.ID_GUDANG', 'gudang.ID_GUDANG')
        ->select('trnsales.*', 'gudang.NAMA AS nama_gudang');

        return DataTables::of($trnsales)
        ->editColumn('ID_GUDANG', function ($row) {
            return $row->nama_gudang;
        })
        ->addColumn('action', function ($row) {
            $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><span class="fas fa-eye"></span></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function generateBukti($tanggal){
        // Parse the provided date
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);

        // Retrieve the top 1 BUKTI for the current year using Eloquent
        $topBukti = trnsales::select('BUKTI')
            ->where('KDTRN', '09')
            ->whereYear('TANGGAL', $Tanggal->format('Y')) // Filter by year
            ->orderByDesc('BUKTI') // Order by BUKTI in descending order
            ->first();

        // Extract and increment BUKTI if it exists, otherwise start from S000001
        if ($topBukti) {
            $nextBukti = intval($topBukti->BUKTI) + 1;
            $formattedBukti = str_pad($nextBukti, strlen($topBukti->BUKTI), '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada data, mulai dari 1
            $nextBukti = "000001";
            $formattedBukti = $nextBukti;
        }
        return $formattedBukti;
    }

    public function getData($bukti,$periode){
        $trnsales = trnsales::where('KDTRN','09')
        ->where('PERIODE',$periode)
        ->where('BUKTI',$bukti)
        ->first();

        return response()->json($trnsales);
    }

    public function getDetail($bukti,$periode){
        $data = trnjadi::where('KDTRN','09')
        ->where('PERIODE', $periode)
        ->where('BUKTI',$bukti)
        ->join('barang','trnjadi.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('trnjadi.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->orderBy('NOMOR','asc')
        ->get();

        return response()->json($data);
    }

    public function postPenyesuaian(Request $request){
        // $bukti = $this->generateBukti($request->tanggal);
        // dd($bukti);

        // dd($request->all());
        $currentDateTime = date('Y-m-d H:i:s');
        // Start a transaction
        DB::beginTransaction();

        try {
            // Generate BUKTI
            $bukti = $this->generateBukti($request->tanggal);
            // Format tanggal
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1; // Initialize the nomor counter

            // Create trnsales record
            trnsales::create([
                'KDTRN' => '09',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang,
                'ID_DEPO' => getIdDepo(),
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);
            // Create trnjadi records
            foreach ($data as $item) {
                // dd($item[2]);
                trnjadi::create([
                    'KDTRN' => '09',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor, // Increment nomor for each item
                ]);
                $nomor++;
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

    public function postDetailPenyesuaian(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            // dd($data);
            foreach ($data as $item) {
                $trnjadi = trnjadi::where('KDTRN', '09')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                    'USEREDIT' => getUserLoggedIn()->ID_USER,
                    'TGLEDIT' => $currentDateTime,
                ]);

                trnjadi::where('KDTRN', '09')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                    'USEREDIT' => getUserLoggedIn()->ID_USER,
                    'TGLEDIT' => $currentDateTime,
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
    public function destroy($bukti, $periode){
        DB::beginTransaction();

        try {
            // Delete records from trnsales table
            trnsales::where("KDTRN", "09")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();

            // Delete records from trnjadi table
            trnjadi::where("KDTRN", "09")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();

            DB::commit();

            // Send a success response after deletion
            return response()->json(['success' => true, 'message' => 'Records deleted successfully']);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction and send an error response
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error occurred while deleting records'], 500);
        }
    }
}
