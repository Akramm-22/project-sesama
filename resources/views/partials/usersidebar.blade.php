    @php($currentUser = Auth::user())

@php
    $regionMenuOptions = \App\Http\Controllers\RecipientController::REGION_OPTIONS;
@endphp

<div class="sidebar-inner d-flex flex-column justify-content-between h-100">
    <div>
        <div class="text-center mb-3">
            <img src="{{ asset('image/logo.png') }}"
                 alt="Logo"
                 class="img-fluid mb-3"
                 style="max-height:64px"
                 onerror="this.onerror=null;this.src='{{ asset('image/foto.png') }}';">
            <h5 class="text-white fw-bold mb-1">{{ $currentUser->name ?? 'Relawan' }}</h5>
            <p class="text-white-50 small mb-0">{{ $currentUser->email ?? 'relawan@sesama.id' }}</p>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item mb-1">
                <a class="nav-link {{ request()->routeIs('userdashboard') ? 'active' : '' }}"
                   href="{{ route('userdashboard') }}">
                    <i class="fas fa-home me-3"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <div class="dropdown w-100">
                    <a class="nav-link d-flex justify-content-between align-items-center dropdown-toggle {{ request()->routeIs('list') ? 'active' : '' }}"
                       href="{{ route('list') }}"
                       role="button"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="outside">
                        <span><i class="fas fa-users me-3"></i> Data Penerima</span>
                        <i class="fas fa-chevron-down small"></i>
                    </a>
                    <div class="dropdown-menu w-100 shadow border-0 mt-2 px-0">
                        <a class="dropdown-item small fw-semibold py-2 {{ request('region') ? '' : 'active-region' }}"
                           href="{{ route('list') }}">
                            Semua Wilayah
                        </a>
                        <div class="dropdown-divider my-0"></div>
                        @foreach($regionMenuOptions as $key => $label)
                            <a class="dropdown-item small py-2 {{ request('region') === $key ? 'active-region' : '' }}"
                               href="{{ route('list', ['region' => $key]) }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer mt-auto pt-3 text-center">
        <div class="d-flex flex-column align-items-center justify-content-center mb-3">
            <div class="text-white fw-bold">Program SESAMA</div>
            <div class="text-white-50 small">Bazma Pertamina</div>
        </div>
        <a class="btn btn-light text-primary fw-bold rounded-pill w-100"
           href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form-user').submit();">
            Logout
        </a>
        <form id="logout-form-user" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
