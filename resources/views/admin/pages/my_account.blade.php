@extends('admin.master')
@section('body')
    <!-- Responsive Account Page -->
    <div class="container-fluid p-2 p-md-4">
        <div class="row g-2 g-md-3">

            <!-- Sidebar -->
            <div class="col-12 col-lg-3">
                <div class="card shadow-sm">
                    <!-- <div class="card-header bg-primary fw-bold">
                        My Account
                    </div> -->

                    <!-- Desktop Navigation -->
                    <ul class="list-group list-group-flush mb-0">
                        <li>
                            <a href="javascript:void(0);"
                                class="list-group-item list-group-item-action sidebar-link active"
                                data-target="profile">Agent Profile</a>
                        </li>
                        @if($user->status==2)
                        <li>
                            <a href="javascript:void(0);"
                                class="list-group-item list-group-item-action sidebar-link"
                                data-target="bethistory">Bet History</a>
                        </li>
                        @endif
                        <li>
                            <a href="javascript:void(0);"
                                class="list-group-item list-group-item-action sidebar-link"
                                data-target="statement">Account Statement</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"
                                class="list-group-item list-group-item-action sidebar-link"
                                data-target="deposit_withdrawal">Deposit & Withdraw</a>
                        </li>
                        @if($user->status==2)
                        <li>
                            <a href="javascript:void(0);"
                                class="list-group-item list-group-item-action sidebar-link"
                                data-target="activity">Activity Log</a>
                        </li>
                        @endif
                    </ul>

                    <!-- Mobile/Tablet Navigation -->
                    {{-- <div class="d-block d-none p-2">
                        <div class="d-flex gap-1">
                            <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-link active flex-fill"
                                data-target="profile">Profile</a>
                            <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-link flex-fill"
                                data-target="statement">Statement</a>
                            <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-link flex-fill"
                                data-target="deposit_withdrawal">Deposit & Withdraw</a>
                            <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-link flex-fill"
                                data-target="activity">Activity</a>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-12 col-lg-9">

                <!-- Profile Section -->
                <div id="profile-section">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Account Details</div>
                        <div class="card-body p-0 !text-black">
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Name</div>
                                <div class="text-break">{{$user->username}}</div>
                            </div>
                            <!-- <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Commission</div>
                                <div>{{$user->commission_amount}}</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Rolling Commission</div>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#rollingCommissionModal"
                                        title="Edit">
                                        <i class="fas fa-pen-to-square text-primary"></i>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#agentrollingCommissionModal"
                                        title="View">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Agent Rolling Commission</div>
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#agentrollingCommissionModal"
                                        title="View">
                                        <i class="fas fa-eye text-primary"></i>
                                    </a>
                                </div>
                            </div> -->
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Currency</div>
                                <div>INR</div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Exposure Limit</div>
                                <div>{{$user->unsattled_amount}}</div>
                            </div>
                            @if($user->status!=5)
                            {{-- <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Partnership</div>
                                <div>{{$user->partnership_percentage}}</div>
                            </div> --}}
                            @endif
                            @if($user->phone)
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Mobile Number</div>
                                <div>{{($user->phone)?$user->phone:0}} <span>
                                    <i data-username="{{ $user->username }}" class="fas fa-pen-to-square text-primary changePhoneModal" style="cursor: pointer;"
                                        title="Update Phone" data-bs-toggle="modal"
                                        data-bs-target="#changePhoneModal">
                                    </i>
                                </span></div>
                            </div>
                            @endif
                            @if($user->status!=5)
                            <div class="d-flex justify-content-between align-items-center border-bottom px-3 py-2">
                                <div class="fw-bold">Refer</div>
                                <div>{{route('user.referral_code',$user->referral_code)}}</div>
                            </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center px-3 py-2">
                                <div class="fw-bold">Password</div>
                                <div class="d-flex align-items-center gap-2">
                                    <span>*********</span>
                                    <i data-username="{{ $user->username }}" class="fas fa-pen-to-square text-primary changePasswordModel" style="cursor: pointer;"
                                        title="Edit Password" data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal">
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- bethistory Section -->
                <div id="bethistory-section" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Profit/Loss History</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-nowrap">Sportname</th>
                                            <th class="text-nowrap">Event Name</th>
                                            <th class="text-nowrap">Market name</th>
                                            <th class="text-nowrap">Result</th>
                                            <th class="text-nowrap">Profit/Loss</th>
                                            <th class="text-nowrap">Total Balance</th>
                                            <th class="text-nowrap">Settle Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sportbookBets as $transaction)
                                        <tr>
                                            <td>{{$transaction->sportname}}</td>
                                            <td>{{$transaction->eventName}}</td>
                                            <td>{{$transaction->mname}}</td>
                                            <td>{{$transaction->nat}}</td>
                                            <td class="{{($transaction->status==2)? 'text-danger' : 'text-success'}}">{{$transaction->profit}}</td>
                                            <td>{{$transaction->wallet_before}}</td>
                                            <td class="text-success fw-bold text-nowrap">{{$transaction->status? $transaction->updated_at : 'Unsattled'}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Statement Section -->
                <div id="statement-section" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Profit/Loss History</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-nowrap">Sportname</th>
                                            <th class="text-nowrap">Event Name</th>
                                            <th class="text-nowrap">Market name</th>
                                            <th class="text-nowrap">Result</th>
                                            <th class="text-nowrap">Profit/Loss</th>
                                            <th class="text-nowrap">Total Balance</th>
                                            <th class="text-nowrap">Settle Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sportbookBets as $transaction)
                                        <tr>
                                            <td>{{$transaction->sportname}}</td>
                                            <td>{{$transaction->eventName}}</td>
                                            <td>{{$transaction->mname}}</td>
                                            <td>{{$transaction->nat}}</td>
                                            <td class="{{($transaction->status==2)? 'text-danger' : 'text-success'}}">{{$transaction->profit}}</td>
                                            <td>{{$transaction->wallet_before}}</td>
                                            <td class="text-success fw-bold text-nowrap">{{$transaction->status? $transaction->updated_at : 'Unsattled'}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Account Statement</div>
                        <div class="card-body">

                            <div class="row mb-3 g-2">
                                <div class="col-12 col-md-4">
                                    <form class="filter_data">
                                        @csrf
                                        <input type="hidden" name="username" value="{{$user->username}}">
                                        <select name="filter_type" class="form-control border-secondary filter_type">
                                            <option value="0">Deposit</option>
                                            <option value="1">Withdrawal</option> --}}
                                            {{-- @foreach($providers as $provider)
                                            <option value="{{$provider->provider}}">{{$provider->provider}}</option>
                                            @endforeach --}}
                                        {{-- </select>
                                    </form>
                                </div>
                                <div class="col-6 col-md-3">

                                    <input type="text" id="fromDate" name="fromDate" class="form-control"
                                        value="2025-09-08T00:00" />
                                </div>
                                <div class="col-6 col-md-3">

                                    <input type="text" id="toDate" name="toDate" class="form-control"
                                        value="2025-09-15T00:00" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <button class="btn btn-primary w-100">Get Statement</button>
                                </div>
                            </div>

                            <div class="table-responsive table_div">
                                
                            </div>

                        </div>
                    </div> --}}
                </div>

                <!-- Deposit Withdrawal Section -->
                <div id="deposit-withdrawal-section" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Deposit & Withdraw</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-nowrap">Date/Time</th>
                                            <th class="text-nowrap">Total Balance</th>
                                            <th class="text-nowrap">Deposit</th>
                                            <th class="text-nowrap">WithDraw</th>
                                            <th class="text-nowrap">Available Balance</th>
                                            <th class="text-nowrap">Status</th>
                                            <th class="text-nowrap">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                            @php
                                                if($transaction->status==2){
                                                    if($transaction->payment_type){
                                                        $available_balance = (int) $transaction->wallet_before - (int) $transaction->transfer_amount;
                                                    } else{
                                                        $available_balance = (int) $transaction->wallet_before + (int) $transaction->transfer_amount;
                                                    }

                                                } else{
                                                    $available_balance = (int) $transaction->wallet_before;
                                                }
                                            @endphp
                                        <tr>
                                            <td class="text-nowrap">{{$transaction->created_at}}</td>
                                            <td>{{$transaction->wallet_before}}</td>
                                            <td>{{($transaction->payment_type)?'-':$transaction->transfer_amount}}</td>
                                            <td>{{($transaction->payment_type)?$transaction->transfer_amount:'-'}}</td>
                                            <td>{{$available_balance}}</td>
                                            <td>{{($transaction->status==2)?'success':(($transaction->status==1)?'processing':'failed')}}</td>
                                            <td class="text-success fw-bold text-nowrap">Patna</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log Section -->
                <div id="activity-section" style="display: none;">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary fw-bold">Activity Log</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped mb-0">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-nowrap">Login Date & Time</th>
                                            <th class="text-nowrap">IP</th>
                                            <th class="text-nowrap">City/State/Country</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activities as $activity)
                                        <tr>
                                            <td class="text-nowrap">{{$activity->created_at}}</td>
                                            <td>{{$activity->ip}}</td>
                                            <td class="text-success fw-bold text-nowrap">Patna</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

<!-- JS to toggle sections -->
 @section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const links = document.querySelectorAll('.sidebar-link');
        const sections = {
            profile: document.getElementById('profile-section'),
            bethistory: document.getElementById('bethistory-section'),
            statement: document.getElementById('statement-section'),
            deposit_withdrawal: document.getElementById('deposit-withdrawal-section'),
            activity: document.getElementById('activity-section'),
        };

        links.forEach(link => {
            link.addEventListener('click', function() {
                // Remove active class from all links
                links.forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');

                // Get target section
                const target = this.getAttribute('data-target');

                // Hide all sections and show target section
                for (const key in sections) {
                    sections[key].style.display = (key === target) ? 'block' : 'none';
                }
            });
        });
    });

    

    
    let form = $('.filter_type').parents('form');
    let formData = new FormData(form[0]);
    $(document).ready(function(){
        callAjaxFormData('post', `{{url('/admin')}}/userStatments`, formData, transactionList);
    });

</script>
@endsection