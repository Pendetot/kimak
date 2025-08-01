<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PembelianBarang;

class PurchaseRequestNotification extends Notification
{
    use Queueable;

    protected $pembelianBarang;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PembelianBarang $pembelianBarang)
    {
        $this->pembelianBarang = $pembelianBarang;
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
            'pembelian_id' => $this->pembelianBarang->id,
            'item_name' => $this->pembelianBarang->item_name,
            'quantity' => $this->pembelianBarang->quantity,
            'message' => 'Pengajuan barang baru untuk ' . $this->pengajuanBarang->item_name . ' (Jumlah: ' . $this->pengajuanBarang->quantity . ') telah diajukan oleh HRD.',
        ];
    }
}
