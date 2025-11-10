
<div class="modal fade" id="normalbet_range" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fancy Position</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6 id="transactionHeader" class="fw-semibold text-dark mb-3" style="font-size: 13px;"></h6>

        <div class="flex flex-row items-center justify-evenly bg-[#000] p-2 mb-3 text-white" style="font-size: 12px;">
            <div>Score</div>
            <div>Amount</div>
        </div>
        <div class="flex flex-row items-center justify-evenly g-2 mb-3">
            <div class="score_range"></div>
            <div class="amount_range"></div>
            
        </div>
        <div class="normalbet_ranges flex flex-col">
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">106</div>
                <div class="value text-red-500">-102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">105</div>
                <div class="value text-red-500">-102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">104</div>
                <div class="value text-red-500">-102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">103</div>
                <div class="value text-red-500">-102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">102</div>
                <div class="value text-red-500">-102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">100</div>
                <div class="value text-green-500">102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">99</div>
                <div class="value text-green-500">102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">98</div>
                <div class="value text-green-500">102</div>                
            </div>
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
                <div class="score">97</div>
                <div class="value text-green-500">102</div>                
            </div>
        </div>

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