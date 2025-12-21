@extends('admin.master')

@section('body')
    <div class="container-fluid px-3 px-md-5 p-4">

        <!-- Responsive Info Cards -->
        <div class="card border border-primary mb-4">
            <div class="card-body py-3">
                <div class="row text-center">
                    <!-- 1st Info Card -->
                    <div class="col-4 col-md-4 col-lg-4 mb-2">
                        <div class="border p-2 h-100 rounded">
                            <div class="fw-semibold">Total Balance</div>
                            <div class="text-primary">IRP {{ $userData->wallet_amount }}</div>
                        </div>
                    </div>

                    <!-- 2nd Info Card -->
                    <div class="col-4 col-md-4 col-lg-4 mb-2">
                        <div class="border p-2 h-100 rounded">
                            <div class="fw-semibold">Total Exposure</div>
                            <div class="text-danger">IRP ( {{ $userData->unsattled_amount }} )</div>
                        </div>
                    </div>

                    <!-- 3rd Info Card -->
                    <div class="col-4 col-md-4 col-lg-4 mb-2">
                        <div class="border p-2 h-100 rounded">
                            <div class="fw-semibold">Available Balance</div>
                            <div class="text-primary">IRP {{$userData->wallet_amount + $userData->unsattled_amount }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Table and Controls -->
        <div class="card border border-primary">
            <div class="card-body py-3">

                <!-- Controls -->
                <div class="row gy-2 gx-3 align-items-center mb-3 small">
                    <div class="col-md-6 d-flex align-items-center">
                        <label class="me-2" for="show-entries">Show</label>
                        <select id="show-entries" class="form-select w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="ms-2">entries</span>
                    </div>

                    <div class="col-12">
                        <div class="row gx-3 gy-2">
                            <div class="col-6 col-lg-3">
                                <input id="search" type="search" class="form-control form-control-sm border-primary"
                                    placeholder="Search" style="min-width: 100%;">
                            </div>
                            <div class="col-6 col-lg-3">
                                <input type="search" class="form-control form-control-sm border-primary"
                                    placeholder="Search by client" style="min-width: 100%;">
                            </div>
                            <div class="col-6 col-lg-3">
                                <a href="{{ route('admin.user_client_account') }}" class="btn btn-primary btn-sm w-100">Add
                                    Client Account</a>
                            </div>
                            <div class="col-6 col-lg-3">
                                <a href="{{route('admin.inactive_user_downline_list')}}" class="btn btn-primary btn-sm w-100 text-white">Inactive List</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Scrollable Table -->
                <div class="table-responsive-sm" style="max-height: 400px;">
                    <table class="table table-bordered table-sm align-middle text-center small mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                {{-- <th>VIP</th> --}}
                                <th>Username</th>
                                <th>Balance</th>
                                <th>Exposure</th>
                                <!-- <th>Exposure Limit</th> -->
                                <th>Avail .Bal.</th>
                                <!-- <th>Ref. P/L</th> -->
                                <!-- <th>Partnership</th> -->
                                <th>U Lock</th>
                                <th>B Lock</th>
                                <!-- <th>My %</th> -->
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    
                                    <td><span class="badge bg-success">{{ ($user->loss_amount > 50000)?'VIP':'user'}}</span> {{ $user->username }}</td>
                                    <td class="text-success">{{$user->wallet_amount + $user->unsattled_amount }}</td>
                                    <td class="text-danger">{{ $user->unsattled_amount }}</td>
                                    <!-- <td>200000</td> -->
                                    <td>{{ $user->wallet_amount }}</td>
                                    <!-- <td>1000</td> -->
                                    <!-- <td>{{$user->partnership_percentage }}</td> -->
                                    <td><input data-username="{{ $user->username }}" value="{{ $user->status == 3 ? '2' : '3' }}" class="lock" type="checkbox" name="u_lock" {{ $user->status == 3 ? 'checked' : '' }} /></td>
                                    <td><input data-username="{{ $user->username }}" value="{{ $user->status == 1 || $user->status == 3 ? '2' : '1' }}" class="lock" type="checkbox" name="b_lock" {{ $user->status == 1 || $user->status == 3 ? 'checked' : '' }} /></td>
                                    <!-- <td>10%</td> -->
                                    <td>
                                        <span class="badge bg-{{ $user->status == 3 ? 'danger' : 'success' }}">
                                            {{ $user->status == 3 ? 'inactive' : 'active' }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Scrollable action buttons -->
                                        <div
                                            class="action-buttons d-flex flex-nowrap gap-1 justify-content-center overflow-auto user_actions" data-username="{{ $user->username }}">
                                            <a href="{{ route('admin.my_account',$user->username) }}"
                                                class="btn btn-sm fw-bold btn-user-details" data-bs-toggle="tooltip"
                                                title="User Details">U</a>
                                            <a href="#" class="btn btn-sm fw-bold btn-deposit-collection updateWalletModel depositWallet"
                                                data-bs-toggle="modal" data-user_wallet="{{ $user->wallet_amount }}" data-username="{{ $user->username }}" data-bs-target="#balanceModal"
                                                title="Deposit / Collection">D/C</a>
                                            <a href="#" class="btn btn-sm fw-bold btn-withdrawal updateWalletModel withdrawWallet"
                                                data-bs-toggle="modal" data-user_wallet="{{ $user->wallet_amount }}" data-username="{{ $user->username }}" data-bs-target="#withdrawModal"
                                                title="Withdrawal">W</a>
                                            <a href="#" class="btn btn-sm fw-bold btn-password-change changePasswordModel"
                                                data-bs-toggle="modal" data-username="{{ $user->username }}" data-bs-target="#changePasswordModal"
                                                title="Password Change">P</a>
                                            <a href="#" class="btn btn-sm fw-bold btn-game-controller"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gameControllerModal"title="Game Control">GC</a>
                                            <a href="#" class="btn btn-sm fw-bold btn-casino-control"
                                                data-bs-toggle="modal" data-bs-target="#casinocontrolModal"
                                                title="Casino Control">
                                                CC
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-sm fw-bold btn-delete deleteUser" data-username="{{ $user->username }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteConfirmationModal" title="Delete">D</a>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Bootstrap 5 Tooltip Init
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });


        // $('.user_actions a').on('click',function(){
        //     user_action_id = $(this).parent().attr('data-username');
        //     console.log('user_action_id--',user_action_id);
            
        // });
        

        // $('.btn-password-change').click(function(){
        //     $('#changePasswordModal').find('form').attr('data-url','');
        // });
        
        $('.lock').on('click',function(){
            $(this).attr('disabled','true');
            callApi('post', `{{Route('admin.action.blockUser')}}`, {status:$(this).val(),username:$(this).attr('data-username')}, ajaxResponseModal);
        });

    </script>
@endsection
