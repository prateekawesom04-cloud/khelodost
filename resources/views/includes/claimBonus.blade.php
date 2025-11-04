<div class="notification_bar">
    <div class="alert fade show flex flex-row items-center justify-between border-b !border-[#0552cc] py-1 !bg-[#0c0339] text-white text-[#0552cc]" role="alert">
        
        <div class="flex flex-col items-start justify-evenly">
            <div class="img">
                <img class="w-10" src="https://img.icons8.com/?size=48&id=12191&format=png" alt="">
            </div>
            {{-- <a href="{{(!isset($anchor))?'javascript:void(0)':route('user.bonus')}}" data-bonus_uid="{{$bonus_uid}}" class="!bg-[#0552cc] btn btn-secondary p-1 claimBonus claim_bonus">Claim Now</a> --}}

        </div>
        <div class="w-70 flex flex-col items-start justify-evenly">
            <div class="p-2 !text-[11px]">
                {{$description}}
            </div>
            {{-- <div class=" flex flex-row items-center justify-center">
                <img class="mx-1 w-8" src="https://img.icons8.com/?size=48&id=118497&format=png" alt="">
                <img class="mx-1 w-8" src="https://img.icons8.com/?size=48&id=32323&format=png" alt="">
                <img class="mx-1 w-8" src="https://img.icons8.com/?size=48&id=16713&format=png" alt="">
                <img class="mx-1 w-8" src="https://img.icons8.com/?size=48&id=63306&format=png" alt="">
            </div> --}}
        </div>
        
        <a href="{{(!isset($anchor))?'javascript:void(0)':route('user.bonus')}}" data-bonus_uid="{{$bonus_uid}}" class="!bg-[#0552cc] btn btn-secondary p-1 claimBonus claim_bonus !text-[11px]">Claim Now</a>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
</div>