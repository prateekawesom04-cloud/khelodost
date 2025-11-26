@extends('sports_master')

@section('head')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    .bg-custom-green { background-color: #059669; }
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
@endsection
@section('sports_body')

<div class="d-flex align-items-center justify-content-center bg-light" style="height:100vh; margin:0;">
  <div class="bg-custom-green p-4 rounded-3 text-center text-white shadow" style="width: 380px;">
    <!-- Logo -->
    <a>
      <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-4" style="max-width:180px;" />
    </a>

    <!-- Change Password Form -->
    <form>
      <!-- Old Password -->
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock"></i></span>
          <input type="hidden" name="username" value="{{$userData->username}}" class="form-control rounded-end" placeholder="Enter old password" />
          <input type="password" name="oldPassword" class="form-control rounded-end" placeholder="Enter old password" />
        </div>
      </div>

      <!-- New Password -->
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock"></i></span>
          <input type="password" name="newPassword" class="form-control rounded-end" placeholder="Enter new password" />
        </div>
      </div>

      <!-- Confirm New Password -->
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text input-group-text-yellow"><i class="bi bi-lock"></i></span>
          <input type="password" name="confirmPassword" class="form-control rounded-end" placeholder="Confirm new password" />
        </div>
      </div>

      <!-- Change Password Button -->
      <div class="d-grid gap-2 mb-3">
        <a href="javascript:void(0)" class="btn btn-yellow text-center changePassword">Change Password</a>
      </div>
    </form>
  </div>
  </div>


@endsection


@section('js')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $('.changePassword').on('click',function(){
        formData = new FormData($(this).parents('form')[0]);
      callApiFormData('post',`{{route('user.changePassword')}}`,formData,ajaxResponseModal);
    });

  </script>

@endsection
