<?php
use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;
use Modules\Patient\Http\Controllers\RdvController;


Route::middleware(['auth', 'role:patient'])->group(function () {

Route::get('/patient/rdv', [RdvController::class, 'index'])
->name('rdv.index');

});
