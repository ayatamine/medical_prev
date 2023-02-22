<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'api_v1.'], function () {
    Route::get('/chronic-diseases', [\App\Http\Controllers\API\Mobile\V1\ChronicDiseasesController::class,'index']);
    Route::get('/family-histories', [\App\Http\Controllers\API\Mobile\V1\FamilyHistoryController::class,'index']);
    Route::post('/patients/store', [\App\Http\Controllers\API\Mobile\V1\ChronicDiseasesController::class,'store']);
    Route::get('/ads', [\App\Http\Controllers\API\Mobile\V1\AdsController::class,'index']);

    Route::controller(\App\Http\Controllers\API\Mobile\V1\Auth\PatientController::class)->prefix('patients')->group(function(){
        Route::post('otp/send', 'sendOtp');
        Route::post('otp/verify', 'loginWithOtp');
        Route::group(['middleware'=>'auth:sanctum'],function(){
            Route::post('complete-medical-record', 'storePatientData');
            Route::put('/{id}/update-phone-number', 'updatePhone');
            Route::post('/{id}/update-thumbnail', 'updateThumbnail');
            Route::delete('/{id}', 'deletePatientAccount');
            Route::post('/{id}/logout', 'logout');
            Route::put('/{id}/notifications-status/{status}', 'switchNotificationsStataus');

            //patient scales
            Route::get('/{id}/scales', 'getPatientScales');
            // recommendation with age and sex filtered base on the patient
            Route::get('/recommendations','recommendations');
            Route::get('/recommendations/{id}','recommendationDetails');
        });
    });
    Route::controller(\App\Http\Controllers\API\Mobile\V1\ScaleController::class)->prefix('scales')->group(function(){
        Route::get('', 'index');
    });
    
});
//'auth:sanctum', 'type.customer'
