$(document).ready(function(){
    
                 
       $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });  
	
	var v_list_of_tickets_closed = $('#tbl_closed_tickets').DataTable({});	
	load_data_to_completed_ticket_list();
	
	 function load_data_to_completed_ticket_list()
                 {
                    var i=1; 
                    v_list_of_tickets_closed.destroy();
                         
                     v_list_of_tickets_closed = $('#tbl_closed_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST', 
                                 'url': '../controller/ticket/ticket_closed_controller.php',
                                 'data': {
                                    action: 'list_closed_ticket'
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_closed_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_closed_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_closed_tickets").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Closed',
									},
								],
            			
                            "columns": [
                               
                                { "data": null,"width": "5%",
                                        "render": function (data, type, row, meta) {
											return meta.row + 1; 
										}
                                    },
                                 { "data": "created_date_time","type": "dom-date" },
								 { "data": "ticket_ref_code"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "location_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=rows['location_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "building_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=rows['building_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                               
                                 { "data": "ticket_priority",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Emergency':
                                                   str_active_status='<span class="badge badge-danger">'+data+'</span>'
                                              break;
                                              case 'Urgent':
                                                   str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                              break;
                                              case 'Essential':
                                                   str_active_status='<span class="badge badge-info">'+data+'</span>'
                                              break;
                                              case 'Normal':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                              default:
                                              str_active_status='<span class="badge bg-slate">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "ticket_ref_code",
                                      render: function ( data, type, rows, meta ) {
                                        var dropdownOptions = {
                                            "WoClosedModify": "Print WO",
                                            "WoClosedModify": "Print SR",
                                            "WoClosedModify": "View Tickets"
                                        };
                                        
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                          
                                       var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: black;"> <i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';                                        

                                        if(filteredOptions=="WoClosedModify")
                                          {
                                              dropdownHTML += '<a  class="dropdown-item"  style="color:black" name="closedWOPrint" href="../view/work_order_print.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" name="closedSRPrint" href="../view/service_report.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a> <a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_complaints" style="color:black"><i class="icon-eye"></i> View Tickets</a>';
                                          }
                                          else
                                          {
                                              dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
                                          }
                                        
                                        dropdownHTML += '</div></div></div>';
                                        return dropdownHTML;
                                        
                                      }    
                                
                                 }
                                //  { "data": "ticket_ref_code",
                                //       render: function ( data, type, rows, meta ) {
                                //          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a  class="dropdown-item"  style="color:black" href="../view/work_order_print.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" href="../view/service_report.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a> <a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_complaints" style="color:black"><i class="icon-eye"></i> View Tickets</a></div></div></div>';
                                //           return str_active_status_edit;
                                //       }   
                                //  }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                                $.extend($.fn.dataTableExt.oSort, {
                                    "dom-date-pre": function(a) {
                                        return moment(a, "DD-MM-YYYY HH:mm:ss")
                                    },
                                    "dom-date-asc": function(a, b) {
                                        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                                    },
                                    "dom-date-desc": function(a, b) {
                                        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                                    },
									
									
                                });
								$('.excel-button').hide();
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                 
                             $('#tbl_closed_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_closed.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket')
                         {
                          
                             $('#span_ticket_ref_no_closed_view_ticket').html(ticket_data.ticket_ref_code);
                             $('#span_customer_closed_view_ticket').html('   Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_location_closed_view_ticket').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_building_closed_view_ticket').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                             
                            load_data_to_grid_entries_list(ticket_data.ticket_ref_code);
               
            			 }
            			
            		
                        
                  });
       
   
                   var v_list_ticket_closed_entries = $('#tbl_closed_entries').DataTable({});
                     
					  
           
                 function load_data_to_grid_entries_list(ticket_ref_code)
                 {
                     var i=1;
                    v_list_ticket_closed_entries.destroy();
                         
                     v_list_ticket_closed_entries = $('#tbl_closed_entries').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_closed_controller.php',
                                 'data': {
                                    action: 'list_ticket_entries',ticket_ref_code:ticket_ref_code
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 1, "asc" ]],
                           
            				"bPaginate": false,
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
                                    "width": '5%',
                                 },
                                  { "data": null,"width": "5%",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "ticket_id",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status='WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"];
                                         
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "category_name" },
								 { "data": "type_name"},
								  { "data": "asset_code",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='0' || data=='NA' || data==0)
                                          {
                                              str_active_status='NA';
                                          }
                                          else
                                          {
                                              str_active_status=data;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								  { "data": "ticket_priority",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Emergency':
                                                   str_active_status='<span class="badge badge-danger">'+data+'</span>'
                                              break;
                                              case 'Urgent':
                                                   str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                              break;
                                              case 'Essential':
                                                   str_active_status='<span class="badge badge-info">'+data+'</span>'
                                              break;
                                              case 'Normal':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                              default:
                                              str_active_status='<span class="badge bg-slate-400">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 },
      
                                   { "data": "ticket_ref_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                         
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="view_visits" data-toggle="modal" data-target="#modal_view_visits" style="color:black"><i class="icon-calendar3"></i> View Visits</a>	<a href="#" class="dropdown-item" name="view_services" data-toggle="modal" data-target="#modal_view_services" style="color:black"><i class="icon-hammer-wrench"></i> View Services</a><div class="dropdown-divider"></div></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8] }, 
            					
            				// ],
                           
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
     

     
                 
     $('#tbl_closed_entries tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        
        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var data = v_list_ticket_closed_entries.row($row).data();
            $('#txt_hidden_ticket_close_id').val(data.ticket_id);
            $('#txt_service_report_no').val(data.service_report_no);
            $('#txt_remarks').val(data.closed_reason);
            $('#txt_service_closed_remarks').val(data.service_report_remarks);
            $('#txt_hidden_ticket_image_close').val(data.service_report_image);
            
            $("#check_foc").val($.trim(data.foc)).trigger("change"); 
           
            
            
            
           
        }
    } ); 
                 
      $('#tbl_closed_entries tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_list_ticket_closed_entries.row($row).data();
       
        
         if($(this).attr("name")=='view_visits')
         {
              $('#span_ticket_ref_no_closed_view_visits').html(data.ticket_ref_code);
          load_data_to_grid_visit_list(data.ticket_id);
          load_data_to_grid_team_list(0,0);
         }
       if($(this).attr("name")=='view_services')
         {
        $('#span_ticket_ref_no_closed_view_services').html(data.ticket_ref_code);
             $.ajax({
        		type: "POST",
        		url: "tickets/services_list_completed_modal.php",
        		data: {ticket_id:data.ticket_id} 
        		 }).done(function(data){
        		     
        			$("#div_services_list").html(data);
        		 });
         }
          
       
    });

	
    
      $('#tbl_closed_entries tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = v_list_ticket_closed_entries.row( tr );
           
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format_entries(row.data()) ).show();
                tr.addClass('shown');
               
                 
            }
        } );
        
        
           function format_entries(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Complaint </div></td>'+
            				'<td ><div align="center">Date Needed </div></td>'+
            				'<td ><div align="center">Additional Info </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.complaints_description+'</div></td>'+
            				'<td><div align="center">'+d.date_needed+'</div></td>'+
            				'<td><div align="center">'+d.additional_info+'</div></td>'+
							
            				
            			  '</tr>'+
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Service Request </div></td>'+
            				'<td ><div align="center">Job Category</div></td>'+
            				'<td ><div align="center">Quote Details</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.service_request+'</div></td>'+
            				'<td><div align="center">'+d.job_category+'</div></td>'+
            				'<td><div align="center">'+d.quote_ref_no+' - '+d.quote_required+'</div></td>'+
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	            
	            var v_list_ticket_closed_visits = $('#tbl_closed_visits').DataTable({});
                     
					  
           
                 function load_data_to_grid_visit_list(ticket_id)
                 {
                     var i=1;
                    v_list_ticket_closed_visits.destroy();
                         
                     v_list_ticket_closed_visits = $('#tbl_closed_visits').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_closed_controller.php',
                                 'data': {
                                    action: 'list_ticket_visits',ticket_id:ticket_id
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "asc" ]],
                           
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            				columnDefs: [
                                    { type: 'date-eu', targets: 1 }
                             ],
                            "columns": [
                                
                                  { "data": null,"width": "5%",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "date_of_visits" },
								 { "data": "time_of_visit"},
								 { "data": "additional_slots"},
							     { "data": "visit_start_time"}
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
 

    
     $('#tbl_closed_visits tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
           
        }
        else {
            v_list_ticket_closed_visits.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var data = v_list_ticket_closed_visits.row($row).data();
          load_data_to_grid_team_list(data.amc_tkt_id,data.amc_visit_id);
             
        }
    } );
          
   
 
  var v_list_ticket_closed_team = $('#tbl_closed_team').DataTable({});
                     
					  
           
                 function load_data_to_grid_team_list(ticket_id,visit_id)
                 {
                     
                    v_list_ticket_closed_team.destroy();
                         
                     v_list_ticket_closed_team = $('#tbl_closed_team').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_closed_controller.php',
                                 'data': {
                                    action: 'list_ticket_team',ticket_id:ticket_id,visit_id:visit_id
                                    
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
                                
                                 { "data": null,"width": "5%"},
                                 { "data": "employee_code" },
								 { "data": "employee_name"},
								 { "data": "employee_contact_no"},
							     { "data": "is_leader"},
							      { "data": "is_attend"}
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				// ],
                            
            				
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
 
 
 
  var v_session_image;
     $('#session_image_close').change(function (e) {
                         
            v_session_image = $("#session_image_close").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image=="")
            {
                v_session_image="default.jpg";
                 $("#txt_hidden_ticket_image_close").val('default.jpg');
            }
            else
            {
                var doc_file_obj = $("#session_image_close")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_close_image_upload.php?random_no="+randomNum);
                v_session_image=$.trim(randomNum+'_'+doc_file1);
                 $('#txt_hidden_ticket_image_close').val(v_session_image);
                
            }     
      });
          
        $("#update_ticket_st").click(function(){
        
	  
	    var close_ticket_id=$('#txt_hidden_ticket_close_id').val();
		var service_report_no=$('#txt_service_report_no').val();
		var service_closed_remarks=$('#txt_service_closed_remarks').val();
		var close_remarks=$('#txt_remarks').val();
		var foc=$("#check_foc option:selected").val();
     var close_table_selected_count = v_list_ticket_closed_entries.rows('.selected').data().length;
        if($.trim(close_table_selected_count)==0)
        {
            swal("Warning","Please select WO...", "warning");
            return false;
        }
		if($.trim(service_report_no)=="")
        {
            swal("Warning","Please  provide the service report no...", "warning");
            return false;
        }
        
        if($.trim(service_closed_remarks)=="")
        {
            swal("Warning","Please  provide the service report remark...", "warning");
            return false;
        }
        else
        {
            				swal({
						  title: "Are you sure?",
						  text: "Do you want to update the work order?",
						  icon: "warning",
						  buttons: ['No, Cancel It!','Yes, Proceed!'],
						  dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) {
							var v_session_image1=$('#txt_hidden_ticket_image_close').val();
                		        $.post("../controller/ticket/ticket_closed_controller.php",{action:'update_close_ticket',ticket_id:close_ticket_id,close_remarks:close_remarks,close_image:v_session_image1,ticket_count:close_table_selected_count,service_report_no:service_report_no,foc:foc,service_closed_remarks:service_closed_remarks}
                                  , function(result,status)
                                    {
                        		
                        				if(status=='success')
                        			{
                        			
                        				   
                        					swal("Success", "WO updated successfully..", "success");
                        					location.reload();
                        				
                        				   
                        			}
                    				else
                    				{
                    				
                    					swal("Error", result, "error");
                    					return false;
                    				}
                		
                		    	});
							
						  }
						  else {
							 return false;
						
						  }
						});
        }
	
        });
          
      $("#txt_hidden_ticket_image_close").val('NA');     
          
    $("#btn_remove_ticket_image_close").click(function(){
	    
	    $('#session_image_close').val('');
        $("#txt_hidden_ticket_image_close").val('NA');
        v_session_image="";
	});
	

	$("#i_image").click(function(){
	    var img_to_load=$("#txt_hidden_ticket_image_close").val();
	    if(img_to_load=='NA')
	    {
	        img_to_load='default.jpg';
	    }
	    var filePath='../httpdocs/images/ticket_close_image/';
	    window.open(filePath + img_to_load );
	});            
				 
			  $('#closed_pdf').on('click', function() {
					//alert(start_date+end_date+v_customer_id+v_customer);
					var filePath='closed_workorder_management_print.php';
					 window.open(filePath, '_blank'); 
				});	

				$('#closed_excel').on('click', function() {
					v_list_of_tickets_closed.button('.excel-button').trigger();
				});	
				
     setInterval(function() {
        var ClosedWOPrint = $.inArray("ClosedWOPrint", permissions);
        if (ClosedWOPrint === -1) {
             $('[name="closedWOPrint"]').hide();
        }
        var ClosedSRPrint = $.inArray("ClosedSRPrint", permissions);
        if (ClosedSRPrint === -1) {
           $('[name="closedSRPrint"]').hide();
        }
    }, 1000);		
				
});