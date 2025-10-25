<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Register Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" href="{{ asset('css') }}/tailwind.min.css">
  <link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css') }}/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css') }}/app_style.css">

 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f0f8ff;
      /* height: 100vh; */
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .bg-custom-green { background-color: #0c0339; }
    .btn-yellow {
      background-color: #ffd600; color: #000; font-weight: 700;
      border-radius: 0.5rem; border: none; transition: background-color 0.3s ease;
    }
    .btn-yellow:hover,
    .btn-yellow:focus { background-color: #e6c200; color: #000; }
    .input-group-text-yellow {
      background-color: #ffd600; color: #000; font-weight: 600; border: none; border-radius: 0.5rem 0 0 0.5rem;
    }
    .form-control:focus { box-shadow: none; }
    a { color: #fff; font-weight: 600; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .btn-outline-secondary {
      border-radius: 0 0.5rem 0.5rem 0; border: none;
      background: rgba(255 255 255 / 0.15); color: #fff;
      width: 3rem; display: flex; align-items: center; justify-content: center; transition: background 0.3s ease;
    }
    .btn-outline-secondary:hover { background: rgba(255 255 255 / 0.3); color: #fff; }

    span.select2 {
      width: 4rem !important;
    }

    .select2-selection {
      height: 100% !important;
      display: flex !important;
      border-radius: inherit !important;
      align-items: center;
      justify-content: center;
      border: 0 !important;
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center bg-light">
  <div class="bg-custom-green rounded-3 text-center text-white shadow my-" style="width: 380px;">
    <!-- Logo -->
    {{-- <img src="{{ asset('banners/auth.png') }}" alt="Logo" class="mb-4 w-full" /> --}}
    <div alt="Logo" class="mb- w-full" style="height: 284px;background: url('banners/auth.png');background-position: center center;background-size: cover;background-repeat: no-repeat;border-radius: 8px 8px 0 0;background-position-y: 30%;"></div>
    <div class="p-4 py-2">
      {{-- <a>
        <div style="display: block;height: 77px;position: relative;">
          <img alt="Logo" style="/*! max-width:180px; *//*! position: absolute; */top: 0%;left: 0%;height: 90px;/*! width: 100%; */" src="logo/logo.png" class="mb-2">
        </div>
      </a> --}}
  
    <!-- Form -->
    <form action="{{route('post.signin')}}" method="POST">
      @csrf
      <!-- Phone -->
      <div class="input-group mb-3 rounded">

        <!-- <span class="input-group-text input-group-text-yellow"><i class="bi bi-phone text-warning"></i> +91</span> -->
        <select class="input-group-text input-group-text-yellow" name="country_phone_code" id="country_phone_code">
          <!-- <option value="{{$country_phone_code[2]}}"><img src='{{asset('icons')}}/flags/{{$country_phone_code[2]}}.svg' width='15'> +{{$country_phone_code[2]}}</option>       
          @foreach($country_phone_code as $code)
            <option value="{{$code}}"><img src='{{asset('icons')}}/flags/{{$code}}.svg' width='15'> +{{$code}}</option>
          @endforeach -->
          
        </select>
        <input type="text" name="phone" class="form-control !border-l-0" placeholder="Enter your phone number" maxlength="10" />
        <!-- <a href="javascript:void(0)" class="btn btn-yellow rounded-0 rounded-end text-center">Get OTP</a> -->
      </div>

      <!-- OTP -->
      <!-- <div class="mb-3">
        <input type="text" name="otp" class="form-control rounded-3" placeholder="Enter OTP" maxlength="6" />
      </div> -->

      <!-- Password -->
      <div class="input-group mb-3">
        <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock text-warning"></i></span>
        <input type="password" name="password" class="form-control rounded-0 rounded-end" placeholder="Password" />
        <a href="#" class="btn btn-outline-secondary" aria-label="Toggle password visibility">
          <i class="bi bi-eye"></i>
        </a>
      </div>

      <!-- Confirm Password -->
      <div class="input-group mb-3">
        <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock text-warning"></i></span>
        <input type="password" name="confirm_password" class="form-control rounded-0 rounded-end" placeholder="Confirm Password" />
        <a href="#" class="btn btn-outline-secondary" aria-label="Toggle confirm password visibility">
          <i class="bi bi-eye"></i>
        </a>
      </div>

      <!-- Referral Code -->
      <div class="mb-3">
        <input type="text" name="referral_code" class="form-control rounded-3" placeholder="Referral Code (optional)" />
      </div>

      <!-- Remember Me -->
      <div class="form-check mb-3 text-start">
        <input class="form-check-input" type="checkbox" id="remember" name="age_confirm" />
        <label class="form-check-label small fw-semibold" for="remember">I am over 18 years and have read and accepted Terms & Conditions.</label>
      </div>

      <!-- Register -->
      <div class="d-grid mb-3">
        <a href="javascript:void(0)" class="btn btn-yellow rounded-3 text-center signIn">Register</a>
      </div>
    </form>
    
          <!-- Or -->
          <p class="mb-3 fs-6 text-white">Or register with</p>
    
          <!-- Chatbot -->
          <div class="d-grid mb-3">
            <a href="{{route('api.login.social')}}" class="btn btn-success rounded-3 fw-semibold text-center !flex items-center justify-center">
              <img class="rounded-circle mr-1" src="{{asset('icons/google.png')}}" width="20" height=20"> Google
            </a>
          </div>
    
          <!-- Login link -->
          <p class="small text-white">
            Already have an account? <a href="{{route('login')}}"><b>Login</b></a>
          </p>
  </div>

@include('includes.app_toast')

  <script src="{{ asset('js') }}/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('js') }}/tailwind.min.js"></script>
  <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@include('includes.ajaxCalls')
@include('includes.script')

<script>
  $('.signIn').click(function(){
    let formData = new FormData($('form')[0]);
    callAjaxFormData('post',"{{route('post.signin')}}",formData,ajaxResponse);
  });

  $(document).ready(function(){
    function formatOption(option) {
      if (!option.id) {
        return option.text;
      }

      // var optionWithImage = $(
      //   '<span style="display: flex;justify-content: space-between;"><img src="' + option.img + '" class="img-flag" width="15" /> ' + option.text + '</span>'
      // );
      
      var optionWithImage = $(
        '<span style="display: flex;justify-content: space-between;"> ' + option.text + '</span>'
      );
      return optionWithImage;
    }

    // Add options dynamically
    var options = [
      @foreach($country_phone_code as $code)
      { id: '{{$code}}', text: ' +{{$code}}', img: '{{asset('icons')}}/flags/{{$code}}.svg' },
      @endforeach
    ];

    $('select').select2({
      templateResult: formatOption,
      templateSelection: formatOption,
      data: options,
      minimumResultsForSearch: Infinity
    });
  });


</script>

</body>
</html>
