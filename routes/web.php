<?php

use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LetterController as AdminLetterController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ValidationController as AdminValidationController;
use App\Http\Controllers\Deputy\DashboardController as DeputyDashboardController;
use App\Http\Controllers\Deputy\ValidationController as DeputyValidationController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\EmployeeController as ManagerEmployeeController;
use App\Http\Controllers\Manager\ValidationController as ManagerValidationController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LetterController as UserLetterController;
use App\Http\Controllers\SignatureController;
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

// Global routes
Route::group(['middleware' => ['auth', 'role:manager|user|deputy']], function () {

    // Route resource
    Route::resource('/signature', SignatureController::class)->names('signature');
});

// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {

    // Dashboard 
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

    // Route resource
    Route::resource('/admin/car', AdminCarController::class)->names('admin.car');
    Route::resource('/admin/user', AdminUserController::class)->names('admin.user');
    Route::resource('/admin/letter', AdminLetterController::class)->names('admin.letter');
    Route::resource('/admin/validation', AdminValidationController::class)->names('admin.validation');
});

// User Routes
Route::group(['middleware' => ['auth', 'role:user']], function () {

    // Dashboard
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard.index');

    // Route resource
    Route::resource('/letter', UserLetterController::class)->names('user.letter');

    // Print
    Route::get('/letter/print/{id}', [UserLetterController::class, 'print'])->name('user.letter.print');
});

// Manager Routes
Route::group(['middleware' => ['auth', 'role:manager']], function () {

    // Dashboard
    Route::get('/manager', [ManagerDashboardController::class, 'index'])->name('manager.dashboard.index');

    // Route resource
    Route::resource('/manager/employee', ManagerEmployeeController::class)->names('manager.employee');
    Route::resource('/manager/validation', ManagerValidationController::class)->names('manager.validation');
});

// Deputy Routes
Route::group(['middleware' => ['auth', 'role:deputy']], function () {

    // Dashboard
    Route::get('/deputy', [DeputyDashboardController::class, 'index'])->name('deputy.dashboard.index');

    // Route resource
    Route::resource('/deputy/validation', DeputyValidationController::class)->names('deputy.validation');
});
