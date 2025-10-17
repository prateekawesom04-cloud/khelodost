@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    <div class="card shadow-sm mb-4 sport_box hidden">
        <div class="p-1 w-100">
            <div class="div mb-0 align-middle odds-div">
                <div class="table_head">
                    <div class="fw-bold" style="width: 50%">🏏 Cricket</div>
                    <div style="">1</div>
                    <div style="">X</div>
                    <div style="">2</div>
                </div>
                <div class="cricket">
                    
                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@section('js')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
    //   cluster: 'ap2'
    // });

    // var channel = pusher.subscribe('cricket-sportsupdate');
    // channel.bind('cricket-sportsupdate-event', function(data) {
    //     updateSports(data);
    // });

    
    setInterval(() => {
        callApi('get',`{{route('user.getSportData','cricket')}}`,{sportname:`{{$sportname}}`},updateSports);
    }, 500);

  </script>

@endsection