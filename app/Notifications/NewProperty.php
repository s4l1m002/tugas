<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Property;

class NewProperty extends Notification
{
    use Queueable;

    protected $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
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
            'text' => "Properti baru menunggu persetujuan: {$this->property->judul}",
        ];
    }
}
