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
                    <h3>Yeni Masraf Ekle</h3>
                </div>
            </div>
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-6">
                        <div class="card-body pt-4">
                            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-6">
                                    <div class="col-md-4">
                                        <label class="form-label" for="expense_type">Masraf Tipi</label>
                                        <select id="expense_type" name="expense_type" class="select2 form-select">
                                            <option value="Taşıt">Taşıt</option>
                                            <option value="Gıda">Gıda</option>
                                            <option value="Dijital Üyelik">Dijital Üyelik</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="description">Belge/Fiş</label>
                                        <input class="form-control" type="file" id="attachment" name="attachment" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label" for="expense_date">Masraf Tarihi</label>
                                        <input class="form-control" type="date" id="expense_date" name="expense_date" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="description">Açıklama</label>
                                        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary">Oluştur</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
</div>
@endsection
