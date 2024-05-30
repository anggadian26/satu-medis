<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me',[AuthController::class, 'me']);
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('read', [ArtikelController::class, 'read']);
    Route::get('show/{id}', [ArtikelController::class, 'show']);
    Route::post('create', [ArtikelController::class, 'create']);
    Route::put('update/{id}', [ArtikelController::class, 'update']);
    Route::delete('delete/{id}', [ArtikelController::class, 'delete']);
    Route::get('artikel/search', [ArtikelController::class, 'search']);
});
