@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="text-center">
                <div class="mb-2 relative" style="height: 205px;display:none;">
                    <iframe src="" frameborder="0" class="w-full h-full absolute top-0 left-0"></iframe>
                </div>
                <div class="my-1 border-b-2 border-gray-300">{{$eventData->eventName}}</div>
                <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300">
                    <div class="iframetv">
                        <img class="w-10" src="{{asset('icons/iframetv.png')}}" alt="">
                    </div>
                    {{-- <div>Live</div> --}}
                    <div>Scorecard</div>
                </div>
                <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300 bg-[#0c0339] text-white py-2">
                    <div>Event Start Time</div>
                    <div>{{$eventData->eventDate}}</div>
                </div>
            </div>
            
            {{-- <div class="soccerData"> --}}
            <div class="eventData">

            </div>

        </div>
    </div>
    @include('includes.betlist')
</main>
@endsection


{{-- @include('includes.soccerEvent_js') --}}
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.7.5/socket.io.min.js"></script>
{{-- <script src="/socket.io/socket.io.js"></script> --}}
<script>
    
    $(document).ready(function(){
        betslipData.eventId = "{{($eventId)?$eventId:''}}";
    });
    
    $('.iframetv').on('click', function(){
        $('iframe').parents('.relative').show();
        
        let src = `https://tv.jaipursofttech.com/livetv.php?eventId={{$eventData->beventId}}`;
        
        $('iframe').attr('src', src);
    });

    eventId = {{$eventId}};
    let sportStatus = {{$market->status}};
    let eventStatus = {{$eventData->status}};
    @if($eventData->sportname == 'cricket')
    callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateCricketEvent);
    setInterval(() => {
        callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateCricketEvent);
    }, 500);
    @else
    
    callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateSoccerEvent);
    setInterval(() => {
        callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateSoccerEvent);
    }, 500);
    @endif

    const socket = io(`{https://72.60.97.123:3001`);
    // Listen for incoming messages
    socket.on('message', (msg) => {
        console.log('Message from server:', msg);
        // run the required function
    });

    setTimeout(() => {
        window.location.reload();
    }, 600*1000);

</script>
{{-- <script type="module">

            window.Echo.connector.socket.on('connect', () => {
                console.log('Successfully connected to Socket.IO server');
            });

            window.Echo.channel('posts')
                .listen('.create', (data) => {
                    console.log('Order status updated: ', data);
                    var d1 = document.getElementById('notification');
                    d1.insertAdjacentHTML('beforeend', '<div class="alert alert-success alert-dismissible fade show"><span><i class="fa fa-circle-check"></i>  '+data.message+'</span></div>');
                });

    </script> --}}
@endsection