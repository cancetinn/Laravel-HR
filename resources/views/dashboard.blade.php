@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-white">Aktif İzinler</h1>

        @if($activeShortLeaves->isNotEmpty() || $activeAnnualLeaves->isNotEmpty())
            <div class="bg-gray-800 p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold mb-4 text-white">Devam Eden İzinler</h2>
                <ul class="space-y-4">
                    @foreach($activeShortLeaves as $leave)
                    <li class="bg-gray-700 p-4 rounded-md shadow">
                        <span class="text-xl font-semibold text-blue-300">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</span>
                        <span class="text-white">- {{ \Carbon\Carbon::parse($leave->date)->format('d F Y') }} {{ \Carbon\Carbon::parse($leave->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($leave->end_time)->format('H:i') }}</span>
                    </li>
                    @endforeach

                    @foreach($activeAnnualLeaves as $leave)
                    <li class="bg-gray-700 p-4 rounded-md shadow">
                        <span class="text-xl font-semibold text-blue-300">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</span>
                        <span class="text-white">- {{ \Carbon\Carbon::parse($leave->start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d F Y') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold mb-4 text-white">Aktif İzin Yok</h2>
                <p class="text-gray-400">Şu anda devam eden bir izin bulunmamaktadır.</p>
            </div>
        @endif
    </div>
</div>
@endsection
