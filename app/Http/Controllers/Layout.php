<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Layout extends Controller
{
    //

    public function index (){
        return View('layout.dashboard');
    }

    public function home(){
        return View('layout.home');
    }
}
