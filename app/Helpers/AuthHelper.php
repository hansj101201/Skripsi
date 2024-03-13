<?php

use Illuminate\Support\Facades\Auth;

function isLoggedIn(){
    if (Auth::guard('web')->check()) {
        return true;
    } else {
        return false;
    }
}

function getUserLoggedIn(){
    if (isLoggedIn() == false){
        return false;
    } else {
        return Auth::guard('web')->user();
    }
}

function getNamaDepo(){
    if (isLoggedIn() == false){
        return false;
    } else {
        if (Auth::guard('web')->user()->depo) {
            return Auth::guard('web')->user()->depo->NAMA;
        } else {
            return '';
        }
    }
}

function getIdDepo(){
    if (isLoggedIn() == false){
        return false;
    } else {
        if (Auth::guard('web')->user()->depo) {
            return Auth::guard('web')->user()->depo->ID_DEPO;
        } else {
            return '';
        }
    }
}

