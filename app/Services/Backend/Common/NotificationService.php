<?php


namespace App\Services\Backend\Common;


use App\Abstracts\Service\Service;
use App\Models\Setting\User;
use App\Services\Backend\Setting\UserService;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use function auth;

class NotificationService extends Service
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Return Paginated Notifications
     * of current logged user
     *
     * @param array $filters
     * @return LengthAwarePaginator
     * @throws Exception
     */
    public function notificationPaginate(array $filters = []): LengthAwarePaginator
    {
        $notifications = null;

        $notifiableUser = (isset($filters['user_id']))
            ? $this->userService->getUserById($filters['user_id'])
            : Auth::user();

        //select Notification type ['all', 'unread']
        //default : unread
        if (isset($filters['type'])) {
            if ($filters['type'] == 'all') {
                $notifications = $notifiableUser->notifications();
            } elseif($filters['type'] == 'unread') {
                $notifications = $notifiableUser->unreadNotifications();
            }
        } else {
            $notifications = $notifiableUser->unreadNotifications();
        }

        //sort
        //select Notification type ['asc', 'desc']
        //default : desc
        if (isset($filters['sort'])) {
            if ($filters['sort'] == 'asc') {
                $notifications = $notifications->oldest();
            } elseif($filters['type'] == 'desc') {
                $notifications = $notifications->latest();
            }
        } else {
            $notifications = $notifications->latest();
        }

        return  $notifications->paginate();
    }

    /**
     * @param array $filters
     * @param array $eagerRelations
     * @return mixed
     * @throws Exception
     */
    public function rolePaginate(array $filters = [], array $eagerRelations = [])
    {
        return $this->userRepository->paginateWith($filters, $eagerRelations, true);
    }

    /**
     * @param string $id
     * @return Notification|null
     * @throws Exception
     */
    public function getNotificationById(string $id): ?Notification
    {
        try {
            /**
             * @var User $currentUser
             */
            $currentUser = auth()->user();

            /**
             * @var Notification $notification
             */
            $notification = $currentUser->notifications()->where('id', $id)->get();

            return $notification;

        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @param array $inputs
     * @return Model
     * @throws Exception
     */
    public function storeNotification(array $inputs): Model
    {
        return $this->userRepository->create($inputs);
    }

    /**
     * @param array $inputs
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function updateNotification(array $inputs, $id): bool
    {
        return $this->userRepository->update($inputs, $id);
    }


    /**
     * @param array $filters
     * @return array
     */
    public function notificationDropdown(array $filters = []): array
    {
        $roleCollection = $this->userRepository->all();
        $roles = [];
        foreach ($roleCollection as $role)
            $roles[$role->id] = $role['name'];

        return $roles;
    }
}
