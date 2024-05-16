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
                            <span class="f-12 text-white">Accountant</span>
                        </span>
                    </div>
                    {{-- <a class="dropdown-item" href="javascript:void(0)"> <i
                            class="icon icon-user-o icon-fw mr-2 mr-sm-1"></i>Account
                    </a> --}}
                    <form action="{{ route('logout') }}" method="post" id="logoutForm">
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

            <!-- Menu Header -->
            {{-- <li class="dt-side-nav__item dt-side-nav__header">
                <span class="dt-side-nav__text">main</span>
            </li> --}}
            <!-- /menu header -->

            <li class="dt-side-nav__item {{ request()->is('agent/dashboard') ? 'open' : '' }}">
                <a href="{{ route('dashboard') }}" class="dt-side-nav__link"> <i
                        class="icon icon-widgets icon-fw icon-xl"></i>
                    <span class="dt-side-nav__text">Dashboard</span> </a>
            </li>

            <li class="dt-side-nav__item {{ request()->is('invoices') || request()->is('customer-advances') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-product-list icon-fw icon-xl"></i> <span class="dt-side-nav__text">Income</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="/invoices?type={{authUserServiceType()}}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Invoice</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{route('customer-advances.index')}}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Money Receipt</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('expenses') || request()->is('expenses-details-report') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-pricing-table icon-fw icon-xl"></i> <span class="dt-side-nav__text">Expense</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('expenses.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Expense</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('expenses.details.report') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Details Report</span> </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('income-vs-expense') ? 'open' : '' }}">
                <a href="{{route('income-vs-expense.index')}}" class="dt-side-nav__link"> <i
                        class="icon icon-pricing-table icon-fw icon-xl"></i>
                    <span class="dt-side-nav__text">Income vs Expense</span> </a>
            </li>

            <li class="dt-side-nav__item {{ request()->is('invoices-due-payments-report') || request()->is('invoices-due-collections') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-pricing-table icon-fw icon-xl"></i> <span class="dt-side-nav__text">Due Payment</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('invoices-due-payments-report') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Due Payments Report</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('invoices.due-collections') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Due Collection</span> </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('supplier-deposits') || request()->is('supplier-deposits-report') || request()->is('supplier-deposits/create') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-card icon-fw icon-xl"></i> <span class="dt-side-nav__text">Supplier Deposit</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('supplier-deposits.create') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Deposit</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('supplier-deposits.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Deposit Details</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('supplier-deposits-report') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Deposit Report</span> </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('investments') || request()->is('investment-to-deposit') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-card icon-fw icon-xl"></i> <span class="dt-side-nav__text">Investment</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('investments.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Investment</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('investment-to-deposit') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Investment to Supplier</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('cash-at-bank-to-deposits') ||
                    request()->is('cash-at-banks') ||
                    request()->is('cash-at-bank-to-drawer-cash') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-card icon-fw icon-xl"></i> <span class="dt-side-nav__text">Manage Cash at Bank</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('cash-at-banks.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Cash at Bank</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('cash-at-bank-to-deposits') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Bank to Supplier</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('cash-at-bank-to-drawer-cash') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Bank to Drawer Cash</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('drawer-cashes') ||
                    request()->is('drawer-cash-to-cash-at-bank') ||
                    request()->is('drawer-cash-to-supplier-deposits') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-card icon-fw icon-xl"></i> <span class="dt-side-nav__text">Manage Drawer Cash</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('drawer-cashes.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Drawer Cash</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('drawer-cash-to-supplier-deposits') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Cash to Supplier</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('drawer-cash-to-cash-at-bank') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Drawer Cash to Bank</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{ request()->is('customer-advances') || request()->is('customer-advances-details') ? 'open' : '' }}">
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-card icon-fw icon-xl"></i> <span class="dt-side-nav__text">Manage Customer Advance</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('customer-advances.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Customer Advance</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('customer-advances.details') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Customer Advance Payment Details</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="dt-side-nav__item {{
                request()->is('agents') ||
                request()->is('suppliers') ||
                request()->is('services') ||
                request()->is('customers') ||
                request()->is('chart-of-accounts') ||
                request()->is('banks') ||
                request()->is('investors') ? 'open' : '' }}"
            >
                <a href="javascript:void(0)" class="dt-side-nav__link dt-side-nav__arrow">
                    <i class="icon icon-setting icon-fw icon-xl"></i> <span class="dt-side-nav__text">Settings</span>
                </a>
                <!-- Sub-menu -->
                <ul class="dt-side-nav__sub-menu">
                    <li class="dt-side-nav__item">
                        <a href="{{ route('agents.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Agent</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('suppliers.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Supplier</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href={{route('services.index')}} class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Services</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('chart-of-accounts.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Chart of Accounts</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('investors.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-crypto icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Investor</span>
                        </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('customers.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-user icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Customers</span> </a>
                    </li>
                    <li class="dt-side-nav__item">
                        <a href="{{ route('banks.index') }}" class="dt-side-nav__link">
                            <i class="icon icon-user icon-fw icon-sm"></i>
                            <span class="dt-side-nav__text">Bank</span> </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /sidebar navigation -->
    </div>
</aside>
