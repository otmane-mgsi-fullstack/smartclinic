<?php

use Illuminate\Support\Facades\Route;
use Modules\Rdv\Http\Controllers\RdvController;


Route::middleware(['web'])
    ->group(function () {
        Route::get('/rdv', [RdvController::class, 'index'])->name('rdv.index');
    });
