<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Contact;

class MarketingContacted extends Notification
{
    use Queueable;

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'contact_id' => $this->contact->id,
            'property_id' => $this->contact->property_id,
            'text' => "Marketing telah menghubungi Anda untuk properti ID: {$this->contact->property_id}",
        ];
    }
}
