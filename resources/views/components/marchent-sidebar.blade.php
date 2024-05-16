<aside id="main-sidebar" class="dt-sidebar">
    <div class="dt-sidebar__container">

        <!-- Sidebar Notification -->
        <div class="dt-sidebar__notification  d-none d-lg-block">
            <!-- Dropdown -->
            <div class="dropdown mb-6" id="user-menu-dropdown">

                <!-- Dropdown Link -->
                <a href="#" class="dropdown-toggle dt-avatar-wrapper text-body" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img class="dt-avatar" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                        alt="Domnic Harris">
                    <span class="dt-avatar-info">
                        <span class="dt-avatar-name text-white">{{ auth()->user()->name }}</span>
                    </span> </a>
                <!-- /dropdown link -->

                <!-- Dropdown Option -->
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dt-avatar-wrapper flex-nowrap p-6 mt--5 bg-gradient-purple text-white rounded-top">
                        <img class="dt-avatar" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}"
                            alt="Domnic Harris">
                        <span class="dt-avatar-info">
                            <span class="dt-avatar-name text-white">{{ auth()->user()->name }}</span>
                            <span class="f-12 text-white">Merchant</span>
                        </span>
                    </div>
                    {{-- <a class="dropdown-item" href="javascript:void(0)"> <i
                            class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Account
                    </a> --}}
                    <form action="{{ route('marchent.logout') }}" method="post" id="logoutForm">
                        @csrf
                    </form>
                    <a class="dropdown-item" type="button"
                        onclick="event.preventDefault(); document.getElementById('logoutForm').submit()"> <i
                            class="icon icon-trash icon-fw mr-2 mr-sm-1"></i>Logout
                    </a>
                </div>
                <!-- /dropdown option -->

            </div>
            <!-- /dropdown -->
        </div>
        <!-- /sidebar notification -->

        <!-- Sidebar Navigation -->
        <ul class="dt-side-nav">

            <!-- /menu header -->

            <li class="dt-side-nav__item {{ request()->is('marchent/dashboard') ? 'open' : '' }}">
                <a href="{{ route('marchent.dashboard') }}" class="dt-side-nav__link"> <i
                        class="icon icon-widgets icon-fw icon-xl"></i>
                    <span class="dt-side-nav__text">Dashboard</span> </a>
            </li>
            <li class="dt-side-nav__item {{ request()->is('marchent/profile') ? 'open' : '' }}">
                <a href="{{ route('marchent.profile') }}" class="dt-side-nav__link"> <i
                        class="icon icon-widgets icon-fw icon-xl"></i>
                    <span class="dt-side-nav__text">Merchant Profile</span> </a>
            </li>
            <!-- Menu Item -->
            <li
                class="dt-side-nav__item {{ request()->is('flat-details') || request()->is('flat-image') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                 <i class="icon icon-widgets icon-fw icon-xl"></i> <span class="dt-side-nav__text">Flat</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('marchent.flat-details') }}" class="dt-side-nav__link">
                        <i class="icon icon-crypto icon-fw icon-sm"></i>
                        <span class="dt-side-nav__text">Flat Details</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('marchent.flat-image') }}" class="dt-side-nav__link">
                        <i class="icon icon-crypto icon-fw icon-sm"></i>
                        <span class="dt-side-nav__text">Flat Image</span> </a>
                    </li>
                </ul>
            </li>
            <!-- Menu Item -->
            <li
                class="dt-side-nav__item {{ request()->is('plot-details') || request()->is('plot-image') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                <i class="icon icon-widgets icon-fw icon-xl"></i> <span class="dt-side-nav__text">Plot</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('marchent.plot-details') }}" class="dt-side-nav__link">
                        <i class="icon icon-crypto icon-fw icon-sm"></i>
                        <span class="dt-side-nav__text">Plot Details</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('marchent.plot-image') }}" class="dt-side-nav__link">
                        <i class="icon icon-crypto icon-fw icon-sm"></i>
                        <span class="dt-side-nav__text">Plot Image</span> </a>
                    </li>
                </ul>
            </li>

{{--            <li class="dt-side-nav__item {{ request()->is('marchent/flat-plot-buy-sell') ? 'open' : '' }}">--}}
{{--                <a href="{{ route('marchent.flat.plot.buy.sell') }}" class="dt-side-nav__link" Flat/Plot Buy/Sell"> <i--}}
{{--                        class="icon icon-widgets icon-fw icon-xl"></i>--}}
{{--                    <span class="dt-side-nav__text">Flat/Plot Buy/Sell</span> </a>--}}
{{--            </li>--}}
{{--            <li class="dt-side-nav__item {{ request()->is('marchent/flat-sell') ? 'open' : '' }}">--}}
{{--                <a href="{{ route('marchent.flatsell') }}" class="dt-side-nav__link" Flat Sell"> <i--}}
{{--                        class="icon icon-widgets icon-fw icon-xl"></i>--}}
{{--                    <span class="dt-side-nav__text">Flat Sell</span> </a>--}}
{{--            </li>--}}
{{--            <li class="dt-side-nav__item {{ request()->is('marchent/flat-buyer') ? 'open' : '' }}">--}}
{{--                <a href="{{ route('marchent.flatbuyer') }}" class="dt-side-nav__link" Flat Buyer"> <i--}}
{{--                        class="icon icon-widgets icon-fw icon-xl"></i>--}}
{{--                    <span class="dt-side-nav__text">Flat Buyer</span> </a>--}}
{{--            </li>--}}
{{--            <li class="dt-side-nav__item {{ request()->is('marchent/plot-sell') ? 'open' : '' }}">--}}
{{--                <a href="{{ route('marchent.plotsell') }}" class="dt-side-nav__link" Plot Sell"> <i--}}
{{--                        class="icon icon-widgets icon-fw icon-xl"></i>--}}
{{--                    <span class="dt-side-nav__text">Plot Sell</span> </a>--}}
{{--            </li>--}}

{{--            <li class="dt-side-nav__item {{ request()->is('marchent/plot-buyer') ? 'open' : '' }}">--}}
{{--                <a href="{{ route('marchent.plotbuyer') }}" class="dt-side-nav__link" Plot Buyer"> <i--}}
{{--                        class="icon icon-widgets icon-fw icon-xl"></i>--}}
{{--                    <span class="dt-side-nav__text">Plot Buyer</span> </a>--}}
{{--            </li>--}}


        </ul>
        <!-- /sidebar navigation -->

    </div>
</aside>
