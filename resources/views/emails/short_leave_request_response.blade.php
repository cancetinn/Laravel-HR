<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $status === 'approve' ? 'Kısa İzin Talebiniz Onaylandı' : 'Kısa İzin Talebiniz Reddedildi' }}</title>
</head>
<body>
    <h1>{{ $status === 'approve' ? 'Kısa İzin Talebiniz Onaylandı' : 'Kısa İzin Talebiniz Reddedildi' }}</h1>
    <p>Merhaba {{ $shortLeave->user->name }},</p>

    @if($status === 'approve')
        <p>Kısa izin talebiniz onaylandı.</p>
        <p><strong>Tarih:</strong> {{ $shortLeave->date }}</p>
        <p><strong>Başlangıç Saati:</strong> {{ $shortLeave->start_time }}</p>
        <p><strong>Bitiş Saati:</strong> {{ $shortLeave->end_time }}</p>
        <p><strong>Süre:</strong> {{ $shortLeave->duration }} dakika</p>
    @else
        <p>Kısa izin talebiniz reddedildi.</p>
    @endif
</body>
</html>
