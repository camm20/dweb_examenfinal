<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarcajeController;
use App\Http\Controllers\CalculoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/loginoauth', [AuthController::class, 'loginoauth']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
        
});


Route::group([
    'middleware' => ['before' => 'jwt.auth']
], function ($router) {
    Route::get('/calculo/view/{id}', [CalculoController::class, 'show']);
    Route::post('/calculo', [CalculoController::class, 'store']);
    Route::post('/marcajes', [MarcajeController::class, 'store']);
    Route::get('/marcajes/view/{id}', [MarcajeController::class, 'show']);
    //Route::apiResource('orders', OrderController::class);
});