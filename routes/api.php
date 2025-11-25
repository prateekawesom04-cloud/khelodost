<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::post('paymentCallbackInd', [TransactionController::class,'paymentCallbackInd'])->name('paymentCallbackInd');
// Route::post('paymentCallbackBan', [TransactionController::class,'paymentCallbackBan'])->name('paymentCallbackBan');

