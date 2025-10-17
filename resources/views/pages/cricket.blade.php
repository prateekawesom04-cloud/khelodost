@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0 flex flex-col overflow-x-scroll w-100">
            <table class="table text-center mb-0 align-middle odds-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-start fw-bold" style="width: 40%">🏏 Cricket</th>
                        <th style="width: 20%">1</th>
                        <th style="width: 20%">X</th>
                        <th style="width: 20%">2</th>
                    </tr>
                </thead>
                <tbody class="cricket">
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection


@section('js')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('cricket-sportsupdate');
    channel.bind('cricket-sportsupdate-event', function(data) {
        updateSports(data);
    });

    
    setInterval(() => {
        callApi('get',`{{route('user.getSportData','cricket')}}`,{sportname:{{$sportname}}},updateSports);
    }, 500);

  </script>

@endsection