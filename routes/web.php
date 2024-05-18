<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\hargaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Layout;
use App\Http\Controllers\barangController;
use App\Http\Controllers\gudangController;
use App\Http\Controllers\salesmanController;
use App\Http\Controllers\depoController;
use App\Http\Controllers\satuanController;
use App\Http\Controllers\supplierController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\pembelianController;
use App\Http\Controllers\penerimaanPOController;
use App\Http\Controllers\pengeluaranBarangKanvasController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\penyesuaianController;
use App\Http\Controllers\stkjadiController;
use App\Http\Controllers\transferGudangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::controller(Layout::class)->middleware(['auth'])->group(function (){
    Route::get('dashboard', 'index')->name('dashboard');
    Route::get('/','index');
    Route::get('getRole', 'getRole')->name('getRole');
});

Route::prefix('setup')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian,Admin Penjualan'])->group(function () {
    Route::prefix('barang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian,Admin Penjualan'])->group(function () {
        Route::controller(barangController::class)->group(function (){
            Route::get('index','index')->middleware(['Login:SuperAdmin'])->name('barang.index');
            Route::post('store','store')->middleware(['Login:SuperAdmin'])->name('barang.store');
            Route::put('update','update')->middleware(['Login:SuperAdmin'])->name('barang.update');
            Route::delete('/{ID}','destroy')->middleware(['Login:SuperAdmin']);
            Route::get('getDetailBarang', 'getDetailBarang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian,Admin Penjualan'])->name('getDetailBarang');
            Route::get('datatable', 'datatable')->name('barang.datatable');
            Route::get('getBarangActive', 'getBarangActive')->middleware(['Login:Admin Depo,Admin Gudang,Pembelian,Admin Penjualan']);
            Route::get('getBarangAll', 'getBarangAll')->middleware(['Login:Admin Depo,Admin Gudang,Pembelian,Admin Penjualan']);
        });
    });

    Route::prefix('gudang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Admin Penjualan'])->group(function () {
        Route::controller(gudangController::class)->group(function (){
            Route::get('index','index')->name('gudang.index');
            Route::post('store','store')->name('gudang.store');
            Route::put('update','update')->name('gudang.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable','datatable')->name('gudang.datatable');
            Route::get('getDetail/{ID}','getDetail');
            Route::get('getGudang/{ID}', 'getGudang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
            Route::get('getGudangSales/{ID}', 'getSalesGudang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
            Route::get('getGudangSalesAll', 'getSalesGudangAll')->middleware(['Login:Admin Depo,Admin Gudang']);
            Route::get('getGudangActive', 'getGudangActive')->middleware(['Login:Admin Depo,Admin Gudang,Admin Penjualan']);
            Route::get('getGudangAll', 'getGudangAll')->middleware(['Login:Admin Depo,Admin Gudang,Admin Penjualan']);
        });
    });

    Route::prefix('depo')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian'])->group(function () {
        Route::controller(depoController::class)->group(function (){
            Route::get('index','index')->middleware(['Login:SuperAdmin'])->name('depo.index');
            Route::post('store','store')->middleware(['Login:SuperAdmin'])->name('depo.store');
            Route::put('update','update')->middleware(['Login:SuperAdmin'])->name('depo.update');
            Route::delete('/{ID}','destroy')->middleware(['Login:SuperAdmin']);
            Route::get('datatable','datatable')->name('depo.datatable');
            Route::get('getDetail/{ID}','getDetail')->middleware(['Login:SuperAdmin']);
            Route::get('getDepoActive', 'getDepoActive')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian']);
            Route::get('getDepoAll', 'getDepoAll')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Pembelian']);
            Route::get('getAllDepoActive', 'getAllDepoActive')->middleware(['Login:SuperAdmin,Admin Depo']);
            Route::get('getAllDepo', 'getAllDepo')->middleware(['Login:SuperAdmin,Admin Depo']);
        });
    });

    Route::prefix('salesman')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan'])->group(function () {
        Route::controller(salesmanController::class)->group(function (){
            Route::get('index','index')->name('salesman.index');
            Route::post('store','store')->name('salesman.store');
            Route::put('update','update')->name('salesman.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable','datatable')->name('salesman.datatable');
            Route::get('getDetail/{ID}','getDetail');
        });
    });

    Route::prefix('harga')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan'])->group(function () {
        Route::controller(hargaController::class)->group(function (){
            Route::get('index','index')->middleware(['Login:SuperAdmin,Admin Depo'])->name('harga.index');
            Route::post('store','store')->middleware(['Login:SuperAdmin,Admin Depo'])->name('harga.store');
            Route::put('update','update')->middleware(['Login:SuperAdmin,Admin Depo'])->name('harga.update');
            Route::delete('/{ID}','destroy')->middleware(['Login:SuperAdmin,Admin Depo']);
            Route::get('datatable','datatable')->name('harga.datatable');
            Route::get('getDetail/{iD}','getDetail');
            Route::get('getHargaBarang', 'getHargaBarang')->middleware(['Login:Admin Depo,Admin Penjualan'])->name('getHargaBarang');
        });
    });

    Route::prefix('satuan')->middleware(['Login:SuperAdmin'])->group(function () {
        Route::controller(satuanController::class)->group(function (){
            Route::get('index','index')->name('satuan.index');
            Route::post('store','store')->name('satuan.store');
            Route::put('update','update')->name('satuan.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable', 'datatable')->name('satuan.datatable');
            Route::get('getDetail/{ID}','getDetail');
        });
    });

    Route::prefix('supplier')->middleware(['Login:SuperAdmin,Pembelian'])->group(function () {
        Route::controller(supplierController::class)->group(function (){
            Route::get('index','index')->name('supplier.index');
            Route::post('store','store')->name('supplier.store');
            Route::put('update','update')->name('supplier.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable','datatable')->name('supplier.datatable');
            Route::get('getDetail/{ID}','getDetail');
        });
    });

    Route::prefix('customer')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan'])->group(function () {
        Route::controller(customerController::class)->group(function (){
            Route::get('index','index')->name('customer.index');
            Route::post('store','store')->name('customer.store');
            Route::put('update','update')->name('customer.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable','datatable')->name('customer.datatable');
            Route::get('getDetail/{ID}','getDetail');
            Route::get('getCustomerActive', 'getCustomerActive');
            Route::get('getCustomerAll', 'getCustomerAll');
        });
    });

    Route::prefix('user')->middleware(['Login:SuperAdmin,Admin Depo'])->group(function () {
        Route::controller(AuthController::class)->group(function (){
            Route::get('index','index')->name('user.index');
            Route::post('store','register')->name('user.store');
            Route::put('update','update')->name('user.update');
            Route::delete('/{ID}','destroy');
            Route::get('datatable','datatable')->name('user.datatable');
            Route::get('getDetail/{id}','getDetail');
        });
    });
});

