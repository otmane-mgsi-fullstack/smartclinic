<?php

use Illuminate\Support\Facades\Route;
use Modules\Rdv\Http\Controllers\RdvController;
use Modules\Rdv\Http\Controllers\RdvBookingController;


Route::middleware(['web'])
    ->group(function () {
        Route::get('/rdv', [RdvController::class, 'index'])->name('rdv.index');
        // Modules/Rdv/Routes/web.php


        Route::post('/rdv/store', [RdvBookingController::class, 'store'])->name('rdv.store');
    });
