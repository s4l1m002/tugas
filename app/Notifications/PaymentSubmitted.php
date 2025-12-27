<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PaymentSubmitted extends Notification
{
    use Queueable;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'payment_submitted',
            'transaction_id' => $this->transaction->id,
            'property_id' => $this->transaction->property_id,
            'pelanggan_id' => $this->transaction->pelanggan_id,
            'payment_method' => $this->transaction->pembayaran_metode,
            'rekening' => $this->transaction->pembayaran_rekening,
            'message' => 'Pelanggan telah mengirim bukti pembayaran untuk properti ID ' . $this->transaction->property_id,
        ];
    }
}
