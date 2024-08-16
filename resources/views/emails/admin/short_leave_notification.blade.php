<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Kısa İzin Talebi Alındı</title>
</head>
<body>
    <h1>Yeni Kısa İzin Talebi Alındı</h1>
    <p>Merhaba,</p>
    <p>{{ $shortLeave->user->name }} tarafından yeni bir kısa izin talebi oluşturuldu.</p>
    <p><strong>Tarih:</strong> {{ $shortLeave->date }}</p>
    <p><strong>Başlangıç Saati:</strong> {{ $shortLeave->start_time }}</p>
    <p><strong>Bitiş Saati:</strong> {{ $shortLeave->end_time }}</p>
    <p><strong>Süre:</strong> {{ $shortLeave->duration }} dakika</p>
    <p><strong>Nedeni:</strong> {{ $shortLeave->reason }}</p>
</body>
</html>
