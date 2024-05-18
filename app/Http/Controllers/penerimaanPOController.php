<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\dtlinvorder;
use App\Models\gudang;
use App\Models\supplier;
use App\Models\trninvorder;
use App\Models\trnjadi;
use App\Models\trnsales;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class penerimaanPOController extends Controller
{
    public function index(){

        $tglClosing = DB::table('closing')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TGL_CLOSING', 'desc')
        ->value('TGL_CLOSING');
        // dd($gudang);
        return view('layout.transaksi.penerimaanpo.index', compact('tglClosing'));
    }

    public function getNomorPo()
    {
        $idDepo = trim(getIdDepo());
        if ($idDepo != '000') {
            $trnorder = trninvorder::where('STATUS', '!=', 2)->where('ID_DEPO',getIdDepo())->whereDate('TANGGAL', '<=', Carbon::now())->get();
        } else {
            $trnorder = trninvorder::where('STATUS', '!=', 2)->whereDate('TANGGAL', '<=', Carbon::now())->get();
        }

        return response()->json($trnorder);
    }

    public function fetchDataById($id)
    {
        $trnorder = trninvorder::where('NOMORPO',$id)
        ->where('STATUS', '!=', 2)
        ->with('supplier')->get();
        if($trnorder->isNotEmpty()){
            return response()->json($trnorder);
        } else {
            return response()->json(['error','message'=> 'Data tidak ditemukan'],404);
        }
    }

    public function fetchDetailData($id, $periode)
    {
        $dtlorder = dtlinvorder::where('PERIODE',$periode)
        ->where('BUKTI',$id)
        ->join('barang','dtlinvorder.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('dtlinvorder.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->orderBy('NOMOR','asc')
        ->get();
        return response()->json($dtlorder);
    }

    public function datatable(){
        $trnsales = trnsales::join('supplier','trnsales.ID_SUPPLIER','supplier.ID_SUPPLIER')
        ->where('KDTRN','01')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy('TANGGAL','desc')
        ->select('trnsales.*','supplier.NAMA AS nama_supplier')
        ->limit(50);

        $tglClosing = DB::table('closing')
            ->where('ID_DEPO',getIdDepo())
            ->orderBy('TGL_CLOSING', 'desc')
            ->value('TGL_CLOSING');

        return DataTables::of($trnsales)
        ->addColumn('action', function ($row) use ($tglClosing) {
            // Initialize the action buttons HTML
            // Check if $row->jumlah is zero
            if($row->TANGGAL <= $tglClosing){
                $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#detailModal" data-kode"detail" data-bukti="'.$row->BUKTI.'" data-tanggal="'.$row->TANGGAL.'" data-nomorpo="'.$row->NOMORPO.'" data-periode="'.$row->PERIODE.'" data-jumlah="'.$row->JUMLAH.'"><span class="fas fa-eye"></span></button>';
            } else {
                if ($row->JUMLAH == 0) {
                    // If $row->jumlah is zero, add the delete button
                    $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#detailModal" data-kode"detail" data-bukti="'.$row->BUKTI.'" data-tanggal="'.$row->TANGGAL.'" data-nomorpo="'.$row->NOMORPO.'" data-periode="'.$row->PERIODE.'" data-jumlah="'.$row->JUMLAH.'"><span class="fas fa-pencil-alt"></span></button> &nbsp;<button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="'.$row->BUKTI.'" data-periode="'.$row->PERIODE.'"><i class="fas fa-trash"></i></button>';
                } else {
                    $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#detailModal" data-kode"edit" data-bukti="'.$row->BUKTI.'" data-tanggal="'.$row->TANGGAL.'" data-nomorpo="'.$row->NOMORPO.'" data-periode="'.$row->PERIODE.'" data-jumlah="'.$row->JUMLAH.'"><span class="fas fa-eye"></span></button>';
                }
            }
            // Return the action buttons HTML
            return $actionButtons;
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($bukti,$periode){
        $data = trnjadi::where('KDTRN','01')
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
            ->where('KDTRN','01')
            ->whereYear('TANGGAL', $Tanggal->format('Y'))
            ->orderByDesc('BUKTI')
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

    public function updateStatusPO($nomorpo){
        $data = DB::table('hansjrco_abc.dtlinvorder')
            ->whereIn('BUKTI', function ($query) use ($nomorpo) {
                $query->select('BUKTI')
                    ->from('trninvorder')
                    ->where('NOMORPO', $nomorpo);
            })
            ->whereRaw('QTYKIRIM < QTYORDER')
            ->get();

            $items = DB::table('hansjrco_abc.dtlinvorder')
            ->whereIn('BUKTI', function ($query) use ($nomorpo) {
                $query->select('BUKTI')
                    ->from('trninvorder')
                    ->where('NOMORPO', $nomorpo);
            })
            ->get();

        // Check if all quantities are zero
        $allQuantitiesZero = $items->every(function ($item) {
            return $item->QTYKIRIM == 0;
        });

        if ($allQuantitiesZero) {
            DB::table('trninvorder')
                ->where('NOMORPO', $nomorpo)
                ->update(['STATUS' => 0]);
        } elseif($data->isEmpty()){
            DB::table('trninvorder')
            ->where('NOMORPO',$nomorpo)
            ->update(['STATUS'=>2]);
        } else {
            DB::table('trninvorder')
            ->where('NOMORPO',$nomorpo)
            ->update(['STATUS'=>1]);
        }
    }

    public function postTrnJadi(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $bukti = $this->generateBukti($request->tanggal);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');
            $data = $request->data;
            $nomor = 1;
            trnsales::create([
                'KDTRN' => '01',
                'TANGGAL' => $tanggalFormatted,
                'BUKTI' => $bukti,
                'PERIODE' => $request->periode,
                'ID_GUDANG' => $request->gudang,
                'ID_DEPO' => getIdDepo(),
                'ID_SUPPLIER' => $request->supplier,
                'NOMORPO' => $request->nomorpo,
                'KETERANGAN' => $request->keterangan,
                'USERENTRY' => getUserLoggedIn()->ID_USER,
                'TGLENTRY' => $currentDateTime
            ]);
            $namaSupplier = supplier::where('ID_SUPPLIER',$request->supplier)
            ->value('NAMA');
            foreach ($data as $item) {
                $data = DB::table('dtlinvorder')
                ->whereIn('BUKTI', function ($query) use ($request) {
                    $query->select('BUKTI')
                        ->from('trninvorder')
                        ->where('NOMORPO', $request->nomorpo);
                })
                ->whereIn('PERIODE', function ($query) use ($request) {
                    $query->select('PERIODE')
                        ->from('trninvorder')
                        ->where('NOMORPO', $request->nomorpo);
                })
                ->where('ID_BARANG', $item[0])
                ->update(['QTYKIRIM' => DB::raw('QTYKIRIM + ' . $item[1])]);
                trnjadi::create([
                    'KDTRN' => '01',
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'ID_GUDANG' => $request->gudang,
                    'PERIODE' => $request->periode,
                    'ID_BARANG' => $item[0],
                    'QTY' => $item[1],
                    'ID_DEPO' => getIdDepo(),
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime,
                    'KET01' => 'Terima dari Supplier '.$request->supplier.' - '.$namaSupplier,
                    'NOMOR' => $nomor++,
                ]);
            }
            $this->updateStatusPO($request->nomorpo);
            DB::commit();
            return response()->json(['success'=> true, 'message' => 'Data Sudah Disimpan dengan No Bukti '. $bukti, 'bukti' => $bukti], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postDetailTrnJadi(Request $request){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $data = $request->data;
            foreach ($data as $item) {
                DB::table('dtlinvorder')
                ->whereIn('BUKTI', function ($query) use ($request) {
                    $query->select('BUKTI')
                        ->from('trninvorder')
                        ->where('NOMORPO', $request->nomorpo);
                })
                ->whereIn('PERIODE', function ($query) use ($request) {
                    $query->select('PERIODE')
                        ->from('trninvorder')
                        ->where('NOMORPO', $request->nomorpo);
                })
                ->where('ID_BARANG', $item[0])
                ->update(['QTYKIRIM' => DB::raw('QTYKIRIM - ' . $item[2] . ' + ' . $item[1]),
                'USEREDIT' => getUserLoggedIn()->ID_USER,
                'TGLEDIT' => $currentDateTime]);
                trnjadi::where('KDTRN', '01')
                    ->where('BUKTI', $request->bukti)
                    ->where('PERIODE', $request->periode)
                    ->where('ID_BARANG', $item[0])
                    ->update([
                        'QTY' => $item[1],
                        'USEREDIT' => getUserLoggedIn()->ID_USER,
                        'TGLEDIT' => $currentDateTime,
                    ]);

                $this->updateStatusPO($request->nomorpo);
            }
            DB::commit();
            return response()->json(['success'=>true,'message' => 'Update successful']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message' => 'Error occurred while updating data'], 500);
        }
    }

    public function getTrnSales(){
        $trnsales = trnsales::with("supplier")
        ->where('KDTRN', '01')
        ->where('ID_DEPO',getIdDepo())
        ->orderBy("TANGGAL", "desc")
        ->limit(50)
        ->get();
        return response()->json($trnsales);
    }

    public function destroy($bukti, $periode){
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $trnsales = trnsales::where("KDTRN","01")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->select("trnsales.NOMORPO")
                ->get()
                ->toArray();
            $trnjadi = trnjadi::where("KDTRN", "01")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->select("trnjadi.ID_BARANG", "trnjadi.QTY")
                ->get()
                ->toArray();
            foreach($trnjadi as $item){
                $nomorpo = $trnsales[0]['NOMORPO'];
                DB::table('dtlinvorder')
                ->whereIn('BUKTI', function ($query) use ($nomorpo) {
                    $query->select('BUKTI')
                        ->from('trninvorder')
                        ->where('NOMORPO', $nomorpo);
                })
                ->whereIn('PERIODE', function ($query) use ($nomorpo) {
                    $query->select('PERIODE')
                        ->from('trninvorder')
                        ->where('NOMORPO', $nomorpo);
                })
                ->where('ID_BARANG', $item['ID_BARANG'])
                ->update(['QTYKIRIM' => DB::raw('QTYKIRIM - ' . $item['QTY']),
                'USEREDIT' => getUserLoggedIn()->ID_USER,
                'TGLEDIT' => $currentDateTime]);
            }
            $this->updateStatusPO($trnsales[0]['NOMORPO']);
            trnsales::where("KDTRN", "01")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();
            trnjadi::where("KDTRN", "01")
                ->where("BUKTI", $bukti)
                ->where("PERIODE", $periode)
                ->delete();


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Records deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error occurred while deleting records'], 500);
        }
    }

}
