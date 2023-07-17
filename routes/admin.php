<?php

use App\Http\Controllers\Admin\AdminRelawanController;
use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\CalonController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\QuickCountController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RespondenController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index']);
    Route::resource('bank-soal', BankSoalController::class);
    Route::post('filter', [BankSoalController::class, 'filter'])->name("filter");

    Route::resource('lokasi', LokasiController::class);
    Route::get('detailSoal/{soal_id}', [LokasiController::class, "detailSoal"])->name("detailSoal");

    Route::resource("calon-legislatif", CalonController::class);
    Route::get("calon-legislatif-soal/{id}", [CalonController::class, 'bankSoalCalon'])->name("bankSoalCalon");
    Route::get("getSoal/{calon}", [CalonController::class, 'getSoal'])->name("getSoal");
    Route::get("deleteHasSoal/{id}", [CalonController::class, 'deleteHasSoal'])->name("deleteHasSoal");
    Route::post('insertSoalCalon', [CalonController::class, 'insertSoalCalon'])->name("insertSoalCalon");

    Route::name('data.')->prefix('data')->group(function(){
        Route::resource('relawan', AdminRelawanController::class);
        Route::resource('user', UserController::class);
        Route::resource('responden', RespondenController::class);
        Route::get('report', [ReportController::class, 'index']);
    });
    Route::get('responden/export', [RespondenController::class, 'export'])->name('responden-export');

    Route::get('quick-qount', [QuickCountController::class, 'index'])->name("quick-qount");

});
