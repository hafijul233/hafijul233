<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\PermissionRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\PermissionService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PermissionController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param PermissionService $permissionService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                PermissionService              $permissionService)
    {

        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->permissionService = $permissionService;
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
        $permissions = $this->permissionService->permissionPaginate($filters);

        return view('backend.setting.permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.setting.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $confirm = $this->permissionService->storePermission($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.settings.permissions.index');
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
        if ($permission = $this->permissionService->getPermissionById($id)) {
            return view('backend.setting.permission.show', [
                'permission' => $permission,
                'timeline' => Utility::modelAudits($permission)
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
        if ($permission = $this->permissionService->getPermissionById($id)) {
            return view('backend.setting.permission.edit', [
                'permission' => $permission
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(PermissionRequest $request, $id): RedirectResponse
    {
        $confirm = $this->permissionService->updatePermission($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.settings.permissions.index');
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

            $confirm = $this->permissionService->destroyPermission($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.settings.permissions.index');
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

            $confirm = $this->permissionService->restorePermission($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.settings.permissions.index');
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

        $permissionExport = $this->permissionService->exportPermission($filters);

        $filename = 'Permission-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $permissionExport->download($filename, function ($permission) use ($permissionExport) {
            return $permissionExport->map($permission);
        });

    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.setting.permission.import');
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
        $permissions = $this->permissionService->getAllPermissions($filters);

        return view('backend.setting.permission.index', [
            'permissions' => $permissions
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

        $permissionExport = $this->permissionService->exportPermission($filters);

        $filename = 'Permission-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $permissionExport->download($filename, function ($permission) use ($permissionExport) {
            return $permissionExport->map($permission);
        });

    }
}
