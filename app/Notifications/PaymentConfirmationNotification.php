<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pembayaran;

class PaymentConfirmationNotification extends Notification
{
    use Queueable;

    protected $pembayaran;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Pembayaran $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Or ['mail', 'database'] if you want email notifications
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
            'pembayaran_id' => $this->pembayaran->id,
            'pelamar_id' => $this->pembayaran->pelamar_id,
            'message' => 'Pembayaran untuk pelamar ' . $this->pembayaran->pelamar->nama_lengkap . ' telah dikonfirmasi.',
        ];
    }
}
