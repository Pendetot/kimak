<?php

namespace App\Services\Pelamar;

use App\Mail\JobOfferEmail;
use App\Mail\RejectionEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalEmail;
use App\Mail\AdministrationInvitationEmail;

class PelamarService
{
    public function sendJobOfferEmail(array $pelamarData)
    {
        // Example data structure for $pelamarData:
        // [
        //     'nama_pelamar' => 'Nama Pelamar',
        //     'email' => 'pelamar@example.com',
        //     'greeting' => 'PAGI',
        //     'posisi_ditawarkan' => 'Posisi yang ditawarkan',
        //     'tanggal_bergabung' => 'Tanggal Bergabung',
        // ]

        Mail::to($pelamarData['email'])->send(new JobOfferEmail($pelamarData));
    }

    public function sendRejectionEmail(array $pelamarData)
    {
        // Example data structure for $pelamarData:
        // [
        //     'nama_pelamar' => 'Nama Pelamar',
        //     'email' => 'pelamar@example.com',
        //     'greeting' => 'SIANG',
        // ]

        Mail::to($pelamarData['email'])->send(new RejectionEmail($pelamarData));
    }

    public function sendApprovalEmail(array $pelamarData)
    {
        // Example data structure for $pelamarData:
        // [
        //     'nama_pelamar' => 'Nama Pelamar',
        //     'email' => 'pelamar@example.com',
        //     'password' => 'random_password',
        // ]

        Mail::to($pelamarData['email'])->send(new ApprovalEmail($pelamarData));
    }

    public function sendAdministrationInvitationEmail(array $invitationData, string $email)
    {
        Mail::to($email)->send(new AdministrationInvitationEmail($invitationData));
    }
}
