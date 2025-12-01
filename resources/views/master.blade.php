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
                @if(count($news))
                <div class="text-black d-flex align-items-center w-100 px-2" style="background:#fff;">
                    <span class="me-2"><i class="fas fa-microphone text-warning"></i></span>
                    <strong class="me-2">News:</strong>
                    <marquee class="flex-grow-1">
                        @foreach($news as $newses)
                        🔥 {{$newses->news}} &nbsp;&nbsp;&nbsp;
                        @endforeach
                    </marquee>
                </div>
                @endif
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
    @if($claim_bonus)
    @include('includes.bonusModal')
    @endif
    @include('includes.ajaxCalls')
    @include('includes.script')
    @yield('js')
</body>

</html>
