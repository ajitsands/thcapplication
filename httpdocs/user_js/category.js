$(document).ready(function(){
  
  $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    var v_btn_category_add = $('#btn_category_add').ladda();
                    var v_btn_category_edit = $('#btn_category_edit').ladda();
                    var v_btn_category_new = $('#btn_category_new').ladda();
                    
                    $("#btn_category_edit").hide();
                    $("#btn_category_new").hide();
                    category_list_table = $('#list_of_category').DataTable( {} );
                    load_data_to_grid_category();
            // Insert expertise details....
 
                v_btn_category_add.click(function(){
                    
                    v_btn_category_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_cat_name=$("#txt_cat_name").val();
					
                  
                    if($.trim(v_cat_name)=="")
                    
                    {
                        swal("Warning","Please provide category....", "warning");
                        v_btn_category_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/category/category_controller.php",{action:'add_category',v_category_name:v_cat_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_category_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_category_add.ladda( 'stop' );
                                     swal("Success", "New category added successfully..", "success");
                                     
                                    load_data_to_grid_category();
                                    $("#txt_cat_name").val('');
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
        
        
        function load_data_to_grid_category()
                 {
                     var i=1;
                    category_list_table.destroy();
                         
                     category_list_table = $('#list_of_category').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/category/category_controller.php',
                                 'data': {
                                    action: 'list_category'
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
                                 { "data": "category_id","visible":false },
                                 { "data": "category_name" },
                                 { "data": "category_status",
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
                                    "data": "category_id",
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
                                //  { "data": "category_id",
                                //       render: function ( data, type, rows, meta ) {
                                         
                                //          var dropdownOptions = {
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
                                //  { "data": "category_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Category" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
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
                              //   return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
          $('#list_of_category tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = category_list_table.row($row).data();
                        v_category_id  = data.category_id;
                        v_category_status  = data.category_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
            			 $("#txt_cat_id").val(v_category_id);  
                         $("#txt_cat_name").val(data.category_name);
                         
            			    $( '#btn_category_add').hide();
                            $( '#btn_category_edit').show();
                            $( '#btn_category_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_action_cat_status=$(this).attr("name");
                             v_action_cat_status=v_action_cat_status.split("_");
                             $.post("../controller/category/category_controller.php",{action:'change_category_status',v_category_id:v_category_id,v_category_status:v_category_status,v_action_cat_status:v_action_cat_status[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_category();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_category_edit.click(function(){
                      
                 
                     v_btn_category_edit.ladda( 'start' );
                    var v_category_id=$("#txt_cat_id").val();
                    var v_category_name=$("#txt_cat_name").val();
  
    
                    if($.trim(v_category_id)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_category_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/category/category_controller.php",{action:'update_category',v_category_id:v_category_id,v_category_name:v_category_name}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_category_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_category_edit.ladda( 'stop' );
                                     swal("Success", "Category details updated successfully..", "success");
                                     
                                      $( '#btn_category_add' ).show();
                                      $( '#btn_category_edit' ).hide();
                                      $( '#btn_category_new' ).hide();
                                        $("#txt_cat_name").val('');
                                      load_data_to_grid_category();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_category_new' ).click(function(){
                  
                  $( '#btn_category_add' ).show();
                  $( '#btn_category_edit' ).hide();
                  $( '#btn_category_new' ).hide();
                  $("#txt_cat_name").val('');
                 
              })
                  
         

});