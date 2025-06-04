<li class="nav-item dropdown has-arrow user-profile-list">
    <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
        <div class="user-names">
            <h5>{{auth()->user()->name}}</h5>
            <span>{{auth()->user()->getRoleNames()->first()}}</span>
        </div>
        <span class="user-img"><img src="{{ asset('assets/img/user-06.jpg') }}" alt="Admin"></span>
    </a>
    {{-- resources/views/partials/user-menu.blade.php --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
</li>
