
<div class="modal fade" id="addStake" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Stake</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="transactionHeader" class="fw-semibold text-dark mb-3" style="font-size: 13px;"></h6>
        <input type="text" class="form-control mb-3" id="stakeAmount" placeholder="Enter Stake..."
            style="font-size: 12px;">

        <div class="row g-2 mb-3 ">
            @if(isset($stakes) && count($stakes))
                @foreach($stakes as $stake)
                <div class="col-6 mb-2 mx-auto">
                    <a class="btn w-100 !bg-[#2888ef]" data-amount="{{$stake}}" style="font-size: 12px;">{{$stake}}</a>
                </div>
                @endforeach
            @endif
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary submitStake" data-bs-dismiss="modal">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('.submitStake').click(function(){
        if($('#stakeAmount').val()==''){
            alert('Please Enter Stake');
            return false;
        }
        let data = {
            stake: $('#stakeAmount').val()
        };
        callApi('post', '{{route('user.post.addStake')}}', data, addStake);

    });

    function addStake(response){
        alert(response.message);
        window.location.reload();
    }

    $('.amount-btn').click(function() {
        $('.amount-btn').removeClass('active');
        $(this).addClass('active');
        $('#stakeAmount').val($(this).attr('data-amount'));
    });
</script>