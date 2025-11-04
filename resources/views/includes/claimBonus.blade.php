<div class="notification_bar">
    <div class="alert fade show flex flex-row items-center justify-evenly border-b !border-[#0552cc] py-1" role="alert">
        <div class="w-75">
            {{$description}}
        </div>
        <a href="{{(!isset($anchor))?'javascript:void(0)':route('user.bonus')}}" data-bonus_uid="{{$bonus_uid}}" class="!bg-[#0552cc] btn btn-secondary p-1 claimBonus claim_bonus">Claim Now</a>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
</div>