Route::prefix('transaksi')->middleware(['Login:Pembelian,Admin Depo,Admin Gudang,Admin Penjualan'])->group(function () {
    Route::controller(stkjadiController::class)->group(function () {
        Route::get('getSaldoBarang', 'getSaldoBarang')->name('getSaldoBarang');
    });
    Route::prefix('gudang')->middleware(['Login:Admin Depo,Admin Gudang'])->group(function (){
        Route::controller(penerimaanPOController::class)->group(function () {
            Route::get('index', 'index')->name('gudang.terimaPO');
            Route::get('fetch-data/{id}', 'fetchDataById')->where('id', '.*');
            Route::get('fetch-detail/{id}/{periode}','fetchDetailData');
            Route::get('getNomorPo', 'getNomorPo');
            Route::get('getTrnSales','getTrnSales')->name('getTrnSales');
            Route::post('postTrnJadi','postTrnJadi')->name('postTrnJadi');
            Route::get('getTrnBukti', 'fetchTopBukti')->name('getTrnBukti');
            Route::get('getDetail/{bukti}/{periode}','getDetail');
            Route::put('postDetailTrnJadi','postDetailTrnJadi')->name('postDetailTrnJadi');
            Route::delete('delete/{bukti}/{periode}','destroy');
            Route::get('datatable','datatable')->name('penerimaanpo.datatable');
        });
    });

    Route::prefix('pengeluaran')->middleware(['Login:Admin Depo,Admin Gudang'])->group(function (){
        Route::controller(pengeluaranBarangKanvasController::class)->group(function () {
            Route::get('getPermintaanActive','getPermintaanActive');
            Route::get('getPermintaanAll','getPermintaanAll');
            Route::get('index', 'index');
            Route::get('datatable', 'datatable')->name('pengeluaran.datatable');
            Route::get('fetch-data/{id}', 'fetchData')->where('id', '.*');
            Route::get('fetch-data-selesai/{id}', 'fetchDataSelesai')->where('id', '.*');
            Route::get('fetch-detail/{id}/{periode}', 'fetchDetail');
            Route::post('postTrnCanvas', 'postTrnCanvas')->name('postTrnCanvas');
            Route::put('postDetailTrnCanvas','postDetailTrnCanvas')->name('postDetailTrnCanvas');
            Route::delete('delete/{bukti}/{periode}','destroy');
        });
    });

    Route::prefix('transfergudang')->middleware(['Login:Admin Depo,Admin Gudang'])->group(function(){
        Route::controller(transferGudangController::class)->group(function () {
            Route::get('index', 'index');
            Route::get('datatable', 'datatable')->name('transfer.datatable');
            Route::get('getDetail/{bukti}/{periode}','getDetail');
            Route::get('getData/{bukti}/{periode}','getData');
            Route::post('postTransferGudang', 'postTransferGudang')->name('postTransferGudang');
            Route::put('postDetailTransferGudang', 'postDetailTransferGudang')->name('postDetailTransferGudang');
            Route::delete('delete/{bukti}/{periode}','destroy');
        });
    });

    Route::prefix('penjualan')->middleware(['Login:Admin Depo,Admin Penjualan'])->group(function(){
        Route::controller(penjualanController::class)->group(function () {
            Route::get('index', 'index');
            Route::get('datatable', 'datatable')->name('penjualan.datatable');
            Route::post('postPenjualan', 'postPenjualan')->name('postPenjualan');
            Route::get('getData/{bukti}/{periode}','getData');
            Route::get('getDetail/{bukti}/{periode}','getDetail');
            Route::delete('delete/{bukti}/{periode}','destroy');
        });
    });

    Route::prefix('pembelian')->middleware(['Login:Pembelian'])->group(function(){
        Route::controller(pembelianController::class)->group(function () {
            Route::get('index', 'index');
            Route::get('datatable', 'datatable')->name('pembelian.datatable');
            Route::post('postPembelian', 'postPembelian')->name('postPembelian');
            Route::get('getData/{bukti}/{periode}','getData');
            Route::get('getDetail/{bukti}/{periode}','getDetail');
            Route::put('postDetailPembelian', 'postDetailPembelian')->name('postDetailPembelian');
            Route::delete('delete/{bukti}/{periode}','destroy');
            Route::get('getSupplierActive', 'getSupplierActive');
            Route::get('getSupplierAll', 'getSupplierAll');
        });
    });

    Route::prefix('penyesuaian')->middleware(['Login:Admin Depo,Admin Gudang'])->group(function(){
        Route::controller(penyesuaianController::class)->group(function () {
            Route::get('index', 'index');
            Route::get('datatable', 'datatable')->name('penyesuaian.datatable');
            Route::post('postPenyesuaian', 'postPenyesuaian')->name('postPenyesuaian');
            Route::get('getData/{bukti}/{periode}','getData');
            Route::get('getDetail/{bukti}/{periode}','getDetail');
            Route::put('postDetailPenyesuaian', 'postDetailPenyesuaian')->name('postDetailPenyesuaian');
            Route::delete('delete/{bukti}/{periode}','destroy');
        });
    });
});

