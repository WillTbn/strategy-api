<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

});

Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
// Route::post('/login', [Fortify::AuthenticateUser::class, 'handle']);
// Route::post('/logout', [Fortify::LogoutUser::class, 'handle']);
