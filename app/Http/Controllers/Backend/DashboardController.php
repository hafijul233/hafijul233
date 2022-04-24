<?php

namespace App\Http\Controllers\Backend;

use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\UserService;
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
     * @var EnumeratorService
     */
    private $enumeratorService;
    /**
     * @var SurveyService
     */
    private $surveyService;

    /**
     * DashboardController constructor.
     * @param UserService $userService
     * @param EnumeratorService $enumeratorService
     * @param SurveyService $surveyService
     */
    public function __construct(UserService $userService,
                                EnumeratorService $enumeratorService,
                                SurveyService $surveyService)
    {

        $this->userService = $userService;
        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
    }

    /**
     * @param Request $request
     * @return array|Application|Factory|View|mixed
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {

        return view('backend.dashboard', [
            'users' => $this->userService->getAllUsers(['role' => [2, 3, 4]])->count(),
            'enumerators' => $this->enumeratorService->getAllEnumerators()->count(),
            'surveys' => $this->surveyService->getAllSurveys()->count()
        ]);
    }

}
