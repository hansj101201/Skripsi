<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class users extends Authenticatable
{
    use HasFactory;

    use HasUuids;
    protected $table = "user";
    protected $primaryKey = "ID";
    public $incrementing = false;
    public $timestamps = false;

    protected $appends = ['rolenya', 'name'];

    protected $fillable = [
        'ID_USER',
        'NAMA',
        'NOMOR_HP',
        'EMAIL',
        'PASSWORD',
        'ROLE_ID',
        'ACTIVE',
        'ID_DEPO',
        'TGLENTRY',
        'USERENTRY',
        'TGLEDIT',
        'USEREDIT',
    ];

    public function getRolenyaAttribute()
    {
        if ($this->Role) {
            return $this->Role->ROLE_NAMA;
        } else {
            return 'No Role Assigned'; // Or any default value you prefer
        }

    }
    public function getNameAttribute()
    {
        return $this->NAMA;
    }

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];
    public function depo()
    {
        return $this->belongsTo(depo::class, 'ID_DEPO', 'ID_DEPO');
    }

    public function Role()
    {
        return $this->hasOne(role::class, 'ROLE_ID', 'ROLE_ID');
    }

    public function adminlte_desc()
    {
        return $this->NAMA;
    }
}
