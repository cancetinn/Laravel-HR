<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İzin Talebi</title>
</head>
<body>
    <h1>Yeni İzin Talebi Alındı</h1>
    <p>Merhaba,</p>
    <p>{{ $leaveRequest->user->name }} tarafından yeni bir izin talebi oluşturuldu.</p>
    <p><strong>Başlangıç Tarihi:</strong> {{ $leaveRequest->start_date }}</p>
    <p><strong>Bitiş Tarihi:</strong> {{ $leaveRequest->end_date }}</p>
</body>
</html>
