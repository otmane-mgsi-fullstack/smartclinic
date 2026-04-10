<?php

use Illuminate\Support\Facades\Route;
use Modules\Rdv\Http\Controllers\RdvController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('rdvs', RdvController::class)->names('rdv');
});
