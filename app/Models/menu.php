<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;


    protected $table        = "menu";
    protected $primaryKey   = "menu_id";
    public $incrementing    = true;
    public $timestamps      = true;

    protected $fillable = [
        'MENU_GROUP',
        'MENU_SUBGROUP',
        'MENU_SUBMENU',
        'MENU_URUTAN',
        'MENU_ICON',
    ];
}
