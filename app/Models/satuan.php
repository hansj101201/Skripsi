<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'satuan';
    protected $fillable = ['ID_SATUAN', 'NAMA', 'TGLEDIT','TGLENTRY','USEREDIT','USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'ID_SATUAN', 'ID_SATUAN');
    }
}
