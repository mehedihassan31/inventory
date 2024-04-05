<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\InventoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::apiResource('inventories', InventoryController::class)->middleware('auth:sanctum');

Route::post('/items/{item}/update', [ItemController::class, 'updateData']);

Route::apiResource('items', ItemController::class)->middleware('auth:sanctum');;

Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
