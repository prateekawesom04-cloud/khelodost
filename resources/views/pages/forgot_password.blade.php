<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="{{ asset('css') }}/tailwind.min.css">
  <link rel="stylesheet" href="{{ asset('css') }}/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css') }}/bootstrap-icons.css">
  <style>
    body {
      background: #f8f9fa;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .bg-custom-green {
      background-color: #059669;
    }

    .btn-yellow {
      background-color: #fcd34d;
      color: #000;
      font-weight: 600;
      border-radius: 0.5rem;
      border: none;
      transition: background 0.3s ease;
    }

    .btn-yellow:hover {
      background-color: #eab308;
      color: #000;
    }

    .input-group-text-yellow {
      background-color: #fcd34d;
      color: #000;
      border: none;
    }

    a {
      color: #fde68a;
      font-weight: 500;
    }

    a:hover {
      text-decoration: underline;
    }

    .small {
      color: #fde68a;
    }

    /* Footer */
    .footer {
      padding-top: 0.3rem;
      padding-bottom: 0.6rem;
      background: #f8f9fa;
    }

    .gaming-curacao {
      height: 60px;
      max-width: 100%;
    }

    .copyright {
      text-align: center;
      color: #6c757d;
      font-size: 0.9rem;
      margin-top: 0.3rem;
      padding-top: 0.5rem;
      border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
      .gaming-curacao {
        height: 45px;
      }

      .copyright {
        font-size: 0.8rem;
      }
    }

    @media (max-width: 576px) {
      .gaming-curacao {
        height: 40px;
      }

      .copyright {
        font-size: 0.75rem;
      }
    }
  </style>
<link rel="stylesheet" href="{{ asset('css/app_style.css') }}">
  <style>
    .bg-custom-green { background-color: #0c0339; }
    .btn-yellow {
      background-color: #fcd34d; color: #000; font-weight: 600;
      border-radius: 0.5rem; border: none; transition: background 0.3s ease;
    }
    .btn-yellow:hover { background-color: #eab308; color: #000; }
    .input-group-text-yellow { background-color: #fcd34d; color: #000; border: none; border-radius: 0.5rem 0 0 0.5rem; }
    a { color: #fde68a; font-weight: 500; }
    a:hover { text-decoration: underline; }
    .small { color: #fde68a; }
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
      <form>
        <!-- Mobile Number + Get OTP -->
        <div class="mb-3 otp_not_verified">
          <div class="input-group">
            <input type="text" name="phone" class="form-control" minlength="10" maxlength="10" placeholder="+91 Enter Your 10 Digit Number" />
            <button type="button" class="btn btn-yellow getOtp">Get OTP</button>
          </div>
        </div>

        <!-- OTP -->
        <div class="mb-3">
          <input type="text" name="otp" class="form-control" minlength="6" maxlength="6" placeholder="Enter OTP" />
        </div>

        <!-- New Password -->
        <div class="mb-3 otp_verified">
          <div class="input-group">
            <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock"></i></span>
            <input type="password" name="newPassword" class="form-control rounded-end" placeholder="Enter new password" />
          </div>
        </div>

        <!-- Confirm New Password -->
        <div class="mb-3 otp_verified">
          <div class="input-group">
            <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock"></i></span>
            <input type="password" name="confirm_password" class="form-control rounded-end" placeholder="Confirm new password" />
          </div>
        </div>

        <!-- Remember Me -->
        {{-- <div class="form-check text-start mb-3">
          <input class="form-check-input" type="checkbox" value="" id="rememberMe" />
          <label class="form-check-label small" for="rememberMe">REMEMBER ME</label>
        </div> --}}

        <!-- Update Button -->
        <div class="mb-3 otp_verified">
          <a id="update" type="submit" class="btn btn-yellow w-100">Update</a>
        </div>

        <!-- Already have account -->
        <p class="small mb-0">
          Already have an account? <a href="{{ route('login') }}"><b>Login</b></a>
        </p>
      </form>
    </div>
  </div>

@include('includes.app_toast')

  <script src="{{ asset('js') }}/jquery-3.7.1.min.js"></script>
  <script src="{{ asset('js') }}/tailwind.min.js"></script>
  <script src="{{ asset('js') }}/bootstrap.bundle.min.js"></script>
@include('includes.ajaxCalls')
@include('includes.script')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function demoLogin() {
      let formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('phone', '9999999999');
      formData.append('password', 'abcd1234');
      callAjaxFormData('post',"{{route('post.login')}}",formData,ajaxResponse);
    }
    
  $('.login').click(function(){
    let formData = new FormData($('form')[0]);
    callAjaxFormData('post',"{{route('post.login')}}",formData,ajaxResponse);
  });

  </script>
</body>
</html>