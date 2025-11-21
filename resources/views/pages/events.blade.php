@extends('admin.master')

@section('body')

    <div class="container-fluid p-4">

        <!-- Bet History Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Events</strong>
            </div>
            <div class="card-body">

                <!-- Table Controls -->
                <div class="d-flex flex-wrap flex-nowrap align-items-center mb-3">
                    <div class="d-flex align-items-center me-3 flex-shrink-0">
                        <label class="me-2 mb-0" for="show-entries">Show</label>
                        <select id="show-entries" class="form-select w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center ms-auto flex-grow-1">
                        <label class="me-2 mb-0" for="search">Search:</label>
                        <input type="search" id="search" class="form-control form-control-sm border border-primary"
                            style="max-width: 250px;">
                    </div>
                    {{-- <div class="col-6 col-lg-3 px-2">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#sattleEvent">Create Bonus</a>
                    </div> --}}
                    {{-- <div class="col-6 col-lg-3 px-2">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#assignBonusModal">Update Event</a>
                    </div> --}}
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Sportname</th>
                                <th>Event ID</th>
                                <th>Name</th>
                                <th>Exposure</th>
                                <th>Date</th>
                                <th>Status</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @if($cricketEvents->count() > 0)
                                @foreach($cricketEvents as $row)
                                    <tr>
                                        <td>{{$row->sportname}}</td>
                                        <td>{{$row->eventId}}</td>
                                        <td>{{$row->eventName}}</td>
                                        <td>{{$row->exposure}}</td>
                                        <td>{{$row->eventDate}}</td>
                                        @php
                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                        @endphp
                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                        {{-- <td>
                                            <div class="flex flex-row items-center justify-evenly">
                                                <div>
                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-target="#sattleEvent"></i>
                                                </div>

                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="text-white text-center">No data!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3">
                    <div class="small text-white mb-2 mb-md-0">Showing 1 to 10 of 0 entries</div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link">First</a></li>
                            <li class="page-item disabled"><a class="page-link">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link">Next</a></li>
                            <li class="page-item disabled"><a class="page-link">Last</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>

    <!-- Compact Reusable Modal with Form -->
<div class="modal fade" id="sattleEvent" tabindex="-1" aria-labelledby="sattleEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-dark">
                {{-- <h5 class="modal-title" id="mainModalLabel">Sattle Event</h5> --}}
                    <div class="flex flex-row gap-2 items-center justify-center">
                        <div>All ( <span class="market_count"></span> )</div>
                        <div>Odds ( <span class="m_market_count"></span> )</div>
                        <div>Fancy ( <span class="fancy_market_count"></span> )</div>
                </div>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body modal-header-dark">
                <div id="sattleEventForm">
                    <input type="hidden" name="eventId" class="eventIdVal">
                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control">
                    </div> --}}
                    <!-- Bonus Type Dropdown -->
                    {{-- <div class="mb-3">
                        <label for="bonusType" class="form-label"><span class="eventIdVal"></span>Result</label>
                        <select id="bonusType" name="type" class="form-select">
                            <option value="1">Team A</option>
                            <option value="2">Team B</option>
                        </select>
                    </div> --}}
                    <div class="eventData">

                    </div>

                    {{-- <div class="flex gap-2">
                        <input type="radio" name="result" id="" value="1"> <span class="mx-1 teamA"></span>wins
                        <input type="radio" name="result" id="" value="2"> <span class="mx-1 teamB"></span>wins
                        <input type="radio" name="result" id="" value="3"> <span class="mx-1">Draw</span>
                    </div> --}}

                </div>

                {{-- <a href="javascript:void(0)" type="button" class="createBonus" class="btn btn-primary">Save</a> --}}
            </div>

            {{-- <div class="modal-footer">
                <a href="javascript:void(0)" type="button" class="sattleEvent btn btn-primary">Save</a>
            </div> --}}
        </div>
    </div>
