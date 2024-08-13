@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold text-white mb-6">Kullanıcılar</h1>
        <div class="bg-primary shadow-md rounded-lg p-6">
            <table class="min-w-full bg-primary text-white">
                <thead>
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Ad Soyad</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Email</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">İşlemler</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold">Bildirimler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="border-b border-gray-700 hover:bg-accent transition duration-200">
                        <td class="py-4 px-5 text-sm">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="py-4 px-5 text-sm">{{ $user->email }}</td>
                        <td class="py-4 px-5 text-sm">
                            <a href="{{ route('admin.short_leaves.show', $user->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">İzin Taleplerini Gör</a>
                        </td>
                        <td class="py-4 px-5 text-sm">
                            @if($user->short_leaves_count > 0)
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">
                                    {{ $user->short_leaves_count }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
