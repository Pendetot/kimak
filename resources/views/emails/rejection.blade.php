<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Hasil Seleksi Lamaran Kerja</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 0 auto; padding: 20px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 40px; text-align: right; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pemberitahuan Hasil Seleksi Lamaran Kerja</h2>
        </div>

        <p>Selamat {{ $greeting }},</p>
        <p><strong>{{ $nama_pelamar }}</strong></p>

        <p>Terima kasih atas partisipasi Anda dalam proses seleksi di perusahaan kami. Setelah interview dan evaluasi, kami sampaikan bahwa saat ini Saudara belum dapat kami terima untuk bergabung di Perusahaan kami.</p>
        <p>Kami sangat menghargai waktu, usaha, dan minat Anda pada perusahaan kami. Semoga kita dapat bergabung pada kesempatan lain.</p>

        <div class="footer">
            <p>Salam,</p>
            <p>HRD PT. Alumada Artha Prima</p>
        </div>
    </div>
</body>
</html>
