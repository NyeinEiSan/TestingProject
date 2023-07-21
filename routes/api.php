<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;

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

Route::get('productList',[RouteController::class,'productList']);
Route::get('categoryList',[RouteController::class,'categoryList']);
Route::get('userList',[RouteController::class,'userList']);
Route::get('cartList',[RouteController::class,'cartList']);
Route::get('orderList',[RouteController::class,'orderList']);
Route::get('contactList',[RouteController::class,'contactList']);

Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[RouteController::class,'contactCreate']);

Route::post('deleteCategory',[RouteController::class,'deleteCategory']);
Route::get('categoryList/{id}',[RouteController::class,'categoryDetails']);
Route::post('categoryUpdate',[RouteController::class,'categoryUpdate']);
