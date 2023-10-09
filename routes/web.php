<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\UserControllers;
use App\Http\Controllers\WEB\AuthControllers;
use App\Http\Controllers\WEB\AdminControllers;
use App\Http\Controllers\WEB\MonitoringControllers;
use App\Http\Controllers\WEB\ProductControllers;
use App\Http\Controllers\WEB\CategoryControllers;
use App\Http\Controllers\WEB\CarouselControllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthControllers::class, 'logpage']);
Route::post('/login', [AuthControllers::class, 'login']);
Route::get('/logout', [AuthControllers::class, 'logout']);

Route::middleware('authname')->group(function () {
Route::get('/dashboard', [UserControllers::class, 'index']);
Route::get('/monitoring', [MonitoringControllers::class, 'monitoring']);
Route::get('/admin', [AdminControllers::class, 'index']);

Route::prefix('user')->group(function () {
    Route::post('/add-user',[UserControllers::class, 'register']);
    Route::get('/edit/{id}',[UserControllers::class, 'edituserpage']);
    Route::put('/edit-store/{id}',[UserControllers::class, 'edituser']);
    Route::get('/delete/{id}',[UserControllers::class, 'delete']);
});

Route::prefix('admin')->group(function () {
    Route::post('/add-admin',[AdminControllers::class, 'create']);
    Route::get('/edit/{id}',[AdminControllers::class, 'editadminpage']);
    Route::put('/edit-store/{id}',[AdminControllers::class, 'editadmin']);
    Route::get('/delete/{id}',[AdminControllers::class, 'delete']);
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductControllers::class, 'index']);
    Route::get('/{id}',[ProductControllers::class, 'byId']);
    Route::post('/add-catalogue',[ProductControllers::class, 'create']);
    Route::get('/edit/{id}',[ProductControllers::class, 'editpage']);
    Route::put('/edit-store/{id}',[ProductControllers::class, 'edit']);
    Route::get('/delete/{id}',[ProductControllers::class, 'delete']);
});

Route::prefix('carousel')->group(function () {
    Route::get('/', [CarouselControllers::class, 'index']);
    Route::post('/add-carousel',[CarouselControllers::class, 'create']);
    Route::get('/edit/{id}',[CarouselControllers::class, 'editpage']);
    Route::put('/edit-store/{id}',[CarouselControllers::class, 'edit']);
    Route::get('/delete/{id}',[CarouselControllers::class, 'delete']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryControllers::class, 'read']);
    Route::post('/add-category',[CategoryControllers::class, 'create']);
    Route::get('/edit/{id}',[CategoryControllers::class, 'editpage']);
    Route::put('/edit-store/{id}',[CategoryControllers::class, 'edit']);
    Route::get('/delete/{id}',[CategoryControllers::class, 'delete']);
});

Route::prefix('profile')->group(function () {
    Route::get('/admin',[AdminControllers::class, 'profileadminpage']);
    Route::put('/edit-store',[AdminControllers::class, 'editprofileadmin']);
    Route::put('/edit-photo',[AdminControllers::class, 'editphotoprofil']);
});

});