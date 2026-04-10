<?php

use Illuminate\Support\Facades\Route;
use Modules\Ordonnance\Http\Controllers\OrdonnanceController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('ordonnances', OrdonnanceController::class)->names('ordonnance');
});
