@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h1 class="text-3xl font-bold mb-6 text-accent">Kullanıcıların Yıllık İzin Durumları</h1>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal bg-primary text-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Kullanıcı</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Toplam Yıllık İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Kullanılmış İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Kalan İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">İzin Talepleri</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        @php
                            $annualLeave = $user->annualLeaves->where('year', now()->year)->first();
                            $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
                            $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
                            $remainingLeaves = $totalLeaves - $usedLeaves;
                        @endphp
                        <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                            <td class="py-4 px-5 text-sm">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-4 px-5 text-sm">{{ $totalLeaves }}</td>
                            <td class="py-4 px-5 text-sm">{{ $usedLeaves }}</td>
                            <td class="py-4 px-5 text-sm">{{ $remainingLeaves }}</td>
                            <td class="py-4 px-5 text-sm">
                                @foreach($user->leaveRequests as $request)
                                <div class="mb-2">
                                    <span>{{ $request->start_date }} - {{ $request->end_date }}</span>
                                    <span>Durum: {{ $request->status }}</span>
                                    @if($request->status === 'pending')
                                    <form action="{{ route('admin.leave.request.update', $request->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button name="action" value="approve" class="text-green-400 hover:underline">Onayla</button>
                                        <button name="action" value="reject" class="text-red-400 hover:underline">Reddet</button>
                                    </form>
                                    @endif
                                </div>
                                @endforeach
                            </td>
                            <td class="py-4 px-5 text-sm">
                                <a href="{{ route('admin.leaves.edit', $user->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">İncele</a>
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
