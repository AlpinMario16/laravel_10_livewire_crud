<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Products\Products;
use App\Livewire\Kategoris\Kategoris;
use App\Livewire\Transaksi\TransaksiForm;
use App\Livewire\Transaksi\LaporanTransaksi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {

    return view('welcome');

});
Route::get('/product', Products::class)->name("products");
Route::get('/kategoris', Kategoris::class)->name("kategoris");
Route::get('/transaksi', TransaksiForm::class)->name("transaksi-form");
Route::get('/laporan-transaksi', LaporanTransaksi::class)->name("laporan.transaksi");


Route::get('/products', Products::class);
