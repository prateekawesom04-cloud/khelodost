<div class="modal fade balance_modal" id="balanceModal" tabindex="-1" aria-labelledby="balanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
        <div class="modal-content mx-2"> <!-- Added horizontal margin -->

            <!-- Modal Header -->
            <div class="modal-header modal-header-dark py-2">
                <h5 class="modal-title fs-6" id="balanceModalLabel">Deposit Update</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <!-- Modal Body with the form -->
            <div class="modal-body modal-body-dark formParntClassname">
                <form id="balance_form_deposit" class="balance_form form">
                    @csrf
                    <input name="username" type="hidden" id="username" class="form-control" value="">
                    <input type="hidden" name="payment_type" value="0">
                    <!-- Balance -->
                    <div class="mb-3">
                        <div class="flex flex-row justify-between items-center">
                            <label for="balance" class="form-label">Balance</label>
                            <label for="balance" class="form-label">Available Balance <span class="userBalance"></span></label>
                        </div>
                        <input type="text" name="transfer_amount" class="form-control" placeholder="Enter balance" autocomplete="off">
                    </div>

                    <!-- Remark -->
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <input type="text" name="remark" class="form-control" value="" autocomplete="off">
                    </div>

                    <!-- Your Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Your Password</label>
                        <input type="password" name="master_password" class="form-control">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end">
                        <a type="submit" name="action" value="deposit" class="btn btn-success me-2 updateWalletSubmit">Deposit</a>
                        <!-- <a type="submit" name="action" value="withdraw" class="btn btn-danger" >Withdraw</a> -->
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade balance_modal" id="withdrawModal" tabindex="-1" aria-labelledby="balanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-scrollable">
        <div class="modal-content mx-2"> <!-- Added horizontal margin -->

            <!-- Modal Header -->
            <div class="modal-header modal-header-dark py-2">
                <h5 class="modal-title fs-6" id="balanceModalLabel">Withdraw</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>

            <!-- Modal Body with the form -->
            <div class="modal-body modal-body-dark formParntClassname">
                <form id="balance_form_withdraw" class="balance_form form">
                    @csrf
                    <input name="username" type="hidden" id="username" class="form-control" value="">
                    <input type="hidden" name="payment_type" value="1">
                    <!-- Balance -->
                    <div class="mb-3">
                        <div class="flex flex-row justify-between items-center">
                            <label for="balance" class="form-label">Balance</label>
                            <label for="balance" class="form-label">Available Balance <span class="userBalance"></span></label>
                        </div>
                        <input type="text" name="transfer_amount" class="form-control" placeholder="Enter balance" autocomplete="off">
                    </div>

                    <!-- Remark -->
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <input type="text" name="remark" class="form-control" value="" autocomplete="off">
                    </div>

                    <!-- Your Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Your Password</label>
                        <input type="password" name="master_password" class="form-control">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end">
                        <a type="submit" name="action" value="deposit" class="btn btn-success me-2 updateWalletSubmit">Withdraw</a>
                        <!-- <a type="submit" name="action" value="withdraw" class="btn btn-danger" >Withdraw</a> -->
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
