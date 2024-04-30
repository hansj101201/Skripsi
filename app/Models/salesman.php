<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class salesman extends Authenticatable
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'salesman';
    protected $fillable = ['ID_SALES', 'NAMA', 'EMAIL','PASSWORD','ID_GUDANG', 'NOMOR_HP', 'ID_DEPO', 'ACTIVE','TGLEDIT','TGLENTRY','USEREDIT','USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
    public function depo()
    {
        return $this->belongsTo(depo::class, 'ID_DEPO', 'ID_DEPO');
    }
}
