@extends('sports_master')

@section('body')

    <div class="container">
        <div class="col-12 col-md-6 mx-auto my-4">

            {{-- Notification Bar --}}
            <div class="bonusList pb-2 mb-2">
                @foreach($bonus as $value)
                {{-- @dd($value); --}}
                    @include('includes.claimBonus',['description'=>$value['description'] ?? $value,'bonus_uid'=>$value['bonus_uid'] ?? $value])
                    {{-- @include('includes.claimBonus',['description'=>$value->description ?? $value,'bonus_uid'=>$value->bonus_uid ?? $value]) --}}
                @endforeach
            </div>

            <div class="flex flex-row items-center">
                <div class="p-2 w-full">
                    <button class="w-full p-2 !border-1 !border-[#0552cc] rounded-md !bg-[#0552cc] text-white">
                        Partner
                    </button>
                </div>
                <div class="p-2 w-full">
                    <button class="w-full p-2 !border-1 !border-[#0552cc] rounded-md !bg-[#0552cc] text-white">
                        Live Chat
                    </button>
                </div>
            </div>
            @php
            // if(count($bonusData) == 0){
            //     $bonusData = [];
            // }
            // $bonusData = [1,2,3,4,5];
            // if($userData->bonus){
            //     $bonusData = $userData->bonus;
            // }
            @endphp



        </div>
    </div>

@endsection

@section('js')

<script>

    function claimBonus(response){
        if(response.responseCode == 200){
            $(this).parents('.notification_bar').remove();
            // ajaxResponseModal(response);
            // setTimeout(() => {
            //     location.reload();
            // }, 1500);
        // } else {
        }
        ajaxResponseModal(response);
    }
    
    $('.claimBonus').on('click',function(){
        formData = {};
        callApi('post', `claimBonus`, {bonus_uid:$(this).attr('data-bonus_uid')}, claimBonus);
    });
</script>

@endsection