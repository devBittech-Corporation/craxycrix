$(document).ready(function(){
  var chk;
	$("#agree").click(function(){
		if($("#agree").prop("checked")== true){
			chk=1;
		}else{
			chk=0;
		}
	});

  $("#btnregister").click(function(event){
   event.preventDefault();
    var comemail  = $('#comemail').val();
    var comname   = $('#comname').val();
    var comnum    = $('#comnum').val();
    var compasss  = $('#compasss').val();
    if(comemail == ""){
      swal({
        text: "Empty or Invalid Email Entered. Please Check",
        icon: "warning",
      });
    }else if (comname == "") {
      swal({
        text: "Please Enter a Valid Company Name",
        icon: "warning",
      });
    }else if (comnum == "") {
      swal({
        text: "Please Enter Numbers only",
        icon: "warning",
      });
    }else if (compasss == "") {
      swal({
        text: "Enter a correct password",
        icon: "warning",
      });
    }else{
      if(comemail != '' && comname != '' && comnum != '' && compasss != '' && chk == 1){
        event.preventDefault();
          $("#fmregister :input").prop("disabled",true);
			    $('.spinner-grow').show();
          $.ajax({
            url:'php/register_code.php',
            type:'post',
            data:{comemail:comemail,comname:comname,comnum:comnum,compasss:compasss,chk:chk},
            success:function(response){
             //$('#results').html(response);
              if(response	== 1){
                swal("Congratulations you successfully Created your Account. Hold you would receive a Verification Number", {
                      icon: "success",
                      button: true,
                    });
                    setInterval(function(){
                     window.location.href = "./confirmcode.html";
                   }, 5000);

              }else{
                toastr.error('Ooops Something Went wrong. Please Check your info, If not Send a support Ticket');
              }
            }
          });
      	setTimeout(function(){
          $("#fmregister :input").prop("disabled",false);
          $('.spinner-grow').hide();
        },3000);

      }else{
        event.preventDefault();
        swal({
          text: "You have to agree with terms and conditions before proceeding",
          icon: "warning",
        });
      //  toastr.error("You have to agree with terms and conditions before proceeding");
      }
      return true;
    }

  });

})
