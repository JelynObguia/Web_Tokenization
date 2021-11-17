<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\SeafoodController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [UsersController::class, 'login']);
Route::post('register', [UsersController::class, 'register']);

// SEAFOOD
Route::get('get-all-seafood', [SeafoodController::class, 'getAllseafoodresto']);
Route::get('get-seafood', [SeafoodController::class, 'getseafoodrestos']);
Route::get('search-seafood', [SeafoodController::class, 'searchseafoodrestos']);