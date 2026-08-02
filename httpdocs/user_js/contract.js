$(document).ready(function(){
  
                    var v_btn_contract_add = $('#btn_contract_add').ladda();
                    var v_btn_contract_edit = $('#btn_contract_edit').ladda();
                    var v_btn_contract_new = $('#btn_contract_new').ladda();
                    
                    $("#btn_contract_edit").hide();
                    $("#btn_contract_new").hide();
                    contract_list_table = $('#list_of_contract').DataTable( {} );
                    load_data_to_grid_contract();
            // Insert expertise details....
 
                v_btn_contract_add.click(function(){
                    
                    v_btn_contract_add.ladda( 'start' );
                    var v_contract_name=$("#txt_contract_name").val();
					
                  
                    if($.trim(v_contract_name)=="")
                    
                    {
                        swal("Warning","Please provide contract name ....", "warning");
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
                                     
                                    load_data_to_grid_contract();
                                    $("#txt_contract_name").val('');
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
        
        
        function load_data_to_grid_contract()
                 {
                     var i=1;
                    contract_list_table.destroy();
                         
                     contract_list_table = $('#list_of_contract').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/contract/contract_controller.php',
                                 'data': {
                                    action: 'list_contract'
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                 { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "contract_type_id","visible":false },
                                 { "data": "contract_type_name" },
                                 { "data": "contract_type_status",
                                    render: function ( data, type, rows, meta ) {
                                        if(data=='Active'){
                                          str_active_status = '<span class="badge badge-success">'+data+'</span>';
                                          return str_active_status;
                                        }
                                        else{
                                            str_active_status = '<span class="badge badge-danger">'+data+'</span>';
                                            return str_active_status;
                                        }
                                      }    
                                 },
                                 {
                                    "data": "contract_type_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "ContractTypeAndAssetCategoryModify": "Edit",
                                            "ContractTypeAndAssetCategoryModify": "Active",
                                            "ContractTypeAndAssetCategoryModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="ContractTypeAndAssetCategoryModify")
                                        {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="name_Edit" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="name_Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="name_Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a>';
                                        }
                                        else
                                        {
                                             dropdownHTML += '<label class="dropdown-item text-danger">You have no privilege</label>';
                                        }
                                
                                        dropdownHTML += '</div></div></div>';
                                
                                        return dropdownHTML;
                                
                                    }
                                }
                                //  { "data": "contract_type_id",
                                //       render: function ( data, type, rows, meta ) {
                                //       var dropdownOptions = {
                                //             "Edit": "Edit",
                                //             "Activate": "Active",
                                //             "Deactivate": "Deactive"
                                //         };
                                
                                //         var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                //             return permissions.includes(option);
                                //         });
                                
                                //         var dropdownHTML = '<div class="list-icons divDropdownForExpertise"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
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
                                //             });
                                //         }
                                
                                //         dropdownHTML += '</div></div></div>';
                                
                                //         return dropdownHTML;
                                          
                                //       }   
                                //  }
                                //  { "data": "contract_type_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Contract" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
          $('#list_of_contract tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = contract_list_table.row($row).data();
                        v_contract_type_id  = data.contract_type_id;
                        v_contract_type_status = data.contract_type_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
            			 $("#txt_contract_id").val(v_contract_type_id);  
                         $("#txt_contract_name").val(data.contract_type_name);
                         
            			    $( '#btn_contract_add').hide();
                            $( '#btn_contract_edit').show();
                            $( '#btn_contract_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         
                         {
                             var v_contr_action_status=$(this).attr("name");  
                             v_contr_action_status = v_contr_action_status.split("_");
                             $.post("../controller/contract/contract_controller.php",{action:'change_contract_status',v_contract_type_id:v_contract_type_id,v_contract_type_status:v_contract_type_status,v_contr_action_status:v_contr_action_status[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_contract();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_contract_edit.click(function(){
                      
                 
                     v_btn_contract_edit.ladda( 'start' );
                    var v_contract_id=$("#txt_contract_id").val();
                    var v_contract_name=$("#txt_contract_name").val();
  
    
                    if($.trim(v_contract_id)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_contract_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/contract/contract_controller.php",{action:'update_contract',v_contract_type_id:v_contract_id,v_contract_type_name:v_contract_name}
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
								console.log(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_contract_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_contract_edit.ladda( 'stop' );
                                     swal("Success", "Contract details updated successfully..", "success");
                                     
                                      $( '#btn_contract_add' ).show();
                                      $( '#btn_contract_edit' ).hide();
                                      $( '#btn_contract_new' ).hide();
                                        $("#txt_contract_name").val('');
                                      load_data_to_grid_contract();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_contract_new' ).click(function(){
                  
                  $( '#btn_contract_add' ).show();
                  $( '#btn_contract_edit' ).hide();
                  $( '#btn_contract_new' ).hide();
                  $("#txt_contract_name").val('');
                 
              })
                  
         

});