<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AccessTokenController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserBankAccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

    Route::prefix('/auth')->as('auth.')->group(function () {
        Route::get('/validate', [AuthController::class, 'validateToken'])->name('validateToken');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('/verifyemail', [AuthController::class, 'verifyEmail'])->name('verifyemail');
        Route::post('/authemail', [AuthController::class, 'authEmail'])->name('authemail');
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

    Route::controller(AccountController::class)->prefix('/account')->as('account.')->group(function (){
        Route::post('/avatar', 'avatarUpdate')->name('avatarUpdate');
        Route::post('/data', 'updateData')->name('updateData');
    });
    Route::controller(UserBankAccountController::class)->prefix('/bank')->as('bank.')->group(function (){
        Route::post('/', 'create')->name('create');
        Route::put('/', 'update')->name('update');
        Route::delete('/{bank}', 'delete')->name('delete');
    });


    Route::controller(AccessTokenController::class)->prefix('/tokens')->as('tokens.')->group(function(){
        Route::put('/{accessToken}', 'resend')->name('resend');
    });


});
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
// tokens
Route::post('/tokens/validate', [AccessTokenController::class, 'validate'])->name('tokens.validate');
Route::post('/tokens', [AccessTokenController::class, 'checking'])->name('tokens.checking');

// password
Route::controller(AuthController::class)->prefix('/password')->as('password.')->group(function(){
    Route::post('/forgot', 'forgotPassword')->name('forgot');
    Route::post('/reset', 'resetPassword')->name('reset');
});
//Register
Route::controller(RegisterController::class)->prefix('/')->as('register.')->group(function(){
    Route::post('/validator-cpf', 'verifyPersonAPI')->name('validatorcpf');
    Route::post('/validator-cep', 'verifyCep')->name('validatorcep');
    Route::post('/register', 'register')->name('client');
});
// Route::post('/validator-cpf', [RegisterController::class, 'verifyPersonAPI'])->name('validatorcpf');
// Route::post('/validator-cep', [RegisterController::class, 'verifyCep'])->name('validatorcep');
