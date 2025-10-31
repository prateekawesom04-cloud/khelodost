<!-- Header -->
<div class="responsive-header">
    <div class="header-inner flex flex-row">
        <!-- Logo Section -->
        <div class="flex items-center logo-section w-25 h-10">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="header-logo" />
        </div>

        <!-- Admin Info Section -->
        <div class="admin-info w-75">
            <div class="admin-row">
                {{-- <span class="admin-badge">Admin</span> --}}

                <div class="dropdown">
                    <a class="admin-name dropdown-toggle" href="#" role="button" id="adminDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end fw-light" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item d-flex flex-row" href="#"><img src="{{asset('icons/coins.png')}}" alt="" class="w-6"> : {{$userData->wallet_amount}} </a></span></li>
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-lock me-2"></i>Change
                                Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
