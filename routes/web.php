<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
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

Auth::routes();

// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {

    // Dashboard 
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
});

// User Routes
Route::group(['middleware' => ['auth', 'role:user']], function() {

    // Dashboard
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard.index');
});