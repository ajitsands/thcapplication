   $(document).ready(function() {
       
    //   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
       
	var v_requisition_mode,v_requisition_edit,v_requisition_view,v_product_total_calculation,requisition_id_modal,v_tckts_edit,v_amc_edit,v_requisition_mode_radio_edit,tckt_amc_ref_requisition,v_amc_ref_requisition_edit,v_tck_ref_requisition_edit,v_amc_ref_tckt_requisition_edit;
	var list_of_amc_asset_requisition_edit= $('#tbl_amc_ref_no_requisition_edit').DataTable();
	var list_of_tickets_asset = $('#tbl_tickets_asset_requisition_edit').DataTable();
	
		//load_data_to_grid_requisition_list(); 
	var v_start_date,v_end_date,v_select_customer_id,v_select_customer_name;
	var date = new Date();
    var firstDay = date.getFullYear()+'-'+('0' + (date.getMonth()+1)) .slice( -2 )+'-01'; 
    var to_date = date.getFullYear()+'-'+('0' + (date.getMonth()+1) ).slice( -2 )+'-'+date.getDate();
   
    $('#txt_start_date').val(firstDay);
    $("#txt_end_date").val(to_date);
     
		
		$("#btn_customer_search").click(function(){ 
			 v_start_date=$("#txt_start_date").val();		
			 v_end_date=$("#txt_end_date").val();
			 v_select_customer_id=$("#select_customer_name option:selected").val();
			 v_select_customer_name=$("#select_customer_name option:selected").text();

			load_data_to_grid_requisition_list_details_list(v_start_date,v_end_date,v_select_customer_id);
			
		});	
		
		
		
	
	var list_of_requisition_details = $('#tbl_requisition_list').DataTable({searching: false, paging: false, info: false,"ordering": false});
	load_data_to_grid_requisition_list_details_list(v_start_date,v_end_date,v_select_customer_id);
	
	
	 var params = {
        head: "requisition",
        open: 1,
        title: "add_requisition"
    };
    
	function load_data_to_grid_requisition_list_details_list(v_start_date,v_end_date,v_select_customer_id)
                 {
					
                     list_of_requisition_details.destroy();
                         
                     list_of_requisition_details = $('#tbl_requisition_list').DataTable( {
                        
                         "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/requisition/requisition_controller.php',
                                 'data': {
                                    action: 'list_requisition_details',
									v_start_date:v_start_date,
                                    v_end_date:v_end_date,
									v_select_customer_id:v_select_customer_id
                                 }
                            },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
            				"bPaginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                            "columns": [
                             { "data": null},
							 { "data": "requisition_serial_no"},
							 { "data": "amc_tkt_ref_no"},
							 { "data": "customer_name"}, 
							 { "data": "requisition_date"},
							{ "data": "requisition_id","className":"text-center",
                                   render: function ( data, type, rows, meta )
								   {
									return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-target="#" name="delete"><i class="icon-pen-plus"></i> Delete</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_requisition_view" name="requisition_view"><i class="icon-book2"></i> View </a><a href="requisition.php?RefNo='+rows["requisition_serial_no"]+'" class="dropdown-item" ><i class="icon-database-edit2"></i> Edit</a></div></div></div>'; 
					
                                   }   
                            }
                                 
                             ],
                             pageLength: 15,
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
                              "fnDrawCallback": function() {
                               
             
                             },
                        
                         
                     });  
                
                 }
	
	
	

		 $('#tbl_requisition_list tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                      
            });
             
               
        $('#tbl_requisition_list tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data_list = list_of_requisition_details.row($row).data();
		                var v_requisition_view= data_list.requisition_serial_no;
		               
							
					if($(this).attr("name")=='delete')
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
            						
            						        $.ajax({
                									type: "POST",
                									url: '../controller/requisition/requisition_controller.php',
                									data: {
                											action: 'delete_requisition',
                											requisition_id : requisition_id 
                										 }
                										
                							      })
                							 location.reload();		 
            							}
            							else {
            							}
            						 });
                             
            			  
            		    }
						
            			if($(this).attr("name")=='requisition_view')
            			{
            			    $('#txt_requisition_serial_no').val(data_list.requisition_serial_no);
            			    $("#requsition_no").html(data_list.requisition_serial_no);
            			    $("#amc_tkt_ref_no").html(data_list.amc_tkt_ref_no);
            			    $("#req_date").html(data_list.requisition_date);
            			    $("#customer_name").html(data_list.customer_name);
            			    
            			  load_data_to_grid_requisition_child(v_requisition_view);
            			}	
					
				});	
				
				
				
	                  var list_of_requsition_master = $('#tbl_requsition_master').DataTable({ destroy: true,});
	                  var list_of_requsition_child = $('#tbl_requsition_child').DataTable({ destroy: true,}); 
	                  
	                  
	               
	            
	            
	            function load_data_to_grid_requisition_child(v_requisition_view)
                 {
					
                     list_of_requsition_child.destroy();
                         
                     list_of_requsition_child = $('#tbl_requsition_child').DataTable( {
                        
                         "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/requisition/requisition_controller.php',
                                 'data': {
                                    action: 'list_requisition_child',
                                    v_requisition_serial_no:v_requisition_view
                                    }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
            				"bPaginate": true,
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
						
                                 
                             ],
                             pageLength: 15,
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
                              "fnDrawCallback": function() {
                               
             
                             },
                        
                         
                     });  
                
                 }  
				
       
       
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
					
					
					
				});