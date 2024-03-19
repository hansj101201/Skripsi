<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;


    protected $table        = "menu";
    protected $primaryKey   = "MENU_ID";
    public $incrementing    = true;
    public $timestamps      = true;

    protected $fillable = [
        'MENU_GROUP',
        'MENU_SUBGROUP',
        'MENU_SUBMENU',
        'MENU_URUTAN',
        'MENU_ICON',
    ];

    public function Roles()
    {
        return $this->belongsToMany(role::class, 'role_menu', 'MENU_ID', 'ROLE_ID');
    }
}
