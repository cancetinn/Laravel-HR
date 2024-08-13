@extends('layouts.app')

@section('content')
<section class="w-full p-4 bg-gray-50 md:p-8 min-h-screen">
    <div class=" flex justify-end items-center mb-4 align-right border-b-2 border-blue-100">
        <div class="flex items-center space-x-4 mb-3">
            <div class="flex items-center space-x-3">
                <img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="w-10 h-10 object-cover rounded-full border-2 border-gray-300" />
                <p class="text-sm font-bold text-gray-900">Merhaba, {{ Auth::user()->first_name }}</p>
            </div>
            <button class="relative border-2 border-gray-200 rounded-full p-2.5">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9962 2.51419C7.56192 2.51419 5.63525 6.52943 5.63525 9.18371C5.63525 11.1675 5.92287 10.5837 4.82477 13.0037C3.48382 16.4523 8.8762 17.8618 11.9962 17.8618C15.1152 17.8618 20.5076 16.4523 19.1676 13.0037C18.0695 10.5837 18.3572 11.1675 18.3572 9.18371C18.3572 6.52943 16.4295 2.51419 11.9962 2.51419Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.306 20.5122C13.0117 21.9579 10.9927 21.975 9.68604 20.5122" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
            </button>
            <button class="border-2 border-gray-200 rounded-full p-2.5">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 18L18 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 6L18 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8 12H16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>


    <div>
    <h2 class="text-base font-bold">Güncel İzin Verilerim</h2>
            </div>
    
    <div class="flex flex-col md:flex-row justify-between mt-4 space-y-3 mb-8 md:space-x-4 md:space-y-0 md:mb-14">
        <div class="p-5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-xl w-full shadow-md">
            <p class="text-base font-bold text-white">Kalan Yıllık İzin</p>
            <p class="text-2xl font-semibold text-white">
                {{ \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('total_leaves') - \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('used_leaves') }}
            </p>
        </div>
        <div class="p-5 bg-gradient-to-r from-green-400 to-teal-400 rounded-xl w-full shadow-md">
            <p class="text-base font-bold text-white">Kullanılan Yıllık İzin</p>
            <p class="text-2xl font-semibold text-white">{{ \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('used_leaves') }}</p>
        </div>
    </div>

    <div>
                <h2 class="leading-tight text-base font-bold">Güncel İzinli Kişiler</h2>
            </div>
    <div class="container mx-auto  w-full">
            <div class="-mx-4 sm:-mx-8 px-4 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Ad - Soyad</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">İzin Türü</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tarih & Saat Aralığı</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeShortLeaves as $leave)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="{{ $leave->user->profile_image_url }}" alt="{{ $leave->user->first_name }} {{ $leave->user->last_name }}" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Kısa İzin</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($leave->start_time)->translatedFormat('j F Y H:i') }} - {{ \Carbon\Carbon::parse($leave->end_time)->translatedFormat('H:i') }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Aktif</span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach

                            @foreach($activeAnnualLeaves as $leave)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10">
                                            <img class="w-full h-full rounded-full" src="{{ $leave->user->profile_image_url }}" alt="{{ $leave->user->first_name }} {{ $leave->user->last_name }}" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Yıllık İzin</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d F Y') }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Aktif</span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</section>
@endsection
