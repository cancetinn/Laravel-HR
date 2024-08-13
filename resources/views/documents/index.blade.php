@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold text-accent mb-6">Belgelerim</h1>
        <div class="bg-primary shadow-md rounded-lg p-6">
            <table class="min-w-full bg-primary text-white">
                <thead>
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Belge Adı</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Belge Türü</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Yüklenme Tarihi</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr class="border-b border-gray-700 hover:bg-accent transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ $document->document_name }}</td> <!-- original_name yerine document_name -->
                        <td class="py-4 px-5 text-sm">{{ $document->document_type }}</td>
                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($document->uploaded_at)->format('d.m.Y') }}</td>
                        <td class="py-4 px-5 text-sm">
                            <button onclick="openModal('{{ asset('storage/documents/' . $document->document_name) }}')" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Görüntüle</button>
                            <a href="{{ asset('storage/documents/' . $document->document_name) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition duration-200">İndir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="documentModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white p-4">
                <div class="mt-2">
                    <embed id="documentViewer" src="" type="application/pdf" class="w-full h-96" />
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
