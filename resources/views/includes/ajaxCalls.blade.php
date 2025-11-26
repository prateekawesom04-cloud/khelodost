<script>

    function callAjax(type = null, url = null, data = null, action = null, beforeAction = null, catchError = null) {
        // if(type.tpLowerCase() != 'get'){
        $.ajax({
            type: type,
            url: `{{ url('/') }}/${url}`,
            data: data,
            beforeSend: () => {
                if (beforeAction) beforeAction();
            },
            success: (response) => {
                if(response.response_code == '409'){
                    alert(response.error);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                    return false;
                }
                if (action) {
                    action(response);
                } else {
                    return response;
                }
            },
            error: (error) => {
                if (catchError) catchError();
            }
        });
        // }
    }
    
    function callApi(type = null, url = null, data = null, action = null, beforeAction = null, catchError = null) {
        // if(type.tpLowerCase() != 'get'){
        $.ajax({
            type: type,
            url: `${url}`,
            data: data,
            beforeSend: () => {
                if (beforeAction) beforeAction();
            },
            success: (response) => {
                if(response.response_code == '409'){
                    alert(response.error);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                    return false;
                }
                if (action) {
                    action(response);
                } else {
                    return response;
                }
            },
            error: (error) => {
                if (catchError) catchError();
            }
        });
        // }
    }
  
    function callAjaxFormData(type = null, url = null, data = null, action = null, beforeAction = null, catchError = null) {
        // if(type.tpLowerCase() != 'get'){
        $.ajax({
            type: type,
            url: url,
            processData: false,
            contentType: false,
            enctype: "multipart/form-data",
            data: data,
            beforeSend: () => {
                if (beforeAction) beforeAction();
            },
            success: (response) => {
                if(response.response_code == '409'){
                    alert(response.error);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                    return false;
                }
                if (action) {
                    action(response);
                } else {
                    return response;
                }
            },
            error: (error) => {
                if (catchError) catchError();
            }
        });
        // }
    }

    function callApiFormData(type = null, url = null, data = null, action = null, beforeAction = null, catchError = null, backendToken=localStorage.getItem('backendToken')) {
        // if(type.tpLowerCase() != 'get'){
        $.ajax({
            type: type,
            url: url,
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'Authorization': 'Bearer ' + backendToken
            },
            beforeSend: () => {
                if (beforeAction) beforeAction();
            },
            success: (response) => {
                if(response.response_code == '409'){
                    alert(response.error);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                    return false;
                }
                if (action) {
                    action(response);
                } else {
                    return response;
                }
            },
            error: (error) => {
                if (catchError) catchError();
            }
        });
        // }
    }


    
    function submitForm(formParntClassname){
        let form = $('.submitForm').parents(`.${formParntClassname}`).find('form');
        let formData = new FormData(form[0]);
        // console.log('formData------',formData);
        
        let url = $(form).attr('data-url');
        
        formData.append('previous_url', '{{url()->previous()}}');

        callApiFormData('post', `{{url('/admin')}}/${url}`, formData, ajaxResponseModal);
    }
    
    function submitFormGlobal(btn,user_uid){
        let form = $(btn).parents('.formParntClassname').find('form');

        let formData = new FormData(form[0]);
        formData.append('m_key', $(form).attr('data-m_key'));
        formData.append('user_uid', user_uid);
        formData.append('admin_uid', user_uid);
        formData.append('previous_url', '{{url()->current()}}');

        callApiFormData('post', `{{url('/admin')}}/createModelData`, formData, ajaxResponseModal);
    }

</script>