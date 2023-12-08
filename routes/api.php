<?php

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


Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/users/{id}', [App\Http\Controllers\UserController::class, 'show']);
Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update']);
Route::put('/users/pass/{email}', [App\Http\Controllers\UserController::class, 'updatePassword']);
Route::put('/users/restaurant/{id}', [App\Http\Controllers\UserController::class, 'updateRestoran']);
Route::get('/users/images/{filename}', [App\Http\Controllers\UserController::class, 'getImageLink']);
Route::post('/users/images/{id}', [App\Http\Controllers\UserController::class, 'updateImage']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);

Route::post('/restaurants', [App\Http\Controllers\RestaurantController::class, 'store']);
Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [App\Http\Controllers\RestaurantController::class, 'show']);

Route::post('/items', [App\Http\Controllers\ItemController::class, 'store']);
Route::get('/items', [App\Http\Controllers\ItemController::class, 'index']);
Route::get('/items/{typename}', [App\Http\Controllers\ItemController::class, 'show']);
Route::get('/items/images/all', [App\Http\Controllers\ItemController::class, 'getAllImageLink']);
Route::get('/items/images/{filename}', [App\Http\Controllers\ItemController::class, 'getImageLink']);

Route::post('/voucher', [App\Http\Controllers\VoucherController::class, 'store']);
Route::get('/voucher', [App\Http\Controllers\VoucherController::class, 'index']);

Route::post('/subscription', [App\Http\Controllers\SubscriptionController::class, 'store']);
Route::get('/subscription', [App\Http\Controllers\SubscriptionController::class, 'index']);

Route::post('/subscription_user', [App\Http\Controllers\SubscriptionUserController::class, 'store']);
Route::get('/subscription_user', [App\Http\Controllers\SubscriptionUserController::class, 'index']);
Route::get('/subscription_user/{id}', [App\Http\Controllers\SubscriptionUserController::class, 'show']);
Route::put('/subscription_user/{id}', [App\Http\Controllers\SubscriptionUserController::class, 'update']);
Route::delete('/subscription_user/{id}', [App\Http\Controllers\SubscriptionUserController::class, 'destroy']);

Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store']);
Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index']);
Route::get('/transactions/success', [App\Http\Controllers\TransactionController::class, 'successOnly']);
Route::get('/transactions/{id}', [App\Http\Controllers\TransactionController::class, 'show']);
Route::put('/transactions/{id}', [App\Http\Controllers\TransactionController::class, 'update']);
Route::put('/transactions/voucher/{id}', [App\Http\Controllers\TransactionController::class, 'updateVoucher']);
Route::put('/transactions/status/{id}', [App\Http\Controllers\TransactionController::class, 'updateStatus']);

Route::post('/ratings', [App\Http\Controllers\RatingController::class, 'store']);
Route::get('/ratings', [App\Http\Controllers\RatingController::class, 'index']);
Route::get('/ratings/{id}', [App\Http\Controllers\RatingController::class, 'show']);
Route::put('/ratings/{id}', [App\Http\Controllers\RatingController::class, 'update']);
Route::delete('/ratings/{id}', [App\Http\Controllers\RatingController::class, 'destroy']);


Route::post('/type_items', [App\Http\Controllers\TypeItemController::class, 'store']);
Route::get('/type_items', [App\Http\Controllers\TypeItemController::class, 'index']);

Route::post('/detail_transactions', [App\Http\Controllers\DetailTransaksiController::class, 'store']);
Route::get('/detail_transactions', [App\Http\Controllers\DetailTransaksiController::class, 'index']);
Route::get('/detail_transactions/{id}', [App\Http\Controllers\DetailTransaksiController::class, 'show']);



//CRUD MAKANANs
// Route::post('/makanans', [App\Http\Controllers\MakananController::class, 'store']);
// Route::get('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'find']);
// Route::post('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'update']);
// Route::put('/makanans/noImage/{id}', [App\Http\Controllers\MakananController::class, 'updateNoImage']);
// Route::delete('/makanans/{id}', [App\Http\Controllers\MakananController::class, 'destroy']);
// Route::get('/makanans', [App\Http\Controllers\MakananController::class, 'index']);
// Route::get('/makanans/images/all', [App\Http\Controllers\MakananController::class, 'getAllImageLink']);
// Route::get('/makanans/images/{filename}', [App\Http\Controllers\MakananController::class, 'getImageLink']);
