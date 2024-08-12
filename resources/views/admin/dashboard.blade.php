@extends('layouts.admin')

@section('content')
<div class="container mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-100">Admin Paneli</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Yeni Kullanıcı Ekle</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-2">Toplam Kullanıcılar</h2>
            <p class="text-gray-400">Toplam: {{ \App\Models\User::count() }}</p>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-2">Admin Kullanıcılar</h2>
            <p class="text-gray-400">Toplam: {{ \App\Models\User::where('role', 1)->count() }}</p>
        </div>
        <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-2">Normal Kullanıcılar</h2>
            <p class="text-gray-400">Toplam: {{ \App\Models\User::where('role', 0)->count() }}</p>
        </div>
    </div>
</div>
@endsection
