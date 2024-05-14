<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\depo;
use App\Models\dtlinvorder;
use App\Models\supplier;
use App\Models\trninvorder;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class pembelianController extends Controller
{
    //

    public function index()
    {
        $barang = barang::where('ACTIVE', 1)->get();

        $tglClosing = DB::table('closing')
            ->where('ID_DEPO', getIdDepo())
            ->orderBy('TGL_CLOSING', 'desc')
            ->value('TGL_CLOSING');

        $tglClosing = $tglClosing ?? "a";
        return view('layout.transaksi.pembelian.index', compact('barang', 'tglClosing'));
    }

    public function datatable()
    {
        $tglClosing = DB::table('closing')
            ->where('ID_DEPO', getIdDepo())
            ->orderBy('TGL_CLOSING', 'desc')
            ->value('TGL_CLOSING');

        $trninvorder = trninvorder::join('supplier', 'trninvorder.ID_SUPPLIER', 'supplier.ID_SUPPLIER')
            ->select('trninvorder.*', 'supplier.NAMA AS nama_supplier');
        return DataTables::of($trninvorder)
            ->addColumn('action', function ($row) use ($tglClosing) {
                if ($row->TANGGAL <= $tglClosing) {
                    $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-kode="detail" data-bukti="' . $row->BUKTI . '" data-periode="' . $row->PERIODE . '"><span class="fas fa-eye"></span></button> &nbsp';
                } else {
                    if ($row->STATUS == 1 || $row->STATUS == 2) {
                        $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-kode="detail" data-bukti="' . $row->BUKTI . '" data-periode="' . $row->PERIODE . '"><span class="fas fa-eye"></span></button> &nbsp';
                    } else {
                        $actionButtons = '<button class="btn btn-primary btn-sm view-detail" id="view-detail" data-toggle="modal" data-target="#addDataModal" data-mode="viewDetail" data-kode="edit" data-bukti="' . $row->BUKTI . '" data-periode="' . $row->PERIODE . '"><span class="fas fa-pencil-alt"></span></span></button> &nbsp;
                <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-bukti="' . $row->BUKTI . '" data-periode="' . $row->PERIODE . '"><i class="fas fa-trash"></i></button>';
                    }
                }
                return $actionButtons;
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function getData($bukti, $periode)
    {
        $data = trninvorder::where('PERIODE', $periode)
            ->where('BUKTI', $bukti)
            ->first();
        return response()->json($data);
    }

    public function getDetail($bukti, $periode)
    {
        $data = dtlinvorder::where('PERIODE', $periode)
            ->where('BUKTI', $bukti)
            ->join('barang', 'dtlinvorder.ID_BARANG', 'barang.ID_BARANG')
            ->join('satuan', 'barang.ID_SATUAN', 'satuan.ID_SATUAN')
            ->select('dtlinvorder.*', 'barang.NAMA AS nama_barang', 'satuan.NAMA AS nama_satuan')
            ->orderBy('NOMOR', 'asc')
            ->get();
        return response()->json($data);
    }

    public function generateBukti($tanggal)
    {
        $Tanggal = DateTime::createFromFormat('d-m-Y', $tanggal);
        $topBukti = trninvorder::select('BUKTI')
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

    public function generateNOPO($bukti, $periode)
    {
        return $bukti . '-' . $periode;
    }

    public function postPembelian(Request $request)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $tglClosing = DB::table('closing')
                ->where('ID_DEPO', $request->depo)
                ->orderBy('TGL_CLOSING', 'desc')
                ->value('TGL_CLOSING');

            $bukti = $this->generateBukti($request->tanggal);
            $nomorpo = $this->generateNOPO($bukti, $request->periode);
            $Tanggal = DateTime::createFromFormat('d-m-Y', $request->tanggal);
            $Tanggal->setTimezone(new DateTimeZone('Asia/Jakarta'));
            $tanggalFormatted = $Tanggal->format('Y-m-d');

            if ($tanggalFormatted > $tglClosing) {
                $data = $request->data;
                $nomor = 1;
                trninvorder::create([
                    'TANGGAL' => $tanggalFormatted,
                    'BUKTI' => $bukti,
                    'PERIODE' => $request->periode,
                    'ID_SUPPLIER' => $request->supplier,
                    'ID_DEPO' => $request->depo,
                    'NOMORPO' => $nomorpo,
                    'DISCOUNT' => $request->diskon,
                    'PEMBELIAN' => $request->jumlah,
                    'NETTO' => $request->netto,
                    'KETERANGAN' => $request->keterangan,
                    'USERENTRY' => getUserLoggedIn()->ID_USER,
                    'TGLENTRY' => $currentDateTime
                ]);
                foreach ($data as $item) {
                    dtlinvorder::create([
                        'TANGGAL' => $tanggalFormatted,
                        'BUKTI' => $bukti,
                        'PERIODE' => $request->periode,
                        'ID_BARANG' => $item[0],
                        'QTYORDER' => $item[1],
                        'HARGA' => $item[2],
                        'DISCOUNT' => $item[3],
                        'JUMLAH' => $item[4],
                        'USERENTRY' => getUserLoggedIn()->ID_USER,
                        'TGLENTRY' => $currentDateTime,
                        'NOMOR' => $nomor++,
                    ]);
                }
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Data Sudah Disimpan dengan No Bukti ' . $bukti, 'bukti' => $bukti], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Tanggal sudah closing']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postDetailPembelian(Request $request)
    {

        $idDepo = trninvorder::where('BUKTI', $request->bukti)
            ->where('PERIODE', $request->periode)
            ->value('ID_DEPO');
        $tglClosing = DB::table('closing')
            ->where('ID_DEPO', $idDepo)
            ->orderBy('TGL_CLOSING', 'desc')
            ->value('TGL_CLOSING');

        $tanggal = trninvorder::where('BUKTI', $request->bukti)
            ->where('PERIODE', $request->periode)
            ->value('TANGGAL');

        if ($tanggal > $tglClosing) {
            $currentDateTime = date('Y-m-d H:i:s');
            DB::beginTransaction();
            try {
                $data = $request->data;
                trninvorder::where('BUKTI', $request->bukti)
                    ->where('PERIODE', $request->periode)
                    ->update([
                        'DISCOUNT' => $request->diskon,
                        'PEMBELIAN' => $request->jumlah,
                        'NETTO' => $request->netto,
                        'KETERANGAN' => $request->keterangan,
                        'USEREDIT' => getUserLoggedIn()->ID_USER,
                        'TGLEDIT' => $currentDateTime
                    ]);
                foreach ($data as $item) {
                    dtlinvorder::where('BUKTI', $request->bukti)
                        ->where('PERIODE', $request->periode)
                        ->where('ID_BARANG', $item[0])
                        ->update([
                            'QTYORDER' => $item[1],
                            'HARGA' => $item[2],
                            'DISCOUNT' => $item[3],
                            'JUMLAH' => $item[4],
                            'USEREDIT' => getUserLoggedIn()->ID_USER,
                            'TGLEDIT' => $currentDateTime
                        ]);
                }
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Update Data Berhasil']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Error occurred while updating data'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Tanggal sudah diclosing']);
        }
    }

    public function destroy($bukti, $periode)
    {
        $tglClosing = DB::table('closing')
            ->where('ID_DEPO', getIdDepo())
            ->orderBy('TGL_CLOSING', 'desc')
            ->value('TGL_CLOSING');

        $tanggal = trninvorder::where("BUKTI", $bukti)
            ->where("PERIODE", $periode)
            ->value('TANGGAL');

        if ($tanggal > $tglClosing) {
            DB::beginTransaction();
            try {
                trninvorder::where("BUKTI", $bukti)
                    ->where("PERIODE", $periode)
                    ->delete();
                dtlinvorder::where("BUKTI", $bukti)
                    ->where("PERIODE", $periode)
                    ->delete();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Error occurred while deleting records'], 500);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Tanggal sudah diclosing']);
        }
    }

    public function getSupplierAll()
    {
        $supplier = supplier::orderBy('ID_SUPPLIER')->orderBy('NAMA')->get();
        return response()->json($supplier);
    }

    public function getSupplierActive()
    {
        $supplier = supplier::where('ACTIVE', 1)->orderBy('ID_SUPPLIER')->orderBy('NAMA')->get();
        return response()->json($supplier);
    }
}
