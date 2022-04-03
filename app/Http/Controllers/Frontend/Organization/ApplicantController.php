<?php

namespace App\Http\Controllers\Frontend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Organization\ApplicantRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\EnumeratorService;
use App\Services\Backend\Organization\SurveyService;
use App\Services\Backend\Setting\CatalogService;
use App\Services\Backend\Setting\ExamLevelService;
use App\Services\Backend\Setting\InstituteService;
use App\Supports\Constant;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @class ApplicantController
 * @package App\Http\Controllers\Backend\Organization
 */
class ApplicantController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

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
     * @var InstituteService
     */
    private $instituteService;
    /**
     * @var ExamLevelService
     */
    private $examLevelService;

    /**
     * ApplicantController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param EnumeratorService $enumeratorService
     * @param SurveyService $surveyService
     * @param CatalogService $catalogService
     * @param InstituteService $instituteService
     * @param ExamLevelService $examLevelService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                EnumeratorService $enumeratorService,
                                SurveyService $surveyService,
                                CatalogService $catalogService,
                                InstituteService $instituteService,
                                ExamLevelService $examLevelService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->enumeratorService = $enumeratorService;
        $this->surveyService = $surveyService;
        $this->catalogService = $catalogService;
        $this->instituteService = $instituteService;
        $this->examLevelService = $examLevelService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        abort(403);
        $filters = $request->except('page');
        $enumerators = $this->enumeratorService->enumeratorPaginate($filters);

        return view('backend.organization.enumerator.index', [
            'enumerators' => $enumerators
        ]);
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
            'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']]),
            'boards' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['BOARD']]),
            'universities' => $this->instituteService->getInstituteDropDown(['exam_level_id' => 3]),
            'exam_levels' => $this->examLevelService->getAllExamLevels(['id_in' => [1, 2, 3, 4]])
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
        $confirm = $this->enumeratorService->storeEnumerator($inputs);
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('frontend.organization.applicants.create');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show($id)
    {
        abort(403);

        if ($enumerator = $this->enumeratorService->getEnumeratorById($id)) {
            return view('backend.organization.enumerator.show', [
                'enumerator' => $enumerator,
                'timeline' => Utility::modelAudits($enumerator)
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     * @throws Exception
     */
    public function edit($id)
    {
        abort(403);

        if ($enumerator = $this->enumeratorService->getEnumeratorById($id)) {
            return view('backend.organization.enumerator.edit', [
                'enumerator' => $enumerator,
                'surveys' => $this->surveyService->getSurveyDropDown(),
                'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']]),
                'boards' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['BOARD']]),
                'universities' => $this->instituteService->getInstituteDropDown(['exam_level_id' => 3]),
                'exam_levels' => $this->examLevelService->getAllExamLevels(['id_in' => [1, 2, 3, 4]])
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ApplicantRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(ApplicantRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->enumeratorService->updateEnumerator($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.organization.enumerators.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function destroy($id, Request $request)
    {
        abort(403);

        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->enumeratorService->destroyEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.organization.enumerators.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     * @throws \Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->enumeratorService->restoreEnumerator($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.organization.enumerators.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return string|StreamedResponse
     * @throws Exception
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');

        $enumeratorExport = $this->enumeratorService->exportEnumerator($filters);

        $filename = 'Enumerator-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $enumeratorExport->download($filename, function ($enumerator) use ($enumeratorExport) {
            return $enumeratorExport->map($enumerator);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.organization.enumeratorimport');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function importBulk(Request $request)
    {
        $filters = $request->except('page');
        $enumerators = $this->enumeratorService->getAllEnumerators($filters);

        return view('backend.organization.enumeratorindex', [
            'enumerators' => $enumerators
        ]);
    }

    /**
     * Display a detail of the resource.
     *
     * @return StreamedResponse|string
     * @throws Exception
     */
    public function print(Request $request)
    {
        $filters = $request->except('page');

        $enumeratorExport = $this->enumeratorService->exportEnumerator($filters);

        $filename = 'Enumerator-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $enumeratorExport->download($filename, function ($enumerator) use ($enumeratorExport) {
            return $enumeratorExport->map($enumerator);
        });

    }
}
