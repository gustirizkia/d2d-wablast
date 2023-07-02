<?php

use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function(){
    Route::get('/', function(){
        return redirect()->route('admin.bank-soal.index');
    });
    Route::resource('bank-soal', BankSoalController::class);
    Route::resource('user', UserController::class);
});
