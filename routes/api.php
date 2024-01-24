<?php

use App\Http\Controllers\Api\CategoryAdminController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SettingController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/', function () {
    return 1 ;
});



Route::get('/settings', [SettingController::class , 'index'])->middleware('auth:sanctum');
Route::get('/nav-categories', [CategoryController::class , 'navbarcategories']);
Route::get('/index-page-categories', [CategoryController::class , 'indexPageCategoriesWithPost']);


Route::post('/login',[LoginController::class , 'login']);
Route::POST('/logout',[LoginController::class , 'logout'])->middleware('auth:sanctum');

Route::apiResource('categoryadmin', CategoryAdminController::class)->except('index', 'show')->middleware('auth:sanctum');

