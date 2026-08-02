$(document).ready(function(){
 
   
  $.post("../controller/profile/profile_controller.php",{action:'select_company_details'},function(res){
	  
  
            var obj = jQuery.parseJSON(res);
			console.log(obj);
			
             edit_customer_details();
                
            			  function edit_customer_details()
                            {
								
								
								
                               $("#txt_company_id").val(obj.data[0].ids);      
								$("#txt_company_name").val(obj.data[0].thc_name);
								
								 $("#txt_vat_no").val(obj.data[0].vat_no);
                                $("#txt_po_box").val(obj.data[0].po_box);
                                $("#txt_tel_no").val(obj.data[0].tel_no);
                                $("#txt_fax_no").val(obj.data[0].fax_no);
                                $("#txt_address").val(obj.data[0].thc_address);
                                $("#txt_email").val(obj.data[0].thc_email);
                                $("#txt_website").val(obj.data[0].thc_website);
                                
                               
                            }
                            
                            
          });                
                        
      
       
              
	          
                $("#btn_company_add").click(function(){
                    
                   // v_btn_customer_edit.ladda( 'start' );
					var v_company_id=$("#txt_company_id").val();
					var v_company_name=$("#txt_company_name").val();
                    var v_company_vat_no=$("#txt_vat_no").val();
					var v_company_po_box=$("#txt_po_box").val();
                    var v_company_email=$("#txt_email").val();
                   
					
					var v_company_tel_no=$("#txt_tel_no").val();                   
                    var v_company_fax_no=$("#txt_fax_no").val();
                    var v_company_address=$("#txt_address").val();
					
                    var v_company_website=$("#txt_website").val();
                    
					
                    if($.trim(v_company_name)==""|| v_company_vat_no === ""||$.trim(v_company_po_box)==""||$.trim(v_company_email)==""||$.trim(v_company_tel_no)==""||$.trim(v_company_fax_no)==""||$.trim(v_company_address)==""||$.trim(v_company_website)=="")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                       //v_btn_customer_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/profile/profile_controller.php",{action:'update_company',v_company_id:v_company_id,v_company_name:v_company_name,v_company_vat_no:v_company_vat_no,v_company_po_box:v_company_po_box,v_company_email:v_company_email,v_company_tel_no:v_company_tel_no,v_company_fax_no:v_company_fax_no,v_company_address:v_company_address,v_company_website:v_company_website}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    //v_btn_customer_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     //v_btn_customer_edit.ladda( 'stop' );
                                     swal("Success", "Customer details updated successfully..", "success");
                                    /*  load_data_to_grid_customer_details_list();
									 $( '#btn_customer_add' ).show();
                                     $( '#btn_customer_edit' ).hide();
                                     $( '#btn_customer_new' ).hide();
									  */
                                     clear_text();
                                    
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                }); 
            
				function clear_text()
				{
					
					$("#txt_company_id").val('');
					$("#txt_company_name").val('');
                    $("#txt_vat_no").val('');
					$("#txt_po_box").val('');
                    $("#txt_email").val('');
                    $("#txt_tel_no").val('');                   
                    $("#txt_fax_no").val('');
                    $("#txt_address").val('');
					$("#txt_website").val('');
					
					
				}
});