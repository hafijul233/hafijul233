<?php

namespace App\Http\Controllers\Backend\Resume;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Resume\AwardRequest;
use App\Http\Requests\Backend\Resume\ExperienceRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Resume\AwardService;
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
 * @class AwardController
 * @package App\Http\Controllers\Backend\Resume
 */
class AwardController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var AwardService
     */
    private $awardService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param AwardService $awardService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        AwardService $awardService
    )
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->awardService = $awardService;
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
        $awards = $this->awardService->awardPaginate($filters);

        return view('backend.resume.award.index', [
            'awards' => $awards
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.resume.award.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(AwardRequest $request): RedirectResponse
    {
        $confirm = $this->awardService->storeAward($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.resume.awards.index');
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
        if ($award = $this->awardService->getAwardById($id)) {
            return view('backend.resume.award.show', [
                'award' => $award,
                'timeline' => Utility::modelAudits($award)
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
        if ($award = $this->awardService->getAwardById($id)) {
            return view('backend.resume.award.edit', [
                'award' => $award
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
    public function update(AwardRequest $request, $id): RedirectResponse
    {
        $confirm = $this->awardService->updateAward($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.resume.awards.index');
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
            $confirm = $this->awardService->destroyAward($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.resume.awards.index');
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
            $confirm = $this->awardService->restoreAward($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.resume.awards.index');
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

        $awardExport = $this->awardService->exportAward($filters);

        $filename = 'Comment-' . date(config('backend.export_datetime')) . '.' . ($filters['format'] ?? 'xlsx');

        return $awardExport->download($filename, function ($award) use ($awardExport) {
            return $awardExport->map($award);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.resume.awardimport');
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
        $awards = $this->awardService->getAllAwards($filters);

        return view('backend.resume.awardindex', [
            'awards' => $awards
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

        $awardExport = $this->awardService->exportAward($filters);

        $filename = 'Comment-' . date(config('backend.export_datetime')) . '.' . ($filters['format'] ?? 'xlsx');

        return $awardExport->download($filename, function ($award) use ($awardExport) {
            return $awardExport->map($award);
        });
    }
}
