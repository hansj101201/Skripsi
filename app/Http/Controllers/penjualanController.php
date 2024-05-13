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
        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        $gudang = gudang::where('ID_DEPO', getIdDepo())->get();
        return view('layout.transaksi.penjualan.index', compact('barang','gudang','customer','tglClosing'));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN', '12')
        ->where(DB::raw('LEFT(BUKTI, 1)'), '0')
        ->join('customer', 'trnsales.ID_CUSTOMER', 'customer.ID_CUSTOMER')
        ->select('trnsales.*', 'customer.NAMA AS nama_customer');

        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');

        return DataTables::of($trnsales)
        ->editColumn('ID_CUSTOMER', function ($row) {
            return $row->nama_customer;
        })
        ->addColumn('action', function ($row) {
            $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><span class="fas fa-eye"></span></button> &nbsp;';
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
            $nextBukti = "00000001";
            $formattedBukti = $nextBukti;
        }
        return $formattedBukti;
    }

    public function postPenjualan(Request $request){
        $bukti = $this->generateBukti($request->tanggal);
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        $customer = customer::where('ID_CUSTOMER', $request->customer)
        ->value('NAMA');
        try {
            $bukti = $this->generateBukti($request->tanggal);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1;
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
                    'KET01' => 'Penjualan ke Customer '.$request->customer.' - '.$customer,
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor++,
                ]);
            }
            DB::commit();
            return response()->json(['success'=> true, 'message' => 'Data Sudah Disimpan dengan No Bukti '. $bukti, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
