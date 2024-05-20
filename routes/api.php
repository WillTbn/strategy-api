<?php

use App\Http\Controllers\Auth\AccessTokenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('/auth')->as('auth.')->group(function () {
        Route::get('/validate', [AuthController::class, 'validateToken'])->name('validateToken');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::controller(ReportController::class)->prefix('/reports')->as('reports.')->group(function(){
        Route::get('/', 'store')->name('store');
        Route::post('/create', 'create')->name('create');
        Route::put('/', 'update')->name('update');
        Route::post('/document', 'updateDoc')->name('uploadDocument');
        Route::post('/audio', 'updateAudio')->name('uploadAudio');
        Route::post('/audio/delete', 'deleteAudio')->name('deleteAudio');
        Route::delete('/{report}', 'delete')->name('delete');
        Route::get('/{report}', 'index')->name('index');
    });
    Route::controller(UserController::class)->prefix('/users')->as('users.')->group(function(){
        Route::get('/', 'store')->name('all');
        Route::post('/create', 'create')->name('create');

    });

    Route::controller(AccessTokenController::class)->prefix('/tokens')->as('tokens.')->group(function(){
        Route::put('/{accessToken}', 'resend')->name('resend');
    });


});
Route::post('/tokens/validate', [AccessTokenController::class, 'validate'])->name('tokens.validate');
Route::post('/tokens', [AccessTokenController::class, 'checking'])->name('tokens.checking');
Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
// Route::post('/login', [Fortify::AuthenticateUser::class, 'handle']);
// Route::post('/logout', [Fortify::LogoutUser::class, 'handle']);
