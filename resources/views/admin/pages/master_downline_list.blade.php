@extends('admin.master')
@section('body')
    <div class="container-fluid p-4">

        <!-- Add Downline Link Button -->
        {{-- <div class="mb-3 d-flex justify-content-end gap-2">
            <a href="#" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
                <span>Clip summary</span>
                <input type="checkbox" />
            </a>
            <a href="#" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addDownlineModal">
                 👨‍💼Add Downline
            </a>
        </div> --}}
        <!-- Info Cards in Card -->
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
                            <div class="text-primary">IRP {{ $userData->wallet_amount }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- <div class="card border border-primary mb-4">
            <div class="card-body py-3">
                <div class="row text-center small">
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Total Balance</div>
                            <div class="text-primary">IRP {{ $userData->wallet_amount }}</div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Total Exposure</div>
                            <div class="text-danger">IRP ( {{ $userData->unsattled_amount }} )</div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Available Balance</div>
                            <div class="text-primary">IRP {{ $userData->wallet_amount }}</div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Balance</div>
                            <div class="text-primary">IRP 1012099026.00</div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Total Avail. bal.</div>
                            <div class="text-primary">IRP 1000</div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <div class="border p-2 h-100">
                            <div class="fw-semibold">Upline P/L</div>
                            <div class="text-danger">IRP 1026.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Table in Card -->
        <div class="card border border-primary">
            <div class="card-body py-3">

                <!-- Show Entries and Search -->
                <div class="row gy-2 gx-3 align-items-center mb-3 small">
                    <!-- <div class="col-md-6 d-flex align-items-center">
                        <label class="me-2" for="show-entries">Show</label>
                        <select id="show-entries" class="form-select w-auto">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <span class="ms-2">entries</span>
                    </div> -->

                    <div class="col-12">
                        <div class="row gx-3 gy-2">
                            <div class="col-6 col-lg-3">
                                <input type="search" class="form-control form-control-sm border-primary"
                                    placeholder="Search" style="min-width: 100%;">
                            </div>
                            <div class="col-6 col-lg-3">
                                <input type="search" class="form-control form-control-sm border-primary"
                                    placeholder="Search by client" style="min-width: 100%;">
                            </div>
                            <div class="col-6 col-lg-3">
                                <a href="{{ route('admin.add_edit_client_account') }}" class="btn btn-primary btn-sm w-100">Add Client Account</a>
                            </div>
                            <div class="col-6 col-lg-3">
                                <a href="#" class="btn btn-primary btn-sm w-100 text-white">Inactive List</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Scrollable Table -->
                <div class="table-responsive-sm" style="max-height: 400px;">
                    <table class="table table-bordered table-sm align-middle text-center small mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>Username</th>
                                <th>Balance</th>
                                <th>Exposure</th>
                                <!-- <th>Exposure Limit</th> -->
                                <th>Avail .Bal.</th>
                                <!-- <th>Ref. P/L</th> -->
                                <th>Partnership</th>
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
                                    <td>
                                        @php
                                        $userRoles = ['admin','super admin','super master','master','agent','user'];
                                        @endphp
                                        <a href="{{route('admin.user_downline_list',$user->username)}}"> 
                                            <span class="badge bg-success">{{$userRoles[$user->status]}}</span class="text-white"> {{ $user->username }}
                                        </a>
                                    </td>
                                    <td>{{ $user->wallet_amount }}</td>
                                    <td>{{ $user->unsattled_amount }}</td>
                                    <!-- <td>200000</td> -->
                                    <td>{{$user->wallet_amount - $user->unsattled_amount }}</td>
                                    <!-- <td>1000</td> -->
                                    <td>{{$user->partnership_percentage }}</td>
                                    <td><input type="checkbox" name="u_lock" /></td>
                                    <td><input type="checkbox" name="b_lock" /></td>
                                    <!-- <td>10%</td> -->
                                    <td>
                                        <span class="badge bg-{{ $user->status == 3 ? 'danger' : 'success' }}">
                                            {{ $user->status == 6 ? 'inactive' : 'active' }}
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
<script>
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]'));
    tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
