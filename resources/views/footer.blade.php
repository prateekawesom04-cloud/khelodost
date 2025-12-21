<footer class="footer">
  <div class="container-fluid px-0">
    <div class="row justify-content-center g-0">
      <!-- First Row: 2 Icons -->
      {{-- <div class="col-6 col-sm-2 footer-icon-wrapper">
        <img src="{{asset('images')}}/upiIcon.svg" alt="Upi" class="footer-icon">
      </div>
      <div class="col-6 col-sm-2 footer-icon-wrapper">
        <img src="{{asset('images')}}/bankTransfer.svg" alt="Bank Transfer" class="footer-icon">
      </div>

      <!-- Second Row: 2 Icons -->
      <div class="col-6 col-sm-2 footer-icon-wrapper">
        <img src="{{asset('images')}}/BeGambleAware.svg" alt="BeGambleAware" class="footer-icon">
      </div>
      <div class="col-6 col-sm-2 footer-icon-wrapper">
        <img src="{{asset('images')}}/cograE.svg" alt="Ecogra" class="footer-icon">
      </div>

      <!-- Third Row: 1 Icon (centered on all screens) -->
      <div class="col-12 col-sm-2 footer-icon-wrapper d-flex justify-content-center">
        <img src="{{asset('images')}}/gamblingCommission.svg" alt="Gambling Commission" class="footer-icon">
      </div>
    </div> --}}
    
            {{-- Game Center --}}

            <div class="game_center border-b-2 border-t-2 !border-[#0552cc] p-2 mb-3">
                <h3 class="!text-[#0c0339] !text-[16px] !font-bold">Game Center</h3>
                <div class="bg-white py-1 shadow-sm">
                    <nav class="nav nav-pills flex-nowrap overflow-auto px-0 small custom-scrollbar"
                        style="white-space: nowrap; -webkit-overflow-scrolling: touch; overflow-x: auto;">

                        <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('cricket') ? 'active' : '' }}"
                            href="{{ route('user.sport','cricket') }}">
                            <span class="me-1">🏏</span>Cricket
                        </a>

                        <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('football') ? 'active' : '' }}"
                            href="{{ route('user.sport','soccer') }}">
                            <span class="me-1">⚽</span>Football
                        </a>

                        <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill {{ request()->routeIs('tennis') ? 'active' : '' }}"
                            href="{{ route('user.sport','tennis') }}">
                            <span class="me-1">🎾</span>Tennis
                        </a>

                        <a class="nav-link d-inline-flex align-items-center mx-1 px-2 py-1 rounded-pill contact_admin" href="javascript:void(0)">
                            <span class="me-1">🏆</span>Complete Matches
                        </a>

                    </nav>
                </div>
                {{-- <div class="flex flex-row py-1 gap-1 overflow-x-auto">
                    <div class="bg-[#0c0339] !text-[16px] !text-[#fff] border-1 !border-[#0552cc] p-2 !font-bold rounded-md">
                        Cricket
                    </div>
                    <div class="bg-[#0c0339] !text-[16px] !text-[#fff] border-1 !border-[#0552cc] p-2 !font-bold rounded-md">
                        Soccer
                    </div>
                    <div class="bg-[#0c0339] !text-[16px] !text-[#fff] border-1 !border-[#0552cc] p-2 !font-bold rounded-md">
                        Tennis
                    </div>
                    <div class="bg-[#0c0339] !text-[16px] !text-[#fff] border-1 !border-[#0552cc] p-2 !font-bold rounded-md">
                        Complete Matches
                    </div>
                </div> --}}
            </div>
    
    <div class="flex flex-row flex-wrap items-center justify-center">
      @foreach ($providers as $provider)
      <div class="footer-icon-wrapper mx-1">
          {{-- <div class="app_content app_col p-2 m-2 rounded shadow-sm"> --}}
              {{-- <h6>{{$provider->title}}</h6> --}}
              <img src="{{asset('images/providers').'/'.$provider->img}}" alt="" srcset="" class="w-22 h-11 rounded-md">
              {{-- <img src="{{asset('images/providers').'/'.$provider->img}}" alt="" srcset="" class="w-20 h-10 bg-gray-900 rounded-lg shadow"> --}}
              {{-- <h5>0</h5> --}}
          {{-- </div> --}}
      </div>
      @endforeach
      <div class="footer-icon-wrapper">
        <img src="{{asset('images')}}/cograE.svg" alt="Ecogra" class="w-20 h-10 rounded-md bg-[#000]">
      </div>
    </div>

    <!-- Center Image -->
    <div>
      <img src="images/gaming-1.49592c7f.png" class="gaming-curacao w-full" alt="Gaming Curacao" />
    </div>

    <!-- Copyright -->
    <div class="copyright">
      © 2025 Matchbhai. All rights reserved.
    </div>
  </div>
</footer>
