@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h1 class="text-3xl font-bold mb-6 text-white">Yeni Kullanıcı Ekle</h1>
            <div class="bg-primary shadow-md rounded-lg p-6">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-white">İsim</label>
                            <input type="text" name="first_name" id="first_name" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-white">Soyisim</label>
                            <input type="text" name="last_name" id="last_name" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-white">Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-white">Şifre</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-white">Şifreyi Onayla</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-white">Rol</label>
                            <select name="role" id="role" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                                <option value="0">Kullanıcı</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label for="title" class="block text-sm font-medium text-white">Unvan</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-white">Telefon</label>
                            <input type="text" name="phone" id="phone" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label for="profile_image" class="block text-sm font-medium text-white">Profil Resmi</label>
                            <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white">
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-accent text-primary p-2 rounded hover:bg-primary hover:text-white transition duration-200">Kullanıcı Oluştur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
