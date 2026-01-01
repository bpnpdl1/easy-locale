# Easy Locale for Laravel

A tiny Laravel package that sets the application locale based on the first URL segment. It supports any configured locale (e.g., `ne`, `en`, `hi`, `es`). The default is Nepali (`ne`).

## Features

- Default locale from config (`ne` by default)
- Detects locale from the first URL segment: `/` → default locale, `/{locale}` → that locale
- Normalizes requests so a single route table works (no duplicate `/en` routes)
- Automatically prefixes generated URLs (`route()`, `url()`) with `/{locale}` when not default
- Ships with basic translation files (`en` and `ne`) under the `easy-locale` namespace

## Requirements

- PHP 8.2+
- Laravel 12 (Illuminate Support ^12.0)

## Installation

Available on Packagist: `bpnpdl/easy-locale`

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
        // add more like:
        // 'hi' => 'Hindi',
        // 'es' => 'Español',
    ],
    'default' => 'ne', // default app locale
];
```

## How It Works

- Global middleware `Bpnpdl\\EasyLocale\\Middleware\\NormalizeLocalePrefix` detects the first URL segment; if it matches a configured locale, it sets `App::setLocale($segment)` and strips the segment before routing. This means `/en/dashboard` is routed by the same single route definition as `/dashboard`.
- The service provider configures `URL::formatPathUsing` so `route()` and `url()` automatically include `/{locale}` when the current locale is not the default.

### Example routes (single set)

```php
Route::get('/', fn () => view('welcome'))->name('home');
// No need to duplicate with Route::prefix('en')
```

## Usage in Views

Use the package translation namespace:

```blade
{{ __('easy-locale::messages.welcome') }}
```

### Locale-aware links

Links you build with `route()` and `url()` are automatically prefixed when the current locale is not the default:

```php
route('home');            // "/" or "/en" (or "/{locale}")
url('/dashboard');        // "/dashboard" or "/en/dashboard"
```

Alternatively in Blade:

```blade
<a href="@easyLocaleHref('/dashboard')">Dashboard</a>
{{-- or using the shared prefix --}}
<a href="{{ $easyLocalePrefix }}/dashboard">Dashboard</a>
```

### Simple Toggle UI

```blade
<div class="flex items-center gap-2">
    <a href="/en" class="px-4 py-2 rounded-md border">English</a>
    <a href="/" class="px-4 py-2 rounded-md border">नेपाली</a>
    {{-- or for other locales: --}}
    <a href="/hi" class="px-4 py-2 rounded-md border">हिन्दी</a>
    <a href="/es" class="px-4 py-2 rounded-md border">Español</a>
}</div>
```

## Development

- PSR-4 autoload: `Bpnpdl\\EasyLocale\\` → `src/`
- Provider: `Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider`
- Middleware: `Bpnpdl\\EasyLocale\\Middleware\\NormalizeLocalePrefix`

## License

MIT
