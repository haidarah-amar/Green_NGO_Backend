<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KpiSummaryController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SuccessStoryController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API works'
    ]);
});
Route::prefix('auth')->controller(UserController::class)->group(function () {

    // Public routes
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/users', 'index');
   
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/me', 'getUserProfile');
        Route::post('/update_profile', 'updateProfile');
        
    });

Route::prefix('beneficiaries')
    ->controller(BeneficiaryController::class)
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{beneficiary}', 'show');
        Route::post('/{beneficiary}', 'update');
        Route::delete('/{beneficiary}', 'destroy');

    });
});


Route::prefix('donors')
    ->controller(DonorController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/partners/top', 'getPartners');

        
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'store');
            Route::post('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
            Route::get('/my-profile', 'myProfile');
        });

    });



    Route::middleware('auth:sanctum')
    ->prefix('employees')
    ->controller(EmployeeController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

    });


    Route::prefix('projects')
    ->controller(ProjectController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');

        
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'store');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

    });
    Route::prefix('programs')
    ->controller(ProgramController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');

        
        // Route::middleware('auth:sanctum')->group(function () {
        //     Route::post('/', 'store');
        //     Route::patch('/{id}', 'update');
        //     Route::delete('/{id}', 'destroy');
        // });

    });
    Route::prefix('SuccessStories')
    ->controller(SuccessStoryController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');

        
        // Route::middleware('auth:sanctum')->group(function () {
        //     Route::post('/', 'store');
        //     Route::patch('/{id}', 'update');
        //     Route::delete('/{id}', 'destroy');
        // });

    });

    Route::prefix('KpiSummaries')
    ->controller(KpiSummaryController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');

        
        // Route::middleware('auth:sanctum')->group(function () {
        //     Route::post('/', 'store');
        //     Route::patch('/{id}', 'update');
        //     Route::delete('/{id}', 'destroy');
        // });

    });

    

