<?php

use App\Http\Controllers\MakananController;
use App\Models\User;
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

Route::apiResource('makanan', MakananController::class);

Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::put('/users/pass/{email}', [App\Http\Controllers\UserController::class, 'updatePassword']);
