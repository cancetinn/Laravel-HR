@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Belgelerim</h1>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <table class="min-w-full bg-white text-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Belge Adı</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Belge Türü</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Yüklenme Tarihi</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ $document->document_name }}</td>
                        <td class="py-4 px-5 text-sm">{{ $document->document_type }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($document->uploaded_at)->format('d.m.Y') }}</td>
                        <td class="py-4 px-5 text-sm flex space-x-2">
                            <button onclick="openModal('{{ asset('storage/documents/' . $document->document_name) }}')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Görüntüle</button>
                            <a target="_blank" href="{{ asset('storage/documents/' . $document->document_name) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">İndir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="documentModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-gray-800 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Belge Görüntüleyici</h2>
                <div class="relative">
                    <embed id="documentViewer" src="" type="application/pdf" class="w-full h-96 border border-gray-300 rounded-md" />
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">Kapat</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(documentUrl) {
        document.getElementById('documentViewer').src = documentUrl;
        document.getElementById('documentModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('documentViewer').src = '';
        document.getElementById('documentModal').classList.add('hidden');
    }
</script>
@endsection
