<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Property;

class PropertyStatusChanged extends Notification
{
    use Queueable;

    protected $property;
    protected $oldStatus;
    protected $newStatus;

    public function __construct(Property $property, $oldStatus, $newStatus)
    {
        $this->property = $property;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'property_id' => $this->property->id,
            'judul' => $this->property->judul,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'text' => "Status properti '{$this->property->judul}' berubah dari {$this->oldStatus} menjadi {$this->newStatus}",
        ];
    }
}
