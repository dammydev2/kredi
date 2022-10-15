<?php

use App\Http\Controllers\API\AuthController;
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

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/addpost', [AuthController::class, 'addPost']);

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'maker-checker'], function () {
        Route::get('', [AuthController::class, 'modifications'])->name('list');
        Route::post('approve/{maker_checker_id}', [AuthController::class, 'approve']);
        Route::post('disapprove/{maker_checker_id}', [AuthController::class, 'disapprove']);
    });
});
