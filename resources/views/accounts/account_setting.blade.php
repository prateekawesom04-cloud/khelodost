@extends('sports_master')

@section('sports_body')
<main class="layout-content-center p-3">

    <!-- Edit Stack Card -->
    {{-- <div class="card deposit-card border-0 rounded-3 p-4 shadow-sm">
        
        <!-- Title -->
        <div class="mb-4">
            <h5 class="bg-success text-white px-3 py-2 m-0">Edit Stack</h5>
        </div>

        <!-- Amount Input -->
        <div class="input-group mb-2">
            <span class="input-group-text bg-light border-end-0">₹</span>
            <input type="number" id="amount" name="amount" class="form-control border-start-0 border-end-0" value="{{isset($userBank->account_id)?$userBank->account_id:''}}" 
                   placeholder="Enter Amount" min="100" max="500000">
            <span class="input-group-text bg-light border-start-0">INR</span>
        </div>
        <small class="text-muted d-block mb-3">Min 100 - Max 5,00,000</small>

        <!-- Quick Amount Buttons -->
        <div class="row g-2 mb-4">
            @foreach ([500, 1000, 2000, 5000, 10000, 15000] as $amount)
                <div class="col-4">
                    <button type="button" 
                            class="btn btn-outline-success w-100 fw-semibold rounded-2"
                            onclick="setAmount({{ $amount }})">
                        +{{ number_format($amount) }}
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="text-end">
            <a href="javascript:void(0)" class="btn btn-success fw-semibold px-4 rounded-2">
                Submit
            </a>
        </div>
    </div> --}}

    <!-- Spacer / Divider -->
    <hr class="my-5">

    <!-- Add/Edit Payment Card -->
    <form class="card deposit-card border-0 rounded-3 p-4 shadow-sm">
        
        <!-- Title -->
        <div class="mb-4">
            <h5 class="bg-success text-white px-3 py-2 m-0">Add / Edit Payment</h5>
        </div>

        <!-- Account No. -->
        <div class="mb-3">
            <label for="account_id" class="form-label fw-semibold">Account ID</label>
            <input type="text" id="account_id" name="account_id" class="form-control" placeholder="Account No./Card No./Upi ID" value="{{isset($userBank->account_id)?$userBank->account_id:''}}">
        </div>
        
        <!-- Confirm Account No. -->
        <div class="mb-3">
            <label for="confirm_account_id" class="form-label fw-semibold">Confirm Account ID</label>
            <input type="text" id="confirm_account_id" name="confirm_account_id" class="form-control" placeholder="Account No./Card No./Upi ID" value="">
        </div>

        <!-- Account Holder Name -->
        <div class="mb-3">
            <label for="account_holder" class="form-label fw-semibold">Account Holder Name</label>
            <input type="text" id="account_holder" name="account_holder" class="form-control" placeholder="Enter Account Holder Name" value="{{isset($userBank->account_holder)?$userBank->account_holder:''}}">
        </div>

        <!-- IFSC Code -->
        <div class="mb-3">
            <label for="ifsc_code" class="form-label fw-semibold">IFSC Code</label>
            <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" placeholder="Enter IFSC Code" value="{{isset($userBank->ifsc_code)?$userBank->ifsc_code:''}}">
        </div>

        <!-- Bank Name -->
        <div class="mb-4">
            <label for="bank_name" class="form-label fw-semibold">Bank Name</label>
            <input type="text" id="bank_name" name="bank_name" class="form-control" placeholder="Enter Bank Name" value="{{isset($userBank->bank_name)?$userBank->bank_name:''}}">
        </div>

        <!-- Save Button -->
        <div class="text-end">
            <a href="javascript:void(0)" class="btn btn-success fw-semibold px-4 rounded-2 addBank">
                Save
            </a>
        </div>
    </form>

</main>

<!-- Script to Set Amount -->
<script>
    function setAmount(value) {
        document.getElementById('amount').value = value;
    }

    $('.addBank').on('click',function(){
        $(this).attr('disabled','true');
        formData = new FormData($(this).parents('form')[0]);
        callApiFormData('post',`{{route('user.action.addBank')}}`,formData,ajaxResponseModal);
    });
</script>
@endsection
