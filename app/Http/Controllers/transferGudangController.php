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

class transferGudangController extends Controller
{
    //
    public function index(){
        $barang = barang::all();
        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        return view("layout.transaksi.transferGudang.index", compact('barang','tglClosing'));
    }

    public function datatable(){
        $trnsales = trnsales::where('KDTRN','15')
        ->where('trnsales.ID_DEPO',getIdDepo())
        ->where('NOPERMINTAAN',null)
        ->whereNull('ID_SALESMAN')
        ->orWhere('ID_SALESMAN', '')
        ->join('gudang as G1', 'trnsales.ID_GUDANG', 'G1.ID_GUDANG')
        ->join('gudang as G2', 'trnsales.ID_GUDANG_TUJUAN', 'G2.ID_GUDANG')
        ->select('trnsales.*', 'G1.NAMA as NAMA_GUDANG', 'G2.NAMA as NAMA_GUDANG_TUJUAN');

        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        // dd($trnsales);
        return DataTables::of($trnsales)

        ->addColumn('action', function ($row) use ($tglClosing) {

            if($row->TANGGAL <= $tglClosing){
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-kode="detail" data-toggle="modal" data-target="#addDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'" data-mode="viewDetail"><span class="fas fa-eye"></span></button>';
            } else {
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-kode="edit" data-toggle="modal" data-target="#addDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'" data-mode="viewDetail"><span class="fas fa-pencil-alt"></span></button> &nbsp;<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
            }
            // Return the action buttons HTML
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getData($bukti,$periode){
        $trnsales = trnsales::where('KDTRN','15')
        ->where('PERIODE',$periode)
        ->where('BUKTI',$bukti)
        ->first();

        return response()->json($trnsales);
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
            ->where('NOPERMINTAAN',null)
            ->where(function ($query) {
                $query->whereNull('ID_SALESMAN')
                    ->orWhere('ID_SALESMAN', '');
            })
            ->whereYear('TANGGAL', $Tanggal->format('Y')) // Filter by year
            ->orderByDesc('BUKTI') // Order by BUKTI in descending order
            ->first();

        // Extract and increment BUKTI if it exists, otherwise start from S000001
        if ($topBukti) {
            $nextBukti = intval($topBukti->BUKTI) + 1;
            $formattedBukti = str_pad($nextBukti, strlen($topBukti->BUKTI), '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada data, mulai dari 1
            $nextBukti = "00000001";
            $formattedBukti = $nextBukti;
        }
        return $formattedBukti;
    }

    public function postTransferGudang(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $bukti = $this->generateBukti($request->tanggal);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal, new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1;
            $gudangAsal = gudang::where('ID_GUDANG', $request->gudang_asal)->value('NAMA');
            $gudangTujuan = gudang::where('ID_GUDANG', $request->gudang_tujuan)->value('NAMA');
            trnsales::create([
                'KDTRN' => '15',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang_asal,
                'ID_GUDANG_TUJUAN' => $request->gudang_tujuan,
                'ID_DEPO' => getIdDepo(),
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
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);
            foreach ($data as $item) {
                trnjadi::create([
                    'KDTRN' => '15',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang_asal,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'KET01' => 'Transfer ke Gudang '.$request->gudang_tujuan.' - '.$gudangTujuan,
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
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
                    'KET01' => 'Terima dari Gudang '.$request->gudang_asal.' - '.$gudangAsal,
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

    public function postDetailTransferGudang(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            foreach ($data as $item) {
                trnjadi::where('KDTRN', '15')
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
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error saat hapus data'], 500);
        }
    }
}
