<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\ExamGroupRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\ExamGroupService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExamGroupController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var ExamGroupService
     */
    private $examGroupService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param ExamGroupService $examGroupService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        ExamGroupService $examGroupService
    )
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->examGroupService = $examGroupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');
        $examGroups = $this->examGroupService->examGroupPaginate($filters);

        return view('setting.examGroup.index', [
            'examGroups' => $examGroups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('setting.examGroup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ExamGroupRequest $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(ExamGroupRequest $request): RedirectResponse
    {
        $confirm = $this->examGroupService->storeExamGroup($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.examGroups.index');
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
        if ($examGroup = $this->examGroupService->getExamGroupById($id)) {
            return view('setting.examGroup.show', [
                'examGroup' => $examGroup,
                'timeline' => Utility::modelAudits($examGroup)
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
        if ($examGroup = $this->examGroupService->getExamGroupById($id)) {
            return view('setting.examGroup.edit', [
                'examGroup' => $examGroup
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ExamGroupRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(ExamGroupRequest $request, $id): RedirectResponse
    {
        $confirm = $this->examGroupService->updateExamGroup($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.examGroups.index');
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
            $confirm = $this->examGroupService->destroyExamGroup($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.examGroups.index');
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
            $confirm = $this->examGroupService->restoreExamGroup($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.examGroups.index');
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

        $examGroupExport = $this->examGroupService->exportExamGroup($filters);

        $filename = 'ExamGroup-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $examGroupExport->download($filename, function ($examGroup) use ($examGroupExport) {
            return $examGroupExport->map($examGroup);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('setting.examGroup.import');
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
        $examGroups = $this->examGroupService->getAllCountries($filters);

        return view('setting.examGroup.index', [
            'examGroups' => $examGroups
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

        $examGroupExport = $this->examGroupService->exportExamGroup($filters);

        $filename = 'ExamGroup-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $examGroupExport->download($filename, function ($examGroup) use ($examGroupExport) {
            return $examGroupExport->map($examGroup);
        });
    }

    /**
     * Display a detail of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function ajax(Request $request): JsonResponse
    {
        $filters = $request->except('page');

        Log::info("Ajax Request:", $request->all());
        $examGroups = $this->examGroupService->getAllExamGroups($filters)->toArray();

        if (count($examGroups) > 0):
            $jsonReturn = ['status' => true, 'data' => $examGroups]; else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
