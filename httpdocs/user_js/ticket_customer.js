$(document).ready(function(){
                    
                    $('#btn_customer_edit').hide();
                    $('#btn_customer_new').hide();
                    $('#error_email').hide();
                    
                    var v_btn_customer_add = $('#btn_customer_add').ladda();
                    var v_btn_customer_edit = $('#btn_customer_edit').ladda();
                    var v_btn_customer_new = $('#btn_customer_new').ladda();
                 
                    var v_list_of_customer_table = $('#list_of_customer').DataTable({});
                      load_data_to_grid_customer_details_list();
					  
                   //check email
                      $("#txt_customer_email_id").change(function(){
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
                                                 
                    });
  
			
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
							
							swal("Warning","Customer Contact Number already exists", "warning");
							$("#txt_contact_person_number").val('');
							return false;
						}

					 });
					
				});
			// end of check
			
			//to check whether the cpr/cr number is unique
 				$("#txt_cpr_cr_number").blur(function(){
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
							
							swal("Warning","CPR/CR Number already exists", "warning");
							$("#txt_cpr_cr_number").val('');
							return false;
						}

					 });
					 
				});
			// end of check
			 
            // Insert customer details....
 
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
                         $.post("../controller/customer/customer_controller.php",{action:'add_customer',v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_customer_po_box:v_customer_po_box,v_customer_location:v_customer_location,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description}
                                , function(result,status)
                                {                     
                                result = $.trim(result);
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
                								
                								//console.log(v_customer_code);
                													
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
                                                    // location.reload();
                                                    
                                                     clear_text();
                                                }
                                                
                                                 
                                            
                                          });
                        
                                   }
							
                        });
                        
                     }
					 
				 
                  
     });
                //load data to customer grid
                 function load_data_to_grid_customer_details_list()
                 {
                     
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
                            "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "customer_name" },
								 { "data": "customer_code"},
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
                                 
                                 { "data": "customer_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Customer" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,4,5,6,7,8] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                 //  $('#list_of_customer tbody').on('click', 'a', function(){
                   //     var $row = $(this).closest('tr');
                    //    var custmr_data = v_list_of_customer_table.row($row).data();
                     //   v_customer_id  = custmr_data.customer_id;
					
                     //    v_customer_status  = custmr_data.customer_status;
                     //    if($(this).attr("name")=='Edit_Customer')
                      //   {
                         
                     //       edit_customer_details(custmr_data.customer_id);
            		//	    $( '#btn_customer_add').hide();
                      //      $( '#btn_customer_edit').show();
                      //      $( '#btn_customer_new').show();
               
            		//	 }
            		//	  function edit_customer_details(v_customer_id)
                     //       {
                       //         $("#txt_customer_id").val(v_customer_id);      
					//			$("#txt_customer_name").val(custmr_data.customer_name);
								
					//			$("#txt_customer_contact_no").val(custmr_data.customer_contact_no);
                      //          $("#txt_customer_email_id").val(custmr_data.customer_email_id);
                      //          $("#txt_customer_po_box").val(custmr_data.customer_po_box);
                        //        $("#txt_customer_location").val(custmr_data.customer_location);
                         //       $("#txt_contact_person").val(custmr_data.customer_contact_person_name);
                         //       $("#txt_contact_person_number").val(custmr_data.customer_contact_person_no);
                         //       $("#txt_cpr_cr_number").val(custmr_data.customer_cpr_cr_no);
                         //       $("#txt_vat_number").val(custmr_data.customer_vat_no);
                          //      $("#txt_customer_address").val(custmr_data.customer_address);
						//		$("#txt_description").val(custmr_data.customer_description);
           
                          //  }
                            
                          //   if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                        // {
                         //    var v_customer_action=$(this).attr("name");
                         //    $.post("../controller/customer/customer_controller.php",{action:'change_customer_status',v_customer_id:v_customer_id,v_customer_status:v_customer_status,v_customer_action:v_customer_action}
                         //       , function(result,status)
                         //       {
                                   
                           //        load_data_to_grid_customer_details_list();
                                
                          //  });
                  //      }
                          
                        
      //  });
       
                 
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
            			    
            				
            				'<td ><div align="center">PO Box </div></td>'+
							'<td ><div align="center">Location </div></td>'+
            				'<td ><div align="center">VAT No. </div></td>'+
            				'<td ><div align="center">Contact Point </div></td>'+
            				'<td ><div align="center">Address </div></td>'+
            				'<td ><div align="center">Description</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.customer_po_box+'</div></td>'+
							'<td><div align="center">'+d.customer_location+'</div></td>'+
            				'<td><div align="center">'+d.customer_vat_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_contact_person_name+' - '+d.customer_contact_person_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_address+'</div></td>'+
            				'<td><div align="center">'+d.customer_description+'</div></td>'+
            				
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	             // Edit customer details....
 
                v_btn_customer_edit.click(function(){
                    
                    v_btn_customer_edit.ladda( 'start' );
					var v_customer_id=$("#txt_customer_id").val();
					var v_customer_name=$("#txt_customer_name").val();                   
                    //var v_customer_code=$("#txt_customer_code").val();
                    //var v_customer_pwd=$("#txt_customer_pwd").val();
					
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
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_customer_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/customer/customer_controller.php",{action:'update_customer',v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_customer_po_box:v_customer_po_box,v_customer_location:v_customer_location,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description}
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
				
                  clear_text();
                 
              })

});