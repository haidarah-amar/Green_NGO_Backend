<?php

use App\Http\Controllers\ActivityController;
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
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GrantController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;

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
        Route::get('/project/{projectId}', 'ProjectPrograms');

        
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'store');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
            Route::post('/{program}/apply', [ProgramController::class, 'apply']);
        });

    });
    Route::prefix('SuccessStories')
    ->controller(SuccessStoryController::class)
    ->group(function () {

        
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/beneficiary/{beneficiaryId}', 'beneficiaryStories');

        
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', 'store');
            Route::patch('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

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

    Route::middleware('auth:sanctum')->prefix('activities')->controller(ActivityController::class)->group(function(){

    Route::get('/', 'index');
    Route::get('{id}', 'show');
    Route::get('/{program}/activities', 'programActivities');

    Route::middleware('auth:sanctum')->group(function () {
    Route::post('/', 'store');
    Route::post('{id}', 'update');
    Route::delete('{id}', 'destroy');
    Route::post('/{activity}/apply',  'apply');

     });   

    });
    
    Route::post('/import/donors', [ImportController::class, 'importDonors']);
    Route::post('/import/projects', [ImportController::class, 'importProjects']);



    Route::prefix('grants')->controller(GrantController::class)->group(function () {

    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::get('/donors/{id}','getGrantsByDonor');
    Route::get('/projects/{id}','getGrantsByProject');

    Route::middleware('auth:sanctum')->group(function () {

    Route::post('/accept',  'acceptGrant');
    Route::post('/',  'store');
    Route::post('/{id}',  'update');
    Route::delete('/{id}', 'destroy');
    

    });
    });


    Route::middleware('auth:sanctum')
    ->prefix('expenses')
    ->controller(ExpenseController::class)
    ->group(function () {

        Route::get('/program/{programId}', 'getExpensesByProgram');
        Route::get('/grant/{grantId}', 'getExpensesByGrant');
        Route::get('/employee/{employeeId}', 'getExpensesByEmployee');

        Route::get('/', 'index');
        Route::get('/{expense}', 'show');
        Route::post('/', 'store');
        Route::put('/{expense}', 'update');
        Route::delete('/{expense}', 'destroy');
    });


    
    Route::middleware('auth:sanctum')
    ->prefix('follow-ups')
    ->controller(FollowUpController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::get('/{followUp}', 'show');
        Route::post('/', 'store');
        Route::put('/{followUp}', 'update');
        Route::delete('/{followUp}', 'destroy');

    Route::get('/programs/{id}', 'getFollowUpsByProgram');
    Route::get('/beneficiaries/{id}', 'getFollowUpsByBeneficiary');
    Route::get('/employees/{id}', 'getFollowUpsByEmployee');

    });

Route::prefix('surveys')->controller(SurveyController::class)->group(function () {

    Route::get('/avg/{type}/{id}', 'getAvgRating');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'store');
        Route::patch('/{survey}', 'update');
        Route::delete('/{survey}', 'destroy');
        Route::get('/', 'index');
        Route::get('/{survey}', 'show');
        Route::get('/all/{type}/{id}', 'getAllSurveies');
    });
    
});

    Route::middleware('auth:sanctum')
    ->prefix('reports')
    ->controller(ReportController::class)
    ->group(function () {

        Route::get('/', 'index');        
        Route::post('/', 'store');       
        Route::get('{id}', 'show');      
        Route::post('{id}', 'update');  
        Route::delete('{id}', 'destroy'); 

        Route::get('employee/{employeeId}', 'getReportsByEmployee');
        Route::get('grant/{grantId}', 'getReportsByGrant');
        Route::get('project/{projectId}', 'getReportsByProject');

    });



