<?php

use App\Http\Controllers\OperationController;
use App\Http\Controllers\WalletController;
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
    return view('welcome');
});
Route::post('operation/create', [WalletController::class, 'storeoperation'])->name('operetion.store');

Route::resource('wallets', WalletController::class);

