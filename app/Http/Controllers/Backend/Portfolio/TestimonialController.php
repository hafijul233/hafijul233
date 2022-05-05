<?php

namespace App\Http\Controllers\Backend\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Organization\SurveyRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\SurveyService;
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
 * @class TestimonialController
 * @package App\Http\Controllers\Backend\Portfolio
 */
class TestimonialController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var SurveyService
     */
    private $surveyService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param SurveyService $surveyService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                SurveyService $surveyService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->surveyService = $surveyService;
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
        $filters = $request->except('page');
        $surveys = $this->surveyService->surveyPaginate($filters);

        return view('backend.organization.survey.index', [
            'surveys' => $surveys
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.organization.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(SurveyRequest $request): RedirectResponse
    {
        $confirm = $this->surveyService->storeSurvey($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.organization.surveys.index');
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
        if ($survey = $this->surveyService->getSurveyById($id)) {
            return view('backend.organization.survey.show', [
                'survey' => $survey,
                'timeline' => Utility::modelAudits($survey)
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
        if ($survey = $this->surveyService->getSurveyById($id)) {
            return view('backend.organization.survey.edit', [
                'survey' => $survey
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SurveyRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(SurveyRequest $request, $id): RedirectResponse
    {
        $confirm = $this->surveyService->updateSurvey($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.organization.surveys.index');
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
     * @throws Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->surveyService->destroySurvey($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.organization.surveys.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     * @throws Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->surveyService->restoreSurvey($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.organization.surveys.index');
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

        $surveyExport = $this->surveyService->exportSurvey($filters);

        $filename = 'Survey-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $surveyExport->download($filename, function ($survey) use ($surveyExport) {
            return $surveyExport->map($survey);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.organization.surveyimport');
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
        $surveys = $this->surveyService->getAllSurveys($filters);

        return view('backend.organization.surveyindex', [
            'surveys' => $surveys
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

        $surveyExport = $this->surveyService->exportSurvey($filters);

        $filename = 'Survey-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $surveyExport->download($filename, function ($survey) use ($surveyExport) {
            return $surveyExport->map($survey);
        });

    }
}
