<div id="betslipData" class="flex betslip w-full relative" style="display:none;">
   <span id="bet_msg_error"></span>
   <span id="errmsg"></span>
   <div class="lds-dual-ring  loader" style="display:none"></div>
   <audio id="myAudio">
      <source src="https://khelodost.online/assets/images/beep.mp3" type="audio/mpeg">
   </audio>
   <div id="placeBetSilp" class="flex flex-col items-center w-full">
      
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
   <div class="placebetOverlay absolute w-full h-100 bg-[#050505de] text-white flex items-center justify-center" style="display:none;">
      Please Wait...
   </div>
</div>



<script>
   
   let betslipData = {};
   
   $('body').on('click','.odd-btn',function(){
      betslipData = {};
      betslipData.eventId = eventId;
      betslipData.oddId = $(this).attr('data-oddId');
      betslipData.oddVal = $(this).attr('data-oddVal');
      betslipData.betType = $(this).attr('data-betType');
      betslipData.size = $(this).attr('data-size');
      betslipData.sid = $(this).parents('.market_row').attr('data-sid');
      betslipData.nat = $(this).parents('.market_row').find('.match_nat_name').text();
      betslipData.marketId = $(this).parents('.market').attr('data-marketId');
      betslipData.mname = $(this).parents('.market').attr('data-mname');
      betslipData.gtype = $(this).parents('.market').attr('data-gtype');

      $('#betslipData').css('background',$(this).css('background'));
      $(this).parents('.market_row').append($('#betslipData').show());

      $('.betslip').show();

      stakeUpdate(100);

   });
 
   function stakeUpdate(stakeVal){
      if(stakeVal==''){
         return false;
      }
      
      betslipData.bet_amount = stakeVal;

      betslipData.profit = betCalculation(betslipData);

      user_bets['running_bet'] = betslipData;

      resultCalculation(betslipData.marketId);

      loadBets();

      $('#stakeValue').val(stakeVal);
      $('#oddVal').val(betslipData.oddVal);
   
      
   }

   function betCalculation(betslipData){
      
      let profit = 0;
      // let market_row = $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`);
      // let other_rows = $(`.market_${betslipData.marketId}`).find(`.market_row[data-sid!='${betslipData.sid}']`);

      if(betslipData.mname == 'Normal'){
         // $('#oddVal').val(betslipData.size);
         profit = parseFloat((betslipData.size * betslipData.bet_amount)/100).toFixed(2);
         // $(other_rows).each(function(i,j){
         //    $(j).find('.loss').html('');
         //    $(j).find('.profit').html('');
         // });
         // $(market_row).find('.loss').html(betslipData.bet_amount);
      } else if(betslipData.mname == 'Bookmaker'){
         profit = parseFloat(betslipData.oddVal).toFixed(2);
      } else {
         // $(market_row).find('.loss').html('');
         // $(other_rows).each(function(i,j){
         //    $(j).find('.loss').html(betslipData.bet_amount);
         //    $(j).find('.profit').html('');
         // });
         profit = parseFloat((betslipData.oddVal - 1) * betslipData.bet_amount).toFixed(2);
      }
      // $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`).find('.profit').html(profit);

      return profit;
   }

   function resultCalculation(marketId){
      // let marketTotal = {};
      
      
      let marketProfit = {};

      let market = $(`.market_${marketId}`);
      let market_row = $(market).find('.market_row');
      
      let marketBets = Object.values(user_bets).filter(i=>i.marketId == marketId);
      
      // console.log("$(market).attr('data-mname')----",$(market).attr('data-mname'));
      
      

      if(!marketBets.length){
         return false;
      }

      $(market_row).each(function(k,row){
      
         
         let sid = $(row).attr('data-sid');
         
         marketProfit[sid] = marketProfit[sid] ?? 0;
         
         
         $(marketBets).each(function(i,j){
            
            j.profit = parseFloat(j.profit);
            j.bet_amount = parseFloat(j.bet_amount);

            
            if($(market).attr('data-mname') == 'Normal'){
               console.log('before---',marketProfit[sid]);
               
               if(sid == j.sid){
                  if(j.betType == '0'){
                     marketProfit[sid] = marketProfit[sid] + j.profit;

                  } else{
                     marketProfit[sid] = marketProfit[sid] - j.profit;
                  }
               console.log('after---',marketProfit[sid]);
               }
            } else{
               if(sid == j.sid){
                  if(j.betType == '0'){
                     marketProfit[sid] = marketProfit[sid] + j.profit;
   
                  } else{
                     marketProfit[sid] = marketProfit[sid] - j.profit;
                  }
               } else{
                  if(j.betType == '0'){
                     marketProfit[sid] = marketProfit[sid] - j.bet_amount;
   
                  } else{
                     marketProfit[sid] = marketProfit[sid] + j.bet_amount;
                  }
               }

            }
         });

         
         if(marketProfit[sid] < 0){
            $(row).find('.profit').removeClass('text-success');
            $(row).find('.profit').addClass('text-danger');
         } else{
            $(row).find('.profit').removeClass('text-danger');
            $(row).find('.profit').addClass('text-success');
         }
         $(row).find('.profit').html(Math.abs(marketProfit[sid]));
      });
      
   }


   let user_bets = {};

   @if($userData)
   // let bets = {!! json_encode($userData->bets) !!};
   // let betsData = '';
   // bets = JSON.parse(betsData);
   // user_bets = (betsData && betsData!='') ? betsData : localStorage.getItem('user_bets') ? JSON.parse(localStorage.getItem('user_bets')) : {};
