<?php

namespace Bpnpdl\EasyLocale\Services;

use Illuminate\Support\Facades\Route;

class GroupLocaleRouteService
{
    public static function setLocaleRoutePrefix($groupRoutes): void
    {
        $availableLocales = array_keys(config('easy-locale.locales', []));
        $appLocale = app()->getLocale();

        if (in_array($appLocale, $availableLocales, true) && $appLocale !== config('easy-locale.default')) {
            Route::prefix($appLocale)->group($groupRoutes);
        } else {
            Route::middleware('web')->group($groupRoutes);
        }
    }
}
