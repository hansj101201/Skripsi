@extends('adminlte::page')

@section('content_header')
    <h1>Selamat Datang {{ auth()->user()->NAMA }}, {{ auth()->user()->role->ROLE_NAMA }}</h1>
@endsection

@section('content')
<div class="row">
    <div class="col m-4" id="kotakKiriAtas" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Barang</h3>
    </div>
    <div class="col m-4" id="kotakKananAtas" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Customer</h3>
    </div>
</div>
<div class="row">
    <div class="col m-4" id="kotakKiriBawah" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Penjualan per Salesman</h3>
    </div>
    <div class="col m-4" id="kotakKananBawah" style="min-height: 250px; background-color: #85FCC3;">
        <h3>Stok Barang</h3>
    </div>
</div>



@endsection
