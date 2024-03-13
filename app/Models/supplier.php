<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'supplier';
    protected $fillable = ['ID_SUPPLIER', 'NAMA', 'ALAMAT','KOTA', 'TELEPON','NPWP', 'ACTIVE', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function transaksi(){
        return $this->hasMany(trnsales::class,'ID_SUPPLIER','ID_SUPPLIER');
    }
}
