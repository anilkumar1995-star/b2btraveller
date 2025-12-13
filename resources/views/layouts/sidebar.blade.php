<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo d-flex align-items-center justify-content-between">
        @if (Auth::user()->company->logo)
            <a href="{{ route('home') }}" class="app-brand-link d-flex align-items-center">
                <img src="{{ Imagehelper::getImageUrl() . Auth::user()->company->logo }}" class="img-fluid rounded me-2"
                    width="100%" alt="Logo">
            </a>
        @else
            <a href="{{ route('home') }}" class="header-logo">
                <img src="" class="img-fluid rounded" alt="">
                <span>{{ Auth::user()->company->companyname }}</span>
            </a>
        @endif
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="{{ Request::is('home') ? 'active' : '' }} menu-item ">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>

        </li>

        <li class="menu-item {{ Request::is('flight/*') ? 'active open' : '' }}">
            <a href="#menu-design" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-plane"></i>
                <div data-i18n="Traveller">Traveller</div>
            </a>
            <ul class="menu-sub" id="menu-design {{ Request::is('flight/*') ? 'show' : '' }}">

                <li class="menu-item {{ Request::is('flight/view') ? 'active' : '' }}">
                    <a href="{{ route('flight.view') }}" class="menu-link">
                        <div data-i18n="Flight">Flight</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('flight/booking-list') ? 'active' : '' }}">
                    <a href="{{ url('flight/booking-list') }}" class="menu-link">
                        <div data-i18n="Booking List">Booking List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::is('profile/*') ? 'active open' : '' }}">
            <a href="#accountSetting" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-description"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub {{ Request::is('profile/*') ? 'show' : '' }}" id="accountSetting">
                <li class="menu-item {{ Request::is('profile/view') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class="menu-link">
                        <div data-i18n="Profile Setting">Profile Setting</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
