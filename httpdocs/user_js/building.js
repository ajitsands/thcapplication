$(document).ready(function(){
  var asset_type_name, v_category_type_id,v_category_type_name,v_category_asset_type_id,v_category_asset_type_name,v_service_desc,v_service_id;
                  
        
                  
                    $('#btn_building_edit').hide();
                    $('#btn_building_new').hide();
 
                    var v_btn_building_add = $('#btn_building_add').ladda();
                    var v_btn_building_edit = $('#btn_building_edit').ladda();
                    var v_btn_building_new = $('#btn_building_new').ladda();

                    var v_list_of_building_table = $('#list_of_building').DataTable({});
                     load_data_to_grid_building_details_list();
                 
                       //check whether the building code is unique
					   
					   	$("#txt_building_code").blur(function(){
							
							var v_building_code=$("#txt_building_code").val();
							
							 $.post("../controller/building/building_controller.php",{action:'check_building_code',v_building_code:v_building_code}
									, function(result,status)
							 { 
								var obj = jQuery.parseJSON(result);
								 if(obj.length==0)
								{
									return true;
								}
								else
								{
									
									swal("Warning","Building code is already exisited", "warning");
									$("#txt_building_code").val('');
									return false;
								}

							 });
							
						});
							   
					   
					   
					   //end check



					   
                         //service insert details
                    v_btn_building_add.click(function(){
                                v_btn_building_add.ladda( 'start' );
								v_building_name=$("#txt_building_name").val();
							//	v_building_code=$("#txt_building_code").val();
								v_building_address=$("#txt_building_address").val();
								v_building_address='NA';
                                 
                                if($.trim(v_building_name)==""||$.trim(v_building_address)=="")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_building_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/building/building_controller.php",{action:'add_building',v_building_name:v_building_name,v_building_address:v_building_address}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_building_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                //start--update building code
                                                
                                                    if(result>=1 && result<=9)
                    								{
                    									 v_building_code= 'F000'+result;
                    								}
                    								if(result>=10 && result<=99)
                    								{
                    									v_building_code= 'F00'+result;
                    								}
                    								if(result>=100 && result<=999)
                    								{
                    									v_building_code= 'F0'+result;
                    								}
                    								if(result>=1000 )
                    								{
                    									v_building_code= 'F'+result;
                    								}
                    								
                    								//console.log(v_customer_code);
                    													
                    								 $.post("../controller/building/building_controller.php",{action:'update_building_code',v_building_code:v_building_code,v_building_id:result}					
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
                                                                     v_btn_building_add.ladda( 'stop' );
                                                                     swal("Success", "New building added successfully..", "success");
                                                                     load_data_to_grid_building_details_list();
                                                                     clear_text();
                                                                     $.ajax({
                                                            		type: "POST",
                                                            		url: "../view/amc/select_building.php"
                                                            		 
                                                            		 }).done(function(data){
                                        
                                                            			$("#div_cust_building").html(data);
                                        								$("#select_building_for_location").select2();
                        						                    });
                                                                }
                                                                
                                                                 
                                                            
                                                          });
                                                
                                                //end
                                                 
                                                 
                                                 
                						
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                    
                    //load data to service datatable
                    function load_data_to_grid_building_details_list()
                     {
                         var i=1;
                    v_list_of_building_table.destroy();
                     v_list_of_building_table = $('#list_of_building').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/building/building_controller.php',
                                 'data': {
                                    action: 'list_building'
                                    
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
								 { "data": "building_id","visible":false },
                                 { "data": "building_code" },
                                 { "data": "building_name"},
                                 { "data": "building_address","visible":false},
                                 { "data": "building_status",
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
                                    "data": "building_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "LocationAndFacilitiesModify": "Edit",
                                            "LocationAndFacilitiesModify": "Active",
                                            "LocationAndFacilitiesModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="LocationAndFacilitiesModify")
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
                                //  { "data": "building_id",
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
                                 
                                //  { "data": "building_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_building" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                                
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],

                             "initComplete": function( settings, json ) {
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
                    $('#list_of_building tbody').on('click', 'a', function(){
                      
                        var $row = $(this).closest('tr');
                        var building_data = v_list_of_building_table.row($row).data();
                        v_building_id  = building_data.building_id;
                         v_building_status  = building_data.building_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
                            edit_building_details(v_building_id);
            			    $( '#btn_building_add').hide();
                            $( '#btn_building_edit').show();
                            $( '#btn_building_new').show();
               
            			 }
            			 
            			  function edit_building_details(v_building_id)
                            {
                                $("#txt_building_id").val(v_building_id);  
                                $("#txt_building_name").val(building_data.building_name);
								$("#txt_building_code").val(building_data.building_code);
								$("#txt_building_address").val(building_data.building_address);
                                
                            }
                            
                         if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_building_action=$(this).attr("name");
                             v_building_action=v_building_action.split("_");
                             $.post("../controller/building/building_controller.php",{action:'change_building_status',v_building_id:v_building_id,v_building_status:v_building_status,v_building_action:v_building_action[1]}
                                , function(result,status)
                                {
                                   //alert(result);
                                   load_data_to_grid_building_details_list();
                                
                            });
                        }
                          
                        
        });
                     //edit click
                    v_btn_building_edit.click(function(){
                            v_btn_building_edit.ladda( 'start' );
                            var v_building_id=$("#txt_building_id").val(); 
							var v_building_name=$("#txt_building_name").val();
							var v_building_code=$("#txt_building_code").val();
							var v_building_address=$("#txt_building_address").val();
                            if($.trim(v_building_name)==""||$.trim(v_building_address)=="")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_building_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/building/building_controller.php",{action:'edit_building',v_building_id:v_building_id,v_building_name:v_building_name,v_building_code:v_building_code,v_building_address:v_building_address}
                                        , function(result,status)
                                        {
                                            result = $.trim(result);
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_building_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_building_edit.ladda( 'stop' );
                                                 swal("Success", " Building details updated successfully..", "success");
                                                 load_data_to_grid_building_details_list();
                                                 clear_text();
                                            }
                                        });
                                
                             }
                          
                });  
                    
                    $( '#btn_building_new' ).click(function(){
                  
                        $( '#btn_building_add' ).show();
                        $( '#btn_building_edit' ).hide();
                        $( '#btn_building_new' ).hide();
                        clear_text();
                    })
                    
                    //function clear text
                   function clear_text()
                 {
                    $("#txt_building_name").val('');
                    $("#txt_building_code").val('');
                    $("#txt_building_address").val('');
                 }
                  

});