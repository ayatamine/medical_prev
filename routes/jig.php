<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return Inertia::render('AdminDashboard');
})->name('admin.dashboard');


/* Auto-generated users admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->parameters(["users" => "user"]);
});


/* Auto-generated permissions admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class)->parameters(["permissions" => "permission"]);
});


/* Auto-generated roles admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->parameters(["roles" => "role"]);
});


/* Auto-generated chronic-diseases admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('chronic-diseases', \App\Http\Controllers\Admin\ChronicDiseaseController::class)->parameters(["chronic-diseases" => "chronicDisease"]);
});


/* Auto-generated family-histories admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('family-histories', \App\Http\Controllers\Admin\FamilyHistoryController::class)->parameters(["family-histories" => "familyHistory"]);
});


/* Auto-generated patients admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class)->parameters(["patients" => "patient"]);
});


/* Auto-generated allergies admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('allergies', \App\Http\Controllers\Admin\AllergyController::class)->parameters(["allergies" => "allergy"]);
});


/* Auto-generated scale-questions admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('scale-questions', \App\Http\Controllers\Admin\ScaleQuestionController::class)->parameters(["scale-questions" => "scaleQuestion"]);
});


/* Auto-generated scale-answers admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('scale-answers', \App\Http\Controllers\Admin\ScaleAnswerController::class)->parameters(["scale-answers" => "scaleAnswer"]);
});


/* Auto-generated patient-scales admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('patient-scales', \App\Http\Controllers\Admin\PatientScaleController::class)->parameters(["patient-scales" => "patientScale"]);
});


/* Auto-generated scales admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('scales', \App\Http\Controllers\Admin\ScaleController::class)->parameters(["scales" => "scale"]);
});
