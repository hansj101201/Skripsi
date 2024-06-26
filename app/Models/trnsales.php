<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trnsales extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'trnsales';

    protected $fillable = ['KDTRN', 'BUKTI', 'PERIODE', 'TANGGAL','ID_CUSTOMER','ID_SUPPLIER','ID_SALESMAN','ID_DRIVER','ID_DEPO', 'ID_GUDANG', 'ID_GUDANG_TUJUAN', 'NOPERMINTAAN','NETTO','JTHTEMPO','NOMORPO', 'DISCOUNT', 'JUMLAH', 'KETERANGAN', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function supplier(){
        return $this->hasOne(supplier::class,'ID_SUPPLIER','ID_SUPPLIER');
    }
}
