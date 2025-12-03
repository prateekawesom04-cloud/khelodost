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
                                <th>Event ID</th>
                                <th>Sportname</th>
                                <th>Name</th>
                                {{-- <th>Exposure</th> --}}
                                <th>Total Bets</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($allEvents->count() > 0)
                                @foreach($allEvents as $row)
                                    <tr>
                                        <td>{{$row->eventId}}</td>
                                        <td>{{$row->sportname}}</td>
                                        <td>
                                            
                                            <a href="{{route('admin.eventDetail',$row->eventId)}}">
                                                {{$row->eventName}}
                                            </a></td>
                                        {{-- <td class="text-danger">{{$row->exposure}}</td> --}}
                                        <td>{{$row->totalBets}}</td>
                                        <td>{{$row->eventDate}}</td>
                                        @php
                                            $teamA = explode(' v ',$row->eventName)[0] ?? 'Series';
                                            $teamB = explode(' v ',$row->eventName)[1] ?? 'Series';
                                        @endphp
                                        <td class="status"><span class="badge {{$row->status?'bg-success':'bg-danger'}} text-white">{{$row->status==1?'inplay':'inactive'}}</span></td>
                                        {{-- <td>{{!$row->status?'upcoming':'inplay'}}</td> --}}
                                        <td>
                                            <div class="flex items-center justify-evenly w-30">
                                                <label class="toggle-switch">
                                                    <input class="statusInput" id="status_{{$row->eventId}}" name="status" data-eventId="{{$row->eventId}}" type="checkbox" {{$row->status!=0?'checked':''}} onchange="updateStatus(this)">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                {{-- <a href="{{route('admin.eventDetail',$row->eventId)}}">
                                                    <i class="bi bi-eye"></i>
                                                </a> --}}
                                            </div>
                                        </td>
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
    $('.statusInput').on('change',function(){
        console.log('sdfghj');
        
        $(this).attr('disabled','disabled');
        callApi('post', `{{Route('admin.action.eventStatus')}}`, {eventId:$(this).attr('data-eventId')}, ajaxResponseModal);
    });

</script>

@endsection