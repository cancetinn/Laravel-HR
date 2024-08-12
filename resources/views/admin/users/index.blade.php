@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h1 class="text-3xl font-bold mb-6 text-accent">Kullanıcılar</h1>
            <a href="{{ route('admin.users.create') }}" class="mb-4 inline-block bg-accent text-primary p-2 rounded hover:bg-primary hover:text-accent transition duration-200">Yeni Kullanıcı Ekle</a>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal bg-primary text-white">
                        <thead>
                            <tr>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">ID</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">İsim</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Email</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Rol</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Telefon</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Unvan</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Profil Resmi</th>
                                <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                                <td class="py-4 px-5 text-sm">{{ $user->id }}</td>
                                <td class="py-4 px-5 text-sm">{{ $user->name }}</td>
                                <td class="py-4 px-5 text-sm">{{ $user->email }}</td>
                                <td class="py-4 px-5 text-sm">{{ $user->role == 1 ? 'Admin' : 'Kullanıcı' }}</td>
                                <td class="py-4 px-5 text-sm">{{ $user->phone }}</td>
                                <td class="py-4 px-5 text-sm">{{ $user->title }}</td>
                                <td class="py-4 px-5 text-sm">
                                    @if ($user->profile_image)
                                        <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profil Resmi" class="w-10 h-10 rounded-full">
                                    @else
                                        <span>Yok</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-sm flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-accent hover:underline">Düzenle</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Sil</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
