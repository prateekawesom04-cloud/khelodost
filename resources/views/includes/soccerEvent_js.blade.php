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
            let eventPage = "{{url('soccerEvent')}}";
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
                    createMarketDiv(this);
                } else {
                    updateMarket(this);
                } 
                
            });
        }


        function createMarketDiv(data){
            
            let html = '';
            
            html += `
                <!-- ${data.mname} -->
                <table id="market_${data.mid}" class="table text-center mb-0 align-middle odds-table my-2">
                    <thead class="table-light">
                        <tr>
                            <th style="">${data.mname}</th>
                            <th style=""></th>
                        </tr>
                    </thead>
                    <tbody class="data_market_${data.mid}">`;

                    $(data.section).each(function(i,j){

                        html +=`
                            <tr class="m_row${i} relative">
                                <!-- ${this.nat} -->
                                <td class="text-start px-3">
                                    <div class="match-layout">
                                        <div class="right-side">
                                            <div class="match_nat${i}">${this.nat}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                            `;

                            $(this.odds).each(function(i,j){
                                html +=`
                                    <a class="odd-btn ${j.otype} ${j.oname}">${j.odds}</a>
                                `;
                            });

                    html +=`
                    
                                    <div class="odd_suspended ${(j.gstatus=="SUSPENDED")?"d-blockwet":""}">Suspended</div>
                                </td>
                            </tr>
                        `;
                    })
                
                html +=`
                    </tbody>
                </table>
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
                    if($(odd).html() != this.odds){
                        $(this).addClass('odd_change');
                        setTimeout(() => {
                            $(this).removeClass('odd_change');
                        }, 300);
                    }
                    $(odd).html(this.odds);
                });
            });


        }

    // event page js start
    
</script>