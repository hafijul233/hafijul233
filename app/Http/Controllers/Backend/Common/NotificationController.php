<?php

namespace App\Http\Controllers\Backend\Common;

use App\Http\Controllers\Controller;
use App\Models\Setting\User;
use App\Services\Backend\Common\NotificationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * @var User $notifiableUser
     */
    protected $notifiableUser = null;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * NotificationController constructor.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

        $this->notifiableUser = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except(['page']);
        $notifications = $this->notificationService->notificationPaginate($filters);

        return view('admin::common.notification.index', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function show(string $id)
    {
        if ($notification = $this->notificationService->getNotificationById($id)) {
            $notificationData = $notification->data;
            return redirect()->to($notificationData['url']);
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Response
     * @throws \Exception
     */
    public function mark(string $id): Response
    {
        $this->notifiableUser->unreadNotifications
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })->markAsRead();

        //TODO forward to notification url
        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function markAll(Request $request): RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }

}
