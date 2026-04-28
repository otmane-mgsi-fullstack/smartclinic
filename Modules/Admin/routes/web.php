<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\MedecinController; //  Admin
use Modules\Admin\Http\Controllers\PatientController; //  Admin


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('admin/medecin', MedecinController::class)
        ->names('admin.medecin');

    Route::resource('admin/patient', PatientController::class)
        ->names('admin.patient');

})->middleware(['auth', 'role:admin']);;
