<script>

    $('.add_user_client').on('click',function(){
        let exitLoop = true;
        let formData = new FormData($('#createAccountForm')[0]);
        let formInputs = $('#createAccountForm input');

        let form =  document.getElementById('createAccountForm');

        for(var i=0; i < form.elements.length; i++){
            var e = form.elements[i];
            if($(e).val() == ''){
                exitLoop = false;
                scrollToElement($(e));
                return false;
            }
        }

        // $(formInputs).each(function(){
        //     console.log($(this).attr('name'),"-----$(this).val()---",$(this).val());
            
        //     if($(this).val() == ''){
        //         // ajaxResponseModal('please provide all fields');
        //         exitLoop = false;
        //         scrollToElement($(this));
        //         return false;
        //     }
            
        // });

        if(exitLoop){
            callAjaxFormData('post', `{{url('/admin')}}/add_user_client`, formData, ajaxResponseModal);
        }
        
    });

    $('.changePhoneModal').on('click',function(){
        $('#changePhoneForm input[name=username]').val($(this).attr('data-username'));
    });

    $('.changePhoneSubmit').on('click',function(){
        let exitLoop = true;
        let formData = new FormData($('#changePhoneForm')[0]);
        let formInputs = $('#changePhoneForm input');
        
        $(formInputs).each(function(){
            if($(this).val() == ''){
                ajaxResponseModal(`Please Enter ${$(this).attr('name')}`);
                exitLoop = false;
                scrollToElement($(this));
                return false;
            }
            
        });
        if(exitLoop){
            callAjaxFormData('post', `{{url('/admin')}}/updateUserPhone`, formData, ajaxResponseModal);
        }
    });

    $('.changePasswordModel').on('click',function(){
        $('#changePasswordFormModel input[name=username]').val($(this).attr('data-username'));
    });

    $('.changePasswordSubmit').on('click',function(){
        let exitLoop = true;
        let formData = new FormData($('#changePasswordFormModel')[0]);
        let formInputs = $('#changePasswordFormModel input');
        
        $(formInputs).each(function(){
            if($(this).val() == ''){
                ajaxResponseModal(`Please Enter ${$(this).attr('name')}`);
                exitLoop = false;
                scrollToElement($(this));
                return false;
            }
            
        });
        if(exitLoop){
            callAjaxFormData('post', `{{url('/admin')}}/updateUserPassword`, formData, ajaxResponseModal);
        }
    });
    
    $('.depositWallet').on('click',function(){
        $('.balance_form input[name=username]').val($(this).attr('data-username'));
        $('.userBalance').text($(this).attr('data-user_wallet'))
    });
    $('.withdrawWallet').on('click',function(){
        $('.balance_form input[name=username]').val($(this).attr('data-username'));
    });

    $('.updateWalletSubmit').on('click',function(){
        let exitLoop = true;
        let formData = new FormData($(this).parents('form')[0]);
        let formInputs = $(this).parents('form').find('input');
        
        $(formInputs).each(function(){
            console.log("$(this).val()====",$(this).val());
            
            if($(this).val() == ''){
                ajaxResponseModal(`Please Enter ${$(this).attr('name')}`);
                exitLoop = false;
                scrollToElement($(this));
                return false;
            }
            
        });
        if(exitLoop){
            callAjaxFormData('post', `{{url('/admin')}}/updateWallet`, formData, ajaxResponseModal);
        }
    });


    function formValidation(formData){

    }

    // function ajaxResponse(response){
    //     if(response.response_code == 200){
    //         window.location.href = '{{url()->previous()}}';
    //     }
    //     responseToast(response.message,'bg-warning');
    // }
    
    function ajaxResponse1(response){
        if(response.response_code == 200){
            window.location.href = '{{url()->current()}}';
        }
        responseToast(response.message,'bg-warning');
    }

    
    function ajaxResponseModal(response){
        if(response.message){
            if(response.response_code == 200){
                responseToast(response.message,'bg-success');
                setTimeout(() => {
                        window.location.href = '{{url()->current()}}';
                }, 1000);
            } else{
                responseToast(response.message,'bg-danger');
            }
        } else{
            responseToast(response,'bg-warning');
        }
    }

    function scrollToElement(element){
        $(element).parent().append('<div class="input_error text-red-600"></div>');
        $(element).get(0).scrollIntoView({behavior: 'smooth'});
        $(element).focus();
        $(element).siblings('.input_error').html(`Please Enter ${$(element).attr('name')}`);
    }

    // form validations
    $('input').on('keyup',function(){
        $(this).siblings('.input_error').remove();
    });

    $('select').on('change',function(){
        $(this).siblings('.input_error').remove();
    });


    // update transaction
    $('.reject_deposit').on('click',function(){
        formData = {};
        callApi('post', `{{Route('admin.action.updateTransaction')}}`, {order_sn:$(this).attr('data-order_sn'),updateKey:'status',status:0}, ajaxResponseModal);
    });
    
    $('.approve_deposit').on('click',function(){
        formData = {};
        callApi('post', `{{Route('admin.action.updateTransaction')}}`, {order_sn:$(this).attr('data-order_sn'),updateKey:'status',status:2}, ajaxResponseModal);
    });


    // Transaction Data

    function transactionList(response) {
        
        let table = `
            <table class="table table-bordered table-striped table-dark mb-0">
                <thead class="table-primary">
                    <tr>
                        <th class="text-nowrap">Date/Time</th>
                        <th class="text-nowrap">Transaction Id</th>
                        <th class="text-nowrap">Type</th>
                        <th class="text-nowrap">Balance</th>
                        <th class="text-nowrap">Status</th>
                    </tr>
                </thead>
                <tbody class="transaction_statement">
                    <tr>
                        <td colspan="6" class="text-center py-4">No data!</td>
                    </tr>
                </tbody>
            </table>
        `;
        $('.table_div').html(table);

        if(response.response_code != 200) return false;
        let data = response.data;
        html = '';
        $(data).each(function(item){
            html += `<tr>
                        <td class="text-center py-4">${this.updated_at}</td>
                        <td class="text-center py-4">${this.order_sn}</td>
                        <td class="text-center py-4">${(this.payment_type==0)?'Deposit':'Withdraw'}</td>
                        <td class="text-center py-4">${this.transfer_amount}</td>
                        <td class="text-center py-4">${(this.status==2)?'Success':'Processing'}</td>
                    </tr>`;
        });

        $('.transaction_statement').html(html);
    }

    
</script>