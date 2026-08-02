$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
     $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });                
   
     var v_list_of_tickets_not_assigned=$('#tbl_of_scheduled_not_assigned_tickets').DataTable({});
    var wo_condition=$('#txt_wo_condition').val();
    var wo_type=$('#txt_wo_type').val();
  
             load_data_to_grid_scheduled_not_assigned_list($.trim(wo_condition),$.trim(wo_type));      
                     
           
                 function load_data_to_grid_scheduled_not_assigned_list(wo_condition,wo_type)
                 {
                     var i=1;
                    v_list_of_tickets_not_assigned.destroy();
                         
                     v_list_of_tickets_not_assigned= $('#tbl_of_scheduled_not_assigned_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/dashboard/dashboard_controller.php',
                                 'data': {
                                    action: 'list_dash_wos',wo_condition:wo_condition,wo_type:wo_type
                                    
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
            					columnDefs: [
                                    { type: 'date-eu', targets: 1 }
                             ],
            			
            			
                            "columns": [
                               
                                 { "data": null,"width": "5%",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "date_of_visits1" },
                               
								 { "data": "ticket_id",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"]+'</a>';
                                         
                                     	return str_active_status;
            
            							 },
                                 },
								 //{ "data": "amc_tkt_ref_no"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                { "data": "location_name"},
                                { "data": "building_name"}
                               
                       
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
                                  
                                }
                            
                     });  
                
                 }
                 
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
             
           
                    // load_data_to_grid_team_list(ticket_data.amc_tkt_id,ticket_data.amc_visit_id);
                    //             $.ajax({
                    //         		type: "POST",
                    //         		url: "tickets/services_list_completed_modal.php",
                    //         		data: {ticket_id:ticket_data.amc_tkt_id} 
                    //         		 }).done(function(data){
                            		     
                    //         			$("#div_services_list").html(data);
                    //         		 });
                              
             
            		    
});