<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
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

Route::prefix('category')->as('category.')->group(function (){
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/store/{id?}', [CategoryController::class, 'store'])->name('store');
    Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
});
Route::prefix('product')->as('product.')->group(function (){
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::post('/store/{id?}', [ProductController::class, 'store'])->name('store');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('delete');
});
Route::prefix('image')->as('image.')->group(function (){
    Route::get('/', [ImageController::class, 'index'])->name('index');
    Route::post('/store/{id?}', [ImageController::class, 'store'])->name('store');
    Route::get('/delete/{id}', [ImageController::class, 'delete'])->name('delete');
});
