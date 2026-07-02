<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthRMController;
use App\Http\Controllers\UserRMController;

Route::get('/login', [AuthRMController::class, 'showLogin'])->name('rm.login');
Route::post('/login', [AuthRMController::class, 'login'])->name('rm.login.post');

Route::middleware('cekloginrm')->group(function () {
    Route::post('/logout', [AuthRMController::class, 'logout'])->name('rm.logout');
    Route::post('/profile/password/update', [AuthRMController::class, 'updatePassword'])
    ->name('profile.password.update');

    Route::prefix('user-rm')->name('userrm.')->group(function () {
        Route::get('/', [UserRMController::class, 'index'])->name('index');
        Route::post('/store', [UserRMController::class, 'store'])->name('store');
        Route::put('/update/{id}', [UserRMController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserRMController::class, 'destroy'])->name('destroy');
    });
});