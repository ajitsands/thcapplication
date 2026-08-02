$(document).ready(function(){
    

    
     $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
    
  var v_user_type_id,v_user_type_name,v_emp_code,v_employee_id,v_session_image,randomNum,v_employee_status,v_expertise_id=[],v_expertise_name=[];
                    
                    $('#btn_customer_edit').hide();
                    $('#btn_customer_new').hide();
                    $('#error_email').hide();
                    //$("#div_expertise_select").hide();
                     
                    var v_btn_customer_add = $('#btn_customer_add').ladda();
                    var v_btn_customer_edit = $('#btn_customer_edit').ladda();
                    var v_btn_customer_new = $('#btn_customer_new').ladda();
                 
                    var v_list_of_customer_table = $('#list_of_customer').DataTable({});
                      load_data_to_grid_customer_details_list();
					  
                   //check email
                    /*  $("#txt_customer_email_id").change(function(){
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_customer_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                            return true;
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid Email", "warning");
                                return false;
                            }
                                                 
                    });*/
  
			
//to check whether the contact person number is unique
			
				$("#txt_contact_person").blur(function(){
					var v_customer_contact_no=$("#txt_contact_person").val();
					 $.post("../controller/customer/customer_controller.php",{action:'check_contact_person_number',v_customer_contact_no:v_customer_contact_no}
							, function(result,status)
					 { 
						var obj = jQuery.parseJSON(result);
						 if(obj.length==0)
						{
							return true;
						}
						else
						{
							
							swal("Warning","Customer Contact Number is already exisited", "warning");
							$("#txt_contact_person_number").val('');
							return false;
						}

					 });
					
				});
			// end of check
			
			//to check whether the cpr/cr number is unique
 			/*	$("#txt_cpr_cr_number").blur(function(){
					var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
					 $.post("../controller/customer/customer_controller.php",{action:'check_cpr_cr_number',v_cpr_cr_number:v_cpr_cr_number}
							, function(result,status)
					 { 
						var obj = jQuery.parseJSON(result);
						if(obj.length==0)
						{
							return true;
						}
						else
						{
							
							swal("Warning","CPR/CR Number is already exisited", "warning");
							$("#txt_cpr_cr_number").val('');
							return false;
						}

					 });
					 
				});*/
			// end of check
			 
			 
			 $('#txt_customer_name').blur(function() {
			  
			  var v_customer_name=$("#txt_customer_name").val();   
              $("#txt_contact_person").val(v_customer_name);
              
            });
            
            $('#txt_customer_contact_no').blur(function() {
			  
			  var v_customer_contact_no=$("#txt_customer_contact_no").val();
              $("#txt_contact_person_number").val(v_customer_contact_no);
              
            });
			 
			 
            // Insert customer details....
 
                v_btn_customer_add.click(function(){
                    v_btn_customer_add.ladda( 'start' );
					
                    var v_customer_name=$("#txt_customer_name").val();				
                    var v_customer_contact_no=$("#txt_customer_contact_no").val();
                    var v_customer_email_id=$("#txt_customer_email_id").val();
                   // var v_customer_po_box=$("#txt_customer_po_box").val();
				//	var v_customer_location=$("#txt_customer_location").val();
				    var v_alternate_contact_no=$("#txt_alternate_contact_no").val();
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
                    var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
                    var v_vat_number=$("#txt_vat_number").val();					
                    var v_customer_address=$("#txt_customer_address").val();
					var v_description=$("#txt_description").val();
					//var v_customer_pwd=$("#txt_customer_pwd").val();
					//var v_customer_cpwd=$("#txt_customer_cpwd").val();
                
        
                     if(v_customer_email_id!="")
                    {
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_customer_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                           // return true;
                            
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid Email", "warning");
                                v_btn_customer_add.ladda( 'stop' );
                               $("#txt_customer_email_id").val("");
                               return false;
                            }
                    }  
        
                    if($.trim(v_customer_name)==""|| v_customer_contact_no === "")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_customer_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/customer/customer_controller.php",{action:'add_customer',v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description,v_alternate_contact_no:v_alternate_contact_no}
                                , function(result,status)
                                {                     
                                result = $.trim(result);
                               //console.log($.trim(result));
								  if(result.charAt(0)=='C')
                                   {
                                       swal("Error", result, "error");
                                       v_btn_customer_add.ladda( 'stop' );
                                       
                                       return false;
                                       if(result.charAt(1)=='P')
                                         {
                                             $('#txt_cpr_cr_number').val("");
                                         }
                                         else
                                         {
                                             $('#txt_customer_contact_no').val("");
                                         }
                                   
                                   }
                                   else
                                   {
                                     	    if(parseInt(result)>=1 && parseInt(result)<=9)
                								{
                									 v_customer_code= 'C000'+parseInt(result);
                								}
                								if(parseInt(result)>=10 && parseInt(result)<=99)
                								{
                									v_customer_code= 'C00'+parseInt(result);
                								}
                								if(parseInt(result)>=100 && parseInt(result)<=999)
                								{
                									v_customer_code= 'C0'+parseInt(result);
                								}
                								if(parseInt(result)>=1000 )
                								{
                									v_customer_code= 'C'+parseInt(result);
                								}
                								
                							//	console.log('Code'+v_customer_code);
                													
                								 $.post("../controller/customer/customer_controller.php",{action:'update_customer_code',v_customer_code:v_customer_code,v_customer_id:result}					
                								 , function(result,status)
                									{ 
                								
                								
                                                if(result.charAt(0)=='U')
                                                {
                                                    v_btn_customer_add.ladda( 'stop' );
                                                    swal("Error", result, "error");
                                                   
                                                    clear_text();
                                                   
                
                                                
                                                }
                                                else 
                                                {
                                                     v_btn_customer_add.ladda( 'stop' );
                                                     swal("Success", "New customer added successfully..", "success");
                                                     load_data_to_grid_customer_details_list();
                                                     clear_text();
                                                     location.reload();
                                                }
                                                
                                                 
                                            
                                          });
                        
                                   }
							
                        });
                        
                     }
					 
				 
                  
                });
                //load data to customer grid
                 function load_data_to_grid_customer_details_list()
                 {
                    var i=1; 
                    v_list_of_customer_table.destroy();
                         
                     v_list_of_customer_table = $('#list_of_customer').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/customer/customer_controller.php',
                                 'data': {
                                    action: 'list_customer'
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 1, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				initComplete: function () {
                                var btns = $('.dt-button');
                                btns.addClass('btn btn-success');
                                btns.removeClass('dt-button');
                                  
                            },
                            "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 13] 
                                        },
										filename: 'THC Customers',
									},
								],
            			"columnDefs": [
                            { "visible": false, "targets": [9, 10, 11, 12, 13] }
                          ],
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                { "data": null,
                                     "render": function (data, type, row, meta) {
										    if (row['customer_id'] === 'NA' || row['customer_id'] === null || row['customer_id'] === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                 },
                                   { "data": "customer_name" },
                                    { "data": "customer_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/customer_profile.php?cust_id='+rows['customer_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
								 
                                 { "data": "customer_contact_no"},
                                 { "data": "customer_cpr_cr_no"},
                                 { "data": "customer_email_id"},
								 
                                 
                                 { "data": "customer_status",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='Active')
                                          {
                                          str_active_status='<span class="badge badge-success">'+data+'</span>'
                                          }
                                         
                                          else
                                          {
                                          str_active_status='<span class="badge badge-danger">'+data+'</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                 {
                                    "data": "customer_id",
                                     render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "CustomerModify": "Edit",
                                            "CustomerModify": "Active",
                                            "CustomerModify": "Deactive",
                                            "CustomerModify" : "Delete"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="CustomerModify")
                                        {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="name_Edit" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="name_Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="name_Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a><a href="#" class="dropdown-item" name="name_Delete" style="color: red;"><i class="icon-trash"></i>Delete</a><a href="#" class="dropdown-item" name="name_Password" style="color: orange;"><i class="icon-lock"></i>Password Settings</a>';
                                        }
                                        else
                                        {
                                             dropdownHTML += '<label class="dropdown-item text-danger">You have no privilege</label>';
                                        }
                                
                                        dropdownHTML += '</div></div></div>';
                                
                                        return dropdownHTML;
                                
                                    }
                                },
                                //  { "data": "customer_id",
                                //       render: function ( data, type, rows, meta ) {
                                //          var dropdownOptions = {
                                //             "Edit": "Edit",
                                //             "Activate": "Active",
                                //             "Deactivate": "Deactive",
                                //             "Delete" : "Delete"
                                //         };
                                
                                //         var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                //             return permissions.includes(option);
                                //         });
                                
                                //         var dropdownHTML = '<div class="list-icons divDropdownForExpertise"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                //         console.log("filetered options "+filteredOptions);
                                //         if (filteredOptions.length === 0) {
                                //             dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
                                //         } else {
                                //             filteredOptions.forEach(function (option) {
                                //                 if (dropdownOptions[option] == "Edit") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: orange;"><i class="icon-database-edit2"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Active") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: green;"><i class="icon-checkmark2"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Deactive") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: red;"><i class="icon-cross3"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Delete") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: red;"><i class="icon-trash"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //             });
                                //         }
                                
                                //         dropdownHTML += '</div></div></div>';
                                
                                //         return dropdownHTML;
                                          
                                //       }   
                                //  }, 
                                //  { "data": "customer_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Customer" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a><a href="#" class="dropdown-item" name="Delete" style="color:red"><i class="icon-trash"></i> Delete</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }, 
                                 { "data": "customer_location",visible:false },
                                 { "data": "customer_vat_no",visible:false },
                                  { "data": "customer_contact_person_name",visible:false,
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit =data+'  -  '+rows['customer_contact_person_no'];
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
                                 { "data": "customer_address",visible:false },
                                 { "data": "customer_description",visible:false }
                       
                             ],
                             pageLength: 50,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               var table = this.api();
							   table.buttons('.excel-button').nodes().css('display', 'none');
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                  v_list_of_customer_table.on( 'order.dt search.dt', function () {
                v_list_of_customer_table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1;
                v_list_of_customer_table.cell(cell).invalidate('dom'); 
                } );
                } ).draw();
                 
    			$('#btn_customer_list_excel').on('click', function() {
    				v_list_of_customer_table.button('.excel-button').trigger();
    			});
                   $('#list_of_customer tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var custmr_data = v_list_of_customer_table.row($row).data();
                        v_customer_id  = custmr_data.customer_id;
						//console.log(v_customer_id);
                         v_customer_status  = custmr_data.customer_status;
                         if($(this).attr("name")=='name_Password')
                         {
                             
                          $('#modal_customer_pass').fadeIn();
                          $('#txt_customer_pass_reset_pass').val(custmr_data.customer_password);
                          $('#txt_customer_email_id_reset_pass').val(custmr_data.customer_email_id);
                          $('#txt_cust_code_pass_sett').val(custmr_data.customer_code);
                          $('#txt_customer_name_reset_pass').val(custmr_data.customer_name);
                          
                          $('#span_customer_details_reset_pass').html(custmr_data.customer_name+' , Code : '+custmr_data.customer_code);
                          
                           	 $.post("../controller/customer/customer_controller.php",{action:'retrive_email_pass',customer_code:custmr_data.customer_code}, function(result,status)
                					 { 
                					    if(typeof result !== 'undefined') 
                					    {
                					        var obj = jQuery.parseJSON(result);
                					        $('#txt_customer_pass_reset_pass').val( obj.data[0].customer_password);
                                            $('#txt_customer_email_id_reset_pass').val( obj.data[0].customer_email_id);
                					       
                					    }
                						
                						
                
                					 });
					
                         
               
            			 }
                         if($(this).attr("name")=='name_Delete')
                         {
                             delete_customer(custmr_data.customer_id);
                         }
                         if($(this).attr("name")=='name_Edit')
                         {
                         
                            edit_customer_details(custmr_data.customer_id);
            			    $( '#btn_customer_add').hide();
                            $( '#btn_customer_edit').show();
                            $( '#btn_customer_new').show();
               
            			 }
            			 
            			  function edit_customer_details(v_customer_id)
                            {
                                $("#txt_customer_id").val(v_customer_id);      
								$("#txt_customer_name").val(custmr_data.customer_name);
								
                                //$("#txt_customer_pwd").val(custmr_data.customer_password);
								//$('#txt_customer_pwd').addClass("password_disable");
								//$("#txt_customer_cpwd").val(custmr_data.customer_password);
								//$('#txt_customer_cpwd').addClass("password_disable"); 
								
								$("#txt_customer_contact_no").val(custmr_data.customer_contact_no);
                                $("#txt_customer_email_id").val(custmr_data.customer_email_id);
                                $("#txt_customer_po_box").val(custmr_data.customer_po_box);
                                $("#txt_customer_location").val(custmr_data.customer_location);
                                $("#txt_contact_person").val(custmr_data.customer_contact_person_name);
                                $("#txt_contact_person_number").val(custmr_data.customer_contact_person_no);
                                $("#txt_cpr_cr_number").val(custmr_data.customer_cpr_cr_no);
                                $("#txt_vat_number").val(custmr_data.customer_vat_no);
                                $("#txt_customer_address").val(custmr_data.customer_address);
								$("#txt_description").val(custmr_data.customer_description);
           
                            }
                            
                             if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_customer_action=$(this).attr("name");
                             v_customer_action=v_customer_action.split("_");
                             $.post("../controller/customer/customer_controller.php",{action:'change_customer_status',v_customer_id:v_customer_id,v_customer_status:v_customer_status,v_customer_action:v_customer_action[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_customer_details_list();
                                
                            });
                        }
                          
                        
        });
        
        $('#btn_reset_pass_cust').on('click', function () {
            var cust_pass=$.trim($("#txt_customer_pass_reset_pass").val());
            var cust_code=$.trim($("#txt_cust_code_pass_sett").val());
            if(cust_pass=='')
            {
                swal("Warning", "Please provide password", "warning");
                return false;
            }
            else
            {
               	$.post("../controller/customer/customer_controller.php",{action:'reset_password',customer_code:cust_code,customer_password:cust_pass}
                , function(result,status)
                {
                    swal("Success", "Customer Password Successfully Reset", "warning");
                });
            }
        });
         $('#btn_reset_pass_cust_send_email').on('click', function () {
            var cust_pass=$.trim($("#txt_customer_pass_reset_pass").val());
            var cust_code=$.trim($("#txt_cust_code_pass_sett").val());
            var cust_email=$.trim($("#txt_customer_email_id_reset_pass").val());
            var cust_name=$.trim($("#txt_customer_name_reset_pass").val());
            if(cust_pass=='')
            {
                swal("Warning", "Please provide password", "warning");
                return false;
            }
            else if(cust_email=='')
            {
                 swal("Warning", "Please provide customer email id", "warning");
                return false;
            }
            else
            {
                
                 $.ajax({
                    url: '../view/send_email.php',
                    type: 'POST',
                    data: {action:'forget_password',customer_code:cust_code,customer_password:cust_pass,customer_name:cust_name,customer_email:cust_email},
                    success: function(response) {
                         swal("Success",response, "success");
                     $('#modal_customer_pass').fadeOut();
                     clear_password_reset_modal()
                    },
                    error: function() {
                      swal("Warning", "Unable to send email.", "warning");
                    }
                  });
          
            }
        });
        function clear_password_reset_modal()
        {
            $('#txt_customer_pass_reset_pass').val('');
          $('#txt_customer_email_id_reset_pass').val('');
          $('#txt_cust_code_pass_sett').val('');
          $('#txt_customer_name_reset_pass').val('');
          
          $('#span_customer_details_reset_pass').html('');
        }
        $('.mdlclose').on('click', function () {
          
             $('#modal_customer_pass').fadeOut();
             clear_password_reset_modal();
        });
        $('#span_pass_gen').on('click', function () {
          
             generate_random_password();
        });
        
        function generate_random_password()
        {
            var randomNumber = Math.floor(1000 + Math.random() * 9000);
            var pass='THC'+randomNumber;
            $("#txt_customer_pass_reset_pass").val(pass);
        }
        
       function delete_customer(v_customer_id)
       {
           swal({
			  title: "Are you sure?",
			  text: "Do you want to delete the customer?",
			  icon: "warning",
			  buttons: true,
			  
			  dangerMode: true,
			  buttons: ['No, cancel it!','Yes, I am sure!'],
		})
		.then((willDelete) => {
			  if (willDelete) {
				
				$.post("../controller/customer/customer_controller.php",{action:'delete_customers',v_customer_id:v_customer_id}
                , function(result,status)
                {
                   
                    if($.trim(result)=='exist')
                    {
                        swal("Customer Deletion","Sorry you are not able to delete the customer, as the system found mutilple references.", {
            				icon: "warning",
            			 });
                        return false;
                    }
                    else
                    {
                       
                        
                         swal("Success", "Customer deleted successfully..", "success");	
                         load_data_to_grid_customer_details_list();
                    }
                   
                });
			  }
			  else {
				 
			  }
		});
            
       }
                 
                  $('#list_of_customer tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_customer_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_customer(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_customer(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				//'<td ><div align="center">PO Box </div></td>'+
							'<td ><div align="center">Alternate Contact Number </div></td>'+
            				'<td ><div align="center">VAT No. </div></td>'+
            				'<td ><div align="center">Contact Point </div></td>'+
            				'<td ><div align="center">Address </div></td>'+
            				'<td ><div align="center">Description</div></td>'+
            				
            				'<td ><div align="center">Active Date</div></td>'+
            				
            				'<td ><div align="center">Deactive Date</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            			
							'<td><div align="center">'+d.customer_location+'</div></td>'+
            				'<td><div align="center">'+d.customer_vat_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_contact_person_name+' - '+d.customer_contact_person_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_address+'</div></td>'+
            				'<td><div align="center">'+d.customer_description+'</div></td>'+
            				'<td><div align="center">'+d.date_active1+'</div></td>'+
            				'<td><div align="center">'+d.date_deactive1+' </div></td>'+
            				
            			  '</tr>'+
            			 
            			'</table>' ;
                        			
		
		
	            }
	             // Edit employee details....
 
                v_btn_customer_edit.click(function(){
                    
                    v_btn_customer_edit.ladda( 'start' );
					var v_customer_id=$("#txt_customer_id").val();
					var v_customer_name=$("#txt_customer_name").val();                   
                    //var v_customer_code=$("#txt_customer_code").val();
                    //var v_customer_pwd=$("#txt_customer_pwd").val();
					
                    var v_customer_contact_no=$("#txt_customer_contact_no").val();
                    var v_customer_email_id=$("#txt_customer_email_id").val();
                    //var v_customer_po_box=$("#txt_customer_po_box").val();
					
					//var v_customer_location=$("#txt_customer_location").val();                   
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
					var v_alternate_contact_no=$("#txt_alternate_contact_no").val();
                    var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
                    var v_vat_number=$("#txt_vat_number").val();
					
                    var v_customer_address=$("#txt_customer_address").val();
					var v_description=$("#txt_description").val();
					  if(v_customer_email_id!="")
                    {
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_customer_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                           // return true;
                            
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid Email", "warning");
                                v_btn_customer_edit.ladda( 'stop' );
                               $("#txt_customer_email_id").val("");
                               return false;
                            }
                    }  
                    if($.trim(v_customer_name)==""|| v_customer_contact_no === "")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_customer_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/customer/customer_controller.php",{action:'update_customer',v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description,v_alternate_contact_no:v_alternate_contact_no}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='C')
                                   {
                                       swal("Error", result, "error");
                                       v_btn_customer_edit.ladda( 'stop' );
                                       
                                       return false;
                                       if(result.charAt(1)=='P')
                                         {
                                             $('#txt_cpr_cr_number').val("");
                                         }
                                         else
                                         {
                                             $('#txt_customer_contact_no').val("");
                                         }
                                   
                                   }
                                   else
                                   {
                                         if(result.charAt(0)=='U')
                                        {
                                            v_btn_customer_edit.ladda( 'stop' );
                                            swal("Error", result, "error");
                                            clear_text();
                                           
        
                                        
                                        }
                                        else 
                                        {
                                             v_btn_customer_edit.ladda( 'stop' );
                                             swal("Success", "Customer details updated successfully..", "success");
                                             load_data_to_grid_customer_details_list();
        									 $( '#btn_customer_add' ).show();
                                             $( '#btn_customer_edit' ).hide();
                                             $( '#btn_customer_new' ).hide();
                                             clear_text();
                                            
                                        }
                                   }
                              
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
                //function clear text
                   function clear_text()
                 {

					$("#txt_customer_name").val('');
                    $("#txt_customer_cpwd").val('');
                    //$("#txt_customer_pwd").val('');
								
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
                 
					
			 $( '#btn_customer_new' ).click(function(){
                  
                  $( '#btn_customer_add' ).show();
                  $( '#btn_customer_edit' ).hide();
                  $( '#btn_customer_new' ).hide();
				  //$('#txt_customer_pwd').removeClass("password_disable");
				  //$('#txt_customer_cpwd').removeClass("password_disable");
                  clear_text();
                 
              })
              
             

});