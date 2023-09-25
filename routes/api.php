<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthControllers;
use App\Http\Controllers\API\UserControllers;
use App\Http\Controllers\API\ProductControllers;
use App\Http\Controllers\API\CategoryControllers;
use App\Http\Controllers\API\FavoriteControllers;
use App\Http\Controllers\API\HistoryControllers;
use App\Http\Controllers\API\CarouselControllers;
use App\Http\Controllers\API\CartControllers;
use App\Http\Controllers\API\TransactionControllers;
use App\Http\Controllers\API\ReviewControllers;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// <!--AUTH--!>

Route::prefix('auth')->group(function () {
    Route::post('/login',[AuthControllers::class, 'login']);
    Route::post('/logout', [AuthControllers::class, 'logout']);
    Route::get('/me', [AuthControllers::class, 'getUserByToken']);
    Route::get('/salam', [AuthControllers::class, 'salam']);
    Route::post('/register', [AuthControllers::class, 'register']);
});

// <!--USER--!>

Route::prefix('user')->group(function () {
    Route::post('/edit-profile',[UserControllers::class, 'edit']);
    Route::post('/edit-password',[UserControllers::class, 'editPassword']);
    Route::post('/edit-password/{token}',[UserControllers::class, 'editPasswordToken']);
    Route::post('/forgot-password',[UserControllers::class, 'forgotPassword']);
});

// <!--PRODUCT---!>

Route::prefix('product')->group(function () {
    Route::post('/create',[ProductControllers::class, 'create']);
    Route::get('/',[ProductControllers::class, 'index']);
    Route::get('/byreview',[ProductControllers::class, 'byreview']);
    Route::get('/{uuid}',[ProductControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[ProductControllers::class, 'edit']);
    Route::delete('/delete/{uuid}',[ProductControllers::class,'delete']);
});

// <!--CAROUSEL---!>

Route::prefix('carousel')->group(function () {
    Route::post('/create', [CarouselControllers::class, 'create']);
    Route::get('/', [CarouselControllers::class, 'index']);
    Route::get('/{uuid}',[CarouselControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CarouselControllers::class, 'edit'])->name('edit_carousel');
    Route::delete('/delete/{uuid}', [CarouselControllers::class, 'delete'])->name('delete_carousel');
});

// <!--CATEGORY---!>

Route::prefix('category')->group(function () {
    Route::post('/create', [CategoryControllers::class, 'create']);
    Route::get('/', [CategoryControllers::class, 'read']);
    Route::get('/{uuid}',[CategoryControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[CategoryControllers::class, 'edit'])->name('edit_category');
    Route::delete('/delete/{uuid}', [CategoryControllers::class, 'delete'])->name('delete_category');
});

// <!--TRANSACTION---!>

Route::prefix('transaction')->group(function () {
    Route::post('/single', [TransactionControllers::class, 'transaksi']);
    Route::post('/cart', [TransactionControllers::class, 'transaksi_keranjang']);
});

// <!--REVIEW---!>
Route::prefix('review')->group(function () {
    Route::post('/create', [ReviewControllers::class, 'create']);
    Route::get('/', [ReviewControllers::class, 'index']);
    Route::get('/{uuid}',[ReviewControllers::class, 'byId']);
    Route::post('/edit/{uuid}',[ReviewControllers::class, 'edit'])->name('edit_review');
    Route::delete('/delete/{uuid}', [ReviewControllers::class, 'delete'])->name('delete_review');
});

//<!--FAVORITE---!>
Route::prefix('favorite')->group(function () {
    Route::get('/', [FavoriteControllers::class, 'index']);
    Route::post('/create',[FavoriteControllers::class, 'create']);
    Route::delete('/delete/{uuid}',[FavoriteControllers::class, 'delete']);
});

//<!--CART---!>
Route::prefix('cart')->group(function () {
    Route::get('/', [CartControllers::class, 'read']);
    Route::post('/add',[CartControllers::class, 'create']);
    Route::post('/edit/{uuid}',[CartControllers::class, 'edit']);
    Route::delete('/delete/{uuid}',[CartControllers::class, 'delete']);
});


//<!--HISTORY---!>
Route::prefix('history')->group(function () {
    Route::get('/',[HistoryControllers::class, 'index']);
    Route::delete('/delete/{uuid}',[HistoryControllers::class,'delete']);
});