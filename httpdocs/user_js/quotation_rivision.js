$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
  var v_quotation_id,v_quotation_ref_no;
         
		var v_btn_quotation_rivision_search = $('#btn_quotation_rivision_search').ladda();
		
		
		
		 $( '#quotation_rivision_master_table' ).show();
		 $( '#quotation_rivision_child_table' ).hide();
		
		 
		
		var v_list_of_quotation_rivision_master_table = $('#list_of_quotation_rivision_master').DataTable({});
            load_data_to_grid_quotation_rivision_master_details_list(v_quotation_ref_no);
			
		var v_list_of_quotation_rivision_child_table = $('#list_of_quotation_rivision_child').DataTable({searching: false, paging: false, info: false,"ordering": false});
		//load_data_to_grid_quotation_rivision_child_details_list();
	
		
		//search button click starts 
                v_btn_quotation_rivision_search.click(function(){
					
                    v_btn_quotation_rivision_search.ladda( 'start' );
					
					v_quotation_id=$("#select_quotation_rivision_no option:selected").val();
					v_quotation_ref_no=$("#select_quotation_rivision_no option:selected").text();
					//alert(v_quotation_ref_no);
					
					load_data_to_grid_quotation_rivision_master_details_list(v_quotation_ref_no);
					
					$( '#quotation_rivision_child_table' ).show();

					load_data_to_grid_quotation_rivision_child_details_list(v_quotation_ref_no);
					v_btn_quotation_rivision_search.ladda( 'stop' );
                });
		
		//search button click ends 
		
		 //load data to quotation rivision master 
                 function load_data_to_grid_quotation_rivision_master_details_list(v_quotation_ref_no)
                 {
                   
                    v_list_of_quotation_rivision_master_table.destroy();
                         
                     v_list_of_quotation_rivision_master_table = $('#list_of_quotation_rivision_master').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/quotation/quotation_rivision_controller.php',
                                 'data': {
                                    action: 'quotation_rivision_master_view',
									v_quotation_ref_no:v_quotation_ref_no
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
                                /* {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 }, */
                                 
                                 { "data": null},
                                 { "data": "quotation_ref_no",},
								 { "data": "customer_name" },
                                 { "data": "date" },
                                 //{ "data": "quotation_id",
                                     // render: function ( data, type, rows, meta ) {
                                       //   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="View_Quotation" style="color:orange"><i class="icon-database-edit2"></i> VIEW</a></div></div></div>';
                                        //  return str_active_status_edit;
                                          
                                      //}   
                                // }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3] }, 
            					
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
			 //load data to quotation rivision master ends
			 
			 
//quotation rivision child list page js starts here

			function load_data_to_grid_quotation_rivision_child_details_list(v_quotation_ref_no)
                 {
					 
                     v_list_of_quotation_rivision_child_table.destroy();
                         
                     v_list_of_quotation_rivision_child_table = $('#list_of_quotation_rivision_child').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/quotation/quotation_rivision_controller.php',
                                 'data': {
                                    action: 'quotation_rivision_child_details_view',
									v_quotation_ref_no:v_quotation_ref_no
                                  
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                            "columns": [
                                { "data": null},
                                 { "data": "description",},
								 { "data": "quantity" },
                                 { "data": "unit" },
                                 { "data": "rate"},
                                 { "data": "total"},
                                 { "data": "discount" },
                                 //{ "data": "discount","visible":false },
								 { "data": "vat" },
								 { "data": "grant_total"},
                                 //{ "data": "quotation_child_id",
                     
                                      //render: function ( data, type, rows, meta ) {
                                               // return '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="quotation.php?RefNo='+rows["quotation_ref_no"]+'" class="dropdown-item" style="color:orange"><i class="icon-database-edit2"></i> Edit</a></div></div></div>';
												 //return '<a href="quotation.php?RefNo='+rows["quotation_ref_no"]+'">Edit</a>';
												//return '<a href="quotation.php?RefNo=rows["quotation_ref_no"]" class="dropdown-item" name="Edit_Quotation_List" style="color:orange"><i class="icon-database-edit2"></i>Edit</a>'
            									//str_active_status_view = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="quotation.php" class="dropdown-item" name="Edit_Quotation_List" style="color:orange"><i class="icon-database-edit2"></i>Edit</a></div></div></div>';
            								
            								//return str_active_status_view;
            
            							// },
            							 
            					

					 
					         //},
            				
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
            				
                            
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                             },
                              "fnDrawCallback": function() {
								
								},
								//footer total calculation starts here
							  
									 "footerCallback": function ( row, data, start, end, display ) {
										var api = this.api(), data;
							 
										// Remove the formatting to get integer data for summation
										var intVal = function ( i ) {
											return typeof i === 'string' ?
												i.replace(/[\$,]/g, '')*1 :
												typeof i === 'number' ?
													i : 0;
										};
										
										//amount total
										// Total over all pages
										total = api
											.column( 5 )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Total over this page
										pageTotal1 = api
											.column( 5, { page: 'current'} )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Update footer
										$( api.column( 5 ).footer() ).html(
											'Total='+pageTotal1 
										);
														  
										//grand total
										// Total over all pages
											total = api
											.column( 8 )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Total over this page
										pageTotal1 = api
											.column( 8, { page: 'current'} )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Update footer
										$( api.column( 8 ).footer() ).html(
											'Total='+pageTotal1 
										);
															  
									 }
							  //footer total calculation ends here
                     });
                
                 }

		
                  
});