<!-- Header -->
<nav class="bg-primary-green navbar px-1 py-2">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-nowrap position-relative">
        <!-- Toggle Button (Visible only on small screens) -->
        <button class="d-md-none custom-toggler position-absolute start-0 top-50 translate-middle-y ms-3" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a href="{{ route('index') }}" class="flex items-center justify-start h-2 navbar-brand p-0 flex-shrink-0 ms-5 max-w-[40%]">
            <img class="w-full" src="{{ asset('logo/logo.png') }}" alt="Logo" height="40"
                style="max-width: 150px; height: auto;" />
        </a>

        <!-- Search + Date/Time -->
        <div class="d-none d-md-flex align-items-center flex-grow-1 mx-3" style="max-width: 500px; min-width: 0;">
            <div class="flex-grow-1">
                <input type="text" class="form-control form-control-sm border-0 rounded-pill"
                    placeholder="Search Events (At least 3 letters)...">
            </div>
            <div class="ms-3 text-white text-nowrap">
                <small id="currentDate" style="font-size: 11px;"></small><br>
                <span id="clock" class="fw-bold" style="font-size: 13px;">--:--:--</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="d-flex align-items-center gap-2 ms-auto flex-shrink-0" id="headerButtons">
            @if($userData)
            <div class="flex flex-row gap-2 align-items-center">
                {{-- <div class="flex flex-col sm:flex-row gap-2"> --}}

                    <button class="account_btn rounded-[0.4rem] px-1 py-1 text-nowrap flex items-center gap-[0.6rem]" data-bs-toggle="offcanvas" data-bs-target="#accountPanel"><span class="flex items-center gap-1 justify-center !text-[10px]">
                    <img src="{{asset('icons/coins.png')}}" alt="" class="w-6"> : <span class="userBalance !text-[10px]">{{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}}</span> </a></span><i class="bi bi-arrow-repeat"></i></button>
    
                    {{-- <button class="account_btn rounded-[0.4rem] px-1 py-1 text-nowrap flex items-center gap-[0.6rem]" data-bs-toggle="offcanvas" data-bs-target="#accountPanel"><span class="!text-[8px]">Exp. : {{$userData->unsattled_amount}} </a></span><i class="bi bi-arrow-repeat"></i></button> --}}

                {{-- </div> --}}

                <img src="{{asset('logo/avatar.png')}}" data-bs-target="#accountPanel" data-bs-toggle="offcanvas" alt="" class="w-12 rounded-circle border-2 border-solid !border-[#2d92f6] cursor-pointer">
                
                <!-- <a class="relative logout" href="{{route('logout')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 23px;height: 23px;fill: #fce31a;"><path d="M256 73.825a182.18 182.18 0 0 0-182.18 182.18c0 100.617 81.567 182.17 182.18 182.17a182.175 182.175 0 1 0 0-364.35zm-18.096 86.22a18.099 18.099 0 0 1 36.197 0v53.975a18.099 18.099 0 0 1-36.197 0zM256 348.589a92.413 92.413 0 0 1-32.963-178.751v33.38a62.453 62.453 0 1 0 65.93 0v-33.38A92.415 92.415 0 0 1 256 348.588z" data-name="Logout"></path></svg>
                </a> -->
            </div>
            @else
            <a href="{{ route('login') }}"
                class="btn btn-outline-light btn-sm rounded-pill px-2 px-sm-3 py-1 text-nowrap">Log In</a>
            <a href="{{ route('signin') }}" class="btn btn-light btn-sm rounded-pill px-2 px-sm-3 py-1 text-nowrap">Sign
                Up</a>
            @endif
        </div>
    </div>
</nav>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- Sports -->
        <div class="mb-4 px-3 pt-3">
            <h6 class="text-uppercase text-muted small mb-3">Sports</h6>
            <a href="{{ route('user.sport','cricket') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🏏
                Cricket</a>
            <a href="{{ route('football') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">⚽
                Football</a>
            <a href="{{ route('tennis') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🎾
                Tennis</a>
        </div>

        <!-- Casino -->
        <div class="px-3 pb-3">
            <h6 class="text-uppercase text-muted small mb-3">Casino</h6>
            <a href="{{ route('indian_card_games') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🃏 Indian
                Card Games</a>
            <a href="{{ route('casino') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🎰
                Casino</a>
            <a href="{{ route('1X2_gaming') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🎮 1X2
                Gaming</a>
            <a href="{{ route('ezugi') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">♟️
                Ezugi</a>
            <a href="{{ route('supernova') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🌟
                Supernova</a>
            <a href="{{ route('slot_casino') }}"
                class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🎲 Slot
                Casino</a>
            <a href="#" class="d-block text-dark text-decoration-none mb-2 py-1 rounded hover-bg-light px-2">🏆
                Sportsbook (80+)</a>
        </div>
    </div>
</div>

