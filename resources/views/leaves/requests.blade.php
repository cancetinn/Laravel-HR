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
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Yıllık İzinlerim</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-gray-700">Mevcut İzin Durumu</h2>
            <div class="flex space-x-4">
                <div class="flex-1 bg-blue-50 p-3 rounded-lg shadow-inner">
                    <h3 class="text-base font-semibold text-gray-600">Toplam Yıllık İzin</h3>
                    <p class="text-xl text-blue-800">{{ $totalLeaves }}</p>
                </div>
                <div class="flex-1 bg-blue-50 p-3 rounded-lg shadow-inner">
                    <h3 class="text-base font-semibold text-gray-600">Kullanılmış İzin</h3>
                    <p class="text-xl text-blue-800">{{ $usedLeaves }}</p>
                </div>
                <div class="flex-1 bg-blue-50 p-3 rounded-lg shadow-inner">
                    <h3 class="text-base font-semibold text-gray-600">Kalan İzin</h3>
                    <p class="text-xl text-blue-800">{{ $remainingLeaves }}</p>
                </div>
            </div>
        </div>

        <!-- İzin Geçmişi -->
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">İzin Geçmişi</h2>
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <table class="min-w-full leading-normal bg-white text-gray-800 rounded-lg overflow-hidden shadow-md">
                <thead>
                    <tr>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Başlangıç Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Bitiş Tarihi</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Durum</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">İşlemler</th>
                        <th class="py-3 px-5 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-700">Gün Sayısı</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveRequests as $request)
                    @php
                        $leaveDays = (new \App\Http\Controllers\Admin\AdminLeaveController)->calculateWeekdays($request->start_date, $request->end_date);
                        $statusClass = $request->status === 'approved' ? 'bg-green-100 text-green-800' : ($request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                        $statusText = $request->status === 'approved' ? 'Onaylandı' : ($request->status === 'pending' ? 'Beklemede' : ($request->status === 'canceled' ? 'İptal Ettin' : 'Reddedildi'));
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm font-semibold rounded-lg {{ $statusClass }}">{{ $statusText }}</td>
                        <td class="py-4 px-5 text-sm">
                            @if($request->status === 'approved' || $request->status === 'pending')
                                <button type="button" class="bg-red-500 text-white px-3 py-1.5 rounded-lg shadow hover:bg-red-600 transition duration-200 cancel-button" data-id="{{ $request->id }}">İptal Et</button>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-sm">{{ $request->days_used }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Yeni İzin Talebi</h2>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            @if($pendingRequest)
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow-inner">
                    Bekleyen bir izin talebiniz var, yeni bir talep gönderemezsiniz.
                </div>
            @else
                <form id="leaveRequestForm" action="{{ route('leave.request') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex space-x-4 items-center">
                        <div class="flex-1">
                            <label for="start_date" class="block text-gray-700 font-semibold">Başlangıç Tarihi</label>
                            <input type="date" name="start_date" id="start_date" class="w-full p-3 rounded-lg bg-gray-100 text-gray-700 border border-gray-300 focus:outline-none focus:border-blue-400 shadow-inner" required>
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-gray-700 font-semibold">Bitiş Tarihi</label>
                            <input type="date" name="end_date" id="end_date" class="w-full p-3 rounded-lg bg-gray-100 text-gray-700 border border-gray-300 focus:outline-none focus:border-blue-400 shadow-inner" required>
                        </div>
                    </div>
                    <button type="button" id="submitRequestButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-200">İzin Talep Et</button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4 shadow-inner">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4 shadow-inner">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Emin misiniz?</h2>
        <p class="text-gray-700 mb-6">Bu işlemi gerçekleştirmek istediğinizden emin misiniz?</p>
        <div class="flex justify-end space-x-4">
            <button id="cancelAction" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Hayır</button>
            <button id="confirmAction" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">Evet</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const submitRequestButton = document.getElementById('submitRequestButton');
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmActionButton = document.getElementById('confirmAction');
    const cancelActionButton = document.getElementById('cancelAction');

    if (submitRequestButton) {
        submitRequestButton.addEventListener('click', function() {
            openConfirmationModal('leaveRequestForm');
        });
    }

    document.querySelectorAll('.cancel-button').forEach(function(button) {
        button.addEventListener('click', function() {
            openConfirmationModal(null, this.getAttribute('data-id'));
        });
    });

    function openConfirmationModal(formId = null, cancelId = null) {
        confirmationModal.classList.remove('hidden');

        confirmActionButton.onclick = function() {
            if (formId) {
                document.getElementById(formId).submit();
            } else if (cancelId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/leave/cancel/${cancelId}`;
                form.innerHTML = `@csrf @method('PUT')`;
                document.body.appendChild(form);
                form.submit();
            }
            closeModal();
        };

        cancelActionButton.onclick = closeModal;
    }

    function closeModal() {
        confirmationModal.classList.add('hidden');
    }
});
</script>
@endsection
