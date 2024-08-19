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
                    <h3>Profilim</h3>
                </div>
                <div class="buttonArea">
                    <a href="{{ route('profile.edit') }}">
                        <button type="button" class="btn rounded-pill btn-primary">
                            <span class="bx bx-sm bx-user me-1_5"></span>Profilimi Düzenle
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
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-6">
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom justify-content-center">
                        <img
                          src="{{ $user->profile_image_url }}"
                          alt="users"
                          class="d-block w-px-200 h-px-200 rounded"
                          id="uploadedAvatar" />
                      </div>
                    </div>
                    <div class="card-body pt-4">
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row g-6">
                          <div class="col-md-6">
                            <label for="{{ $user->first_name }} " class="form-label">Adınız</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              value="{{ $user->first_name }}"
                              autofocus 
                              disabled/>
                          </div>
                          <div class="col-md-6">
                            <label for="last_name" class="form-label">Soyadınız</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" disabled/>
                          </div>
                          <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="{{ $user->email }}"
                              placeholder="{{ $user->email }}" 
                              disabled/>
                          </div>
                          <div class="col-md-6">
                            <label for="phone" class="form-label">Telefon Numarası</label>
                            <input
                              type="text"
                              class="form-control"
                              id="phone"
                              name="phone"
                              value="{{ $user->phone }}" 
                              disabled/>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label" for="department">Departmanım</label>
                            <select id="department" class="select2 form-select" disabled>
                                <option value="1" {{ $user->department == 1 ? 'selected' : '' }}>Grafik Tasarım</option>
                                <option value="2" {{ $user->department == 2 ? 'selected' : '' }}>Yazılım</option>
                                <option value="3" {{ $user->department == 3 ? 'selected' : '' }}>İçerik Ekibi</option>
                                <option value="4" {{ $user->department == 4 ? 'selected' : '' }}>SEO</option>
                            </select>
                          </div>
                          
                          <div class="col-md-6">
                            <label for="joining_date" class="form-label">İşe Başlangıç Tarihi</label>
                            <input class="form-control" type="date" value="{{ $user->joining_date }}" id="joining_date" disabled>
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
