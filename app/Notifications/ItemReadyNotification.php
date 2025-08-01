<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\PengajuanBarang;

class ItemReadyNotification extends Notification
{
    use Queueable;

    protected $pengajuanBarang;

    public function __construct(PengajuanBarang $pengajuanBarang)
    {
        $this->pengajuanBarang = $pengajuanBarang;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pengajuan_id' => $this->pengajuanBarang->id,
            'item_name' => $this->pengajuanBarang->item_name,
            'message' => 'Barang yang diajukan: ' . $this->pengajuanBarang->item_name . ' sudah siap.',
        ];
    }
