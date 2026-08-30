$(document).ready(function(){
                 
       $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });          
                    var v_list_of_extended_tickets = $('#tbl_of_reschedule_tickets').DataTable({});
                      load_data_to_grid_extended_ticket_list();
					  
           
                 function load_data_to_grid_extended_ticket_list()
                 {
                     var i=1;
                    v_list_of_extended_tickets.destroy();
                         
                     v_list_of_extended_tickets = $('#tbl_of_reschedule_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_extended_controller.php',
                                 'data': {
                                    action: 'list_extended_ticket'
                                    
                                 },
								  beforeSend: function () {
									$("#tbl_of_reschedule_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_reschedule_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_reschedule_tickets").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                { "data": null,"width": "5%",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
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
                                         // str_active_status=data+' - '+rows['location_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "building_code",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status=rows['building_name'];
                                        //  str_active_status=data+' - '+rows['building_name'];
                                          
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
                                            "WoExtensionModify": "View / Edit",
                                            "WoExtensionModify": "Schedule & Assign",
                                            "WoExtensionModify": "Change Status"
                                        }; 
                                        
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });  
                                       
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: black;"> <i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                          if(filteredOptions=="WoExtensionModify")
                                          {
                                              dropdownHTML += ' <a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_ticket" style="color: black;"><i class="icon-eye"></i> View Ticket</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="schedule_ticket_multiple" style="color: black;" data-toggle="modal" data-target="#modal_schedule_ticket_multiple"><i class="icon-calendar"></i>Schedule & Assign </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="change_status_ticket" style="color: black;" data-toggle="modal" data-target="#modal_change_status_ticket"><i class="icon-pencil5"></i> Change Status</a>';  
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
                                          
                                         
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_ticket" style="color:black"><i class="icon-eye"></i> View Ticket</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="schedule_ticket_multiple" style="color:black" data-toggle="modal" data-target="#modal_schedule_ticket_multiple"><i class="icon-calendar"></i>Schedule & Assign </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="change_status_ticket" style="color:black" data-toggle="modal" data-target="#modal_change_status_ticket"><i class="icon-pencil5"></i> Change Status</a></div></div></div>';
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
                                    }
                                });   
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                   $('#tbl_of_reschedule_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_extended_tickets.row($row).data();
                       
                         if($(this).attr("name")=='view_ticket')
                         {
                            $('#txt_hidden_cust_id_view_ticket').val(ticket_data.customer_id);
                            $('#txt_hidden_cust_code_view_ticket').val(ticket_data.customer_code);
                            $('#txt_hidden_cust_name_view_ticket').val(ticket_data.customer_name);
                            $('#txt_hidden_loc_id_view_ticket').val(ticket_data.location_id);
                            $('#txt_hidden_loc_code_view_ticket').val(ticket_data.location_code);
                            $('#txt_hidden_loc_name_view_ticket').val(ticket_data.location_name);
                            $('#txt_hidden_build_id_view_ticket').val(ticket_data.building_id);
                            $('#txt_hidden_build_code_view_ticket').val(ticket_data.building_code);
                            $('#txt_hidden_build_name_view_ticket').val(ticket_data.building_name);
                            $('#txt_hidden_ref_view_ticket').val(ticket_data.ticket_ref_no);
                            
                             
                            $('#txt_hidden_ticket_ref_code_view_ticket').val(ticket_data.ticket_ref_code);
                             $('#span_ticket_ref_no_view_ticket').html(ticket_data.ticket_ref_code);
                             $('#span_customer_view_ticket').html('  ,Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_customer_view_location').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_customer_view_building').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                              $("#txt_hidden_ticket_image").val('default.jpg');
                              $("#txt_hidden_ticket_image2").val('default.jpg');
                            load_data_to_grid_entries_list(ticket_data.ticket_ref_code);
                             clear_view_controls();
               
            			 }
            			
            			  if($(this).attr("name")=='schedule_ticket_multiple')
                          {
                            $('#txt_hidden_ticket_ref_code_schedule_ticket_multiple').val(ticket_data.ticket_ref_code);
                             $('#span_ticket_ref_no_schedule_ticket_multiple').html(ticket_data.ticket_ref_code);
                             $('#span_customer_schedule_ticket_multiple').html('  ,Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_customer_schedule_location_multiple').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_customer_schedule_building_multiple').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                            
                            load_data_to_grid_ticket_schedules_list_multiple_extended(ticket_data.ticket_ref_code);
            			 }
            			   if($(this).attr("name")=='change_status_ticket')
                         {
                            $('#txt_hidden_ticket_ref_code_change_status').val(ticket_data.ticket_ref_code);
                             $('#span_ticket_ref_no_change_status').html(ticket_data.ticket_ref_code);
                             $('#span_customer_change_status').html('  ,Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_location_change_status').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_building_change_status').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                           
               
            			 }
                        
                  });
       
     $('#btn_change_ticket_status').click(function(){
      
       var ticket_ref_code=$('#txt_hidden_ticket_ref_code_change_status').val();
       var remarks=$('#txt_remarks').val();
       var status = $("input[name='radio_status_change_status']:checked").val();
       if(ticket_ref_code=='')
         {
               swal("Warning", "Ticket Ref No is missing...", "warning");
               return false;
         }
         
         if($.trim(status)=='Closed' || $.trim(status)=='Cancelled')
         {
               if(remarks=='')
               {
                 remarks='NA';  
               }
           $.post("../controller/ticket/ticket_controller.php",{action:'change_status_ticket',ticket_ref_code:ticket_ref_code,remarks:remarks,status:status}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully updated the status of the ticket ...", "success");
                            $('#txt_remarks').val('');
                           load_data_to_grid_extended_ticket_list();
                            
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not change the status...", "error");
                                return false;
                                
                        }
             });
            
         }
          else
           {
              swal("Warning", "Please choose the status...", "warning");
               return false;
             
           }
  });
                   var v_list_ticket_entries = $('#tbl_ticket_entries').DataTable({});
                     
					  
           
                 function load_data_to_grid_entries_list(ticket_ref_code)
                 {
                     var i=1;
                    v_list_ticket_entries.destroy();
                         
                     v_list_ticket_entries = $('#tbl_ticket_entries').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_extended_controller.php',
                                 'data': {
                                    action: 'list_ticket_entries',ticket_ref_code:ticket_ref_code
                                    
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
            				
            			
                            "columns": [
                               
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
								 
                                 { "data": "ticket_status",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                                  {
                                                      case 'Opened':
                                                          str_active_status='<span class="badge bg-pink-400">'+rows['ticket_status']+'</span>'
                                                      break;
                                                     
                                                      case 'Cancelled':
                                                          str_active_status='<span class="badge bg-slate-400">'+rows['ticket_status']+'</span>'
                                                      break;
                                                      case 'Scheduled':
                                                          str_active_status='<span class="badge bg-blue-400">'+rows['ticket_status']+'</span>'
                                                      break;
                                                      case 'Assigned':
                                                          str_active_status='<span class="badge bg-green-400">'+rows['ticket_status']+'</span>'
                                                      break;
                                                      default:
                                                          str_active_status='<span class="badge bg-brown-400">'+rows['ticket_status']+'</span>'
                                                      break;
                                                  }
                                         
                                     	return str_active_status;
            
            							 },
                                 }
                       
                             ],
                             pageLength: 20,
            				 searching: false,
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
                                   
                                }
                            
                     });  
                
                 }
                 
     $('#tbl_ticket_entries tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_list_ticket_entries.row($row).data();
       
        
         if($(this).attr("name")=='cancel_ticket_entries')
         {
              $('#txt_hidden_cancel_ticket_entry_id1').val(data.ticket_id);
              $('#txt_hidden_cancel_ticket_ref_code1').val(data.ticket_ref_code);
          
          
         }
       
       
    });
 
  $('#btn_cancel_ticket_entry1').click(function(){
      
       var ticket_id=$('#txt_hidden_cancel_ticket_entry_id1').val();
       var cancel_reason=$('#txt_ticket_entry_cancel_reason').val();
       var ticket_ref_code=$('#txt_hidden_cancel_ticket_ref_code1').val();
       if(ticket_id=='')
         {
               swal("Warning", "Sorry not able to cancel the entry...", "warning");
         }
           else
           {
               if(cancel_reason=='')
               {
                 cancel_reason='NA';  
               }
           $.post("../controller/ticket/ticket_controller.php",{action:'cancel_ticket_entry',ticket_id:ticket_id,cancel_reason:cancel_reason}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully cancelled the ticket entry...", "success");
                            
                           load_data_to_grid_entries_list(ticket_ref_code)
                            load_data_to_grid_extended_ticket_list();
                            
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not cancel...", "error");
                                return false;
                                
                        }
             });
             
           }
  });
       
    
    $('#tbl_ticket_entries tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
           // clear_view_controls();
        }
        else {
            v_list_ticket_entries.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var data = v_list_ticket_entries.row($row).data();
          
             $('#txt_additional_info1').val(data.additional_info);
             $('#txt_complaints1').val(data.complaints_description);
            $('#txt_hidden_ticket_id_view_ticket').val(data.ticket_id);
            $('#txt_hidden_category_id_view_ticket').val(data.category_id);
             $('#txt_hidden_type_id_view_ticket').val(data.type_id);
           
              $('input[name=radio-styled-color1][value='+data.ticket_priority+']').prop('checked',true);
             $('input[name=radio-quote1][value='+data.quote_required+']').prop('checked',true);
             $('input[name=radio_service_request1][value="'+data.service_request+'"]').prop('checked',true);
             $('input[name=radio_job_category1][value='+data.job_category+']').prop('checked',true);
              $('#txt_quote_date1').val(data.quote_date);
              
               $('#txt_ticket_book_date_needed1').val(data.date_needed);
                $('#txt_hidden_ticket_image').val(data.ticket_image);
                 $('#txt_hidden_ticket_image2').val(data.ticket_image2);
                $('#txt_quote_ref_no1').val(data.quote_ref_no);
           load_data_to_grid_all_services_list(data.category_id,data.type_id,data.ticket_id);
            load_data_to_grid_selected_services_list(data.ticket_id);
        }
    } );
          
   
	
	   
                 
            var v_ticket_all_services_list_table = $('#tbl_ticket_all_services').DataTable({});
            
             function load_data_to_grid_all_services_list(category_id,type_id,ticket_id)
                {
                 
                  v_ticket_all_services_list_table.destroy();
                        
                   v_ticket_all_services_list_table = $('#tbl_ticket_all_services').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_controller.php',
                                'data': {
                                   action: 'list_all_services_except_selected',category_id:category_id,type_id:type_id,ticket_id:ticket_id
                                   
                                }
                            },
                            "language": {
                                "zeroRecords": "No records available",
                                "infoEmpty": "No records available",
                             },
                           //"order": [[ 0, "desc" ]],
                          
                           "bPaginate": false,
                           "bLengthChange": false,
                           "bFilter": false,
                           "bInfo": false,
                           "autoWidth": false,
                          
                       
                           "columns": [
                              
                               
                                { "data": "service_description"}
                               
                                
                      
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [0] }
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                //return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
    $('#tbl_ticket_all_services tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_ticket_all_services_list_table.row($row).data();
           
        }
    } ); 
    
            
             var v_ticket_services_selected_list_table = $('#tbl_selected_ticket_services').DataTable({});
            
             function load_data_to_grid_selected_services_list(ticket_id)
                {
                 
                  v_ticket_services_selected_list_table.destroy();
                        
                   v_ticket_services_selected_list_table = $('#tbl_selected_ticket_services').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_controller.php',
                                'data': {
                                   action: 'list_selected_services',ticket_id:ticket_id
                                   
                                }
                            },
                            "language": {
                                "zeroRecords": "No records available",
                                "infoEmpty": "No records available",
                             },
                           //"order": [[ 0, "desc" ]],
                          
                           "bPaginate": false,
                           "bLengthChange": false,
                           "bFilter": false,
                           "bInfo": false,
                           "autoWidth": false,
                          
                       
                           "columns": [
                              
                               
                                { "data": "service_description"},
                                 { "data": "ticket_service_id",
                                     render: function ( data, type, rows, meta ) {
                                        
                                       str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="cancel_ticket_services" style="color:black" ><i class="icon-cancel-circle2"></i> Delete Service</a></div></div></div>';
                                       return str_active_status_edit;
                                         
                                     }   
                                }
                                
                               
                                
                      
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [0,1] }
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                //return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
                
        $('#tbl_selected_ticket_services tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_services_selected_list_table.row($row).data();
       
		var category_id=$('#txt_hidden_category_id_view_ticket').val();
		var type_id=$('#txt_hidden_type_id_view_ticket').val();
        
         if($(this).attr("name")=='cancel_ticket_services')
         {
               $.post("../controller/ticket/ticket_controller.php",{action:'cancel_ticket_entry_services',ticket_id:data.ticket_id,service_id:data.service_id}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				   load_data_to_grid_all_services_list(category_id,type_id,data.ticket_id);
                                load_data_to_grid_selected_services_list(data.ticket_id);  
            				    
            			}
        				else
        				{
        					
        					swal("Error", result, "error");
        					return false;
        				}
    		
    		    	});
          
         }
       
       
    });   
     var v_session_image1;
     $('#session_image1').change(function (e) {
                         
            v_session_image1 = $("#session_image1").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image1==="")
            {
                v_session_image1=$('#txt_hidden_ticket_image').val();
                // $('#txt_hidden_ticket_image').val(v_session_image1);
            }
            else
            {
                var doc_file_obj = $("#session_image1")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                 doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image1=$.trim(randomNum+'_'+doc_file1);
                 $('#txt_hidden_ticket_image').val(v_session_image1);
                
            }     
      });
     
     $("#btn_remove_ticket_image1").click(function(){
	    $('#session_image1').val('');
        //$("#hidden_image_show1").val('default.jpg');
        v_session_image1="";
	});
		$("#i_image1").click(function(){
	    var img_to_load=$("#txt_hidden_ticket_image").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
      
      
      var v_session_image2;
     $('#session_image2').change(function (e) {
                         
            v_session_image2 = $("#session_image2").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image2==="")
            {
                v_session_image2=$('#txt_hidden_ticket_image2').val();
                // $('#txt_hidden_ticket_image').val(v_session_image1);
            }
            else
            {
                var doc_file_obj = $("#session_image2")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                 doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image2=$.trim(randomNum+'_'+doc_file1);
                 $('#txt_hidden_ticket_image2').val(v_session_image2);
                
            }     
      });
     
     $("#btn_remove_ticket_image2").click(function(){
	    $('#session_image2').val('');
        //$("#hidden_image_show1").val('default.jpg');
        v_session_image2="";
	});
		$("#i_image2").click(function(){
	    var img_to_load=$("#txt_hidden_ticket_image2").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
    var v_btn_update_ticket_entries = $('#btn_update_ticket_entries').ladda();
    $("#btn_update_ticket_entries").click(function(){
        
		v_btn_update_ticket_entries.ladda( 'start' );
		
		
	
		var ticket_ref_code=$('#txt_hidden_ticket_ref_code_view_ticket').val();
		var ticket_id=$('#txt_hidden_ticket_id_view_ticket').val();
		var category_id=$('#txt_hidden_category_id_view_ticket').val();
		var type_id=$('#txt_hidden_type_id_view_ticket').val();
	
		var additional_info=$('#txt_additional_info1').val();
		var priority_val = $("input[name='radio-styled-color1']:checked").val();
		var quote_val = $("input[name='radio-quote1']:checked").val();
        var service_request = $("input[name='radio_service_request1']:checked").val();
		var job_category = $("input[name='radio_job_category1']:checked").val();
		var quote_date = $('#txt_quote_date1').val();
		var date_needed = $('#txt_ticket_book_date_needed1').val();
        var complaint_description=$("#txt_complaints1").val();
        var v_session_image1=$('#txt_hidden_ticket_image').val();
        var v_session_image2=$('#txt_hidden_ticket_image2').val();
        
        var quote_ref_no=$('#txt_quote_ref_no1').val();
		var service_table_selected_count = v_ticket_all_services_list_table.rows('.selected').data().length;
		
		  var ServiceTableSelectedValues = $.map(v_ticket_all_services_list_table.rows('.selected').data(), function (item) {
			return item;
		}); 
		
		var SQLString ="Insert into tbl_ticket_services (ticket_id,ticket_ref_code,service_id,service_description,ticket_service_status) values ";
	        for(counter=0;counter<=service_table_selected_count-1;counter++)
				{
					SQLString = SQLString +'('+ticket_id+',"'+ticket_ref_code+'",'+
					ServiceTableSelectedValues[counter].service_id+',"'+
					ServiceTableSelectedValues[counter].service_description+'","Pending"),'; 
					
				}
            SQLString =  SQLString.replace(/,\s*$/, "");
          
				if($.trim(ticket_ref_code)==""||$.trim(ticket_id)=="")
                                
                                {
                                    swal("Warning","Please select ticket entry...", "warning");
                                    v_btn_update_ticket_entries.ladda( 'stop' );
                                    return false;
                                }
                 else
                    {
                      if(service_table_selected_count==0)
                      {
                       SQLString="";
                      }
    		        $.post("../controller/ticket/ticket_controller.php",{action:'update_ticket_entry',ticket_id:ticket_id,additional_info:additional_info,priority_val:priority_val,quote_val:quote_val,complaint_description:complaint_description,SQLString:SQLString,quote_date:quote_date,date_needed:date_needed,job_category:job_category,service_request:service_request,v_session_image:v_session_image1,v_session_image2:v_session_image2,quote_ref_no:quote_ref_no}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				    
            				    
            					v_btn_update_ticket_entries.ladda( 'stop' );
            					swal("Success", "Ticket entry updated successfully..", "success");
            				    load_data_to_grid_entries_list(ticket_ref_code);
            				   clear_view_controls();
            			}
        				else
        				{
        					v_btn_update_ticket_entries.ladda( 'stop' );
        					swal("Error", result, "error");
        				}
    		
    		    	});
            }
	}); 
    
     function clear_view_controls()
     {
            $('#txt_additional_info1').val('');
             $('#txt_complaints1').val('');
            $('#txt_hidden_ticket_id_view_ticket').val('');
            $('#txt_hidden_category_id_view_ticket').val('');
             $('#txt_hidden_type_id_view_ticket').val('');
             $('#txt_quote_date1').val('');
             $('#txt_ticket_book_date_needed1').val('');
            
              $('input[name=radio-styled-color1][value=Normal]').prop('checked',true);
             $('input[name=radio-quote1][value=No]').prop('checked',true);
              $('input[name=radio_job_category1][value=PPM]').prop('checked',true);
              $('input[name=radio_service_request1][value=Others]').prop('checked',true);
                $('#txt_hidden_ticket_image').val('default.jpg');
                $('#txt_hidden_ticket_image2').val('default.jpg');
                $('#txt_quote_ref_no1').val('');
           
            
           load_data_to_grid_all_services_list(0,0,0);
            load_data_to_grid_selected_services_list(0);
     }
    
	 
	 //Schedule multiple
	 
	      
            
            var v_ticket_schedule_category_list_multiple_extended = $('#tbl_ticket_schedule_category_list_multiple_extended').DataTable({});
                 
            function load_data_to_grid_ticket_schedules_list_multiple_extended(ticket_ref_code)
                {
                 
                 v_ticket_schedule_category_list_multiple_extended.destroy();
                        
                   v_ticket_schedule_category_list_multiple_extended = $('#tbl_ticket_schedule_category_list_multiple_extended').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_extended_controller.php',
                                'data': {
                                   action: 'schedule_ticket_category_list',ticket_ref_code:ticket_ref_code
                                   
                                }
                            },
                            "language": {
                                "zeroRecords": "No records available",
                                "infoEmpty": "No records available",
                             },
                           //"order": [[ 0, "desc" ]],
                          
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
                                    
                                 },
                               { "data": "ticket_id",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status='WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"];
                                         
                                     	return str_active_status;
            
            							 },
                                 },
                                { "data": "category_name"},
                                { "data": "type_name"},
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
								  { "data": "asset_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data;
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                               
                                { "data": "ticket_id",
                                     render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services_schedule_extended" name="view_services_schedule_extended" ><i class="icon-eye"></i> View Services</a><a href="#" class="dropdown-item" name="view_requisition_extended" data-toggle="modal" data-target="#modal_view_requisition_extended" style="color:black"><i class="icon-circle-right2"></i> View Requisitions</a></div></div></div>';
                                         
                                     }   
                                }
                                
                                
                                
                                
                      
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                              // { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                               { "width": "5%", "targets": 0 } 
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                //return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
                
    $('#tbl_ticket_schedule_category_list_multiple_extended tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_ticket_schedule_category_list_multiple_extended.row($row).data();
           
        }
    } ); 
                
	              $('#tbl_ticket_schedule_category_list_multiple_extended tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_ticket_schedule_category_list_multiple_extended.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_schedule_category_multiple(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_schedule_category_multiple(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Complaint </div></td>'+
            				'<td ><div align="center">Asset Code </div></td>'+
            				'<td ><div align="center">Additional Info </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.complaints_description+'</div></td>'+
            				'<td><div align="center">'+d.asset_code+'</div></td>'+
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
            				'<td><div align="center">'+d.quote_date+' - '+d.quote_required+'</div></td>'+
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	            
	            
	            
    $('#select_slots_multiple_extended').on('change', function(){
         var visit_date=$("#txt_date_multiple").val();
         var visit_slot=$("#select_slots_multiple_extended option:selected").val();
         var visit_duration=$("#duration_multiple option:selected").val();
         var i=visit_slot;
         var slot_sql_string="";
         var sch_slot_sql_string="";
         var t=parseInt(visit_slot)+parseInt(visit_duration);
        
          if(t>24)
          {
               swal("Warning", "Sorry! the slots schedule exceeds the slots available for the day...", "warning");
              return false;
          }
          else
          {
                  for(i=visit_slot;i<=t;i++)
             {
                  slot_sql_string=slot_sql_string+' slot_'+i+' ="0" and';
                  sch_slot_sql_string=sch_slot_sql_string+' slot_'+i+' ="1" ,';
             }
              var new_slot_sql_string = slot_sql_string.split(" ").slice(0, -1).join(" ");
               var new_sch_slot_sql_string = sch_slot_sql_string.replace(/,\s*$/, "");
             load_data_to_grid_available_technicians_multiple(visit_date,new_slot_sql_string);
         
             $("#txt_visit_date_assign_hidden_multiple").val(visit_date);
             $("#txt_visit_slot_assign_hidden_multiple").val(visit_slot);
             $("#txt_visit_slot_assign_hidden_for_sch_multiple").val(new_sch_slot_sql_string);
             $("#txt_visit_added_slot_multiple").val(visit_duration);
             $("#txt_vist_start_time_hidden_multiple").val(visit_slot+':00');
          }
    });
	         
    $('#duration_multiple').on('change', function(){
         var visit_date=$("#txt_date_multiple").val();
         var visit_slot=$("#select_slots_multiple_extended option:selected").val();
         var visit_duration=$("#duration_multiple option:selected").val();
         var i=visit_slot;
         var slot_sql_string="";
         var sch_slot_sql_string="";
         var t=parseInt(visit_slot)+parseInt(visit_duration);
        
          if(t>24)
          {
              swal("Warning", "Sorry! the slots schedule exceeds the slots available for the day...", "warning");
              return false;
          }
          else
          {
                  for(i=visit_slot;i<=t;i++)
             {
                  slot_sql_string=slot_sql_string+' slot_'+i+' ="0" and';
                  sch_slot_sql_string=sch_slot_sql_string+' slot_'+i+' ="1" ,';
             }
              var new_slot_sql_string = slot_sql_string.split(" ").slice(0, -1).join(" ");
              var new_sch_slot_sql_string = sch_slot_sql_string.replace(/,\s*$/, "");
             load_data_to_grid_available_technicians_multiple(visit_date,new_slot_sql_string);
         
             $("#txt_visit_date_assign_hidden_multiple").val(visit_date);
             $("#txt_visit_slot_assign_hidden_multiple").val(visit_slot);
             $("#txt_visit_slot_assign_hidden_for_sch_multiple").val(new_sch_slot_sql_string);
             $("#txt_visit_added_slot_multiple").val(visit_duration);
             $("#txt_vist_start_time_hidden_multiple").val(visit_slot+':00');
          }
    });   
    
    $('#txt_date_multiple').on('change', function(){
         var visit_date=$("#txt_date_multiple").val();
         var visit_slot=$("#select_slots_multiple_extended option:selected").val();
         var visit_duration=$("#duration_multiple option:selected").val();
         var i=visit_slot;
         var slot_sql_string="";
         var sch_slot_sql_string="";
         var t=parseInt(visit_slot)+parseInt(visit_duration);
        
          if(t>24)
          {
               swal("Warning", "Sorry! the slots schedule exceeds the slots available for the day...", "warning");
              return false;
          }
          else
          {
                  for(i=visit_slot;i<=t;i++)
             {
                  slot_sql_string=slot_sql_string+' slot_'+i+' ="0" and';
                  sch_slot_sql_string=sch_slot_sql_string+' slot_'+i+' ="1" ,';
             }
              var new_slot_sql_string = slot_sql_string.split(" ").slice(0, -1).join(" ");
               var new_sch_slot_sql_string = sch_slot_sql_string.replace(/,\s*$/, "");
             load_data_to_grid_available_technicians_multiple(visit_date,new_slot_sql_string);
         
             $("#txt_visit_date_assign_hidden_multiple").val(visit_date);
             $("#txt_visit_slot_assign_hidden_multiple").val(visit_slot);
             $("#txt_visit_slot_assign_hidden_for_sch_multiple").val(new_sch_slot_sql_string);
             $("#txt_visit_added_slot_multiple").val(visit_duration);
             $("#txt_vist_start_time_hidden_multiple").val(visit_slot+':00');
          }
    });   

$('#txt_date_multiple').on('change', function(){
    var visit_date=$("#txt_date_multiple").val();
        $("#txt_vist_start_time_hidden_multiple").val($("#txt_date_multiple").val());
});
	 
	
	
	 
	   var v_list_of_techsavail_multiple = $('#tbl_techs_schedule_ticket_multiple').DataTable({});
                     // load_data_to_grid_open_ticket_list();
					  
           
        function load_data_to_grid_available_technicians_multiple(visit_date,visit_slot)
                 {
                     
                    v_list_of_techsavail_multiple.destroy();
                         
                     v_list_of_techsavail_multiple = $('#tbl_techs_schedule_ticket_multiple').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_avail_tech_in_schedule_ticket',visit_date:visit_date,visit_slot:visit_slot
                                    
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
                               
                                //  { "data": null,"width": "5%"},
                                
								 { "data": "employee_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['employee_name']+' - '+rows['employee_contact_no'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "employee_id","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=' <div style="padding-bottom:30px;padding-left:30px;padding-right:60px;width:200px;"><td ><input type="checkbox"  class="form-check-input selected" id="'+rows["employee_id"]+'"></td></div>';
                                        
                                    }   
                                },
                                
                                 
                                 { "data": "employee_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_tech_expertise_multiple" data-toggle="modal" data-target="#modal_view_expertise_multiple" style="color:black"><i class="icon-eye"></i> View Expertise</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="view_schs_multiple" style="color:black" data-toggle="modal" data-target="#modal_view_tech_schedules_multiple"><i class="icon-calendar"></i> View Schedules</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
            				],
                            
            				
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
                 
    $('#tbl_techs_schedule_ticket_multiple tbody').on( 'click', 'tr', function () {
	        var $row = $(this).closest('tr');
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
         
             if ($row.find($("input[type=checkbox]"))==true){ 
               
        
                 $row.find($("input[type=checkbox]")).prop("checked", false);
                }
                else
                {
                   
                   // $row.find($("input[type=checkbox]")).prop("checked", true);
                     $row.find($("input[type=checkbox]")).prop("checked", false);
                    
                }
         
           
        }
        else {
            
            $(this).addClass('selected');
            
           
            var ids = v_list_of_techsavail_multiple.row($row).data();
           
        }
    } );
	 
    $("#tbl_techs_schedule_ticket_multiple tbody").on('change',"input[type='checkbox']",function(e){
       
         var table = $('#tbl_techs_schedule_ticket_multiple').DataTable();
          var $row = $(this).closest('tr');
         if ($row.find($("input[type=checkbox]"))==true){ 
        
         table.$("input[type=checkbox]").prop("checked", false);
            $(this).prop('checked', true);
            $row.addClass('selected');
        }
        else
        {
             
               table.$("input[type=checkbox]").prop("checked", false);
             $(this).prop("checked", true);
             $row.addClass('selected');
             
        }
       
        
        
    });
	 
	
    
	 
    $('#tbl_ticket_schedule_category_list_multiple_extended tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_schedule_category_list_multiple_extended.row($row).data();
       
       
       if($(this).attr("name")=='view_services_schedule_extended')
         {
             $("#span_ticket_ref_no_view_services_multiple").html(data.ticket_ref_code);
             
             
           load_data_to_grid_assigned_services_list_multiple(data.ticket_id);
         }
        
        if($(this).attr("name")=='view_requisition_extended')
         {
             $("#span_ticket_ref_no_view_requisitions_extended").html(data.ticket_ref_code);
             
             
           load_data_to_grid_requistion_list_extended(data.ticket_id);
         } 
         
         
    });
 
 
       var v_btn_ticket_entries_schedule_all_multiple = $('#btn_schudle_all_multiple').ladda();
    $("#btn_schudle_all_multiple").click(function(){
        
		v_btn_ticket_entries_schedule_all_multiple.ladda( 'start' );
		
	       var leadr_emp_id;
	       var ticket_count = v_ticket_schedule_category_list_multiple_extended.rows('.selected').data().length;
		
        		  var ticketTableSelectedValues = $.map(v_ticket_schedule_category_list_multiple_extended.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var ticketidarray = [];
               
                for(t=0;t<=ticket_count-1;t++)
        				{
        				    
        				     ticketidarray.push(ticketTableSelectedValues[t].ticket_id);
        				
        				}
		
           var visit_date=$("#txt_visit_date_assign_hidden_multiple").val();
           
           var visit_slot=$("#txt_visit_slot_assign_hidden_multiple").val();
           var visit_duration=$("#txt_visit_added_slot_multiple").val();
           var ticket_ref_code=$("#txt_hidden_ticket_ref_code_schedule_ticket_multiple").val();
           
           var customer_id=$("#txt_customer_id_assign_hidden_multiple").val();
           var customer_code=$("#txt_customer_code_assign_hidden_multiple").val();
           var customer_name=$("#txt_customer_name_assign_hidden_multiple").val();
           var visit_start_time=$("#txt_vist_start_time_hidden_multiple").val();
         
           
           function pad2(n) {
              return (n < 10 ? '0' : '') + n;
            }
            
            var date = new Date();
            var month = pad2(date.getMonth()+1);//months (0-11)
            var day = pad2(date.getDate());//day (1-31)
            var year= date.getFullYear();
            
            var formattedDate =  year+"-"+month+"-"+day;
           if(ticket_count==0)
            {
                swal("Warning", "Please select the entry before scheduling...", "warning");
                 v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
               return false; 
            }
            if(visit_date=='')
            {
                swal("Warning", "Please specify the date of schedule", "warning");
                 v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
               return false; 
            }
             if(visit_slot=='')
            {
                swal("Warning", "Please specify the slot of schedule", "warning");
                 v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
               return false; 
            }
           if(visit_date<formattedDate)
           {
               swal("Warning", "Sorry! Not able to schedule to past dates...", "warning");
                v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
               return false;
               
           }
            var i=visit_slot;
             var sch_slot_sql_string="";
             var t=parseInt(visit_slot)+parseInt(visit_duration);
    
              if(t>24)
              {
                   swal("Warning", "Sorry! the slots schedule exceeds the slots available for the day...", "warning");
                  return false;
              }
           else
           {
         
               
               
               	var tech_table_selected_count = v_list_of_techsavail_multiple.rows('.selected').data().length;
		
        		  var techTableSelectedValues = $.map(v_list_of_techsavail_multiple.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var empidarray = [];
                var empcodearray = [];
                var empnamearray = [];
                var empcontactnoarray = [];
                for(x=0;x<=tech_table_selected_count-1;x++)
        				{
        				    
        				     empidarray.push(techTableSelectedValues[x].employee_id);
        				     empcodearray.push(techTableSelectedValues[x].employee_code);
        				     empnamearray.push(techTableSelectedValues[x].employee_name);
        				     empcontactnoarray.push(techTableSelectedValues[x].employee_contact_no);
        				
        				}
        			 var table = $('#tbl_techs_schedule_ticket_multiple').DataTable();

                      var checkedvalues = table.$('input:checked').map(function () {
                          leadr_emp_id=this.id;
                        }).get().join(',');

                if(tech_table_selected_count==0)
                {
                           $.post("../controller/ticket/ticket_controller.php",{action:'schedule_ticket_visit_entries_multiple',ticket_id:ticketidarray,visit_date:visit_date,visit_slot:visit_slot,ticket_ref_code:ticket_ref_code,customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,visit_duration:visit_duration,total_slots:t,visit_start_time:visit_start_time,ticket_count:ticket_count}
                           , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                            
                                            swal("Success", "Successfully scheduled the ticket entry...", "success");
                                            v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
                                           
                                            
                                            load_data_to_grid_extended_ticket_list();
                                              load_data_to_grid_ticket_schedules_list_multiple_extended(ticket_ref_code);
                          
                          
                                       var var_date=$("#txt_date_multiple").val();
                                       var var_slots=$("#txt_visit_slot_assign_hidden_for_sch_multiple").val(); load_data_to_grid_available_technicians_multiple(var_date,var_slots);
                                            
                                        }
                                    else 
                                        {
                                            
                                                swal("Error", "Sorry! Could not schedule...", "error");
                                                 v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
                                                return false;
                                                
                                        }
                             });
                }
                else
                {
                 $.post("../controller/ticket/ticket_controller.php",{action:'schedule_assign_ticket_visit_multiple',ticket_id:ticketidarray,visit_date:visit_date,visit_slot:visit_slot,ticket_ref_code:ticket_ref_code,customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,tech_table_selected_count:tech_table_selected_count,empidarray:empidarray,empcodearray:empcodearray,empnamearray:empnamearray,leadr_emp_id:leadr_emp_id,visit_duration:visit_duration,total_slots:t,visit_start_time:visit_start_time,ticket_count:ticket_count,empcontactnoarray:empcontactnoarray}
                          , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                            v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
                                            swal("Success", "Successfully scheduled and assigned ticket entry...", "success");
                                             v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
                                           // $("#modal_schedule_ticket").modal('hide');
                                            load_data_to_grid_extended_ticket_list();
                                            load_data_to_grid_ticket_schedules_list_multiple_extended(ticket_ref_code);
                          
                                        var var_date=$("#txt_date_multiple").val();
                                       var var_slots=$("#txt_visit_slot_assign_hidden_for_sch_multiple").val(); load_data_to_grid_available_technicians_multiple(var_date,var_slots);
                                        
                                            
                                        }
                                    else 
                                        {
                                             v_btn_ticket_entries_schedule_all_multiple.ladda( 'stop' );
                                                swal("Error", "Sorry! Could not schedule...", "error");
                                                return false;
                                                
                                        }
                             });
                }
               
             
           }
    }); 
    
   
          
          
            var list_of_assigned_services_extended = $('#tbl_assigned_services_list_extended').DataTable();
    
     function load_data_to_grid_assigned_services_list_multiple(ticket_id)
                 {
                    
                    list_of_assigned_services_extended.destroy();
                         
                     list_of_assigned_services_extended = $('#tbl_assigned_services_list_extended').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_extended_controller.php',
                                 'data': {
                                         action: 'list_assigned_services',ticket_id:ticket_id
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 { "data": null,"width": "5%"},
                                 { "data": "service_description" },
                                  { "data": "tech_remarks" },
                                   { "data": "ticket_service_status",
                                  render: function ( data, type, rows, meta ) {
                                      switch(data)
                                              {
                                                  case 'Pending':
                                                      str_active_status='<span class="badge badge-warning">'+rows['ticket_service_status']+'</span>'
                                                  break;
                                                 
                                                  case 'Start':
                                                      str_active_status='<span class="badge badge-info">'+rows['ticket_service_status']+'</span>'
                                                  break;
                                                  case 'Completed':
                                                      str_active_status='<span class="badge badge-success">'+rows['ticket_service_status']+'</span>'
                                                  break;
                                                  case 'Cancelled':
                                                      str_active_status='<span class="badge badge-danger">'+rows['ticket_service_status']+'</span>'
                                                  break;
                                                  default:
                                                      str_active_status='<span class="badge badge-secondary">'+rows['ticket_service_status']+'</span>'
                                                  break;
                                              }
                                     
                                 	return str_active_status;
        
        							 }
                                   }
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 0,1,2,3] }, 
            					 { "width": "5%", "targets": 0 } 
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
                 
                 
                 
                 
      var list_of_requistion_extended = $('#tbl_requisitions_list_extended').DataTable();
    
     function load_data_to_grid_requistion_list_extended(ticket_id)
                 {
                    
                    list_of_requistion_extended.destroy();
                         
                     list_of_requistion_extended = $('#tbl_requisitions_list_extended').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_extended_controller.php',
                                 'data': {
                                         action: 'list_of_requisitions',ticket_id:ticket_id
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            					columnDefs: [
                                    { type: 'date-eu', targets: 2 }
                             ],
            			
            			
                            "columns": [
                                 { "data": null,"width": "5%"},
                                 { "data": "requisition_serial_no" },
                                  { "data": "req_date" },
                                   { "data": "status",
                                  render: function ( data, type, rows, meta ) {
                                     str_active_status='<span class="badge badge-info">'+data+'</span>'
                                     
                                 	return str_active_status;
        
        							 }
                                   }
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 0,1,2,3] }, 
            					 { "width": "5%", "targets": 0 } 
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
                 
                 
                 
                 
                 
    $('#tbl_techs_schedule_ticket_multiple tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_list_of_techsavail_multiple.row($row).data();
       
       if($(this).attr("name")=='view_tech_expertise_multiple')
         {
             
            load_data_to_grid_tech_expertise_multiple(data.employee_code);
             $('#span_tech_name_code_view_expertises').html(data.employee_name);
         }
         if($(this).attr("name")=='view_schs_multiple')
         {
             
             $('#span_tech_name_code_view_schedules').html(data.employee_name);
            load_data_to_grid_tech_schedules_multiple(data.employee_code);
         }
    });
 
                 
                 
    var list_of_tech_expertise_multiple = $('#tbl_tech_expertise_multiple').DataTable();
    
     function load_data_to_grid_tech_expertise_multiple(tech_code)
                 {
                    
                    list_of_tech_expertise_multiple.destroy();
                         
                     list_of_tech_expertise_multiple = $('#tbl_tech_expertise_multiple').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                         action: 'list_tech_expertises',tech_code:tech_code
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"bSearch": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                 { "data": "expertise_name" }
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0] }
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });   
                 }
                      
    var list_of_tech_schedules_multiple = $('#tbl_tech_schedules_multiple').DataTable();
    
     function load_data_to_grid_tech_schedules_multiple(tech_code)
                 {
                    var visit_date=$('#txt_date_multiple').val();
                    
                    list_of_tech_schedules_multiple.destroy();
                         
                     list_of_tech_schedules_multiple = $('#tbl_tech_schedules_multiple').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                         action: 'list_tech_schedules',tech_code:tech_code,visit_date:visit_date
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"bSearch": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                
                                  { "data": "slot_date","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                       str_actions='<span class="badge badge-info">'+data+'</span>';
                                        return str_actions;
                                        
                                    }   
                                },
                                  { "data": "slot_1","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_2","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_3","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_4","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_5","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_6","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },{ "data": "slot_7","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_8","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_9","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_10","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_11","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },{ "data": "slot_12","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_13","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_14","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_15","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_16","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_17","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_18","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                
                                { "data": "slot_19","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_20","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_21","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_22","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_23","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                },
                                { "data": "slot_24","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        if(data==0)
                                        {
                                            str_actions='<span class="badge badge-success">Available</span>';
                                        }
                                        else
                                        {
                                            str_actions='<span class="badge badge-danger">'+data+'</span>';
                                        }
                                        return str_actions;
                                        
                                    }   
                                }
                       
                             ],
                             pageLength: 10,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0] },
            					{ "bSortable": false, "aTargets": [1] },
            					{ "bSortable": false, "aTargets": [2] },
            					{ "bSortable": false, "aTargets": [3] },
            					{ "bSortable": false, "aTargets": [4] },
            					{ "bSortable": false, "aTargets": [5] },
            					{ "bSortable": false, "aTargets": [6] },
            					{ "bSortable": false, "aTargets": [7] },
            					{ "bSortable": false, "aTargets": [8] },
            					{ "bSortable": false, "aTargets": [9] },
            					{ "bSortable": false, "aTargets": [10] },
            					{ "bSortable": false, "aTargets": [11] },
            					{ "bSortable": false, "aTargets": [12] },
            					{ "bSortable": false, "aTargets": [13] },
            					{ "bSortable": false, "aTargets": [14] },
            					{ "bSortable": false, "aTargets": [15] },
            					{ "bSortable": false, "aTargets": [16] },
            					{ "bSortable": false, "aTargets": [17] },
            					{ "bSortable": false, "aTargets": [18] },
            					{ "bSortable": false, "aTargets": [19] },
            					{ "bSortable": false, "aTargets": [20] },
            					{ "bSortable": false, "aTargets": [21] },
            					{ "bSortable": false, "aTargets": [22] },
            					{ "bSortable": false, "aTargets": [23] },
            					{ "bSortable": false, "aTargets": [24] },
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });   
                 }

});