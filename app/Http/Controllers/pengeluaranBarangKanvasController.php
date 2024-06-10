<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\gudang;
use App\Models\trnjadi;
use App\Models\trnsales;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class pengeluaranBarangKanvasController extends Controller
{
    //
    public function index(){
        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        return view("layout.transaksi.kanvas.index", compact("tglClosing"));
    }

    public function datatable(){
        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        $trnsales = trnsales::where('KDTRN','15')
        ->where('NOPERMINTAAN','!=','')
        ->where('trnsales.ID_DEPO',getIdDepo())
        ->join('gudang as G1', 'trnsales.ID_GUDANG', '=', 'G1.ID_GUDANG')
        ->join('salesman', 'trnsales.ID_GUDANG_TUJUAN', '=', 'salesman.ID_GUDANG')
        ->select('trnsales.*', 'G1.NAMA as NAMA_GUDANG', 'salesman.NAMA as NAMA_GUDANG_TUJUAN');

        // dd($trnsales);
        return DataTables::of($trnsales)
        ->addColumn('action', function ($row) use ($tglClosing) {

            if($row->TANGGAL <= $tglClosing){
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-kode="detail" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'" data-mode="viewDetail"><span class="fas fa-eye"></span></button>';
            } else {
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-kode="edit" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'" data-mode="viewDetail"><span class="fas fa-pencil-alt"></span></button> &nbsp;<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            }
            // Return the action buttons HTML
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function fetchData($id){
        $trnsales = trnsales::join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
        ->select('trnsales.*', 'salesman.ID_GUDANG AS gudang_sales')
        ->where('trnsales.KDTRN', '30')
        ->where('trnsales.NOPERMINTAAN', $id)
        ->where('trnsales.STATUS', 0)
        ->get();
        if($trnsales->isNotEmpty()){
            return response()->json($trnsales);
        } else {
            return response()->json(['error','message'=> 'Data tidak ditemukan'],404);
        }
    }

    public function fetchDataSelesai($id){
        $trnsales = trnsales::join('salesman', 'trnsales.ID_SALESMAN', '=', 'salesman.ID_SALES')
        ->select('trnsales.*', 'salesman.ID_GUDANG AS gudang_sales')
        ->where('trnsales.KDTRN', '30')
        ->where('trnsales.NOPERMINTAAN', $id)
        ->get();
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
            $formattedBukti = 'S' . str_pad($nextBukti, 7, '0', STR_PAD_LEFT);
        } else {
            $nextBukti = 1;
            $formattedBukti = 'S' . str_pad($nextBukti, 7, '0', STR_PAD_LEFT);
        }

        return $formattedBukti;
    }

    public function updateTrnsalesStatus($nopermintaan) {
        trnsales::where('KDTRN', '30')
            ->where('NOPERMINTAAN', $nopermintaan)
            ->update(['STATUS' => 1]);
        return response()->json(['success' => true, 'message' => 'trnsales STATUS updated successfully'], 200);
    }

    public function reverseTrnsalesStatus($nopermintaan) {
        trnsales::where('KDTRN', '30')
            ->where('NOPERMINTAAN', $nopermintaan)
            ->update(['STATUS' => 0]);
        return response()->json(['success' => true, 'message' => 'trnsales STATUS updated successfully'], 200);
    }


    public function postTrnCanvas(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $bukti = $this->generateBukti($request->tanggal);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1;
            $gudangTujuan = gudang::where('ID_GUDANG', $request->gudang_tujuan)
            ->value('NAMA');
            $gudangAsal = gudang::where('ID_GUDANG',$request->gudang_asal)
            ->value('NAMA');
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
            foreach ($data as $item) {
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
                    'KET01' => 'Pengeluaran Kanvas ke '.$request->gudang_tujuan.' - '.$gudangTujuan,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor,
                ]);

                trnjadi::create([
                    'KDTRN' => '05',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang_tujuan,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'KET01' => 'Penerimaan Kanvas dari '.$request->gudang_asal.' - '.$gudangAsal,
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'NOMOR' => $nomor,
                ]);
                $nomor++;
            }
            DB::commit();
            return response()->json(['success'=> true, 'message' => 'Data Sudah Disimpan dengan No Bukti '. $bukti, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error saat menyimpan data'], 500);
        }
    }

    public function postDetailTrnCanvas(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            foreach ($data as $item) {
                $trnjadi = trnjadi::where('KDTRN', '15')
                ->where('BUKTI', $request->bukti)
                ->where('PERIODE', $request->periode)
                ->where('ID_BARANG', $item[0])
                ->update([
                    'QTY' => $item[1],
                    'USEREDIT' => getUserLoggedIn()->ID_USER,
                    'TGLEDIT' => $currentDateTime,
                ]);
                trnjadi::where('KDTRN', '05')
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
            return response()->json(['success'=>true,'message' => 'Data berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message' => 'Error saat update data'], 500);
        }
    }

    public function destroy($bukti, $periode){
        DB::beginTransaction();
        $nopermintaan = trnsales::where("KDTRN","05")
        ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->value("NOPERMINTAAN");
        try {
            trnsales::where("KDTRN", "05")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();
            trnjadi::where("KDTRN", "05")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();
            trnsales::where("KDTRN", "15")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();
            trnjadi::where("KDTRN", "15")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();
            $this->reverseTrnsalesStatus($nopermintaan);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error saat hapus data'], 500);
        }
    }

    public function getPermintaanActive(Request $request){
        $tanggal = Carbon::createFromFormat('d-m-Y', $request->TANGGAL)->format('Y-m-d');
        $trnsales = trnsales::where('KDTRN','30')->where('ID_DEPO', getIdDepo())->where('STATUS',0)->whereDate('TANGGAL', '<=', $tanggal)->get();
        return response()->json($trnsales);
    }

    public function getPermintaanAll(Request $request){
        $trnsales = trnsales::where('KDTRN','30')->where('ID_DEPO', getIdDepo())->get();
        return response()->json($trnsales);
    }
}
