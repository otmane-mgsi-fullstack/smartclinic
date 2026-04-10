<?php

use Illuminate\Support\Facades\Route;
use Modules\Facturation\Http\Controllers\FacturationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('facturations', FacturationController::class)->names('facturation');
});
