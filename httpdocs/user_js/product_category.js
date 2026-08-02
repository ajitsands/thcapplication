$(document).ready(function(){
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
    var v_product_type_id,v_product_type_name,v_product_type_status;
  
                    var v_btn_product_category_add = $('#btn_product_category_add').ladda();
                    var v_btn_product_category_edit = $('#btn_product_category_edit').ladda();
                    var v_btn_product_category_new = $('#btn_product_category_new').ladda();
                    
                    var v_btn_prdt_type_add = $('#btn_prdt_type_add').ladda();
                    var v_btn_prdt_type_edit = $('#btn_prdt_type_edit').ladda();
                    var v_btn_prdt_type_new = $('#btn_prdt_type_new').ladda();
                    
                    
                    $("#btn_product_category_edit").hide();
                    $("#btn_product_category_new").hide();
                    
                    $("#btn_prdt_type_edit").hide();
                    $("#btn_prdt_type_new").hide();
                    
                    product_category_list_table = $('#list_of_prdt_category').DataTable( {} );
                    load_data_to_grid_product_category();
                    
                    product_category_type_list_table = $('#list_of_prdt_category_type').DataTable( {} );
                    load_data_to_grid_product_category_type();
            // Insert product_category details....
 
                v_btn_product_category_add.click(function(){
                    
                    v_btn_product_category_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_product_category_name=$("#txt_product_category_name").val();
                  
                    if($.trim(v_product_category_name)=="")
                    
                    {
                        swal("Warning","Please provide product category name ....", "warning");
                        v_btn_product_category_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/product/product_category_controller.php",{action:'add_product_category',v_product_category_name:v_product_category_name }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_product_category_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_product_category_add.ladda( 'stop' );
                                     swal("Success", "New product category added successfully..", "success");
                                     
                                    load_data_to_grid_product_category();
                                    $("#txt_product_category_name").val('');
                                    location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
        
        
                function load_data_to_grid_product_category()
                 {
                     
                    product_category_list_table.destroy();
                         
                     product_category_list_table = $('#list_of_product_category').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/product/product_category_controller.php',
                                 'data': {
                                    action: 'list_product_category'
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
                               
                                 { "data": null},
                                 { "data": "product_category_id","visible":false },
                                 { "data": "product_category_name" },
                                 { "data": "product_category_status",
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
                                 { "data": "product_category_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_product_category" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 5,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
                $('#list_of_product_category tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = product_category_list_table.row($row).data();
                        v_product_category_id  = data.product_category_id;
                        v_product_category_status  = data.product_category_status;
                         if($(this).attr("name")=='Edit_product_category')
                         {
                        
            			 $("#txt_product_category_id").val(v_product_category_id);  
                         $("#txt_product_category_name").val(data.product_category_name);
                         
            			    $( '#btn_product_category_add').hide();
                            $( '#btn_product_category_edit').show();
                            $( '#btn_product_category_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_product_cate_action=$(this).attr("name");
                             $.post("../controller/product/product_category_controller.php",{action:'change_product_category_status',v_product_category_id:v_product_category_id,v_product_category_status:v_product_category_status,v_product_cate_action:v_product_cate_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_product_category();
                                
                            });
                        }
                          
                
                        
        });
                 
                 
                 v_btn_product_category_edit.click(function(){
                      
                 
                     v_btn_product_category_edit.ladda( 'start' );
                     v_product_category_id=$("#txt_product_category_id").val();
                    var v_product_category_name=$("#txt_product_category_name").val();
   //alert(v_product_category_id);
    
                    if($.trim(v_product_category_id)=="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_product_category_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/product/product_category_controller.php",{action:'update_product_category',v_product_category_id:v_product_category_id,v_product_category_name:v_product_category_name}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_product_category_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_product_category_edit.ladda( 'stop' );
                                     swal("Success", " Product Category details updated successfully..", "success");
                                     
                                      $( '#btn_product_category_add' ).show();
                                      $( '#btn_product_category_edit' ).hide();
                                      $( '#btn_product_category_new' ).hide();
                                        $("#txt_product_category_name").val('');
                                      load_data_to_grid_product_category();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
                 $( '#btn_product_category_new' ).click(function(){
                  
                  $( '#btn_product_category_add' ).show();
                  $( '#btn_product_category_edit' ).hide();
                  $( '#btn_product_category_new' ).hide();
                  $("#txt_product_category_name").val('');
                 
                })
                
                $( '#btn_prdt_type_new' ).click(function(){
                  
                  $( '#btn_prdt_type_add' ).show();
                  $( '#btn_prdt_type_edit' ).hide();
                  $( '#btn_prdt_type_new' ).hide();
                  
                  $("#select_product_category").val(null).trigger("change");
                  $("#txt_product_type").val('');
                 
                })
                  
         //insert product type details
         
          v_btn_prdt_type_add.click(function(){
                    
                    v_btn_prdt_type_add.ladda( 'start' );
                    
					var v_prdt_category_id=$("#select_product_category option:selected").val();
                    var v_prdt_category_name=$("#select_product_category option:selected").text()
                    var v_product_name=$("#txt_product_type").val();
                    if($.trim(v_product_name)==""||v_prdt_category_name=="" )
                    
                    {
                        swal("Warning","Please provide all field....", "warning");
                        v_btn_prdt_type_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/product/product_type_controller.php",{action:'add_product_type',v_prdt_category_id:v_prdt_category_id,v_prdt_category_name:v_prdt_category_name,v_product_name:v_product_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_prdt_type_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_prdt_type_add.ladda( 'stop' );
                                     swal("Success", "New product type added successfully..", "success");
                                     
                                    load_data_to_grid_product_category_type();
                                    $("#txt_product_type").val('');
									$("#select_product_category").val(null).trigger("change");
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
            
            
            //load datatable
             function load_data_to_grid_product_category_type()
                 {
                     
                    product_category_type_list_table.destroy();
                         
                     product_category_type_list_table = $('#list_of_prdt_category_type').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/product/product_type_controller.php',
                                 'data': {
                                    action: 'list_product_type'
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
                               
                                 { "data": null},
                                 { "data": "product_type_id","visible":false },
                                 { "data": "product_category_name" },
                                  { "data": "product_type_name" },
                                 { "data": "product_type_status",
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
                                 { "data": "product_type_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_product_category_type" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 5,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
                 $('#list_of_prdt_category_type tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var product_type_data = product_category_type_list_table.row($row).data();
                        v_product_type_id  = product_type_data.product_type_id;
                        v_product_type_status  = product_type_data.product_type_status;
                         if($(this).attr("name")=='Edit_product_category_type')
                         {
                         
            			 $("#txt_product_category_type_id").val(v_product_type_id);  
                         $("#txt_product_type").val(product_type_data.product_type_name);
                          $("#select_product_category").val(product_type_data.product_category_id).trigger("change");
            			    $( '#btn_prdt_type_add').hide();
                            $( '#btn_prdt_type_edit').show();
                            $( '#btn_prdt_type_new').show();
               
            			 }
                        
                         if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_product_cate_type_action=$(this).attr("name");
                             $.post("../controller/product/product_type_controller.php",{action:'change_product_type_status',v_product_type_id:v_product_type_id,v_product_type_status:v_product_type_status,v_product_cate_type_action:v_product_cate_type_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_product_category_type();
                                
                            });
                        }
                          
                
                        
        });
        
         v_btn_prdt_type_edit.click(function(){
                      
                 
                     v_btn_prdt_type_edit.ladda( 'start' );
                   	var v_prdt_category_id=$("#select_product_category option:selected").val();
                    var v_prdt_category_name=$("#select_product_category option:selected").text()
                    var v_product_name=$("#txt_product_type").val();
                    
					var v_prdt_type_id=$("#txt_product_category_type_id").val();
  
    
                    if($.trim(v_product_name)==""||v_prdt_category_name=="" )
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_prdt_type_edit.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/product/product_type_controller.php",{action:'update_product_type',v_product_type_id:v_prdt_type_id,v_product_name:v_product_name,v_prdt_category_name:v_prdt_category_name,v_prdt_category_id:v_prdt_category_id}
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_prdt_type_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                     v_btn_prdt_type_edit.ladda( 'stop' );
                                     swal("Success", "Product type details updated successfully..", "success");
                                     
                                      $( '#btn_prdt_type_add' ).show();
                                      $( '#btn_prdt_type_edit' ).hide();
                                      $( '#btn_prdt_type_new' ).hide();
                                      $("#txt_product_type").val('');
								      $("#select_product_category").val(null).trigger("change");
                                      load_data_to_grid_product_category_type();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
            
                   
                });
                 
                 
});