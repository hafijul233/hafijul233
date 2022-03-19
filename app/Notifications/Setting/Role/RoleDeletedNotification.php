<?php

namespace App\Notifications\Setting\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class RoleDeletedNotification extends Notification
{
    use Queueable;

    /**
     * @var Role
     */
    private $role;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
        $this->user = Auth::user();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
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
            'title' => 'Role Deleted',
            'has_image' => false,
            'image_url' => asset('#'),
            'icon_class' => 'mdi mdi-account-check text-white',
            'icon_background' => 'bg-secondary',
            'description' => 'Role named '
                . link_to(route('admin.roles.show', $this->role->id) . '?with=purge', $this->role->name ?? '') . ' deleted by '
                . link_to(route('admin.users.show', $this->user->id), $this->user->name ?? '') . '.',
            'url' => route('admin.roles.show', $this->role->id)
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
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
