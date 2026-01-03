<?php

namespace Bpnpdl\EasyLocale\Http\Controllers;

use Bpnpdl\EasyLocale\Services\ChangeLanguageService;
use Illuminate\Http\Request;

class LanguageController
{
    public function switch(Request $request, string $locale, ChangeLanguageService $service)
    {
        $redirectUrl = $service->changeLanguage($locale);

        return redirect($redirectUrl);
    }
}
