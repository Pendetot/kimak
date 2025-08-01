<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Hasil Seleksi dan Penawaran Kerja</title>
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
            <h2>Pemberitahuan Hasil Seleksi dan Penawaran Kerja</h2>
        </div>

        <p>Selamat {{ $greeting }},</p>
        <p>{{ $nama_pelamar }}</p>

        <p>Terima kasih atas partisipasi Anda dalam proses seleksi di perusahaan kami. Dengan gembira kami memberitahukan bahwa Anda telah berhasil melewati seluruh tahapan seleksi dan kami ingin menawarkan posisi sebagai <strong>{{ $jenis_jabatan_pekerjaan }}</strong> di perusahaan kami.</p>
        <p>Kami sangat antusias untuk menyambut Anda bergabung dengan tim kami. Mohon informasikan kesediaan Anda untuk bergabung paling lambat [Tanggal Batas Konfirmasi]. Anda diharapkan dapat mulai bergabung pada tanggal <strong>{{ $tanggal_bergabung }}</strong>.</p>

        <p>Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.</p>

        <div class="footer">
            <p>Salam Hormat,</p>
            <p>HRD PT...........................</p>
        </div>
    </div>
</body>
</html>