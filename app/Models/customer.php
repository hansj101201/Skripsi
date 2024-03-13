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
    protected $fillable = ['ID_CUSTOMER', 'NAMA', 'NAMACUST', 'ALAMAT', 'KOTA', 'KODEPOS', 'NEGARA', 'NAMAUP', 'ACTIVE', 'BAGIAN',
    'CRDLIMIT', 'TERMKREDIT', 'TERMBULAN', 'TERMHARI', 'REKENING', 'PERWAKILAN', 'ID_SALES', 'NPWP', 'ALAMAT_KIRIM',
    'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];
}
