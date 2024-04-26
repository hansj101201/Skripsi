<?php

use App\Http\Controllers\barangController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\gudangController;
use App\Http\Controllers\laporanSalesController;
use App\Http\Controllers\pdfController;
use App\Http\Controllers\pengembalianController;
use App\Http\Controllers\penjualanCanvasController;
use App\Http\Controllers\permintaanController;
use App\Http\Controllers\salesmanController;
use App\Http\Controllers\stkjadiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('barang')->group(function(){
    Route::controller(barangController::class)->group(function(){
        Route::get('getAllBarang', 'getAllBarang');
    });
});

Route::prefix('salesman')->group(function(){
    Route::controller(salesmanController::class)->group(function(){
        Route::post('login','doLogin');
        Route::get('cekEmail','cekEmail');
        Route::put('resetPassword','resetPassword');
    });
});

Route::prefix('permintaan')->group(function(){
    Route::controller(permintaanController::class)->group(function(){
        Route::post('postPermintaan','postPermintaan');
    });
});

Route::prefix('pengembalian')->group(function(){
    Route::controller(pengembalianController::class)->group(function(){
        Route::post('postPengembalian','postPengembalian');
    });
});

Route::prefix('stock')->group(function(){
    Route::controller(stkjadiController::class)->group(function(){
        Route::get('getStockSales','getStockSales');
        Route::get('getStockPenjualan', 'getStockPenjualan');
    });
});

Route::prefix('gudang')->group(function(){
    Route::controller(gudangController::class)->group(function(){
        Route::get('getListGudang','getListGudang');
    });
});

Route::prefix('customer')->group(function(){
    Route::controller(customerController::class)->group(function(){
        Route::get('getCustomer','getCustomer');
    });
});

Route::prefix('penjualan')->group(function(){
    Route::controller(penjualanCanvasController::class)->group(function(){
        Route::post('postPenjualanCanvas','postPenjualanCanvas');
        Route::get('getTanggalClosing', 'getTanggalClosing');
    });
});

Route::prefix('laporanSales')->group(function(){
    Route::controller(laporanSalesController::class)->group(function(){
        Route::get('getPermintaan', 'getPermintaan');
        Route::get('getPenerimaan', 'getPenerimaan');
        Route::get('getPengembalian', 'getPengembalian');
    });
});

Route::prefix('pdf')->group(function(){
    Route::controller(pdfController::class)->group(function(){
        Route::get('generatePdf','generatePdf');
    });
});
