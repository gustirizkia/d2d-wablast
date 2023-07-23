<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\SurveyController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get("relawan", [RelawanController::class, 'index']);
Route::get("getCalon", [RelawanController::class, 'getCalon']);
Route::get("successAdd", [RelawanController::class, 'successAdd']);
Route::post("addRelawan", [RelawanController::class, 'addRelawan'])->name("addRelawan");
Route::get("survey-relawan", [RelawanController::class, 'survey'])->name("survey-relawan");

Route::get('page-login', function(){
    return view("auth.login");
});


Route::get('/', [HomeController::class, 'welcome'])->name("home");
Route::middleware('auth')->group(function () {


    Route::get('/list-survey', [SurveyController::class, 'riwayat'])->name('list-survey');
    Route::get('/survey', [SurveyController::class, 'index'])->name('survey');
    Route::post('/inputDataTarget', [SurveyController::class, 'inputDataTarget'])->name('inputDataTarget');
    Route::post('/nextSoal', [SurveyController::class, 'nextSoal'])->name('nextSoal');
    Route::get('/backSoal', [SurveyController::class, 'backSoal'])->name('backSoal');
    Route::get('/quiz/{id}', [SurveyController::class, 'quiz'])->name('quiz');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
// alamat
Route::get('listKota', [AlamatController::class, 'listKota'])->name('listKota');
Route::get('listKecamatan', [AlamatController::class, 'listKecamatan'])->name('listKecamatan');
Route::get('listDesa', [AlamatController::class, 'listDesa'])->name('listDesa');

require __DIR__.'/auth.php';


Route::get('/register', function(){
    return abort(404);
});
Route::get('/login', function(){
    return view('login');
})->name('login');
