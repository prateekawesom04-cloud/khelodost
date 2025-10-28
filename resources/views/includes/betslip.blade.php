<div id="betslipData" class="flex betslip" style="display:none;">
   <span id="bet_msg_error"></span>
   <span id="errmsg"></span>
   <div class="lds-dual-ring  loader" style="display:none"></div>
   <audio id="myAudio">
      <source src="https://khelodost.online/assets/images/beep.mp3" type="audio/mpeg">
   </audio>
   <div id="placeBetSilp" class="flex flex-col items-center">
      
      {{-- <div class="flex flex-row gap-2">
         <span id="nat" class="my-1"></span>
         <span id="profit" class="my-1 text-green-500"></span>
         <span id="loss" class="my-1 text-red-500"></span>
      </div> --}}
      <div class="flex flex-row flex-wrap justify-evenly items-center bet-btns">
         <div class="col-6 p-[0.4rem]">
            <div class="flex flex-col gap-1">
                  {{-- <label for="">Odds</label> --}}
                     <div class="flex flex-row justify-center items-center gap-1">
                        <span class="p-1 !bg-[#273393] h-full w-[25px] flex justify-center items-center text-white">+</span>
                        <div class="stake_inputs w-[70%]">
                           <input type="number" pattern="[0-9]*" step="1" id="stakeValue" class="calProfitLoss stake-input form-control text-center p-0 border-0 CommanBtn ">
                        </div>
                        <span class="p-1 !bg-[#273393] h-full w-[25px] flex justify-center items-center text-white">-</span>
                     </div>
            </div>
         </div>
         <div class="col-6 p-[0.4rem]">
            {{-- <label for="">Stake</label> --}}
            <input type="number" pattern="[0-9]*" step="1" id="oddVal" class="calProfitLoss odd-val odds-input form-control text-center p-0 border-0 CommanBtn">
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="100">100</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="500">500</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="1000">1000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="10000">10000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="25000">25000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="50000">50000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="75000">75000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" value="100000">100000</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#2888ef] text-white" value="100">Min Stake</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#273393] text-white" value="100000">Max Stake</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#066d11] text-white" onclick="">Edit Stake</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#ff1c1c] text-white" value="0">Clear</button>
         </div>
         <div class="col-6 p-[0.1rem]">
            {{-- <button href="javascript:void(0)" class="!!bg-[#fff] !text-[#fc7600] border !border-[#fc7600]" type="button" value="0"> Cancel</button> --}}
            <button onclick="cancelBet();" class="!bg-[#e86779] text-white" type="button" value="0"> Cancel</button>
         </div>
         <div class="col-6 p-[0.1rem]">
            <button href="javascript:void(0)" class="!bg-[#15b526] text-white" onclick="placeBet();"> Place Bet</button>
         </div>
      </div>
   </div>
</div>



<script>

   let betslipData = {};

   function profitAmount(odd, stake){
      return parseFloat((odd-1)*stake/100).toFixed(2);
   }

   $('body').on('click','.odd-btn',function(){
      // $('#betslipTab').tab('show');
      betslipData.oddVal = $(this).attr('data-oddVal');
      betslipData.marketId = $(this).parents('.market_data').attr('data-marketId');
      $('#betslipData').css('background',$(this).css('background'));
      $(this).parents('.market_data').append($('#betslipData').show());
      $('.betslip').show();

      if($('.loss').length){
         $('.loss').remove();
         $('.profit').remove();
      }

      $(this).parents('.market').find('.market_data').each(function(i,j){
         // if($(j).attr('data-marketId') != betslipData.marketId){
            $(j).find('.match_nat').append('<span class="loss my-1 text-red-500"></span>');
         // }
      });
      $(this).parents('.market_data').find('.loss').remove();
      $(this).parents('.market_data').find('.match_nat').append('<span class="profit my-1 text-green-500"></span>');
      updateBetslip(this);
      stakeUpdate(100);

   });

   $('#stakeValue').on('keyup',function(){
      stakeUpdate($(this).val());
   });

   $('body').on('click','.bet-btns button', function(){
      stakeUpdate($(this).val());
   });

   function updateBetslip(odd){
      
      // betslipData.mname = $(odd).parents('.market_data').attr('data-mname');
      // betslipData.nat = $(odd).parents('.market_data').attr('data-nat');
      
      $(odd).attr('data-oddId',betslipData.oddVal);
      $('#oddVal').val(betslipData.oddVal);
      // $('#nat').html(betslipData.nat);
   }
   
   function stakeUpdate(val){
      
      // if(val < 100){
      //    responseToast('minimum stake value is 100');
      // }
      betslipData.bet_amount = val;
      betslipData.profit = profitAmount(betslipData.oddVal, val);
      $('.profit').html(betslipData.profit);
      $('.loss').html(val);
      $('#stakeValue').val(val);
   }

   function placeBet(){

      marketId = $(`.market_data[data-marketId='${betslipData.marketId}']`);
      
      odd = $(marketId).find(`.odd-btn[data-oddId='${betslipData.oddVal}']`).html();
      
      if(odd != betslipData.oddVal){
         responseToast('Odd changed');
         $('.betslip').hide();
         return false;
      }

      if($('#stakeValue').val() < 100){
         responseToast('minimum stake value is 100');
         return false;
      }
      callApi('post',`{{route('user.placebet')}}`,betslipData,postPlacebet);

   }
   
   function postPlacebet(res){
      ajaxResponse(res);
      if(res.code == 200){
         callApi('get','{{route('user.openbets')}}',null,openBets);
      }
   }
   
   function cancelBet(){
      $('.betslip').hide();
      $('.loss').remove();
      $('.profit').remove();
   }

   function openBets(res){
      
      if(res.code == 200){
         let bets = '';


         $(res.data).each(function(i,j){

            bets +=`
               <div class="flex flex-col rounded-md border border-[#747a87] p-2 mt-2">
                  
                  <div class="!bg-[#2888ef] flex flex-row gap-2 flex-1 mt-2 p-2">
                     <span class="t_data w-[40%]">BetId</span>
                     <span class="t_data w-[20%]">Date</span>
                     <span class="t_data w-[20%]">Odd Value</span>
                     <span class="t_data w-[20%]">Bet Amount</span>
                  </div>
                  <div class="flex fex-row gap-2 flex-1">
                     <div class="t_data w-[40%]">${this.betId}</div>
                     <div class="t_data w-[20%]">${formatData(this.created_at)}</div>
                     <div class="t_data w-[20%]">${this.oddVal}</div>
                     <div class="t_data w-[20%]">${this.bet_amount}</div>
                  </div>
                                 
               </div>
            `;

         });

         $('#openbets').html(bets);
         $('#openBetsTab').tab('show');
      }
   }

   $(document).ready(function(){
      callApi('get','{{route('user.openbets')}}',null,openBets);
   });

</script>