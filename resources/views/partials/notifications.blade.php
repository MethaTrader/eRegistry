<li class="nav-item dropdown d-none d-md-block">
    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"><img src="{{ asset('assets/img/icons/note-icon-02.svg') }}" alt=""><span class="pulse"></span></a>
    <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
            <span>Notifications</span>
        </div>
        <div class="drop-scroll">
            <ul class="notification-list">
                <li class="notification-message">
                    <a href="{{ url('/activities') }}">
                        <div class="media">
                            <span class="avatar"><img alt="John Doe" src="{{ asset('assets/img/user.jpg') }}" class="img-fluid"></span>
                            <div class="media-body">
                                <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="topnav-dropdown-footer">
            <a href="{{ url('/activities') }}">View all notifications</a>
        </div>
    </div>
</li>
