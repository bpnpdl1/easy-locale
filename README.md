# Easy Locale for Laravel

A tiny Laravel package that sets the application locale based on the first URL segment. Defaults to Nepali (`ne`), and switches to English (`en`) when the request path is prefixed with `/en`.

## Features
- Default locale from config (`ne` by default)
- Detects locale from route prefix: `/` → Nepali, `/en` → English
- Auto-registers middleware for the `web` group
- Ships with basic translation files (`en` and `ne`) under the `easy-locale` namespace

## Requirements
- PHP 8.2+
- Laravel 12 (Illuminate Support ^12.0)

## Installation
```
composer require bpnpdl/easy-locale
```

The service provider is auto-discovered. Optionally publish config and resources:
```
php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=config
php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=lang
php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=views
```

## Configuration
Published to `config/easy-locale.php`:
```php
return [
    'locales' => [
        'en' => 'English',
        'ne' => 'नेपाली',
    ],
    'default' => 'ne', // default app locale
];
```

## How It Works
The middleware `Bpnpdl\\EasyLocale\\Middleware\\DetectLocaleFromPrefix` sets the locale to `en` when the first URL segment is `en`, otherwise it uses the configured default (`ne`). It is pushed to the `web` middleware group by the package provider.

### Example routes
Add an English-prefixed group mirroring base routes:
```php
Route::get('/', fn () => view('welcome'));        // Nepali
Route::prefix('en')->group(function () {
    Route::get('/', fn () => view('welcome'));    // English
});
```

## Usage in Views
Use the package translation namespace:
```blade
{{ __('easy-locale::messages.welcome') }}
```

### Simple Toggle UI
```blade
<div class="flex items-center gap-2">
  <a href="/en" class="px-4 py-2 rounded-md border">English</a>
  <a href="/" class="px-4 py-2 rounded-md border">नेपाली</a>
</div>
```

## Development
- PSR-4 autoload: `Bpnpdl\\EasyLocale\\` → `src/`
- Provider: `Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider`
- Middleware: `Bpnpdl\\EasyLocale\\Middleware\\DetectLocaleFromPrefix`

## License
MIT
