
<div class="modal fade" id="showBonus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="row g-2 mb-3 ">
            @if($claim_bonus)
                @foreach($shareBonus as $bonus)
                <div class="col-6 mb-2 mx-auto">
                    {{$bonus['description']}}
                </div>
                @endforeach
            @endif
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary claim_bonus" data-bs-dismiss="modal">Claim</button>
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