<div class="sidebar">

    <!-- LOGO -->
    <div class="logo">
        <img src="{{ asset('images/foto1.png') }}">
        <span>E-ARSIP</span>
    </div>

    <!-- MENU -->
    <div class="sidebar-menu">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}">
            <span>
                <i class="bi bi-grid"></i>
                Dashboard
            </span>
        </a>

        {{-- ================= MASTER DATA ================= --}}
        <a class="dropdown-toggle"
   data-bs-toggle="collapse"
   href="#masterMenu">

    <span>
        <i class="bi bi-folder2-open"></i>
        Master Data
    </span>

    <i class="bi bi-chevron-down"></i>

</a>

        <div class="collapse
            @if(
                request()->routeIs('users.*') ||
                request()->routeIs('pejabat.*') ||
                request()->routeIs('arsip.*')
            )
                show
            @endif"
            id="masterMenu">

            @if(Auth::user()->role_id == 1)

                <a href="{{ route('users.index') }}" class="ps-4">
                    <i class="bi bi-people"></i>
                    Data User
                </a>

                <a href="{{ route('pejabat.index') }}" class="ps-4">
                    <i class="bi bi-person-badge"></i>
                    Data Pejabat
                </a>

            @endif

            <a href="{{ route('arsip.index') }}" class="ps-4">
                <i class="bi bi-folder"></i>
                Data Arsip
            </a>

        </div>

        {{-- ================= SURAT ================= --}}
        <a
    class="d-flex justify-content-between align-items-center"
    data-bs-toggle="collapse"
    href="#suratMenu">

    <span>
        <i class="bi bi-envelope"></i>
        Surat
    </span>

    <i class="bi bi-chevron-down"></i>

</a>

        <div class="collapse
            @if(
                request()->routeIs('suratmasuk.*') ||
                request()->routeIs('suratkeluar.*')
            )
                show
            @endif"
            id="suratMenu">

            <a href="{{ route('suratmasuk.index') }}" class="ps-4">
                <i class="bi bi-envelope-open"></i>
                Surat Masuk
            </a>

            <a href="{{ route('suratkeluar.index') }}" class="ps-4">
                <i class="bi bi-envelope-arrow-up"></i>
                Surat Keluar
            </a>

        </div>

        {{-- Agenda --}}
        <a href="{{ route('agenda.index') }}">
            <span>
                <i class="bi bi-calendar-event"></i>
                Agenda Kegiatan
            </span>
        </a>

        {{-- Laporan --}}
        @if(Auth::user()->role_id == 1)

        <a href="{{ route('laporan.index') }}">
            <span>
                <i class="bi bi-file-earmark-text"></i>
                Laporan
            </span>
        </a>

        @endif

    </div>