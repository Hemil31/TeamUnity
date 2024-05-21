<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboradController;
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
Route::get('/login', [AdminController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');

Route::middleware(['auth','prevent-back-history'])->group(function () {
    Route::get('/', [DashboradController::class, 'index'])->name('dashboard');
    Route::get('/excel', [DashboradController::class, 'excelDowload'])->name('excel');
    Route::resource('companies', CompaniesController::class);
    Route::resource('employee', EmployeeController::class);
    Route::put('/companies/{id}/restore', [CompaniesController::class, 'restore'])->name('companies.restore');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
});

Route::fallback(function () {
    return redirect('/');
});
