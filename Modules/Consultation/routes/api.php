<?php

use Illuminate\Support\Facades\Route;
use Modules\Consultation\Http\Controllers\ConsultationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('consultations', ConsultationController::class)->names('consultation');
});
