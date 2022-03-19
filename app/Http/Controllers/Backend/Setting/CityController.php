<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CityRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\CityService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CityController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var CityService
     */
    private $cityService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param CityService $cityService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                CityService              $cityService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->cityService = $cityService;
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
        $citys = $this->cityService->cityPaginate($filters);

        return view('setting.city.index', [
            'citys' => $citys
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('setting.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CityRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(CityRequest $request): RedirectResponse
    {
        $confirm = $this->cityService->storeCity($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.citys.index');
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
        if ($city = $this->cityService->getCityById($id)) {
            return view('setting.city.show', [
                'city' => $city,
                'timeline' => Utility::modelAudits($city)
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
        if ($city = $this->cityService->getCityById($id)) {
            return view('setting.city.edit', [
                'city' => $city
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CityRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(CityRequest $request, $id): RedirectResponse
    {
        $confirm = $this->cityService->updateCity($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.citys.index');
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

            $confirm = $this->cityService->destroyCity($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.citys.index');
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

            $confirm = $this->cityService->restoreCity($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.citys.index');
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

        $cityExport = $this->cityService->exportCity($filters);

        $filename = 'City-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $cityExport->download($filename, function ($city) use ($cityExport) {
            return $cityExport->map($city);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('setting.city.import');
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
        $citys = $this->cityService->getAllCountries($filters);

        return view('setting.city.index', [
            'citys' => $citys
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

        $cityExport = $this->cityService->exportCity($filters);

        $filename = 'City-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $cityExport->download($filename, function ($city) use ($cityExport) {
            return $cityExport->map($city);
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

        $cities = $this->cityService->getAllCities($filters)->toArray();

        if(count($cities) > 0):
            $jsonReturn = ['status' => true, 'data' => $cities];
        else :
            $jsonReturn = ['status' => false, 'data' => []];
        endif;

        return response()->json($jsonReturn, 200);
    }
}
