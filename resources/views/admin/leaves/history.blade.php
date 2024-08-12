<!-- resources/views/admin/leaves/history.blade.php -->

@extends('layouts.admin')

@section('content')
    <h2>{{ $user->first_name }} {{ $user->last_name }} İzin Geçmişi</h2>

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
            @foreach($user->leaveRequests as $request)
                @php
                    $leaveDays = Carbon\Carbon::parse($request->start_date)->diffInDays(Carbon\Carbon::parse($request->end_date)) + 1;
                @endphp
                <tr>
                    <td>{{ $request->start_date }}</td>
                    <td>{{ $request->end_date }}</td>
                    <td>{{ $request->status }}</td>
                    <td>{{ $leaveDays }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
