<!DOCTYPE html>
<html lang="en">
<head>
@include('head')
<link rel="stylesheet" href="{{asset('css')}}/admin_style.css">
@yield('head')
</head>

<body>
    @include('admin.header')
    @include('admin.navbar')
    @yield('body')
    @include('admin.model.add_method')
    @include('admin.model.add_banner')
    @include('admin.model.edit_banner')
    @include('admin.model.add_downline')
    @include('admin.model.game_controller')
    @include('admin.model.add_message')
    @include('admin.model.agent_rolling_commission')
    @include('admin.model.change_password')
    @include('admin.model.creadit_ref')
    @include('admin.model.delete')
    @include('admin.model.deposit_withdraw')
    @include('admin.model.rolling_commission')
    @include('admin.model.sports_setting')
    @include('admin.model.news_edit')
    @include('admin.model.number_edit')
    @include('admin.model.change_phone')
    {{-- @include('admin.model.edit_bonus')
    @include('admin.model.assign_bonus') --}}
    @include('admin.model.casino_control')
    @include('admin.model.responseModel')
    @include('includes.app_toast')
    @include('includes.ajaxCalls')
    @include('includes.script')
    @include('includes.admin_js')
    @yield('js')
</body>

</html>
