$(document).ready(function(){
  
        $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    var v_btn_asset_type_add = $('#btn_asset_type_add').ladda();
                    var v_btn_asset_type_edit = $('#btn_asset_type_edit').ladda();
                    var v_btn_asset_type_new = $('#btn_asset_type_new').ladda();
                    
                    $("#btn_asset_type_edit").hide();
                    $("#btn_asset_type_new").hide();
                    asset_type_list_table = $('#list_of_asset_type').DataTable( {} );
					load_data_to_grid_asset_type();
            // Insert expertise details....
 
                v_btn_asset_type_add.click(function(){
                    
                    v_btn_asset_type_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
					var v_category_id=$("#select_category option:selected").val();
                    var v_category_name=$("#select_category option:selected").text()
                    var v_asset_name=$("#txt_asset_name").val();
					
                  
                    if($.trim(v_asset_name)==""||v_category_id=="select" )
                    
                    {
                        swal("Warning","Please provide all field....", "warning");
                        v_btn_asset_type_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/asset_type/asset_type_controller.php",{action:'add_asset_type',v_category_id:v_category_id,v_category_name:v_category_name,v_asset_name:v_asset_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_asset_type_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_asset_type_add.ladda( 'stop' );
                                     swal("Success", "New asset type added successfully..", "success");
                                     
                                    load_data_to_grid_asset_type();
                                    $("#txt_asset_name").val('');
									$("#select_category").val(null).trigger("change");
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
        
        
       function load_data_to_grid_asset_type()
                 {
                     var i=1;
                   asset_type_list_table.destroy();
                         
                       asset_type_list_table = $('#list_of_asset_type').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/asset_type/asset_type_controller.php',
                                 'data': {
                                    action: 'list_asset_type'
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                         "columns": [
                               
                                 { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "asset_type_id","visible":false },
                                 { "data": "asset_type_name" },								
								 { "data": "category_name" },
                                 { "data": "asset_type_status",
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
                                    "data": "asset_type_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "AssetTypeModify": "Edit",
                                            "AssetTypeModify": "Active",
                                            "AssetTypeModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="AssetTypeModify")
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
                                //  { "data": "asset_type_id",
                                //       render: function ( data, type, rows, meta ) {
                                //         var dropdownOptions = {
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
                                //  { "data": "asset_type_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Asset_Type" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
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
                 
                 
          $('#list_of_asset_type tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = asset_type_list_table.row($row).data();
                        v_asset_id  = data.asset_type_id;
                        v_asset_type_status  = data.asset_type_status;
						//v_category_id  = data.category_id;
                        //v_category_name  = data.category_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
            			 $("#txt_asset_id").val(v_asset_id);  
                         $("#txt_asset_name").val(data.asset_type_name);
						 
						 						
                        //  $('#select_category option').map(function () {
                        //  if ($(this).val() == $.trim(data.category_id)) return this;
                        //  }).attr('selected', 'selected') ;
                        // $("#select_category").select2().trigger('change');
                         
                         $("#select_category").val(data.category_id).trigger("change");
						 
						 
                         //$("#txt_asset_name").val(data.asset_type_name);
                         
            			    $( '#btn_asset_type_add').hide();
                            $( '#btn_asset_type_edit').show();
                            $( '#btn_asset_type_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_action_status=$(this).attr("name");
                             v_action_status=v_action_status.split("_");
                             $.post("../controller/asset_type/asset_type_controller.php",{action:'change_asset_type_status',v_asset_id:v_asset_id,v_asset_status:v_asset_type_status,v_action_status:v_action_status[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_asset_type();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_asset_type_edit.click(function(){
                      
                 
                     v_btn_asset_type_edit.ladda( 'start' );
                    var v_category_id=$("#select_category option:selected").val();
                    var v_category_name=$("#select_category option:selected").text()
                    var v_asset_name=$("#txt_asset_name").val();
					var v_asset_id=$("#txt_asset_id").val();
  
    
                    if($.trim(v_asset_name)==""||v_category_name=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_asset_type_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/asset_type/asset_type_controller.php",{action:'update_asset_type',v_category_id:v_category_id,v_category_name:v_category_name,v_asset_name:v_asset_name,v_asset_id:v_asset_id}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_asset_type_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_asset_type_edit.ladda( 'stop' );
                                     swal("Success", "Asset type details updated successfully..", "success");
                                     
                                      $( '#btn_asset_type_add' ).show();
                                      $( '#btn_asset_type_edit' ).hide();
                                      $( '#btn_asset_type_new' ).hide();
                                      $("#txt_asset_name").val('');
								      $("#select_category").val(null).trigger("change");
                                      load_data_to_grid_asset_type();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_asset_type_new' ).click(function(){
                  
                  $( '#btn_asset_type_add' ).show();
                  $( '#btn_asset_type_edit' ).hide();
                  $( '#btn_asset_type_new' ).hide();
                  $("#txt_asset_name").val('');
				  $("#select_category").val(null).trigger("change");
                 
              })
                  
         

});