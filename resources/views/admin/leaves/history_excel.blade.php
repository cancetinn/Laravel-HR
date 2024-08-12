<table>
    <thead>
        <tr>
            <th>Başlangıç Tarihi</th>
            <th>Bitiş Tarihi</th>
            <th>Durum</th>
            <th>Gün Sayısı</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leaveRequests as $request)
        @php
            $leaveDays = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
        @endphp
        <tr>
            <td>{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</td>
            <td>{{ $request->status }}</td>
            <td>{{ $leaveDays }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
