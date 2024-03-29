<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;

    protected $table        = "role";
    protected $primaryKey   = "ROLE_ID";
    public $incrementing    = true;
    public $timestamps      = true;

    public function Menus()
    {
        return $this->belongsToMany(menu::class, 'role_menu', 'ROLE_ID', 'MENU_ID');
    }
}
