<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pelamar;

class DocumentsForwardedNotification extends Notification
{
    use Queueable;

    protected $pelamar;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Pelamar $pelamar)
    {
        $this->pelamar = $pelamar;
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
            'pelamar_id' => $this->pelamar->id,
            'message' => 'Dokumen untuk pelamar ' . $this->pelamar->nama_lengkap . ' telah diteruskan.',
        ];
    }
}
