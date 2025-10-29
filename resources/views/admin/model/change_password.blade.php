<!-- Change Password Modal -->
<div class="modal fade change-password-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-header-dark py-2" >
        <h5 class="modal-title fs-6" id="changePasswordModalLabel">Change Password</h5>
        <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body-dark p-3">
        <form action="#" id="changePasswordFormModel" data-url="changePassword">
          @csrf
              <input name="username" type="hidden" id="username" class="form-control" value="">
          <div class="row">
            <!-- Old Password -->
            <div class="form-group col-md-6 mb-3">
              <label for="old_password">New Password</label>
              <input name="password" type="password" id="old_password" class="form-control">
            </div>

            <!-- New Password -->
            <div class="form-group col-md-6 mb-3">
              <label for="confirm_password">Confirm Password</label>
              <input name="confirm_password" type="password" id="confirm_password" class="form-control">
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="form-group mb-4">
            <label for="master_password">Master Password</label>
            <input name="master_password" type="password" id="master_password" class="form-control">
          </div>

          <!-- Buttons -->
          <div class="form-group text-end">
            <a href="javascript:0" class="btn btn-primary changePasswordSubmit">Confirm</a>
            <a href="javascript:0" class="btn btn-secondary" data-bs-dismiss="modal">No</a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
