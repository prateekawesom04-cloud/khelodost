@extends('master')

@php
if($userData){
    if($userData->additional_data){
        $additional_data = json_decode($userData->additional_data,true);
        $stakes = (array_key_exists('stakes',$additional_data))?$additional_data['stakes']:[];
    }
}else{
    $stakes = [];
}
@endphp

@section('head')
    <style>
        * {
            font-weight: 700;
            /* font-size: 11px; */
        }
    </style>
@endsection

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
    @include('includes.betslip')

    @include('includes.user_js')
    @if($userData)
        @include('includes.addStake')
        @include('includes.normalbetModal')
    @endif
    <script>
        $(document).ready(function(){
            setTimeout(() => {
            $('.sport_box').show();
            }, 500);
        });
    </script>
@endsection
