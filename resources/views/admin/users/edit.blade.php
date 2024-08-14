@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h1 class="text-3xl font-bold mb-6 text-white">Kullanıcıyı Düzenle</h1>
            <div class="bg-primary shadow-md rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kullanıcı bilgileri formu -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-white">İsim</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-white">Soyisim</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-white">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-white">Rol</label>
                            <select name="role" id="role" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                                <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>Kullanıcı</option>
                                <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Grafik Tasarım</option>
                                <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>İçerik Ekibi</option>
                            </select>
                        </div>
                        <div>
                            <label for="department" class="block text-sm font-medium text-white">Departman</label>
                            <select name="department" id="department" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                                <option value="Grafik Tasarım" {{ $user->department == 'Grafik Tasarım' ? 'selected' : '' }}>Grafik Tasarım</option>
                                <option value="Yazılım" {{ $user->department == 'Yazılım' ? 'selected' : '' }}>Yazılım</option>
                                <option value="İçerik" {{ $user->department == 'İçerik' ? 'selected' : '' }}>İçerik</option>
                            </select>
                        </div>
                        <div>
                            <label for="joining_date" class="block text-sm font-medium text-white">İşe Giriş Tarihi</label>
                            <input type="date" name="joining_date" id="joining_date" value="{{ old('joining_date', $user->joining_date) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="title" class="block text-sm font-medium text-white">Unvan</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $user->title) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-white">Telefon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-white">Yeni Şifre</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-white">Yeni Şifreyi Onayla</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label for="profile_image" class="block text-sm font-medium text-white">Profil Resmi</label>
                            <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                            @if ($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profil Resmi" class="mt-2 w-20 h-20 rounded-full">
                            @endif
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-accent text-primary p-2 rounded hover:bg-primary hover:text-white transition duration-200">Güncelle</button>
                    </div>
                </form>
            </div>

            <!-- Belge Yükleme Formu -->
            <!-- (Bu kısım mevcut kodla aynı kalıyor) -->
            <div class="bg-primary shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-2xl font-bold mb-4 text-white">Belge Yükle</h2>
                <form action="{{ route('admin.upload.document', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="document" class="block text-sm font-medium text-white">Belge Seç</label>
                            <input type="file" name="document" id="document" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="document_type" class="block text-sm font-medium text-white">Belge Türü</label>
                            <select name="document_type" id="document_type" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                                <option value="contract">Sözleşme</option>
                                <option value="leave">İzin Belgesi</option>
                                <!-- Diğer belge türleri -->
                            </select>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Belge Yükle</button>
                    </div>
                </form>
            </div>

            <!-- Kullanıcı Belgeleri Listesi -->
            <!-- (Bu kısım mevcut kodla aynı kalıyor) -->
            <div class="bg-primary shadow-md rounded-lg p-6 mt-8">
                <h2 class="text-2xl font-bold mb-4 text-white">Kullanıcı Belgeleri</h2>
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
                            <td class="py-4 px-5 text-sm">{{ $document->document_name }}</td>
                            <td class="py-4 px-5 text-sm">{{ $document->document_type }}</td>
                            <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($document->uploaded_at)->format('d.m.Y') }}</td>
                            <td class="py-4 px-5 text-sm flex space-x-2">
                                <!-- Görüntüle Butonu -->
                                <button onclick="openModal('{{ asset('storage/documents/' . $document->document_name) }}')" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Görüntüle</button>
                                <!-- İndir Butonu -->
                                <a href="{{ asset('storage/documents/' . $document->document_name) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition duration-200">İndir</a>
                                <!-- Sil Butonu -->
                                <form action="{{ route('admin.delete.document', $document->id) }}" method="POST" onsubmit="return confirm('Bu belgeyi silmek istediğinize emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Sil</button>
                                </form>
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
