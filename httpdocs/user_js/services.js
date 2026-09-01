$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
  var asset_type_name, v_category_type_id,v_category_type_name,v_category_asset_type_id,v_category_asset_type_name,v_service_desc,v_service_id;
                  
                    $('#btn_services_edit').hide();
                    $('#btn_services_new').hide();
                    $('#div_list_asset_type').hide();
                     
                     
                    var v_btn_services_add = $('#btn_services_add').ladda();
                    var v_btn_services_edit = $('#btn_services_edit').ladda();
                    var v_btn_services_new = $('#btn_services_new').ladda();

                    var v_list_of_services_table = $('#list_of_services').DataTable({});
                    // $(document).on('init.dt', function () {
                    //     $('#list_of_services_filter input[type="search"]').attr('autocomplete', 'off');
                    // });

                    load_data_to_grid_services_details_list();
                      
                      //asset typr load on category change
                    
                    $('#select_category_type_for_service').bind('change',function() {
                        
                       load_div_for_asset_bind();
                        
                    });
                         
                          function load_div_for_asset_bind()
                          {
                              v_category_type_id=$("#select_category_type_for_service option:selected").val();
                              if(v_category_type_id && v_category_type_id !== 'select' && v_category_type_id !== '') {
                                  $.ajax({
                         		      type: "POST",
                         		      url: "services/category_asset_type.php",
                         		      data: { v_category_type_id : v_category_type_id } 
                         		  }).done(function(data){
                         		      $('#div_employee_select').removeClass('col-lg-6 col-md-6').addClass('col-lg-4 col-md-4');
                         		      $('#div_list_asset_type').removeClass('col-lg-6 col-md-6').addClass('col-lg-4 col-md-4').show();
                         		      $('#div_service_input').removeClass('col-lg-6 col-md-6').addClass('col-lg-4 col-md-4');
                         		      $("#div_list_asset_type").html(data);
                         		      $("#select_asset_type_for_service").select2();
                         		      if(v_service_id!=='')
                                      {
                                          $("#select_asset_type_for_service option:selected").val(asset_type_name);
                                          $('#select_asset_type_for_service option').map(function () {
                                              if ($(this).val() == asset_type_name) return this;
                                          }).attr('selected', 'selected');
                                          $("#select_asset_type_for_service").select2().trigger('change');
                                      }
                         		  });
                              } else {
                                  $('#div_employee_select').removeClass('col-lg-4 col-md-4').addClass('col-lg-6 col-md-6');
                                  $('#div_list_asset_type').hide().html('');
                                  $('#div_service_input').removeClass('col-lg-4 col-md-4').addClass('col-lg-6 col-md-6');
                              }
                          }
                         //service insert details
                    v_btn_services_add.click(function(){
                                v_btn_services_add.ladda( 'start' );
                                v_category_type_id=$("#select_category_type_for_service option:selected").val();
                                v_category_type_name=$("#select_category_type_for_service option:selected").text();
                                v_category_asset_type_id=$("#select_asset_type_for_service option:selected").val();
                                v_category_asset_type_name=$("#select_asset_type_for_service option:selected").text();
                                v_service_desc=$("#txt_service_desc").val();
                                 
                                if($.trim(v_service_desc)==""||typeof v_category_type_id === "undefined"|| typeof v_category_asset_type_id === "undefined")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_services_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/services/service_controller.php",{action:'add_service',v_category_type_id:v_category_type_id,v_category_type_name:v_category_type_name,v_category_asset_type_id:v_category_asset_type_id,v_category_asset_type_name:v_category_asset_type_name,v_service_desc:v_service_desc}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_services_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_services_add.ladda( 'stop' );
                                                 swal("Success", "New Service added successfully..", "success");
                                                 load_data_to_grid_services_details_list();
                                                 clear_text();
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                    
                    //load data to service datatable
                    function load_data_to_grid_services_details_list()
                     {
                         var i=1;
                    v_list_of_services_table.destroy();
                     v_list_of_services_table = $('#list_of_services').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/services/service_controller.php',
                                 'data': {
                                    action: 'service_list_view'
                                    
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
                                 { "data": "service_id","visible":false },
                                 { "data": "category_id","visible":false },
                                 { "data": "category_name" },
                                 { "data": "asset_type_id","visible":false },
                                 { "data": "asset_type_name"},
                                 { "data": "service_description"},
                                 { "data": "service_status",
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
                                    "data": "service_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "ServicesModify": "Edit",
                                            "ServicesModify": "Active",
                                            "ServicesModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="ServicesModify")
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
                                
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
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
                 
                 
                    $('#list_of_services tbody').on('click', 'a', function(){
                       $('#div_list_asset_type').show();
                        var $row = $(this).closest('tr');
                        var service_data = v_list_of_services_table.row($row).data();
                        v_service_id  = service_data.service_id;
                         v_service_status  = service_data.service_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
                            edit_service_details(v_service_id);
            			    $( '#btn_services_add').hide();
                            $( '#btn_services_edit').show();
                            $( '#btn_services_new').show();
               
            			 }
            			 
            			  function edit_service_details(v_service_id)
                            {
                                $("#txt_service_id").val(v_service_id);  
                                $("#txt_service_desc").val(service_data.service_description);
                                asset_type_name=service_data.asset_type_id
                                
                                 $("#select_category_type_for_service").val(service_data.category_id).trigger("change");
                              $("#select_asset_type_for_service").val(service_data.asset_type_id).trigger("change");
                                
                                
                               
                            }
                            
                             if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_services_action=$(this).attr("name");
                             v_services_action = v_services_action.split("_");
                             $.post("../controller/services/service_controller.php",{action:'change_service_status',v_service_id:v_service_id,v_service_status:v_service_status,v_services_action:v_services_action[1]}
                                , function(result,status)
                                {
                                   //alert(result);  
                                   load_data_to_grid_services_details_list();
                                
                            });
                        }
                          
                        
        });
                     //edit click
                    v_btn_services_edit.click(function(){
                            v_btn_services_edit.ladda( 'start' );
                            var v_service_id=$("#txt_service_id").val(); 
                            v_category_type_id=$("#select_category_type_for_service option:selected").val();
                            v_category_type_name=$("#select_category_type_for_service option:selected").text();
                            v_category_asset_type_id=$("#select_asset_type_for_service option:selected").val();
                            v_category_asset_type_name=$("#select_asset_type_for_service option:selected").text();
                            v_service_desc=$("#txt_service_desc").val();
                            if($.trim(v_service_desc)==""||typeof v_category_type_id === "undefined"|| typeof v_category_asset_type_id === "undefined")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_services_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/services/service_controller.php",{action:'update_service',v_category_type_id:v_category_type_id,v_category_type_name:v_category_type_name,v_category_asset_type_id:v_category_asset_type_id,v_category_asset_type_name:v_category_asset_type_name,v_service_desc:v_service_desc,v_service_id:v_service_id}
                                        , function(result,status)
                                        {
                                            result = $.trim(result);
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_services_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_services_edit.ladda( 'stop' );
                                                 swal("Success", " Service details updated successfully..", "success");
                                                 load_data_to_grid_services_details_list();
                                                 clear_text();
                                            }
                                        });
                                
                             }
                          
                });  
                    
                    $( '#btn_services_new' ).click(function(){
                  
                        $( '#btn_services_add' ).show();
                        $( '#btn_services_edit' ).hide();
                        $( '#btn_services_new' ).hide();
                        clear_text();
                    })
                    
                    //function clear text
                    function clear_text()
                    {
                        $("#select_category_type_for_service").val(null).trigger("change");
                        $("#select_asset_type_for_service").val(null).trigger("change");
                        $("#txt_service_desc").val('');
                        $("#txt_service_id").val('');
                        $('#div_employee_select').removeClass('col-lg-4 col-md-4').addClass('col-lg-6 col-md-6');
                        $('#div_list_asset_type').hide().html('');
                        $('#div_service_input').removeClass('col-lg-4 col-md-4').addClass('col-lg-6 col-md-6');
                    }
                  

});