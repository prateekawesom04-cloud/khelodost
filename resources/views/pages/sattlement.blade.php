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

                <!-- Bet History Table -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Event ID</th>
                                <th>Name</th>
                                <th>Date</th>
                                {{-- <th>Description</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($events->count() > 0)
                                @foreach($events as $row)
                                    <tr>
                                        <td>{{$row->eventId}}</td>
                                        <td>{{$row->eventName}}</td>
                                        <td>{{$row->eventDate}}</td>
                                        @php
                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                        @endphp
                                        <td>{{(!$row->status)?'upcoming':'inplay'}}</td>
                                        {{-- <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td> --}}
                                        <td>
                                            <div class="flex flex-row items-center justify-evenly">
                                                {{-- <div class="p-[.1rem]">
                                                    <i data-eventName="{{$row->eventName}}" data-eventId="{{ $row->eventId }}" class="fas fa-{{($row->status)?'circle-xmark text-danger b_active':'check text-success b_deactive'}}" style="cursor: pointer;" title="Change Status"></i>
                                                </div> --}}
                                                <div>
                                                    <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#sattleEvent"></i>
                                                    {{-- <i data-teama="{{$teamA}}" data-teamb="{{$teamB}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="{{($teamB=='Series')?'':'#sattleEvent'}}"></i> --}}
                                                    {{-- <i data-teamA="{{$explode(' v ',$row->eventName)[0]}}" data-teamB="{{explode(' v ',$row->eventName)[1]}}" data-eventId="{{ $row->eventId }}" class="editEvent fas fa-edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#sattleEvent"></i> --}}
                                                </div>

                                            </div>
                                        </td>
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
                <h5 class="modal-title" id="mainModalLabel">Sattle Event</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body modal-header-dark">
                <form id="sattleEventForm">
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

                </form>

                {{-- <a href="javascript:void(0)" type="button" class="createBonus" class="btn btn-primary">Save</a> --}}
            </div>

            <div class="modal-footer">
                <a href="javascript:void(0)" type="button" class="sattleEvent btn btn-primary">Save</a>
            </div>
        </div>
    </div>
</div>
<script>

    function getEventData(res){
        res = res.response;
        res = JSON.parse(res);
        data = res.data;
        if(! data.length){
            return false;
        }
        $(data).each(function(i,j){


            if(j.mname == "MATCH_ODDS" || j.mname == "Bookmaker" || j.mname == "TIED_MATCH" || j.mname == "fancy1" || j.mname == "Normal" || j.mname == "oddeven") {

            // if(data.mname == "MATCH_ODDS" || data.mname == "Bookmaker" || data.mname == "TIED_MATCH" || data.mname == "fancy1" || data.mname == "Normal" || data.mname == "oddeven") {

                let html = '';
                
                html += `
                    <div class="market" data-marketid="${j.mid}" data-mname="${j.mname}">
                        <h3>${j.mname}</h3>
                        <div class="mb-3">
                            <label for="matchType" class="form-label"><span class="eventIdVal"></span>Result</label>
                            <select id="nat" name="result" class="form-select">
                `;
                
                    $(j.section).each(function(i,j){
                        html+=`
                            <option value="${i+1}">${this.nat}</option>
                        `;
                    });
                html +=`
                            </select>
                        </div>
                    </div>
                        
                `;

                if(data.mname == "TIED_MATCH"){
                    $('.market[data-mname=Bookmaker]').after(html);
                } else{
                    $('.eventData').append(html);
                }
            }
        });
    }

    $('.sattleEvent').on('click',function(){
        $(this).addClass('disabled');
        let formData = new FormData($('#sattleEventForm')[0]);
        // console.log('formdata--',formData);
        
        callAjaxFormData('post', `{{route('sattleEvent')}}`, formData, ajaxResponseModal);
        // callApi('post', `{{route('sattleEvent')}}`, formData, ajaxResponseModal);
    });

    $('.editEvent').on('click',function(){
        
        callApi('get',`{{route('user.getEventData')}}`,{eventId:$(this).attr('data-eventId')},getEventData);
        // $('#sattleEventForm').find('.eventIdVal').val($(this).attr('data-eventId'));
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