<?php

namespace App\Services\HRD;

use App\Models\Pelamar;

class HRDService
{
    public function kelolaAdministrasiPelamar(Pelamar $pelamar, array $data)
    {
        // Logika untuk mengelola administrasi pelamar
        $pelamar->update([
            'status_aplikasi' => $data['status_aplikasi'],
            'tanggal_interview' => $data['tanggal_interview'],
            'catatan_hrd' => $data['catatan_hrd'],
        ]);

        return $pelamar;
    }
}