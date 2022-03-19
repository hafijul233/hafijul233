<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\UserRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\Setting\RoleService;
use App\Services\Backend\Setting\UserService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var RoleService
     */
    private $roleService;
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;
    /**
     * @var CountryService
     */
    private $countryService;

    /**
     * PermissionController constructor.
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param UserService $userService
     * @param RoleService $roleService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                UserService                 $userService,
                                RoleService                 $roleService)
    {
        $this->userService = $userService;
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function index(Request $request): View
    {
        $filters = $request->except('page');
        $users = $this->userService->userPaginate($filters);

        return view('backend.setting.user.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws Exception
     */
    public function create(): View
    {
        $roles = $this->roleService->roleDropdown();

        return view('backend.setting.user.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $inputs = $request->except(['_token', 'password_confirmation']);

        $photo = $request->file('photo');

        $confirm = $this->userService->storeUser($inputs, $photo);
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.settings.users.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|void
     * @throws \Exception
     */
    public function show(int $id)
    {
        if ($user = $this->userService->getUserById($id)) {
            return view('backend.setting.user.show', [
                'user' => $user,
                'timeline' => Utility::modelAudits($user)
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function edit(int $id)
    {
        if ($user = $this->userService->getUserById($id)) {
            $roles = $this->roleService->roleDropdown();
            $user_roles = $user->roles()->pluck('id')->toArray() ?? [];

            return view('backend.setting.user.edit', [
                'user' => $user,
                'roles' => $roles,
                'user_roles' => $user_roles
            ]);
        }

        abort(404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param  $id
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function update(UserRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except(['_token', 'password_confirmation']);

        $photo = $request->file('photo');

        $confirm = $this->userService->updateUser($inputs, $id, $photo);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route('backend.settings.users.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back()->withInput();

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     * @throws \Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->userService->destroyUser($id);
            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.settings.users.index');
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
            $confirm = $this->userService->restoreUser($id);
            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }
            return redirect()->route('backend.settings.users.index');
        }

        abort(403, 'Wrong user credentials');
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('backend.settings.user.permission.import');
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
        $users = $this->userService->getAllUsers($filters);

        return view('backend.setting.user.index', [
            'users' => $users
        ]);
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

        $userExport = $this->userService->exportUser($filters);

        $filename = 'User-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $userExport->download($filename, function ($user) use ($userExport) {
            return $userExport->map($user);
        });
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

        $userExport = $this->userService->exportUser($filters);

        $filename = 'User-' . date('Ymd-His') . '.' . ($filters['format'] ?? 'xlsx');

        return $userExport->download($filename, function ($user) use ($userExport) {
            return $userExport->map($user);
        });
    }
}
