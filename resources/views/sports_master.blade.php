@extends('master')

@section('body')
    <div class="container-fluid p-0">
    <div class="layout-container">
        
        <!-- Left Sidebar -->
        <aside class="layout-sidebar-left">
            @include('left-sidebar')
        </aside>

        <!-- Center Content -->
        <main class="layout-content-center">
            @yield('sports_body')
        </main>

        <!-- Right Sidebar -->
        <aside class="layout-sidebar-right">
            @include('right-sidebar')
        </aside>

    </div>
</div>

    @include('includes.user_js')
    <script>
        $(document).ready(function(){
            setTimeout(() => {
            $('.sport_box').show();
            }, 500);
        });
    </script>
@endsection
