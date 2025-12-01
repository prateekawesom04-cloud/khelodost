@if(isset($banners))
@foreach($banners as $banner)

<!-- Edit News Modal -->
<div class="modal fade add-banner-modal" id="bannerUpdateImage{{$banner->id}}" tabindex="-1" aria-labelledby="addBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header modal-header-dark">
        <h5 class="modal-title" id="">Update Banner</h5>
        <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
      </div>

      <!-- Modal Body with Form -->
      <div class="modal-body-dark p-3">
        <form action="#" method="POST" enctype="multipart/form-data" id="addBannerForm">
          @csrf
            <input type="hidden" name="id" value="{{$banner->id}}">
          <!-- Image Upload Field -->
          <div class="form-group mb-4">
            <label for="image" class="form-label fw-bold">📤 Select Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
          </div>

          <!-- Buttons -->
          <div class="form-group text-end">
            <a href="javascript:void(0)" class="btn btn-dark bannerUpdateImage">Add</a>
            <a href="javascript:0" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

<script>
    
    $('.bannerUpdateImage').on('click',function(){
        $(this).addClass('disabled');
        formaData = new FormData($(this).parents('form')[0]);
        callApiFormData('post', `{{Route('admin.action.bannerUpdateImage')}}`, formaData, ajaxResponseModal);
    });
    
</script>
@endif