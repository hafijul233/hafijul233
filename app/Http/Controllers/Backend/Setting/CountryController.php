<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\CountryRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\CountryService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CountryController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var CountryService
     */
    private $countryService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param CountryService $countryService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                CountryService              $countryService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->countryService = $countryService;
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
        $countries = $this->countryService->countryPaginate($filters);

        return view('setting.country.index', [
            'countries' => $countries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('setting.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CountryRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(CountryRequest $request): RedirectResponse
    {
        $confirm = $this->countryService->storeCountry($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.countries.index');
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
        if ($country = $this->countryService->getCountryById($id)) {
            return view('setting.country.show', [
                'country' => $country,
                'timeline' => Utility::modelAudits($country)
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
        if ($country = $this->countryService->getCountryById($id)) {
            return view('setting.country.edit', [
                'country' => $country
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CountryRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(CountryRequest $request, $id): RedirectResponse
    {
        $confirm = $this->countryService->updateCountry($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('contact.settings.countries.index');
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

            $confirm = $this->countryService->destroyCountry($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.countries.index');
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

            $confirm = $this->countryService->restoreCountry($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('contact.settings.countries.index');
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

        $countryExport = $this->countryService->exportCountry($filters);

        $filename = 'Country-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $countryExport->download($filename, function ($country) use ($countryExport) {
            return $countryExport->map($country);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('setting.country.import');
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
        $countrys = $this->countryService->getAllCountries($filters);

        return view('setting.country.index', [
            'countrys' => $countrys
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

        $countryExport = $this->countryService->exportCountry($filters);

        $filename = 'Country-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $countryExport->download($filename, function ($country) use ($countryExport) {
            return $countryExport->map($country);
        });

    }
}
