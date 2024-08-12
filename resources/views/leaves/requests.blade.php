@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-accent">Yıllık İzinlerim</h1>

        <!-- Mevcut İzin Durumu -->
        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-accent">Mevcut İzin Durumu</h2>
            <div class="flex space-x-4">
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-white">Toplam Yıllık İzin</h3>
                    <p class="text-xl text-white">{{ $totalLeaves }}</p>
                </div>
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-white">Kullanılmış İzin</h3>
                    <p class="text-xl text-white">{{ $usedLeaves }}</p>
                </div>
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-white">Kalan İzin</h3>
                    <p class="text-xl text-white">{{ $remainingLeaves }}</p>
                </div>
            </div>
        </div>

        <!-- İzin Geçmişi -->
        <h2 class="text-2xl font-semibold mb-4 text-accent">İzin Geçmişi</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <table class="min-w-full leading-normal bg-primary text-white">
                <thead>
                    <tr>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Başlangıç Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Bitiş Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Durum</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Gün Sayısı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $request)
                    @php
                        $leaveDays = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ $request->start_date }}</td>
                        <td class="py-4 px-5 text-sm">{{ $request->end_date }}</td>
                        <td class="py-4 px-5 text-sm">{{ ucfirst($request->status) }}</td>
                        <td class="py-4 px-5 text-sm">{{ $leaveDays }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Yeni İzin Talebi -->
        <h2 class="text-2xl font-semibold mb-4 text-accent">Yeni İzin Talebi</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md">
            <form action="{{ route('leave.request') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex space-x-4 items-center">
                    <div class="flex-1">
                        <label for="start_date" class="block text-white font-semibold">Başlangıç Tarihi</label>
                        <input type="date" name="start_date" id="start_date" class="w-full p-2 rounded bg-gray-800 text-white" required>
                    </div>
                    <div class="flex-1">
                        <label for="end_date" class="block text-white font-semibold">Bitiş Tarihi</label>
                        <input type="date" name="end_date" id="end_date" class="w-full p-2 rounded bg-gray-800 text-white" required>
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition duration-200">İzin Talep Et</button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
@endsection
