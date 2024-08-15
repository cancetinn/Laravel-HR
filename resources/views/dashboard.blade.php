@extends('layouts.app')

@section('content')
<div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search bx-md"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none ps-1 ps-sm-2"
                    placeholder="Arama"
                    aria-label="Arama" />
                </div>
              </div>

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
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
              <div class="row">
                <div class="col-xxl-8 mb-6 order-0">
                  <div class="card">
                    <div class="d-flex align-items-start row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary mb-6">Günaydın, {{ Auth::user()->first_name }}!</h5>
                          <h4 class="mb-6">
                          <i class='bx bx-sun'></i> 24°C <small>/ İstanbul/Pendik</small>
                          </>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                          <img
                            src="{{ Auth::user()->profile_image_url }}"
                            height="175"
                            class="scaleX-n1-rtl"
                            alt="{{ Auth::user()->first_name }}" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="{{ asset('theme/assets/img/icons/unicons/chart-success.png')}}"
                                alt="chart success"
                                class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded text-muted"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                <a class="dropdown-item" href="javascript:void(0);">Görüntüle</a>
                                
                              </div>
                            </div>
                          </div>
                          <p class="mb-1">Mevcut Yıllık İzin</p>
                          <h4 class="card-title mb-3">
                          {{ \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('total_leaves') - \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('used_leaves') }}
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="{{ asset('theme/assets/img/icons/unicons/wallet-info.png')}}"
                                alt="wallet info"
                                class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded text-muted"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">Görüntüle</a>
                              </div>
                            </div>
                          </div>
                          <p class="mb-1">Kullanılan İzin Sayısı</p>
                          <h4 class="card-title mb-3">
                          {{ \App\Models\AnnualLeave::where('user_id', auth()->id())->sum('used_leaves') }}
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">Zimmetli Eşyalarım</h5>
                      </div>
                      <div class="dropdown">
                        <button
                          class="btn text-muted p-0"
                          type="button"
                          id="orederStatistics"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="bx bx-dots-vertical-rounded bx-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                          <a class="dropdown-item" href="javascript:void(0);">Görüntüle</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-6">
                        <!-- <div class="d-flex flex-column align-items-center gap-1">
                          <h3 class="mb-1">4</h3>
                          <small>Adet eşya</small>
                        </div> -->
                        <!-- <div id="orderStatisticsChart"></div> -->
                      </div>
                      <ul class="p-0 m-0">
                        <li class="d-flex align-items-center mb-5">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-laptop"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Elektronik</h6>
                              <small>Macbook M1 Air 2021</small>
                            </div>
                            <div class="user-progress">
                              <h6 class="mb-0">15.08.2024</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-save"></i
                            ></i></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Disk</h6>
                              <small>Sandisk Taşınabilir Harddisk</small>
                            </div>
                            <div class="user-progress">
                              <h6 class="mb-0">12.08.2024</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-laptop"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Elektronik</h6>
                              <small>Macbook M1 Air 2021</small>
                            </div>
                            <div class="user-progress">
                              <h6 class="mb-0">15.08.2024</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-laptop"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Elektronik</h6>
                              <small>Macbook M1 Air 2021</small>
                            </div>
                            <div class="user-progress">
                              <h6 class="mb-0">15.08.2024</h6>
                            </div>
                          </div>
                        </li>
                        <li class="d-flex align-items-center mb-5">
                          <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"
                              ><i class="bx bx-laptop"></i
                            ></span>
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <h6 class="mb-0">Elektronik</h6>
                              <small>Macbook M1 Air 2021</small>
                            </div>
                            <div class="user-progress">
                              <h6 class="mb-0">15.08.2024</h6>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Expense Overview -->
                <div class="col-md-6 col-lg-4 order-1 mb-6">
                    <div class="card h-100">
                        <div class="card-header nav-align-top">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-tabs-line-card-income" aria-controls="navs-tabs-line-card-income" aria-selected="true">
                                        İzinlerim
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                                    <div id="incomeChart"></div>
                                    <div class="d-flex align-items-center justify-content-center mt-6 gap-3">
                                        <div class="flex-shrink-0">
                                            <div id="expensesOfWeek"></div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Aylık Kullanılan Kısa İzin</h6>
                                            <small>Toplam: 3 Saat</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Expense Overview -->

                <!-- Transactions -->
                <div class="col-md-6 col-lg-4 order-2 mb-6">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">İzinli Kişiler</h5>
                    </div>
                    <div class="card-body pt-4">
                      <ul class="p-0 m-0">
                      @foreach($activeShortLeaves as $leave)
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ $leave->user->profile_image_url }}" alt="{{ $leave->user->first_name }} {{ $leave->user->last_name }}" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="d-block">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</small>
                              <h6 class="fw-normal mb-0">Günlük İzin</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                              <span class="fw-normal mb-0">{{ \Carbon\Carbon::parse($leave->start_time)->translatedFormat('j F H:i') }} - {{ \Carbon\Carbon::parse($leave->end_time)->translatedFormat('H:i') }}</span>
                              <span class="badge bg-success">Aktif</span>
                            </div>
                          </div>
                        </li>
                        @endforeach
                        @foreach($activeAnnualLeaves as $leave)
                        <li class="d-flex align-items-center mb-6">
                          <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ $leave->user->profile_image_url }}" alt="{{ $leave->user->first_name }} {{ $leave->user->last_name }}" class="rounded" />
                          </div>
                          <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                              <small class="d-block">{{ $leave->user->first_name }} {{ $leave->user->last_name }}</small>
                              <h6 class="fw-normal mb-0">Yıllık İzin</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                              <span class="fw-normal mb-0">{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d F ') }} - {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d F ') }}</span>
                              <span class="badge bg-success">Aktif</span>
                            </div>
                          </div>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
                <!--/ Transactions -->
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body">
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , developed by Can Cetin @ 
                    <a href="https://arinadigital.com/" target="_blank" class="footer-link">Arina Digital</a>
                  </div>
                </div>
              </div>
            </footer>

            <div class="content-backdrop fade"></div>
          </div>
        </div>
@endsection
