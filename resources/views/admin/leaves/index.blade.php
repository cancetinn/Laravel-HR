@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Kullanıcıların Yıllık İzin Durumları</h1>
            <div class="flex items-center space-x-4">
                <input type="text" id="search" placeholder="İsim veya soyisim ara..." class="p-2 rounded bg-gray-800 text-white">
                <a href="{{ route('admin.leaves.export') }}" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition duration-200">Excel İndir</a>
            </div>
        </div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                <table id="users-table" class="min-w-full leading-normal bg-primary text-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white cursor-pointer" onclick="sortTable(0)">Kullanıcı</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white cursor-pointer" onclick="sortTable(1)">Toplam Yıllık İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white cursor-pointer" onclick="sortTable(2)">Kullanılmış İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white cursor-pointer" onclick="sortTable(3)">Kalan İzin</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white cursor-pointer" onclick="sortTable(4)">Son İzin Tarihi</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">Durum</th>
                            <th class="py-3 px-5 border-b-2 border-accent text-left text-sm font-semibold text-white">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                        @foreach($users as $user)
                        @php
                            $annualLeave = $user->annualLeaves->where('year', now()->year)->first();
                            $totalLeaves = $annualLeave ? $annualLeave->total_leaves : 0;
                            $usedLeaves = $annualLeave ? $annualLeave->used_leaves : 0;
                            $remainingLeaves = $totalLeaves - $usedLeaves;

                            $lastApprovedLeave = $user->leaveRequests()->where('status', 'approved')->orderBy('end_date', 'desc')->first();
                        @endphp
                        <tr class="border-b border-gray-700 hover:bg-accent hover:text-primary transition duration-200">
                            <td class="py-4 px-5 text-sm">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-4 px-5 text-sm">{{ $totalLeaves }}</td>
                            <td class="py-4 px-5 text-sm">{{ $usedLeaves }}</td>
                            <td class="py-4 px-5 text-sm">{{ $remainingLeaves }}</td>
                            <td class="py-4 px-5 text-sm">
                                @if($lastApprovedLeave)
                                    <span>{{ \Carbon\Carbon::parse($lastApprovedLeave->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($lastApprovedLeave->end_date)->translatedFormat('d F Y') }}</span>
                                @else
                                    <span>Henüz onaylanmış izin yok</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-sm">
                                @if($lastApprovedLeave && $lastApprovedLeave->status === 'approved')
                                    <div class="flex items-center">
                                        <span class="bg-green-500 rounded-full w-4 h-4 mr-2 border-2 border-white animate-pulse"></span>
                                        <span>Onaylandı</span>
                                    </div>
                                @else
                                    <span>Henüz onaylanmış izin yok</span>
                                @endif
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

<script>
    document.getElementById('search').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#users-table tbody tr');
        
        tableRows.forEach(row => {
            const userName = row.cells[0].textContent.toLowerCase();
            if (userName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function sortTable(columnIndex) {
        const table = document.getElementById('users-table');
        const rows = Array.from(table.rows).slice(1);
        const isAscending = table.getAttribute('data-sort-direction') === 'asc';
        const direction = isAscending ? 1 : -1;

        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();

            if (!isNaN(aText) && !isNaN(bText)) {
                return direction * (parseFloat(aText) - parseFloat(bText));
            }

            return direction * aText.localeCompare(bText);
        });

        rows.forEach(row => table.tBodies[0].appendChild(row));

        table.setAttribute('data-sort-direction', isAscending ? 'desc' : 'asc');
    }
</script>
@endsection
