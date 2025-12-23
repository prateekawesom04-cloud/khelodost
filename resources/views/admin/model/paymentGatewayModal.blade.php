<div class="modal fade" id="approve_transaction" tabindex="-1" aria-hidden="true">
    <div class="flex items-center justify-center modal-dialog w-full h-full">
        <div class="modal-content !w-[280px] mx-auto text-center">
            <div class="modal-header border-0">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="flex flex-col g-2 mb-3 items-center justify-center gap-3">
                    <div class="userBankData !text-[#333] text-left">

                    </div>
                    <div class="flex flex-row gap-2">
                        <a id="lgPayUpdateTransaction" href="javascript:void(0)" class="btn btn-primary bg-[#0552cc] lgPayUpdateTransaction">LgPay</a>
                        <a id="updateTransaction" href="javascript:void(0)" class="btn btn-primary bg-[#0552cc] updateTransaction">UnitedPay</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>