<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeneficiaryController;

Route::prefix('auth')->controller(UserController::class)->group(function () {

    // Public routes
    Route::post('/register', 'register');
    Route::post('/login', 'login');

   
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'getUserProfile');
        Route::post('/update-profile', 'updateProfile');
    });

Route::prefix('beneficiaries')
    ->controller(BeneficiaryController::class)
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{beneficiary}', 'show');
        Route::patch('/{beneficiary}', 'update');
        Route::delete('/{beneficiary}', 'destroy');

    });
});
