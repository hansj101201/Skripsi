<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class harga extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'harga';
    protected $defaultOrder = [
        'mulai_berlaku' => 'desc', // urutkan berdasarkan tanggal terbaru
    ];
    protected $fillable = ['ID_BARANG', 'HARGA', 'ID_SATUAN', 'MULAI_BERLAKU', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
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
}
