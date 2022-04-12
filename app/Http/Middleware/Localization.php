<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $availableLocales = config('app.available_locales');

        $locale = Session::get('locale');

        if (in_array($locale, $availableLocales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
