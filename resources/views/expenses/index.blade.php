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
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
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
                    <h3>Masraflar</h3>
                </div>
                <div class="buttonArea">
                    <a href="{{ route('expenses.create') }}">
                        <button type="button" class="btn rounded-pill btn-primary">
                            <span class="tf-icons bx bx-plus-medical bx-18px me-2"></span>Talep Oluştur
                        </button>
                    </a>
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
            <div class="card">
                <div class="table-responsive text-nowrap">
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Masraf Tipi</th>
                                <th>Açıklama</th>
                                <th>Belge/Fiş</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>Ödeme Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            @php
                                $statusClass = $expense->status === 'approved' ? 'bg-label-success' :
                                               ($expense->status === 'pending' ? 'bg-label-warning' : 'bg-label-danger');
                                $statusText = $expense->status === 'approved' ? 'Onaylandı' :
                                              ($expense->status === 'pending' ? 'Beklemede' : 'Reddedildi');
                                $paystatusClass = $expense->payment_status === 'paid' ? 'bg-label-success' :
                                               ($expense->payment_status === 'pending' ? 'bg-label-warning' : 'bg-label-danger');
                                $paystatusText = $expense->payment_status === 'paid' ? 'Ödendi' :
                                              ($expense->payment_status === 'pending' ? 'Ödeme Beklemede' : 'Ödeme Reddedildi');
                            @endphp
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                                <td class="py-4 px-5 text-sm">{{ $expense->expense_type }}</td>
                                <td class="py-4 px-5 text-sm">{{ $expense->description }}</td>
                                <td class="py-4 px-5 text-sm">
                                    <a href="{{ Storage::url($expense->attachment) }}" target="_blank">Görüntüle</a>
                                </td>
                                <td class="py-4 px-5 text-sm">{{ \Carbon\Carbon::parse($expense->expense_date)->translatedFormat('d F Y') }}</td>
                                <td class="py-4 px-5 text-sm">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $statusClass }}">{{ $statusText }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-sm">
                                    <div class="flex items-center">
                                        <span class="inline-block w-3 h-3 rounded-full mr-2 {{ $paystatusClass }}">{{ $paystatusText }}</span>
                                    </div>
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
