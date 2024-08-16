<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $status === 'approved' ? 'İzin Talebiniz Onaylandı' : 'İzin Talebiniz Reddedildi' }}</title>
</head>
<body>
    <h1>{{ $status === 'approved' ? 'İzin Talebiniz Onaylandı' : 'İzin Talebiniz Reddedildi' }}</h1>
    <p>Merhaba {{ $leaveRequest->user->name }},</p>

    @if($status === 'approved')
        <p>Yıllık izin talebiniz onaylandı.</p>
        <p><strong>Başlangıç Tarihi:</strong> {{ $leaveRequest->start_date }}</p>
        <p><strong>Bitiş Tarihi:</strong> {{ $leaveRequest->end_date }}</p>
    @else
        <p>Yıllık izin talebiniz reddedildi.</p>
    @endif
</body>
</html>
