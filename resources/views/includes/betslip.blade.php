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
      <div class="flex flex-row flex-wrap justify-evenly items-center bet-btns w-full">
         <div class="col-6 p-[0.4rem]">
            <div class="flex flex-col gap-1">
                  {{-- <label for="">Odds</label> --}}
                     <div class="flex flex-row justify-center items-center gap-1">
                        {{-- <span class="p-1 !bg-[#273393] h-full w-[25px] flex justify-center items-center text-white">+</span> --}}
                        <div class="stake_inputs w-[70%]">
                           <input type="number" pattern="[0-9]*" step="1" id="stakeValue" class="calProfitLoss stake-input form-control text-center p-0 border-0 CommanBtn ">
                        </div>
                        {{-- <span class="p-1 !bg-[#273393] h-full w-[25px] flex justify-center items-center text-white">-</span> --}}
                     </div>
            </div>
         </div>
         <div class="col-6 p-[0.4rem]">
            {{-- <label for="">Stake</label> --}}
            <input type="number" pattern="[0-9]*" step="1" id="oddVal" class="calProfitLoss odd-val odds-input form-control text-center p-0 border-0 CommanBtn">
         </div>
         @if(isset($stakes) && count($stakes))
            @foreach($stakes as $stake)
            <div class="col-3 p-[0.1rem]">
               <button type="button" value="{{$stake}}">{{$stake}}</button>
            </div>
            @endforeach
         @endif

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
      </div>
      
      <div class="flex flex-row flex-wrap justify-evenly items-center bet-btns w-full">
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#2888ef] text-white" value="100">Min Stake</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#273393] text-white" value="100000">Max Stake</button>
         </div>
         <div class="col-3 p-[0.1rem]">
            <button type="button" class="!bg-[#066d11] text-white addStake">Edit Stake</button>
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
   
   $('body').on('click','.odd-btn',function(){
      
      betslipData.oddId = $(this).attr('data-oddId');
      betslipData.oddVal = $(this).attr('data-oddVal');
      betslipData.betType = $(this).attr('data-betType');
      betslipData.size = $(this).attr('data-size');
      betslipData.sid = $(this).parents('.market_row').attr('data-sid');
      betslipData.marketId = $(this).parents('.market').attr('data-marketId');
      betslipData.mname = $(this).parents('.market').attr('data-mname');
      betslipData.gtype = $(this).parents('.market').attr('data-gtype');

      $('#betslipData').css('background',$(this).css('background'));
      $(this).parents('.market_row').append($('#betslipData').show());

      $('.betslip').show();

      stakeUpdate(100);

   });

   function betCalculation(betslipData){
      
      let profit = 0;
      let market_row = $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`);
      let other_rows = $(`.market_${betslipData.marketId}`).find(`.market_row[data-sid!='${betslipData.sid}']`);

      if(betslipData.mname == 'Normal'){
         // $('#oddVal').val(betslipData.size);
         profit = parseFloat((betslipData.size * betslipData.bet_amount)/100).toFixed(2);
         $(other_rows).each(function(i,j){
            $(j).find('.loss').html('');
            $(j).find('.profit').html('');
         });
         $(market_row).find('.loss').html(betslipData.bet_amount);
      } else {
         $(market_row).find('.loss').html('');
         $(other_rows).each(function(i,j){
            $(j).find('.loss').html(betslipData.bet_amount);
            $(j).find('.profit').html('');
         });
         profit = parseFloat((betslipData.oddVal - 1) * betslipData.bet_amount).toFixed(2);
      }
      $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`).find('.profit').html(profit);

      return profit;
   }

   let user_bets = {};

   @if($userData)
   
   // let bets = {!! json_encode($userData->bets) !!};
   let bets = '';
   // bets = JSON.parse(bets);
   user_bets = (bets && bets!='') ? bets : localStorage.getItem('user_bets') ? JSON.parse(localStorage.getItem('user_bets')) : {};
   // user_bets = localStorage.getItem('user_bets') ? JSON.parse(localStorage.getItem('user_bets')) : {};


   function normalbet_range(score, amount){
      let html = '';
      for(let i=score+6; i>=score-6 && i>=0; i--){
         if(!j.betType){
            let cls = (i<score) ? 'text-red-500' : 'text-green-500';
         } else{
            let cls = (i>=score) ? 'text-red-500' : 'text-green-500';
         }
         html +=`
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
               <div class="score">${i}</div>
               <div class="value ${cls}">${amount}</div>                
            </div>
         `;
      }
      $('.normalbet_ranges').html(html);
   }

   function loadBets(){

      if(Object.keys(user_bets).length){
         
         $.each(user_bets, function(i,j){
            $('.loss').show();
            $('.profit').show();
            let market_row = $(`.market_${j.marketId}`).find(`.market_row_${j.sid}`);
            let other_rows = $(`.market_${j.marketId}`).find(`.market_row[data-sid!='${j.sid}']`);

            
            let odd = $(market_row).find(`.odd-btn[data-tno='${j.tno}']`).attr('data-oddVal');
            // let odd = $(market_row).find(`.odd-btn[data-tno='${j.tno}']`).find('span').html();

            if(j.mname == 'Normal'){
               $(market_row).find('.profit').html(j.profit);
               $(market_row).find('.loss').html(j.bet_amount);

               $(market_row).find('.normal_bet_range').remove();
               $(market_row).find(`.match_nat`).append(`
                  <span class='normal_bet_range !bg-blue-600 btn text-white bg-blue-100 p-1 rounded-md' data-score='${j.oddVal}' data-size="${j.size}" data-amount='${j.bet_amount}' data-betType='${j.betType}' data-marketId='${j.marketId}'>Bets</span>
               `);

            } else{
               $(other_rows).each(function(i,k){
                  $(k).find('.loss').html(j.bet_amount);
               });
               $(market_row).find('.profit').html(j.profit);
            }

         });
      }

   }
   // $(document).ready(function(){
   //    loadBets();
   // });

   @endif


   $('#stakeValue').on('keyup',function(){
      stakeUpdate($(this).val());
   });

   $('body').on('click','.bet-btns button', function(){
      if(!$(this).hasClass('addStake')){
         stakeUpdate($(this).val());
      } else{
         @if($userData)
            $('#addStake').modal('show');
         @endif
      }
   });

   $('body').on('click','.normal_bet_range', function(){
      let normal_btn = $(this);
      let marketId = $(this).attr('data-marketId');
      let marketDiv = $(`.market[data-marketId='${marketId}']`);
      let score = parseInt($(this).attr('data-score'));
      let amount = parseInt($(this).attr('data-amount'));
      let size = $(this).attr('data-size');

      let html = '';
      for(let i=score+6; i>=score-6 && i>=0; i--){
         
         let cls = '';
         if($(normal_btn).attr('data-betType')==0){
            cls = (i<score) ? 'text-red-500' : 'text-green-500';
            amount = (i<score) ? amount : size;
         } else{
            cls = (i>=score) ? 'text-red-500' : 'text-green-500';
            amount = (i>=score) ? amount : size;
         }
         html +=`
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
               <div class="score">${i}</div>
               <div class="value ${cls}">${amount}</div>                
            </div>
         `;
      }
      $('.normalbet_ranges').html(html);
      // normalbet_range(parseInt(score), amount);
      $('#normalbet_range').modal('show');
   });

   function updateBetslip(odd){
      
      // betslipData.mname = $(odd).parents('.market_data').attr('data-mname');
      // betslipData.nat = $(odd).parents('.market_data').attr('data-nat');
      
      $(odd).attr('data-oddId',betslipData.oddVal);
      $('#oddVal').val(betslipData.oddVal);
      // $('#nat').html(betslipData.nat);
   }
   
   function stakeUpdate(stakeVal){
      if(stakeVal==''){
         return false;
      }
      
      betslipData.bet_amount = stakeVal;

      betslipData.profit = betCalculation(betslipData);

      $('#stakeValue').val(stakeVal);
      $('#oddVal').val(betslipData.oddVal);
   
      
   }

   function placeBet(){

      market_row = $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`);

      let odd = $(market_row).find(`.odd-btn[data-oddId='${betslipData.oddId}']`).attr('data-oddVal');

      console.log('odd-',odd);
      console.log('betsffd-',betslipData);
      
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
         $('.betslip').hide();
         user_bets[`${betslipData.marketId}_${betslipData.sid}`] = betslipData;
         localStorage.setItem('user_bets', JSON.stringify(user_bets));
         loadBets();

         callApi('get','{{route('user.openbets')}}',null,openBets);
      }
   }
   
   function cancelBet(){
      $('.betslip').hide();
      $('.loss').html('');
      $('.profit').html('');
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