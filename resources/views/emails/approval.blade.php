<!DOCTYPE html>
<html>
<head>
    <title>Akun Anda Telah Dibuat</title>
</head>
<body>
    <p>Selamat {{ $data['nama_pelamar'] }},</p>
    <p>Akun anda telah berhasil dibuat. Berikut adalah detail akun anda:</p>
    <p>Email: {{ $data['email'] }}</p>
    <p>Password: {{ $data['password'] }}</p>
    <p>Silahkan login ke sistem kami menggunakan detail akun di atas.</p>
</body>
</html>
