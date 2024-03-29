<?php

namespace App\Http\Controllers\Backend\Resume;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Resume\LanguageRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Resume\LanguageService;
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
 * @class LanguageController
 * @package App\Http\Controllers\Backend\Resume
 */
class LanguageController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var LanguageService
     */
    private $languageService;

    /**
     * CommentController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param LanguageService $languageService
     */
    public function __construct(
        AuthenticatedSessionService $authenticatedSessionService,
        LanguageService $languageService
    ) {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->languageService = $languageService;
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
        $filters = $request->except('page', 'sort', 'direction');
        $languages = $this->languageService->languagePaginate($filters);

        return view('backend.resume.language.index', [
            'languages' => $languages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.resume.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return RedirectResponse
     * @throws Exception|Throwable
     */
    public function store(LanguageRequest $request): RedirectResponse
    {
        $confirm = $this->languageService->storeLanguage($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.resume.languages.index');
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
        if ($language = $this->languageService->getLanguageById($id)) {
            return view('backend.resume.language.show', [
                'service' => $language,
                'timeline' => Utility::modelAudits($language)
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
        if ($language = $this->languageService->getLanguageById($id)) {
            return view('backend.resume.language.edit', [
                'service' => $language
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
    public function update(ExperienceRequest $request, $id): RedirectResponse
    {
        $confirm = $this->languageService->updateLanguage($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.resume.languages.index');
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
            $confirm = $this->languageService->destroyLanguage($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.resume.languages.index');
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
            $confirm = $this->languageService->restoreLanguage($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.resume.languages.index');
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
        $filters = $request->except('page', 'sort', 'direction');

        $languageExport = $this->languageService->exportLanguage($filters);

        $filename = 'Comment-' . date(config('backend.export_datetime')) . '.' . ($filters['format'] ?? 'xlsx');

        return $languageExport->download($filename, function ($language) use ($languageExport) {
            return $languageExport->map($language);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.resume.languageimport');
    }
}
