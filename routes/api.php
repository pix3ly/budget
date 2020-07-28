<?php

use App\Http\Controllers\API\AuthenticateController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Http\Request;

Route::post('/authenticate', AuthenticateController::class);

Route::get('/transactions', [TransactionController::class, 'index']);
