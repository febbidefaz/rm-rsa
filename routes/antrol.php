<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AntrolReportController;

Route::prefix('antrol')->group(function () {

    Route::get('/report', [AntrolReportController::class, 'index'])
        ->name('antrol.report.index');

    Route::get('/report/data', [AntrolReportController::class, 'data'])
        ->name('antrol.report.data');

    Route::patch('/report/task',[AntrolReportController::class, 'updateTask']
        )->name('antrol.report.task.update');

});