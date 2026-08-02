$(document).ready(function(){
  
  $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    var v_btn_location_add = $( '#btn_location_add' ).ladda();
                    var v_btn_location_edit = $( '#btn_location_edit' ).ladda();
                    var v_btn_location_new = $( '#btn_location_new' ).ladda();
                    
                    $("#btn_location_edit").hide();
                    $("#btn_location_new").hide();
                    location_list_table = $('#list_of_location').DataTable( {} );
                    load_data_to_grid_location();
                    
                     $('#txt_location_code').keydown(function (e) {
                       var k = e.which;
                        var ok = k >= 65 && k <= 90 || // A-Z
                            k >= 96 && k <= 105 || // a-z
                            k >= 35 && k <= 40 || // arrows
                            k == 8 || // Backspaces
                             k == 9 ||//Tab
                            k >= 48 && k <= 57; // 0-9
                
                        if (!ok){
                            e.preventDefault();
                        }        
                    });
                    
                     $('#txt_location_code').change(function (e) {
                        var v_location_code_test=$("#txt_location_code").val();
                         $.post("../controller/location/location_controller.php",{action:'check_location_code',v_location_code:v_location_code_test }
                                , function(result,status)
                                {
                                   
                              
                               
                                if(result==1)
                                {
                                    v_btn_location_add.ladda( 'stop' );
                                     swal("Warning", "Location code already exist..", "warning");
                                   $("#txt_location_code").val('');
                                }
                                else 
                                {
                                    return true;
                                }
                                
                                 
                            
                        });
                        
                    });
                    
                    
           
                v_btn_location_add.click(function(){
                    
                    v_btn_location_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_location_name=$("#txt_location_name").val();
                  var v_location_code=$("#txt_location_code").val();
                  
                  
                    if($.trim(v_location_name)===""||$.trim(v_location_code)==="")
                    
                    {
                        swal("Warning","Please provide location details ....", "warning");
                        v_btn_location_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/location/location_controller.php",{action:'add_location',location_name:v_location_name,v_location_code:v_location_code }
                                , function(result,status)
                                {
                                   console.log(result);
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='L')
                                {
                                    v_btn_location_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_location_add.ladda( 'stop' );
                                     swal("Success", "New location added successfully..", "success");
                                     
                                    load_data_to_grid_location();
                                    $("#txt_location_name").val('');
                                     $("#txt_location_code").val('');
                                     
                                     $.ajax({
                                    		type: "POST",
                                    		url: "../view/amc/select_location.php"
                                    		 
                                    		 }).done(function(data){
                
                                    			$("#div_cust_location").html(data);
                								$("#select_location_for_customer_location").select2();
                						});
                						
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
        
        
        function load_data_to_grid_location()
                 {
                    var i=1;
                    location_list_table.destroy();
                         
                     location_list_table = $('#list_of_location').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/location/location_controller.php',
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
            				"bFilter": false,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                  { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "location_id","visible":false },
                                 { "data": "location_name" },
                                 { "data": "location_code" },
                                 { "data": "location_status",
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
                                    "data": "location_id",
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
                                //  { "data": "location_id",
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
                                //  { "data": "location_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_location" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4] }, 
            					
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
                 
                 
          $('#list_of_location tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = location_list_table.row($row).data();
                        v_location_id  = data.location_id;
                        v_location_status  = data.location_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
            			 $("#txt_location_id").val(v_location_id);  
                         $("#txt_location_name").val(data.location_name);
                          $("#txt_location_code").val(data.location_code);
            			    $( '#btn_location_add').hide();
                            $( '#btn_location_edit').show();
                            $( '#btn_location_new').show();
               
            			 }  
                        
                         if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_location_action=$(this).attr("name");
                             v_location_action=v_location_action.split("_");  
                             $.post("../controller/location/location_controller.php",{action:'change_location_status',v_location_id:v_location_id,v_location_status:v_location_status,v_location_action:v_location_action[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_location();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
       v_btn_location_edit.click(function(){
                      
                 
                     v_btn_location_edit.ladda( 'start' );
                    var v_location_id=$("#txt_location_id").val();
                    var v_location_name=$("#txt_location_name").val();
                     var v_location_code=$("#txt_location_code").val();
    
                    if($.trim(v_location_id)===""||$.trim(v_location_code)==="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_location_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/location/location_controller.php",{action:'update_location',v_location_id:v_location_id,location_name:v_location_name,v_location_code:v_location_code}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='L')
                                {
                                    v_btn_location_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_location_edit.ladda( 'stop' );
                                     swal("Success", " location details updated successfully..", "success");
                                     
                                      $( '#btn_location_add' ).show();
                                      $( '#btn_location_edit' ).hide();
                                      $( '#btn_location_new' ).hide();
                                        $("#txt_location_name").val('');
                                        $("#txt_location_code").val('');
                                      load_data_to_grid_location();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
      $( '#btn_location_new' ).click(function(){
                  
                  $( '#btn_location_add' ).show();
                  $( '#btn_location_edit' ).hide();
                  $( '#btn_location_new' ).hide();
                  $("#txt_location_name").val('');
                 $("#txt_location_code").val('');
              })
                  
         

});