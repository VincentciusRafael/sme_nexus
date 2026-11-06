<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'verified', 'role:sme_owner'])
    ->prefix('business-autopsy')
    ->name('business-autopsy.')
    ->group(function () {
        Route::view('/', 'business-autopsy.dashboard')->name('dashboard');
    });
