
<div class="modal fade" id="showBonus" tabindex="-1" aria-hidden="true">
  <div class="flex items-center justify-center modal-dialog w-full h-full">
    <div class="modal-content !w-[280px] mx-auto text-center">
      <div class="modal-header border-0">
        {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="flex flex-col g-2 mb-3 items-center justify-center gap-3">
            <div class="text-[#0552cc] text-[13px]">Today's Bonus</div>
            {{-- <span>Testing</span> --}}
            @if($claim_bonus)
                @foreach($shareBonus as $bonus)
                <div class="col-6 mb-2 mx-auto">
                    {{$bonus['description']}}
                </div>
                @endforeach
            @endif
          <a href="{{route('user.bonus')}}" type="button" class="btn btn-primary bg-[#0552cc] claim_bonus">Claim Now</a>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
      if(localStorage.getItem('showBonusModal') !== 'shown'){
          // localStorage.setItem('showBonusModal', 'shown');
        // $('#showBonus').modal('show');
        $('.indexBonus').show();
      }
        $('.claim_bonus').click(function(){
            localStorage.setItem('showBonusModal', 'shown');
            // window.location.href = '{{route('user.sport','cricket')}}';
        });
    });
</script>