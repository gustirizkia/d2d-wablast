<?php

use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('bank-soal', BankSoalController::class);
Route::resource('user', UserController::class);
