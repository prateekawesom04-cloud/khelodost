@extends('admin.master')
@section('body')
    <div class="container-fluid p-4">
        <div class="card border border-primary">
            <div class="card-header bg-primary text-white p-2 rounded-top">
            <h4 class="mb-0">Withdraw Amount</h4>
        </div>
            <div class="card-body">

                <!-- Controls Section -->
                <div class="overflow-auto mb-3">
                    <div class="d-flex flex-nowrap justify-content-between align-items-center gap-3"
                        style="min-width: 320px;">
                        <!-- Show Entries -->
                        <div class="d-flex align-items-center flex-shrink-0">
                            <label class="me-2 mb-0">Show</label>
                            <select class="form-select w-auto me-2">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>

                        </div>

                        <!-- Search -->
                        <div class="d-flex align-items-center flex-shrink-0">
                            <label class="me-2 mb-0">Search:</label>
                            <input type="search" class="form-control form-control-sm w-auto">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                        <table class="table table-bordered table-striped acc-table">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Action</th>
                                    <th>Date/Time</th>
                                    <th>UID</th>
                                    <th>Transaction ID</th>
                                    <th>Total Balance</th>
                                    {{-- <th>Deposit</th> --}}
                                    <th>WithDraw</th>
                                    <th>Available Balance</th>
                                    {{-- <th>Screenshot</th> --}}
                                    <th>Status</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    @php
                                        if($transaction->payment_type){
                                            $available_balance = (int) $transaction->wallet_before - (int) $transaction->transfer_amount;
                                        } else{
                                            $available_balance = (int) $transaction->wallet_before + (int) $transaction->transfer_amount;
                                        }
                                    @endphp
                                <tr>
                                    <td>
                                        @if($transaction->status==1)
                                        <flex class="flex flex-row items-center justify-evenly gap-3">
                                            <div class="p-[.3rem] border-2 !border-[#0d6efd] solid flex">
                                                <i data-order_sn="{{ $transaction->order_sn }}" class="fas fa-circle-xmark text-danger reject_withdraw" style="cursor: pointer;" title="reject">
                                                </i>
                                            </div>
                                            <div class="p-[.3rem] border-2 !border-[#0d6efd] solid flex">
                                                <i data-order_sn="{{ $transaction->order_sn }}" class="fas fa-check text-primary approve_withdraw" style="cursor: pointer;" title="approve">
                                                </i>
                                            </div>

                                        </flex>
                                        @else
                                        --
                                        @endif
                                    </td>
                                    <td>{{$transaction->created_at}}</td>
                                    <td>{{$transaction->username}}</td>
                                    <td>{{$transaction->order_sn}}</td>
                                    <td>{{$transaction->wallet_before}}</td>
                                    {{-- <td>{{($transaction->payment_type)?'-':$transaction->transfer_amount}}</td> --}}
                                    <td>{{($transaction->payment_type)?$transaction->transfer_amount:'-'}}</td>
                                    <td>{{$available_balance}}</td>
                                    {{-- <td>--</td> --}}
                                    <td>{{($transaction->status==2)?'Success':(($transaction->status==1)?'Processing':'Failed')}}</td>
                                    <td>{{$transaction->remark}}</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                <!-- Bottom Controls -->
                {{-- <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-2 mt-3">
                    <a class="btn acc-btn-clear w-100 w-md-auto">Clear All</a>
                    <input type="password" class="form-control acc-password-input w-100 w-md-auto" placeholder="•••••••">
                    <a class="btn acc-btn-submit w-100 w-md-auto">Submit Payment</a>
                </div> --}}

                <!-- Entry Info -->
                <div class="mt-3 text-end">
                    <small>Showing 1 to 10 of 2 entries</small>
                </div>

            </div>
        </div>
    </div>
@endsection

    @section('js')
    <script>
        $('.transaction_status').on('change',function(){
            let formData = {};
            
            formData['previous_url'] = '{{url()->previous()}}';
            formData['search_data_key'] = 'order_sn';
            formData['search_data_value'] = $(this).attr('data-order_sn');
            formData['update_data_key'] = $(this).attr('name');
            formData['update_data_value'] = $(this).val();
            formData['update_data_model_key'] = 'transactions';
            callAjaxFormData('post', `{{url('/admin')}}/updateModelData`, formData, ajaxResponseModal);
        });
    </script>
    @endsection