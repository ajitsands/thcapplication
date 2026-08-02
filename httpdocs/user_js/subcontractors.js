$(document).ready(function(){
  var v_user_type_id,v_user_type_name,v_emp_code,v_employee_id,v_session_image,randomNum,v_employee_status,v_expertise_id=[],v_expertise_name=[],checked_val;
            var v_item_img;         
                    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    
                    $('#btn_subcontractor_edit').hide();
                    $('#btn_employee_new').hide();
                    
                     
                    var v_btn_subcontractor_add = $('#btn_subcontractor_add').ladda();
                    var v_btn_btn_subcontractor_edit = $('#btn_subcontractor_edit').ladda();
                    var v_btn_employee_new = $('#btn_employee_new').ladda();
                 
                    var v_list_of_subcontractors_table = $('#list_of_subcontractors').DataTable({});
                    load_data_to_grid_subcontractors_details_list();
                   
                     $('#select_employee_type').change(function (e) {
                         
                            v_user_type_id=$("#select_employee_type option:selected").val();
                            v_user_type_name=$("#select_employee_type option:selected").text()
                            //console.log(v_user_type_name);
                            if(v_user_type_name=='Technician')
                            {
                                 $("#div_expertise_select").show();
                                 $("#div_select_emp_tech_type").show();
                            }
                            else
                            {
                                $("#div_expertise_select").hide();
                                $("#div_select_emp_tech_type").hide();
                            }
                    });
             
                      $('#select_expertise').on('select2:select', function (e) {
                        
                         var data = e.params.data;
                          
                       
                         expertise_id= data.id;
                         v_expertise_name= $('#select_expertise option:selected') .toArray().map(item => item.text);
                         v_expertise_id = $('#select_expertise option:selected') .toArray().map(item => item.value);
                        
                        
                       
                        });
                $('#session_image').change(function (e) {
         
                 
                v_item_img = $("#session_image").val();
                var  randomNum = Math.ceil(Math.random() * 999999);
                    if(v_item_img=="")
                {
                    v_item_img="default.jpg";
                }
                else
                {
                    var doc_file_obj = $("#session_image")[0].files[0];
                    var upload = new ns.Upload(doc_file_obj);
                    var doc_file1= doc_file_obj.name;
                    v_item_img=$.trim(randomNum+'_'+doc_file1);
					//alert(v_item_img);
                    var success = upload.doUpload("../../httpdocs/user_upload/subcontractor_reg_form_upload.php?random_no="+randomNum,v_item_img);

                }  
        });   
       
                     $('input[type="checkbox"]').click(function(){
                        if($(this).prop("checked") === true)
                        {
                            checked_val='Yes';
                        }
                    
                        else 
                        {
                         checked_val='No';
                        }
                 });
                        
            // Insert subcontractors details....
 
                v_btn_subcontractor_add.click(function(){
                    v_btn_subcontractor_add.ladda( 'start' );
					
                    var v_sub_name=$("#txt_subcontractor_name").val();
                    var v_sub_cr_no=$("#txt_subcontractor_cr_no").val();
					var v_sub_address=$("#txt_subcontractor_address").val();
					var v_sub_contact_person_name=$("#txt_subcontratcor_contact_person_name").val();
                    var v_sub_contact_no1=$("#txt_contact_no1").val();
					var v_sub_contact_no2=$("#txt_contact_no2").val();
                    
                    v_session_image = $("#session_image").val();
                    randomNum = Math.ceil(Math.random() * 999999);   
                    
                        if(v_session_image==="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                            upload.doUpload("../httpdocs/user_upload/subcontractor_reg_form_upload.php?random_no="+randomNum);
                            v_session_image=$.trim(randomNum+'_'+doc_file1);
                        }  
                    //alert(v_session_image);
                    if($.trim(v_sub_name)===""||$.trim(v_sub_cr_no)===""||$.trim(v_sub_address)===""||v_sub_contact_person_name===""||v_sub_contact_no1==="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_subcontractor_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {     
                       
                         $.post("../controller/subcontractors/subcontractor_controller.php",{action:'add_subcontractor',v_sub_name:v_sub_name,v_sub_cr_no:v_sub_cr_no,v_sub_address:v_sub_address,v_sub_contact_person_name:v_sub_contact_person_name,v_sub_contact_no1:v_sub_contact_no1,v_sub_contact_no2:v_sub_contact_no2,v_subcontractor_reg_form:v_session_image}
                                , function(result,status)
                                {
                                    console.log(result);
									result = $.trim(result);
                               
                                if(result=="")
                                {
                                    v_btn_subcontractor_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   
                                }
                                else 
                                {
                                    v_btn_subcontractor_add.ladda( 'stop' );
                                     swal("Success", "New subcontractor added successfully..", "success");
                                     load_data_to_grid_subcontractors_details_list();
                                     clear_text();
                                     location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                //load data to employeegrid
                 function load_data_to_grid_subcontractors_details_list()
                 {
                     var i=1;
                    v_list_of_subcontractors_table.destroy();
                         
                     v_list_of_subcontractors_table = $('#list_of_subcontractors').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/subcontractors/subcontractor_controller.php',
                                 'data': {
                                    action: 'subcontractors_list_view'
                                    
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
            				
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "subcontractor_ids","visible":false },
                                 { "data": "subcontractor_name" },
                                 { "data": "subcontractor_cr_no"},
                                  { "data": "subcontractor_address"},
                                
                                 { "data": "subcontactor_status",
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
                                    "data": "expertise_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "SubContractorsModify": "Edit",
                                            "SubContractorsModify": "Active",
                                            "SubContractorsModify": "Deactive",
                                            "SubContractorsModify":"View vendor registration form"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="SubContractorsModify")
                                        {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="Edit_Employee" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a><a href="../httpdocs/images/subcontractors_reg_form/'+rows["vendor_reg_form"]+'" target="_blank" class="dropdown-item" name="view_doc" style="color:blue"><i class="icon-file-text3"></i>View vendor registration form</a>';
                                        }
                                        else
                                        {
                                             dropdownHTML += '<label class="dropdown-item text-danger">You have no privilege</label>';
                                        }
                                
                                        dropdownHTML += '</div></div></div>';
                                
                                        return dropdownHTML;
                                
                                    }
                                }
                                 
                                //  { "data": "subcontractor_ids",
                                //       render: function ( data, type, rows, meta ) {
                                //         var dropdownOptions = {
                                //             "Edit": "Edit",
                                //             "Activate": "Active",
                                //             "Deactivate": "Deactive",
                                //             "ViewVendorRegistrationForm":"View vendor registration form"
                                //         };
                                        
                                //         var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                //             return permissions.includes(option);
                                //         });
                                        
                                //         var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                        
                                //         if (filteredOptions.length === 0) {
                                //             dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
                                //         } else {
                                //             filteredOptions.forEach(function (option) {
                                //                 if (dropdownOptions[option] == "Edit") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Active") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Deactive") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "View vendor registration form") {
                                //                     dropdownHTML += '<a href="../httpdocs/images/subcontractors_reg_form/'+rows["vendor_reg_form"]+'" target="_blank" class="dropdown-item" name="view_doc" style="color:blue"><i class="icon-file-text3"></i>View vendor registration form</a>';
                                //                 }
                                //             });
                                //         }
                                //          dropdownHTML += '</div></div></div>';
                                
                                //         return dropdownHTML;  
                                //       }   
                                //  }
                                //  { "data": "subcontractor_ids",
                                //       render: function ( data, type, rows, meta ) {
                                //         //   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a><a href="#" class="dropdown-item" name="view_employee" style="color:blue"><i class="icon-book2"></i> View</a></div></div></div>';
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a><a href="../httpdocs/images/subcontractors_reg_form/'+rows["vendor_reg_form"]+'" target="_blank" class="dropdown-item" name="view_doc" style="color:blue"><i class="icon-file-text3"></i>View vendor registration form</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                   $('#list_of_subcontractors tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var subcontractor_data = v_list_of_subcontractors_table.row($row).data();
                        v_subcontractor_id  = subcontractor_data.subcontractor_ids;
                         v_subcontractor_status  = subcontractor_data.subcontactor_status;
                         if($(this).attr("name")=='Edit_Employee')
                         {
                         
                            $("#txt_subcontractor_name").val(subcontractor_data.subcontractor_name);
							$("#txt_subcontractor_cr_no").val(subcontractor_data.subcontractor_cr_no);
							$("#txt_subcontractor_address").val(subcontractor_data.subcontractor_address);
							$("#txt_subcontratcor_contact_person_name").val(subcontractor_data.subcontratcor_contact_person_name);
							$("#txt_contact_no1").val(subcontractor_data.contact_no1);
							$("#txt_contact_no2").val(subcontractor_data.contact_no2);
							
							$("#img_preview").html("<img style='width:60px;height:60px;'src='../httpdocs/images/subcontractors_reg_form/"+$.trim(subcontractor_data.vendor_reg_form)+"'>");
							$('#vendor_reg_form').text(subcontractor_data.vendor_reg_form);
            			    $( '#btn_subcontractor_add').hide();
                            $( '#btn_subcontractor_edit').show();
               
            			 }
            			
            			 
                        if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                        {
                             var v_subcontractor_action=$(this).attr("name");
                             $.post("../controller/subcontractors/subcontractor_controller.php",{action:'change_subcontractor_status',v_subcontractor_id:v_subcontractor_id,v_subcontractor_status:v_subcontractor_status,v_subcontractor_action:v_subcontractor_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_subcontractors_details_list();
                                
                            });
                        }
						
						if($(this).attr("name")=='view_doc')
                         {
							 
						 }
                          
                        
        });
       
                 
                  $('#list_of_subcontractors tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_subcontractors_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_subcontractors(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
                 function format_subcontractors(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				'<td ><div align="center">Contact Person Name</div></td>'+
            				'<td ><div align="center">Contact Number 1</div></td>'+
            				'<td ><div align="center">Contact Number 2</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.subcontratcor_contact_person_name+'</div></td>'+
            				'<td><div align="center">'+d.contact_no1+'</div></td>'+
            				'<td><div align="center">'+d.contact_no2+'</div></td>'+
            				
            			  '</tr>'+
            			  
            			'</table>' ;
                        			
		
		
	            }
	             // Edit Subcontractors details....
 
                v_btn_btn_subcontractor_edit.click(function(){
                    
                    v_btn_btn_subcontractor_edit.ladda( 'start' );
                    var v_sub_name=$("#txt_subcontractor_name").val();
                    var v_sub_cr_no=$("#txt_subcontractor_cr_no").val();
					var v_sub_address=$("#txt_subcontractor_address").val();
					var v_sub_contact_person_name=$("#txt_subcontratcor_contact_person_name").val();
                    var v_sub_contact_no1=$("#txt_contact_no1").val();
					var v_sub_contact_no2=$("#txt_contact_no2").val();
					
                    v_session_image = $("#session_image").val();
                    var v_session_image_new = $("#vendor_reg_form").text();
                    var randomNum = Math.ceil(Math.random() * 999999);   
					
                     if(v_session_image=="" && v_session_image_new!="")
                        {
                            v_session_image=v_session_image_new;
                           
                            
                        }
                        else if(v_session_image=="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                            upload.doUpload("../httpdocs/user_upload/subcontractor_reg_form_upload.php?random_no="+randomNum);
                            v_session_image=randomNum+'_'+doc_file1;
                        }  
						//alert(v_session_image);
                    if($.trim(v_sub_name)===""||$.trim(v_sub_cr_no)===""||$.trim(v_sub_address)===""||v_sub_contact_person_name===""||v_sub_contact_no1==="")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_subcontractor_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/subcontractors/subcontractor_controller.php",{action:'update_subcontractor',v_subcontractor_id:v_subcontractor_id,v_sub_name:v_sub_name,v_sub_cr_no:v_sub_cr_no,v_sub_address:v_sub_address,v_sub_contact_person_name:v_sub_contact_person_name,v_sub_contact_no1:v_sub_contact_no1,v_sub_contact_no2:v_sub_contact_no2,v_subcontractor_reg_form:v_session_image}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                // result = $.trim(result);
                               
                                // if(result.charAt(0)=='U')
                                // {
                                    // v_btn_btn_subcontractor_edit.ladda( 'stop' );
                                    // swal("Error", result, "error");
                                    // clear_text();
                                   

                                
                                // }
                                // else 
                                // {
                                     v_btn_btn_subcontractor_edit.ladda( 'stop' );
                                     swal("Success", "Subcontractors details updated successfully..", "success");
                                     load_data_to_grid_subcontractors_details_list();
                                    clear_text();
									$('#btn_subcontractor_edit').hide();
									$('#btn_subcontractor_add').show();
                                    
                                // }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                
                 $( '#btn_employee_new' ).click(function(){
                  
                        $( '#btn_employee_add' ).show();
                        $( '#div_emp_code').hide();
                        $( '#btn_employee_edit' ).hide();
                        $( '#btn_employee_new' ).hide();
                        clear_text();
                    })
            
                //function clear text
                   function clear_text()
                 {
                   
                    $("#txt_subcontractor_name").val('');
                    $("#txt_subcontractor_cr_no").val('');
                    $("#txt_subcontractor_address").val('');
                    $("#txt_subcontratcor_contact_person_name").val('');
                    $("#txt_contact_no1").val('');
					$("#txt_contact_no2").val('');
					
                    $("#session_image").val(null);
					
                    $("#vendor_reg_form").empty();
                    $("#img_preview").hide()
                 }
                  

});