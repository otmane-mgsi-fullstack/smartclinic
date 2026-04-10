<?php

use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth', 'verified'])->prefix('v1')->group(function () {
    Route::apiResource('patients', PatientController::class)->names('patient');
});
