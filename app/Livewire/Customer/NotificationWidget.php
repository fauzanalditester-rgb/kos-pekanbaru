<?php

namespace App\Livewire\Customer;

use App\Models\Notification;
use Livewire\Component;

class NotificationWidget extends Component
{
    public $showDropdown = false;

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function render()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('livewire.customer.notification-widget', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id === auth()->id()) {
            $notification->update(['is_read' => true]);
        }
        $this->showDropdown = false;
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}
