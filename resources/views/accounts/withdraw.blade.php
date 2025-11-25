@extends('sports_master')

@section('sports_body')
<!-- Breadcrumb Navigation -->
<main class="layout-content-center p-3">
<div class="breadcrumb-nav fw-bold">
  <span>🏠</span>
  <span class="breadcrumb-arrow">></span>
  <span>Withdraw</span>
</div>

<!-- Main Withdraw Card -->
<div class="withdraw-card">
  <!-- Available Withdraw Amount Badge -->
  <div class="withdraw-badge">
    Available Withdraw Amount: ₹ {{isset($userData->wallet_amount)?$userData->wallet_amount:'00'}}
  </div>

  <!-- Amount Section -->
  <div class="amount-label">AMOUNT</div>
  
  <div class="input-group amount-input-group">
    <span class="input-group-text">₹</span>
    <input id="depositAmount" type="number" class="form-control" placeholder="Enter Amount" aria-label="Amount">
    <span class="input-group-text">INR</span>
  </div>

            <!-- Quick Amount Links -->
            <div class="row g-2 mb-4">
                @foreach ([500, 1000, 2000, 5000, 10000, 15000] as $amount)
                    <div class="col-4">
                        <a href="javascript:void(0)" data-amount="{{ $amount }}"
                            class="btn btn-success w-100 fw-semibold rounded-2 amount-btn !bg-[#0c9971]">+{{ $amount }}</a>
                    </div>
                @endforeach
            </div>
  <!-- Payment Method Section -->
  {{-- <div class="payment-method-section">
    <div class="payment-method-title">Select Payment Method</div>
    <div class="payment-method-subtitle">No previous payment methods available.</div>
  </div> --}}

  <!-- Submit Button -->
  <button type="submit" class="submit-btn">Submit</button>
</div>

<!-- Bottom Action Buttons -->
{{-- <div class="bottom-buttons">
  <a href="javascript:void(0)" class="bottom-btn">Show Withdraw History</a>
  <a href="javascript:void(0)" class="bottom-btn">Add Withdraw Method</a>
</div> --}}    

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

@endsection


@section('js')

<script>

    // Quick amount buttons
    $('.amount-btn').click(function() {
        $('#depositAmount').val($(this).attr('data-amount'));
    });
    
    // On submit button click
    $('button.submit-btn').click(function() {
        let transfer_amount = parseInt($('#depositAmount').val());
        let data = {};
        data.payment_type = '1';

        if (transfer_amount >= 500) {
            data.transfer_amount = transfer_amount;

            callAjax('post', 'paymentGatewayMethod', data, paymentGatewayMethod);
            
        } else {
            alert('Please Enter Amount more than 100');
        }
    });

    function paymentGatewayMethod(response) {
        // response = JSON.parse(response.response);
        data = JSON.parse(response.data);
        console.log('res msg',response.message,'data--',data);
        
        if (response.response_code == 200) {
            // $('#paymentModel').modal('show');
            if(data['payUrl']){
                window.location.href = data['payUrl'];
            } else{
                responseToast(response.message);
            }
            // $('.paymentModel').html(response.response);

        } else {
            responseToast('Deposit Request failed');
            // window.location.reload();
        }
        
    }

</script>

@endsection