<!-- Compact Reusable Modal with Form -->
<div class="modal fade" id="editBonusModal" tabindex="-1" aria-labelledby="editBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="mainModalLabel">Edit Bonus</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body modal-header-dark">
                <form id="editBonusForm">
                    {{-- <div class="mb-3">
                        <label for="name" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control">
                    </div> --}}
                    <!-- Bonus Type Dropdown -->
                    {{-- <div class="mb-3">
                        <label for="bonusType" class="form-label">Bonus Type</label>
                        <select id="bonusType" name="type" class="form-select">
                            <option value="1">Referral</option>
                            <option value="2">Register</option>
                        </select>
                    </div> --}}

                    <!-- Amount -->
                    <input type="hidden" name="type" value="1">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control">
                    </div>

                    <!-- Wager Amount -->
                    <div class="mb-3">
                        <label for="wagerAmount" class="form-label">Wager Amount</label>
                        <input type="text" id="wagerAmount" name="wager_amount" class="form-control">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" id="description" name="description" class="form-control">
                    </div>

                    <!-- Status -->
                    {{-- <div class="form-check form-switch mb-3"> --}}
                        {{-- <input class="form-check-input" type="checkbox" id="status" name="status"> --}}
                        {{-- <label class="form-check-label" for="status">Status</label> --}}
                    {{-- </div> --}}
                </form>

                {{-- <a href="javascript:void(0)" type="button" class="createBonus" class="btn btn-primary">Save</a> --}}
            </div>

            <div class="modal-footer">
                <a href="javascript:void(0)" type="button" class="createBonus btn btn-primary">Save</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.createBonus').on('click',function(){
        $(this).addClass('disabled');
        let formData = new FormData($('#editBonusForm')[0]);
        
        callAjaxFormData('post', `createBonus`, formData, ajaxResponseModal);
    });
</script>
