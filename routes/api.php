<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ReportTemplateController;
use App\Http\Controllers\WhiteLabelSettingsController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::get('account-active', [AuthController::class, 'accountActive']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::get('plans', [PlanController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [AuthController::class, 'logOut']);
        Route::post('profile-update', [AuthController::class, 'profileUpdate']);
        Route::post('report-template', [ReportTemplateController::class, 'create']);
        Route::apiResources([
            'white-label-settings' => WhiteLabelSettingsController::class,
        ]);
    });
});
