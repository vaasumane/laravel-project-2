<?php

use App\Http\Controllers\EmployeeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'employee'], function () {
        Route::group(['middleware' => ['project.auth']], function () {
            Route::post('/get-employee', [EmployeeController::class, 'GetEmployee']);
            Route::post('/add-employee', [EmployeeController::class, 'CreateEmployee']);
            Route::post('/edit-employee', [EmployeeController::class, 'UpdateEmployee']);
            Route::post('/delete-employee', [EmployeeController::class, 'DeleteEmployee']);
        });
    });
});
