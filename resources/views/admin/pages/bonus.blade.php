@extends('admin.master')

@section('body')
    <div class="container-fluid p-4">

        <!-- Bet History Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white">
                <strong>Bonus</strong>
            </div>
            <div class="card-body">

                <!-- Table Controls -->
                <div class="row gy-2 gx-3 align-items-center justify-between mb-3 small">

                    <div class="col-12 col-md-6 flex">
                        <div class="col-6 d-flex align-items-center">
                            <label class="me-2" for="show-entries">Show</label>
                            <select id="show-entries" class="form-select w-auto">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                            <span class="ms-2">entries</span>
                        </div>
                        <div class="col-6">
                            <input id="search" type="search" class="form-control form-control-sm border-primary"
                                placeholder="Search" style="min-width: 100%;">
                        </div>
                    </div>
                    {{-- <div class="col-6 col-lg-3 px-2">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#editBonusModal">Create Bonus</a>
                    </div> --}}
                    <div class="col-12 col-md-3">
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm w-100 h-full !flex justify-center items-center" data-bs-toggle="modal" data-bs-target="#assignBonusModal">Assign  Bonus</a>
                    </div>
                </div>

                <!-- Bet History Table -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Bonus ID</th>
                                <th>Amount</th>
                                <th>Wager</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bonus->count() > 0)
                                @foreach($bonus as $row)
                                    <tr>
                                        <td>{{$row->bonus_uid}}</td>
                                        <td>{{$row->amount}}</td>
                                        <td class="text-danger">{{$row->wager_amount}}</td>
                                        <td>{{$row->description}}</td>
                                        <td class="{{($row->status)?'text-success':'text-danger'}}">{{($row->status)?'Active':'Inactive'}}</td>
                                        <td>
                                            <div class="flex flex-row items-center justify-evenly">
                                                <div class="p-[.1rem]">
                                                    {{-- <i data-bonus_uid="{{ $row->bonus_uid }}" class="fas fa-{{($row->status)?'check b_active':'circle-xmark b_deactive'}} text-danger" style="cursor: pointer;" title="Change Status"></i> --}}
                                                    <i data-bonus_uid="{{ $row->bonus_uid }}" class="fas fa-{{($row->status)?'circle-xmark text-danger b_active':'check text-success b_deactive'}}" style="cursor: pointer;" title="Change Status"></i>
                                                </div>
                                                <div>
                                                    <i data-bonus_uid="{{ $row->bonus_uid }}" class="editBonus fas fa-edit" data-bs-toggle="modal" data-bs-target="#editBonusModal"></i>
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
@endsection

@section('js')

    @include('admin.model.edit_bonus')
    @include('admin.model.assign_bonus')

    <script>
        
    // update bonus
    $('.b_active').on('click',function(){
        formData = {};
        callApi('post', `changeBonusStatus`, {bonus_uid:$(this).attr('data-bonus_uid'),status:0}, ajaxResponseModal);
    });
    
    $('.b_deactive').on('click',function(){
        formData = {};
        callApi('post', `changeBonusStatus`, {bonus_uid:$(this).attr('data-bonus_uid'),status:1}, ajaxResponseModal);
    });

    </script>

    @endsection