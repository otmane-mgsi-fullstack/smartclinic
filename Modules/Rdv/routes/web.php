<?php

use Illuminate\Support\Facades\Route;
use Modules\Rdv\Http\Controllers\RdvController;
use Modules\Rdv\Http\Controllers\RdvBookingController;
use Modules\Rdv\Http\Controllers\AdminRdvController;

Route::middleware(['web'])
    ->group(function () {
        Route::get('/rdv', [RdvController::class, 'index'])->name('rdv.index');
        // Modules/Rdv/Routes/web.php

        Route::post('/rdv/store', [RdvBookingController::class, 'store'])->name('rdv.store');
    });

Route::middleware(['web', 'auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('rdv', AdminRdvController::class)->names('rdv');
});
