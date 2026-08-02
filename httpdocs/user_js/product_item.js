$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
  var v_product_category_id, v_product_category_name,v_product_type_id,v_product_type_name,v_product_item_name,v_product_item_id,v_product_item_status,product_type_id_combo;
                  
                    $('#btn_product_item_edit').hide();
                    $('#btn_product_item_new').hide();
                    $('#div_list_product_type').hide();
                     
                     
                    var v_btn_product_item_add = $('#btn_product_item_add').ladda();
                    var v_btn_product_item_edit = $('#btn_product_item_edit').ladda();
                    var v_btn_product_item_new = $('#btn_product_item_new').ladda();

                    var v_list_of_product_item_table = $('#list_of_product_item').DataTable({});
                     load_data_to_grid_product_item_details_list();
                      
                      //asset typr load on category change
                    
                    $('#select_product_category_for_item').bind('change',function() {
                        
                       load_div_for_product_type_bind();
                        
                    });
                         
                         function load_div_for_product_type_bind()
                         {
                             
                              v_prdt_category_id=$("#select_product_category_for_item option:selected").val();
                             $.ajax({
                    		type: "POST",
                    		url: "product_item/product_type_combo.php",
                    		data: { v_prdt_category_id : v_prdt_category_id } 
                    		 }).done(function(data){
                    		     
                    			 $('#div_list_product_type').show();
                    			$("#div_list_product_type").html(data);
                    			$("#select_product_type_for_item").select2();
                    		    if(v_product_item_id!=='')
                            	{
                                    
                                	$("#select_product_type_for_item").val(product_type_id_combo).trigger("change");
                            	}
                    		 });
                         }
                         //Product item insert details
                    v_btn_product_item_add.click(function(){
                                v_btn_product_item_add.ladda( 'start' );
                                v_product_category_id=$("#select_product_category_for_item option:selected").val();
                                v_product_category_name=$("#select_product_category_for_item option:selected").text();
                                v_product_type_id=$("#select_product_type_for_item option:selected").val();
                                v_product_type_name=$("#select_product_type_for_item option:selected").text();
                                v_product_item_name=$("#txt_product_item_name").val();
                                 
                                if($.trim(v_product_item_name)==""||$.trim(v_product_category_name) == ""|| $.trim(v_product_type_name)== ""||$.trim(v_product_type_name)== "SELECT PRODUCT TYPE")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_product_item_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/product_item/product_item_controller.php",{action:'add_product_item',v_product_category_id:v_product_category_id,v_product_category_name:v_product_category_name,v_product_type_id:v_product_type_id,v_product_type_name:v_product_type_name,v_product_item_name:v_product_item_name}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_product_item_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_product_item_add.ladda( 'stop' );
                                                 swal("Success", "New Service added successfully..", "success");
                                                 load_data_to_grid_product_item_details_list();
                                                 clear_text();
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                    
                    //load data to product item datatable
                    function load_data_to_grid_product_item_details_list()
                     {
                    v_list_of_product_item_table.destroy();
                     v_list_of_product_item_table = $('#list_of_product_item').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/product_item/product_item_controller.php',
                                 'data': {
                                    action: 'product_item_list_view'
                                    
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
                                 { "data": "product_item_id","visible":false },
                                 { "data": "product_category_id","visible":false },
                                 
                                 { "data": "product_category_name" },
                                 { "data": "product_type_id","visible":false },
                                 { "data": "product_type_name"},
                                 { "data": "product_item_name"},
                                 { "data": "item_status",
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
                                 { "data": "product_item_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_product_item" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
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
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
                    $('#list_of_product_item tbody').on('click', 'a', function(){
                       $('#div_list_product_type').show();
                        var $row = $(this).closest('tr');
                        var product_item_data = v_list_of_product_item_table.row($row).data();
                        v_product_item_id  = product_item_data.product_item_id;
                         v_product_item_status  = product_item_data.item_status;
                         if($(this).attr("name")=='Edit_product_item')
                         {
                         
                            edit_product_item_details(v_product_item_id);
            			    $( '#btn_product_item_add').hide();
                            $( '#btn_product_item_edit').show();
                            $( '#btn_product_item_new').show();
               
            			 }
            			 
            			  function edit_product_item_details(v_product_item_id)
                            {
                                $("#txt_product_item_id").val(v_product_item_id);  
                                $("#txt_product_item_name").val(product_item_data.product_item_name);
                                product_type_id_combo=product_item_data.product_type_id
                                
                                 $("#select_product_category_for_item").val(product_item_data.product_category_id).trigger("change");
                                 
                                
                            }
                            
                             if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_product_item_action=$(this).attr("name");
                             $.post("../controller/product_item/product_item_controller.php",{action:'change_product_item_status',v_product_item_id:v_product_item_id,v_product_item_status:v_product_item_status,v_product_item_action:v_product_item_action}
                                , function(result,status)
                                {
                                   //alert(result);
                                   load_data_to_grid_product_item_details_list();
                                
                            });
                        }
                          
                        
        });
                     //edit click
                    v_btn_product_item_edit.click(function(){
                            v_btn_product_item_edit.ladda( 'start' );
                            var v_product_item_id=$("#txt_product_item_id").val(); 
                                v_product_category_id=$("#select_product_category_for_item option:selected").val();
                                v_product_category_name=$("#select_product_category_for_item option:selected").text();
                                v_product_type_id=$("#select_product_type_for_item option:selected").val();
                                v_product_type_name=$("#select_product_type_for_item option:selected").text();
                                v_product_item_name=$("#txt_product_item_name").val();
                               // alert(v_product_item_name);
                            if($.trim(v_product_item_name)==""||$.trim(v_product_category_name) == ""|| $.trim(v_product_type_name)== ""||$.trim(v_product_type_name)== "SELECT PRODUCT TYPE")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_product_item_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/product_item/product_item_controller.php",{action:'update_product_item',v_product_category_id:v_product_category_id,v_product_category_name:v_product_category_name,v_product_type_id:v_product_type_id,v_product_type_name:v_product_type_name,v_product_item_name:v_product_item_name,v_product_item_id:v_product_item_id}
                                        , function(result,status)
                                        {
                                            result = $.trim(result);
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_product_item_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_product_item_edit.ladda( 'stop' );
                                                 swal("Success", " Product item details updated successfully..", "success");
                                                 load_data_to_grid_product_item_details_list();
                                                 clear_text();
                                            }
                                        });
                                
                             }
                          
                });  
                    
                    $( '#btn_product_item_new' ).click(function(){
                  
                        $( '#btn_product_item_add' ).show();
                        $( '#btn_product_item_edit' ).hide();
                        $( '#btn_product_item_new' ).hide();
                        clear_text();
                    })
                    
                    //function clear text
                   function clear_text()
                 {
                    $("#select_product_category_for_item").val(null).trigger("change");
                    $("#select_product_type_for_item").val(null).trigger("change");
                    $("#txt_product_item_name").val('');
                    $("#txt_service_id").val('');
                    
                 }
                  

});