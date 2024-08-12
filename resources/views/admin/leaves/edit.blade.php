@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-accent">{{ $user->first_name }} {{ $user->last_name }} - Detaylar</h1>

        <!-- Kullanıcı Bilgileri ve Güncelleme Formu -->
        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <form action="{{ route('admin.annual.leave.update', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex space-x-4 items-center">
                    <div class="flex-1">
                        <label for="first_name" class="block text-white font-semibold">Ad</label>
                        <input type="text" id="first_name" value="{{ $user->first_name }}" class="w-full p-2 rounded bg-gray-800 text-white" disabled>
                    </div>
                    <div class="flex-1">
                        <label for="last_name" class="block text-white font-semibold">Soyad</label>
                        <input type="text" id="last_name" value="{{ $user->last_name }}" class="w-full p-2 rounded bg-gray-800 text-white" disabled>
                    </div>
                </div>

                <div class="flex space-x-4 items-center">
                    <div class="flex-1">
                        <label for="email" class="block text-white font-semibold">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}" class="w-full p-2 rounded bg-gray-800 text-white" disabled>
                    </div>
                    <div class="flex-1">
                        <label for="phone" class="block text-white font-semibold">Telefon</label>
                        <input type="text" id="phone" value="{{ $user->phone }}" class="w-full p-2 rounded bg-gray-800 text-white" disabled>
                    </div>
                </div>

                <div>
                    <label for="profile_image" class="block text-white font-semibold">Profil Resmi</label>
                    @if($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profil Resmi" class="w-20 h-20 rounded-full mb-4">
                    @else
                        <span class="text-white">Yok</span>
                    @endif
                </div>

                <div>
                    <label for="total_leaves" class="block text-white font-semibold">Toplam Yıllık İzin</label>
                    <input type="number" name="total_leaves" id="total_leaves" value="{{ $totalLeaves }}" min="0" class="w-20 p-2 rounded bg-gray-800 text-white">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Güncelle</button>
                </div>
            </form>
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
                    @foreach($user->leaveRequests as $request)
                    @php
                        $leaveDays = \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1;
                    @endphp
                    <tr class="border-b border-gray-700">
                        <td class="py-4 px-5 text-sm">{{ $request->start_date }}</td>
                        <td class="py-4 px-5 text-sm">{{ $request->end_date }}</td>
                        <td class="py-4 px-5 text-sm">{{ $request->status }}</td>
                        <td class="py-4 px-5 text-sm">{{ $leaveDays }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Güncelleme Logları -->
        <h2 class="text-2xl font-semibold mb-4 text-accent">Güncelleme Logları</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md">
            @if($logs->isEmpty())
                <p class="text-white">Henüz bir güncelleme yapılmamış.</p>
            @else
                <ul class="list-disc pl-5">
                    @foreach($logs as $log)
                        <li class="text-white">{{ $log->updated_by }} tarafından {{ $log->previous_total_leaves }} izinden {{ $log->new_total_leaves }} izne güncellendi. ({{ $log->created_at->format('d.m.Y H:i') }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
