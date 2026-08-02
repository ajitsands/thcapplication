$(document).ready(function(){
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
 // var v_product_category_id, v_product_category_name,v_product_type_id,v_product_type_name,v_product_master_name,v_product_master_id,v_product_master_status,product_type_id_combo;
 var v_product_master_id,v_product_master_status,product_type_id_combo_master,product_item_id_combo_master;
                  
                    $('#btn_product_master_edit').hide();
                    $('#btn_product_master_new').hide();
                    $('#div_list_product_type').hide();
                     
                     
                    var v_btn_product_master_add = $('#btn_product_master_add').ladda();
                    var v_btn_product_master_edit = $('#btn_product_master_edit').ladda();
                    var v_btn_product_master_new = $('#btn_product_master_new').ladda();

                    var v_list_of_product_master_table = $('#list_of_product_master').DataTable({});
                     load_data_to_grid_product_master_details_list();
                      
                      //asset typr load on category change
                    
                    $('#select_product_category_for_master').bind('change',function() {
                        
                       load_div_for_product_type_bind();
                        
                    });
                         
                         function load_div_for_product_type_bind()
                         {
                             
                             var v_prdt_category_id_master=$("#select_product_category_for_master option:selected").val();
                             $.ajax({
                    		type: "POST",
                    		url: "product_master/product_type_combo_master.php",
                    		data: { v_prdt_category_id_master : v_prdt_category_id_master } 
                    		 }).done(function(data){
                    		     
                    			 
                    			$("#div_list_product_type_master").html(data);
                    			$("#select_product_type_for_master").select2();
                    		    if(v_product_master_id!=='')
                            	{
                                    
                                	$("#select_product_type_for_master").val(product_type_id_combo_master).trigger("change");
                            	}
                    		 });
                         }
                         
                         
                        $("#div_list_product_type_master").change(function(){
                            //alert("jbf");
                               load_div_for_product_item_bind();
                            });
                            
                            function load_div_for_product_item_bind()
                         {
                             
                             var v_prdt_type_id_master=$("#select_product_type_for_master option:selected").val();
                             
                             $.ajax({
                    		type: "POST",
                    		url: "product_master/product_item_combo_master.php",
                    		data: { v_prdt_type_id_master : v_prdt_type_id_master } 
                    		 }).done(function(data){
                    		     
                    			 
                    			$("#div_list_product_item").html(data);
                    			$("#select_product_item_for_master").select2();
                    		    if(v_product_master_id!=='')
                            	{
                                    
                                	$("#select_product_item_for_master").val(product_item_id_combo_master).trigger("change");
                            	}
                    		 });
                         }
                         
                         //Product item insert details
                    v_btn_product_master_add.click(function(){
                                v_btn_product_master_add.ladda( 'start' );
                                var v_product_category_id_master=$("#select_product_category_for_master option:selected").val();
                                var v_product_category_name_master=$("#select_product_category_for_master option:selected").text();
                                var v_product_type_id_master=$("#select_product_type_for_master option:selected").val();
                                var v_product_type_name_master=$("#select_product_type_for_master option:selected").text();
                                var v_product_item_id_master=$("#select_product_item_for_master option:selected").val();
                                var v_product_item_name_master=$("#select_product_item_for_master option:selected").text();
                                var v_product_unit=$("#txt_product_unit").val();
                                var v_product_unit_rate=$("#txt_product_unit_rate").val();
                                var v_product_brand_name=$("#txt_product_brand_name").val();
                                 
                                 if($.trim(v_product_unit_rate)==""||$.trim(v_product_brand_name)==""||$.trim(v_product_category_id_master) == ""|| $.trim(v_product_type_id_master) == ""|| $.trim(v_product_item_id_master) == ""||$.trim(v_product_item_name_master)=="SELECT PRODUCT ITEM"||$.trim(v_product_category_name_master)=="SELECT CATEGORY TYPE"||$.trim(v_product_unit)=='')
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_product_master_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/product_master/product_master_controller.php",{action:'add_product_master',v_product_category_id_master:v_product_category_id_master,v_product_category_name_master:v_product_category_name_master,v_product_type_id_master:v_product_type_id_master,v_product_type_name_master:v_product_type_name_master,v_product_item_id_master:v_product_item_id_master,v_product_item_name_master:v_product_item_name_master,v_product_unit_rate:v_product_unit_rate,v_product_brand_name:v_product_brand_name,v_product_unit:v_product_unit}
                                            , function(result,status)
                                            {
                                                
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_product_master_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_product_master_add.ladda( 'stop' );
                                                 swal("Success", "Product master details added successfully..", "success");
                                                 load_data_to_grid_product_master_details_list();
                                                 clear_text();
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                    
                    //load data to product item datatable
                    function load_data_to_grid_product_master_details_list()
                     {
                    v_list_of_product_master_table.destroy();
                     v_list_of_product_master_table = $('#list_of_product_master').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/product_master/product_master_controller.php',
                                 'data': {
                                    action: 'product_master_list_view'
                                    
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
                                 { "data": "product_master_id","visible":false },
                                 { "data": "product_category_id","visible":false },
                                 
                                 { "data": "product_category_name" },
                                 { "data": "product_type_id","visible":false },
                                 { "data": "product_type_name"},
                                 { "data": "product_item_id","visible":false },
                                 { "data": "product_item_name"},
                                 { "data": "product_brand_name"},
                                 { "data": "product_unit"},
                                 { "data": "product_unit_rate"},
                                 { "data": "status",
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
                                 { "data": "product_master_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_product_master" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                                
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8,9,10,11] }, 
            					
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
                 
                 
                    $('#list_of_product_master tbody').on('click', 'a', function(){
                       $('#div_list_product_type').show();
                        var $row = $(this).closest('tr');
                        var product_master_data = v_list_of_product_master_table.row($row).data();
                        v_product_master_id  = product_master_data.product_master_id;
                         v_product_master_status  = product_master_data.status;
                         if($(this).attr("name")=='Edit_product_master')
                         {
                         
                            edit_product_master_details(v_product_master_id);
            			    $( '#btn_product_master_add').hide();
                            $( '#btn_product_master_edit').show();
                            $( '#btn_product_master_new').show();
               
            			 }
            			 
            			  function edit_product_master_details(v_product_master_id)
                            {
                                $("#txt_product_master_id").val(v_product_master_id);  
                                $("#txt_product_unit_rate").val(product_master_data.product_unit_rate);
                                 $("#txt_product_unit").val(product_master_data.product_unit);
                                 $("#txt_product_brand_name").val(product_master_data.product_brand_name);
                                product_item_id_combo_master=product_master_data.product_item_id
                                 product_type_id_combo_master=product_master_data.product_type_id
                                
                                 $("#select_product_category_for_master").val(product_master_data.product_category_id).trigger("change");
                                 
                                
                            }
                            
                             if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_product_master_action=$(this).attr("name");
                             $.post("../controller/product_master/product_master_controller.php",{action:'change_product_master_status',v_product_master_id:v_product_master_id,v_product_master_status:v_product_master_status,v_product_master_action:v_product_master_action}
                                , function(result,status)
                                {
                                   //alert(result);
                                   load_data_to_grid_product_master_details_list();
                                
                            });
                        }
                          
                        
        });
                     //edit click
                    v_btn_product_master_edit.click(function(){
                            v_btn_product_master_edit.ladda( 'start' );
                             var v_product_category_id_master=$("#select_product_category_for_master option:selected").val();
                                var v_product_category_name_master=$("#select_product_category_for_master option:selected").text();
                                var v_product_type_id_master=$("#select_product_type_for_master option:selected").val();
                                var v_product_type_name_master=$("#select_product_type_for_master option:selected").text();
                                var v_product_item_id_master=$("#select_product_item_for_master option:selected").val();
                                var v_product_item_name_master=$("#select_product_item_for_master option:selected").text();
                                var v_product_unit_rate=$("#txt_product_unit_rate").val();
                                var v_product_unit=$("#txt_product_unit").val();
                                var v_product_brand_name=$("#txt_product_brand_name").val();
                                var v_product_master_id=$("#txt_product_master_id").val();
                               // alert(v_product_master_name);
                            if($.trim(v_product_master_id)===""||typeof v_product_item_id_master === "undefined"||typeof v_product_category_id_master === "undefined"|| typeof v_product_type_id_master === "undefined")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_product_master_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/product_master/product_master_controller.php",{action:'update_product_master',v_product_category_id_master:v_product_category_id_master,v_product_category_name_master:v_product_category_name_master,v_product_type_id_master:v_product_type_id_master,v_product_type_name_master:v_product_type_name_master,v_product_item_id_master:v_product_item_id_master,v_product_item_name_master:v_product_item_name_master,v_product_unit_rate:v_product_unit_rate,v_product_brand_name:v_product_brand_name,v_product_master_id:v_product_master_id,v_product_master_status:v_product_master_status,v_product_unit:v_product_unit}
                                        , function(result,status)
                                        {
                                            console.log(result);
                                            result = $.trim(result);
                                            if(result.charAt(0)==='U')
                                            {
                                                v_btn_product_master_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_product_master_edit.ladda( 'stop' );
                                                 swal("Success", " Product master details updated successfully..", "success");
                                                 load_data_to_grid_product_master_details_list();
                                                 clear_text();
                                            }
                                        });
                                
                             }
                          
                });  
                    
                    $( '#btn_product_master_new' ).click(function(){
                  
                        $( '#btn_product_master_add' ).show();
                        $( '#btn_product_master_edit' ).hide();
                        $( '#btn_product_master_new' ).hide();
                        clear_text();
                    })
                    
                    //function clear text
                   function clear_text()
                 {
                    $("#select_product_category_for_master").val(null).trigger("change");
                    $("#select_product_type_for_master").val(null).trigger("change");
                     $("#select_product_item_for_master").val(null).trigger("change");
                    $("#txt_product_unit_rate").val('');
                    $("#txt_product_unit").val('');
                    $("#txt_product_brand_name").val('');
                     $("#txt_product_master_id").val('');
                    
                 }
                  

});