@extends('sports_master')

@section('sports_body')
    <main class="layout-content-center p-3 account-deposit">
        <!-- Current Balance -->
        <div class="breadcrumb-nav fw-bold">
            <span>🏠</span>
            <span class="breadcrumb-arrow">></span>
            <span>Deposit</span>
        </div>

        <!-- Deposit Card -->
        <div class="card deposit-card border-0 rounded-3 p-4">
            <span class="badge bg-success p-2 px-3 rounded-pill shadow-sm">
                Current Available Balance: ₹ {{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}}
            </span>

            <!-- Amount Section -->
            <label class="form-label fw-bold">AMOUNT</label>
            <div class="input-group mb-2">
                <span class="input-group-text bg-light border-end-0">₹</span>
                <input id="depositAmount" type="number" class="form-control border-start-0 border-end-0" placeholder="Enter Amount"
                    min="100" max="500000">
                <span class="input-group-text bg-light border-start-0">INR</span>
            </div>
            <small class="text-muted d-block mb-3">Min 100 - Max 5,00,000</small>

            <!-- Quick Amount Links -->
            <div class="row g-2 mb-4">
                @foreach ([500, 1000, 2000, 5000, 10000, 15000] as $amount)
                    <div class="col-4">
                        <a href="javascript:void(0)" data-amount="{{ $amount }}"
                            class="btn btn-success w-100 fw-semibold rounded-2 amount-btn">+{{ $amount }}</a>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <a href="javascript:void(0)" class="btn btn-success fw-semibold px-4 rounded-2 btn-submit">Submit</a>
            </div>
        </div>
        
        <!-- Table Section -->
        <div class="table-responsive rounded mt-4" style="white-space: nowrap;">
            <table class="table table-bordered text-white mb-0">
                <thead class="text-center">
                    <tr>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Transaction No</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($data) && count($data) > 0)
                        @foreach ($data as $value)
                            <tr class="text-center" style="background-color: #3e3e3e;">
                                <td>{{ $value->payment_type ? 'Withdraw' : 'Deposit' }}</td>
                                <td>{{ $value->transfer_amount }}</td>
                                <td>{{ $value->status == 2 ? 'Success' : 'Processing' }}</td>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y') }}</td>
                                <td style="word-break: break-word;">{{ $value->order_sn }}</td>
                                <td>{{ $value->remark }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-white">No Data Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </main>

    
<div class="modal fade" id="paymentModel" tabindex="-1" aria-labelledby="sattleEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="mainModalLabel">Deposit</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body modal-header-dark paymentModel">
                
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')

<script>

    // Quick amount buttons
    $('.amount-btn').click(function() {
        $('#depositAmount').val($(this).attr('data-amount'));
    });
    
    // On submit button click
    $('a.btn-submit').click(function() {
        let transfer_amount = parseInt($('#depositAmount').val());
        let data = {};
        data.payment_type = '0';

        if (transfer_amount >= 100) {
            data.transfer_amount = transfer_amount;

            callAjax('post', 'paymentGatewayMethod', data, paymentGatewayMethod);
            
        } else {
            alert('Please Enter Amount more than 100');
        }
    });

    function paymentGatewayMethod(response) {
        // response = JSON.parse(response.response);
        data = JSON.parse(response.data);
        if (response.response_code == 200) {
            // $('#paymentModel').modal('show');
            window.location.href = data['payUrl'];
            // $('.paymentModel').html(response.response);

        } else {
            responseToast('Deposit Request failed');
            // window.location.reload();
        }
        
    }

</script>

@endsection