<script>
    
    function updateSports(res){
        let html = ``;
        
        data = JSON.parse(res.data);
        console.log(res.sport, 'data-----',data);
        
        $(data).each(function(){

            let date = (this.eventName).split(' / ')[1];
            this.eventName = (this.eventName).split(' / ')[0];

            date = date.split('M (')[0];
            dateHour = date[date.length-1];
            date = date.split(dateHour)[0];
            date += ' '+dateHour+'M';
            
            this.eventDate = date;

            html += eval(res.sport)(this);
        });
        $(`.${res.sport}`).html(html);
    }
    
    function updateInplaySports(res){
        let html = ``;
        
        data = JSON.parse(res.data);
        console.log(res.sport, 'data-----',data);
        
        $(data).each(function(){

            let date = (this.eventName).split(' / ')[1];
            this.eventName = (this.eventName).split(' / ')[0];

            date = date.split('M (')[0];
            dateHour = date[date.length-1];
            date = date.split(dateHour)[0];
            date += ' '+dateHour+'M';
            
            this.eventDate = date;

            if((new Date()).getTime() < (new Date(data.eventDate)).getTime()) {
                return false;
            }
            html += eval(res.sport)(this);
        });
        $(`.${res.sport}InplayData`).html(html);
    }

    // Sport Page js start
        function cricket(data){
            let eventPage = "{{url('eventPage')}}";
            let c_time = (new Date()).getTime();
            // if((new Date()).getTime() < (new Date(data.eventDate)).getTime()) {
            //     eventPage = "{{url('upcomingEventPage')}}";
            // }
            return `
                <div class="border-solid border-b border-gray-500 p-2" data-gameId='${data.gameId}' data-marketId='${data.marketId}' data-eventName="${data.eventName}" data-eventDate="${data.eventDate}">
                    
                        <span class="text-sm">${data.eventDate}</span>
                        
                        <div class="flex flex-row items-center justify-between pb-1">
                            <a href="${eventPage}/${data.gameId}" class="right-side eventPage">
                                ${data.eventName}
                            </a>
                            <div class="flex flex-row items-center gap-3 justify-between">
                                <span class="in_play blinking_green m-0"></span>
                                <span class="">BM</span>
                            </div>
                        </div>

                        <div class="flex flex-row">
                            <a class="odd-btn">${data.back11}</a>
                            <a class="odd-btn">${data.back1}</a>
                            <a class="odd-btn">${data.back12}</a>
                            <a class="odd-btn lay">${data.lay11}</a>
                            <a class="odd-btn lay">${data.lay1}</a>
                            <a class="odd-btn lay">${data.lay12}</a>
                        </div>

                </div>
            `;
        }

        // $('body').on('click','.eventPage', function(){
        //     let url = $(this).attr('data-href');
        //     let tr = $(this).parents('tr');
        //     let data = {};
        //     data['gameId'] = $(tr).attr('data-gameId');
        //     data['eventName'] = $(tr).attr('data-eventName');
        //     data['eventDate'] = $(tr).attr('data-eventDate');
        //     console.log('data---',data);
            
        //     callApi('get',url,data);
        // });

    // sport page js end


    
    let cricketEventPageLoading = false;
    function updateCricketEvent(res){

        res = res.response;
        res = JSON.parse(res);
        data = res.data;
        
        
        $(data).each(function(i,j){
            if(!cricketEventPageLoading) {
                if(i == data.length-1) {
                    cricketEventPageLoading = true;
                }
                if(j.gtype == "match" || j.gtype == "match1" || j.gtype == "fancy" || j.gtype == "oddeven" || j.gtype) {
                    create_cMarketDiv(this);
                }
            } else {
                update_cMarket(this);
            } 
            
        });
    }

    function create_cMarketDiv(data){
        
        let html = '';
        
        html += `
            <!-- ${data.mname} -->
            <div id="market_${data.mid}" class="flex flex-col market text-[12px]" data-mname="${data.mname}" data-marketId="${data.mid}">
                <div class="bg-[#2888ef] mt-3 p-2 data_market_${data.mid}">
                    ${(data.mname=='fancy1')?'TOSS':data.mname}
                </div>
                
                
                <div class="flex flex-row items-center justify-between w-full border-b border-gray-500">
                    <div class="w-[60%]">
                        `;

                if(data.mname == 'MATCH_ODDS'){
                    html +=`
                        <span class="">Max</span>
                        <span class="mx-1 text-green-500">5000</span>
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
                

                if(!data.min && !data.max){
                    if(data.gtype == "fancy"){
                        html +=`
                            <span class="">Session Market</span>
                        `;
                    } else if(data.gtype == "oddeven"){
                        html +=`
                            <span class="">Fancy Market</span>
                        `;
                    // } else{
                    //     html +=`
                    //         <span class="">${data.mname} Session</span>
                    //     `;
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
                    
                    if(data.mname == 'fancy1' && i==2) {
                        
                        return false;
                        // return;
                    }
                    html +=`
                        <div class="m_row${i} flex flex-col items-center border-b border-gray-500 market_data" data-marketId="${data.mid}" data-nat="${this.nat}" data-mname="${data.mname}">
                            <div class="flex flex-row items-center justify-between w-full">
                                <div class="flex justify-between items-center match_nat match_nat${i} w-[60%]"><span>${this.nat}</span></div>
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

        if(data.mname == "TIED_MATCH"){
            $('.market[data-mname=Bookmaker]').after(html);
        } else{
            $('.eventData').append(html);
        }
    }

    function update_cMarket(data){

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
    
    // function inplay(res){

    //     console.log('res in eventPage',res.data);
    //     data = res.data;
    //     data = JSON.parse(data);
    //     console.log('data in eventPage',data);
    //     let html = ``;
        
    //     // $(data).each(function(){

    //     //     let date = (this.eventName).split(' / ')[1];
    //     //     this.eventName = (this.eventName).split(' / ')[0];

    //     //     date = date.split('M (')[0];
    //     //     dateHour = date[date.length-1];
    //     //     date = date.split(dateHour)[0];
    //     //     date += ' '+dateHour+'M';
            
    //     //     this.eventDate = new Date(date).toLocaleString();

    //     //     html += eventData(this);
    //     // });
    //     // $('.eventData').html(html);
    // }

    
    function updateEvent(res){

        res = res.response;
        res = JSON.parse(res);
        data = res.data;
        
        
        $(data).each(function(){
            
            if(this.mname == "MATCH_ODDS"){
                updateMatchOdds(this);
            } else if(this.mname == "Bookmaker"){
                updateBookmaker(this);
            } else if(this.mname == "TIED_MATCH"){
                updateTiedmatch(this);
            } else if(this.mname == "fancy1"){
                updateLinemarket(this);
            } else if(this.mname == "Normal"){
                updateNormal(this);
            } else if(this.mname == "meter"){
                updateMeter(this);
            } else if(this.mname == "Ball By Ball"){
                updateBallbyball(this);
            } else if(this.mname == "Over By Over"){
                updateOverbyover(this);
            } else if(this.mname == "oddeven"){
                updateOddeven(this);
            } else if(this.mname == "khado"){
                updateKhado(this);
            // } else if(this.gtype == "cricketcasino"){
            //     cricketcasino(this);
            }
        //     let date = (this.eventName).split(' / ')[1];
        //     this.eventName = (this.eventName).split(' / ')[0];

        //     date = date.split('M (')[0];
        //     dateHour = date[date.length-1];
        //     date = date.split(dateHour)[0];
        //     date += ' '+dateHour+'M';
            
        //     this.eventDate = new Date(date).toLocaleString();

        //     html += eventData(this);
        });
        // $('.eventData').html(html);
    }

    function updateMatchOdds(data){

        let m_div = $('.match_odds');

        let section = data.section;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        
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
    
    function updateBookmaker(data){

        let m_div = $('.bookmaker');
        let section = data.section;

        if(section.length) {
            $(m_div).parents('table').show();
        }

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

    function updateLinemarket(data){

        let m_div = $('.linemarket');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }
    
    function updateTiedmatch(data){

        let m_div = $('.tiedmatch');
        let section = data.section;

        if(section.length) {
            $(m_div).parents('table').show();
        }

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
    
    function updateNormal(data){
        
        let m_div = $('.updateNormal');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row relative">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                        <div class="odd_suspended ${(j.gstatus=="SUSPENDED")?"":"d-block"}">Suspended</div>
                        <div class="odd_running  ${(j.gstatus=="BALL RUNNING")?"":"d-block"}">Ball Running</div>
                    </td>

                </tr>

            `;
            
        });
        $(m_div).html(html);

    }
    
    function updateMeter(data){

        let m_div = $('.updateMeter');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }
    
    function updateBallbyball(data){

        let m_div = $('.ballbyball');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }
    
    function updateOverbyover(data){

        let m_div = $('.overbyover');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }

    function updateOddeven(data){

        let m_div = $('.oddeven');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>
                    
                    <td>
                        <a class="odd-btn lay lay1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }
    
    function updateKhado(data){

        let m_div = $('.khado');
        let section = data.section;
        let html =``;

        if(section.length) {
            $(m_div).parents('table').show();
        }
        $(section).each(function(i,j){
            html += `
                <tr class="m_row">
                    <td class="text-start px-3">
                        <div class="match-layout">
                            <div class="right-side">
                                <div class="match_nat">${j.nat}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <a class="odd-btn back1">${j.odds[0].odds}</a>
                    </td>

                </tr>
            `;
            
        });
        $(m_div).html(html);

    }
    
    function cricketcasino(data){

        let m_div = $('.eventDatabox');
        let section = data.section;
        let html =``;

        // if(section.length) {
        //     $(m_div).parents('table').show();
        // }

        $(section).each(function(i,j){
            html += `
                <table class="table text-center mb-0 align-middle odds-table my-4 border-t-2 border-gray-300" style="display: none;">
                    <thead class="table-light">
                        <tr>
                            <th style="">Khado</th>
                            <th style="">Back</th>
                        </tr>
                    </thead>
                    <tbody class="khado">
                        <tr class="m_row">
                            <td class="text-start px-3">
                                <div class="match-layout">
                                    <div class="right-side">
                                        <div class="match_nat">${j.nat}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a class="odd-btn back1">${j.odds[0].odds}</a>
                            </td>

                        </tr>
                    </tbody>
                </table>
            `;
            
        });
        $(m_div).append(html);

    }

    function eventData(data){
        return `
            <tr data-gameId='${data.gameId}' data-marketId='${data.marketId}'>
                <!-- eventData -->
                <td class="text-start px-3">
                    <div class="match-layout">
                        <!-- Left Side: Date & Time -->
                        <span class="match-status today">${data.eventDate}</small></span>

                        <!-- Right Side: Teams -->
                        <div class="right-side">
                            ${data.eventName}
                        </div>
                    </div>
                </td>

                <td>
                    <a class="odd-btn">${data.back11}</a>
                    <a class="odd-btn">${data.back1}</a>
                </td>

                <td>
                    <a class="odd-btn">${data.back12}</a>
                    <a class="odd-btn lay">${data.lay11}</a>
                </td>

                <td>
                    <a class="odd-btn lay">${data.lay1}</a>
                    <a class="odd-btn lay">${data.lay12}</a>
                </td>
            </tr>
        `;
    }

    function formatData(dateStr){
        const today = new Date(dateStr);

        // Extract day, month, and year
        let day = today.getDate();
        let month = today.getMonth() + 1;
        let year = today.getFullYear();
        let hours = today.getHours();
        let minutes = String(today.getMinutes()).padStart(2, '0');

        // Add leading zero to day and month if needed
        day = day < 10 ? '0' + day : day;
        month = month < 10 ? '0' + month : month;

        // Format the date as dd/mm/yyyy
        const formattedDate = `${day} ${month} ${year} ${hours}:${minutes}`;

        return formattedDate;
    }
</script>