@if($userData)
<!-- Account Panel Offcanvas -->
<div class="offcanvas offcanvas-end account-offcanvas" tabindex="-1" id="accountPanel">
    <div class="offcanvas-header bg-light text-dark d-flex justify-content-between align-items-center">
        <span class="fs-5 fw-semibold d-flex align-items-center gap-2">📧 {{$userData->username}}</span>
        <a type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas"></a>
    </div>

    <div class="offcanvas-body bg-light p-1 d-flex flex-column">
        <!-- Balance Information -->
        <div class="balance-section bg-white rounded p-3 shadow-sm mb-4">
            <div class="balance-title fw-bold text-secondary fs-6 mb-3 d-flex align-items-center gap-2">
                💳 Balance Information
            </div>
{{-- 
            <div class="mb-3">
                <div class="text-muted small fw-semibold">BALANCE</div>
                <div class="balance-amount fs-6 fw-bold text-success">₹ <span class="userBalance">{{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}}</span></div>
            </div> --}}

            <div class="d-flex justify-content-between mb-3">
                {{-- <div>
                    <div class="text-muted small fw-semibold text-uppercase">Free Cash</div>
                    <div class="fs-6 fw-bold">₹ 0.00</div>
                </div> --}}
                <div class="">
                    <div class="text-muted small fw-semibold">BALANCE</div>
                    <div class="balance-amount fs-6 fw-bold text-success">₹ <span class="userBalance fs-6">{{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}}</span></div>
                </div>
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Net Exposure</div>
                    <div class="fs-6 fw-bold">₹ {{$userData->unsattled_amount}}</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('user.deposit') }}" class="btn btn-success flex-fill fw-bold">➕ Deposit</a>
                <a href="{{ route('user.withdraw') }}" class="btn btn-danger flex-fill fw-bold">➖ Withdraw</a>
            </div>
        </div>

        <!-- Statements Section -->
        <div class="menu-title fw-bold text-secondary fs-6 mt-1 ml-1 mb-2">
            📄 Report
        </div>

        <div class="ms-3 border-top">
            <a href="{{ route('account_statement') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">📥 Account
                Statement</a>
            <a href="{{ route('profit_loss_event') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">📃 Profit & Loss</a>
            <a href="{{ route('user.betlist') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">📊 Bets History</a>
            <a href="{{ route('user.live_game_bet_history') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">📊 Live Game Bets History</a>
        </div>
        @if($userData->bonus)
        <div class="menu-title fw-bold text-secondary fs-6 ml-1 mt-2 mb-2">
            <a href="{{ route('user.bonus') }}" class="text-decoration-none text-secondary">🎁 Bonuses</a>
        </div>
        @endif
        
        <div class="menu-title fw-bold text-secondary fs-6 ml-1 mt-1 mb-2">
            <a href="{{ route('user.transaction_history') }}" class="text-decoration-none text-secondary">📃 Transaction History</a>
        </div>
        <div class="menu-title fw-bold text-secondary fs-6 ml-1 mt-1 mb-2">
            <a href="{{ route('user.referred_users') }}" class="text-decoration-none text-secondary">📃 Referral Users</a>
        </div>

        <!-- Settings Section -->
        {{-- <div class="menu-title fw-bold text-secondary fs-6 ml-1 mt-4 mb-2">
            ⚙️ Account Settings
        </div>

        <div class="ms-3 border-top">
            <a href="{{ route('account_setting') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">🛠️ Settings</a>
        </div> --}}

        <!-- Account Actions Section -->
        <div class="menu-title fw-bold text-secondary fs-6 ml-1 mt-1 mb-2">
            🔐 Account Actions
        </div>

        <div class="ms-3 border-top">
            <a href="{{ route('change_password') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">🔑 Change
                Password</a>
            <a href="{{ route('logout') }}" class="d-block py-2 px-3 text-decoration-none text-dark border-bottom">🚪 Sign Out</a>
        </div>

    </div>
</div>
@endif
<script>
    // Check localStorage on page load
    // window.addEventListener('load', function() {
    //     if (localStorage.getItem('demo_login') === 'true') {
    //         document.getElementById('headerButtons').innerHTML =
    //             '<button class="btn btn-outline-light btn-sm rounded-pill px-2 px-sm-3 py-1 text-nowrap" data-bs-toggle="offcanvas" data-bs-target="#accountPanel">Account</button>';
    //     }
    // });

    // Sign out function
    function signOut() {
        localStorage.removeItem('demo_login');
        location.reload();
    }

    // Logout function
    function logout() {
        localStorage.removeItem('demo_login');
        location.reload();
    }

    function startClock() {
        setInterval(() => {
            let now = new Date();
            let ist = new Date(now.getTime() + 5.5 * 60 * 60 * 1000);
            const dateEl = document.getElementById("currentDate");
            const timeEl = document.getElementById("clock");
            if (dateEl && timeEl) {
                dateEl.textContent = ist.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                }) + " (GMT +5:30)";
                timeEl.textContent = ist.toLocaleTimeString('en-GB');
            }
        }, 1000);
    }
    startClock();

    // Toggle button animation
    document.addEventListener('DOMContentLoaded', function() {
        const toggler = document.querySelector('.custom-toggler');
        const offcanvas = document.getElementById('mobileMenu');

        if (toggler && offcanvas) {
            toggler.addEventListener('click', function() {
                this.classList.toggle('active');
            });

            offcanvas.addEventListener('hidden.bs.offcanvas', function() {
                toggler.classList.remove('active');
            });
        }
    });
</script>