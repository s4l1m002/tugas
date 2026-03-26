<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentRejected extends Notification
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
            'type' => 'payment_rejected',
            'transaction_id' => $this->transaction->id,
            'property_id' => $this->transaction->property_id,
            'message' => 'Pembayaran untuk properti ID ' . $this->transaction->property_id . ' ditolak oleh admin.',
            'text' => '<strong>Pembayaran Ditolak</strong><br>Transaksi #' . $this->transaction->id . ' untuk properti <a href="' . url('/property/' . $this->transaction->property_id) . '">#' . $this->transaction->property_id . '</a> telah DITOLAK.'
        ];
    }
}
