<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\QuestionController;

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


Route::post('login', [UsersController::class, 'login'])->name('api_login');
Route::post('register', [UsersController::class, 'register'])->name('api_register');
Route::middleware(['auth:api'])->group(function () {
    
    Route::apiResources(['user' => UsersController::class]);


    /** QuestionController::class */
    Route::apiResources(['question' => QuestionController::class]);
    Route::get('destroyAll', [QuestionController::class, 'destroyAll']);

    /** Controller::class */
    Route::get('createCategorie', [Controller::class, 'createCategorie']);
    Route::get('createRole', [Controller::class, 'createRole']);
    Route::get('createSuperUser/{id}', [Controller::class, 'createSuperUser']);

    Route::get('getAllDiagnostic', [Controller::class, 'getAllDiagnostic']);
    Route::get('getDiagnostic/{id}', [Controller::class, 'getDiagnostic']);
    Route::get('createDiagnostic', [Controller::class, 'createDiagnostic']);
    Route::delete('destroyDiagnostic/{id}', [Controller::class, 'destroyDiagnostic']);

    Route::post('createReponse', [Controller::class, 'createReponse']);


    
});