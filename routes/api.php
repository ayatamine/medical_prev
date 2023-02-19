<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* Auto-generated users api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::post('/users/{user}/assign-role', [\App\Http\Controllers\API\UserController::class,'assignRole'])->name('users.assign-role');
    Route::get('/users/dt', [\App\Http\Controllers\API\UserController::class,'dt'])->name('users.dt');
    Route::apiResource('/users', \App\Http\Controllers\API\UserController::class)->parameters(["users" => "user"]);
});


/* Auto-generated permissions api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/permissions/dt', [\App\Http\Controllers\API\PermissionController::class,'dt'])->name('permissions.dt');
    Route::apiResource('/permissions', \App\Http\Controllers\API\PermissionController::class)->parameters(["permissions" => "permission"]);
});


/* Auto-generated roles api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::post('/roles/{role}/assign-permission', [\App\Http\Controllers\API\RoleController::class,'assignPermission'])->name('roles.assign-permission');
    Route::get('/roles/dt', [\App\Http\Controllers\API\RoleController::class,'dt'])->name('roles.dt');
    Route::apiResource('/roles', \App\Http\Controllers\API\RoleController::class)->parameters(["roles" => "role"]);
});


/* Auto-generated chronic-diseases api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/chronic-diseases/dt', [\App\Http\Controllers\API\ChronicDiseaseController::class,'dt'])->name('chronic-diseases.dt');
    Route::apiResource('/chronic-diseases', \App\Http\Controllers\API\ChronicDiseaseController::class)->parameters(["chronic-diseases" => "chronicDisease"]);
});


/* Auto-generated family-histories api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/family-histories/dt', [\App\Http\Controllers\API\FamilyHistoryController::class,'dt'])->name('family-histories.dt');
    Route::apiResource('/family-histories', \App\Http\Controllers\API\FamilyHistoryController::class)->parameters(["family-histories" => "familyHistory"]);
});


/* Auto-generated patients api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/patients/dt', [\App\Http\Controllers\API\PatientController::class,'dt'])->name('patients.dt');
    Route::apiResource('/patients', \App\Http\Controllers\API\PatientController::class)->parameters(["patients" => "patient"]);
});


/* Auto-generated allergies api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/allergies/dt', [\App\Http\Controllers\API\AllergyController::class,'dt'])->name('allergies.dt');
    Route::apiResource('/allergies', \App\Http\Controllers\API\AllergyController::class)->parameters(["allergies" => "allergy"]);
});


/* Auto-generated patients api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/patients/dt', [\App\Http\Controllers\API\PatientController::class,'dt'])->name('patients.dt');
    Route::apiResource('/patients', \App\Http\Controllers\API\PatientController::class)->parameters(["patients" => "patient"]);
});


/* Auto-generated scale-questions api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/scale-questions/dt', [\App\Http\Controllers\API\ScaleQuestionController::class,'dt'])->name('scale-questions.dt');
    Route::apiResource('/scale-questions', \App\Http\Controllers\API\ScaleQuestionController::class)->parameters(["scale-questions" => "scaleQuestion"]);
});


/* Auto-generated scale-answers api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/scale-answers/dt', [\App\Http\Controllers\API\ScaleAnswerController::class,'dt'])->name('scale-answers.dt');
    Route::apiResource('/scale-answers', \App\Http\Controllers\API\ScaleAnswerController::class)->parameters(["scale-answers" => "scaleAnswer"]);
});


/* Auto-generated patient-scales api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/patient-scales/dt', [\App\Http\Controllers\API\PatientScaleController::class,'dt'])->name('patient-scales.dt');
    Route::apiResource('/patient-scales', \App\Http\Controllers\API\PatientScaleController::class)->parameters(["patient-scales" => "patientScale"]);
});


/* Auto-generated scales api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/scales/dt', [\App\Http\Controllers\API\ScaleController::class,'dt'])->name('scales.dt');
    Route::apiResource('/scales', \App\Http\Controllers\API\ScaleController::class)->parameters(["scales" => "scale"]);
});
