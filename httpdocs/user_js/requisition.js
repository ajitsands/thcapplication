   $(document).ready(function() {
       
      // $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
       
	   $("#tbl_amc").hide();
	   $("#tbl_tickets").hide();
	   $("#btn_requisition_new").hide();
	   $("#btn_edit_requisition").hide();
	   $("#btn_requisition_edit").hide();
	   var product_brand;
	   $("#div_tkts_ref_no").hide();
    	var list_of_amc_asset_requisition= $('#tbl_amc_asset_requisition_new').DataTable();
    	var list_of_tickets_asset = $('#tbl_tickets_asset_requisition').DataTable();
    	var list_of_requisition_child_table = $('#tbl_requisition_child').DataTable({"paging": false});
    	var hidden_amc_ref,hidden_ticket_ref,v_requisition_serial_no,v_requisition_mode,v_txt_requisition_serial_no;
    	var v_product_total_calculation,v_product_total_requisition,hidden_ticket_id,v_amc_child_idd,v_amc_ref_requisition,v_amc_child_id,v_tck_ref_requisition;
    	var v_btn_requisition_add = $('#btn_requisition_add').ladda();
    	var v_btn_requisition_edit= $('#btn_edit_requisition').ladda();
    	var flag=0;
    	var v_req_ref_no=$("#txt_requsition_no_hidden").val();
    	
    	if(v_req_ref_no=='')
    	{
    	 check_pending_requsition(); 
    	
    	}
    	 else
    	 {
    	   select_requisition_edit(v_req_ref_no);  
    	 }
    	 
       $("#btn_add_category_req").click(function(){
          
          $("#add_new_category_req").modal("show");
           
       });
       
       $("#btn_add_type_req1").click(function(){
            
          $("#add_new_type_req").modal("show");
           
       });
        $("#btn_add_item_req").click(function(){
          
          $("#add_new_item_req").modal("show");
           
       })
        $("#btn_add_brand_req").click(function(){
          
          $("#add_new_master_req").modal("show");
           
       })
       
    	
	   $("#tbl_amc").show();
		load_data_to_grid_amc_asset(v_amc_ref_requisition);
	
		 function check_pending_requsition()
                    {
                        
                         $.post("../controller/requisition/requisition_controller.php",{action:'check_requsition_status'},function(result,status){
                               var obj= jQuery.parseJSON(result);
                               var v_requisition_count=obj.data[0].requisition_count;
                               var v_requisition_id=obj.data[0].requisition_id;
                               var v_requisition_number=obj.data[0].requisition_serial_no;
                               
                               if(v_requisition_count>0)
                                {
                                            swal({
                                                                
                                    							title: "You have an uncompleted requsition request",
                                    							text: "Do you want to load again?",
                                    							icon: 'warning',
                                    							dangerMode: true,
                                    							allowOutsideClick: false,
                                                                closeOnClickOutside: false,
                                    							buttons: {
                                    							  cancel: 'No cancel old request!',
                                    							  delete: 'Yes please load'
                                    							}
                                    							}).then(function (willDelete) {
                                    							if (willDelete) {
                                    						
                                    						      select_requisition(v_requisition_number);
                                                 						 
                                    							} else {
                                    							    
                                    							  cancel_requisition(v_requisition_number);
                                    							 
                                    							}
                                    				});
                                    
                                   
                               }
                        });
                } 
                         
                        
                                             
                    function select_requisition(v_requisition_number)
                    {
                         
                         $.post("../controller/requisition/requisition_controller.php",{action:'select_requisition_pending_data',v_requisition_number:v_requisition_number},function(result,status){
                                var obj= jQuery.parseJSON(result);
                                $("#txt_amc_ref_no_requisition").val(obj.data[0].amc_tkt_ref_no);
                                $("#txt_requisition_serial_no").val(obj.data[0].requisition_serial_no);
                                
                                var v_reqisition_mode=obj.data[0].requisition_mode;
                                $("input:radio[name=answer][value="+ v_reqisition_mode+"]").attr('checked',true); 
                                var v_requisition_serial_no=obj.data[0].requisition_serial_no;
                                load_data_to_grid_amc_asset(obj.data[0].amc_tkt_ref_no);
                                load_data_to_grid_requisition_child_table(v_requisition_serial_no);
                             });
                        
                       
                        
                        
                    }
                    
                    function select_requisition_edit(v_req_ref_no)
                    {
                        
                        $.post("../controller/requisition/requisition_controller.php",{action:'select_requisition_edit_data',v_requisition_serial_no:v_req_ref_no},function(result,status){
                                var obj= jQuery.parseJSON(result);
                                $("#txt_amc_ref_no_requisition").val(obj.data[0].amc_tkt_ref_no);
                                $("#txt_requisition_serial_no").val(obj.data[0].requisition_serial_no);
                                
                                var v_reqisition_mode=obj.data[0].requisition_mode;
                                $("input:radio[name=answer][value="+ v_reqisition_mode+"]").attr('checked',true); 
                                var v_requisition_serial_no=obj.data[0].requisition_serial_no;
                                load_data_to_grid_amc_asset(obj.data[0].amc_tkt_ref_no);
                                load_data_to_grid_requisition_child_table(v_requisition_serial_no);
                             });
                         $("#btn_requisition_edit").show();
                         $("#btn_requisition_generate").hide();
                          $('#txt_requisition_serial_no').val(v_requisition_serial_no);
                    }
                    
                    
                   
                   
                    
                    function cancel_requisition(v_requisition_number)
                    {
                        
                        $.post("../controller/requisition/requisition_controller.php",{action:'cancel_requisition_list',v_requisition_serial_no:v_requisition_number
                                                }
                                                , function(result,status)
                                                {
                                                   
                         });
                       
                    }
		
		
		
		
		 
			$('#txt_hidden_requisition_mode').val("AMC");
		
		
		//radio button clicks
	   
            $("input[type='radio']").change(function() {
                if ($(this).val() == "AMC") {
                    $("#tbl_amc").show();
					$("#tbl_tickets").hide();
					load_data_to_grid_amc_asset(v_amc_ref_requisition);
					v_requisition_mode="AMC";
					$("#div_amc_ref_no").show();
					$("#div_tkts_ref_no").hide();
					v_amc_ref_requisition=$('#txt_amc_ref_no_requisition').val();
			
					}
				else 
				{
                    $("#tbl_amc").hide();
					$("#tbl_tickets").show();
					load_data_to_grid_tickets_asset(v_tck_ref_requisition);
					v_requisition_mode="TKT";
					$("#div_amc_ref_no").hide();
					 $("#div_tkts_ref_no").show();  
					 v_amc_child_idd=hidden_ticket_id;
                }
                	$('#txt_hidden_requisition_mode').val(v_requisition_mode);
            });
			
			//radio button clicks ends
			//span values
 	   
		 $("#btn_ref_search").click(function () {  
			 v_amc_ref_requisition=$('#txt_amc_ref_no_requisition').val();
			  v_tck_ref_requisition=$('#txt_tkt_ref_no_requisition').val();
			  load_data_to_grid_tickets_asset(v_tck_ref_requisition);
			  load_data_to_grid_amc_asset(v_amc_ref_requisition);
 	      });
		  
		  
		   $("#btn_reload").click(function () {   
				location.reload();
		   });
		   
		   $("#btn_requisition_new").click(function () { 
		        $("#btn_requisition_new").hide();
                $("#btn_edit_requisition").hide();
                $("#btn_requisition_add").show();
				clear_text();
		   });
    //span values ends..........................
    
       function load_data_to_grid_amc_asset(v_amc_ref_requisition)
                 {
                    //alert(v_reference_number);
                    list_of_amc_asset_requisition.destroy();
                         
                     list_of_amc_asset_requisition = $('#tbl_amc_asset_requisition_new').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/requisition/requisition_controller.php',
                                 'data': {
                                    action: 'list_amc_asset',
									v_amc_ref_requisition:v_amc_ref_requisition
                                    
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
                                 { "data": "asset_ref_no"},
								 { "data": "category_name"},
                                 { "data": "asset_type_name"},
								 
                       
                             ],
                             pageLength: 10,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
							  "drawCallback": function () {
                                   
                                },
		
                     });  
                
                 }
				 
				$('#tbl_amc_asset_requisition_new tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						
					}
					else {
						list_of_amc_asset_requisition.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						
						var $row = $(this).closest('tr');
						var data = list_of_amc_asset_requisition.row($row).data();
						 }
				});  



			
				 function load_data_to_grid_tickets_asset(v_tck_ref_requisition)
                 {
                    //alert(v_reference_number);
                    list_of_tickets_asset.destroy();
                         
                     list_of_tickets_asset = $('#tbl_tickets_asset_requisition').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/requisition/requisition_controller.php',
                                 'data': {
                                    action: 'list_tickets_asset',
                                    v_tck_ref_requisition:v_tck_ref_requisition
                                 }
                            },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
                            "paging": false,
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
                                 
                                { "data": null},
                                { "data": "ticket_ref_code"},
								{ "data": "category_name"},
								{ "data": "type_name"},
								{ "data": "complaints_description"},
								
			   
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
							  "drawCallback": function () {
                                   
                                },
		
                     });  
                
                 }
	
				 
    $('#tbl_amc_asset_requisition_new tbody').on( 'click', 'tr', function () {

            var $row = $(this).closest('tr');
            var data = list_of_amc_asset_requisition.row($row).data();
			  hidden_amc_ref=data.amc_ref_no;
			  $("#txt_amc_child_id").val(data.amc_child_id);
			  $('#txt_asset_code_amc').val(data.asset_ref_no);
			  $('#txt_customer_code_amc').val(data.customer_name);
			  $('#txt_building_name_amc').val(data.asset_building);
			  $('#txt_location_name_amc').val(data.asset_location);  
			  $('#txt__hidden_amc_location_id').val(data.location_id);
			  $('#txt__hidden_amc_building_id').val(data.building_id);
			  $('#txt__hidden_amc_customer_id').val(data.customer_id);

			  $('#span_customer_details').html('Customer Details : '+data.customer_code+' - '+data.customer_name);
			  $('#span_location_details').html(' Location : '+' - '+data.asset_location);
			  $('#span_building_details').html(' Building : '+' - '+data.asset_building);
		
      

    } );
		
			$('#tbl_tickets_asset_requisition tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						
					}
					else {
						list_of_tickets_asset.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						
						var $row_tickets = $(this).closest('tr');
						var data_tickets = list_of_tickets_asset.row($row_tickets).data();
						 }
				});  
		
	 $('#tbl_tickets_asset_requisition tbody').on( 'click', 'tr', function () {
		 
            var $row_tickets = $(this).closest('tr');
            var data_tickets = list_of_tickets_asset.row($row_tickets).data();
			  hidden_amc_ref=data_tickets.ticket_ref_code;
			
			 $('#txt_amc_child_id').val(data_tickets.ticket_id);
			  $('#txt_asset_code_amc').val(data_tickets.ticket_ref_code);
			  $('#txt_customer_code_amc').val(data_tickets.customer_name);
			  $('#txt_building_name_amc').val(data_tickets.building_name);
			  $('#txt_location_name_amc').val(data_tickets.location_name);
			  $('#txt__hidden_amc_location_id').val(data_tickets.location_id);
			  $('#txt__hidden_amc_building_id').val(data_tickets.building_id);
			  $('#txt__hidden_amc_customer_id').val(data_tickets.customer_id);
			
			  $('#span_customer_details_tickets').html('Customer Details : '+data_tickets.customer_code+' - '+data_tickets.customer_name);
			  $('#span_location_details_tickets').html(' Location : '+data_tickets.location_code+' - '+data_tickets.location_name);
			  $('#span_building_details_tickets').html(' Building : '+data_tickets.building_code+' - '+data_tickets.building_name);

    } );
	
	$('#select_product_category_for_master').bind('change',function() {
                    $('#select_product_type_for_master').val('').trigger('change');
                    $('#select_product_item_for_master').val('').trigger('change');
                    $('#select_product_brand').val('').trigger('change');               
        load_div_for_product_type_bind();
        
                        
    });
                         
            function load_div_for_product_type_bind()
                    {
                             
						var v_prdt_category_id_master=$("#select_product_category_for_master option:selected").val();
						$.ajax({
						type: "POST",
						url: "requisition/select_product_type_requisition_combo.php",
						data: { v_prdt_category_id_master : v_prdt_category_id_master } 
						 }).done(function(data){ 
							$("#div_list_product_type_master").html(data);
							$("#select_product_type_for_master").select2();
						    $("#btn_add_type_req").trigger('click');
						 });
					  	 
                    }
                         
                        
    $("#div_list_product_type_master").change(function(){
         $('#select_product_item_for_master').val('').trigger('change');
         $('#select_product_brand').val('').trigger('change');
		load_div_for_product_item_bind();
    });
                            
            function load_div_for_product_item_bind()
                    {
                             
						var v_prdt_type_id_master=$("#select_product_type_for_master option:selected").val();
						$.ajax({
						type: "POST",
						url: "requisition/select_product_item_requisition_combo.php",
						data: { v_prdt_type_id_master : v_prdt_type_id_master } 
						 }).done(function(data){
							 
							 
							$("#div_list_product_item").html(data);
							$("#select_product_item_for_master").select2();
						  
						 });
                    }
         $("#div_list_product_item").change(function(){
            var v_prdt_item_id_master=$("#select_product_item_for_master option:selected").val(); 
             	$("#txt_product_item_id_req").val(v_prdt_item_id_master);
                $('#select_product_brand').val('').trigger('change');         
		        load_div_for_product_brand_bind();
         });  
         
         
         function load_div_for_product_brand_bind()
                    {
                             
						var v_prdt_item_id_master=$("#select_product_item_for_master option:selected").val();
						$.ajax({
						type: "POST",
						url: "requisition/select_product_brand_requisition_combo.php",
						data: { v_prdt_item_id_master_req : v_prdt_item_id_master } 
						 }).done(function(data){
							$("#div_list_product_brand").html(data);
							$("#select_product_brand").select2();
						  
						 });
                    }
         
           $("#div_list_product_brand").change(function(){  
                var v_product_category_id_requisition=$("#select_product_category_for_master option:selected").val();
        		
        		var v_product_type_id_requisition=$("#select_product_type_for_master option:selected").val();
        		
        		var v_product_item_id_requisition=$("#select_product_item_for_master option:selected").val();
        		
        		var v_product_master_requisition_id=$("#select_product_brand option:selected").val();
        	    if(flag==0)
                {        	
        		$.post('../controller/requisition/requisition_controller.php',{action:'find_product_unit_price',v_product_category_id_requisition:v_product_category_id_requisition,v_product_type_id_requisition:v_product_type_id_requisition,v_product_item_id_requisition:v_product_item_id_requisition,v_product_master_requisition_id:v_product_master_requisition_id},function(result,status){
        		        var obj= jQuery.parseJSON(result);
        		        if(obj.length==0)
        		        {
        		          $("#txt_product_unit_rate").val('');
                          $("#txt_product_unit").val('');   
        		        }
        		        else
        		        {
                        var v_product_unit_price=obj.data[0].product_unit_rate;
                        var v_product_unit=obj.data[0].product_unit;
                       
                        $("#txt_product_unit_rate").val(v_product_unit_price);
                        $("#txt_product_unit").val(v_product_unit);
        		        }
        		       
                        
        		       
        		}) 
                }
                
                        var v_product_unit_rate_requisition=$("#txt_product_unit_rate").val();
        				var v_product_quantity_requisition=$("#txt_product_quantity").val();
        				v_product_total_calculation=(parseFloat(v_product_unit_rate_requisition)*parseFloat(v_product_quantity_requisition));
        				v_product_total_requisition=$("#txt_product_grant_total").val(v_product_total_calculation);
                
           });
                    
                  
                         
	$("#txt_product_quantity,#txt_product_unit_rate").change(function(){
				var v_product_unit_rate_requisition=$("#txt_product_unit_rate").val();
				var v_product_quantity_requisition=$("#txt_product_quantity").val();
				v_product_total_calculation=(parseFloat(v_product_unit_rate_requisition)*parseFloat(v_product_quantity_requisition));
				v_product_total_requisition=$("#txt_product_grant_total").val(v_product_total_calculation);
				
	});
	
	
           
                    	
	$("#btn_requisition_add").click(function(){ 
	   v_btn_requisition_add.ladda( 'start' );
	    var v_requisition_mode=  $('#txt_hidden_requisition_mode').val();
		var amc_asset_code=$('#txt_asset_code_amc').val();
		var amc_customer_name=$('#txt_customer_code_amc').val();
		var amc_building_name=$('#txt_building_name_amc').val();
		var amc_location_name=$('#txt_location_name_amc').val();
		var amc_location_id=$('#txt__hidden_amc_location_id').val();
		var amc_building_id=$('#txt__hidden_amc_building_id').val();
		var amc_customer_id=$('#txt__hidden_amc_customer_id').val(); 
		var v_product_category_id_requisition=$("#select_product_category_for_master option:selected").val();
		var v_product_category_name_requisition=$("#select_product_category_for_master option:selected").text();
		var v_product_type_id_requisition=$("#select_product_type_for_master option:selected").val();
		var v_product_type_name_requisition=$("#select_product_type_for_master option:selected").text();
		var v_product_item_id_requisition=$("#select_product_item_for_master option:selected").val();
		var v_product_item_name_requisition=$("#select_product_item_for_master option:selected").text();
		var v_product_unit_rate_requisition=$("#txt_product_unit_rate").val();
		var v_product_unit_requisition=$("#txt_product_unit").val();
		var v_product_quantity_requisition=$("#txt_product_quantity").val();
		var v_product_brand=$("#select_product_brand option:selected").text();
		v_amc_child_idd=$('#txt_amc_child_id').val();
		v_product_total_requisition=$("#txt_product_grant_total").val();
		v_requisition_serial_no=$('#txt_requisition_serial_no').val();
	
		if($.trim(amc_asset_code)==''||$.trim(amc_customer_name)==''||$.trim(amc_building_name)==''||$.trim(amc_location_name)==''||$.trim(amc_location_id)==''||$.trim(amc_building_id)==''||$.trim(amc_customer_id)=='')
		{
		    if(v_requisition_mode=="AMC")
		    {
		    swal("Warning", "Please select an asset...", "warning");
		    }
		    else
		    {
		      swal("Warning", "Please select a ticket...", "warning");  
		    }
		    v_btn_requisition_add.ladda( 'stop' );
		   
		    return false;
		}
		else if($.trim(v_product_category_id_requisition)=='select'||$.trim(v_product_type_id_requisition)=='select'||$.trim(v_product_item_id_requisition)=='select'||$.trim(v_product_unit_rate_requisition)==''||$.trim(v_product_quantity_requisition)==''||$.trim(v_product_total_requisition)=='')
		{
		    swal("Warning", "Please fill all the fields...", "warning");
		    v_btn_requisition_add.ladda( 'stop' );
		   
		    return false;
		}
		else
		{
    		$.post('../controller/requisition/requisition_controller.php',{action:'add_requisitions',amc_asset_code:amc_asset_code,
    		amc_customer_name:amc_customer_name,amc_building_name:amc_building_name,amc_location_name:amc_location_name,
    		amc_location_id:amc_location_id,amc_building_id:amc_building_id,amc_customer_id:amc_customer_id,
    		v_requisition_mode:v_requisition_mode,v_requisition_serial_no:v_requisition_serial_no,v_product_category_id_requisition:v_product_category_id_requisition,
    		v_product_category_name_requisition:v_product_category_name_requisition,v_product_type_id_requisition:v_product_type_id_requisition,
    		v_product_type_name_requisition:v_product_type_name_requisition,v_product_item_id_requisition:v_product_item_id_requisition,
    		v_product_item_name_requisition:v_product_item_name_requisition,v_product_unit_rate_requisition:v_product_unit_rate_requisition,
    		v_product_quantity_requisition:v_product_quantity_requisition,v_amc_child_idd:v_amc_child_idd,hidden_amc_ref_tckt:hidden_amc_ref,v_product_total_requisition:v_product_total_requisition,v_product_unit_requisition:v_product_unit_requisition,v_product_brand:v_product_brand},function(result,status)
    		{
                
                      v_requisition_serial_no=$.trim(result);
        			   $('#txt_requisition_serial_no').val(v_requisition_serial_no);	
        
        							 
        								  if(result.charAt(0)=='C')
                                           {
                                               swal("Error", result, "error");
                                             v_btn_requisition_add.ladda( 'stop' );
                                               clear_text();
                                               return false;
                                               
                                           
                                           }
                                           else
                                           {
        									   
        									swal("Success", "Item added successfully..", "success");
        									clear_text();
        									$('[name="answer"]').each(function(){
                                                $(this).attr('disabled','disabled');                                
                                            });
        								
        									$("#txt_amc_ref_no_requisition").prop("disabled", true);
        									v_btn_requisition_add.ladda( 'stop' );									 
        									load_data_to_grid_requisition_child_table(v_requisition_serial_no);
        								    return false;
                                
                                           }
                  
                });
	    	}
	
        });
		
		
		
		 
	    function load_data_to_grid_requisition_child_table(v_requisition_serial_no)
                 {
                     
                    list_of_requisition_child_table.destroy();
                         
                    list_of_requisition_child_table = $('#tbl_requisition_child').DataTable( {
                           
                            "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/requisition/requisition_controller.php',
                                 'data': {
                                    action: 'list_requisition_child',
                                    v_requisition_serial_no:v_requisition_serial_no
                                 }
                            },
							
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                            "paging": false,
            				"Paginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
										{ "data": null},
										{ "data": "asset_ref_no"},
										{ "data": "product_category_name"},
										{ "data": "product_type_name"},
										{ "data": "product_item_name"},
										{ "data": "product_unit_rate"},
										{ "data": "product_quantity"},
										{ "data": "grant_total"},
										{ "data": "requisition_child_id","className":"text-center",
                                           render: function ( data, type, rows, meta )
        								   {
        									return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-target="#" name="delete_child"><i class="icon-pen-plus"></i> Delete</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_requisition_edit" name="requisition_edit_child"><i class="icon-database-edit2"></i> Edit</a></div></div></div>'; 
        					
                                           }   
                                        }
										],
										
                             pageLength: 10,
            				 searching: false,
                             responsive: true,

                             "initComplete": function( settings, json ) {
                              },
							  
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                return nRow;
                              },
                              "drawCallback": function () {
                                   
                              },
                              "footerCallback": function ( row, data, start, end, display ) {
                                var api = this.api(), data;
                     
                                // Remove the formatting to get integer data for summation
                                var intVal = function ( i ) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '')*1 :
                                        typeof i === 'number' ?
                                            i : 0;
                                };
                     
                                // Total over all pages Income
                                total1 = api
                                    .column( 7 )
                                    .data()
                                    .reduce( function (a, b) {
                                        
                                        return intVal(a) + intVal(b);
                                    }, 0 );
                               
                                // Total over this page Income
                                pageTotal1 = api
                                    .column( 7, { page: 'current'} )
                                    .data()
                                    .reduce( function (a, b) {
                                        return intVal(a) + intVal(b);
                                    }, 0 );
                               
                                // Update footer
                                $( api.column( 7 ).footer() ).html($.fn.dataTable.render.number(',', '.', 3, '').display( pageTotal1 )
                                    
                                );
                        }
                        
                     });  
                
                 }
                 
				 
				 
				 $('#tbl_requisition_child tbody').on( 'click', 'tr', function () {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						
					}
					else {
						list_of_requisition_child_table.$('tr.selected').removeClass('selected');
						$(this).addClass('selected');
						
						var $row_tickets = $(this).closest('tr');
						var data_child = list_of_requisition_child_table.row($row_tickets).data();
						 }
				});  
		
                 
		 $('#tbl_requisition_child tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                      
            });
		
		         
        $('#tbl_requisition_child tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data_child = list_of_requisition_child_table.row($row).data();
		
						var requisition_child_id=data_child.requisition_child_id;
						var asset_ref_no=data_child.asset_ref_no;
					
						
					
					var product_type_id=data_child.product_type_id;
					var product_item_id=data_child.product_item_id;
					var product_item_name=data_child.product_item_name
				    //alert(data_child.product_item_name);
				
					
					if($(this).attr("name")=='delete_child')
                         {
                              swal({
                                                                    
            							title: "Are you sure?",
            							text: "Do you want to delete the entry?",
            							icon: 'warning',
            							dangerMode: true,
            							allowOutsideClick: false,
                                        closeOnClickOutside: false,
            							buttons: {
            							  cancel: 'No Cancel !',
            							  delete: 'Yes Please Delete'
            							}
            							}).then(function (willDelete) {
            							if (willDelete) {
            						
            						       cancel_requisition_item(requisition_child_id);
                         				   	load_data_to_grid_requisition_child_table(v_requisition_serial_no); 		 
            							} else {
            							    
            							   
            							 
            							}
            						 });
                             
						}
						
						
						
    				if($(this).attr("name")=='requisition_edit_child')
    					{	
    					            	$("#btn_requisition_new").show();
						                $("#btn_edit_requisition").show();
						                $("#btn_requisition_add").hide();
						            flag=1;     
            						var requisition_child_id=data_child.requisition_child_id;
            						product_brand=data_child.product_brand;
            					
            					
            						$("#txt_hidden_requisition_child_id").val(data_child.requisition_child_id);
            						$("#txt_product_unit_rate").val(data_child.product_unit_rate);  
            						$("#txt_product_quantity").val(data_child.product_quantity);  
            						$("#txt_product_grant_total").val(data_child.grant_total);  
            					
            						$("#select_product_category_for_master").val(data_child.product_category_id).trigger("change");
                                    load_div_for_product_type_bind_edit(product_type_id,product_item_id,product_brand,product_item_name);
                                  // load_div_for_product_brand_bind_edit(product_item_id,product_brand);
    						}
    							
					});	
					
					
			
					
				function cancel_requisition_item(requisition_child_id)
				{
				     $.ajax({
									type: "POST",
									url: '../controller/requisition/requisition_controller.php',
									data: {
											action: 'delete_requisition_child',
											requisition_child_id : requisition_child_id 
										 }
										
							 })
				}
						
						
				function load_div_for_product_type_bind_edit(product_type_id,product_item_id,product_brand,product_item_name)
						{
                          
						var v_prdt_category_id_master=$("#select_product_category_for_master option:selected").val();
				   
						$.ajax({
						type: "POST",
						url: "requisition/select_product_type_requisition_combo.php",
						data: { v_prdt_category_id_master : v_prdt_category_id_master } 
						 }).done(function(data){ 
							$("#div_list_product_type_master").html(data);
							$("#select_product_type_for_master").select2();
						    $('#select_product_type_for_master option').map(function () {
                            if ($(this).val() == $.trim(product_type_id)) return this;
                            }).attr('selected', 'selected') ;
                           $('#select_product_type_for_master').select2().trigger('change');
                          
                          load_div_for_product_item_bind_edit(product_item_id,product_brand,product_item_name); 
						 });
						 
                    }
					
               
                            
            function load_div_for_product_item_bind_edit(product_item_id,product_brand,product_item_name)
                    {
                         //  alert(product_item_name);
						var v_prdt_type_id_master=$("#select_product_type_for_master option:selected").val();
						$.ajax({
						type: "POST",
						url: "requisition/select_product_item_requisition_combo.php",
						data: { v_prdt_type_id_master : v_prdt_type_id_master } 
						 }).done(function(data){
							$("#div_list_product_item_edit").html(data);
							$("#select_product_item_for_master").select2();
							 $('#select_product_item_for_master option').map(function () {
                        if ($.trim($(this).val()) == $.trim(product_item_id)) return this;
                        }).attr('selected', 'selected') ;
                           $('#select_product_item_for_master').select2().trigger('change');
						   load_div_for_product_brand_bind_edit(product_item_id,product_brand);
						 });
					 
						 
						  
                    }
                    
                    
                    
               function load_div_for_product_brand_bind_edit(product_item_id,product_brand)
                    {
                      // alert(product_brand);
                       var v_prdt_item_id_master=$("#select_product_item_for_master option:selected").val();
						$.ajax({
						type: "POST",
						url: "requisition/select_product_brand_requisition_combo.php",
						data: { v_prdt_item_id_master_req : product_item_id } 
						 }).done(function(data){
							$("#div_list_product_brand").html(data);
							$("#select_product_brand").select2();
						    
						    $('#select_product_brand option').map(function () {
                                if ($(this).text() == $.trim(product_brand)) return this;
                                }).attr('selected', 'selected') ;
                           $('#select_product_brand').select2().trigger('change');
						 });
                    }     
                    
                    
                    
                    
                    
                    
         $("#btn_edit_requisition").click(function(){
              v_btn_requisition_edit.ladda( 'start' );
        var v_requisition_child_id= $("#txt_hidden_requisition_child_id").val();
        var v_requisition_mode=$('input[name="answer"]:checked').val();  
        
		var amc_asset_code=$('#txt_asset_code_amc').val();
		var amc_customer_name=$('#txt_customer_code_amc').val();
		var amc_building_name=$('#txt_building_name_amc').val();
		var amc_location_name=$('#txt_location_name_amc').val();
		var amc_location_id=$('#txt__hidden_amc_location_id').val();
		var amc_building_id=$('#txt__hidden_amc_building_id').val();
		var amc_customer_id=$('#txt__hidden_amc_customer_id').val(); 
		var v_product_category_id_requisition=$("#select_product_category_for_master option:selected").val();
		var v_product_category_name_requisition=$("#select_product_category_for_master option:selected").text();
		var v_product_type_id_requisition=$("#select_product_type_for_master option:selected").val();
		var v_product_type_name_requisition=$("#select_product_type_for_master option:selected").text();
		var v_product_item_id_requisition=$("#select_product_item_for_master option:selected").val();
		var v_product_item_name_requisition=$("#select_product_item_for_master option:selected").text();
		var v_product_unit_rate_requisition=$("#txt_product_unit_rate").val();
		var v_product_quantity_requisition=$("#txt_product_quantity").val();
		v_amc_child_idd=$('#txt_amc_child_id').val();
		v_product_total_requisition=$("#txt_product_grant_total").val();
		v_requisition_serial_no=$('#txt_requisition_serial_no').val();	
		
		//alert(v_requisition_serial_no);
		if($.trim(amc_asset_code)==''||$.trim(amc_customer_name)==''||$.trim(amc_building_name)==''||$.trim(amc_location_name)==''||$.trim(amc_location_id)==''||$.trim(amc_building_id)==''||$.trim(amc_customer_id)=='')
		{
		    if(v_requisition_mode=="AMC")
		    {
		    swal("Warning", "Please select an asset...", "warning");
		    }
		    else
		    {
		      swal("Warning", "Please select a ticket...", "warning");  
		    }
		    v_btn_requisition_edit.ladda( 'stop' );
		    
		    return false;
		}
		else if($.trim(v_product_category_id_requisition)=='select'||$.trim(v_product_type_id_requisition)=='select'||$.trim(v_product_item_id_requisition)=='select'||$.trim(v_product_unit_rate_requisition)==''||$.trim(v_product_quantity_requisition)==''||$.trim(v_product_total_requisition)=='')
		{
		    swal("Warning", "Please fill all the fields...", "warning");
		    v_btn_requisition_edit.ladda( 'stop' );
		    clear_text();
		    return false;
		}
		else
		{
            		$.post('../controller/requisition/requisition_controller.php',{action:'edit_requisition_child',amc_asset_code:amc_asset_code,
            		amc_customer_name:amc_customer_name,amc_building_name:amc_building_name,amc_location_name:amc_location_name,
            		amc_location_id:amc_location_id,amc_building_id:amc_building_id,amc_customer_id:amc_customer_id,
            		v_requisition_mode:v_requisition_mode,v_requisition_serial_no:v_requisition_serial_no,v_product_category_id_requisition:v_product_category_id_requisition,
            		v_product_category_name_requisition:v_product_category_name_requisition,v_product_type_id_requisition:v_product_type_id_requisition,
            		v_product_type_name_requisition:v_product_type_name_requisition,v_product_item_id_requisition:v_product_item_id_requisition,
            		v_product_item_name_requisition:v_product_item_name_requisition,v_product_unit_rate_requisition:v_product_unit_rate_requisition,
            		v_product_quantity_requisition:v_product_quantity_requisition,v_amc_child_idd:v_amc_child_idd,hidden_amc_ref_tckt:hidden_amc_ref,v_product_total_requisition:v_product_total_requisition,requisition_child_id:v_requisition_child_id},function(result,status)
            		{
                        
                         
            							 
            								  if(result.charAt(0)=='C')
                                               {
                                                   swal("Error", result, "error");
                                                 v_btn_requisition_edit.ladda( 'stop' );
                                                   
                                                   return false;
                                                   
                                               
                                               }
                                               else
                                               {
            									   
            									swal("Success", "Item edited successfully..", "success");
            									clear_text();
            									 $("#btn_requisition_new").hide();
                                                 $("#btn_edit_requisition").hide();
                                                 $("#btn_requisition_add").show();
            									v_btn_requisition_edit.ladda( 'stop' );									 
            									load_data_to_grid_requisition_child_table(v_requisition_serial_no);
            								    return false;
                                    
                                               }
                      
                    });	
		   }
             
         });           
                    
                    
                    
		
		$("#btn_requisition_generate").click(function(){ 
    			v_requisition_serial_no=$('#txt_requisition_serial_no').val();
    			
    			
    			$.post('../controller/requisition/requisition_controller.php',{action:'requisitions_status_generated',v_requisition_serial_no:v_requisition_serial_no},function(result,status)
    			{
    								if(result.charAt(0)=='C')
    									   {
    										   swal("Error", result, "error");
    										
    									   }
    								else
    									   {
    										   
    										 swal("Success", "Requisition generated successfully...", "success"); 
    										
    									   }
    			});
		
		});
		
			$("#btn_requisition_edit").click(function(){ 
    			v_requisition_serial_no=$('#txt_requisition_serial_no').val();
    			
    			
    			$.post('../controller/requisition/requisition_controller.php',{action:'requisitions_status_generated',v_requisition_serial_no:v_requisition_serial_no},function(result,status)
    			{
    								if(result.charAt(0)=='C')
    									   {
    										   swal("Error", result, "error");
    										
    									   }
    								else
    									   {
    										   
    										 swal("Success", "Requisition updated successfully...", "success"); 
    										
    									   }
    			});
		
		});
		
		$("#btn_print_requisition").click(function(){
		    var requsition_number=$('#txt_requisition_serial_no').val();
                           if($.trim(requsition_number)=="")
                    {
                                    
                        swal("Error",'Please select or create requsition for print','error');            
                        
                    }
                    else
                    {
                       $.post("../controller/requisition/requisition_controller.php",{action:'check_requsition_status_for_print',v_requisition_serial_no:requsition_number},function(result,status){
                       var obj= jQuery.parseJSON(result);
                        var v_requisition_status=obj.data[0].req_status;
                        
                       if(v_requisition_status =='Pending')
                       {
                                  
                         swal("Error",'Please generate requsition for print','error');  
                       }
                       else
                       {
                          window.open("print/print_requsition.php?requsition_number="+requsition_number,"_blank"); 
                       }
                       
                       
                       });
                    }
                        
		    
		});
	
		 function clear_text()
                 {

					$("#txt_product_quantity").val('');
                    $("#txt_product_unit_rate").val('');
                    $("#txt_product_grant_total").val('');
                    $('#select_product_category_for_master').val('').trigger('change');
                    $('#select_product_type_for_master').val('').trigger('change');
                    $('#select_product_item_for_master').val('').trigger('change');
                    $('#select_product_brand').val('').trigger('change');
                 }
       
	});