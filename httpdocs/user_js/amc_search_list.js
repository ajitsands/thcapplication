$(document).ready(function(){
     $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });                
    
     var v_list_active_amc=$('#tbl_of_active_list_amc').DataTable({});
     var v_list_of_onhold_amc = $('#tbl_of_onhold_amc').DataTable({});
     var v_list_of_completed_amc = $('#tbl_of_completed_amc').DataTable({});
     var v_list_of_cancelled_amc = $('#tbl_of_cancelled_amc').DataTable({});
     var v_list_of_amc_child = $('#tbl_of_amc_child_details').DataTable({});
	 var v_list_of_amc_subcontractors = $('#tbl_of_amc_subcontractors_details').DataTable({});
    
    load_data_to_grid_active_amc_list();
   display_count();
    
    
	function display_count()
	{
	    
		$.post('../controller/amc/amc_search_controller.php',{action:'action_count_active'},function(result,status){
                d = JSON.parse(result);
                $('#span_active_count').html(d.data[0].count_active);
        });
        $.post('../controller/amc/amc_search_controller.php',{action:'action_count_hold'},function(result,status){
                d = JSON.parse(result);
                $('#span_onhold_count').html(d.data[0].count_hold);
        });
        $.post('../controller/amc/amc_search_controller.php',{action:'action_count_completed'},function(result,status){
                d = JSON.parse(result);
                $('#span_completed_count').html(d.data[0].count_complete);
        });
        $.post('../controller/amc/amc_search_controller.php',{action:'action_count_cancelled'},function(result,status){
                d = JSON.parse(result);
                $('#span_cancelled_count').html(d.data[0].count_cancel);
        });
       
     
	
	}
   
                   
         $("#tab_amc_active").click(function(){
	        load_data_to_grid_active_amc_list();
	       });             
           
                 function load_data_to_grid_active_amc_list()
                 {
                     
                    v_list_active_amc.destroy();
                         
                     v_list_active_amc= $('#tbl_of_active_list_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'list_amc_active'
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_active_list_amc").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_active_list_amc").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_active_list_amc").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				columnDefs: [
                                    { type: 'date-eu', targets: [5,6] }
                             ],
                         
                            "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction',
                                        exportOptions: {
                                            //columns: [1, 2, 3,12, 9,7,10,11,5,6] 
                                            columns: [1,2,3,5,6,7,8,10,11,12,13] 
                                        },
										filename: 'List of AMC - Active',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
											//Loop over the cells
											$('row c', sheet).each(function() {
											//select the index of the row
											var numero=$(this).parent().index() ;
												var residuo = numero%2;
												if (numero==1){           
													$(this).attr('s','22');//22 - Bold, blue background
												}else if (numero==0){
													// if(residuo ==0  ){//'is t',
													//$(this).attr('s','40');//25 - Normal text, fine black border
													// }else{
													// $(this).attr('s','32');//32 - Bold, gray background, fine black border
													// }
												}
											});
										},
                                    }
                                ],
                               
                               
                            "columns": [
                                 {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                    
                                 },
                                 //{ "data": null,"width": "5%"},
                                
                                {"data": null,
                                    "width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
                                },
                                
								 { "data": "amc_ref_no"},
								 { "data": "contract_type_name"},
								 
								 { "data": "customer_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "amc_start_date1","width": "20%"},
                                { "data": "amc_end_date1","width": "20%"},
                                { "data": "amc_total_amt"},
                                { "data": "total_amc_amount","visible":false},
                                 { "data": "amc_ref_no",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black;">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="view_amc_child_details" data-toggle="modal" data-target="#modal_view_amc_child_details" style="color:black"><i class="icon-eye"></i> View Asset Details</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item classActiveSearchAMCReport" data-name="classActiveSearchAMCReport" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> AMC QR</a><a href="https://' + serverName + '/thc/printpdf/qr_code/customer_feedback_qr.php?amc_ref_no=' + rows['amc_ref_no'] + '&amc_id=' + rows['amc_id'] + '&contract_type=' + rows['contract_type_name'] + '&customer_code=' + rows['customer_code'] + '&customer_name=' + rows['customer_name'] + '" class="dropdown-item" name="qr_amc_customer" data-toggle="" data-target="" style="color:black" target="_blank"><i class="icon-qrcode"></i> Customer Feedback QR</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="amc_delete" style="color:red;"><i class="icon-trash" style="color:red;"></i> Delete</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }
                                    //   "exportOptions": {
                                    //     // Exclude this column from export
                                    //     columns: ':not(:last-child)'
                                    // }
                                      
                                 },
								 { "data": "amc_description","visible":false },
								 { "data": "amc_vat_perct","visible":false},
								 { "data": "amc_vat_amt","visible":false},
								 { "data": "customer_name","visible":false},
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                            //     "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                            //      $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                            //      return nRow;
                            //   },
                            //   "drawCallback": function () {
                                  
                            //     }
                            
                     });  
                
                 }
                  $('#tbl_of_active_list_amc tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_active_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                });
                
                
                
                
        
               function format_amc_details(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Signed Date </div></td>'+
            				'<td ><div align="center">Amount Details </div></td>'+
            				'<td ><div align="center">VAT Details </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_amount).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_vat_amt).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+' ('+d.amc_vat_perct+' )'+'</div></td>'+
							
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Description </div></td>'+
            				'<td ><div align="center">Is RFP? </div></td>'+
            				'<td ><div align="center">AMC Parent</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_description+'</div></td>'+
            				'<td><div align="center">'+d.is_rfp+'</div></td>'+
            				'<td><div align="center">'+d.amc_parent_ref_no+'</div></td>'+
							
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Attachment 1</div></td>'+
            				'<td ><div align="center">AMC Attachment 2</div></td>'+
            				'<td ><div align="center">AMC Attachment 3</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment1_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment2_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment3_desc+'</div></td>'+
							
            				
            			  '</tr>'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Renewal Notes</div></td>'+
            				'<td ><div align="center">AMC Renewal Attachment</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				'<td><div align="center">'+d.amc_renewal_notes+'</div></td>'+
            					'<td><div align="center"><a href="../httpdocs/images/amc_renewal_attachments/'+d.amc_renewal_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	          
	       $("#tab_amc_hold").click(function(){
	            
				$("#div_data").LoadingOverlay("show", {
					 background  : "rgba(132, 194, 0, 0.2)",
					 text: "Loading..."
				 });
	        load_data_to_grid_hold_amc_list();
	       });
	          
	             function load_data_to_grid_hold_amc_list()
                 {
                    
                    v_list_of_onhold_amc.destroy();
                         
                     v_list_of_onhold_amc= $('#tbl_of_onhold_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'list_hold_amc'
                                    
                                 },
								 
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            				columnDefs: [
                                    { type: 'date-eu', targets: [5,6] }
                             ],
                              "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction',
                                        exportOptions: {
                                            //columns: [1, 2, 3,12, 9,7,10,11,5,6]
                                            columns: [1, 2, 3,13, 10,7,8,11,12,5,6]
                                        },
										filename: 'List of AMC - Hold',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
											// Loop over the cells 
											$('row c', sheet).each(function() {
											//select the index of the row
											var numero=$(this).parent().index() ;
												var residuo = numero%2;
												if (numero==1){           
													$(this).attr('s','22');//22 - Bold, blue background
												}else if (numero>1){
													// if(residuo ==0  ){//'is t',
													// $(this).attr('s','25');//25 - Normal text, fine black border
													// }else{
													// $(this).attr('s','32');//32 - Bold, gray background, fine black border
													// }
												}
											});
										},
                                    }
                                ],
                               
                            "columns": [
                                 {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                    
                                 },
                                 //{ "data": null,"width": "5%"},
                                 {"data": null,
                                    "width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
                                },
                                
								 { "data": "amc_ref_no"},
								 { "data": "contract_type_name"},
								 { "data": "customer_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "amc_start_date1","width": "20%"},
                                { "data": "amc_end_date1","width": "20%"},
                                { "data": "amc_total_amt"},
                                { "data": "total_amc_amount","visible":false },
                                { "data": "amc_ref_no",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_amc_child_details" data-toggle="modal" data-target="#modal_view_amc_child_details" style="color:black"><i class="icon-eye"></i> View Asset Details</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item" name="amc_active" style="color:black;"><i class="icon-database-edit2" style="color:black;"></i> Active</a><a href="#" class="dropdown-item" name="renew_amc_report" data-name="" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="amc_delete" style="color:red"><i class="icon-trash" style="color:red;"></i>Delete</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
								 { "data": "amc_description","visible":false },
								 { "data": "amc_vat_perct","visible":false},
								 { "data": "amc_vat_amt","visible":false},
								 { "data": "customer_name","visible":false},
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                            //     "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                            //      $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                            //      return nRow;
                            //   },
                            //   "drawCallback": function () {
                                  
                            //     }
                            
                     });  
					$("#div_data").LoadingOverlay("hide", true);
                 }
                  $('#tbl_of_onhold_amc tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_onhold_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details_onhold(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
	             
	              function format_amc_details_onhold(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Signed Date </div></td>'+
            				'<td ><div align="center">Amount Details </div></td>'+
            				'<td ><div align="center">VAT Details </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_amount).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_vat_amt).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+' ('+d.amc_vat_perct+' )'+'</div></td>'+
							
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Description </div></td>'+
            				'<td ><div align="center">Is RFP? </div></td>'+
            				'<td ><div align="center">Hold Reason</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_description+'</div></td>'+
            				'<td><div align="center">'+d.is_rfp+'</div></td>'+
            				'<td><div align="center">'+d.hold_description+'</div></td>'+
							
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Attachment 1</div></td>'+
            				'<td ><div align="center">AMC Attachment 2</div></td>'+
            				'<td ><div align="center">AMC Attachment 3</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment1_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment2_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment3_desc+'</div></td>'+
							
            				
            			  '</tr>'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Renewal Notes</div></td>'+
            				'<td ><div align="center">AMC Renewal Attachment</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				'<td><div align="center">'+d.amc_renewal_notes+'</div></td>'+
            					'<td><div align="center"><a href="../httpdocs/images/amc_renewal_attachments/'+d.amc_renewal_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		
		
	            }
	            
	        $("#tab_amc_complete").click(function(){
	            
	        load_data_to_grid_complete_amc_list();
	       });
	          
	             function load_data_to_grid_complete_amc_list()
                 {
                    
                    v_list_of_completed_amc.destroy();
                         
                     v_list_of_completed_amc= $('#tbl_of_completed_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'list_completed_amc'
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_completed_amc").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_completed_amc").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_completed_amc").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            				columnDefs: [
                                    { type: 'date-eu', targets: [5,6] }
                             ],
                              "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction', 
                                        exportOptions: {
                                             //columns: [1, 2, 3,12, 9,7,10,11,5,6]
                                             columns: [1, 2, 3,13, 10,7,8,11,12,5,6]
                                        },
										filename: 'List of AMC - Completed',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
											// Loop over the cells
											$('row c', sheet).each(function() {
											//select the index of the row
											var numero=$(this).parent().index() ;
												var residuo = numero%2;
												if (numero==1){           
													$(this).attr('s','22');//22 - Bold, blue background
												}else if (numero>1){
													// if(residuo ==0  ){//'is t',
													// $(this).attr('s','25');//25 - Normal text, fine black border
													// }else{
													// $(this).attr('s','32');//32 - Bold, gray background, fine black border
													// }
												}
											});
										},
                                    }
                                    
                                ],
                               
                            "columns": [
                                 {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                     
                                 },
                                 //{ "data": null,"width": "5%"},
                                 {"data": null,
                                    "width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
                                },
                                
								 { "data": "amc_ref_no"},
								 { "data": "contract_type_name"},
								 { "data": "customer_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                 { "data": "amc_start_date1","width": "20%"},
                                { "data": "amc_end_date1","width": "20%"},
                                { "data": "amc_total_amt"},
                                { "data": "total_amc_amount","visible":false },
                                 { "data": "amc_ref_no",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black;">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_amc_child_details" data-toggle="modal" data-target="#modal_view_amc_child_details" style="color:black;"><i class="icon-eye"></i> View Asset Details</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item" name="amc_active" style="color:black;"><i class="icon-database-edit2"style="color:black;"></i> Active</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="amc_delete" style="color:red;"><i class="icon-trash" style="color:red;"></i>Delete</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
								 { "data": "amc_description","visible":false },
								 { "data": "amc_vat_perct","visible":false},
								 { "data": "amc_vat_amt","visible":false},
								 { "data": "customer_name","visible":false},
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                            //     "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                            //      $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                            //      return nRow;
                            //   },
                            //   "drawCallback": function () {
                                  
                            //     }
                            
                     });  
                
                 }
                  $('#tbl_of_completed_amc tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_completed_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                
               
        $("#tab_amc_cancel").click(function(){
	            
	        load_data_to_grid_cancel_amc_list();
	       });
	          
	             function load_data_to_grid_cancel_amc_list()
                 {
                    
                    v_list_of_cancelled_amc.destroy();
                         
                     v_list_of_cancelled_amc= $('#tbl_of_cancelled_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'list_cancelled_amc'
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_cancelled_amc").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_cancelled_amc").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_cancelled_amc").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            					columnDefs: [
                                    { type: 'date-eu', targets: [5,6] }
                             ],
                              "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction',
                                        exportOptions: {
                                            //columns: [1, 2, 3,12, 9,7,10,11,5,6]
                                            columns: [1, 2, 3,13, 10,7,8,11,12,5,6]
                                        },
										filename: 'List of AMC - Cancelled',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
											// Loop over the cells
											$('row c', sheet).each(function() {
											//select the index of the row
											var numero=$(this).parent().index() ;
												var residuo = numero%2;
												if (numero==1){           
													$(this).attr('s','22');//22 - Bold, blue background
												}else if (numero>1){
													// if(residuo ==0  ){//'is t',
													// $(this).attr('s','25');//25 - Normal text, fine black border
													// }else{
													// $(this).attr('s','32');//32 - Bold, gray background, fine black border
													// }
												}
											});
										},
                                    }
                                ],
                               
            			
                            "columns": [
                                 {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                    
                                 },
                                 //{ "data": null,"width": "5%"},
                                 {"data": null,
                                    "width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
                                },
                                
								 { "data": "amc_ref_no"},
								 { "data": "contract_type_name"},
								 { "data": "customer_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 }, 
                                 { "data": "amc_start_date1","width": "20%"},
                                { "data": "amc_end_date1","width": "20%"},
                                { "data": "amc_total_amt"},
                                { "data": "total_amc_amount","visible":false },
                                 { "data": "amc_ref_no",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_amc_child_details" data-toggle="modal" data-target="#modal_view_amc_child_details" style="color:black"><i class="icon-eye"></i> View Asset Details</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item" name="amc_active" style="color:black"><i class="icon-database-edit2" style="color:black;"></i> Active</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="amc_delete" style="color:red"><i class="icon-trash" style="color:red;"></i>Delete</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
								 { "data": "amc_description","visible":false },
								 { "data": "amc_vat_perct","visible":false},
								 { "data": "amc_vat_amt","visible":false},
								 { "data": "customer_name","visible":false},
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                            //     "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                            //      $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                            //      return nRow;
                            //   },
                            //   "drawCallback": function () {
                                  
                            //     }
                            
                     });  
                
                 }
                  $('#tbl_of_cancelled_amc tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_cancelled_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details_cancelled(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                      function format_amc_details_cancelled(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Signed Date </div></td>'+
            				'<td ><div align="center">Amount Details </div></td>'+
            				'<td ><div align="center">VAT Details </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_amount).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_vat_amt).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+' ('+d.amc_vat_perct+' )'+'</div></td>'+
							
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Description </div></td>'+
            				'<td ><div align="center">Cancel Date </div></td>'+
            				'<td ><div align="center">Cancel Reason</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_description+'</div></td>'+
            				'<td><div align="center">'+d.cancelled_on+'</div></td>'+
            				'<td><div align="center">'+d.cancelled_description+'</div></td>'+
							
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Attachment 1</div></td>'+
            				'<td ><div align="center">AMC Attachment 2</div></td>'+
            				'<td ><div align="center">AMC Attachment 3</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment1_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment2_desc+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment3_desc+'</div></td>'+
							
            				
            			  '</tr>'+
            			'<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Renewal Notes</div></td>'+
            				'<td ><div align="center">AMC Renewal Attachment</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				'<td><div align="center">'+d.amc_renewal_notes+'</div></td>'+
            					'<td><div align="center"><a href="../httpdocs/images/amc_renewal_attachments/'+d.amc_renewal_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		 
		
	            }
	          
              $('#tbl_of_active_list_amc tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = v_list_active_amc.row($row).data();
                        var amc_id=data.amc_id;
                        var ref_no=data.amc_ref_no;
                        var contract_type=data.contract_type_name;
                        var customer_code=data.customer_code;
                        var customer_name=data.customer_name;
                       
                         if($(this).attr("name")=='view_amc_child_details')
                         {
                           $('#span_amc_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_child_details(data.amc_ref_no);
                           
            			 }
						 if($(this).attr("name")=='view_amc_subcontractors_details')
                         {
                           $('#span_amc_ref_no1').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_subcontractors_details(data.amc_ref_no);
                           
            			 }
            			 if($(this).attr("name")=='amc_delete')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Delete This Entry?",
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
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'amc_delete',amc_ref_no:ref_no}, function(result,status){
    						           
    						         if(status=='success')
    						          {
    						             
    						           swal("Success","Deleted Successfully","success"); 
    						           load_data_to_grid_active_amc_list();
    						           display_count();
    						           
    						          }
                                 
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
						 
						  if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
						 
						 if($(this).attr("name")=='qr_amc_customer')
						 {
						  //   alert("dfg");
						  //   var filePath = 'https://' + serverName + '/thc/printpdf/qr_code/generate_amc_qr.php?amc_ref_no=' + ref_no + '&amc_id=' + amc_id + '&contract_type=' + contract_type_1 + '&customer_code=' + customer_code + '&customer_name=' + customer_name;
				    //          window.open(filePath, '_blank');
						 }
          
                  });   
             
            $('#tbl_of_onhold_amc tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = v_list_of_onhold_amc.row($row).data();
                        var ref_no=data.amc_ref_no;
                         if($(this).attr("name")=='view_amc_child_details')
                         {
                           $('#span_amc_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_child_details(data.amc_ref_no);
                           
            			 }
						 if($(this).attr("name")=='view_amc_subcontractors_details')
                         {
                           $('#span_amc_ref_no1').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_subcontractors_details(data.amc_ref_no);
                           
            			 }
            			 if($(this).attr("name")=='amc_delete')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Delete This Entry?",
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
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'amc_delete',amc_ref_no:ref_no}, function(result,status){
    						           
    						         if(status=='success')
    						          {
    						             
    						           swal("Success","Deleted Successfully","success"); 
    						          
    						           load_data_to_grid_hold_amc_list();
    						           
    						           display_count();
    						           
    						          }
                                 
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
            			 }
            			  if($(this).attr("name")=='amc_active')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Active the Status?",
    							icon: 'warning',
    							dangerMode: true,
    							allowOutsideClick: false,
                                closeOnClickOutside: false,
    							buttons: {
    							cancel: 'No Cancel !',
    							 delete: 'Yes Please Active'
    							}
    							}).then(function (willDelete) {
    							if (willDelete) {
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'active_status',amc_ref_no:ref_no}, function(result,status){
    						           
    						         if(status=='success')
    						          {
    						             
    						           swal("Success","Status Changed Successfully","success"); 
    						           
    						           load_data_to_grid_hold_amc_list();
    						           
    						           display_count();
    						           
    						          }
                                 
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
						 
						 if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
            			 
            		
                        
                  }); 
            $('#tbl_of_completed_amc tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = v_list_of_completed_amc.row($row).data();
                        var ref_no=data.amc_ref_no;
                         if($(this).attr("name")=='view_amc_child_details')
                         {
                           $('#span_amc_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_child_details(data.amc_ref_no);
                           
            			 }
						 if($(this).attr("name")=='view_amc_subcontractors_details')
                         {
                           $('#span_amc_ref_no1').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_subcontractors_details(data.amc_ref_no);
                           
            			 }
            			 
            			 if($(this).attr("name")=='amc_delete')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Delete This Entry?",
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
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'amc_delete',amc_ref_no:ref_no}, function(result,status){
    						           
    						         if(status=='success')
    						          {
    						             
    						           swal("Success","Deleted Successfully","success");
    						           load_data_to_grid_complete_amc_list();
    						           display_count();
    						          
    						          }
                                 
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
            			 
            			 
            			 
            			  if($(this).attr("name")=='amc_active')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Active the Status?",
    							icon: 'warning',
    							dangerMode: true,
    							allowOutsideClick: false,
                                closeOnClickOutside: false,
    							buttons: {
    							cancel: 'No Cancel !',
    							 delete: 'Yes Please Active'
    							}
    							}).then(function (willDelete) {
    							if (willDelete) {
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'active_status',amc_ref_no:ref_no}, function(result,status){
                                    
                                   if(status=='success')
    						          {
    						             
    						           swal("Success","Status Changed Successfully","success"); 
    						           
    						           load_data_to_grid_complete_amc_list();
    						           display_count();
    						          }
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
            		  if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
                  }); 
            $('#tbl_of_cancelled_amc tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var data = v_list_of_cancelled_amc.row($row).data();
                        var ref_no=data.amc_ref_no;
                         if($(this).attr("name")=='view_amc_child_details')
                         {
                           $('#span_amc_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_child_details(data.amc_ref_no);
                           
            			 }
						 if($(this).attr("name")=='view_amc_subcontractors_details')
                         {
                           $('#span_amc_ref_no1').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_subcontractors_details(data.amc_ref_no);
                           
            			 }
            			 
            			 if($(this).attr("name")=='amc_delete')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Delete This Entry?",
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
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'amc_delete',amc_ref_no:ref_no}, function(result,status){
    						           
    						         if(status=='success')
    						          {
    						             
    						           swal("Success","Deleted Successfully","success"); 
    						           load_data_to_grid_cancel_amc_list();
    						           display_count();
    						          }
                                 
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
            			 
            			 
            			 if($(this).attr("name")=='amc_active')
                         {
                          swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Active the Status?",
    							icon: 'warning',
    							dangerMode: true,
    							allowOutsideClick: false,
                                closeOnClickOutside: false,
    							buttons: {
    							cancel: 'No Cancel !',
    							 delete: 'Yes Please Active'
    							}
    							}).then(function (willDelete) {
    							if (willDelete) {
    						     
    						       $.post("../controller/amc/amc_search_controller.php",{action:'active_status',amc_ref_no:ref_no}, function(result,status){
                                   if(status=='success')
    						          {
    						             
    						           swal("Success","Status Changed Successfully","success"); 
    						           
    						           load_data_to_grid_cancel_amc_list();
    						           display_count();  
    						          }
                                  });
                         
                             				  		 
    							} else {
    							}
    						 });
                             
                            
            			 }
						 if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
            		   
                  }); 
                  
            function load_data_to_grid_amc_child_details(amc_ref_no)
                 {
                    
                    v_list_of_amc_child.destroy();
                         
                     v_list_of_amc_child= $('#tbl_of_amc_child_details').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'action_view_amc_child_details',amc_ref_no:amc_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                    
                                 },
                                 { "data": null,"width": "5%"},
                                
								 { "data": "category_name"},
								 { "data": "asset_type_name"},
								 { "data": "asset_ref_no","width": "20%"},
								 { "data": "location_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['asset_location'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                 { "data": "building_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['asset_building'];
                                          
                                     	return str_active_status;
            
            							 }
                                 }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                  
                                }
                            
                     });  
                
                 }
                 
                   $('#tbl_of_amc_child_details tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_amc_child.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_child_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                      function format_amc_child_details(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Zone/Floor </div></td>'+
            				'<td ><div align="center"> Area Code </div></td>'+
            				'<td ><div align="center">Room No </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.zone_floor+'</div></td>'+
            				'<td><div align="center">'+d.flat_area_code+'</div></td>'+
            				'<td><div align="center">'+d.room_no+'</div></td>'+
							
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Location Details </div></td>'+
            				'<td ><div align="center">Brand </div></td>'+
            				'<td ><div align="center">Serial No</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.asset_sp_des+'</div></td>'+
            				'<td><div align="center">'+d.asset_brand+'</div></td>'+
            				'<td><div align="center">'+d.asset_serial_no+'</div></td>'+
							
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Capacity</div></td>'+
            				'<td ><div align="center">Cost</div></td>'+
            				'<td ><div align="center">Is Warrenty</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.asset_capacity+'</div></td>'+
            				'<td><div align="center">'+d.asset_cost+'</div></td>'+
            				'<td><div align="center">'+d.is_warentee+'</div></td>'+
							
            				
            			  '</tr>'+
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			  '<td ><div align="center">Warrenty End Date</div></td>'+
            			    '<td ><div align="center">Asset Description</div></td>'+
            				'<td ><div align="center">Asset Image</div></td>'+
            				
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.warentee_end_date+'</div></td>'+
            				'<td><div align="center">'+d.asset_description+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.asset_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Renewal Notes</div></td>'+
            				'<td ><div align="center">AMC Renewal Attachment</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				'<td><div align="center">'+d.amc_renewal_notes+'</div></td>'+
            					'<td><div align="center"><a href="../httpdocs/images/amc_renewal_attachments/'+d.amc_renewal_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
				
				
				function load_data_to_grid_amc_subcontractors_details(amc_ref_no)
                 {
                    
                    v_list_of_amc_subcontractors.destroy();
                         
                     v_list_of_amc_subcontractors= $('#tbl_of_amc_subcontractors_details').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'action_view_amc_subcontractors_details',amc_ref_no:amc_ref_no
                                    
                                 },

                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 
                                 { "data": null,"width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
								},
                                
								 { "data": "subcontractor_name","width": "15%"},
								 { "data": "contractor_description","width": "15%"},
								 { "data": "contract_amount"},
								 { "data": "contract_vat","width": "10%"},
								 { "data": "contract_total_amount","width": "10%" },
                                 { "data": "contract_start_date","width": "15%",
									render: function(data, type, row) {
										 
										return row.contract_start_date + ' - ' + row.contract_end_date;
									}
								 },
								 { "data": "file_name","width": "20%",
								  render: function ( data, type, rows, meta ) {
                                         
									  return '<div align="left"><a href="../httpdocs/images/amc_subcontractor_file_upload/'+data+'" target = "_blank" height="50px" width="50px">View Doc</a></div>';
             
									 },
								 }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                              },
                              "drawCallback": function () {
                                  
                                },
								"footerCallback": function (rows, data, start, end, display) {
                                var api = this.api();
								var intVal = function (i) {
									return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; 
								};

								var total_amount_rec = api
									.column(5, { page: 'current' })
									.data()
									.reduce(function (a, b) {
										return intVal(a) + intVal(b); 
									}, 0);

								v_list_of_amc_subcontractors.column(5).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }
                 
                 
                setInterval(function() {
                    var index = $.inArray("ListOfAMCExcel", permissions);
                    if (index === -1) {
                        $('.excel-button').css('display', 'none');
                    }
                    var SearchAMC = $.inArray("SearchAMCReport", permissions);
                     if (SearchAMC === -1) {
                       $('[name="renew_amc_report"]').hide();
                    }
                }, 1000);  
                 
      
});