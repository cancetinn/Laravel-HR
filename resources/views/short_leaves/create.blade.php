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
        <div class="heading mb-4">
            <div class="titleArea text-center">
                <h3>Yeni Günlük İzin Talebi Oluştur</h3>
            </div>
        </div>
        <div class="col-xl-8 mx-auto">
            <div class="card mb-6 shadow-sm">
                <div class="card-body">
                    <form id="dailyLeaveForm" action="{{ route('short_leaves.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="html5-date-input" class="form-label">Tarih</label>
                            <input class="form-control" type="date" name="date" id="html5-date-input" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required />
                        </div>
                        <div class="mb-4">
                            <label for="start_time" class="form-label">Başlangıç Saati</label>
                            <input class="form-control" type="time" name="start_time" id="start_time" required />
                        </div>
                        <div class="mb-4">
                            <label for="end_time" class="form-label">Bitiş Saati</label>
                            <input class="form-control" type="time" name="end_time" id="end_time" required />
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="reason">Mazeret/Açıklama</label>
                            <textarea id="reason" class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                            <label class="form-check-label" for="defaultCheck1">
                                İzin prosedürünü onaylıyorum.
                            </label>
                        </div>
                        <button type="button" class="btn btn-primary w-100" id="submitRequestButton">İzin Talebini Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Talebi Gönder?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bu izin talebini göndermek istediğinize emin misiniz?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hayır</button>
                        <button type="button" class="btn btn-success" id="confirmButton">Evet</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let submitButton = document.getElementById('submitRequestButton');
    let confirmButton = document.getElementById('confirmButton');
    let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

    submitButton.addEventListener('click', function() {
        deleteModal.show();
    });

    confirmButton.addEventListener('click', function() {
        document.getElementById('dailyLeaveForm').submit();
    });
});
</script>
@endsection
