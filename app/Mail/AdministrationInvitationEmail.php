<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdministrationInvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $invitationData)
    {
        $this->invitationData = $invitationData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Undangan Proses Administrasi')->view('emails.administration_invitation');
    }
}
