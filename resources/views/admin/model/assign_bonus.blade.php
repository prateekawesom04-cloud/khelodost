<!-- Compact Reusable Modal with Form -->
<div class="modal fade" id="assignBonusModal" tabindex="-1" aria-labelledby="assignBonusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-header-dark">
                <h5 class="modal-title" id="mainModalLabel">Assign Bonus</h5>
                <a type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></a>
            </div>
            <div class="modal-body modal-header-dark">
                <form id="assignBonusForm">
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

                    
                <div class="mb-3">
                    <label for="userId" class="form-label fw-semibold">Username:</label>
                    <input type="text" class="form-control" id="userId" name="username" placeholder="Enter Username" required>
                </div>

                    <!-- Amount -->
                    <input type="hidden" name="type" value="1">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="bonusType" class="form-label fw-semibold">Bonus Type:</label>
                        <select class="form-select" id="bonusType" name="bonus_uid" required>
                            <option value="" selected disabled>-- Select Bonus Type --</option>
                            @foreach($assignBonus as $b)
                                <option value="{{$b->bonus_uid}}">{{$b->name}}</option>
                            @endforeach
                            {{-- <option value="Red envelope">Red envelope</option> --}}
                        </select>
                    </div>

                    <!-- Status -->
                    {{-- <div class="form-check form-switch mb-3"> --}}
                        {{-- <input class="form-check-input" type="checkbox" id="status" name="status"> --}}
                        {{-- <label class="form-check-label" for="status">Status</label> --}}
                    {{-- </div> --}}
                </form>

                {{-- <a href="javascript:void(0)" type="button" class="assignBonus" class="btn btn-primary">Save</a> --}}
            </div>

            <div class="modal-footer">
                <a href="javascript:void(0)" type="button" class="assignBonus btn btn-primary">Save</a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.assignBonus').on('click',function(){
        $(this).addClass('disabled');
        let formData = new FormData($('#assignBonusForm')[0]);
        
        callAjaxFormData('post', `assignBonus`, formData, ajaxResponseModal);
    });
</script>
