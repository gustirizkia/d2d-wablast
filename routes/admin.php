<?php

use App\Http\Controllers\Admin\AdministatorController;
use App\Http\Controllers\Admin\AdminRelawanController;
use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\CalonController;
use App\Http\Controllers\Admin\DapilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KuisionerKecamatanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\QuickCountController;
use App\Http\Controllers\Admin\RealCountController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RespondenController;
use App\Http\Controllers\Admin\SaksiController;
use App\Http\Controllers\Admin\SkipLogikController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\WaController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('exportDataSoal', [BankSoalController::class, 'exportDataSoal'])->name("exportDataSoal");
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
        Route::get('relawan-data/getStatistik', [AdminRelawanController::class, 'getStatistik'])->name('relawan-getStatistik');
        Route::resource('user', UserController::class);
        Route::resource('responden', RespondenController::class);
        Route::get('responden-data/statistik', [RespondenController::class, 'statistik'])->name('responden-statistik');
        Route::get('report', [ReportController::class, 'index'])->name("report");

        Route::resource('bank-soal', BankSoalController::class);

        Route::get('bank-soal/tambah-skiplogik/{soal_id}', [SkipLogikController::class, 'tambahData'])->name("tambahData-skip");
        Route::get('bank-soal/new-tambah-skiplogik/{soal_id}', [SkipLogikController::class, 'newTambahData'])->name("new-tambahData-skip");
        Route::get('bank-soal/editSkipSoal/{soal_id}/{skip_id}', [SkipLogikController::class, 'editSkipSoal'])->name("editSkipSoal");
        Route::post('bank-soal/storePilihanSkip', [SkipLogikController::class, 'storePilihanSkip'])->name("storePilihanSkip");
        Route::get('bank-soal/skiplogik/{soal_id}', [SkipLogikController::class, 'index'])->name("skiplogik");
        Route::get('bank-soal/storeData-skiplogik', [SkipLogikController::class, 'storeData'])->name("storeData-skip");

        Route::resource('kuisioner-kecamatan', KuisionerKecamatanController::class);
    });
    Route::get('responden/export', [RespondenController::class, 'export'])->name('responden-export');
    Route::get('responden/exportAll', [RespondenController::class, 'exportAll'])->name('responden-exportAll');
    Route::get('responden/exportDetail/{id}', [RespondenController::class, 'exportDetail'])->name('responden-exportDetail');

    Route::name('real-count.')->prefix('real-count')->group(function(){
        Route::get('quick-qount', [QuickCountController::class, 'index'])->name("quick-qount");

        Route::resource('/dapil', DapilController::class);
        Route::resource('saksi', SaksiController::class);
        Route::get('saksi-getSurveyor', [SaksiController::class, 'getSurveyor'])->name('getSurveyor');
    });


    Route::resource('administator', AdministatorController::class);

    // statistik
    Route::name("statistik.")->prefix('statistik')->group(function(){
        Route::get('soal', [StatistikController::class, 'soal'])->name("soal");
    });

    Route::resource('wa', WaController::class);

});

Route::post('getSoal', [WaController::class, "getSoal"])->name("getSoal");
Route::post('getJawaban', [WaController::class, "getJawaban"])->name("getJawaban");

Route::get("getKecamatanById/{kecamatan_id}", [BankSoalController::class, 'getKecamatanById'])->name("getKecamatanById");

