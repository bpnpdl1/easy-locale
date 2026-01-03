# Contribution Guide for Easy Locale

Thank you for considering contributing to Easy Locale. This guide explains how to set up the package for development, coding standards, and the PR process.

## Overview

- **Package Goal:** Provide clean, locale-aware routing and link generation for Laravel.
- **Compatibility:** PHP 8.2+ and Laravel 12.x.
- **License:** MIT.

## Getting Started

1. **Fork & Clone**
   - Fork `bpnpdl1/easy-locale` and clone your fork locally.
2. **Install Dependencies**
   - Run:
     ```powershell
     composer install
     ```
3. **Code Style**
   - Follow PSR-12 and Laravel conventions.
   - Prefer descriptive names over abbreviations.
   - Keep public APIs stable and documented.

## Local Development & Testing

To test the package inside a Laravel app while you develop:

- Add the package via Packagist (recommended):
  ```powershell
  composer require bpnpdl/easy-locale
  ```
- Or wire a local clone via PSR-4 in your app’s `composer.json` (editable workflow):
  ```json
  {
    "autoload": {
      "psr-4": {
        "Bpnpdl\\EasyLocale\\": "packages/bpnpdl/easy-locale/src/"
      }
    }
  }
  ```
- Register provider in `bootstrap/providers.php` of your app:
  ```php
  return [
      Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider::class,
  ];
  ```
- Rebuild autoload and smoke test:
  ```powershell
  composer dump-autoload -o
  php artisan route:list
  ```
- Publish optional assets:
  ```powershell
  php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=config
  php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=lang
  php artisan vendor:publish --provider="Bpnpdl\\EasyLocale\\EasyLocaleServiceProvider" --tag=views
  ```

## Making Changes

- Keep changes minimal and focused; avoid unrelated refactors.
- Include or update docs where behavior changes (README sections: Installation, Usage, Troubleshooting).
- Ensure namespaces and PSR-4 paths remain consistent (`Bpnpdl\\EasyLocale\\` → `src/`).
- If adding features:
  - Keep public APIs intuitive and small.
  - Add usage examples and edge-case notes.

## Commit Messages

Use clear, conventional messages:

- `feat: add locale switch endpoint`
- `fix: correct default locale handling`
- `docs: clarify route grouping usage`
- `refactor: streamline service provider boot`

## Pull Requests

- Create a branch: `feature/<short-summary>` or `fix/<short-summary>`.
- Provide context: what changed, why, and how to test.
- Include screenshots for view changes.
- Reference issues if applicable.
- Keep PRs small and incremental.

## Release & Versioning

- Follow semantic versioning.
- Tag releases with `vX.Y.Z` after merging.
- Update README if user-facing behavior changes.

## Security & Contact

- For security issues, please contact: **bipinpaudel6774@gmail.com**.
- General questions: LinkedIn **https://www.linkedin.com/in/bpnpdl/**.

---

By contributing, you agree your changes are licensed under MIT along with the rest of the project.
