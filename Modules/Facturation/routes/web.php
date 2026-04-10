<?php

use Illuminate\Support\Facades\Route;
use Modules\Facturation\Http\Controllers\FacturationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('facturations', FacturationController::class)->names('facturation');
});
