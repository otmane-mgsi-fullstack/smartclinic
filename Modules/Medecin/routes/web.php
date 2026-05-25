<?php
use Illuminate\Support\Facades\Route;
use Modules\Medecin\Http\Controllers\MedecinController;
use Modules\Medecin\Http\Controllers\DisponibiliteController;
use Modules\Medecin\Http\Controllers\RdvManageControlleController;
use Modules\Medecin\Http\Controllers\PatientManageController;
use Modules\Medecin\Http\Controllers\DocumentManageController;

Route::middleware(['auth', 'role:medecin'])->group(function () {

    Route::get('/medecin/dashboard', [MedecinController::class, 'dashboard'])
        ->name('medecin.dashboard');

    Route::get('/medecin/dispo', [DisponibiliteController::class, 'index'])
        ->name('medecin.dispo.index');

    Route::get('/medecin/rdv', [RdvManageControlleController::class, 'index'])
        ->name('medecin.rdv');
    Route::patch('/rdv/{id}/status', [RdvManageControlleController::class, 'updateStatus'])->name('medecin.rdv.status');

    Route::post('/medecin/dispo', [DisponibiliteController::class, 'store'])
        ->name('medecin.dispo.store');

    // Gestion des Patients par le Médecin
    Route::resource('/medecin/patients', PatientManageController::class)->names([
        'index' => 'medecin.patients.index',
        'create' => 'medecin.patients.create',
        'store' => 'medecin.patients.store',
        'edit' => 'medecin.patients.edit',
        'update' => 'medecin.patients.update',
        'destroy' => 'medecin.patients.destroy',
    ])->except(['show']);

    // Gestion des Documents par le Médecin
    Route::get('/medecin/documents', [DocumentManageController::class, 'index'])->name('medecin.documents.index');
    Route::get('/medecin/documents/create', [DocumentManageController::class, 'create'])->name('medecin.documents.create');
    Route::post('/medecin/documents', [DocumentManageController::class, 'store'])->name('medecin.documents.store');
    Route::get('/medecin/documents/{id}/download', [DocumentManageController::class, 'download'])->name('medecin.documents.download');
    Route::delete('/medecin/documents/{id}', [DocumentManageController::class, 'destroy'])->name('medecin.documents.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('medecin', MedecinController::class)->names('medecin');
});

