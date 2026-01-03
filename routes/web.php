<?php

use Bpnpdl\EasyLocale\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/locale/{locale}', [LanguageController::class, 'switch'])
        ->name('easy-locale.switch-language');
});
