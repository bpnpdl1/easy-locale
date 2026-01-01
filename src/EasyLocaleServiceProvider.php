<?php

namespace Bpnpdl\EasyLocale;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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
        // Register package translations under the 'easy-locale' namespace
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'easy-locale');

        // Optionally register package views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'easy-locale');

        // Push locale-detection middleware into the 'web' group
        $this->app->afterResolving('router', function (Router $router) {
            $router->pushMiddlewareToGroup('web', \Bpnpdl\EasyLocale\Middleware\DetectLocaleFromPrefix::class);
        });

        $this->publishes([
            __DIR__ . '/Config/easy-locale.php' => config_path('easy-locale.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/lang' => lang_path('vendor/easy-locale'),
        ], 'lang');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/easy-locale'),
        ], 'views');
    }
}
