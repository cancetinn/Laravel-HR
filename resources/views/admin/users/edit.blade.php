@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h1 class="text-3xl font-bold mb-6 text-accent">Kullanıcıyı Düzenle</h1>
            <div class="bg-primary shadow-md rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block text-sm font-medium text-white">Unvan</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $user->title) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-white">Telefon</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
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
                        <button type="submit" class="bg-accent text-primary p-2 rounded hover:bg-primary hover:text-accent transition duration-200">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
