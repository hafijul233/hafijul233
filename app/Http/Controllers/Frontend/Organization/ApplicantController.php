<?php

namespace App\Http\Controllers\Frontend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Organization\ApplicantRequest;
use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\CatalogService;
use App\Services\Backend\Setting\ExamLevelService;
use App\Services\Backend\Setting\StateService;
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
     * @var StateService
     */
    private $stateService;

    /**
     * ApplicantController Constructor
     *
     * @param EnumeratorService $enumeratorService
     * @param SurveyService $surveyService
     * @param CatalogService $catalogService
     * @param ExamLevelService $examLevelService
     * @param StateService $stateService
     */
    public function __construct(EnumeratorService $enumeratorService,
                                SurveyService $surveyService,
                                CatalogService $catalogService,
                                ExamLevelService $examLevelService,
                                StateService $stateService)
    {

        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
        $this->catalogService = $catalogService;
        $this->examLevelService = $examLevelService;
        $this->stateService = $stateService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function create()
    {
        $enables = [];

        foreach (Constant::ENABLED_OPTIONS as $field => $label):
            $enables[$field] = __('common.' . $label);
        endforeach;

        return view('frontend.organization.applicant.create', [
            'enables' => $enables,
            'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district']),
            'surveys' => $this->surveyService->getSurveyDropDown(['enabled' => Constant::ENABLED_OPTION]),
            'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
            'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApplicantRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function store(ApplicantRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->enumeratorService->storeEnumerator($inputs);

        if ($confirm['status'] == true) {
            notify('Applicant Registration Successful', $confirm['level'], $confirm['title']);
            return redirect()->route('frontend.organization.applicants.create');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }
}
