<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController as ProductControllerAlias;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/auth/register', [AuthController::class, 'newUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/logout', [AuthController::class, 'logOut']);



Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/auth/logout', [AuthController::class, 'logOut']);
    Route::post('/cart/addToCart', [CartController::class, 'addToCart']);
    Route::post('/cart/delete', [CartController::class, 'removeCart']);
});



Route::post('/product/import', [ProductControllerAlias::class, 'import']);
