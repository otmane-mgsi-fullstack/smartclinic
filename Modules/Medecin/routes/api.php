<?php

use Illuminate\Support\Facades\Route;
use Modules\Medecin\Http\Controllers\MedecinController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('medecins', MedecinController::class)->names('medecin');
});
