# Easy Locale for Laravel

Locale-aware routing and links with “no prefix for default” semantics. If your default locale is `en`, URLs look like `/about`; other locales are prefixed, e.g. `/np/about`.

## Features

- Default locale without a URL prefix (e.g., `en` → `/about`)
- Other locales use a first URL segment (e.g., `np` → `/np/about`)
- Simple locale switch route: `GET /locale/{locale}` redirects to the proper URL
- Lightweight service to group your app routes under the current locale
- Publishable views (language switcher) and translations

## Requirements

- PHP 8.2+
- Laravel 12 (Illuminate Support ^12.0)

## Installation

### Editable install in a Laravel app (GitHub clone)

If you want to modify this package locally and push changes back to GitHub while using it inside your Laravel app, clone the repo into your app and wire PSR-4 autoload:

```powershell
mkdir -Force packages\bpnpdl
git clone https://github.com/bpnpdl1/easy-locale.git packages\bpnpdl\easy-locale
```

In your app `composer.json` add:

```json
{
  "autoload": {
    "psr-4": {
      "Bpnpdl\\EasyLocale\\": "packages/bpnpdl/easy-locale/src/"
    }
  }
}
```

Register the provider in `bootstrap/providers.php`:

```php
return [
    // ...
    Bpnpdl\EasyLocale\EasyLocaleServiceProvider::class,
];
```

Then rebuild autoload:

```powershell
composer dump-autoload -o
php artisan route:list
```

Edit files under `packages/bpnpdl/easy-locale`, commit, and push:

```powershell
cd packages\bpnpdl\easy-locale
git checkout -b feature/readme-update
git add -A
git commit -m "docs: update README"
git push -u origin feature/readme-update
```

Install via Composer — either as a local path repository or from your VCS:

1. Local path (mono-repo)

Add to your app `composer.json`:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "packages/bpnpdl/easy-locale",
      "options": { "symlink": true }
    }
  ]
}
```

Then require the package:

```bash
composer require bpnpdl/easy-locale:@dev
```

2. VCS (GitHub)

```json
{
  "repositories": [
    { "type": "vcs", "url": "https://github.com/bpnpdl1/easy-locale" }
  ]
}
```

```bash
composer require bpnpdl/easy-locale:dev-develop
```

The service provider is auto-discovered.

## Publish assets

```bash
php artisan vendor:publish --provider="Bpnpdl\EasyLocale\EasyLocaleServiceProvider" --tag=config
php artisan vendor:publish --provider="Bpnpdl\EasyLocale\EasyLocaleServiceProvider" --tag=lang
php artisan vendor:publish --provider="Bpnpdl\EasyLocale\EasyLocaleServiceProvider" --tag=views
```

## Configuration

`config/easy-locale.php`:

```php
return [
        'locales' => [
                'en' => 'English',
                'np' => 'नेपाली',
                // add more like:
                // 'hi' => 'Hindi',
                // 'es' => 'Español',
        ],
        'default' => 'en', // default app locale; has no URL prefix
];
```

## Routing: group by current locale

Use the provided service to group your frontend routes. Default locale → no prefix; others → `/{locale}` prefix.

```php
use Bpnpdl\EasyLocale\Services\GroupLocaleRouteService;

$frontend = function () {
        Route::get('/', fn () => view('welcome'))->name('home');
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
};

GroupLocaleRouteService::setLocaleRoutePrefix($frontend);
```

Behind the scenes, the package sets `app()->getLocale()` from the first URL segment if it matches a configured locale; otherwise it uses your configured default.

## Locale switching

The package registers:

- `GET /locale/{locale}` → `easy-locale.switch-language`

Use it to switch languages without breaking URLs. Examples:

```blade
<a href="{{ route('easy-locale.switch-language', 'en') }}">English</a>
<a href="{{ route('easy-locale.switch-language', 'np') }}">नेपाली</a>
```

If you prefer a ready-made UI, include the switcher view:

```blade
@include('easy-locale::switcher')
{{-- or if you published views: --}}
@include('vendor.easy-locale.switcher')
```

## Translations and views

- Translations can be published to `lang/vendor/easy-locale`.
- Views can be published to `resources/views/vendor/easy-locale`.

In your app views you can use normal Laravel translation files (e.g., `lang/en/*.php`, `lang/np/*.php`). The package itself does not override your app’s translation loading.

## Example: links

When you build links using named routes, the current locale determines the URL:

```blade
<a href="{{ route('home') }}">Home</a>
<a href="{{ route('about') }}">About</a>
<a href="{{ route('contact') }}">Contact</a>
```

- Default locale `en`: `/`, `/about`, `/contact`
- Locale `np`: `/np`, `/np/about`, `/np/contact`

## Troubleshooting

- Seeing `/en/...` when you expect no prefix? Ensure `default` in `config/easy-locale.php` is set to `en` and that you group routes with `GroupLocaleRouteService`.
- Switching to the default locale still shows a prefix? Use the `easy-locale.switch-language` route; it removes the prefix for the default locale.
- Added a new locale but URLs don’t work? Add the locale code to `config('easy-locale.locales')`, clear caches, and verify your route group is using `GroupLocaleRouteService`.

## Development

- PSR-4: `Bpnpdl\EasyLocale\` → `src/`
- Provider: `Bpnpdl\EasyLocale\EasyLocaleServiceProvider`
- Services: `ChangeLanguageService`, `GroupLocaleRouteService`
- Routes: `routes/web.php` (switch endpoint)

## License

MIT
