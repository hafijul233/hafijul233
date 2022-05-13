<?php

namespace App\Http\Controllers\Backend\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Portfolio\EducationRequest;
use App\Http\Requests\Backend\Portfolio\ExperienceRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Portfolio\ProjectService;
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
 * @class ProjectController
 * @package App\Http\Controllers\Backend\Portfolio
 */
class ProjectController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * ProjectController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param ProjectService $projectService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        ProjectService $projectService
    )
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->projectService = $projectService;
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
        $projects = $this->projectService->projectPaginate($filters);

        return view('backend.portfolio.project.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.portfolio.project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(EducationRequest $request): RedirectResponse
    {
        $confirm = $this->projectService->storeProject($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.projects.index');
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
        if ($project = $this->projectService->getProjectById($id)) {
            return view('backend.portfolio.project.show', [
                'project' => $project,
                'timeline' => Utility::modelAudits($project)
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
        if ($project = $this->projectService->getProjectById($id)) {
            return view('backend.portfolio.project.edit', [
                'project' => $project
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExperienceRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(EducationRequest $request, $id): RedirectResponse
    {
        $confirm = $this->projectService->updateProject($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.portfolio.projects.index');
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
            $confirm = $this->projectService->destroyProject($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.projects.index');
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
            $confirm = $this->projectService->restoreProject($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.portfolio.projects.index');
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

        $projectExport = $this->projectService->exportProject($filters);

        $filename = 'Project-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $projectExport->download($filename, function ($project) use ($projectExport) {
            return $projectExport->map($project);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.portfolio.projectimport');
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
        $projects = $this->projectService->getAllProjects($filters);

        return view('backend.portfolio.projectindex', [
            'projects' => $projects
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

        $projectExport = $this->projectService->exportProject($filters);

        $filename = 'Project-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $projectExport->download($filename, function ($project) use ($projectExport) {
            return $projectExport->map($project);
        });
    }
}
