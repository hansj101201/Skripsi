<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\barang;
use App\Models\harga;
use App\Models\satuan;
use App\Models\trnjadi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class barangController extends Controller
{
    public function index () {
        $satuan = satuan::all();
        return view('layout.setup.barang.index', compact('satuan'));
    }

    public function datatable(){
        $barang = barang::join("satuan","barang.ID_SATUAN","satuan.ID_SATUAN")
        ->select("barang.*", "satuan.NAMA AS nama_satuan");

        return DataTables::of($barang)
        ->editColumn('ACTIVE', function ($row) {
            return $row->ACTIVE == 1 ? 'Ya' : 'Tidak'; // Kolom untuk nilai asli
        })
        ->addColumn('action', function ($row) {
            return '<button class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#DataModal" data-kode="'.$row->ID_BARANG.'" data-mode="edit"><i class="fas fa-pencil-alt"></i></button> &nbsp;
            <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteDataModal" data-kode="'.$row->ID_BARANG.'" data-jenis="barang" data-master="setup"><i class="fas fa-trash"></i></button>';
        })
        ->rawColumns(["action"])
        ->make(true);
    }
    public function getDetailBarang(Request $request) {
        $barang = Barang::where('ID_BARANG',$request->input('id_barang'))
        ->join('satuan','satuan.ID_SATUAN','barang.ID_SATUAN')
        ->select('barang.*','satuan.NAMA AS nama_satuan')
        ->first();
        return response()->json($barang);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Periksa apakah ID yang akan ditambahkan sudah ada dalam database
        // dd($request->all());
        $existingRecord = barang::where('ID_BARANG', $request['ID_BARANG'])->first();
        if (!$existingRecord) {
            $validatedData = $request->validate([
                'ID_BARANG' => 'required',
                'NAMA' => 'required',
                'NAMASINGKAT' => 'required',
                'ID_SATUAN' => 'required',
                'MIN_STOK' => 'required',
                'ACTIVE' => 'sometimes'
            ]);
            $data = $validatedData;

            $currentDateTime = date('Y-m-d H:i:s');
            $data['USERENTRY'] = getUserLoggedIn()->ID_USER;
            $data['TGLENTRY'] = $currentDateTime;
            // ID tidak ada dalam database, maka buat entitas baru
            barang::create($data);
            return response()->json(['success' => true, 'message' => 'Data Sudah Di Simpan.']);
        } else {
            // ID sudah ada dalam database, kirim respons JSON dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Data Sudah Ada.']);
        }
    }

    public function update(Request $request)
    {

        $barang = barang::where('ID_BARANG', $request['ID_BARANG'])->first();

        // dd($barang);
        if ($barang) {
            $validatedData = $request->validate([
                'ID_BARANG' => 'required',
                'NAMA' => 'required',
                'NAMASINGKAT' => 'required',
                'ID_SATUAN' => 'sometimes',
                'MIN_STOK' => 'required',
                'ACTIVE' => 'sometimes',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
            $validatedData['USEREDIT'] = getUserLoggedIn()->ID_USER;
            $validatedData['TGLEDIT'] = $currentDateTime;
            // dd($validatedData);
            $barang->update($validatedData);

            // dd($barang);
            return response()->json(['success' => true,'message' => 'Data berhasil diperbarui'], 200);
        } else {
            return response()->json(['success' => false,'error' => 'Data dengan KDJADI tersebut tidak ditemukan'], 404);
        }
    }

    public function destroy($ID_BARANG)
    {
        $trnjadiCount = trnjadi::where('ID_BARANG', $ID_BARANG)->count();
        $brgjadi = barang::where('ID_BARANG', $ID_BARANG)->first();
        if ($trnjadiCount > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus barang karena sudah digunakan dalam transaksi'], 422);
        } else if (!$brgjadi) {
            return response()->json(['success' => false,'message' => 'Data tidak ditemukan'], 404);
        } else {
            $hargaCount = harga::where('ID_BARANG', $ID_BARANG)->count();
            if ($hargaCount > 0) {
                // Delete the related harga records
                harga::where('ID_BARANG', $ID_BARANG)->delete();
            }
            $brgjadi->delete();
            return response()->json(['success' => true,'message' => 'Data berhasil dihapus'], 200);
        }
    }

    public function getBarangActive()
    {
        $barang = barang::where('ACTIVE',1)->get();
        return response($barang);
    }

    public function getBarangAll()
    {
        $barang = barang::all();
        return response($barang);
    }
}
