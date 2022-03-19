<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\StateRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\StateService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StateController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param StateService $stateService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                StateService              $stateService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->stateService = $stateService;
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
        $states = $this->stateService->statePaginate($filters);

        return view('setting.state.index', [
            'states' => $states
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('setting.state.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StateRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(StateRequest $request): RedirectResponse
    {
        $confirm = $this->stateService->storeState($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.states.index');
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
        if ($state = $this->stateService->getStateById($id)) {
            return view('setting.state.show', [
                'state' => $state,
                'timeline' => Utility::modelAudits($state)
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
        if ($state = $this->stateService->getStateById($id)) {
            return view('setting.state.edit', [
                'state' => $state
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StateRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(StateRequest $request, $id): RedirectResponse
    {
        $confirm = $this->stateService->updateState($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.states.index');
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
        if ($this->authenticatedSessionService->validate($request)) {

            $confirm = $this->stateService->destroyState($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.states.index');
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

            $confirm = $this->stateService->restoreState($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.states.index');
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

        $stateExport = $this->stateService->exportState($filters);

        $filename = 'State-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $stateExport->download($filename, function ($state) use ($stateExport) {
            return $stateExport->map($state);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('setting.state.import');
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
        $states = $this->stateService->getAllCountries($filters);

        return view('setting.state.index', [
            'states' => $states
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

        $stateExport = $this->stateService->exportState($filters);

        $filename = 'State-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $stateExport->download($filename, function ($state) use ($stateExport) {
            return $stateExport->map($state);
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

        $states = $this->stateService->getAllStates($filters)->toArray();

        if(count($states) > 0):
            $jsonReturn = ['status' => true, 'data' => $states];
        else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
