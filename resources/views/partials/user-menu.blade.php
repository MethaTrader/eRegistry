<li class="nav-item dropdown has-arrow user-profile-list">
    <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
        <div class="user-names">
            <h5>{{auth()->user()->name}}</h5>
            <span>{{auth()->user()->getRoleNames()->first()}}</span>
        </div>
        <span class="user-img"><img src="{{ asset('assets/img/user-06.jpg') }}" alt="Admin"></span>
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ url('/login') }}">Logout</a>
    </div>
</li>
