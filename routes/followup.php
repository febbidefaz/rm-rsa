<?php

use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\SKDPController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| SKDP
|--------------------------------------------------------------------------
*/

Route::prefix('skdp')
    ->name('skdp.')
    ->controller(SKDPController::class)
    ->group(function () {

        Route::post('/post', 'post')
            ->name('post');

        Route::post('/edit', 'edit')
            ->name('edit');

        Route::delete('/delete', 'delete')
            ->name('destroy');

        Route::get('/spesialis', 'getSpesialis')
            ->name('spesialis');

        Route::get('/dokter', 'getDokterSkdp')
            ->name('dokter');

        Route::get('/{no_skdp}/print', 'print')
            ->name('print');
    });


/*
|--------------------------------------------------------------------------
| RAWAT JALAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/rawat-jalan',
    [FollowUpController::class, 'index']
)->name('rawatjalan.index');


Route::get(
    '/rawat-jalan/data',
    [FollowUpController::class, 'data']
)->name('rawatjalan.data');


/*
|--------------------------------------------------------------------------
| SKDP AJAX
|--------------------------------------------------------------------------
*/

Route::get(
    '/rawat-jalan/skdp/data',
    [SKDPController::class, 'listData']
)->name('rawatjalan.skdp.data');


/*
|--------------------------------------------------------------------------
| SEP
|--------------------------------------------------------------------------
*/

Route::get(
    '/sep/detail',
    [FollowUpController::class, 'sepDetail']
)->name('sep.detail');


/*
|--------------------------------------------------------------------------
| LABEL
|--------------------------------------------------------------------------
*/

Route::get(
    '/label-tengah/{id}',
    [FollowUpController::class, 'printLabelTengah']
)->name('label.tengah');


Route::get(
    '/label-samping/{id}',
    [FollowUpController::class, 'printLabelSamping']
)->name('label.samping');


/*
|--------------------------------------------------------------------------
| DETAIL RAWAT JALAN
| ROUTE DINAMIS TARUH PALING BAWAH
|--------------------------------------------------------------------------
*/

Route::get(
    '/rawat-jalan/{id}',
    [FollowUpController::class, 'detail']
)->name('rawatjalan.detail');