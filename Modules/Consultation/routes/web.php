<?php

use Illuminate\Support\Facades\Route;
use Modules\Consultation\Http\Controllers\ConsultationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('consultations', ConsultationController::class)->names('consultation');
});
