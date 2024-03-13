<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'gudang';

    protected $fillable = ['ID_GUDANG', 'NAMA', 'ALAMAT', 'ID_DEPO', 'ACTIVE', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];
    public function depo()
    {
        return $this->hasOne(depo::class, 'ID_DEPO', 'ID_DEPO');
    }
}
