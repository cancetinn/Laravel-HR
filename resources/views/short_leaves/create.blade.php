@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-accent">Yeni Kısa İzin Talebi Oluştur</h1>

        <!-- İzin Oluşturma Formu -->
        <div class="bg-primary p-6 rounded-lg shadow-md mb-8">
            <form action="{{ route('short_leaves.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-white">Tarih</label>
                        <input type="date" name="date" id="date" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                    </div>
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-white">Başlangıç Saati</label>
                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-white">Bitiş Saati</label>
                        <input type="time" name="end_time" id="end_time" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label for="reason" class="block text-sm font-medium text-white">Mazeret/Açıklama</label>
                        <textarea name="reason" id="reason" rows="4" class="mt-1 block w-full bg-gray-700 border-gray-600 rounded-md text-white" required></textarea>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">İzin Talebi Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
