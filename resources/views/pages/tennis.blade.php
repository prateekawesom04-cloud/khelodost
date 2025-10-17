@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    <div class="card shadow-sm mb-4 sport_box hidden">
        <div class="p-1 w-100">
            <div class="div mb-0 align-middle odds-div">
                <div class="table_head">
                    <div class="fw-bold" style="width: 50%">🏏 Tennis</div>
                    <div style="">1</div>
                    <div style="">X</div>
                    <div style="">2</div>
                </div>
                <div class="tennis">
                    
                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@include('includes.soccerEvent_js')
@section('js')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
    //   cluster: 'ap2'
    // });

    // var channel = pusher.subscribe('tennis-sportsupdate');
    // channel.bind('tennis-sportsupdate-event', function(data) {
    //     updateSoccer(data);
    // });
    
    $(document).ready(function(){
         
        setInterval(() => {
            callApi('get',`{{route('user.getSportData','tennis')}}`,{sportname:`{{$sportname}}`},updateSoccer);
        }, 500);

    });

  </script>

@endsection