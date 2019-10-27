
$(document).ready(function(){

   $('#btnregister').click(function(){

   var veri   = $('#veri').val();
   if(veri == ""){
        swal({
            text: "Enter Verification Code",
            icon: "warning",
        });
        }else{
              $("#fmregister :input").prop("disabled",true);
			        $('.spinner-grow').show();
        	    event.preventDefault();
        	    $.ajax({
                     method: "POST",
                     url: "php/verifycode.php",
                     data:{veri:veri},
                     success: function(data){
                          //$('#results').html(data);
                            if(data == 1){
                            $('.spinner-grow').hide();
                              swal({
              					            text: "Congratulations your account has been verified....  Please wait while we redirect you",
              					            icon: "success",
              					        });
					                    setInterval(function(){
                               window.location.href="login.html";
                             }, 5000);
                            return true;
                            }else{
                             $('.spinner-grow').hide();
                              swal({
                                  text: "Sorry Verification Code is Invalid",
                                  icon: "warning",
                              });
                              return false;
                            }
                     }
                });
                setTimeout(function(){
                  $("#fmregister :input").prop("disabled",false);
                  $('.spinner-grow').hide();
                },3000);
                toastr.error("Invalid Verification Code Entered");
                return true;
             }
             return false;
        })

/*var sec = 60;
var timer = document.getElementById('myTimer');
var verify = document.getElementById('resend');
window.onload = countDown;
function countDown(){
	if (sec < 10) {
		timer.innerHTML = "0" + sec;
	}else{
		timer.innerHTML = sec + '';
	}
	if (sec <= 0) {
    $("#resend").removeAttr("disabled");
    $("#resend").removeClass().addClass("btnEnable");
    $("#myTimer").fadeTo(2500, 0);
    return;
     }
  sec -= 1;
  window.setTimeout(countDown, 1000);
}*/

})
