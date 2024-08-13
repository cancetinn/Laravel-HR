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
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Yeni Kısa İzin Talebi Oluştur</h1>

        <!-- İzin Oluşturma Formu -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <form id="requestForm" action="{{ route('short_leaves.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tarih</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Başlangıç Saati</label>
                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">Bitiş Saati</label>
                        <input type="time" name="end_time" id="end_time" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Mazeret/Açıklama</label>
                        <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md text-gray-800 focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="button" id="submitRequestButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">İzin Talebi Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modern Popup Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Emin misiniz?</h2>
        <p class="text-gray-700 mb-6">Bu izin talebini göndermek istediğinizden emin misiniz?</p>
        <div class="flex justify-end space-x-4">
            <button id="cancelButton" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition duration-200">Hayır</button>
            <button id="confirmButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Evet</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitRequestButton').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('confirmationModal').classList.remove('hidden');
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('confirmationModal').classList.add('hidden');
    });

    document.getElementById('confirmButton').addEventListener('click', function() {
        document.getElementById('requestForm').submit();
    });
</script>
@endsection
