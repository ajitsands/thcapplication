$(document).ready(function(){

   // var v_but_login = $( '#btn_sign_in' ).ladda();
     
    
     $( '#txt_old_password' ).change(function(){     
    
         var v_old_pswd = $('#txt_old_password').val();
         var v_old_pswd_hidden = $('#txt_hidden_old_pswd').val();
        //console.log(v_old_pswd_hidden);
            if(v_old_pswd!=v_old_pswd_hidden)
            {
                $('#txt_error_msg').html("Incorrect password");
                $('#txt_old_password').val("");
            }
            else
            {
                //console.log("success");
                $('#txt_error_msg').html("");
            }
    
     }); 
     $( '#btn_login' ).click(function(){
               
                
                var v_username = $('#txt_login_username').val();
				//alert(v_username);
				var v_password = $('#txt_login_password').val();
	
				$.post("../controller_pms/login/login_controller.php",{action:'login',v_username:v_username,v_password:v_password}, function(result,status){
					//alert(result);
              	var str = result.split('#');
				//alert(str[0]+str[1]);
                if($.trim(str[0])=='true')
                {
                   
					//v_but_login.ladda( 'stop' );
                    $(location).attr('href',str[1]);
					
                    
                }
                else
                {
					//alert("'Invalid Attempt..! Please Check your Username and Password...',");
                $('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
            $.jGrowl(result,{
                position: 'bottom-center',
                theme: 'bg-info',
                header: 'Error',
				hideAfter: 6000
            });
                   	
                }
               
             
           }); 
				
				
    });
    
	
	//reset password starts
	 $( '#btn_reset_password' ).click(function(){
		
		var v_old_pswd = $('#txt_old_password').val();
		var v_new_password = $('#txt_new_password').val(); 
		var v_new_confirm_password = $('#txt_confirm_password').val();
		var v_user_id = $('#txt_user_id').val();
		
		if($.trim(v_old_pswd)==''||$.trim(v_new_password)==''||$.trim(v_new_confirm_password)=='')
		{
		   	$('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
            $.jGrowl("Please fill all the fields!......",{
                position: 'top-center',
                theme: 'bg-info',
                header: 'Error',
				hideAfter: 6000
            }); 
            return false;
		}
		
		if(v_new_password!=v_new_confirm_password)
		{
			$('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
            $.jGrowl("Password and confirm password mismatch!......",{
                position: 'top-center',
                theme: 'bg-info',
                header: 'Error',
				hideAfter: 6000
            });
			$('#txt_new_password').val(''); 
			$('#txt_confirm_password').val('');
			//$('#txt_old_password').val('');
		}
	
			else{
				
				$.post("../controller_pms/login/login_controller.php",{action:'reset_password',v_password:v_new_password,v_user_id:v_user_id}, function(result,status){
					
					if(status=='success')
					{
					
						$('#txt_new_password').val(''); 
						$('#txt_confirm_password').val('');
						$('#txt_old_password').val('');
						$('#txt_hidden_old_pswd').val(v_new_password);
						 $('#modal_form_vertical').modal('hide');
							swal("Success","Password reset successfully....", "success");
					
						
					}
				});
			}
	
	});
	//reset password ends
    
});