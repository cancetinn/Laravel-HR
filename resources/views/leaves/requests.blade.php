@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-accent text-white">Yıllık İzinlerim</h1>

        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-accent text-white">Mevcut İzin Durumu</h2>
            <div class="flex space-x-4">
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-300">Toplam Yıllık İzin</h3>
                    <p class="text-2xl text-white">{{ $totalLeaves }}</p>
                </div>
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-300">Kullanılmış İzin</h3>
                    <p class="text-2xl text-white">{{ $usedLeaves }}</p>
                </div>
                <div class="flex-1 bg-gray-800 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-300">Kalan İzin</h3>
                    <p class="text-2xl text-white">{{ $remainingLeaves }}</p>
                </div>
            </div>
        </div>

        <!-- İzin Geçmişi -->
        <h2 class="text-2xl font-semibold mb-4 text-accent text-white">İzin Geçmişi</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <table class="min-w-full leading-normal bg-gray-900 text-white rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Başlangıç Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Bitiş Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Durum</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">İşlemler</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Gün Sayısı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $request)
                    @php
                        $leaveDays = (new \App\Http\Controllers\Admin\AdminLeaveController)->calculateWeekdays($request->start_date, $request->end_date);
                        $statusClass = $request->status === 'approved' ? 'bg-green-500' : ($request->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500');
                        $statusText = $request->status === 'approved' ? 'Onaylandı' : ($request->status === 'pending' ? 'Beklemede' : ($request->status === 'canceled' ? 'İptal Ettin' : 'Reddedildi'));
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ $statusText }}</td>
                        <td class="py-4 px-5 text-sm">
                            @if($request->status === 'approved' || $request->status === 'pending')
                                <form action="{{ route('leave.cancel', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 transition duration-200">İptal Et</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-4 px-5 text-sm">{{ $request->days_used }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-accent text-white">Yeni İzin Talebi</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md">
            @if($pendingRequest)
                <div class="bg-yellow-500 text-white p-4 rounded mb-4">
                    Bekleyen bir izin talebiniz var, yeni bir talep gönderemezsiniz.
                </div>
            @else
                <form action="{{ route('leave.request') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex space-x-4 items-center">
                        <div class="flex-1">
                            <label for="start_date" class="block text-gray-300 font-semibold">Başlangıç Tarihi</label>
                            <input type="date" name="start_date" id="start_date" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:border-accent" required>
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-gray-300 font-semibold">Bitiş Tarihi</label>
                            <input type="date" name="end_date" id="end_date" class="w-full p-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:border-accent" required>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition duration-200">İzin Talep Et</button>
                </form>
            @endif
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
