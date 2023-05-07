<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::resource('/staff', \App\Http\Controllers\StaffController::class)->middleware('isLogin');
Route::resource('/buyer', \App\Http\Controllers\BuyerController::class)->middleware('isLogin');
Route::resource('/item', \App\Http\Controllers\ItemController::class)->middleware('isLogin');
Route::post('/item/stokkurang/{id}', [\App\Http\Controllers\ItemController::class, 'stokkurang'])->middleware('isLogin')->name('item.stokkurang');
Route::resource('/sales', \App\Http\Controllers\SalesController::class)->middleware('isLogin');
Route::get('/sales/getbarang/{id}', [\App\Http\Controllers\SalesController::class, 'getbarang'])->middleware('isLogin')->name('sales.getbarang');
// Route::resource('/dashboard', \App\Http\Controllers\DashboardController::class)->middleware('isLogin');
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'chart'])->name('chart')->middleware('isLogin');
Route::resource('/laporan', \App\Http\Controllers\LaporanController::class)->middleware('isLogin');
Route::get('/laporan/penjualan/cetak/{tglawal}/{tglakhir}', [\App\Http\Controllers\LaporanController::class, 'laporanpenjualan'])->name('laporanpenjualan');
Route::get('/auth', [\App\Http\Controllers\AuthController::class, 'index'])->middleware('isTamu');
Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login'])->middleware('isTamu');
Route::get('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
