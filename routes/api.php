<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\PaymentController;

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

Route::post('/login', [AuthController::class, 'login']);

// Route::get('/users', [UserController::class, 'index']);
// Route::put('/users/{id}', [AuthController::class, 'update']);



Route::post('admin/login', [AdminController::class, 'login']);

Route::middleware('auth:sanctum', 'abilities:admin')->group(function() {
    Route::post('admin/logout', [AdminController::class, 'logout']);
    Route::get('admin/details', [AdminController::class, 'userDetails']);
    Route::resource('cars', CarController::class)->except('index', 'show');
    Route::resource('/rents', RentController::class)->except('store', 'update');
    Route::resource('/payments', PaymentController::class)->except('store', 'update');
  });

Route::post('user/register', [UserController::class, 'register']);
// Route::post('/cars', [CarController::class, 'store']);

Route::post('user/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum', 'abilities:frontuser')->group(function() {
  Route::post('user/logout', [UserController::class, 'logout']);
  Route::get('user/details', [UserController::class, 'userDetails']);
  // Route::resource('cars', CarController::class)->except('store', 'update', 'delete');
});

Route::middleware('auth:sanctum')->group(function() {
  Route::resource('cars', CarController::class)->except('store', 'update', 'delete');
  Route::resource('/rents', RentController::class)->except('index', 'update', 'delete');
  Route::resource('/payments', PaymentController::class)->except('index', 'update', 'delete');
  // Route::get('/cars', [CarController::class, 'index']);
  // Route::get('/cars/{car}', [CarController::class, 'show']);
});