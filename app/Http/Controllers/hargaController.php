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
        $harga = harga::orderBy('MULAI_BERLAKU', 'desc')->with('barang')->with('satuan')->get();
        $barang = barang::all()->where('ACTIVE',1);
        return view('layout.setup.harga.index', compact('harga','barang'));
    }

    public function datatable(Request $request){
        $harga = harga::join('barang','harga.ID_BARANG','barang.ID_BARANG')
        ->join('satuan','barang.ID_SATUAN','satuan.ID_SATUAN')
        ->distinct()
        ->orderBy('MULAI_BERLAKU','desc')
        ->select('harga.*','barang.NAMA AS nama_barang','satuan.NAMA AS nama_satuan');

        return DataTables::of($harga)
        ->addColumn('BARANG_NAMA', function ($row) {
            return $row->nama_barang;
        })
        ->addColumn("SATUAN_NAMA", function ($row) {
            return $row->nama_satuan;
        })
        ->orderColumn("SATUAN_NAMA",function($query, $order){
            $query->orderBy('ID_BARANG', $order);
        })
        ->orderColumn("BARANG_NAMA",function($query, $order){
            $query->orderBy('ID_BARANG', $order);
        })
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
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'MULAI_BERLAKU' => 'required', // Add your validation rules here
            'ID_BARANG.*' => 'required', // Validate each ID_BARANG field in the array
            'HARGA.*' => 'required', // Validate each HARGA field in the array
        ]);

        // dd($validatedData);

        $mulai_berlaku = DateTime::createFromFormat('d-m-Y', $validatedData['MULAI_BERLAKU']);

        // Mengatur zona waktu ke Asia/Jakarta
        $mulai_berlaku->setTimezone(new DateTimeZone('Asia/Jakarta'));

        // Format tanggal ke dalam format yang diinginkan
        $mulai_berlaku_formatted = $mulai_berlaku->format('Y-m-d');
        $currentDateTime = date('Y-m-d H:i:s');

        // Once validated, you can process the data and store it in your database
        // Loop through each entry in the arrays
        foreach ($request->ID_BARANG as $key => $value) {
            // Here you can save each entry to your database or perform other actions
            // For example, you can create a new Harga model instance and save it
            $harga = new harga();
            $harga->MULAI_BERLAKU = $mulai_berlaku_formatted;
            $harga->ID_BARANG = $validatedData['ID_BARANG'][$key];
            $harga->HARGA = $validatedData['HARGA'][$key];
            $harga->TGLENTRY = $currentDateTime;
            $harga->save();
        }

        // After storing the data, you can redirect the user or perform other actions
        return response()->json(['success' => true,'message' => 'Data harga berhasil disimpan.']); // Redirect to a success page or any other route
    }

    public function update(Request $request)
    {

        $harga = harga::where('ID', $request['ID'])->first();

        // dd($barang);
        if ($harga) {
            $validatedData = $request->validate([
                'ID_BARANG' => 'required',
                'HARGA' => 'required',
                'MULAI_BERLAKU' => 'required',
            ]);

            $currentDateTime = date('Y-m-d H:i:s');
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
