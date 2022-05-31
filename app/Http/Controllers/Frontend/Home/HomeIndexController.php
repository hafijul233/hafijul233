<?php

namespace App\Http\Controllers\Frontend\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CatalogRequest;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/**
 * Class AboutIndexController
 * @package App\Http\Controllers\Frontend
 */
class HomeIndexController extends Controller
{
    /**
     * AboutIndexController Constructor
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        return view('frontend.home.index');
    }
}
