<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\UserAccountAmountController;
use App\Http\Controllers\Api\V1\FineController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;
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

Route::post('auth/register', RegisterController::class);
Route::post('auth/login', LoginController::class);
Route::get('zones', [ZoneController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::put('replenish', [UserAccountAmountController::class, 'update']);
    Route::put('password', PasswordUpdateController::class);
    Route::post('auth/logout', LogoutController::class);

    Route::apiResource('vehicles', VehicleController::class);

    Route::post('parkings', [ParkingController::class, 'store']);
    Route::put('parkings/{parking}', [ParkingController::class, 'update'])->whereNumber('parking');
    Route::get('parkings/{parking}', [ParkingController::class, 'show'])->whereNumber('parking');

    Route::post('fines', [FineController::class, 'store']);
});
