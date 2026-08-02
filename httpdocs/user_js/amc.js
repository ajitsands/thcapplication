 $(document).ready(function(){

//$(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });

 var attachments =[],checked_val = 'Yes',v_customer_code,v_first_attachment,randomNum,v_second_attachment,randomNumSec,v_third_attachment,randomNumThird,amc_num;
                  
                    $('#btn_amc_new').hide();
                    $('#btn_amc_edit').hide();
                     
                    var v_btn_amc_add = $('#btn_amc_add').ladda();
                    var v_btn_amc_edit = $('#btn_amc_edit').ladda();
                    var v_btn_amc_new = $('#btn_amc_new').ladda();
                    var v_btn_customer_add = $('#btn_customer_add').ladda();
                    var v_btn_contract_add = $('#btn_contract_type_add').ladda(); 
                    
                    function getYearlyAmount(currentAmonut, dateRange){
                        var splitWoleDate = dateRange.split("-");
                        var startDate =  new Date(splitWoleDate[0]);
                        var endDate =  new Date(splitWoleDate[1]); 
                        var monthsDifference = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());
                        if (endDate.getDate() < startDate.getDate()) {
                            monthsDifference--;
                        }
                        var TotalAmc = parseFloat(currentAmonut/12)*monthsDifference;
                        TotalAmc = TotalAmc.toFixed(3);
                        $('#txt_total_amc_amount').val(TotalAmc);
                    }
                    
                    $('.applyBtn').click(function(){
                        $("#txt_amc_amount, #txt_total_amc_amount").val('');   
                    });
                    
                    $('#txt_amc_amount').keyup(function(){
                        var currAmnt = $("#txt_amc_amount").val();
                        var dateRange = $("#txt_amc_start_end_date").val();
                        getYearlyAmount(currAmnt, dateRange);
                    });
                    
                    $('#txt_amc_amount').change(function (e) {
                         //getYearlyAmount();
                         CalculateVatAmount();  
                    });
                        
                    $('#txt_vat_percentage').change(function (e) {
                         CalculateVatAmount();
                          
                        });
                    function CalculateVatAmount()
                        {
                            var v_amc_amount = $("#txt_total_amc_amount").val();
                            var v_amc_vat_percentage = $("#txt_vat_percentage").val();
                            var vat_per=parseFloat(v_amc_vat_percentage)/100;
                            var v_vat_amount= v_amc_amount * vat_per;
                            
                            if(isNaN(v_vat_amount))
                                {
                                     $("#txt_amc_vat_amount").val(0);
                                }
                            else
                                {
                                     $("#txt_amc_vat_amount").val(v_vat_amount);
                                }
                       
                        }
              
                  
							
							$('#custom_checkbox_inline_right_checked').click(function () {
								

								if ($(this).prop("checked") === true) {
									checked_val = "Yes";
								} else {
									checked_val = 'No';
								}
							});
                        
                    $('#first_attachment').change(function (e) {
                         attachment_upload('#first_attachment',v_first_attachment);
                            
                    });
                    $('#second_attachment').change(function (e) {
                         
                             attachment_upload('#second_attachment',v_second_attachment);
                    });
                    $('#third_attachment').change(function (e) {
                         
                             attachment_upload('#third_attachment',v_third_attachment);
                    });
                      

                    // function attachment_upload(txt_param,v_attachment)
                    //  {
                    //         v_attachment = $(txt_param).val();
                    //         randomNum = Math.ceil(Math.random() * 999999);
                           
                    //         if(v_attachment=="")
                    //         {
                    //             //alert("inside if");
                    //             v_attachment="default.jpg";
                    //         } 
                    //         else
                    //         {
                    //             var doc_file_obj = $(txt_param)[0].files[0];
                    //             var upload = new ns.Upload(doc_file_obj);
                    //             doc_file1= doc_file_obj.name;
                    //              v_attachment=$.trim(randomNum+'_'+doc_file1);
                    //              attachments.push(v_attachment);
                    //             var success = upload.doUpload("../httpdocs/user_upload/amc_attachements.php?random_no="+randomNum,v_attachment);
                    //         }  
                           
                    //  }
                      function attachment_upload(txt_param, v_attachment)
                        {
                            v_attachment = $(txt_param).val();
                            var randomNum = Math.ceil(Math.random() * 999999);
                        
                            if (v_attachment == "")
                            {
                                v_attachment = "default.jpg";
                            }
                            else
                            {
                                var doc_file_obj = $(txt_param)[0].files[0];
                        
                                if (doc_file_obj)
                                {
                                    var upload = new ns.Upload(doc_file_obj);
                        
                                    var doc_file1 = doc_file_obj.name;
                        
                                    // Replace spaces and special characters
                                    doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                        
                                    // Final filename (same as DB value)
                                    v_attachment = randomNum + "_" + doc_file1;
                        
                                    attachments.push(v_attachment);
                        
                                    var success = upload.doUpload(
                                        "../httpdocs/user_upload/amc_attachements.php?random_no=" + randomNum,
                                        v_attachment
                                    );
                                }
                            }
                        
                            return v_attachment;
                        }
                
                         //AMC  insert details
                    v_btn_amc_add.click(function(){
                        
                                v_btn_amc_add.ladda( 'start' );
                                v_first_attachment=attachments[0];
                                v_second_attachment=attachments[1];
                                v_third_attachment=attachments[2];
                                var v_amc_cust_id=$("#select_customer_for_amc option:selected").val();
                                var v_amc_cust_name_code=$("#select_customer_for_amc option:selected").text();
                                var res = v_amc_cust_name_code.split("-");
                                var v_amc_cust_code=res[0];
                                var v_amc_cust_name=res[1];
                                var v_amc_contract_type_id=$("#select_contract_type_for_amc option:selected").val();
                                var v_amc_contract_type_name=$("#select_contract_type_for_amc option:selected").text();
                                var v_amc_signed_date=$("#txt_amc_signed_date").val();
                                v_amc_signed_date = v_amc_signed_date.split("/").reverse();
                                var tmp = v_amc_signed_date[2];
                                v_amc_signed_date[2] = v_amc_signed_date[1];
                                v_amc_signed_date[0] = v_amc_signed_date[0];
                                v_amc_signed_date[1] = tmp;
                                v_amc_signed_date = v_amc_signed_date.join("-");
                                var v_amc_start_end_date=$("#txt_amc_start_end_date").val();
                                var res_start_end = v_amc_start_end_date.split("-");
                                var v_amc_start_date=$.trim(res_start_end[0]);
                                var v_amc_end_date=$.trim(res_start_end[1]);
                                v_amc_start_date = v_amc_start_date.split("/").reverse();
                                var tmpstart = v_amc_start_date[2];
                                v_amc_start_date[2] = v_amc_start_date[1];
                                v_amc_start_date[0] = v_amc_start_date[0];
                                v_amc_start_date[1] = tmpstart;
                                v_amc_start_date = v_amc_start_date.join("-");
                                v_amc_end_date = v_amc_end_date.split("/").reverse();
                                var tmpend = v_amc_end_date[2];
                                v_amc_end_date[2] = v_amc_end_date[1];
                                v_amc_end_date[0] = v_amc_end_date[0];
                                v_amc_end_date[1] = tmpend;
                                v_amc_end_date = v_amc_end_date.join("-");
                                var v_amc_amount = $("#txt_amc_amount").val();
                                var v_amc_vat_percentage = $("#txt_vat_percentage").val();
                                var v_amc_vat_per_amount=$("#txt_amc_vat_amount").val();
                                var v_amc_is_rfp=checked_val;
								
                                var v_amc_description=$("#txt_amc_description").val();
                                var v_amc_first_desc=$("#txt_first_attachment_desc").val();
                                var v_amc_second_desc=$("#txt_sec_attachment_desc").val();
                                var v_amc_third_desc=$("#txt_third_attachment_desc").val();
                                var v_total_amc_amnt = $('#txt_total_amc_amount').val();
                                var v_total_payable_amt=(parseFloat(v_total_amc_amnt)+parseFloat(v_amc_vat_per_amount));
                                

                                if(v_first_attachment===""||typeof v_first_attachment === "undefined")
                                    {
                                        //alert("inside if");
                                        v_first_attachment="default.jpg";
                                    }
                                    
                                if(v_second_attachment===""||typeof v_second_attachment === "undefined")
                                    {
                                           
                                        v_second_attachment="default.jpg";
                                    }
                                        
                                if(v_third_attachment===""||typeof v_third_attachment === "undefined")
                                    {
                                               
                                        v_third_attachment="default.jpg";
                                    }

                                if($.trim(v_amc_start_end_date)===""||$.trim(v_amc_vat_per_amount)===""||$.trim(v_amc_amount)===""||$.trim(v_amc_vat_percentage)===""||$.trim(v_amc_amount)===""||$.trim(v_amc_start_end_date)===""||typeof v_amc_cust_id === "undefined"|| typeof v_amc_contract_type_id === "undefined"|| $.trim(v_amc_signed_date)==="")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_amc_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/amc/amc_controller.php",{action:'add_amc',v_amc_cust_id:v_amc_cust_id,v_amc_cust_code:v_amc_cust_code,v_amc_cust_name:v_amc_cust_name,v_amc_contract_type_id:v_amc_contract_type_id,v_amc_contract_type_name:v_amc_contract_type_name,v_amc_signed_date:v_amc_signed_date,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date,v_amc_amount:v_amc_amount,v_amc_vat_percentage:v_amc_vat_percentage,v_amc_vat_per_amount:v_amc_vat_per_amount,v_amc_is_rfp:v_amc_is_rfp,v_amc_description:v_amc_description,v_first_attachment:v_first_attachment,v_second_attachment:v_second_attachment,v_third_attachment:v_third_attachment,v_amc_first_desc:v_amc_first_desc,v_amc_second_desc:v_amc_second_desc,v_amc_third_desc:v_amc_third_desc,v_total_payable_amt:v_total_payable_amt,v_total_amc_amnt:v_total_amc_amnt}
                                            , function(result,status)
                                            {
                                                
                                                $("#txt_amc_number").val(result); 
                                                result = $.trim(result);
                                                if(result.charAt(0)=='U')
                                                    {
                                                        v_btn_amc_add.ladda( 'stop' );
                                                        swal("Error", result, "error");
                                                      // clear_text();
                                                    }
                                                else 
                                                    {  
														JSONPost(document.getElementById('amc_form'),'AMC','Add AMC',v_amc_cust_code,v_amc_cust_name,v_amc_contract_type_name,result,v_first_attachment,v_second_attachment,v_third_attachment,v_amc_is_rfp,v_total_payable_amt);
                                                         v_btn_amc_add.ladda( 'stop' );
                                                         swal("Success", "AMC details added successfully..", "success");
                                                         //location.reload();
                                                    }
                                    });
  
                                }
                        });//close of AMC add button
                    
                     $("#bootbox_customer").click(function(){
                          
                         // $("#add_new_customer_amc").show();
                            $('#add_new_customer_amc').modal('show');
                      });
                        
						//Add customer Details
				v_btn_customer_add.click(function(){
                    v_btn_customer_add.ladda( 'start' );
					
                    var v_customer_name=$("#txt_customer_name").val();				
                    var v_customer_contact_no=$("#txt_customer_contact_no").val();
                    var v_customer_email_id=$("#txt_customer_email_id").val();
                    var v_customer_po_box=$("#txt_customer_po_box").val();
					var v_customer_location=$("#txt_customer_location").val();                   
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
                    var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
                    var v_vat_number=$("#txt_vat_number").val();					
                    var v_customer_address=$("#txt_customer_address").val();
					var v_description=$("#txt_description").val();
					
                    if($.trim(v_customer_name)==""|| v_customer_contact_no === ""||$.trim(v_customer_po_box)==""||$.trim(v_customer_location)==""||$.trim(v_cpr_cr_number)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_customer_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/amc/amc_controller.php",{action:'add_customer',v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_customer_po_box:v_customer_po_box,v_customer_location:v_customer_location,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description}
                                , function(result,status)
                                  {                     
										result = $.trim(result);
									   
										if(result>=1 && result<=9)
										{
											 v_customer_code= 'C000'+result;
										}
										if(result>=10 && result<=99)
										{
											v_customer_code= 'C00'+result;
										}
										if(result>=100 && result<=999)
										{ 
											v_customer_code= 'C0'+result;
										}
										if(result>=1000 )
										{
											v_customer_code= 'C'+result;
										}
								
								 $.post("../controller/amc/amc_controller.php",{action:'update_customer_code',v_customer_code:v_customer_code,v_customer_id:result}					
								 , function(result,status)
									{ 
								
								
										if(result.charAt(0)=='U')
										{
											v_btn_customer_add.ladda( 'stop' );
											swal("Error", result, "error");
										   
											clear_text_customer();
										   

										
										}
										else 
										{
											 v_btn_customer_add.ladda( 'stop' );
											 swal("Success", "New customer added successfully..", "success");
											 
											 clear_text_customer();
											 location.reload();
										}
							
                                 });
                        
                                 });
                        
                     }
					 
				 
                  
                });

				//End customer details
				
				$("#contract_type_add_modal").click(function(){
                          
                         // $("#add_new_customer_amc").show();
                            $('#add_new_contract_type_amc').modal('show');
                });
                
                
                 v_btn_contract_add.click(function(){
                    
                    v_btn_contract_add.ladda( 'start' );
                    var v_contract_name=$("#txt_contract_name").val();
					
                  
                    if($.trim(v_contract_name)=="")
                    
                    {
                        swal("Warning","Please provide contract type ....", "warning");
                        v_btn_contract_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/contract/contract_controller.php",{action:'add_contract',v_contract_type_name:v_contract_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_contract_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_contract_add.ladda( 'stop' );
                                     swal("Success", "New contract added successfully..", "success");
                                     
                                    
                                    $("#txt_contract_name").val('');
                                    location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
				
				//function clear text		
				function clear_text_customer() 
                 {

					$("#txt_customer_name").val('');
                    $("#txt_customer_cpwd").val('');
                    $("#txt_customer_contact_no").val('');
                    $("#txt_customer_email_id").val('');
                    $("#txt_customer_po_box").val('');
					$("#txt_customer_location").val('');
                    $("#txt_contact_person").val('');
                    $("#txt_contact_person_number").val('');
			        $("#txt_cpr_cr_number").val('');
                    $("#txt_vat_number").val('');			
                    $("#txt_customer_address").val('');
				    $("#txt_description").val('');
    
                 }
		 // v_btn_amc_add.click(function(){
			// event.preventDefault();
			//var v_username = $('#txt_login_username').val(); 
			// JSONPost(document.getElementById('amc_form'),'Login','Save','User');
		 // });			 
	function JSONPost(formName,moduleName,event,v_amc_cust_code,v_amc_cust_name,v_amc_contract_type_name,amcNumber,v_first_attachment,v_second_attachment,v_third_attachment,v_amc_is_rfp,v_total_payable_amt)
	{
		var formData = new FormData(formName);
			formData.append('module', moduleName);
			formData.append('event', event);
			formData.append('amc_ref_no', amcNumber);
			formData.append('first_attachment', v_first_attachment);
			formData.append('second_attachment', v_second_attachment);
			formData.append('third_attachment', v_third_attachment);
			formData.append('RFP', v_amc_is_rfp);
			formData.append('total_amount', v_total_payable_amt);
			formData.append('customer_code', v_amc_cust_code);
			formData.append('customer_name', v_amc_cust_name);
			formData.append('contract_type', v_amc_contract_type_name);
			formData.append('action', 'amc_log');
 	
		
		$.ajax({
            type: 'POST',
            url: '../controller/amc/amc_controller.php',
            data: formData,
			contentType: false, // Ensure that the content type is set to false for FormData
            processData: false, // Prevent jQuery from processing the data
            success: function (response) {
                console.log(response); // Display a success message or handle as needed
				location.reload();
            },
            error: function (error) {
                console.log(error);
                console.log('Error inserting data'); // Display an error message
            }
        });
	}
		
});