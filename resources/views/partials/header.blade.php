<div class="header">
    <div class="header-left">
        <a href="{{ url('/dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" width="35" height="35" alt=""> <span>eRegistry</span>
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><img src="{{ asset('assets/img/icons/bar-icon.svg') }}" alt=""></a>
    <a id="mobile_btn" class="mobile_btn float-start" href="#sidebar"><img src="{{ asset('assets/img/icons/bar-icon.svg') }}" alt=""></a>
    <ul class="nav user-menu float-end">
        @include('partials.user-menu')
    </ul>
</div>
