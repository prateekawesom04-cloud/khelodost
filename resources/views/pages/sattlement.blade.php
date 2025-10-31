@extends('admin.master')

@section('body')

    <div class="flex flex-col justify-center items-center">
        <h4 class="my-1 border-b border-gray-300">Settlement Page</h4>
        {{-- <h4 class="mt-2 mb-1">{{$eventId}}</h4> --}}
        <h4 class="mt-2 mb-1">Event List</h4>
        <div class="">
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
                                <td><span class="badge bg-success">USER</span> {{ $user->username }}</td>
                                <td>{{ $user->wallet_amount }}</td>
                                <td>{{ $user->unsattled_amount }}</td>
                                <!-- <td>200000</td> -->
                                <td>{{$user->wallet_amount - $user->unsattled_amount }}</td>
                                <!-- <td>1000</td> -->
                                <!-- <td>{{$user->partnership_percentage }}</td> -->
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
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" />
                <label class="form-check-label" for="inlineRadio1">Win</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" />
                <label class="form-check-label" for="inlineRadio2">Loss</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" />
                <label class="form-check-label" for="inlineRadio2">Draw</label>
            </div>
        </div>
    </div>
@endsection