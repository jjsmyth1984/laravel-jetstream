<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::get('/products/{user_id}', 'userIndex');
    Route::post('/products/create', 'createProduct');
    Route::put('/products/{id}', 'update');
    Route::delete('/products/{id}', 'delete');
});
