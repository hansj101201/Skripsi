<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\barang;
use App\Models\harga;
use App\Models\satuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class hargaController extends Controller
{
    public function index () {
        $harga = harga::orderBy('MULAI_BERLAKU', 'desc')->get();
        $barang = barang::where('ACTIVE',1)->orderBy('ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('barang.*','satuan.NAMA AS nama_satuan')
        ->get();
        return view('layout.setup.harga.index', compact('harga','barang'));
    }

    public function datatable(Request $request){
        $harga = harga::join('barang','harga.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->orderBy('MULAI_BERLAKU','desc')
        ->select('harga.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan');

        return DataTables::of($harga)
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#editDataModal" data-kode="'.$row->ID.'"><i class="fas fa-pencil-alt"></i></button> &nbsp;';
        })
        ->rawColumns(["action"])
        ->make(true);
    }

    public function getDetail($id){
        $harga = harga::where('harga.ID',$id)
        ->join('barang','harga.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->select('harga.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan')
        ->get();
        return response()->json($harga);
    }

    public function getHargaBarang(Request $request){
        $Tanggal = DateTime::createFromFormat('d-m-Y', $request->input('tanggal'));
        $harga = harga::where('ID_BARANG', $request->input('barang_id'))
            ->where('MULAI_BERLAKU','<=',$Tanggal)
            ->orderBy('MULAI_BERLAKU','desc')
            ->select('HARGA')
            ->first();
        $hargaValue = $harga ? $harga->HARGA : 0;
        return response()->json($hargaValue);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'MULAI_BERLAKU' => 'required',
            'ID_BARANG.*' => 'required',
            'HARGA.*' => 'required',
        ]);
        $mulai_berlaku = DateTime::createFromFormat('d-m-Y', $validatedData['MULAI_BERLAKU']);
        $mulai_berlaku->setTimezone(new DateTimeZone('Asia/Jakarta'));
        $mulai_berlaku_formatted = $mulai_berlaku->format('Y-m-d');
        $currentDateTime = date('Y-m-d H:i:s');
        $latestHarga = harga::orderBy('MULAI_BERLAKU', 'desc')->select('MULAI_BERLAKU')->first();
        if (!$latestHarga) {
            foreach ($request->ID_BARANG as $key => $value) {
                $harga = new harga();
                $harga->MULAI_BERLAKU = $mulai_berlaku_formatted;
                $harga->ID_BARANG = $validatedData['ID_BARANG'][$key];
                $harga->HARGA = str_replace(',', '', $validatedData['HARGA'][$key]);
                $harga->USERENTRY = getUserLoggedIn()->ID_USER;
                $harga->TGLENTRY = $currentDateTime;
                $harga->save();
            }
            return response()->json(['success' => true,'message' => 'Data harga berhasil disimpan.']); // Redirect to a success page or any other route
        } else {
            $mulai_formatted = date('d-m-Y', strtotime($latestHarga['MULAI_BERLAKU']));
            if ($latestHarga['MULAI_BERLAKU'] < $mulai_berlaku_formatted) {
                foreach ($request->ID_BARANG as $key => $value) {
                    $harga = new harga();
                    $harga->MULAI_BERLAKU = $mulai_berlaku_formatted;
                    $harga->ID_BARANG = $validatedData['ID_BARANG'][$key];
                    $harga->HARGA = str_replace(',', '', $validatedData['HARGA'][$key]);
                    $harga->USERENTRY = getUserLoggedIn()->ID_USER;
                    $harga->TGLENTRY = $currentDateTime;
                    $harga->save();
                }
                return response()->json(['success' => true,'message' => 'Data harga berhasil disimpan.']); // Redirect to a success page or any other route
            } else {
                return response()->json(['success' => false, 'message' => 'Tanggal harus lebih besar dari tanggal '.$mulai_formatted]);
            }
        }
    }

    public function update(Request $request)
    {

        $harga = harga::where('ID', $request['ID'])->first();

        // dd($barang);
        if ($harga) {
            $validatedData = $request->validate([
                'HARGA' => 'required',
            ]);

            $validatedData['HARGA'] = str_replace(',', '', $validatedData['HARGA']);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            // dd($validatedData);
            $harga->update($validatedData);

            // dd($barang);
            return response()->json(['success'=>true, 'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success'=>false, 'error' => 'Data tidak berhasil diperbarui'], 404);
        }
    }

    public function destroy($ID)
    {
        $harga = harga::where('ID', $ID)->first();
        if (!$harga) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        } else {
            $harga->delete();
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        }
    }
}
