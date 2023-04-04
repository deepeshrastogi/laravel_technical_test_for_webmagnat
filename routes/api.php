<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\Attributes\AttributeController;
use App\Http\Controllers\Api\Products\ProductController;
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

Route::controller(UserAuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('signup', 'signup');
});

Route::controller(AttributeController::class)->prefix('attributes')->group(function () {
    Route::post('/', 'create');
    Route::get('/', 'attributelist');
});

Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'getProductsList');
    Route::post('/', 'create');
    Route::get('/{id}', 'getProduct');
    Route::delete('/{id}', 'delete');
});