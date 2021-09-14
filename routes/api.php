<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CatalogController;

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

Route::group(['prefix' => 'order'], function() {
    Route::get('/', [OrderController::class, 'all']);
    Route::get('{order}', [OrderController::class, 'one']);
    Route::put('{order}', [OrderController::class, 'update']);
    Route::delete('{order}', [OrderController::class, 'delete']);
});

Route::group(['prefix' => 'product'], function() {
    Route::get('/', [ProductController::class, 'all']);
    Route::get('{product}', [ProductController::class, 'one']);
    Route::put('{product}', [ProductController::class, 'update']);
    Route::delete('{product}', [ProductController::class, 'delete']);
});

Route::group(['prefix' => 'catalog'], function() {
    Route::get('/', [CatalogController::class, 'all']);
    Route::get('{catalog}', [CatalogController::class, 'one']);
    Route::put('{catalog}', [CatalogController::class, 'update']);
    Route::delete('{catalog}', [CatalogController::class, 'delete']);
});