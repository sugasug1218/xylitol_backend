<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// ログイン処理
Route::post('/login', [AuthController::class, 'login']);

// ログイン前ユーザーは入れない
Route::middleware('auth:api')->group(function () {
    Route::get('/test', [UserApiController::class, 'index']);
});


Route::post('/preRegister', [RegisterController::class, 'preRegister']); // 仮登録
Route::post('/authToken', [RegisterController::class, 'AuthToken']); // ワンタイムトークン認証
Route::post('/register', [RegisterController::class, 'register']); // 本登録