</div>
<script>

    let eventData = '';
    let sportname = 'cricket';

    function getEventData(res){
        res = res.response;
        res = JSON.parse(res);
        data = res.data;
        eventData = data;

        let mcount = 0;
        let fcount = 0;


        $(data).filter(function(i,j){
            if(j.mname == "MATCH_ODDS" || j.mname == "Bookmaker" || j.mname == "TIED_MATCH") {
                mcount++;
            }else{
                fcount++;
            }
        });

        $('.market_count').text(data.length);
        $('.m_market_count').text(mcount);
        $('.fancy_market_count').text(fcount);

        if(! data.length){

            return false;
        }
        $('.eventData').html('');

        $(data).each(function(i,j){


            if(j.mname == "MATCH_ODDS" || j.mname == "Bookmaker" || j.mname == "TIED_MATCH" || j.mname == "Normal") {
                if(sportname != 'cricket' && j.mname != "MATCH_ODDS"){
                    return;
                }
            // if(data.mname == "MATCH_ODDS" || data.mname == "Bookmaker" || data.mname == "TIED_MATCH" || data.mname == "fancy1" || data.mname == "Normal" || data.mname == "oddeven") {

                let html = '';
                
                if(j.mname != 'Normal'){
                    
                    html += `
                        <form class="my-2 ${j.mname}">
                        <input type="hidden" name="eventId" class="eventId" value="${j.gmid}">
                        <input type="hidden" name="marketId" class="marketId" value="${j.mid}">
                        <input type="hidden" name="mname" class="mname" value="${j.mname}">
                        <div class="market" data-marketId="${j.mid}" data-mname="${j.mname}">
                            <h3 class="!text-[14px] p-2 bg-[#0c0339] mt-4 mb-2 text-center">${j.mname}</h3>
                            <div class="flex flex-row items-center justify-between gap-3 divide-xed divide-gray-300 mb-1">
                                <div class="w-[60%] px-2">Result</div>
                    
                                <div class="px-2">Action</div>
                            </div>
                            <div class="flex flex-row items-center justify-between gap-3 mb-1">
                                <div class="w-[60%] px-2">
                                    <select id="nat" name="result" class="form-select marketResult">
                        `;
                        
                        $(j.section).each(function(i,j){
                            
                                html += `
                                    <option value="${this.sid}">${this.nat}</option>
                                `;
                        });

                    html +=`
                                    </select>
                                </div>
                                <a href="javascript:void(0)" class="px-2 sattleEvent btn btn-secondary">Save</a>
                            </div>
                        </div>
                        </form>
                    `;
                } else{
                    html +=`
                        <div class="market" data-marketId="${j.mid}" data-mname="${j.mname}">
                            <h3 class="!text-[14px] p-2 bg-[#0c0339] mt-4 mb-2 text-center">${j.mname}</h3>
                            <div class="flex flex-row items-center justify-between gap-3 divide-xed divide-gray-300 mb-1">
                                <div class="w-[60%] px-2">Runner</div>
                    
                                <div class="px-2">Result</div>
                                <div class="px-2">Action</div>
                            </div>
                    `;
                        $(j.section).each(function(i2,j2){
                            
                        html += `
                            <form class="flex flex-row items-center justify-between gap-3 mb-1">
                                <input type="hidden" name="eventId" class="eventId" value="${j.gmid}">
                                <input type="hidden" name="marketId" class="marketId" value="${j.mid}">
                                <input type="hidden" name="mname" class="mname" value="${j.mname}">
                                <input type="hidden" name="result" class="result" value="${this.sid}">
                                <div class="w-[60%] px-2">${this.nat}</div>
                                <div class="px-2">
                                    <input type="text" name="size" class="form-control" placeholder="Enter Value">
                                </div>
                                <a href="javascript:void(0)" class="px-2 sattleEvent btn btn-secondary">Save</a>
                            </form>
                        `;
                        });
                    html+=`
                        </div>
                    `;
                }

                if(j.mname == "TIED_MATCH"){
                    $('.market[data-mname=Bookmaker]').after(html);
                } else{
                    $('.eventData').append(html);
                    $('#sattleEvent').modal('show');
                }
            }
        });
    }

    let eventResult = {};
    $('body').on('change','.marketResult',function(){
        if($(this).parents('form').hasClass('Normal')) {
            $(this).parents('form').find('.sattleEvent').removeClass('disabled');
            $(this).parents('form').find('input[name="size"]').val('');
        }
    });

    $('body').on('click','.sattleEvent',function(){
        $(this).addClass('disabled');
        // let formData = new FormData($('#sattleEventForm')[0]);
        let formData = new FormData($(this).parents('form')[0]);
        eventResult['eventId'] = formData.get('eventId');
        eventResult['marketId'] = formData.get('marketId');
        eventResult['mname'] = formData.get('mname');
        // Object.fromEntries(formData.entries())
        let sid_result = {};

        if(formData.get('mname') == "MATCH_ODDS" || formData.get('mname') == "Bookmaker" || formData.get('mname') == "TIED_MATCH") {
            $(eventData).each(function(i,j){
                if(j.mid == formData.get('marketId')) {
                    
                    $(j.section).each(function(i2,j2){
                        if(j2.sid == formData.get('result')){
                            sid_result[j2.sid] = 0;
                        } else{
                            sid_result[j2.sid] = 1;
                        }
                    });
                }
            });
            
            // eventResult[formData.get('marketId')] = sid_result;
            eventResult['sid_results'] = sid_result;
            // formData.set('result', JSON.stringify(resultObj));
        } else if(formData.get('mname') == "Normal") {
            if(formData.get('size') == ''){
                ajaxResponseModal('please enter value');
                $(this).removeClass('disabled');
                return false;
            }
            $(eventData).each(function(i,j){
                if(j.mid == formData.get('marketId')) {
                    
                    $(j.section).each(function(i2,j2){
                        if(j2.sid == formData.get('result')){
                            sid_result[j2.sid] = formData.get('size');
                        }

                    });
                }
            });
            
            // eventResult[formData.get('marketId')] = sid_result;
            eventResult['sid_results'] = sid_result;

        }
        console.log('eventResult---',eventResult);
        
        // eventResult = JSON.stringify(eventResult);
        
        // callAjaxFormData('post', `{{route('sattleEvent')}}`, formData, ajaxResponseModal);
        
        callApi('post', `{{route('sattleEvent')}}`, eventResult, ajaxResponseModal);
    });

    $('.editEvent').on('click',function(){

        sportname = $(this).attr('data-sportname');
        $('.sattleEvent').removeClass('disabled');
        $(this).addClass('disabled');
        callApi('get',`{{route('user.getEventData')}}`,{eventId:$(this).attr('data-eventId')},getEventData);
        $('#sattleEventForm').find('.eventIdVal').val($(this).attr('data-eventId'));
        // $('#sattleEventForm').find('.teamA').text($(this).attr('data-teama'));
        // $('#sattleEventForm').find('.teamB').text($(this).attr('data-teamb'));
    });
    
    $('.sattleEventBets').on('click',function(){

        sportname = $(this).attr('data-sportname');
        $('.sattleEvent').removeClass('disabled');
        $(this).addClass('disabled');
        callApi('post',`{{route('admin.sattleEventBets')}}`,{eventId:$(this).attr('data-eventId')},ajaxResponseModal);
        $('#sattleEventForm').find('.eventIdVal').val($(this).attr('data-eventId'));
        // $('#sattleEventForm').find('.teamA').text($(this).attr('data-teama'));
        // $('#sattleEventForm').find('.teamB').text($(this).attr('data-teamb'));
    });
    
    // $('.updateBonus').on('click',function(){
    //     $(this).addClass('disabled');
    //     let formData = new FormData($('#sattleEventForm')[0]);
        
    //     callAjaxFormData('post', `updateBonus`, formData, ajaxResponseModal);
    // });

    // @if($events->count() > 0)
    //     @foreach($events as $row)
            // callApi('get',`{{route('user.getEventData')}}`,{eventId:{{$row->eventId}}},updateSattleEvent);
    //     @endforeach
    // @endif

</script>


@endsection