<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MjknController;

Route::prefix('mjkn')->group(function () {

    Route::get('/batal-antrean', [MjknController::class, 'index'])
        ->name('mjkn.batal-mjkn.index');

    Route::post('/batal-antrean', [MjknController::class, 'batal'])
        ->name('mjkn.batal-mjkn.batal');

});