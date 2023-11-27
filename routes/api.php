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
Route::get('/users/images/{filename}', [App\Http\Controllers\UserController::class, 'getImageLink']);
Route::post('/users/images/{id}', [App\Http\Controllers\UserController::class, 'updateImage']);

//CRUD MAKANANs
Route::post('/makanans', [App\Http\Controllers\MakananController::class, 'store']);
Route::get('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'find']);
Route::post('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'update']);
Route::delete('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'destroy']);
Route::get('/makanans', [App\Http\Controllers\MakananController::class, 'index']);
Route::get('/makanans/images/all', [App\Http\Controllers\MakananController::class, 'getAllImageLink']);
Route::get('/makanans/images/{filename}', [App\Http\Controllers\MakananController::class, 'getImageLink']);

