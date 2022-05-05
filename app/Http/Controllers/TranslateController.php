<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TranslateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $locale = $request->language;

        if (!in_array($locale, config('app.available_locales'))) {
            $locale = 'en';
        }

        Session::put('locale', $locale);

        app()->setLocale(Session::get('locale'));

        return redirect()->back();
    }
}
