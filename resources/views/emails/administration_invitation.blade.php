<!DOCTYPE html>
<html>
<head>
    <title>Undangan Proses Administrasi</title>
</head>
<body>
    <p>Yth. {{ $invitationData['nama_pelamar'] }},</p>
    <p>Selamat! Anda telah lolos ke tahap selanjutnya. Kami mengundang Anda untuk mengikuti proses administrasi yang akan dilaksanakan pada:</p>
    <ul>
        <li><strong>Tanggal:</strong> {{ $invitationData['tanggal_administrasi'] }}</li>
        <li><strong>Waktu:</strong> {{ $invitationData['waktu_administrasi'] }}</li>
        <li><strong>Lokasi:</strong> {{ $invitationData['lokasi_administrasi'] }}</li>
    </ul>
    <p>Mohon konfirmasi kehadiran Anda sebelum tanggal {{ $invitationData['batas_konfirmasi_tanggal'] }} pukul {{ $invitationData['batas_konfirmasi_waktu'] }}.</p>
    <p>Terima kasih.</p>
</body>
</html>
