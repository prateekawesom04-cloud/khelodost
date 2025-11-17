<!-- Compact Reusable Modal with Form -->
<div class="modal fade" id="mainModal" tabindex="-1" aria-labelledby="mainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header-dark flex justify-between items-center">
                <h5 class="modal-title mx-2" id="mainModalLabel">Add Method</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <!-- Modal Body with Form -->
            <div class="modal-body modal-body-dark formParntClassname">
                <form id="methodForm" data-m_key="payments">
                    <input type="hidden" name="status" value="1">
                    <div class="mb-3">
                        <label for="methodType" class="form-label">Select Type</label>
                        <select class="form-select form-select-sm modal-body-dark" id="methodType" name="payment_method"
                            required>
                            <option value="" disabled selected>Select a method</option>
                            <option value="upi">UPI</option>
                            <option value="bank">Bank</option>
                            <option value="phonepe">PhonePe</option>
                            <option value="gpay">GPay</option>
                            <option value="paytm">Paytm</option>
                            <option value="qrcode">QR Code</option>
                            <option value="usdt">USDT</option>
                        </select>
                    </div>
                    <!-- Dynamic Fields will appear here -->
                    <div id="dynamicFields"></div>
                    <div class="text-end mt-2">
                        <a href="javascript:void(0)" type="submit" class="btn btn-primary btn-sm submit_modal">Save</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- JavaScript  -->
<script>
    document.getElementById('methodType').addEventListener('change', function() {
        const selected = this.value;
        const dynamicFields = document.getElementById('dynamicFields');
        dynamicFields.innerHTML = '';

        if (selected === 'upi') {
            dynamicFields.innerHTML = `
        <div class="mb-2">
            <label for="upiId" class="form-label">UPI ID</label>
            <input type="text" class="form-control form-control-sm" id="upiId" name="payment_method_uid" required>
        </div>
        <div class="mb-2">
            <label for="upiHolderName" class="form-label">UPI Holder Name</label>
            <input type="text" class="form-control form-control-sm" id="upiHolderName" name="holder_name" required>
        </div>
    `;
        } else if (selected === 'qrcode') {
            dynamicFields.innerHTML = `
                <div class="mb-2">
                    <label for="accountName" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control form-control-sm" id="accountName" name="holder_name" required>
                </div>
                <div class="mb-2">
                    <label for="qrUpload" class="form-label">Upload QR Code</label>
                    <input type="file" class="form-control form-control-sm" id="qrUpload" name="payment_method_uid" accept="image/*" required>
                </div>
            `;
        } else if (selected === 'bank') {
            dynamicFields.innerHTML = `
                <div class="mb-2">
                    <label for="accountName" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control form-control-sm" id="accountName" name="holder_name" required>
                </div>
                <div class="mb-2">
                    <label for="accountNumber" class="form-label">Account Number</label>
                    <input type="text" class="form-control form-control-sm" id="accountNumber" name="payment_method_uid" required>
                </div>
                <div class="mb-2">
                    <label for="ifsc" class="form-label">IFSC Code</label>
                    <input type="text" class="form-control form-control-sm" id="ifsc" name="ifsc_code" required>
                </div>
            `;
        } else if (selected === 'phonepe' || selected === 'gpay' || selected === 'paytm') {
            dynamicFields.innerHTML = `
                <div class="mb-2">
                    <label for="accountName" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control form-control-sm" id="accountName" name="holder_name" required>
                </div>
                <div class="mb-2">
                    <label for="mobileNumber" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control form-control-sm" id="mobileNumber" name="payment_method_uid" required>
                </div>
            `;
        } else if (selected === 'usdt') {
            dynamicFields.innerHTML = `
                <div class="mb-2">
                    <label for="accountName" class="form-label">Account Holder Name</label>
                    <input type="text" class="form-control form-control-sm" id="accountName" name="holder_name" required>
                </div>
                <div class="mb-2">
                    <label for="usdtId" class="form-label">USDT Wallet Id</label>
                    <input type="text" class="form-control form-control-sm" id="usdtId" name="payment_method_uid" required>
                </div>
            `;
        }
    });
</script>
