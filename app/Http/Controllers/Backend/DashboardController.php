<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Organization\Enumerator;
use App\Models\Backend\Organization\Survey;
use App\Models\Backend\Setting\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{

    public function __construct()
    {

    }

    public function __invoke(Request $request)
    {

        return view('backend.dashboard', [
            'users' => User::all()->count(),
            'enumerators' => Enumerator::all()->count(),
            'surveys' => Survey::all()->count()
        ]);
    }

}
