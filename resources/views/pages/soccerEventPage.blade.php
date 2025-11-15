@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    <div class="card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="text-center">
                <div class="mb-2 relative" style="height: 285px;display:none;">
                    <iframe src="" frameborder="0" class="w-full h-full absolute top-0 left-0"></iframe>
                </div>
                <h4 class="my-1 border-b-2 border-gray-300">{{$eventData->eventName}}</h4>
                <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300">
                    <div class="iframetv">
                        <img class="w-10" src="{{asset('icons/iframetv.png')}}" alt="">
                    </div>
                    {{-- <h5>Live</h5> --}}
                    <h5>Scorecard</h5>
                </div>
                <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300 bg-[#0c0339] text-white py-2">
                    <h5>Event Start Time</h5>
                    <h5>{{$eventData->eventDate}}</h5>
                </div>
            </div>
            
            {{-- <div class="soccerData"> --}}
            <div class="eventData">

            </div>

        </div>
    </div>
</main>
@endsection


{{-- @include('includes.soccerEvent_js') --}}
@section('js')

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
</script>

@endsection