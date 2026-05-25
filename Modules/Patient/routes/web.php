<?php
use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;
use Modules\Patient\Http\Controllers\RdvController;


Route::middleware(['auth', 'role:patient'])->group(function () {

    Route::get('/patient/dashboard', [PatientController::class, 'index'])
        ->name('patient.dashboard');

    Route::get('/patient/rdv', [RdvController::class, 'index'])
        ->name('rdv.index');

    Route::get('/patient/mes-rdvs', [PatientController::class, 'mesRdvs'])
        ->name('patient.mes_rdvs');

    Route::get('/patient/documents', [PatientController::class, 'documents'])
        ->name('patient.documents');

    Route::get('/patient/documents/{id}/download', [PatientController::class, 'downloadDocument'])
        ->name('patient.documents.download');

    Route::get('/patient/disponibilites', [PatientController::class, 'disponibilites'])
        ->name('patient.disponibilites');

    Route::get('/patient/messages', [PatientController::class, 'messages'])
        ->name('patient.messages');

});
