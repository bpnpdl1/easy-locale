<?php

namespace Bpnpdl\EasyLocale\Services;

use Illuminate\Http\Request;

class ChangeLanguageService
{
    /**
     * Change the application's locale.
     *
     * @return void
     */
    public function changeLanguage(string $locale)
    {
        $defaultLocale = config('easy-locale.default');
        $previousUrl = Request::create(url()->previous());
        $host = $previousUrl->getSchemeAndHttpHost();
        $path = $previousUrl->getPathInfo();

        $firstUrlSegment = $previousUrl->segment(1);

        $redirectUrl = $host . '/' . $locale . $path;

        if ($defaultLocale == $locale) {
            $redirectUrl = $host . preg_replace('#^/' . preg_quote($firstUrlSegment, '#') . '#', '', $path) ?: '/';
        }

        return $redirectUrl;
    }
}
