<?php

use App\Http\Controllers\AeroportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlyController;
use App\Http\Controllers\PisteController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\ReservationController;

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

Route::prefix('auth')->group( function () {
  Route::post('login', [AuthController::class, 'login']);
  Route::post('register', [AuthController::class, 'register']);
  Route::post('reset-password', [AuthController::class, 'resetpassword']);
  Route::post('update-password', [AuthController::class,'changePassword']);
  Route::post('delete-user/{id}', [AuthController::class, 'delete']);

  Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
  });
});

Route::prefix('user')->group(function() {
  Route::get('get-all', [UserController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [UserController::class, 'getById']);
});

Route::prefix('aeroport')->group(function () {
  Route::get('get-all', [AeroportController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [AeroportController::class, 'getById']);
  Route::post('create', [AeroportController::class, 'create']);
  Route::put('update/{id}', [AeroportController::class, 'update']);
  Route::delete('delete/{id}', [AeroportController::class, 'delete']);
});

Route::prefix('flies')->group(function () {
  Route::get('get-all', [FlyController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [FlyController::class, 'getById']);
  Route::post('create', [FlyController::class, 'create']);
  Route::put('update/{id}', [FlyController::class, 'update']);
  Route::delete('delete/{id}', [FlyController::class, 'delete']);
});

Route::prefix('piste')->group(function () {
  Route::get('get-all', [PisteController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [PisteController::class, 'getById']);
  Route::get('get-by-airport/{id}', [PisteController::class, 'getByAirport']);
  Route::post('create', [PisteController::class, 'create']);
  Route::put('update/{id}', [PisteController::class, 'update']);
  Route::delete('delete/{id}', [PisteController::class, 'delete']);
});

Route::prefix('plane')->group(function () {
  Route::get('get-all', [PlaneController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [PlaneController::class, 'getById']);
  Route::get('get-by-airport/{id}', [PlaneController::class, 'getByAirport']);
  Route::post('create', [PlaneController::class, 'create']);
  Route::put('update/{id}', [PlaneController::class, 'update']);
  Route::delete('delete/{id}', [PlaneController::class, 'delete']);
});

Route::prefix('reservation')->group(function () {
  Route::get('get-all', [ReservationController::class, 'getAll']);  
  Route::get('get-by-id/{id}', [ReservationController::class, 'getById']);
  Route::get('get-by-user/{id}', [ReservationController::class, 'getByUser']);
  Route::get('get-by-flight/{id}', [ReservationController::class, 'getByFlight']);
  Route::post('create', [ReservationController::class, 'create']);
  Route::put('update/{id}', [ReservationController::class, 'update']);
  Route::delete('delete/{id}', [ReservationController::class, 'delete']);
});

