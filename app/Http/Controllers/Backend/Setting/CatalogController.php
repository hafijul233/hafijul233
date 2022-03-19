<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\CatalogRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\CatalogService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @class CatalogController
 * @package $NAMESPACE$
 * 
 */
class CatalogController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    
    /**
     * @var CatalogService
     */
    private $catalogService;

    /**
     * CatalogController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param CatalogService $catalogService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                CatalogService              $catalogService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->catalogService = $catalogService;
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
        $catalogs = $this->catalogService->catalogPaginate($filters);

        return view('backend.setting.catalog.index', [
            'catalogs' => $catalogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.setting.catalog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CatalogRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(CatalogRequest $request): RedirectResponse
    {
        $confirm = $this->catalogService->storeCatalog($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.setting.catalogs.index');
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
        if ($catalog = $this->catalogService->getCatalogById($id)) {
            return view('backend.setting.catalog.show', [
                'catalog' => $catalog,
                'timeline' => Utility::modelAudits($catalog)
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
        if ($catalog = $this->catalogService->getCatalogById($id)) {
            $catalogTypes = $this->catalogService->getCatalogModelTypeArray();

            return view('backend.setting.catalog.edit', [
                'catalog' => $catalog,
                'catalogTypes' => $catalogTypes
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CatalogRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(CatalogRequest $request, $id): RedirectResponse
    {
        $confirm = $this->catalogService->updateCatalog($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.setting.catalogs.index');
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

            $confirm = $this->catalogService->destroyCatalog($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.setting.catalogs.index');
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

            $confirm = $this->catalogService->restoreCatalog($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.setting.catalogs.index');
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

        $catalogExport = $this->catalogService->exportCatalog($filters);

        $filename = 'Catalog-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $catalogExport->download($filename, function ($catalog) use ($catalogExport) {
            return $catalogExport->map($catalog);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.setting.catalogimport');
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
        $catalogs = $this->catalogService->getAllCatalogs($filters);

        return view('backend.setting.catalogindex', [
            'catalogs' => $catalogs
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

        $catalogExport = $this->catalogService->exportCatalog($filters);

        $filename = 'Catalog-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $catalogExport->download($filename, function ($catalog) use ($catalogExport) {
            return $catalogExport->map($catalog);
        });

    }
}
