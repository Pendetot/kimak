<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Pelamar;

class InterviewAttendanceNotification extends Notification
{
    use Queueable;

    protected $pelamar;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pelamar $pelamar)
    {
        $this->pelamar = $pelamar;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = $this->pelamar->interview_attendance_status === 'can_attend' ? 'Bisa Hadir' : 'Tidak Bisa Hadir';
        $subject = 'Konfirmasi Kehadiran Interview Pelamar: ' . $this->pelamar->nama_lengkap . ' (' . $status . ')';
        $url = route('hrd.administrasi-pelamar.show', $this->pelamar->id);

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting('Halo HRD,')
                    ->line('Pelamar bernama ' . $this->pelamar->nama_lengkap . ' telah mengkonfirmasi kehadiran interview.')
                    ->line('Status kehadiran: ' . $status . '.')
                    ->action('Lihat Detail Pelamar', $url)
                    ->line('Terima kasih.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pelamar_id' => $this->pelamar->id,
            'pelamar_name' => $this->pelamar->nama_lengkap,
            'attendance_status' => $this->pelamar->interview_attendance_status,
        ];
    }
}
