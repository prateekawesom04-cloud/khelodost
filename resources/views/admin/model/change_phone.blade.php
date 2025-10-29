<!-- Change Password Modal -->
<div class="modal fade" id="changePhoneModal" tabindex="-1" aria-labelledby="changePhoneModalLabel">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-header-dark py-2" >
        <h5 class="modal-title fs-6" id="changePhoneModalLabel">Update Phone</h5>
        <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body-dark p-3">
        <form action="#" id="changePhoneForm">
          @csrf
          <input name="username" type="hidden" id="username" class="form-control" value="">
          <div class="row">
            <!-- Old Password -->
            <div class="form-group mb-3">
              <label for="phone">Phone</label>
              <input name="phone" type="text" id="phone" class="form-control">
            </div>

            <!-- Confirm Password -->
            <div class="form-group mb-4">
              <label for="master_password">Master Password</label>
              <input name="master_password" type="password" id="master_password" class="form-control">
            </div>

            <!-- Buttons -->
            <div class="form-group text-end">
              <a href="javascript:0" class="btn btn-primary changePhoneSubmit">Confirm</a>
              <a href="javascript:0" class="btn btn-secondary" data-bs-dismiss="modal">No</a>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