@endif
   user_bets = localStorage.getItem('user_bets') ? JSON.parse(localStorage.getItem('user_bets')) : {};


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
      callApi('get','{{route('user.eventBets')}}',{gtype:0,eventId:eventId},openBetsBottom);

      if(Object.keys(user_bets).length){
         
         // let sid = {};

         // let sidResult = {};
         
         $.each(user_bets, function(i,j){

            // sid[j.sid] = sid[j.sid]??{};
            
            // sid[j.sid] = sid[j.sid]??0;
            

            let market_row = $(`.market_${j.marketId}`).find(`.market_row_${j.sid}`);
            let other_rows = $(`.market_${j.marketId}`).find(`.market_row[data-sid!='${j.sid}']`);

            // // sidResult[j.marketId] = sidResult[j.marketId] ?? {};
            
            // $(other_rows).each(function(){
            //    user_bets[this.marketId+'_'+this.sid+'_'+this.oddId]
            // })

            // let profit = 0;

            
            // if(j.betType){
            //    sid[j.sid]['loss'] = (sid[j.sid]['loss'] ?? 0) + j.bet_amount;
            //    sid[j.sid]['profit'] = (sid[j.sid]['profit'] ?? 0) + j.profit;
            // } else{
            //    sid[j.sid]['loss'] = Math.abs(j.bet_amount - (sid[j.sid]['loss'] ?? 0));
            //    sid[j.sid]['profit'] = Math.abs(j.profit - (sid[j.sid]['profit'] ?? 0));
            // }

            // sid[j.sid][j.marketId] = sid[j.sid]['profit'] - sid[j.sid]['loss'];

            // // sid[j.sid]['profit'] -= sid[j.sid]['loss'];
            
            // if(sid[j.sid]['profit'] < 0){
            //    $(market_row).find('.profit').removeClass('text-success');
            //    $(market_row).find('.profit').addClass('text-danger');
            // } else{
            //    $(market_row).find('.profit').removeClass('text-danger');
            //    $(market_row).find('.profit').addClass('text-success');
            // }
            
            $(market_row).find('.loss').html('');
            // $(market_row).find('.loss').hide();
            // $('.loss').show();
            $('.profit').show();

            
            // let odd = $(market_row).find(`.odd-btn[data-tno='${j.tno}']`).attr('data-oddVal');
            // let odd = $(market_row).find(`.odd-btn[data-tno='${j.tno}']`).find('span').html();

            if(j.mname == 'Normal'){
            
               // $(market_row).find('.loss').html(sid[j.sid]['loss']);
               // $(market_row).find('.profit').html(sid[j.sid]['profit']);
               // $(market_row).find('.profit').html(j.profit);
               // $(market_row).find('.loss').html(j.bet_amount);
               let size = parseFloat($(market_row).find('.profit').text());
               console.log('size--',size);
               
               $(market_row).find('.normal_bet_range').remove();
               $(market_row).find(`.match_nat`).append(`
                  <span class='normal_bet_range !bg-blue-600 btn text-white bg-blue-100 p-1 rounded-md mx-2' data-score='${j.oddVal}' data-size="${size}" data-amount='${j.bet_amount}' data-betType='${j.betType}' data-marketId='${j.marketId}' style="width: 20px;height: 20px;display: flex;align-items: center;justify-content: center;">i</span>
               `);
            

            } else{
               // $(other_rows).each(function(i,k){
                  // $(k).find('.loss').html(j.bet_amount);
                  // $(k).find('.loss').html(sid[j.sid]['loss']);
               // });
               // $(market_row).find('.profit').html(j.profit);
               // $(market_row).find('.loss').html(sid[j.sid]['loss']);
               // $(market_row).find('.profit').html(sid[j.sid]['profit']);
            }
            
         });

         // let allMarkets = [];
         $('.market').each(function(){
            // allMarkets[] = $(this).attr('data-marketId');
            resultCalculation($(this).attr('data-marketId'));
         });
         
      }

   }
   // $(document).ready(function(){
   //    loadBets();
   // });



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
         // if($(normal_btn).attr('data-betType')==0){
            cls = (i<score) ? 'text-red-500' : 'text-green-500';
            samount = (i<score) ? amount : size;
         // } else{
         //    cls = (i>=score) ? 'text-red-500' : 'text-green-500';
         //    amount = (i>=score) ? amount : size;
         // }
         html +=`
            <div class="flex flex-row items-center justify-evenly g-2 mb-3">
               <div class="score">${i}</div>
               <div class="value ${cls}">${samount}</div>                
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
  

   function placeBet(){
      $('.placebetOverlay').show();

      let min_stake = {{isset($UserGeneralSetting->min_stake)?$UserGeneralSetting->min_stake:100}};
      let max_stake = {{isset($UserGeneralSetting->max_stake)?$UserGeneralSetting->max_stake:100000}};
      let min_odds = {{isset($UserGeneralSetting->min_odds)?$UserGeneralSetting->min_odds:1}};
      let max_odds = {{isset($UserGeneralSetting->max_odds)?$UserGeneralSetting->max_odds:40}};
      let bet_delay = {{isset($UserGeneralSetting->bet_delay)?$UserGeneralSetting->bet_delay:2}};

      setTimeout(() => {

         $('.placebetOverlay').hide();

         if(!sportStatus || !eventStatus){
            responseToast('Bet Placement Not Allowed');
            $('.betslip').hide();
            return false;
         }
         market_row = $(`.market_${betslipData.marketId}`).find(`.market_row_${betslipData.sid}`);

         let odd = $(market_row).find(`.odd-btn[data-oddId='${betslipData.oddId}']`).attr('data-oddVal');

         if(odd != betslipData.oddVal){
            responseToast('Odd changed');
            $('.betslip').hide();
            return false;
         }
         
         if($('#stakeValue').val() < min_stake){
            responseToast('Minimum stake value is '+min_stake);
            return false;
         }
         if($('#stakeValue').val() > max_stake){
            responseToast('Maximum stake value is '+max_stake);
            return false;
         }
         if($('#oddVal').val() < min_odds){
            responseToast('Minimum odd value is '+min_odds);
            return false;
         }
         if($('#oddVal').val() > max_odds){
            if(betslipData.mname != "Normal"  && betslipData.mname != "Bookmaker"){
               responseToast('Maximum odd value is '+max_odds);
               return false;
            }
         }
         callApi('post',`{{route('user.placebet')}}`,betslipData,postPlacebet);

      }, bet_delay*1000);

   }
   
   function postPlacebet(res){
   
      ajaxResponse(res);
      if(res.response_code == 200){
         refreshWallet();
         $('.betslip').hide();
         // $.extend({}, obj1, obj2)
         if(user_bets[`${betslipData.marketId}_${betslipData.sid}_${betslipData.oddId}`]){
            
            bet = user_bets[`${betslipData.marketId}_${betslipData.sid}_${betslipData.oddId}`];
            // $.each(bet,function(i,j){
               
               
               // if(betslipData.mname == 'Normal'){

               // } else{
                  betslipData['bet_amount']=parseInt(bet['bet_amount']) + parseInt(betslipData['bet_amount']);
                  betslipData['profit']=parseInt(bet['profit']) + parseInt(betslipData['profit']);
                  // betslipData['profit']+=bet['profit'];
               // }
               
               
            // });
            // user_bets[`${betslipData.marketId}_${betslipData.sid}_${betslipData.oddId}`] = betslipData;
         // } else{
         
            
         //    user_bets[`${betslipData.marketId}_${betslipData.sid}_${betslipData.oddId}`] = betslipData;
         }
         delete user_bets['running_bet'];
         $('.betslip').hide();
         user_bets[`${betslipData.marketId}_${betslipData.sid}_${betslipData.oddId}`] = betslipData;
         localStorage.setItem('user_bets', JSON.stringify(user_bets));
         loadBets();

         callApi('get','{{route('user.eventBets')}}',betslipData,openBetsBottom);
      }
   }
   
   function cancelBet(){
      $('.betslip').hide();
      // $('.loss').html('');
      // $('.profit').html('');
      delete user_bets['running_bet'];
      loadBets();
   }

   function openBets(res){
      
      if(res.response_code == 200){
         let bets = '';

         bets +=`
            <div class="flexTable flex flex-col rounded-md border border-[#747a87] p-2 mt-2">
               
               <div class="flexTableHead !bg-[#2888ef] flex flex-row gap-2 flex-1 mt-2 p-2">
                  <span class="flexTableItem t_data">BetId</span>
                  <span class="flexTableItem t_data">Date</span>
                  <span class="flexTableItem t_data">Odd Value</span>
                  <span class="flexTableItem t_data">Bet Amount</span>
               </div>
         `;

         $(res.data).each(function(i,j){

            bets +=`
                  <div class="flexTableRow flex fex-row gap-2 flex-1">
                     <div class="flexTableItem t_data">${this.betId}</div>
                     <div class="flexTableItem t_data">${formatData(this.created_at)}</div>
                     <div class="flexTableItem t_data">${this.oddVal}</div>
                     <div class="flexTableItem t_data">${this.bet_amount}</div>
                  </div>
                        
            `;

         });
         bets+=`           
               </div>
            `;

         $('#openbets').html(bets);
         $('#openBetsTab').tab('show');
      }
   }
   
   // function openBetsBottom(res){
      
   //    if(res.response_code == 200){
   //       let bets = '';

   //       bets +=`
   //          <div class="flex flex-col rounded-md border border-[#747a87] p-2 mt-2 overflow-x-auto">
               
   //             <div class="!bg-[#2888ef] flex flex-row gap-2 flex-1 mt-2 p-2">
   //                <span class="flexTableItem t_data">No.</span>
   //                <span class="flexTableItem t_data">Bhaw</span>
   //                <span class="flexTableItem t_data">BetType</span>
   //                <span class="flexTableItem t_data">Time</span>
   //                <span class="flexTableItem t_data">ip</span>
   //             </div>
   //       `;

   //       $(res.data).each(function(i,j){

   //          bets +=`
   //                <div class="flex fex-row gap-2 flex-1">
   //                   <div class="flexTableItem t_data">${i}</div>
   //                   <div class="flexTableItem t_data">${this.oddVal}</div>
   //                   <div class="flexTableItem t_data">${this.betOn?'Lay':'Back'}</div>
   //                   <div class="flexTableItem t_data">${formatData(this.created_at)}</div>
   //                   <div class="flexTableItem t_data">${this.ip}</div>
   //                </div>
                       
   //          `;

   //       });
   //       bets+=`           
   //             </div>
   //          `;

   //       $('.allBetList').html(bets);
   //       $('#openBetsTab').tab('show');
   //    }
   // }

   
   function openBetsBottom(res){
      
      if(res.response_code == 200){
         $('.allBetList').html('');
         let bets = '';
         
         $('.allBetCount').find('span').html($(res.data).length);
         $('.fancyBetCount').find('span').html(res.normalBets);

         bets +=`
            <table class="table text-center flex flex-col rounded-md border border-[#747a87] p-2 mt-2 overflow-x-auto">
               
               <thead class="flex flex-row gap-2 flex-1 mt-2">
                  <tr class="!bg-[#349afa] w-100">
                     <th class="flexTableItem t_data">No.</th>
                     <th class="flexTableItem t_data">Runner</th>
                     <th class="flexTableItem t_data">Bhaw</th>
                     <th class="flexTableItem t_data">Amount</th>
                     <th class="flexTableItem t_data">BetType</th>
                     <th class="flexTableItem t_data">Time</th>
                  </tr>
               </thead>
         `;

         $(res.data).each(function(i,j){

            bets +=`
               <tbody>
                  <tr class="flex fex-row gap-2 flex-1 ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${i+1}</td>
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${this.mname}/${this.nat}</td>
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${this.oddVal}</td>
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${this.bet_amount}</td>
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${this.betOn?'Lay':'Back'}</td>
                     <td class="flexTableItem t_data ${this.betOn?'!bg-[#e9a9dc]':'!bg-[#91c9f5]'}">${formatData(this.created_at)}</td>
                  </tr>
               </tbody>
                       
            `;

         });
         bets+=`           
               </table>
            `;

         $('.allBetList').html(bets);
         // $('#openBetsTab').tab('show');
      }
   }

   $(document).ready(function(){
      // callApi('get','{{route('user.openbets')}}',null,openBets);
      // callApi('get','{{route('user.eventBets')}}',{gtype:0,eventId:eventId},openBetsBottom);

      // let marketList = 

   });
    
    $('.allBetCount').on('click',function(){
      $(this).parent().find('a').removeClass('active');
      $(this).addClass('active');
      callApi('get','{{route('user.eventBets')}}',{gtype:0,eventId:eventId},openBetsBottom);
    });
    $('.fancyBetCount').on('click',function(){
      $(this).parent().find('a').removeClass('active');
      $(this).addClass('active');
      callApi('get','{{route('user.eventBets')}}',{gtype:1,eventId:eventId},openBetsBottom);
    });

</script>