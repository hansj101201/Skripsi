<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class depo extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'depo';
    protected $fillable = ['ID_DEPO', 'NAMA', 'LOKASI', 'ACTIVE', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function gudang()
    {
        return $this->hasMany(Gudang::class,'ID_GUDANG','ID_GUDANG');
    }
    public function salesman()
    {
        return $this->hasMany(Salesman::class,'ID_SALES','ID_SALES');
    }
}
