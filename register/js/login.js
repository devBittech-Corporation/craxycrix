$(document).ready(function(){

	$("#login").click(function(event){
    var email = $('#email').val();
    var password = $('#password').val();
		if(email != '' && password != ''){
      event.preventDefault();

	//		$(".loader").css("display","");
				$.ajax({
					url:'php/login_code.php',
					type:'post',
					data:{email:email,password:password},
					success:function(response){
           //$('#results').html(response);
						if(response	== 1){
							window.location.href = "../pickadmin/index.php";
						}else if (response == '2') {
							window.location.href = "../pickcompany/index.php";
						}else{
							toastr.error('Invalid Username or Password');
						}
					}
				});
		/*	setTimeout(function(){
				$("#fmregister :input").prop("disabled",false);
				$(".loader").css("display","none");
			},2000);
*/
		}else{
			event.preventDefault();
			toastr.error("Username and Password field should not be empty");
		}
	});
})
