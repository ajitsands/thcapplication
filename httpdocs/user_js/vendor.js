$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
                 $('#btn_vendor_edit').hide();
                    $('#btn_vendor_new').hide();
                    $('#error_email').hide();
                    //$("#div_expertise_select").hide();
                     
                    var v_btn_vendor_add = $('#btn_vendor_add').ladda();
                    var v_btn_vendor_edit = $('#btn_vendor_edit').ladda();
                    var v_btn_vendor_new = $('#btn_vendor_new').ladda();
                 
                    var v_list_of_vendor_table = $('#list_of_vendor').DataTable({});
                      load_data_to_grid_vendor_details_list();
					  
                   //check email
                     /* $("#txt_vendor_email_id").change(function(){
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_vendor_email_id").val();
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
  
		
			 
            // Insert vendor details....
 
                v_btn_vendor_add.click(function(){
                    v_btn_vendor_add.ladda( 'start' );
					
                    var v_vendor_name=$("#txt_vendor_name").val();				
                    var v_vendor_contact_no=$("#txt_vendor_contact_no").val();
                    var v_vendor_email_id=$("#txt_vendor_email_id").val();
                    var v_vendor_vat_reg_no=$("#txt_vendor_vat_reg_no").val();
					var v_vendor_fax=$("#txt_vendor_fax").val();                   
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
                    var v_vendor_po_box=$("#txt_vendor_po_box").val();
                    var v_vendor_address=$("#txt_vendor_address").val();
					
                     if(v_vendor_email_id!="")
                    {
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_vendor_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                           // return true;
                            
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid Email", "warning");
                                v_btn_vendor_add.ladda( 'stop' );
                               $("#txt_vendor_email_id").val("");
                               return false;
                            }
                                                 
                     }
        
                    if($.trim(v_vendor_name)==""|| v_vendor_contact_no === ""||$.trim(v_vendor_vat_reg_no)==""||$.trim(v_vendor_fax)==""||$.trim(v_vendor_address)==""||$.trim(v_vendor_po_box)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_vendor_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/vendor/vendor_controller.php",{action:'add_vendor',v_vendor_name:v_vendor_name,v_vendor_contact_no:v_vendor_contact_no,v_vendor_email_id:v_vendor_email_id,v_vendor_vat_reg_no:v_vendor_vat_reg_no,v_vendor_fax:v_vendor_fax,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_vendor_address:v_vendor_address,v_vendor_po_box:v_vendor_po_box}
                                , function(result,status)
                                {                     
                                result = $.trim(result);
                               
							
								
							
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_vendor_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     v_btn_vendor_add.ladda( 'stop' );
                                     swal("Success", "New vendor added successfully..", "success");
                                     load_data_to_grid_vendor_details_list();
                                     clear_text();
                                }
                                
                                 
                            
                        
                        
                        });
                        
                     }
					 
				 
                  
                });
                //load data to vendor grid
                 function load_data_to_grid_vendor_details_list()
                 {
                     
                    v_list_of_vendor_table.destroy();
                         
                     v_list_of_vendor_table = $('#list_of_vendor').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/vendor/vendor_controller.php',
                                 'data': {
                                    action: 'list_vendor'
                                    
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
                                 { "data": "vendor_id","visible":false },
                                 { "data": "vendor_name" },
                                 { "data": "vendor_tel_no"},
                                 { "data": "vendor_email"},
								 { "data": "vendor_vat_reg_no" },
                                 
                                 { "data": "vendor_status",
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
                                 
                                 { "data": "vendor_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_vendor" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
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
                 
                   $('#list_of_vendor tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var custmr_data = v_list_of_vendor_table.row($row).data();
                        v_vendor_id  = custmr_data.vendor_id;
						//console.log(v_vendor_id);
                         v_vendor_status  = custmr_data.vendor_status;
                         if($(this).attr("name")=='Edit_vendor')
                         {
                         
                            edit_vendor_details(v_vendor_id);
            			    $( '#btn_vendor_add').hide();
                            $( '#btn_vendor_edit').show();
                            $( '#btn_vendor_new').show();
               
            			 }
            			 
            			  function edit_vendor_details(v_vendor_id)
                            {
                                $("#txt_vendor_id").val(v_vendor_id);      
								$("#txt_vendor_name").val(custmr_data.vendor_name);
								
								$("#txt_vendor_contact_no").val(custmr_data.vendor_tel_no);
                                $("#txt_vendor_email_id").val(custmr_data.vendor_email);
                                $("#txt_vendor_vat_reg_no").val(custmr_data.vendor_vat_reg_no);
                                $("#txt_vendor_fax").val(custmr_data.vendor_fax);
                                $("#txt_vendor_po_box").val(custmr_data.vendor_po_box);
                                $("#txt_contact_person").val(custmr_data.vendor_contact_person_name);
                                $("#txt_contact_person_number").val(custmr_data.vendor_contact_person_no);
                                $("#txt_vendor_address").val(custmr_data.vendor_address);
								
           
                            }
                            
                             if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_vendor_action=$(this).attr("name");
                             $.post("../controller/vendor/vendor_controller.php",{action:'change_vendor_status',v_vendor_id:v_vendor_id,v_vendor_status:v_vendor_status,v_vendor_action:v_vendor_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_vendor_details_list();
                                
                            });
                        }
                          
                        
        });
       
                 
                  $('#list_of_vendor tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_vendor_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_vendor(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
                 function format_vendor(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            			    '<td ><div align="center">Fax No</div></td>'+
            			    '<td ><div align="center">P.O Box</div></td>'+
            				'<td ><div align="center">Contact Person</div></td>'+
            				'<td ><div align="center">Contact Person Number</div></td>'+	
							'<td ><div align="center">Address </div></td>'+
            			
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            			    '<td><div align="center">'+d.vendor_fax+'</div></td>'+
            			    '<td><div align="center">'+d.vendor_po_box+'</div></td>'+
            				'<td><div align="center">'+d.vendor_contact_person_name+'</div></td>'+
            				
            				'<td><div align="center">'+d.vendor_contact_person_no+'</div></td>'+
            				'<td><div align="center">'+d.vendor_address+'</div></td>'+
            			
            				
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	             // Edit employee details....
 
                v_btn_vendor_edit.click(function(){
                    
                    v_btn_vendor_edit.ladda( 'start' );
					var v_vendor_id=$("#txt_vendor_id").val();
					var v_vendor_name=$("#txt_vendor_name").val();                   
                    var v_vendor_contact_no=$("#txt_vendor_contact_no").val();
                    var v_vendor_email_id=$("#txt_vendor_email_id").val();
                    var v_vendor_vat_reg_no=$("#txt_vendor_vat_reg_no").val();
                    var v_vendor_po_box=$("#txt_vendor_po_box").val(); 
					var v_vendor_fax=$("#txt_vendor_fax").val();                   
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
					var v_vendor_address=$("#txt_vendor_address").val();
				
					
                    if($.trim(v_vendor_name)==""|| v_vendor_contact_no === ""||$.trim(v_vendor_vat_reg_no)==""||$.trim(v_vendor_address)==""||$.trim(v_vendor_po_box)=="")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_vendor_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/vendor/vendor_controller.php",{action:'update_vendor',v_vendor_po_box:v_vendor_po_box,v_vendor_id:v_vendor_id,v_vendor_name:v_vendor_name,v_vendor_contact_no:v_vendor_contact_no,v_vendor_email_id:v_vendor_email_id,v_vendor_vat_reg_no:v_vendor_vat_reg_no,v_vendor_fax:v_vendor_fax,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_vendor_address:v_vendor_address}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_vendor_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     v_btn_vendor_edit.ladda( 'stop' );
                                     swal("Success", "vendor details updated successfully..", "success");
                                     load_data_to_grid_vendor_details_list();
									 $( '#btn_vendor_add' ).show();
                                     $( '#btn_vendor_edit' ).hide();
                                     $( '#btn_vendor_new' ).hide();
									
                                     clear_text();
                                    
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
                //function clear text
                   function clear_text()
                 {

					$("#txt_vendor_name").val('');
                 $("#txt_vendor_po_box").val('');
                    $("#txt_vendor_contact_no").val('');
                    $("#txt_vendor_email_id").val('');
                    $("#txt_vendor_vat_reg_no").val('');
					$("#txt_vendor_fax").val('');
                    $("#txt_contact_person").val('');
                    $("#txt_contact_person_number").val('');
				    $("#txt_vendor_address").val('');
				   
                 }
                 
					
			 $( '#btn_vendor_new' ).click(function(){
                  
                  $( '#btn_vendor_add' ).show();
                  $( '#btn_vendor_edit' ).hide();
                  $( '#btn_vendor_new' ).hide();
				 
                  clear_text();
                 
              })

});