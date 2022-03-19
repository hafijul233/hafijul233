<?php

namespace App\Notifications\Setting\Permission;

use App\Models\Setting\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PermissionDeletedNotification extends Notification
{
    use Queueable;

    /**
     * @var Permission
     */
    private $permission;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        $this->user = Auth::user();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Permission Deleted',
            'has_image' => false,
            'image_url' => asset('#'),
            'icon_class' => 'mdi mdi-card-account-details-star text-white',
            'icon_background' => 'bg-secondary',
            'description' => 'Permission named '
                . link_to(route('backend.settings.permissions.show', $this->permission->id), $this->permission->name ?? '') . ' deleted by '
                . link_to(route('admin.users.show', $this->user->id), $this->user->name ?? '') . '.',
            'url' => route('backend.settings.permissions.show', $this->permission->id)
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

}
