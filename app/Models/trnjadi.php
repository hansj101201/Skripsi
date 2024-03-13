<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trnjadi extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'trnjadi';

    protected $fillable = ['KDTRN', 'BUKTI', 'PERIODE', 'TANGGAL','ID_BARANG','ID_GUDANG','ID_DEPO', 'ID_SATUAN', 'KURS', 'QTY', 'RETUR', 'BONUS','HARGA', 'POTONGAN', 'JUMLAH', 'NOMOR','KETERANGAN', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function barang(){
        return $this->belongsTo(barang::class,'ID_BARANG','ID_BARANG');
    }

    public function satuan(){
        return $this->belongsTo(satuan::class,'ID_SATUAN','ID_SATUAN');
    }
}
