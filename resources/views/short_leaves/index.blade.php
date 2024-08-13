@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-white">İzin Taleplerim</h1>
        <div class="bg-primary p-6 rounded-lg shadow-md">
            <table class="min-w-full leading-normal bg-gray-900 text-white rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Tarih</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Başlangıç Saati</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Bitiş Saati</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Süre (Dakika)</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">Durum</th>
                        <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-gray-300">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortLeaves as $leave)
                    @php
                        // Eğer izin bitiş saati şu anki saatten küçükse "İzin Bitti" olarak göster
                        if (\Carbon\Carbon::parse($leave->end_time)->isPast()) {
                            $statusClass = 'bg-gray-500';
                            $statusText = 'İzin Bitti';
                        } else {
                            $statusClass = $leave->status === 'approved' ? 'bg-green-500' : ($leave->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500');
                            $statusText = $leave->status === 'approved' ? 'Onaylandı' : ($leave->status === 'pending' ? 'Beklemede' : 'Reddedildi');
                        }
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->start_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->end_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ $leave->duration }}</td>
                        <td class="py-4 px-5 text-sm">
                            <div class="flex items-center">
                                <span class="rounded-full w-4 h-4 mr-2 border-2 border-white {{ $statusClass }}"></span>
                                <span>{{ $statusText }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm">
                            @if($statusText !== 'İzin Bitti')
                            <form action="{{ route('short_leaves.destroy', $leave->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 transition duration-200">Sil</button>
                            </form>
                            @else
                            <span class="text-gray-500">İşlem Yapılamaz</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
