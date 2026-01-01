<?php

namespace Bpnpdl\EasyLocale\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class DetectLocaleFromPrefix
{
    /**
     * Default to Nepali; if first URL segment is 'en', use English.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $default = config('easy-locale.default', 'ne');
        $first = $request->segment(1);

        if ($first === 'en') {
            App::setLocale('en');
        } else {
            App::setLocale($default);
        }

        return $next($request);
    }
}
