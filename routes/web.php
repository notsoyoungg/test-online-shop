<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/cart', [CartController::class, 'show'])->name('show-cart');
Route::post('/cart/add', [CartController::class, 'addProduct'])->name('add-to-cart');
Route::delete('/cart/remove', [CartController::class, 'removeProduct'])->name('remove-from-cart');
