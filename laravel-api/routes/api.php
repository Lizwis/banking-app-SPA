<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAcountsController;

use App\Http\Controllers\AccountTransactionController;



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



Route::group(['prefix' => 'user/accounts'], function () {
    Route::get('/list', [UserAcountsController::class, 'index']);
    Route::get('/show/{account_id}', [UserAcountsController::class, 'show']);
});

Route::group(['prefix' => '/account/transactions'], function () {
    Route::get('/list/{account_id}', [AccountTransactionController::class, 'index']);
    Route::post('/store', [AccountTransactionController::class, 'store']);
});
