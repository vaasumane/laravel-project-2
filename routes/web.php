<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class,'index']);
Route::post('/validate_credentials', [LoginController::class,'validate_credentials']);
Route::get('/dashboard', [DashboardController::class,'index']);
Route::get('/profile-setting',[ LoginController::class,'profile_setting']);