Route::prefix('laporan')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang,Admin Penjualan'])->group(function(){
    Route::controller(laporanController::class)->group(function () {
        Route::get('penjualan', 'penjualan')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
        Route::get('stok', 'stok')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang']);
        Route::get('getStok/{periode}/{id}','getStok')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang']);
        Route::get('getStok/{periode}/{id}/{barang}','getDetailTrn')->middleware(['Login:SuperAdmin,Admin Depo,Admin Gudang']);
        Route::get('getPenjualanCustomer/{awal}/{akhir}','getPenjualanCustomer')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
        Route::get('getPenjualanBarang/{awal}/{akhir}','getPenjualanBarang')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
        Route::get('getPenjualanSalesman/{awal}/{akhir}','getPenjualanSalesman')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
        Route::get('getDetailPenjualanCustomer/{id}/{awal}/{akhir}','getDetailPenjualanCustomer')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
        Route::get('getDetailPenjualanSalesman/{id}/{awal}/{akhir}','getDetailPenjualanSalesman')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan']);
    });
});

Route::prefix('pdf')->middleware(['Login:SuperAdmin,Admin Depo,Admin Penjualan'])->group(function(){
    Route::controller(pdfController::class)->group(function () {
        Route::get('index', 'index');
        Route::get('getStok/{periode}/{id}','getStok');
        Route::get('getPenjualanBarang/{awal}/{akhir}','getPenjualanBarang');

        Route::get('pdfCustomer/{periode}/{id}/{depo}', 'pdfCustomer');
        Route::get('pdfSalesman/{periode}/{id}/{depo}', 'pdfSalesman');
        Route::get('pdfBarang/{periode}/{id}/{depo}', 'pdfBarang');
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login','login')->name('login');
    Route::post('doLogin','doLogin')->name('user.login');
    Route::get('logout','logout')->name('logout');
});


