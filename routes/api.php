<?php

use App\Http\Controllers\AccessControl\PermissionController;
use App\Http\Controllers\AccessControl\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Forms\DynamicFormController;
use App\Http\Controllers\Forms\FormController;
use App\Http\Controllers\Forms\FormFieldController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Auth routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'authUserInfo']);
    Route::get('/forms/{form}/data', [DynamicFormController::class, 'getDataFromDynamicTable']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/forms/{form}/export', [DynamicFormController::class, 'exportToExcel']);

    Route::apiResource('forms', FormController::class);
    Route::apiResource('form_fields', FormFieldController::class);
    Route::post('forms/{form}/publish', [DynamicFormController::class, 'publish']);
    Route::post('forms/{form}/submit', [DynamicFormController::class, 'insertDataIntoDynamicTable']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class)->only(['index', 'show']);
});
