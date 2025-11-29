@extends('admin.master')

@section('body')
<div class="container-fluid py-4 formParntClassname">
    <form id="createAccountForm" data-url="add_edit_client_account">
    @csrf
        <input type="hidden" name="admin_username" value="{{$userData->username}}">
        <!-- Account Details -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-id-badge me-2"></i> Account Details
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 g-md-4">
                    <div class="col-12 col-md-6">
                        <label for="accountType" class="form-label small">
                            <i class="fas fa-user-tag me-1 text-primary d-none d-md-inline"></i> Account Type
                        </label>
                        <select name="status" name="" id="accountType" class="form-select border-2" required>
                            <option value="" selected>Select User Type</option>
                            @if($userData->status<1)
                            <option value="1">⭐ Super Admin</option>
                            <option value="2">🎯 Super Master</option>
                            <option value="3">🔧 Master</option>
                            <option value="4">👤 Agent</option>
                            @elseif($userData->status<2)
                            <option value="2">🎯 Super Master</option>
                            <option value="3">🔧 Master</option>
                            <option value="4">🤝 Agent</option>
                            <option value="5">👤 User</option>
                            @elseif($userData->status<3)
                            <option value="4">🤝 Agent</option>
                            <option value="5">👤 User</option>
                            @else
                            <option value="5">👤 User</option>
                            @endif
                        </select>
                    </div>
                    <!-- <div class="col-12 col-md-6">
                        <label for="clientName" class="form-label small">
                            <i class="fas fa-building me-1 text-primary d-none d-md-inline"></i> Client Name
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
                            <i class="fas fa-user me-1 text-success d-none d-md-inline"></i> User Uid
                        </label>
                        <input name="username" id="username" type="text" class="form-control border-2" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="referenceName" class="form-label small">
                            <i class="fas fa-user-friends me-1 text-success d-none d-md-inline"></i> Reference Code (Optional)
                        </label>
                        <input name="referral_code" id="referenceName" type="text" class="form-control border-2" value="{{substr(uniqid().rand(1000,1111),4)}}">
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

        <!-- Commission -->
        <!-- <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-info text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-percent me-2"></i> Commission: Cricket / Soccer / Tennis
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 mx-auto">
                        <label for="commission" class="form-label small">
                            <i class="fas fa-chart-line me-1 text-info d-none d-md-inline"></i> Commission M.O
                        </label>
                        <input name="commission_amount" id="commission" type="number" class="form-control border-2 text-center" min="0" max="100" value="1" placeholder="Enter commission percentage">
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Partnership Sharing -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-secondary text-white py-1">
                <h5 class="mb-0 fs-6">
                    <i class="fa-solid fa-users me-2"></i> Partnership Sharing
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 mx-auto">
                        <label for="sharing" class="form-label small">
                            <i class="fas fa-handshake me-1 text-secondary d-none d-md-inline"></i> Downline Sharing
                        </label>
                        <input name="partnership_percentage" id="sharing" type="number" class="form-control border-2 text-center" min="0" max="100" placeholder="Enter sharing percentage">
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
                    <div class="col-12 col-md-4">
                        <label for="creditRef" class="form-label small">
                            <i class="fas fa-credit-card me-1 text-dark d-none d-md-inline"></i> Credit Reference
                        </label>
                        <input name="creditRef" id="creditRef" type="text" class="form-control border-2">
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="deposit" class="form-label small">
                            <i class="fas fa-plus-circle me-1 text-success d-none d-md-inline"></i> Add Deposit (₹)
                        </label>
                        <input name="wallet_amount" id="deposit" type="number" class="form-control border-2 text-center">
                    </div>
                    <div class="col-12 col-md-4">
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

        <!-- Submit Button -->
        <div class="text-center text-md-start mb-5">
            <a type="submit" class="add_user_client btn btn-success px-4 px-md-5 py-2 py-md-1 shadow-lg w-100 w-md-auto">
                <i class="fa-solid fa-circle-plus me-2"></i>
                Create Account
            </a>
        </div>
    </form>
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