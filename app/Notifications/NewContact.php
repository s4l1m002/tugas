<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Contact;

class NewContact extends Notification
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
        $fromName = $this->contact->pelanggan?->name ?? 'Pelanggan';
        $fromEmail = $this->contact->pelanggan?->email ?? null;
        return [
            'contact_id' => $this->contact->id,
            'property_id' => $this->contact->property_id,
            'from_name' => $fromName,
            'from_email' => $fromEmail,
            'message' => $this->contact->pesan,
            'text' => "Anda menerima permintaan kontak untuk properti ID: {$this->contact->property_id} dari {$fromName}.",
        ];
    }
}
