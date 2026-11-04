<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Business Autopsy') &mdash; UMKM Nexus</title>
    @vite(['resources/css/business-autopsy.css', 'resources/js/business-autopsy.js'])
</head>
<body class="ba-app">
    <div class="ba-shell">
        <aside class="ba-sidebar">
            <a class="ba-brand" href="{{ route('admin.business-autopsy.dashboard') }}">
                <span class="ba-brand-mark">BA</span>
                <span>
                    <span class="d-block">UMKM Nexus</span>
                    <small class="fw-normal text-white-50">Admin Autopsy</small>
                </span>
            </a>

            <div class="ba-nav">
                <div class="ba-nav-label">Menu Admin</div>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.dashboard') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.dashboard') }}">Dashboard</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.users.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.users.index') }}">Pengguna</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.profiles.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.profiles.index') }}">Profil UMKM</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.categories.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.categories.index') }}">Kategori Bisnis</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.symptoms.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.symptoms.index') }}">Gejala</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.diagnoses.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.diagnoses.index') }}">Master Diagnosis</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.rules.index', 'admin.business-autopsy.rules.create', 'admin.business-autopsy.rules.show', 'admin.business-autopsy.rules.edit') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.rules.index') }}">Business Rules</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.rules.tester*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.rules.tester') }}">Rule Tester</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.recommendations.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.recommendations.index') }}">Rekomendasi</a>
                <a class="ba-nav-link {{ request()->routeIs('admin.business-autopsy.audit.*') ? 'active' : '' }}" href="{{ route('admin.business-autopsy.audit.index') }}">Audit</a>
                <a class="ba-nav-link" href="#" aria-disabled="true">Laporan <span class="badge text-bg-light ms-auto">Segera</span></a>
                <a class="ba-nav-link" href="#" aria-disabled="true">Pengaturan <span class="badge text-bg-light ms-auto">Segera</span></a>
            </div>
        </aside>

        <div class="ba-main">
            <header class="ba-topbar d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <div class="fw-semibold">@yield('header', 'Admin Business Autopsy')</div>
                    <div class="small ba-muted">@yield('subheader', 'Kelola master data dan aturan diagnosis')</div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="small ba-muted">{{ auth()->user()->full_name ?? '' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Keluar</button>
                    </form>
                </div>
            </header>

            <main class="ba-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <div class="fw-semibold mb-1">Periksa kembali isian berikut:</div>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
