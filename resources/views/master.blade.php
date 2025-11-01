<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')

    @yield('head')
</head>

<body>
    <div class="app_body relative">
        <div>
            @include('header')
            @include('navbar')
        </div>

        <div>
            @yield('body')
        </div>

        <div class="footer_part w-full">
            @include('footer')
        </div>
    </div>
    @include('includes.app_toast')
    {{-- @if($claim_bonus) --}}
    @include('includes.bonusModal')
    {{-- @endif --}}
    @include('includes.ajaxCalls')
    @include('includes.script')
    @yield('js')
</body>

</html>
