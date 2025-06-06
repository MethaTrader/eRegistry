<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <!-- Dashboard -->
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="{{ asset('assets/img/icons/menu-icon-01.svg') }}" alt=""></span> <span> Dashboard </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Admin Dashboard</a></li>
                    </ul>
                </li>

                <!-- Doctors -->
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="{{ asset('assets/img/icons/menu-icon-02.svg') }}" alt=""></span> <span> Doctors </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.index') ? 'active' : '' }}">Doctor List</a></li>
                        <li><a href="{{ route('doctors.create') }}" class="{{ request()->routeIs('doctors.create') ? 'active' : '' }}">Add Doctor</a></li>
                    </ul>
                </li>

                <!-- Patients -->
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="{{ asset('assets/img/icons/profile-user.svg') }}" alt=""></span> <span> Patients </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">Patient List</a></li>
                        <li><a href="{{ route('patients.create') }}" class="{{ request()->routeIs('patients.create') ? 'active' : '' }}">Add Patient</a></li>
                    </ul>
                </li>

                <!-- Patients -->
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="{{ asset('assets/img/icons/menu-icon-04.svg') }}" alt=""></span> <span> Monitoring </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{route('monitoring.index')}}" class="{{ request()->routeIs('patients.index') ? 'active' : '' }}">Monitoring List</a></li>
                        <li><a href="{{ route('monitoring.create') }}" class="{{ request()->routeIs('patients.monitoring.create') ? 'active' : '' }}">Add monitoring</a></li>
                    </ul>
                </li>

                <!-- Training Materials - NEW SECTION -->
                <li class="submenu">
                    <a href="#"><span class="menu-side"><i class="fas fa-graduation-cap" style="width: 18px; height: 18px; color: #6B7280;"></i></span> <span> Training </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{ route('training.index') }}" class="{{ request()->routeIs('training.*') ? 'active' : '' }}">Video Tutorials</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>