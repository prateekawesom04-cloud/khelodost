@extends('sports_master')

@section('sports_body')
<main class="container py-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0 sport_box hidden">
            <div class="table-responsive">
                <table class="table text-center mb-0 align-middle odds-table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start fw-bold" style="min-width: 200px;">🎾 Tennis</th>
                            <th style="width: 20%">1</th>
                            <th style="width: 20%">2</th>
                        </tr>
                    </thead>
                    <tbody class="tennis">
                        
                    </tbody>
                </table>
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