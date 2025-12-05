<nav class="navbar">
    <div class="container-fluid">
        <ul class="navbar-nav flex-row w-100 custom-scrollbar">
            <li class="nav-item">
                {{-- <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }} active-nav" href="{{ route('admin.index') }}">Dashboard</a> --}}
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">Dashboard</a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.user_downline_list',$userData->username) ? 'active' : '' }}" href="{{ route('admin.user_downline_list',$userData->username) }}">Downline List</a>
            </li>
            <li class="nav-item position-relative">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.deposit') ? 'active' : '' }} position-relative d-inline-block" href="{{ route('admin.deposit') }}">
                    💰Deposit
                    {{-- <span class="position-absolute badge rounded-pill bg-danger badge-notification">
                        3
                    </span> --}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.withdraw') ? 'active' : '' }}" href="{{ route('admin.withdraw') }}">💸Withdraw</a>
            </li>
            {{-- <li class="nav-item dropdown">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown">Downline List</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.user_downline_list',$userData->username) }}">User Downline
                            List</a></li> --}}
                    {{-- <li>
                        <a class="dropdown-item" href="{{ route('admin.master_downline_list') }}">Master Downline
                            List</a>
                    </li> --}}
                {{-- </ul>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.my_account',$userData->username) }}">👨‍💼My Account</a>
            </li>

            {{-- <li class="nav-item dropdown">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown">My Report</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.event_profit_loss') }}">Event Profit/Loss</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.downline_profit_loss') }}">Downline
                            Profit/Loss</a>
                    </li>
                </ul>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.bonusData') }}">Bonus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.betlist') ? 'active' : '' }}" href="{{ route('admin.betlist') }}">Betlist</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.betlist') }}">🎯BetList</a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.market_analysis') ? 'active' : '' }}" href="{{ route('admin.market_analysis') }}">Market Analysis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.cricket_analysis') ? 'active' : '' }}" href="{{ route('admin.cricket_analysis') }}">Cricket Lock</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.soccer_analysis') ? 'active' : '' }}" href="{{ route('admin.soccer_analysis') }}">Soccer Lock</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.tennis_analysis') ? 'active' : '' }}" href="{{ route('admin.tennis_analysis') }}">Tennis Lock</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.payments') }}">🏧Payments</a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.commission') }}">Commission</a>
            </li> --}}

            {{-- <li class="nav-item dropdown">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown">⚙️My Setting</a>
                <ul class="dropdown-menu">
                    @if($userData->status==0)
                    <li><a class="dropdown-item" href="{{ route('admin.admin_fund') }}">💰Admin Fund</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('admin.news_view') }}">📰News</a></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.user_general_setting') }}">👥User General
                            Setting</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('admin.block_market') }}">🚫Block Market</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.event_wise_setting') }}">📅Event Wise
                            Setting</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.betting') }}">🎲Betting</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.add_banner') }}">🖼️Add Banner</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.add_number') }}">📞Add Number</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.add_bonus') }}">🎁Add Bonus</a></li>
                </ul>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('admin.index') ? 'active' : '' }} fw-bold" href="{{ route('admin.logout') }}"><strong>Logout 🔒</strong></a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = location.pathname;

        function clearActiveNav() {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });
        }

        function activateNavLink(link) {
            clearActiveNav();

            if (link.classList.contains('dropdown-item')) {
                const parentToggle = link.closest('.dropdown-menu')?.previousElementSibling;
                if (parentToggle) {
                    parentToggle.classList.add('active');
                }
            } else if (!link.classList.contains('dropdown-toggle')) {
                link.classList.add('active');
            }
        }

        function positionMobileDropdown(toggle) {
            if (window.innerWidth <= 991) {
                setTimeout(() => {
                    const menu = toggle.nextElementSibling;
                    if (menu) {
                        const rect = toggle.getBoundingClientRect();
                        menu.style.position = "fixed";
                        menu.style.top = rect.bottom + 2 + "px";
                        menu.style.left = Math.min(rect.left, window.innerWidth - 200) + "px";
                    }
                }, 10);
            }
        }

        document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
            const linkHref = link.getAttribute('href');
            if (!linkHref || linkHref === '#') return;

            let linkPath;
            try {
                linkPath = new URL(linkHref, window.location.origin).pathname;
            } catch (e) {
                linkPath = linkHref;
            }

            if (currentPath === linkPath) {
                activateNavLink(link);
            }

            link.addEventListener('click', function() {
                activateNavLink(this);
            });
        });

        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                positionMobileDropdown(this);
            });
        });
    });
</script>