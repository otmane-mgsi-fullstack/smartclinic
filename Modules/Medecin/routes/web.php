<?php

use Illuminate\Support\Facades\Route;
use Modules\Medecin\Http\Controllers\MedecinController;
use Modules\Medecin\Http\Controllers\DisponibiliteController;





Route::middleware(['auth', 'role:medecin'])->group(function () {

    Route::get('/medecin/dashboard', [MedecinController::class, 'index'])
        ->name('medecin.dashboard');

    Route::get('/medecin/dispo', [DisponibiliteController::class, 'index'])
        ->name('medecin.dispo');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('medecin', MedecinController::class)->names('medecin');
});
