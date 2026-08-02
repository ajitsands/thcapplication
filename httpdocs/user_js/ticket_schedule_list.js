$(document).ready(function(){

  
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
     $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });                
    var v_btn_search_tickets = $('#btn_search_tickets').ladda();
    var v_list_of_tickets_not_assigned=$('#tbl_of_scheduled_not_assigned_tickets').DataTable({});
    var v_list_of_tickets_assigned = $('#tbl_of_scheduled_assigned_tickets').DataTable({});
    var v_list_of_tickets_extended = $('#tbl_of_extended_tickets').DataTable({});
    var v_list_of_tickets_completed = $('#tbl_of_completed_tickets').DataTable({});
    var v_list_of_tickets_closed = $('#tbl_of_closed_tickets').DataTable({});
    var v_list_of_tickets_cancelled = $('#tbl_of_cancelled_tickets').DataTable({}); 
    
    list_entries();
   
    $("#btn_search_tickets").click(function(){
	list_entries();
	}); 
	function display_count()
	{
	    var start_date=$('#txt_start_date').val();
		var end_date=$('#txt_end_date').val();
		$.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_not_assigned',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_not_assigned').html(d.data[0].count_not_assigned);
        });
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_assigned',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_assigned').html(d.data[0].count_assigned);
        });
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_extended',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_extended').html(d.data[0].count_extended);
        });
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_completed',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_completed').html(d.data[0].count_completed);
        });
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_closed',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_closed').html(d.data[0].count_closed);
        });
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_count_cancelled',start_date:start_date,end_date:end_date},function(result,status){
                d = JSON.parse(result);
                $('#span_count_cancelled').html(d.data[0].count_cancelled);
        });
	
	}
	var start_date,end_date;
	var v_customer_name,v_customer;
    function list_entries()
    {
        //v_btn_search_tickets.ladda( 'start' );
		start_date=$('#txt_start_date').val();
		end_date=$('#txt_end_date').val();
		v_customer=$("#select_customer option:selected").val();
		v_customer_name=$("#select_customer option:selected").text();
		
		if(start_date=='' || end_date=='')
		{
		    swal("Warning","Please specify the date range...", "warning");
           //v_btn_search_tickets.ladda( 'stop' );
            return false;  
		}
		if(end_date<start_date)
		{
		    swal("Warning","Please provide valid date range...", "warning");
           //v_btn_search_tickets.ladda( 'stop' );
            return false; 
		}
		else
		{
		   
            
            load_data_to_grid_scheduled_not_assigned_list(start_date,end_date,v_customer);
			load_data_to_grid_scheduled_assigned_list(start_date,end_date,v_customer);
			load_data_to_grid_extended_list(start_date,end_date,v_customer);
			load_data_to_grid_completed_list(start_date,end_date,v_customer);
			load_data_to_grid_closed_list(start_date,end_date,v_customer);
			load_data_to_grid_cancelled_list(start_date,end_date,v_customer);
            display_count();
		}
	
    }
    
         
                     
           
                 function load_data_to_grid_scheduled_not_assigned_list(start_date,end_date,v_customer)
                 {
                     var i=1;
                    v_list_of_tickets_not_assigned.destroy();
                         
                     v_list_of_tickets_not_assigned= $('#tbl_of_scheduled_not_assigned_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_not_assigned',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 },
								beforeSend: function () {
									$("#tbl_of_scheduled_not_assigned_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_scheduled_not_assigned_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_scheduled_not_assigned_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Not Assigned',
									},
								],
                            "columns": [
                               
                                 { "data": null,"width": "5%",
                                       "render": function (data, type, row, meta) {
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item" name="print_wo"  style="color:black" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item" name="print_sr"  style="color:black" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                           
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                   var table = this.api();
									table.buttons('.excel-button').nodes().css('display', 'none');
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                    v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 }
				 
			$('#not_assigned_pdf').on('click', function() {
				//v_list_of_tickets_not_assigned.button('.pdf-button').trigger();
				var filePath='not_assigned_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
				window.open(filePath, '_blank'); 
			});	
			
			
			$('#not_assigned_excel').on('click', function() {
				v_list_of_tickets_not_assigned.button('.excel-button').trigger();
			});		
			
			
               $('#tbl_of_scheduled_not_assigned_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_not_assigned.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket_details_search')
                         {
                                $('#div_close').hide();
                                $('#div_close_service_report').hide();
                                $('#div_cancel').hide();
                                
                              
                             $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                                var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                        $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                        
                                        var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                        
                                       
                                       
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
             
            			 }
            		
                        
                  });   
         
    $("#a_workorder_print").click(function(){
	    var tkt_ids=$("#txt_tkt_id").val();
	   var filePath='../view/work_order_print.php?ticket_id='+tkt_ids;
	    window.open(filePath );
	});  
    $("#span_ticket_image").click(function(){
	    var img_to_load=$("#txt_tkt_image_url").val();
	  //  var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(img_to_load );
	}); 
	$("#span_ticket_image2").click(function(){
	    var img_to_load=$("#txt_tkt_image_url2").val();
	  //  var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(img_to_load );
	}); 
	
	 $("#span_service_report_image").click(function(){
	    var img_to_load=$("#txt_tkt_service_reportimage_url").val();
	    
	  //  var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(img_to_load );
	});
     $("#a_view_team").click(function(){
          var tkt_id=$("#txt_tkt_id").val();
           var visit_id=$("#txt_visit_id").val();
            load_data_to_grid_team_list(tkt_id,visit_id);
     });
      $("#a_view_services").click(function(){
          var tkt_id=$("#txt_tkt_id").val();
           var visit_id=$("#txt_visit_id").val();
            $.ajax({
        		type: "POST",
        		url: "tickets/services_list_completed_modal.php",
        		data: {ticket_id:tkt_id} 
        		 }).done(function(data){
        		     
        			$("#div_services_list").html(data);
        		 });
     });
           var list_of_team = $('#tbl_view_team_search').DataTable();
           function load_data_to_grid_team_list(ticket_id,visit_id)
                 {
                     
                    list_of_team.destroy();
                         
                     list_of_team = $('#tbl_view_team_search').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
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
             
           
                 function load_data_to_grid_scheduled_assigned_list(start_date,end_date,v_customer)
                 {
					
                     var i=1;
                    v_list_of_tickets_assigned.destroy();
                         
                     v_list_of_tickets_assigned = $('#tbl_of_scheduled_assigned_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_assigned',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_scheduled_assigned_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_scheduled_assigned_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_scheduled_assigned_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
							 
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Assigned',
									},
								],
								"initComplete": function( settings, json ) {
                                    
                              $('.excel-button').css('display', 'none');
							  console.log("kjk");
             
                              },
								
                            "columns": [
                               
                               
                                  { "data": null,"width": "5%",
                                       "render": function (data, type, row, meta) {
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item"  style="color:black" name="print_wo" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item" name="print_sr"  style="color:black" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
                            
            				
                             
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   // v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 }  

		$('#assigned_pdf').on('click', function() {
			//alert(start_date+end_date+v_customer_id+v_customer);
			var filePath='assigned_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
			 window.open(filePath, '_blank'); 
		});	

		$('#assigned_excel').on('click', function() {
			v_list_of_tickets_assigned.button('.excel-button').trigger();
			//exportDataTableToExcel(v_list_of_tickets_assigned);
		});			
                 
                 
          $('#tbl_of_scheduled_assigned_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_assigned.row($row).data();
                       
                       if($(this).attr("name")=='view_ticket_details_search')
                         {
                              $('#div_close').hide();
                                $('#div_close_service_report').hide();
                                $('#div_cancel').hide();
                                
                              $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                              var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                         $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                        
                                        var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
                              
             
            			 }
                        
                  });   
                       
                 
              function load_data_to_grid_extended_list(start_date,end_date,v_customer)
                 {
                     var i=1;
                    v_list_of_tickets_extended.destroy();
                         
                     v_list_of_tickets_extended = $('#tbl_of_extended_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_extended',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_extended_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_extended_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_extended_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Extended',
									},
								],
            			
                            "columns": [
                               
                                 { "data": null,"width": "5%",
                                       "render": function (data, type, row, meta) {
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item" name="print_wo"  style="color:black" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item" name="print_sr"  style="color:black" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   // v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 }    
			$('#extended_pdf').on('click', function() {
				//v_list_of_tickets_extended.button('.pdf-button').trigger();
				var filePath='extended_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
				window.open(filePath, '_blank'); 
			});	

			$('#extended_excel').on('click', function() {
			    v_list_of_tickets_extended.button('.excel-button').trigger();
				//exportDataTableToExcel(v_list_of_tickets_extended);
			});		
			
             $('#tbl_of_extended_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_extended.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket_details_search')
                         {
                               $('#div_close').hide();
                                $('#div_close_service_report').hide();
                                $('#div_cancel').hide();
                                
                              $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                              var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                         $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                        
                                        var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
                              
             
            			 }
            		
                        
                  });            
                 
           function load_data_to_grid_completed_list(start_date,end_date,v_customer)
                 {
                     var i=1;
                    v_list_of_tickets_completed.destroy();
                         
                     v_list_of_tickets_completed = $('#tbl_of_completed_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_completed',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 },
								  beforeSend: function () {
									$("#tbl_of_completed_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_completed_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_completed_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Completed',
									},
								],
            			
                            "columns": [
                               
                                { "data": null,"width": "5%",
                                       "render": function (data, type, row, meta) {
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item" name="print_wo"  style="color:black" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item" name="print_sr" style="color:black" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                               //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   // v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 }  

			$('#completed_pdf').on('click', function() {
				//v_list_of_tickets_completed.button('.pdf-button').trigger();
				var filePath='completed_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
				window.open(filePath, '_blank'); 
			});	

			$('#completed_excel').on('click', function() {
				v_list_of_tickets_completed.button('.excel-button').trigger();
				//exportDataTableToExcel(v_list_of_tickets_completed);
			});						 
                 
                    $('#tbl_of_completed_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_completed.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket_details_search')
                         {
                              $('#div_close').show();
                                $('#div_close_service_report').show();
                                $('#div_cancel').hide();
                                
                             $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                                var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                         $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                        
                                        var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
                              
             
            			 }
            		
                        
                  });     
                         
                  function load_data_to_grid_closed_list(start_date,end_date,v_customer)
                 {
                    var i=1; 
                    v_list_of_tickets_closed.destroy();
                         
                     v_list_of_tickets_closed = $('#tbl_of_closed_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_closed',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 },
								 beforeSend: function () {
									$("#tbl_of_closed_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_closed_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_closed_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
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
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item"  style="color:black" name="print_wo" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" name="print_sr" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                             //    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                              //   return nRow;
                              },
                              "drawCallback": function () {
                                   // v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 }    
				 
			   $('#closed_pdf').on('click', function() {
					//v_list_of_tickets_closed.button('.pdf-button').trigger();
					var filePath='closed_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
					window.open(filePath, '_blank'); 
				});	

				$('#closed_excel').on('click', function() {
					v_list_of_tickets_closed.button('.excel-button').trigger();
				});	   
                      
                  $('#tbl_of_closed_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_closed.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket_details_search')
                         {
                              $('#div_close').show();
                                $('#div_close_service_report').show();
                                $('#div_cancel').hide();
                              $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                                var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                         $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                        var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
                              
             
            			 }
            		
                        
                  });     
                                  
                function load_data_to_grid_cancelled_list(start_date,end_date,v_customer)
                 {
                     var i=1;
                    v_list_of_tickets_cancelled.destroy();
                         
                     v_list_of_tickets_cancelled = $('#tbl_of_cancelled_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_scheduled_ticket_cancelled',start_date:start_date,end_date:end_date,customer:v_customer
                                    
                                 }, 
								 beforeSend: function () {
									$("#tbl_of_cancelled_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_cancelled_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_cancelled_tickets").LoadingOverlay("hide");
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
                                    { type: 'date-eu', targets: 1 }
                             ],
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6] 
                                        },
										filename: 'List of Work Order - Cancelled',
									},
								],
            			
                            "columns": [
                               
                                { "data": null,"width": "5%",
                                       "render": function (data, type, row, meta) {
										    if (row['amc_tkt_ref_no'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                    },
                                 { "data": "date_of_visits1",
								 render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								 },  
                                 { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
										return '';
									  }	
									  else
									  {
										  if(rows['additional_slots']!=0)
										  {
											  
											   var endslot=parseInt(data)+parseInt(rows['additional_slots']);
											   
											   str_active_status=data+' - '+endslot;
										  }
										 else
										 {
											  str_active_status=data;
										 }
											  
											return str_active_status;
									  }
									  }
                                  },
								 { "data": "amc_tkt_id",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["amc_tkt_ref_no"]+'-'+rows["amc_tkt_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
												return 'No records available';
										  }
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name",
									render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
								},
                                { "data": "building_name",
									render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }	
										  return data;
									}
								},
                                 { "data": "amc_tkt_ref_no",
                                      render: function ( data, type, rows, meta ) {
										  if (data === 'NA') {
												return '';
										  }
                                         str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">		<a href="#" class="dropdown-item" name="view_ticket_details_search" data-toggle="modal" data-target="#modal_view_ticket_details_search" style="color:black"><i class="icon-eye"></i> View Details</a><a  class="dropdown-item"  style="color:black" name="print_wo" href="../view/work_order_print.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" name="print_sr" href="../view/service_report.php?ticket_id='+rows["amc_tkt_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   // v_btn_search_tickets.ladda( 'stop' );
                                }
                            
                     });  
                
                 } 
				 
				$('#cancelled_pdf').on('click', function() {
					//v_list_of_tickets_cancelled.button('.pdf-button').trigger();
					var filePath='cancelled_workorder_print.php?start_date='+start_date+'&end_date='+end_date+'&v_customer='+v_customer+'&v_customer_name='+v_customer_name;
					window.open(filePath, '_blank'); 
				});	

				$('#cancelled_excel').on('click', function() {
					v_list_of_tickets_cancelled.button('.excel-button').trigger();
				});	  
                 
                 
                   $('#tbl_of_cancelled_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_tickets_cancelled.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket_details_search')
                         {
                              $('#div_close').hide();
                                $('#div_close_service_report').hide();
                                $('#div_cancel').show();
                             $('#span_ticket_ref_no_view_ticket_search').html('WO-'+ticket_data.amc_tkt_ref_no+'-'+ticket_data.amc_tkt_id);
                              $('#span_visit_date').html(ticket_data.date_of_visits1);
                               var toslot=parseInt(ticket_data.time_of_visit)+parseInt(ticket_data.additional_slots);
                                 if(ticket_data.additional_slots!=0)
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit+' - '+toslot);
                                 }
                                 else
                                 {
                                     $('#span_visit_slots').html(ticket_data.time_of_visit);
                                 }
                                $('#span_visit_start_time').html(ticket_data.visit_start_time);
                                $('#txt_tkt_id').val(ticket_data.amc_tkt_id);
                                $('#txt_visit_id').val(ticket_data.amc_visit_id);
                                
                               $.post('../controller/ticket/ticket_assign_controller.php',{action:'action_view_details',ticket_id:ticket_data.amc_tkt_id},function(result,status){
                                        d = JSON.parse(result);
                                        $('#span_priority').html(d.data[0].ticket_priority);
                                        $('#span_service_request').html(d.data[0].service_request);
                                        $('#span_job_category').html(d.data[0].job_category);
                                        $('#span_loc_details').html(d.data[0].location_code+" - "+d.data[0].location_name);
                                        $('#span_build_details').html(d.data[0].building_code+" - "+d.data[0].building_name);
                                        $('#span_cust_details').html(d.data[0].customer_code+" - "+d.data[0].customer_name);
                                        $('#span_booked_date').html(d.data[0].created_date_time);
                                        $('#span_req_date').html(d.data[0].date_needed);
                                         $('#span_quote_details').html(d.data[0].quote_required+'  '+d.data[0].quote_ref_no);
                                        $('#span_complaint').html(d.data[0].complaints_description);
                                        $('#span_add_info').html(d.data[0].additional_info);
                                        $('#txt_tkt_image_url').val(d.data[0].ticket_image);
                                        $('#txt_tkt_image_url2').val(d.data[0].ticket_image2);
                                         var ser_report_img;
                                        if(d.data[0].service_report_image=='http://thc.sianlab.com/httpdocs/images/ticket_close_image/NA')
                                        {
                                            ser_report_img='http://thc.sianlab.com/httpdocs/images/ticket_close_image/default.jpg'
                                        }
                                        else
                                        {
                                           ser_report_img= d.data[0].service_report_image;
                                        }
                                        $('#txt_tkt_service_reportimage_url').val(ser_report_img);
                                        $('#span_report_no').html(d.data[0].service_report_no);
                                        $('#span_close_remarks').html(d.data[0].closed_reason);
                                        $('#span_close_by').html(d.data[0].closed_by_name);
                                        $('#span_close_on').html(d.data[0].closed_on);
                                        $('#span_cancel_by').html(d.data[0].cancelled_by_name);
                                        $('#span_cancel_remarks').html(d.data[0].cancelled_reason);
                                        $('#span_cancel_on').html(d.data[0].cancelled_date_time);
                                        
                                       
                                        
                                });
                                 load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                                $.ajax({
                            		type: "POST",
                            		url: "tickets/services_list_completed_modal.php",
                            		data: {ticket_id:ticket_data.amc_tkt_id} 
                            		 }).done(function(data){
                            		     
                            			$("#div_services_list").html(data);
                            		 });
                              
             
            			 }
            		
                        
                  });    
                  
    var txt_workordrnumber = $('#txt_workordrnumber').val();
    if(txt_workordrnumber!=="")
    {
        $('#tab_tickets_assigned').click();
        v_list_of_tickets_assigned.search(txt_workordrnumber).draw();
    }
    
    setInterval(function() {
        var PrintWO = $.inArray("PrintWO", permissions);
        if (PrintWO === -1) {
             $('[name="print_wo"]').hide();
        }
        var PrintSR = $.inArray("PrintSR", permissions);
        if (PrintSR === -1) {
           $('[name="print_sr"]').hide();
        }
    }, 1000);
                  
				
});