@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">
    
            <!-- 🔷 Banner Image Card -->
            <div class="mb-2">
                <iframe src="https://tv.jaipursofttech.com/livetv.php?eventId={{$eventId}}" frameborder="0" class="w-full"></iframe>
                {{-- <div class="rounded-4 text-center flex flex-row max-w-full overflow-hidden app_scroller">
                    <a href="{{ route('index') }}" class="min-w-full">
                        <img src="{{ asset('banners/banner1.png') }}" class="img-fluid" alt="Banner">
                    </a>
                    <a href="{{ route('index') }}" class="min-w-full">
                        <img src="{{ asset('banners/banner2.png') }}" class="img-fluid" alt="Banner">
                    </a>
                    <a href="{{ route('index') }}" class="min-w-full">
                        <img src="{{ asset('banners/banner3.png') }}" class="img-fluid" alt="Banner">
                    </a>
                    <a href="{{ route('index') }}" class="min-w-full">
                        <img src="{{ asset('banners/banner4.png') }}" class="img-fluid" alt="Banner">
                    </a>
                </div> --}}
            </div>
    <div class="shadow-sm mb-4">
        <div class="card-body p-0 eventDatabox">
            <div class="text-center">
                <h4 class="my-1 border-b-2 border-gray-300">{{$eventData->eventName}}</h4>
                {{-- <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300">
                    <h5>Live</h5>
                    <h5>Scorecard</h5>
                </div> --}}
                <div class="flex flex-row justify-evenly items-center my-1 border-b-2 border-gray-300 bg-[#0c0339] text-white py-2">
                    <h5>Event Start Time</h5>
                    <h5>{{$eventData->eventDate}}</h5>
                </div>
            </div>

            <div class="eventData">

            </div>

        </div>
    </div>
</main>
@endsection


@section('js')

<script>
    callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateCricketEvent);
    // setInterval(() => {
        callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$eventId}}},updateCricketEvent);
    // }, 500);
    
    $(document).ready(function(){
        betslipData.eventId = "{{($eventId)?$eventId:''}}";
    });
</script>

@endsection