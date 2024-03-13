<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dtlinvorder extends Model
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'dtlinvorder';
    protected $fillable = ['BUKTI', 'PERIODE', 'TANGGAL','ID_BARANG', 'ID_SATUAN', 'QTYORDER', 'QTYKIRIM', 'HARGA', 'DISCOUNT', 'JUMLAH', 'NOMOR', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(barang::class, 'ID_BARANG', 'ID_BARANG');
    }

    public function satuan()
    {
        return $this->belongsTo(satuan::class, 'ID_SATUAN', 'ID_SATUAN');
    }

    public function trninvorder()
    {
        return $this->belongsTo(trninvorder::class, 'BUKTI', 'BUKTI')
            ->whereColumn('dtlinvorder.PERIODE', 'trninvorder.PERIODE');
    }
}
