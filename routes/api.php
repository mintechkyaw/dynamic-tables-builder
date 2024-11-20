<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Forms\DynamicFormController;
use App\Http\Controllers\Forms\FormController;
use App\Http\Controllers\Forms\FormFieldController;
use Illuminate\Http\Request;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {});

Route::apiResource('forms', FormController::class);
Route::apiResource('form_fields', FormFieldController::class);

Route::post('forms/{form}/publish', [DynamicFormController::class, 'publish']);
