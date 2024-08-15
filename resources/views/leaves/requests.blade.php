@extends('layouts.app')

@section('content')
<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                    <i class="bx bx-search bx-md"></i>
                    <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2" placeholder="Arama" aria-label="Arama" />
                </div>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ Auth::user()->profile_image_url }}" alt class="w-px-40 h-auto rounded-circle" />
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->profile_image_url }}" alt class="w-px-40 h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                                        <small class="text-muted">{{ Auth::user()->title }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user bx-md me-3"></i><span>Profilim</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="bx bx-power-off bx-md me-3"></i><span>Çıkış Yap</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="heading d-flex justify-content-between">
                <div class="titleArea">
                    <h3>Yıllık İzin</h3>
                </div>
            </div>

            <div class="row g-6 mb-6">
                <div class="col-md-6 col-xl-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-white">Toplam İzin</h5>
                            <h3 class="card-text text-white">{{ $totalLeaves }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-white">Kullanılmış İzin</h5>
                            <h3 class="card-text text-white">{{ $usedLeaves }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card bg-success text-white">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-white">Kalan İzin</h5>
                            <h3 class="card-text text-white">{{ $remainingLeaves }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="container mx-auto px-4 sm:px-8">
                <div class="py-8">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-700">İzin Geçmişi</h2>
                    <div class="card">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Başlangıç Tarihi</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Gün Sayısı</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveRequests as $request)
                                    @php
                                        $leaveDays = (new \App\Http\Controllers\LeaveController)->calculateWeekdays(\Carbon\Carbon::parse($request->start_date), \Carbon\Carbon::parse($request->end_date));
                                        $statusClass = match($request->status) {
                                            'approved' => 'bg-label-success',
                                            'pending' => 'bg-label-warning',
                                            default => 'bg-label-danger'
                                        };
                                        $statusText = match($request->status) {
                                            'approved' => 'Onaylandı',
                                            'pending' => 'Beklemede',
                                            'canceled' => 'İptal Ettin',
                                            default => 'Reddedildi'
                                        };
                                    @endphp
                                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->start_date)->translatedFormat('d F Y') }}</td>
                                        <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($request->end_date)->translatedFormat('d F Y') }}</td>
                                        <td class="py-4 px-5 text-sm">
                                            <span class="badge badge-center rounded-pill bg-info">{{ $leaveDays }}</span>
                                        </td>
                                        <td class="py-4 px-5 text-sm">
                                            <div class="flex items-center">
                                                <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $statusClass }}">{{ $statusText }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-5 text-sm">
                                            @if($request->status === 'pending')
                                                <form id="cancel-form-{{ $request->id }}" action="{{ route('leave.cancel', $request->id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <button type="button" class="btn rounded-pill btn-outline-danger cancel-button" data-id="{{ $request->id }}">
                                                    İptal Et
                                                </button>
                                            @else
                                                <span class="text-gray-500">İşlem Yapılamaz</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <hr class="m-4">
                    <div class="heading mb-4 text-center">
                        <h2 class="text-2xl font-semibold text-gray-700">Yeni İzin Talebi</h2>
                    </div>
                    <div class="col-xl-8 mx-auto">
                        <div class="card mb-6 shadow-sm">
                            <div class="card-body">
                                @if($pendingRequest)
                                    <div class="alert alert-warning" role="alert">Bekleyen bir izin talebiniz var, yeni bir talep gönderemezsiniz.</div>
                                @else
                                    <form id="leaveRequestForm" action="{{ route('leave.request') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="start_date" class="form-label text-gray-700 font-semibold">Başlangıç Tarihi</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control bg-gray-100 text-gray-700 border border-gray-300 rounded-lg shadow-inner" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="end_date" class="form-label text-gray-700 font-semibold">Bitiş Tarihi</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control bg-gray-100 text-gray-700 border border-gray-300 rounded-lg shadow-inner" required>
                                        </div>
                                        <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                                            <label class="form-check-label" for="defaultCheck1">
                                                İzin prosedürünü onaylıyorum.
                                            </label>
                                        </div>
                                        <button type="button" id="submitRequestButton" class="btn btn-primary w-100">İzin Talep Et</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="leaveConfirmationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">İzin Talebini Onayla</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bu izin talebini göndermek istediğinize emin misiniz?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hayır</button>
                            <button type="button" class="btn btn-success" id="confirmSubmit">Evet, Gönder</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancelLeaveModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">İzin Talebini İptal Et</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bu izin talebini iptal etmek istediğinize emin misiniz?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hayır</button>
                            <button type="button" class="btn btn-danger" id="confirmCancel">Evet, İptal Et</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var submitRequestButton = document.getElementById('submitRequestButton');
                    var confirmSubmit = document.getElementById('confirmSubmit');
                    var leaveConfirmationModal = new bootstrap.Modal(document.getElementById('leaveConfirmationModal'));
                    var checkbox = document.getElementById('defaultCheck1');

                    if (submitRequestButton) {
                        submitRequestButton.addEventListener('click', function() {
                            if (checkbox.checked) {
                                leaveConfirmationModal.show();
                            } else {
                                alert('Lütfen izin prosedürünü onaylayın.');
                            }
                        });
                    }

                    if (confirmSubmit) {
                        confirmSubmit.addEventListener('click', function() {
                            document.getElementById('leaveRequestForm').submit();
                        });
                    }

                    document.querySelectorAll('.cancel-button').forEach(button => {
                        button.addEventListener('click', function() {
                            var requestId = this.getAttribute('data-id');
                            var cancelLeaveModal = new bootstrap.Modal(document.getElementById('cancelLeaveModal'));
                            cancelLeaveModal.show();

                            var confirmCancel = document.getElementById('confirmCancel');
                            if (confirmCancel) {
                                confirmCancel.addEventListener('click', function() {
                                    document.getElementById(`cancel-form-${requestId}`).submit();
                                }, { once: true });
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>
@endsection
