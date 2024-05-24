<?php

use App\Http\Controllers\DataIntegrationController;
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

Route::middleware('apiCall')->group(function () {
    Route::post('/incomes', [DataIntegrationController::class, 'incomes'])->name('integration.incomes');
});

Route::middleware('apiCall')->group(function () {
    Route::post('/orders', [DataIntegrationController::class, 'orders'])->name('integration.orders');
});

Route::middleware('apiCall')->group(function () {
    Route::post('/stocks', [DataIntegrationController::class, 'stocks'])->name('integration.stocks');
});

Route::middleware('apiCall')->group(function () {
    Route::post('/sales', [DataIntegrationController::class, 'sales'])->name('integration.sales');
});
