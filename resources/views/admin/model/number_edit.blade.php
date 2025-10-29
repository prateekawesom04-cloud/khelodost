<!-- Edit Mobile Number Modal -->
<div class="modal fade" id="editMobileModal" tabindex="-1" aria-labelledby="editMobileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-header-dark py-2">
        <h5 class="modal-title fs-6" id="editMobileModalLabel">Edit Mobile Number</h5>
        <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body-dark p-3">
        <form action="#" method="POST" id="editMobileForm">
          @csrf
          <input type="hidden" name="username" value="{{$userData->username}}">

          <!-- Mobile Number Input -->
          <div class="mb-3">
            <label for="mobileNumber" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobileNumber" name="phone" maxlength="10" value="{{$userData->phone}}">
          </div>
          <div class="mb-3">
            <label for="mobileNumber" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="masterPassword" value="">
          </div>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-end">
            <a href="javascript:0" type="submit" class="btn btn-primary me-2 updatePhone">Update</a>
            <a href="javascript:0" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
