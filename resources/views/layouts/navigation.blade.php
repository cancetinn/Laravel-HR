@if(auth()->check())
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="https://arinadigital.com/wp-content/uploads/2023/12/logo.svg" alt="Arina Digital">
            </span>
            <!-- <span class="app-brand-text demo menu-text fw-bold ms-2">Arina Digital</span> -->
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-10">
        <li class="menu-header small text-uppercase"><span class="menu-header-text">HIZLI ERİŞİM</span></li>
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('short-leaves*') || request()->is('leave/requests*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-tree-alt"></i>
                <div class="text-truncate" data-i18n="İzinler">İzinler</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('short-leaves*') ? 'active' : '' }}">
                    <a href="{{ route('short_leaves.index') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Günlük İzin">Günlük İzin</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('leave/requests*') ? 'active' : '' }}">
                    <a href="{{ route('leave.requests') }}" class="menu-link">
                        <div class="text-truncate" data-i18n="Yıllık İzin">Yıllık İzin</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->is('documents*') ? 'active' : '' }}">
            <a href="{{ route('documents') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-file-doc"></i>
                <div class="text-truncate" data-i18n="Belgelerim">Belgelerim</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('expenses*') ? 'active' : '' }}">
            <a href="{{ route('expenses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-receipt"></i>
                <div class="text-truncate" data-i18n="Masraflar">Masraflar</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">DESTEK</span></li>
        <li class="menu-item">
            <a href="javascript:void(0);" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div class="text-truncate" data-i18n="Support">Yardım</div>
            </a>
        </li>

        @if(auth()->user() && in_array(auth()->user()->role, [1, 2, 3]))
        <li class="menu-item {{ request()->is('admin*') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate" data-i18n="Yönetim Paneli">Yönetim Paneli</div>
            </a>
        </li>
        @endif
    </ul>
</aside>
@endif
