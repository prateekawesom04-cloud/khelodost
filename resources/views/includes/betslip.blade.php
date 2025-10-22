<div id="betslip" class="m-1 md:static absolute hidden md:flex betslip" style="display:none;">
   <span id="bet_msg_error"></span>
   <span id="errmsg"></span>
   <div class="lds-dual-ring  loader" style="display:none"></div>
   <audio id="myAudio">
      <source src="https://khelodost.online/assets/images/beep.mp3" type="audio/mpeg">
   </audio>
   <div id="placeBetSilp" class="flex flex-col items-center">
      
      <div class="flex flex-row gap-2">
         <span id="nat" class="my-1"></span>
         <span id="profit" class="my-1 text-green-500"></span>
         <span id="loss" class="my-1 text-red-500"></span>
      </div>
      <div class="flex flex-row">
         <div class="stake_inputs w-50 p-2">
            <input step="0.01" id="oddVal" class="calProfitLoss odd-val odds-input form-control  CommanBtn" style="color:#000 !important">
         </div>
         <div class="stake_inputs w-50 p-2">
            <input pattern="[0-9]*" step="1" id="stakeValue" class="calProfitLoss stake-input form-control  CommanBtn">
         </div>
      </div>
      <div class="flex flex-row flex-wrap justify-evenly bet-btns">
         <button class=" chipName7" type="button" value="100">100</button>
         <button class=" chipName7" type="button" value="500">500</button>
         <button class=" chipName7" type="button" value="1000">1000</button>
         <button class=" chipName7" type="button" value="10000">10000</button>
         <button class=" chipName7" type="button" value="25000">25000</button>
         <button class=" chipName7" type="button" value="50000">50000</button>
         <button class=" chipName7" type="button" value="75000">75000</button>
         <button class=" " type="button" onclick="stakeUpdate(0);">Clear</button>
         <a href="javascript:void(0)" class="w-[46%] !bg-[#fff] !text-[#fc7600] border !border-[#fc7600]" type="button" onclick="ClearAllSelection();"> Cancel</a>
         <a href="javascript:void(0)" class="w-[46%]" onclick="placeBet();"> Place Bet</a>
      </div>
   </div>
</div>



<script>

   let betslipData = {};

   $('body').on('click','.odd-btn',function(){
      $('.betslip').show();
      updateBetslip(this);
      $('#betslipTab').tab('show');

   });

   $('#stakeValue').on('keyup',function(){
      stakeUpdate($(this).val());
   });

   $('body').on('click','.bet-btns button', function(){
      stakeUpdate($(this).val());
   });

   function updateBetslip(odd){
      
      betslipData.oddVal = $(odd).html();
      betslipData.marketId = $(odd).parents('.market_data').attr('data-marketId');
      betslipData.mname = $(odd).parents('.market_data').attr('data-mname');
      betslipData.nat = $(odd).parents('.market_data').attr('data-nat');
      
      stakeUpdate(100);
      $(odd).attr('data-oddId',betslipData.oddVal);
      $('#oddVal').val(betslipData.oddVal);
      $('#nat').html(betslipData.nat);
   }
   
   function stakeUpdate(val){
      
      // if(val < 100){
      //    responseToast('minimum stake value is 100');
      // }
      betslipData.profit = parseFloat(betslipData.oddVal*val).toFixed(2);
      betslipData.bet_amount = val;
      $('#profit').html(betslipData.profit);
      $('#loss').html(val);
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
   
   function openBets(res){
      
      if(res.code == 200){
         let bets = '';


         $(res.data).each(function(i,j){

            bets +=`
               <div class="flex flex-col rounded-md border border-[#747a87] p-2 mt-2">
                  
                  <div class="bg-[#fc7600] flex flex-row gap-2 flex-1 mt-2 p-2">
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