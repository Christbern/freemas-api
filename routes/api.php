<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClientController,
    SiteController,
    QualificationController,
    EmployeeController,
    AttendanceController,
    PayrollSheetController,
    AuthController
};

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // secure existing resources
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('sites', SiteController::class);
    Route::apiResource('qualifications', QualificationController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('attendances', AttendanceController::class)->except(['update']);
    Route::get('payroll-sheets', [PayrollSheetController::class, 'index']);
    Route::post('payroll-sheets/generate', [PayrollSheetController::class, 'generate']);
    Route::get('payroll-sheets/{payrollSheet}', [PayrollSheetController::class, 'show']);
});
