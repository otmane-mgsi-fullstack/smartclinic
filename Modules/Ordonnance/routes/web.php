<?php

use Illuminate\Support\Facades\Route;
use Modules\Ordonnance\Http\Controllers\OrdonnanceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('ordonnances', OrdonnanceController::class)->names('ordonnance');
});
