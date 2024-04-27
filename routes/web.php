<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CompaniesController;
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
Route::get('/', [AdminController::class, 'index']);
Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::resource('companies', CompaniesController::class);

