@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-white">{{ $user->first_name }} {{ $user->last_name }} - Kısa İzin Talepleri</h1>

        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <table class="min-w-full leading-normal bg-primary text-white">
                <thead>
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Tarih</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Başlangıç Saati</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Bitiş Saati</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Süre (Dakika)</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Mazeret</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->shortLeaves as $leave)
                    @php
                        $statusClass = $leave->status === 'approved' ? 'bg-green-500' : ($leave->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500');
                        $statusText = $leave->status === 'approved' ? 'Onaylandı' : ($leave->status === 'pending' ? 'Beklemede' : 'Reddedildi');
                    @endphp
                    <tr class="border-b border-gray-700">
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->date)->translatedFormat('d F Y') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->start_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->end_time)->format('H:i') }}</td>
                        <td class="py-4 px-5 text-sm">{{ $leave->duration }}</td>
                        <td class="py-4 px-5 text-sm">
                            <button onclick="openReasonModal('{{ $leave->reason }}')" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Görüntüle</button>
                        </td>
                        <td class="py-4 px-5 text-sm">
                            <div class="flex items-center">
                                <span class="rounded-full w-4 h-4 mr-2 border-2 border-white {{ $statusClass }}"></span>
                                <span>{{ $statusText }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5 text-sm">
                            @if($leave->status === 'pending')
                                <form action="{{ route('admin.short_leaves.update', $leave->id) }}" method="POST" class="flex space-x-2">
                                    @csrf
                                    <input type="text" name="remarks" placeholder="Açıklama" class="p-2 rounded bg-gray-800 text-white">
                                    <button type="submit" name="action" value="approve" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition duration-200">Onayla</button>
                                    <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Reddet</button>
                                </form>
                            @else
                                <span class="text-gray-500">İşlem Yapıldı</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-semibold mb-4 text-white">Güncelleme Logları</h2>
        <div class="bg-primary p-6 rounded-lg shadow-md">
            @if($logs->isEmpty())
                <p class="text-white">Henüz bir güncelleme yapılmamış.</p>
            @else
                <ul class="list-disc pl-5">
                    @foreach($logs as $log)
                        <li class="text-white">{{ $log->admin->name }} tarafından {{ $log->action === 'approve' ? 'Onaylandı' : 'Reddedildi' }} - {{ $log->remarks }} ({{ $log->created_at->translatedFormat('d F Y H:i') }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<!-- Reason Modal -->
<div id="reasonModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-black opacity-50 absolute inset-0"></div>
        <div class="bg-white p-6 rounded-lg shadow-lg z-50 max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-4">Mazeret</h2>
            <p id="reasonText" class="text-gray-800"></p>
            <div class="mt-6">
                <button onclick="closeReasonModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openReasonModal(reason) {
        document.getElementById('reasonText').textContent = reason;
        document.getElementById('reasonModal').classList.remove('hidden');
    }

    function closeReasonModal() {
        document.getElementById('reasonModal').classList.add('hidden');
    }
</script>
@endsection
