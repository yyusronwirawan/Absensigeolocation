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
    return view('auth.login');
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    Route::resource('/agency', \App\Http\Controllers\AgencyController::class);

    Route::resource('/position', \App\Http\Controllers\PositionController::class);

    Route::resource('/employee', \App\Http\Controllers\EmployeeController::class);

    Route::resource('/role', \App\Http\Controllers\RoleAndPermissionController::class);

    Route::resource('/application', \App\Http\Controllers\ApplicationController::class);
    Route::get('/approveApplication/{application}', [\App\Http\Controllers\ApplicationController::class, 'getApprove'])->name('application.approve');
    Route::put('/approveApplication/{application}', [\App\Http\Controllers\ApplicationController::class, 'storeApprove'])->name('application.storeApprove');

    Route::resource('/attendance', \App\Http\Controllers\AttendanceController::class);
    Route::get('/attendanceCheckout/{attendance}',  [\App\Http\Controllers\AttendanceController::class, 'createCheckout'])->name('attendance.createCheckout');
    Route::post('/attendanceCheckout/{attendance}',  [\App\Http\Controllers\AttendanceController::class, 'storeCheckout'])->name('attendance.storeCheckout');
    Route::get('/attendanceAssignmentCheckin',  [\App\Http\Controllers\AttendanceController::class, 'createAssignmentCheckin'])->name('attendance.createAssignmentCheckin');
    Route::get('/attendanceAssignmentCheckout/{attendance}',  [\App\Http\Controllers\AttendanceController::class, 'createAssignmentCheckout'])->name('attendance.createAssignmentCheckout');
    Route::get('/exportAttendance',  [\App\Http\Controllers\AttendanceController::class, 'exportAttendance'])->name('attendance.exportAttendance');

    Route::get('/listPosition', [\App\Http\Controllers\PositionController::class, 'select'])->name('position.select');
    Route::get('/listAgency', [\App\Http\Controllers\AgencyController::class, 'select'])->name('agency.select');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/password/{user}', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('update.password');
    Route::put('/profile/{user}', [\App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('update.profile');
});
