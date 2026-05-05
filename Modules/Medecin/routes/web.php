<?php

use Illuminate\Support\Facades\Route;
use Modules\Medecin\Http\Controllers\MedecinController;
use Modules\Medecin\Http\Controllers\DisponibiliteController;
use Modules\Medecin\Http\Controllers\RdvManageControlleController;





Route::middleware(['auth', 'role:medecin'])->group(function () {

    Route::get('/medecin/dashboard', [MedecinController::class, 'index'])
        ->name('medecin.dashboard');

    Route::get('/medecin/dispo', [DisponibiliteController::class, 'index'])
        ->name('medecin.dispo.index');

    Route::get('/medecin/rdv', [RdvManageControlleController::class, 'index'])
        ->name('medecin.rdv');
    Route::patch('/rdv/{id}/status', [RdvManageControlleController::class, 'updateStatus'])->name('medecin.rdv.status');

    Route::post('/medecin/dispo', [DisponibiliteController::class, 'store'])
        ->name('medecin.dispo.store');



});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('medecin', MedecinController::class)->names('medecin');
});
