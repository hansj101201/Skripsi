<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'barang';
    protected $fillable = ['ID_BARANG', 'NAMA', 'NAMASINGKAT', 'ID_SATUAN', 'MIN_STOK', 'ACTIVE','TGLEDIT','TGLENTRY','USEREDIT','USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function satuan(){
        return $this->hasOne(satuan::class,'ID_SATUAN','ID_SATUAN');
    }
}
