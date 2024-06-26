<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/get_products', [ProductController::class, 'index']);
Route::get('/get_product/{pid}', [ProductController::class, 'show']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/add_products', [ProductController::class, 'store']);
    Route::post('/new_order', [OrderController::class, 'store']);
    Route::get('/logout', [UserController::class, 'logout']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
