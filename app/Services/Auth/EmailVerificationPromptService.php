<?php

namespace App\Services\Auth;


use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use function redirect;
use function view;

class EmailVerificationPromptService
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');
    }
}
