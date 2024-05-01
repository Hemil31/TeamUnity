<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
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
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('companies', CompaniesController::class);
Route::resource('employee', EmployeeController::class);

