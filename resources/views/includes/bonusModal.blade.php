
<div class="modal fade" id="showBonus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
      </div>
      <div class="modal-body">

        <div class="flex flex-col g-2 mb-3 items-center justify-center gap-3">
            <div class="text-[#0c0339] text-[13px]">Today's Bonus</div>
            <span>Testing</span>
            @if($claim_bonus)
                @foreach($shareBonus as $bonus)
                <div class="col-6 mb-2 mx-auto">
                    {{$bonus['description']}}
                </div>
                @endforeach
            @endif
          <button type="button" class="btn btn-primary bg-[#0c0339] claim_bonus" data-bs-dismiss="modal">Claim Now</button>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('#showBonus').modal('show');

        // $('.claim_bonus').click(function(){
        //     window.location.href = '{{route('user.sport','cricket')}}';
        // });
    });
</script>