<?php

namespace App\Http\Controllers\Frontend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Organization\ApplicantRequest;
use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\CatalogService;
use App\Services\Backend\Setting\ExamLevelService;
use App\Supports\Constant;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * @class ApplicantController
 * @package App\Http\Controllers\Backend\Organization
 */
class ApplicantController extends Controller
{
    /**
     * @var EnumeratorService
     */
    private $enumeratorService;
    /**
     * @var SurveyService
     */
    private $surveyService;
    /**
     * @var CatalogService
     */
    private $catalogService;
    /**
     * @var ExamLevelService
     */
    private $examLevelService;

    /**
     * ApplicantController Constructor
     *
     * @param EnumeratorService $enumeratorService
     * @param SurveyService $surveyService
     * @param CatalogService $catalogService
     * @param ExamLevelService $examLevelService
     */
    public function __construct(EnumeratorService $enumeratorService,
                                SurveyService $surveyService,
                                CatalogService $catalogService,
                                ExamLevelService $examLevelService)
    {

        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
        $this->catalogService = $catalogService;
        $this->examLevelService = $examLevelService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function create()
    {
        return view('frontend.organization.applicant.create', [
            'surveys' => $this->surveyService->getSurveyDropDown(),
            'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
            'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(ApplicantRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        dd($inputs);

        $confirm = $this->enumeratorService->storeEnumerator($inputs);

        if ($confirm['status'] == true) {
            notify('Applicant Registration Successful', $confirm['level'], $confirm['title']);
            return redirect()->route('frontend.organization.applicants.create');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }
}
