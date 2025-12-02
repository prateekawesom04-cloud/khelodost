<!-- Header -->
<div class="responsive-header">
    <div class="header-inner flex flex-row">
        <!-- Logo Section -->
        <div class="flex items-center logo-section w-25 h-10">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="header-logo" />
        </div>

        <!-- Admin Info Section -->
        
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
        
        <div class="dropdown">

            <button class="flex flex-row gap-2 align-items-center dropdown-toggle cursor-pointer" data-bs-toggle="dropdown">
                {{-- <div class="flex flex-col sm:flex-row gap-2"> --}}
    
                <div class="account_btn rounded-[0.4rem] px-1 py-1 text-nowrap flex items-center gap-[0.6rem]">
                    <span class="flex items-center gap-1 justify-center !text-[10px]">
                        <img src="{{asset('icons/coins.png')}}" alt="" class="w-6"> : {{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}} </a>
                    </span>
                    <i class="bi bi-arrow-repeat"></i>
                </div>
    
                    {{-- <button class="account_btn rounded-[0.4rem] px-1 py-1 text-nowrap flex items-center gap-[0.6rem]" data-bs-toggle="offcanvas" data-bs-target="#accountPanel"><span class="!text-[8px]">Exp. : {{$userData->unsattled_amount}} </a></span><i class="bi bi-arrow-repeat"></i></button> --}}
    
                {{-- </div> --}}
    
                <img src="{{asset('logo/avatar.png')}}" alt="" class="w-12 rounded-circle border-2 border-solid !border-[#2d92f6] cursor-pointer">
                
                <!-- <a class="relative logout" href="{{route('logout')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 23px;height: 23px;fill: #fce31a;"><path d="M256 73.825a182.18 182.18 0 0 0-182.18 182.18c0 100.617 81.567 182.17 182.18 182.17a182.175 182.175 0 1 0 0-364.35zm-18.096 86.22a18.099 18.099 0 0 1 36.197 0v53.975a18.099 18.099 0 0 1-36.197 0zM256 348.589a92.413 92.413 0 0 1-32.963-178.751v33.38a62.453 62.453 0 1 0 65.93 0v-33.38A92.415 92.415 0 0 1 256 348.588z" data-name="Logout"></path></svg>
                </a> -->
            </button>
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
                {{-- <li><a class="dropdown-item" href="{{ route('admin.event_wise_setting') }}">📅Event Wise Setting</a></li> --}}
                {{-- <li><a class="dropdown-item" href="{{ route('admin.betting') }}">🎲Betting</a></li> --}}
                <li><a class="dropdown-item" href="{{ route('admin.add_banner') }}">🖼️Add Banner</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.add_number') }}">📞Add Number</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.bonusData') }}">🎁Add Bonus</a></li>
                {{-- <li><a class="dropdown-item" href="#"><i class="fa-solid fa-lock me-2"></i>Change Password</a></li> --}}
                <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
            </ul>
        </div>
        
        {{-- <div class="admin-info w-75">
            <div class="admin-row">
                <span class="admin-badge">Admin</span>

                <div class="dropdown">
                    <a class="admin-name dropdown-toggle" href="#" role="button" id="adminDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end fw-light" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item d-flex flex-row" href="#"><img src="{{asset('icons/coins.png')}}" alt="" class="w-6"> : {{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}} </a></span></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-lock me-2"></i>Change
                                Password</a></li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>
</div>
