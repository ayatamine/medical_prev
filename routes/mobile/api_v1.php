<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'api_v1.'], function () {
    Route::get('/chronic-diseases', [\App\Http\Controllers\API\Mobile\V1\ChronicDiseasesController::class,'index']);
    Route::get('/family-histories', [\App\Http\Controllers\API\Mobile\V1\FamilyHistoryController::class,'index']);
    Route::post('/patients/store', [\App\Http\Controllers\API\Mobile\V1\ChronicDiseasesController::class,'store']);

    Route::controller(\App\Http\Controllers\API\Mobile\V1\Auth\PatientController::class)->prefix('patients')->group(function(){
        Route::post('otp/send', 'sendOtp');
        Route::post('otp/verify', 'loginWithOtp');
        Route::post('complete-medical-record', 'storePatientData');
    });
    
});
//'auth:sanctum', 'type.customer'
