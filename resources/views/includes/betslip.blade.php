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

   @if($userData)
   
   // let bets = {!! json_encode($userData->bets) !!};
   let user_bets = localStorage.getItem('user_bets') ? JSON.parse(localStorage.getItem('user_bets')) : {};


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

            if(j.mname != 'Normal'){
            $(`.market_data[data-marketId='${j.marketId}']`).find(`.odd-btn[data-oddVal='${j.oddVal}']`).parents('.match_nat').find('.profit').html(j.profit);

            //    $(`.market_data[data-marketId='${j.marketId}']`).find(`.odd-btn[data-oddId='${j.oddVal}']`).parents('.match_nat').find('.profit').html(j.profit);
            // } else{
            //    $(`.market_data[data-marketId='${j.marketId}']`).find(`.odd-btn[data-oddVal='${j.oddVal}']`).parents('.match_nat').find('.profit').html(j.profit);
            // }
            $(`.market_data[data-marketId='${j.marketId}']`).find(`.odd-btn[data-oddVal!='${j.oddVal}']`).parents('.match_nat').find('.loss').html(j.bet_amount);

            $(`.market_data[data-marketId='${j.marketId}']`).find(`.odd-btn[data-oddVal='${j.oddVal}']`).parents('.match_nat').find('.loss').html('');
            } else{
               $(`.market[data-marketId='${j.marketId}']`).find(`.market_data[data-sid='${j.sid}']`).find('.match_nat').find('.profit').html(j.profit);
               
               $(`.market[data-marketId='${j.marketId}']`).find(`.market_data[data-sid='${j.sid}']`).find('.match_nat').find('.loss').html(j.bet_amount);
               
               console.log();
               

               $(`.market[data-marketId='${j.marketId}']`).find(`.market_data[data-sid='${j.sid}']`).find('.match_nat').find('.profit').after(`
                  <span class='normal_bet_range !bg-blue-600 btn text-white bg-blue-100 p-1 rounded-md'  data-score='${j.normal_oddVal}' data-amount='${j.bet_amount}' data-betType='${j.betType}' 'data-marketId='${j.marketId}' data-bettype='${j.betType}'>Bets</span>
               `);
            }
            // $('market_data[data-marketId="'+j.marketId+'"]').find(`.odd-btn[data-oddId!='${j.oddVal}']`).parent().find('.match_nat').find('.loss').html(j.loss);
         });
      }

   }
   // $(document).ready(function(){
   //    loadBets();
   // });

   @endif

   let betslipData = {};

   function profitAmount(odd, stake,mname='MATCH_ODDS'){
      if(betslipData.mname == 'Normal'){
         return parseFloat((odd*stake)/100).toFixed(2);
      } else {
         return parseFloat((odd-1)*stake).toFixed(2);
      }
      // return parseFloat((odd-1)*stake/100).toFixed(2);
   }

   $('body').on('click','.odd-btn',function(){
      // $('#betslipTab').tab('show');
      
      betslipData.oddVal = $(this).attr('data-oddVal');
      betslipData.betOn = $(this).attr('data-beton');
      betslipData.marketId = $(this).parents('.market_data').attr('data-marketId');
      betslipData.sid = $(this).parents('.market_data').attr('data-sid');
      betslipData.mname = $(this).parents('.market_data').attr('data-mname');
      
      betslipData.betType = $(this).attr('data-betType');

      if(betslipData.mname == 'Normal'){
         betslipData.normal_oddVal = betslipData.oddVal;
         betslipData.oddVal = $(this).find('.odd_size').html();
      }
      $('#betslipData').css('background',$(this).css('background'));
      $(this).parents('.market_data').append($('#betslipData').show());
      $('.betslip').show();

      // if($('.loss').length){
         $('.loss').hide();
         $('.profit').hide();
      // }

      if($(this).parents('.market').find('.market_data[data-mname=Normal]').length){

         $(this).parents('.market').find('.market_data').each(function(i,j){
            // if($(j).attr('data-marketId') != betslipData.marketId){
               // $(j).find('.match_nat').append('<span class="loss my-1 text-red-500"></span>');
               $(j).find('.match_nat').find('.loss').hide();
               $(j).find('.match_nat').find('.profit').hide();
            // }
         });
         $(this).parents('.market_data').find('.loss').show();
         $(this).parents('.market_data').find('.profit').show();

      } else{

         $(this).parents('.market').find('.market_data').each(function(i,j){
            // if($(j).attr('data-marketId') != betslipData.marketId){
               // $(j).find('.match_nat').append('<span class="loss my-1 text-red-500"></span>');
               $(j).find('.match_nat').find('.loss').show();
               $(j).find('.match_nat').find('.profit').hide();
            // }
         });
         $(this).parents('.market_data').find('.loss').hide();
         $(this).parents('.market_data').find('.profit').show();

      }

      // $(this).parents('.market_data').find('.loss').remove();
      // $(this).parents('.market_data').find('.loss').hide();
      // $(this).parents('.market_data').find('.profit').show();
      // $(this).parents('.market_data').find('.match_nat').append('<span class="profit my-1 text-green-500"></span>');
      // $(this).parents('.market_data').find('.match_nat').append('<span class="profit my-1 text-green-500"></span>');
      updateBetslip(this);
      stakeUpdate(100);

   });

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
      let marketDiv = $(`.market_data[data-marketId='${marketId}']`);
      let score = parseInt($(this).attr('data-score'));
      let amount = parseInt($(this).attr('data-amount'));

      let html = '';
      for(let i=score+6; i>=score-6 && i>=0; i--){
         
         let cls = '';
         if(!$(normal_btn).attr('data-bettype')){
            cls = (i<score) ? 'text-red-500' : 'text-green-500';
         } else{
            cls = (i>=score) ? 'text-red-500' : 'text-green-500';
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
   
   function stakeUpdate(val){
      if(val==''){
         return false;
      }
      let marketDiv = $(`.market_data[data-marketId='${betslipData.marketId}']`);
      let mname = $(marketDiv).attr('data-mname');
      // if(val < 100){
      //    responseToast('minimum stake value is 100');
      // }
      betslipData.bet_amount = val;
      odd = betslipData.oddVal;

      // if(betslipData.mname == 'Normal'){
      //    odd = $(marketDiv).find(`.odd-btn[data-oddVal='${betslipData.oddVal}']`).find('.odd_size').html();
      //    console.log('norma odd---', $(marketDiv).find(`.odd-btn[data-oddVal='${betslipData.oddVal}']`));
      //    console.log('norma odd 2---', $(marketDiv).find(`.odd-btn[data-oddVal='${betslipData.oddVal}']`).find('.odd_size'));
         
      // }

      betslipData.profit = profitAmount(odd, val,mname);

      $(marketDiv).find('.profit').html(betslipData.profit);
      $(marketDiv).find('.loss').html(val);
      // $('.loss').html(val);
      $('#stakeValue').val(val);
   
      
   }

   function placeBet(){

      marketId = $(`.market_data[data-marketId='${betslipData.marketId}']`);
      // marketId = $(`.market[data-marketId='${betslipData.marketId}']`);

      if(betslipData.mname == 'Normal'){
         betslipData.oddVal = $(marketId).find(`.odd-btn[data-oddId='${betslipData.oddVal}']`).find('.odd_size').html();
         
      } else{
         odd = $(marketId).find(`.odd-btn[data-oddId='${betslipData.oddVal}']`).find('span').html();
      }
      
      console.log('odd----',odd);
      

      if(odd != betslipData.oddVal){
         responseToast('Odd changed');
         $('.betslip').hide();
         $('.loss').hide();
         $('.profit').hide();
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
         if(betslipData.mname == 'Normal'){

            $(`.market[data-marketId='${betslipData.marketId}']`).find(`.market_data[data-sid='${betslipData.sid}']`).find(`.odd-btn[data-size='${betslipData.oddVal}']`).parents('.match_nat').find('.profit').after(`
               <span class='normal_bet_range !bg-blue-600 btn text-white bg-blue-100 p-1 rounded-md' data-score='${betslipData.normal_oddVal}' data-amount='${betslipData.bet_amount}' data-betType='${betslipData.betType}' data-marketId='${betslipData.marketId}'>Bets</span>
            `);

         }

         callApi('get','{{route('user.openbets')}}',null,openBets);
      }
   }
   
   function cancelBet(){
      $('.betslip').hide();
      $('.loss').hide();
      $('.profit').hide();
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