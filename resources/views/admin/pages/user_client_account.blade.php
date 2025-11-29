@extends('admin.master')

@section('body')
<div class="container-fluid py-4 formParntClassname">
    <form id="createAccountForm" data-url="user_client_account">
        <!-- Account Details -->
        <input type="hidden" name="admin_username" value="{{($userData->admin_username)?$userData->admin_username:'adminabcd'}}">
         @csrf
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white py-1">
                <h5 class="mb-0">
                    <i class="fa-solid fa-id-badge me-2"></i> Account Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="accountType" class="form-label">
                            <i class="fas fa-user-tag me-1 text-primary"></i> Account Type
                        </label>
                        <select name="status" id="accountType" class="form-select border-2" required>
                            <option value="2" selected>👨‍💼 User</option>
                        </select>
                    </div>

                    <!-- <div class="col-md-6">
                        <label for="clientName" class="form-label">
                            <i class="fas fa-building me-1 text-primary"></i> Client Name
                        </label>
                        <input name="clientName" id="clientName" type="text" class="form-control border-2" placeholder="Enter Client Name" required>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-success text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-address-card me-2"></i> Personal Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 g-md-4">
                    <div class="col-12 col-md-6">
                        <label for="username" class="form-label small">
                            <i class="fas fa-user me-1 text-success d-none d-md-inline"></i> Username
                        </label>
                        <input name="username" id="username" type="text" class="form-control border-2" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="referenceCode" class="form-label small">
                            <i class="fas fa-user-friends me-1 text-success d-none d-md-inline"></i> Reference Code (optional)
                        </label>
                        <input name="referral_code" id="referenceCode" type="text" class="form-control border-2" value="{{substr(uniqid().rand(1000,1111),4)}}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label small">
                            <i class="fas fa-lock me-1 text-success d-none d-md-inline"></i> Password
                        </label>
                        <div class="position-relative">
                            <input name="password" id="password" type="password" class="form-control border-2" style="padding-right: 45px;" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword('password', this)">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="confirm_password" class="form-label small">
                            <i class="fas fa-lock me-1 text-success d-none d-md-inline"></i> Retype Password
                        </label>
                        <div class="position-relative">
                            <input name="confirm_password" id="confirm_password" type="password" class="form-control border-2" style="padding-right: 45px;" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword('confirm_password', this)">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Settings -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-warning text-dark py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-gear me-2"></i> User Settings
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 g-md-4">
                    <div class="col-12 col-md-6">
                        <label for="maxBet" class="form-label small">
                            <i class="fas fa-coins me-1 text-warning d-none d-md-inline"></i> Max Bet (₹)
                        </label>
                        <input name="max_bet" id="maxBet" type="number" class="form-control border-2 text-center" min="0" value="0">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="maxProfit" class="form-label small">
                            <i class="fas fa-trophy me-1 text-warning d-none d-md-inline"></i> Max Profit (₹)
                        </label>
                        <input name="max_profit" id="maxProfit" type="number" class="form-control border-2 text-center" min="0" value="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sport & Casino Balance -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-dark text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-coins me-2"></i> Sport & Casino Balance
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 g-md-4">
                    <!-- <div class="col-12 col-md-4">
                        <label for="creditRef" class="form-label small">
                            <i class="fas fa-credit-card me-1 text-dark d-none d-md-inline"></i> Credit Reference
                        </label>
                        <input name="creditref" id="creditRef" type="text" class="form-control border-2">
                    </div> -->
                    <div class="col-12 col-md-6">
                        <label for="deposit" class="form-label small">
                            <i class="fas fa-plus-circle me-1 text-success d-none d-md-inline"></i> Add Deposit (₹)
                        </label>
                        <input name="wallet_amount" id="deposit" type="number" class="form-control border-2 text-center">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="depositRemark" class="form-label small">
                            <i class="fas fa-comment me-1 text-dark d-none d-md-inline"></i> Deposit Remark
                        </label>
                        <input name="remark" id="depositRemark" type="text" class="form-control border-2">
                    </div>
                </div>
            </div>
        </div>

        <!-- Security -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-danger text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-shield me-2"></i> Security
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 mx-auto">
                        <label for="masterPassword" class="form-label small">
                            <i class="fas fa-key me-1 text-danger d-none d-md-inline"></i> Master Password
                        </label>
                        <div class="position-relative">
                            <input name="masterPassword" id="masterPassword" type="password" class="form-control border-2" style="padding-right: 45px;" required>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword('masterPassword', this)">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <!-- Submit Button -->
    <div class="mb-5 text-center text-md-start">
        <a class="add_user_client btn btn-success px-4 px-md-5 py-2 py-md-1 shadow-lg w-100 w-md-auto">
            <i class="fa-solid fa-circle-plus me-2"></i>
            Create Account
        </a>
    </div>
</div>

<script>
function togglePassword(inputId, eyeIcon) {
    const passwordInput = document.getElementById(inputId);
    const icon = eyeIcon.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

</script>
@endsection

@section('js')
<script>
    
</script>

@endsection