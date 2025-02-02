 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Ru<sup>2</sup>將</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Nav::isRoute('home') }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('Dashboard') }}</span></a>
        </li>

         <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Line Notify') }}
        </div>

        <!-- Nav Item - Line Notify Channels -->
        <li class="nav-item {{ Nav::isRoute('notify.token.show') }}">
            <a class="nav-link" href="{{ route('notify.token.show') }}">
                <i class="fas fa-fw fas fa-tasks"></i>
                <span>{{ __('Line Notify Channels') }}</span>
            </a>
        </li>

        <!-- Nav Item - Line Notify Templates -->
        <li class="nav-item {{ Nav::isRoute('notify.template.show') }}">
            <a class="nav-link" href="{{ route('notify.template.show') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>{{ __('Line Notify Templates') }}</span>
            </a>
        </li>
        
        <!-- Nav Item - Line Notify Messages -->
        <li class="nav-item {{ Nav::isRoute('notify.message.show') }}">
            <a class="nav-link" href="{{ route('notify.message.show') }}">
                <i class="fas fa-fw fa-sticky-note"></i>
                <span>{{ __('Line Notify Messages') }}</span>
            </a>
        </li>
        

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Line Card Designer') }}
        </div>

         <!-- Nav Item - New Cards -->
         <li class="nav-item {{ Nav::isRoute('line.templates.get') }}">
            <a class="nav-link" href="{{ route('line.templates.get') }}">
                <i class="fas fa-fw fa-pen"></i>
                <span>{{__('New Line Card')}}</span>
            </a>
        </li>

        <!-- Nav Item - Line Cards -->
        <li class="nav-item {{ Nav::isRoute('line.cards.get') }}">
            <a class="nav-link" href="{{ route('line.cards.get') }}">
                <i class="fas fa-fw fa-address-card"></i>
                <span>{{__('My Line Cards')}}</span>
            </a>
        </li>

        <!-- Nav Item - Line Cards -->
        <li class="nav-item {{ Nav::isRoute('line.shared.get') }}">
            <a class="nav-link" href="{{ route('line.shared.get') }}">
                <i class="fas fa-fw fa-address-card"></i>
                <span>{{__('Shared Line Cards')}}</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            {{ __('Settings') }}
        </div>

        <!-- Nav Item - Profile -->
        <li class="nav-item {{ Nav::isRoute('profile') }}">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>{{ __('Profile') }}</span>
            </a>
        </li>

        <!-- Nav Item - About -->
        <li class="nav-item {{ Nav::isRoute('about') }}">
            <a class="nav-link" href="{{ route('about') }}">
                <i class="fas fa-fw fa-hands-helping"></i>
                <span>{{ __('About') }}</span>
            </a>
        </li>

        <!-- Nav Item - About -->
        <li class="nav-item {{ Nav::isRoute('logout') }}">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>{{ __('Log Out') }}</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
<!-- End of Sidebar -->