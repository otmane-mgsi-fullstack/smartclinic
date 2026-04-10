<?php

use Illuminate\Support\Facades\Route;
use Modules\Medecin\Http\Controllers\MedecinController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('medecin', MedecinController::class)->names('medecin');
});
