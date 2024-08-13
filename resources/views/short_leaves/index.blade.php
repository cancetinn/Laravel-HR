@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
    <div class="flex justify-end items-center mb-4 align-right border-b-2 border-blue-100">
            <div class="flex items-center space-x-4 mb-3">
                <div class="flex items-center space-x-3">
                    <img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="w-10 h-10 object-cover rounded-full border-2 border-gray-300" />
                    <p class="text-sm font-bold text-gray-900">Merhaba, {{ Auth::user()->first_name }}</p>
                </div>
                <button class="relative border-2 border-gray-200 rounded-full p-2.5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9962 2.51419C7.56192 2.51419 5.63525 6.52943 5.63525 9.18371C5.63525 11.1675 5.92287 10.5837 4.82477 13.0037C3.48382 16.4523 8.8762 17.8618 11.9962 17.8618C15.1152 17.8618 20.5076 16.4523 19.1676 13.0037C18.0695 10.5837 18.3572 11.1675 18.3572 9.18371C18.3572 6.52943 16.4295 2.51419 11.9962 2.51419Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M14.306 20.5122C13.0117 21.9579 10.9927 21.975 9.68604 20.5122" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
                </button>
                <button class="border-2 border-gray-200 rounded-full p-2.5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 18L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6 6L18 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M8 12H16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">İzin Taleplerim</h1>
            <a href="{{ route('short_leaves.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-200">
                Kısa İzin Talebi Oluştur
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full leading-normal bg-white text-gray-800 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Tarih</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Başlangıç Saati</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Bitiş Saati</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Süre (Dakika)</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Durum</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortLeaves as $leave)
                    @php
                        if (\Carbon\Carbon::parse($leave->end_time)->isPast()) {
                            $statusClass = 'bg-gray-500';
                            $statusText = 'İzin Bitti';
                        } else {
                            $statusClass = $leave->status === 'approved' ? 'bg-green-100 text-green-800' : ($leave->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                            $statusText = $leave->status === 'approved' ? 'Onaylandı' : ($leave->status === 'pending' ? 'Beklemede' : 'Reddedildi');
                        }
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->start_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->end_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ $leave->duration }}</td>
                        <td class="py-4 px-5 text-sm">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $statusClass }}"></span>
                                <span>{{ $statusText }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm">
                            @if($statusText !== 'İzin Bitti')
                            <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition duration-200" onclick="confirmDelete('{{ route('short_leaves.destroy', $leave->id) }}')">Sil</button>
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

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Emin misiniz?</h2>
        <p class="mb-4 text-gray-600">Bu işlemi yapmak istediğinizden emin misiniz?</p>
        <div class="flex justify-end space-x-4">
            <button id="cancelButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-400 transition duration-200">Hayır</button>
            <form id="confirmForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition duration-200">Evet</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(actionUrl) {
        document.getElementById('confirmForm').action = actionUrl;
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('confirmationModal').classList.add('hidden');
    });
</script>
@endsection
