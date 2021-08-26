<nav class="navbar navbar-expand-md navbar-dark navbar-overlap d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
                <x-jet-application-mark width="36" />
            </a>
        </h1>
        {{-- <div class="navbar-nav flex-row order-md-last">
            @auth
            <!-- User Dropdown -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <x-avatar :model="Auth::user()" />
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                        <!-- <div class="mt-1 small text-muted">UI Designer</div> -->
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <!-- Account Management -->
                    <span class="dropdown-header">{{ __('Manage Account') }}</span>
                    <a href="{{ route('profile.show') }}" class="dropdown-item">
                        {{ __('Profile') }}
                    </a>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <a href="{{ route('api-tokens.index') }}" class="dropdown-item">
                        {{ __('API Tokens') }}
                    </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <!-- Authentication -->
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item" data-no-swup>
                        {{ __('Log out') }}
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            </div>
            @else
            @if (Route::has('register'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                    <span class="nav-link-title">
                        {{ __('Register') }}
                    </span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <span class="nav-link-title">
                        {{ __('Login') }}
                    </span>
                </a>
            </li>
            @endif
        </div> --}}
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-tablericon-home />
                            </span>
                            <span class="nav-link-title">
                                {{ __('Home') }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('linklist') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('linklist') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-tablericon-list />
                            </span>
                            <span class="nav-link-title">
                                {{ __('Linklist') }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('pastebin') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pastebin') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <x-tablericon-file-code />
                            </span>
                            <span class="nav-link-title">
                                {{ __('Pastebin') }}
                            </span>
                        </a>
                    </li>
                    <!--<div
                                    class="ms-md-auto ps-md-4 py-2 py-md-0 me-md-4 order-first order-md-last flex-grow-1 flex-md-grow-0" style="align-self: center;">
                                    <form action="." method="get">
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                               <x-tablericon-search />
                                            </span>
                                            <input type="text" class="form-control form-control-dark" placeholder="Search…"
                                                aria-label="Search in website">
                                        </div>
                                    </form>
                                </div> -->
            </div>
        </div>
    </div>
</nav>
