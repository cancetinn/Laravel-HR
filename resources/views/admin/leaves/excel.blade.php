<table>
    <thead>
        <tr>
            <th>Kullanıcı</th>
            <th>Toplam Yıllık İzin</th>
            <th>Kullanılmış İzin</th>
            <th>Kalan İzin</th>
            <th>Son İzin Tarihi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        @php
            $annualLeave = $user->annualLeaves->first();
            $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
            $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
            $remainingLeaves = $totalLeaves - $usedLeaves;

            // Son ve onaylanmış izin talebini al
            $lastApprovedLeave = $user->leaveRequests->first();
        @endphp
        <tr>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $totalLeaves }}</td>
            <td>{{ $usedLeaves }}</td>
            <td>{{ $remainingLeaves }}</td>
            <td>
                @if($lastApprovedLeave)
                    {{ \Carbon\Carbon::parse($lastApprovedLeave->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($lastApprovedLeave->end_date)->translatedFormat('d F Y') }}
                @else
                    Henüz onaylanmış izin yok
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
