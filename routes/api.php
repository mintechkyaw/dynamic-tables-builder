<?php

use App\Http\Controllers\AccessControl\PermissionController;
use App\Http\Controllers\AccessControl\RoleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Forms\DynamicFormController;
use App\Http\Controllers\Forms\FormController;
use App\Http\Controllers\Forms\FormFieldController;
use App\Http\Controllers\Stats\StatsController;
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

/*Authentication Routes*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    /*User Profile Routes*/
    Route::get('/user', [AuthController::class, 'authUserInfo']);
    Route::put('/user', [AuthController::class, 'updateUserInfo']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/forms/{form}/export', [DynamicFormController::class, 'exportToExcel']);

    /*Forms and form fields Routes*/
    Route::apiResource('forms', FormController::class);
    Route::apiResource('form_fields', FormFieldController::class);

    /*Dynamic Form Routes*/
    Route::post('forms/{form}/publish', [DynamicFormController::class, 'publish']);
    Route::post('forms/{form}/submit', [DynamicFormController::class, 'insertDataIntoDynamicTable']);
    Route::get('/forms/{form}/data', [DynamicFormController::class, 'getDataFromDynamicTable']);

    /*Users Routes*/
    Route::apiResource('users', UserController::class);

    /*Access Control Routes*/
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class)->only(['index', 'show']);

    /* Stats Routes */
});

Route::get('/stats', [StatsController::class, 'index']);
