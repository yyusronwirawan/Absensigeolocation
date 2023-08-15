<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');

//     Route::apiResource('/agency', \App\Http\Controllers\API\AgencyController::class);

//     Route::apiResource('/position', \App\Http\Controllers\API\PositionController::class);

//     Route::apiResource('/employee', \App\Http\Controllers\API\EmployeeController::class);

//     Route::apiResource('/period', \App\Http\Controllers\API\PeriodController::class);

//     Route::apiResource('/role', \App\Http\Controllers\API\RoleAndPermissionController::class);

//     Route::apiResource('/application', \App\Http\Controllers\API\ApplicationController::class);

//     Route::apiResource('/attendance', \App\Http\Controllers\API\AttendanceController::class);
// });

// Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
