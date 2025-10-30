<script>
    
    function updateSoccer(res){
        let html = ``;
        
        data = JSON.parse(res.data);
        console.log(res.sport, 'data-----',data);
        $(data).each(function(){

            html += eval(res.sport)(this);
        });
        $(`.${res.sport}`).html(html);
    }

    // Sport Page js start

        function cricketEvents(data){
            let eventPage = "{{url('soccerEvent')}}";
            let c_time = (new Date()).getTime();
            let html = ``;
            // if((new Date()).getTime() < (new Date(data.stime)).getTime()) {
            //     eventPage = "{{url('soccerUpcomingEvent')}}";
            // }
            html += `
                <tr data-gmid='${data.gmid}' data-mid='${data.mid}' data-ename="${data.ename}" data-stime="${data.stime}">
                    <!-- Football -->
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <!-- Left Side: Date & Time -->
                            <span class="match-status today">${data.stime}</small></span>

                            <a href="${eventPage}/${data.gmid}" class="right-side eventPage">
                                ${data.ename}
                            </a>
                        </div>
                    </td>
                    `;
                
                $(data.section).each(function(i,j){
                    html +=`
                        <td>
                        `;
                            $(j.odds).each(function(){
                                html +=`
                                    <a class="odd-btn ${this.otype} ${this.oname}">${this.odds}</a>
                                `;
                            });
                    html +=`
                        </td>
                        `;
                });
                html +=`
                </tr>
            `;

            return html;
        }

        function soccer(data){
            let eventPage = "{{url('eventDetail')}}";
            let c_time = (new Date()).getTime();
            let html = ``;
            // if((new Date()).getTime() < (new Date(data.stime)).getTime()) {
            //     eventPage = "{{url('soccerUpcomingEvent')}}";
            // }
            html += `
                <div class="border-solid border-b border-gray-500 p-2" data-gmid='${data.gmid}' data-mid='${data.mid}' data-ename="${data.ename}" data-stime="${data.stime}">
                    
                    <span class="text-sm">${data.stime}</span>
                    <div class="flex flex-row items-center justify-between pb-1">
                        <a href="${eventPage}/${data.gmid}" class="right-side eventPage">
                            ${data.ename}
                        </a>
                        <div class="flex flex-row items-center gap-3 justify-between">
                            <span class="in_play blinking_green m-0"></span>
                            <span class="">BM</span>
                        </div>
                    </div>
                    <div class="flex flex-row">  
                    `;
                
                        $(data.section).each(function(i,j){
                            $(j.odds).each(function(){
                                html +=`
                                    <a class="odd-btn ${this.otype} ${this.oname}">${this.odds}</a>
                                `;
                            });
                        });

                html +=`
                    </div>
                </div>
            `;

            return html;
        }
        
        function tennis(data){
            let eventPage = "{{url('eventDetail')}}";
            let c_time = (new Date()).getTime();
            let html = ``;
            
            html += `
                <div class="border-solid border-b border-gray-500 p-2" data-gmid='${data.gmid}' data-mid='${data.mid}' data-ename="${data.ename}" data-stime="${data.stime}">
                    
                    <span class="text-sm">${data.stime}</span>
                    <div class="flex flex-row items-center justify-between pb-1">
                        <a href="${eventPage}/${data.gmid}" class="right-side eventPage">
                            ${data.ename}
                        </a>
                        <div class="flex flex-row items-center gap-3 justify-between">
                            <span class="in_play blinking_green m-0"></span>
                            <span class="">BM</span>
                        </div>
                    </div>
                    <div class="flex flex-row">  
                    `;
                
                        $(data.section).each(function(i,j){
                            $(j.odds).each(function(){
                                html +=`
                                    <a class="odd-btn ${this.otype} ${this.oname}">${this.odds}<small>${j.size}</small></a>
                                `;
                            });
                        });

                html +=`
                    </div>
                </div>
            `;

            return html;
        }

    // sport page js end

    // event page js start

        let eventPageLoading = false;
        function updateSoccerEvent(res){

            res = res.response;
            res = JSON.parse(res);
            data = res.data;
            
            
            $(data).each(function(i,j){
                if(!eventPageLoading) {
                    if(i == data.length-1) {
                        eventPageLoading = true;
                    }
                    // if(j.gtype == "match" || j.gtype == "match1" || (j.gtype == "fancy" && j.mname =="Normal") || j.gtype == "oddeven" || j.gtype == "fancy1") {
                    //     create_cMarketDiv(this);
                    // } 
                    if(j.mname == "MATCH_ODDS" || j.mname == "Bookmaker") {
                        createMarketDiv(this);
                    }
                } else {
                    updateMarket(this);
                } 
                
            });
        }


        function createMarketDiv(data){
            
            let html = '';
            
            html += `
                <!-- ${data.mname} -->
                <div id="market_${data.mid}" class="flex flex-col market text-[12px]" data-mname="${data.mname}" data-marketId="${data.mid}">
                    <div class="bg-[#2888ef] mt-3 p-2 data_market_${data.mid}">${data.mname}</div>
                    
                
                    <div class="flex flex-row items-center justify-between w-full border-b border-gray-500">
                        <div class="w-[60%]">
                            `;

                    if(data.mname == 'MATCH_ODDS'){
                        html +=`
                            <span class="">Max</span>
                            <span class="mx-1 text-green-500">100000</span>
                        `;
                    } else {

                        if(data.min){
                            html +=`
                                <span class="">Min</span>
                                <span class="mx-1 text-green-500">${(data.min)?data.min:''}</span>
                            `;
                        }
                        if(data.max){
                            html +=`
                                <span class="">Max</span>
                                <span class="mx-1 text-green-500">${(data.max)?data.max:''}</span>
                            `;
                        }

                    }
                    html +=`
                        </div>
                        <div class="flex flex-row justify-end flex-1">
                            <span class="bet-head">BACK</span>
                            <span class="bet-head !bg-[#e9a9dc]">LAY</span>
                        </div>
                    </div>
                    
                    `;

                    $(data.section).each(function(i,j){

                        html +=`
                            <div class="m_row${i} flex flex-col items-center border-b border-gray-500 market_data" data-marketId="${data.mid}" data-nat="${this.nat}" data-mname="${data.mname}">
                                <div class="flex flex-row items-center justify-between w-full">
                                    <div class="flex justify-between items-center match_nat w-[60%]"><span class="match_nat${i}">${this.nat}</span></div>
                                    <div class="flex flex-1 justify-end relative">
                            `;

                            $(this.odds).each(function(i,j){
                                html +=`
                                    <a data-oddVal="${j.odds}" class="odd-btn ${j.otype} ${j.oname}">${j.odds}</a>
                                `;
                            });

                        html +=`
                                        <div class="odd_suspended ${(j.gstatus=="SUSPENDED")?"d-block":""}">Suspended</div>
                                        <div class="odd_suspended ${(j.gstatus=="Ball Running")?"d-block":""}">Ball Running</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    })
                
                html +=`
                </div>
            `;

            $('.soccerData').append(html);
        }

        function updateMarket(data){

            let m_div = $(`#market_${data.mid}`);

            let section = data.section;
            
            $(section).each(function(i,j){
                
                $(m_div).find(`.match_nat${i}`).html(j.nat);
                
                $(j.odds).each(function(){
                    let odd = $(m_div).find(`.m_row${i}`).find(`.${this.oname}`);
                    if(parseFloat($(odd).html()) != parseFloat(this.odds)){
                        
                        $(odd).addClass('odd_change');
                        setTimeout(() => {
                            $(odd).removeClass('odd_change');
                        }, 400);
                        $(odd).html(this.odds);
                    }
                });
            });


        }

    // event page js start
    
</script>