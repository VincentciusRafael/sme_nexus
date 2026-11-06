<nav class="navbar navbar-expand-sm nx-navbar sticky-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bolder" href="{{ route('dashboard') }}">
            <span class="nx-logo-mark">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </span>
            <span class="d-none d-sm-inline">SME Nexus</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto gap-1 mt-2 mt-sm-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}"
                    href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 {{ request()->routeIs('decision.*', 'business-autopsy.*') ? 'active' : '' }}"
                    aria-current="{{ request()->routeIs('decision.*', 'business-autopsy.*') ? 'page' : 'false' }}"
                    href="{{ route('decision.autopsy') }}">Decision</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-secondary" href="#" aria-disabled="true" title="Segera hadir">Collaboration <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis ms-1" style="font-size:.62rem">Segera</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 text-secondary" href="#" aria-disabled="true" title="Segera hadir">Intelligence <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis ms-1" style="font-size:.62rem">Segera</span></a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
                <button type="button" class="btn nx-icon-btn" data-theme-toggle aria-label="Mode gelap/terang" title="Mode gelap/terang">
                    <svg class="i-sun" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <svg class="i-moon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>

                <div class="dropdown">
                    <button class="btn d-flex align-items-center gap-2 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nx-avatar">{{ \Illuminate\Support\Str::substr(Auth::user()->name, 0, 1) }}</span>
                        <span class="d-none d-md-block text-start lh-sm">
                            <span class="d-block fw-semibold small">{{ Auth::user()->name }}</span>
                            <span class="d-block text-secondary" style="font-size:.75rem">{{ Auth::user()->email }}</span>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border rounded-4 p-0 overflow-hidden" style="min-width:224px">
                        <li class="px-3 py-3 bg-body-tertiary border-bottom">
                            <div class="fw-semibold small">{{ Auth::user()->name }}</div>
                            <div class="text-secondary text-truncate" style="font-size:.75rem">{{ Auth::user()->email }}</div>
                        </li>
                        <li><a class="dropdown-item py-2 px-3" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                        <li><hr class="dropdown-divider my-0"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 px-3 text-danger">{{ __('Log Out') }}</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
