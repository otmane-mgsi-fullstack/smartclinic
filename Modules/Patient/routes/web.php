<?php
use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth', 'role:patient'])->group(function () {

Route::get('/patient/dashboard', [PatientController::class, 'index'])
->name('patient.dashboard');

});
