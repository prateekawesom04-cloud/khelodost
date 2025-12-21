<script>
    
    function ajaxResponseModal(response){
        if(response.message){
            if(response.response_code == 200){
                responseToast(response.message,'bg-success');
                setTimeout(() => {
                        window.location.href = '{{url()->current()}}';
                }, 1000);
            } else{
                responseToast(response.message,'bg-warning');
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
          $('.userExposure').html(res.unsattled_amount);
        }
    }

    $('.bi-arrow-repeat').on('click',function(){
        refreshWallet();
    });


  $(document).ready(function(){
    $('.otp_verified').hide();
  });

  let otpVerified = false;

  let data = {
    phone:'',
    otp:'',
    otpTimer: null,
    otpTimeLeft: 60,
    newPassword:'',
    confirm_password:''
  }

  $('input').on('change',function(e){
    if(otpVerified && $(this).attr('name')=='phone'){
      e.preventDefault();
      return false;
    }
    data[$(this).attr('name')] = $(this).val();
  });
  
  $('.getOtp').on('click',function(){
    
    if(otpVerified){
      return;
    }

    if(data.phone.length < 10){
      alert('Please Enter Correct Number');
      return;
    }

    $(this).prop('disabled', true);

        data.otpTimeLeft = 60;
    callApi('get', '{{route('user.getOtp')}}', data, getOtp);
  });

  function startOtpCountdown(button) {

    $(button).prop('disabled', true).text(`Retry in ${data.otpTimeLeft}s`);

    data.otpTimer = setInterval(() => {
      data.otpTimeLeft--;

      if (data.otpTimeLeft > 0) {
        $(button).prop('disabled', true).text(`Retry in ${data.otpTimeLeft}s`);
      } else {
        data.otpTimeLeft = 60;
        if (!otpVerified) {
        localStorage.setItem('user_otp', 0);
        // if (!localStorage.getItem('user_otp') || localStorage.getItem('user_otp') != data.phone) {
          $(button).prop('disabled', false).text('Get OTP');
        }
        clearInterval(data.otpTimer);
      }
    }, 1000);

  }

  function getOtp(res){
    // console.log(res);
    
    if(res.response_code == 200){
      responseToast('Please Enter Otp','bg-warning');
      startOtpCountdown('.getOtp');
      
      localStorage.setItem('user_otp', data.phone);
    } else{
      $('.getOtp').prop('disabled', false);
      responseToast(res.message,'bg-danger');
    }
  }

  $('input[name=otp]').on('keyup',function(e) {
    if (!localStorage.getItem('user_otp') || localStorage.getItem('user_otp') != data.phone) {
      $(this).val('');
      responseToast('Otp not send yet...','bg-warning');
      return false;
    }
    
    if ($(this).val().length == 6) {
      // let data = {};
      data.otp = $(this).val();
      data.phone = data.phone;

      callApi('get', '{{route('user.verifyOtp')}}', data, verifyOtp);
    }
  });

  function verifyOtp(response) {
    if (response.response_code == 200) {
      otpVerified = true;

      $('input[name=password]').prop('disabled', false);
      $('input[name=confirm_password]').prop('disabled', false);

      $('a.getOtp').prop('disabled', true).text('OTP Verified');

      $('.otp_verified').show();
      $('.otp_not_verified').hide();

      if (data.otpTimer) {
        // clearInterval(data.otpTimer);
        data.otpTimer = null;
      }
    } else {
      responseToast('Invalid OTP','bg-danger');
    //   clearInterval(data.otpTimer);
    //   $('.getOtp').removeAttr('disabled').text('Get OTP');
    }
  }
  
  $('input[name="search"], input[type="search"]').on('keyup', function() {
    
      var searchText = $(this).val().toLowerCase(); 

      $('table tbody tr').filter(function() {
        
          $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
      });
  });
  
  $('.contact_admin').on('click',function(e){
    e.preventDefault();
      responseToast('Please contact to admin.','bg-warning');
  });
</script>