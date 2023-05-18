<?php

use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\EmployeeController as ManagerEmployeeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\SignatureController as UserSignatureController;
use Illuminate\Support\Facades\Auth;
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

    // Route resource
    Route::resource('/admin/car', AdminCarController::class)->names('admin.car');
    Route::resource('/admin/user', AdminUserController::class)->names('admin.user');
});

// User Routes
Route::group(['middleware' => ['auth', 'role:user']], function() {

    // Dashboard
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard.index');

    // Route resource
    Route::resource('/signature', UserSignatureController::class)->names('user.signature');
});

// Manager Routes
Route::group(['middleware' => ['auth', 'role:manager']], function() {

    // Dashboard
    Route::get('/manager', [ManagerDashboardController::class, 'index'])->name('manager.dashboard.index');

    // Route resource
    Route::resource('/manager/employee', ManagerEmployeeController::class)->names('manager.employee');
});