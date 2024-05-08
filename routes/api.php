<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::prefix('/auth')->name('auth.')->middleware('auth:sanctum')->group(function () {
    Route::get('/validate', [AuthController::class, 'validateToken'])->name('validateToken');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
// Route::post('/login', [Fortify::AuthenticateUser::class, 'handle']);
// Route::post('/logout', [Fortify::LogoutUser::class, 'handle']);
