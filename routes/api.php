<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ResumeController;
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


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('resume', [ResumeController::class, 'uploadResume']);
    Route::get('resume', [ResumeController::class, 'fetch']);
    Route::post('logout', [UserController::class, 'logout']);

    // Company
    Route::post('company', [CompanyController::class, 'store']);
    Route::post('/company/{id}', [CompanyController::class, 'update']);

    // Jobs
    Route::post('job', [JobController::class, 'store']);
    Route::post('/job/{id}', [JobController::class, 'update']);
});

Route::get('jobs', [jobController::class, 'all']);
Route::get('company', [CompanyController::class, 'all']);
