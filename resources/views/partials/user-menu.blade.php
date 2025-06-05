<li class="nav-item dropdown has-arrow user-profile-list">
    <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown" aria-expanded="false">
        <div class="user-names">
            <h5>{{ auth()->user()->name }}</h5>
            <span>{{ auth()->user()->getRoleNames()->first() }}</span>
        </div>
        <span class="user-img">
            <img src="{{ asset('assets/img/user-06.jpg') }}" alt="Admin">
        </span>
    </a>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu dropdown-menu-end">
        <div class="dropdown-header">
            <h6 class="dropdown-header-title">{{ auth()->user()->name }}</h6>
            <small class="text-muted">{{ auth()->user()->getRoleNames()->first() }}</small>
        </div>
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ route('home') }}">
            <i class="feather-home me-2"></i>
            Dashboard
        </a>

        @if(auth()->user()->hasRole(['admin', 'Administrator']))
            <a class="dropdown-item" href="{{ route('doctors.index') }}">
                <i class="feather-users me-2"></i>
                Doctors
            </a>
        @endif

        <a class="dropdown-item" href="{{ route('patients.index') }}">
            <i class="feather-user me-2"></i>
            Patients
        </a>

        <a class="dropdown-item" href="{{ route('monitoring.index') }}">
            <i class="feather-activity me-2"></i>
            Monitoring
        </a>

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="feather-log-out me-2"></i>
            Logout
        </a>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>