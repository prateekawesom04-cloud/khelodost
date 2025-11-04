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
    
    @foreach ($providers as $provider)
    <div class="col-6 col-sm-2 footer-icon-wrapper">
        {{-- <div class="app_content app_col p-2 m-2 rounded shadow-sm"> --}}
            {{-- <h6>{{$provider->title}}</h6> --}}
            <img src="{{$provider->img}}" alt="" srcset="" class="w-32 bg-gray-900 h-16 rounded-lg shadow">
            {{-- <h5>0</h5> --}}
        {{-- </div> --}}
    </div>
    @endforeach
      <div class="col-6 col-sm-2 footer-icon-wrapper">
        <img src="{{asset('images')}}/cograE.svg" alt="Ecogra" class="footer-icon">
      </div>

    <!-- Center Image -->
    <div>
      <img src="images/gaming-1.49592c7f.png" class="gaming-curacao w-full" alt="Gaming Curacao" />
    </div>

    <!-- Copyright -->
    <div class="copyright">
      © 2025 playcrick99. All rights reserved.
    </div>
  </div>
</footer>
