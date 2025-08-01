<!DOCTYPE html>
<html>
<head>
    <title>Undangan Interview</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 40px; text-align: right; font-size: 0.9em; }
        .details { margin-top: 20px; }
        .details p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Undangan Interview</h2>
        </div>

        <p>Kepada Yth,</p>
        <p><strong>{{ $nama_kandidat }}</strong></p>
        <p>Di tempat</p>

        <p>Dengan hormat,</p>

        <p>Berdasarkan hasil evaluasi tim seleksi PT. Alumada Artha Prima terhadap lamaran kerja Saudara yang kami terima lewat link pelamar untuk posisi yang dilamar Tenaga <strong>{{ $jenis_jabatan_pekerjaan }}</strong>. Untuk itu Saudara kami undang untuk mengikuti seleksi Interview online.</p>

        <div class="details">
            <p><strong>Undangan Interview dilaksanakan pada:</strong></p>
            <p>Hari/tanggal : {{ $tanggal_interview }}</p>
            <p>Waktu : {{ $waktu_interview }}</p>
            <p>Via : {{ $via_interview }}</p>
        </div>

        <p>Mohon konfirmasikan kehadiran Saudari paling lambat <strong>{{ $batas_konfirmasi_tanggal }} pukul {{ $batas_konfirmasi_waktu }}</strong> dengan membalas pesan pada No Hp 0852-3662-6311 (HRD PT. Alumada Artha Prima) dengan format &quot;Siap Hadir - ({{ $nama_kandidat }}) &quot;. Terimakasih</p>

        <div class="footer">
            <p>Hormat kami,</p>
            <p>HRD</p>
            <p>PT. Alumada Artha Prima</p>
        </div>
    </div>
</body>
</html>
