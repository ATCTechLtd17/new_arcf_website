<header class="dt-header">

    <!-- Header container -->
    <div class="dt-header__container">

        <!-- Brand -->
        <div class="dt-brand">

            <!-- Brand tool -->
            <div class="dt-brand__tool" data-toggle="main-sidebar">
                <i class="icon icon-xl icon-menu-fold d-none d-lg-inline-block"></i>
                <i class="icon icon-xl icon-menu d-lg-none"></i>
            </div>
            <!-- /brand tool -->

            <!-- Brand logo -->
            <span class="dt-brand__logo">
                <a class="dt-brand__logo-link" href="">
                   @if(authUser()->service_type == \App\Enum\ServiceType::DOCUMENTS_CLEARING)
                        <img class="dt-brand__logo w-100" src="{{ asset('images/ARCF Logo New-01.jpg') }}" alt="Probashi Bangla">
                   @endif
                       @if(authUser()->service_type == \App\Enum\ServiceType::TRAVEL_TOURISM)
                           <img class="dt-brand__logo w-100" src="{{ asset('images/ARCF Travel Logo JPG.jpg') }}" alt="Probashi Bangla">
                       @endif
                </a>
            </span>
            <!-- /brand logo -->

        </div>
        <!-- /brand -->

        <!-- Header toolbar-->
        <div class="dt-header__toolbar">

            <h2 class="text-center text-white" style="margin-top: 22px; font-size: 32px;margin-left: 20%">{{authUser()->service_type->getLabel()}}</h2>

            <!-- Search box -->
            {{-- <form class="search-box d-none d-lg-block">
                <input class="form-control border-0" placeholder="Search in app..." value="" type="search">
                <span class="search-icon text-light-gray"><i class="icon icon-search icon-lg"></i></span>
            </form> --}}
            <!-- /search box -->

            <!-- Header Menu Wrapper -->
            <div class="dt-nav-wrapper">
                <!-- Header Menu -->
                <ul class="dt-nav d-lg-none">
                    <li class="dt-nav__item dt-notification-search dropdown">

                        <!-- Dropdown Link -->
                        <a href="#" class="dt-nav__link dropdown-toggle no-arrow" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"> <i
                                class="icon icon-search-new icon-fw icon-lg"></i> </a>
                        <!-- /dropdown link -->

                        <!-- Dropdown Option -->
                        <div class="dropdown-menu">

                            <!-- Search Box -->
                            <form class="search-box right-side-icon">
                                <input class="form-control form-control-lg" type="search"
                                    placeholder="Search in app...">
                                <button type="submit" class="search-icon"><i
                                        class="icon icon-search icon-lg"></i></button>
                            </form>
                            <!-- /search box -->

                        </div>
                        <!-- /dropdown option -->

                    </li>
                </ul>
                <!-- /header menu -->

                <!-- Header Menu -->
                <!-- /header menu -->

                <!-- Header Menu -->

                <!-- /header menu -->

                <!-- Header Menu -->
                <!-- /header menu -->

            </div>
            <!-- Header Menu Wrapper -->

        </div>
        <!-- /header toolbar -->

    </div>
    <!-- /header container -->

</header>
