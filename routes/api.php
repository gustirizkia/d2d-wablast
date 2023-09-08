<?php

use App\Http\Controllers\Api\RealCountController;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SurveyApiController;
use App\Http\Controllers\Api\SurveyController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::get("all-quiz/{id_target}", [QuizController::class, 'getAllSoal']);
Route::post("saveOne", [QuizController::class, 'saveOne']);
Route::get("detailKecamatan/{kota_id}", [SurveyApiController::class, "detailKecamatan"]);
Route::get("listDesa", [AlamatController::class, "listDesa"]);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('survey-index', [SurveyApiController::class, 'index']);
    Route::post('inputTarget', [SurveyApiController::class, 'inputTarget']);
    Route::post('selesaiQuiz', [SurveyApiController::class, 'selesaiQuiz']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getUser']);
    Route::get('real-count-get-data', [RealCountController::class, 'getData']);
    Route::post('real-count/inputSaksi', [RealCountController::class, 'inputSaksi']);
});
