<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrganizationController extends Controller
{

    public function __construct()
    {

    }

    public function __invoke(Request $request)
    {
        return view('backend.dashboard');
    }

}
