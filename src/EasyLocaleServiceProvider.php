<?php

namespace Bpnpdl\EasyLocale;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EasyLocaleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Config/easy-locale.php',
            'easy-locale'
        );
    }

    public function boot(): void
    {
        $default = config('easy-locale.default', 'en');
        $locales = array_keys((array) config('easy-locale.locales', []));
        $firstSegment = request()->segment(1);
        app()->setLocale($firstSegment && in_array($firstSegment, $locales, true) ? $firstSegment : $default);

        // Register package translations under the 'easy-locale' namespace
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'easy-locale');

        // Optionally register package views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'easy-locale');


        $this->publishes([
            __DIR__ . '/Config/easy-locale.php' => config_path('easy-locale.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => lang_path('vendor/easy-locale'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/easy-locale'),
        ], 'views');

        // Load package routes
        $routesPath = __DIR__ . '/../routes/web.php';
        if (file_exists($routesPath)) {
            $this->loadRoutesFrom($routesPath);
        }
    }
}
