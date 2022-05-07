<?php

namespace App\Http\Controllers\Backend\Resume;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\CertificateRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Resume\EducationService;
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
 * @class CommentController
 * @package App\Http\Controllers\Backend\Resume
 */
class EducationController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var EducationService
     */
    private $educationService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param EducationService $educationService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                EducationService $educationService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->educationService = $educationService;
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
        $educations = $this->educationService->educationPaginate($filters);

        return view('backend.resume.education.index', [
            'educations' => $educations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.resume.education.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(CertificateRequest $request): RedirectResponse
    {
        $confirm = $this->educationService->storeSurvey($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.educations.index');
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
        if ($education = $this->educationService->getSurveyById($id)) {
            return view('backend.resume.education.show', [
                'service' => $education,
                'timeline' => Utility::modelAudits($education)
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
        if ($education = $this->educationService->getSurveyById($id)) {
            return view('backend.resume.education.edit', [
                'service' => $education
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CertificateRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(CertificateRequest $request, $id): RedirectResponse
    {
        $confirm = $this->educationService->updateSurvey($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.educations.index');
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

            $confirm = $this->educationService->destroySurvey($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.educations.index');
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

            $confirm = $this->educationService->restoreSurvey($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.educations.index');
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

        $educationExport = $this->educationService->exportSurvey($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $educationExport->download($filename, function ($education) use ($educationExport) {
            return $educationExport->map($education);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.portfolio.educationimport');
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
        $educations = $this->educationService->getAllSurveys($filters);

        return view('backend.portfolio.educationindex', [
            'educations' => $educations
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

        $educationExport = $this->educationService->exportSurvey($filters);

        $filename = 'Comment-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $educationExport->download($filename, function ($education) use ($educationExport) {
            return $educationExport->map($education);
        });

    }
}
