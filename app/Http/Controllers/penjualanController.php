<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\customer;
use App\Models\gudang;
use App\Models\harga;
use App\Models\trnjadi;
use App\Models\trnsales;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use function Laravel\Prompts\select;

class penjualanController extends Controller
{
    //

    public function index(){
        $barang = barang::all();
        $gudang = gudang::where('ID_DEPO',getIdDepo())->get();
        $customer = customer::all();
        return view('layout.transaksi.penjualan.index', compact('barang','gudang','customer'));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN', '12')
        ->where(DB::raw('LEFT(BUKTI, 1)'), '0')
        ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
        ->select('trnsales.*', 'customer.NAMA AS nama_customer');

        return DataTables::of($trnsales)
        ->editColumn('ID_CUSTOMER', function ($row) {
            return $row->nama_customer;
        })
        ->addColumn('action', function ($row) {
            $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><span class="fas fa-eye"></span></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getData($bukti,$periode){
        $data = trnsales::where('KDTRN','12')
        ->where('PERIODE', $periode)
        ->where('BUKTI',$bukti)
        ->first();
        return response()->json($data);
    }

    public function getDetail($bukti,$periode){
        $data = trnjadi::where('KDTRN','12')
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
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
        $topBukti = trnsales::select('BUKTI')
            ->where('KDTRN', '12')
            ->where(DB::raw('LEFT(BUKTI, 1)'), '0')
            ->whereYear('TANGGAL', $Tanggal->format('Y')) // Filter by year
            ->orderByDesc('BUKTI') // Order by BUKTI in descending order
            ->first();
        if ($topBukti) {
            $nextBukti = intval($topBukti->BUKTI) + 1;
            $formattedBukti = str_pad($nextBukti, strlen($topBukti->BUKTI), '0', STR_PAD_LEFT);
        } else {
            $nextBukti = "000001";
            $formattedBukti = $nextBukti;
        }
        return $formattedBukti;
    }

    public function postPenjualan(Request $request){
        $bukti = $this->generateBukti($request->tanggal);
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $bukti = $this->generateBukti($request->tanggal);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1; // Initialize the nomor counter
            trnsales::create([
                'KDTRN' => '12',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang_asal,
                'ID_CUSTOMER' => $request->customer,
                'ID_DEPO' => getIdDepo(),
                'DISCOUNT' => $request->diskon,
                'JUMLAH' => $request->jumlah,
                'NETTO' => $request->netto,
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);
            foreach ($data as $item) {
                trnjadi::create([
                    'KDTRN' => '12',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang_asal,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'HARGA' => $item[2],
                    'POTONGAN' => $item[3],
                    'JUMLAH' => $item[4],
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor++, // Increment nomor for each item
                ]);
            }
            DB::commit();
            return response()->json(['success'=> true, 'message' => 'Data Sudah Disimpan dengan No Bukti '. $bukti, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postDetailPenjualan(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = $request->data;
            trnsales::where('KDTRN','12')
            ->where('BUKTI', $request->bukti)
            ->where('PERIODE',$request->periode)
            ->update(
                [
                    'DISCOUNT' => $request->diskon,
                    'JUMLAH' => $request->jumlah,
                    'NETTO' => $request->netto,
                    'KETERANGAN' => $request->keterangan,
                    'USEREDIT' => getUserLoggedIn()->ID_USER,
                    'TGLEDIT' => $currentDateTime
                ]
            );
            foreach ($data as $item) {
                trnjadi::where('KDTRN', '12')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                    'HARGA' => $item[2],
                    'POTONGAN' => $item[3],
                    'JUMLAH' => $item[4],
                    'USEREDIT' => getUserLoggedIn()->ID_USER,
                    'TGLEDIT' => $currentDateTime
                ]);
                // dd($trnjadi);
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
            trnsales::where("KDTRN", "12")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();

            // Delete records from trnjadi table
            trnjadi::where("KDTRN", "12")
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
