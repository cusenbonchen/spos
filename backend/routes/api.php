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

use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']); 
Route::post('login/biometric', [AuthController::class, 'loginWithBiometric']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('users', [AuthController::class, 'userUpdate']);
    Route::get('me', [AuthController::class, 'me']);

});

