@extends('layouts.app') @section('content')
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
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
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
                    <h3>Günlük İzin</h3>
                </div>
                <div class="buttonArea">
                    <a href="{{ route('short_leaves.create') }}">
                        <button type="button" class="btn rounded-pill btn-primary">
                            <span class="tf-icons bx bx-plus-medical bx-18px me-2"></span>Talep Oluştur
                        </button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Başlangıç Saati</th>
                                <th>Bitiş Saati</th>
                                <th>Süre (Dakika)</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shortLeaves as $leave)
                            @php
                                $statusClass = $leave->status === 'approved' ? 'bg-label-success' :
                                               ($leave->status === 'pending' ? 'bg-label-warning' : 'bg-label-danger');
                                $statusText = $leave->status === 'approved' ? 'Onaylandı' :
                                              ($leave->status === 'pending' ? 'Beklemede' : 'Reddedildi');
                            @endphp
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                                <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->date)->translatedFormat('d F Y') }}</td>
                                <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->start_time)->format('H:i') }}</td>
                                <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($leave->end_time)->format('H:i') }}</td>
                                <td class="py-4 px-5 text-sm">
                                    <span class="badge badge-center rounded-pill bg-info">{{ $leave->duration }}</span>
                                </td>
                                <td class="py-4 px-5 text-sm">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $statusClass }}">{{ $statusText }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-sm">
                                    @if($leave->status === 'pending')
                                    <button type="button" class="btn rounded-pill btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelLeaveModal" data-id="{{ $leave->id }}">
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

            <!-- İzin İptal Etme Modali -->
            <div class="modal fade" id="cancelLeaveModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">İzni İptal Et</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bu izni iptal etmek istediğinizden emin misiniz?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hayır</button>
                            <form id="cancelForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Evet, İptal Et</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cancelModal = document.getElementById('cancelLeaveModal');
            let cancelForm = document.getElementById('cancelForm');
            
            cancelModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let leaveId = button.getAttribute('data-id');
                let actionUrl = `/short-leaves/${leaveId}`;
                cancelForm.setAttribute('action', actionUrl);
            });
        });
    </script>
@endsection