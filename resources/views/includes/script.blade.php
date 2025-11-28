<script>
    
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

    // toast js start
        
        function responseToast(msg,background='bg-light'){
            $('.app_toast .toast-body').html(msg);
            $('.app_toast').css('right','1%');
            $('.app_toast').addClass(background);
            $('.app_toast').fadeIn('slow',function(){
                setTimeout(() => {
                    $('.app_toast').fadeOut('slow');
                    $('.app_toast').css('right','-100%');
                    $('.app_toast').removeClass(background);
                }, 2000);
            });
        }
        
    // toast js end

    
    function ajaxResponse(response){
        
        if(response.redirect){
            window.location.href = response.redirect;
        }
        if(response.code==200){
            responseToast(response.message,'bg-success');
        } else{
            responseToast(response.message,'bg-warning');
        }
    }

    $(document).ready(function(){
        
        let scrollCounter = 0;

        setInterval(() => {
            
            if(scrollCounter<3){
                scrollCounter+=1;
            } else{
                scrollCounter=0;
            }
            $('.app_scroller').animate({
                scrollLeft: scrollCounter*$('.app_scroller').innerWidth()
                // scrollLeft: $('.app_scroller').scrollLeft()+window.innerWidth
            },700);
            
            // $('.app_scroller').scrollLeft($('.app_scroller').scrollLeft()+window.innerWidth)
        }, 3000);

        $(function () {
            $('.datetimepicker').datetimepicker({
                // format: 'MM/DD/YYYY HH:mm' // Example format: Month/Day/Year Hour:Minute
            });
        });
    });

    function refreshWallet(){
        $('.bi-arrow-repeat').toggleClass('rotated');
      callApi('get','{{route('user.userBalance')}}',{},userBalance);
    }

    function userBalance(res){
        if(res.response_code == 200){
            $('.userBalance').html(res.wallet_amount);
        }
    }

    $('.bi-arrow-repeat').on('click',function(){
        refreshWallet();
    });


</script>