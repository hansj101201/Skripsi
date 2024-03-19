@extends('adminlte::page')

@section('content_header')
    <h1>Selamat Datang {{ auth()->user()->NAMA }}, {{ auth()->user()->role->ROLE_NAMA }}</h1>
@endsection

@section('content')
    <h2>ini adalah dashboard</h2>
@endsection
