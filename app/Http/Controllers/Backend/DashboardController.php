<?php

namespace App\Http\Controllers\Backend;

use App\Services\Backend\Setting\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * DashboardController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return array|Application|Factory|View|mixed
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        return view('backend.dashboard', [
            'users' => $this->userService->getAllUsers(['role' => [2, 3, 4]])->count(),
            'enumerators' => 0,
            'surveys' => 0
        ]);
    }
}
