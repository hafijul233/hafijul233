<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    public function __construct()
    {
    }

    public function __invoke(Request $request)
    {
        $settings = config('backend.settings');
        return view('backend.setting', [
            'settings' => $settings
        ]);
    }
}
