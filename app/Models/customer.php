<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'customer';
    protected $fillable = ['ID_CUSTOMER', 'NAMA', 'EMAIL', 'ALAMAT', 'KOTA', 'KODEPOS','TELEPON', 'PIC', 'NOMOR_HP', 'ALAMAT_KIRIM', 'KOTA_KIRIM', 'KODEPOS_KIRIM','TELEPON_KIRIM', 'PIC_KIRIM', 'NOMOR_HP_KIRIM', 'ACTIVE', 'ID_SALES','TITIK_GPS',
    'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];
}
