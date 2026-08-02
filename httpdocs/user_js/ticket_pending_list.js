$(document).ready(function(){
                 
       $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });          
                    var v_list_of_open_tickets = $('#tbl_of_open_tickets').DataTable({});
                      load_data_to_grid_open_ticket_list();
					  
           
                 function load_data_to_grid_open_ticket_list()
                 {
                     var i=1;
                    v_list_of_open_tickets.destroy();
                         
                     v_list_of_open_tickets = $('#tbl_of_open_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_open_ticket'
                                    
                                 },
								  beforeSend: function () {
									$("#tbl_of_open_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_open_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_open_tickets").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                  { "data": null,"width": "5%",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "created_date_time" ,"type": "dom-date"},
								 { "data": "ticket_ref_code"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "location_name"},
                    //              { "data": "location_name",
                    //                   render: function ( data, type, rows, meta ) {
                                          
                    //                       str_active_status=data+' - '+rows['location_name'];
                                         
                    //                  	return str_active_status;
            
            							 //},
                    //              },
                                 { "data": "building_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                         // str_active_status=data+' - '+rows['building_name'];
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
                                            "WoOpenedModify": "View / Edit",
                                            "WoOpenedModify": "Schedule & Assign",
                                            "WoOpenedModify": "Change Status"
                                        };
                                        
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });  
                                        console.log("filtered options "+filteredOptions);
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: black;"> <i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                          if(filteredOptions=="WoOpenedModify")
                                          {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_ticket" style="color: black;"><i class="icon-eye"></i> View / Edit</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="schedule_ticket_multiple" style="color: black;" data-toggle="modal" data-target="#modal_schedule_ticket_multiple"><i class="icon-calendar"></i>Schedule & Assign </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="change_status_ticket" style="color: black;" data-toggle="modal" data-target="#modal_change_status_ticket"><i class="icon-pencil5"></i> Change Status</a>'; 
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
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_ticket" data-toggle="modal" data-target="#modal_view_ticket" style="color:black"><i class="icon-eye"></i> View / Edit</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="schedule_ticket_multiple" style="color:black" data-toggle="modal" data-target="#modal_schedule_ticket_multiple"><i class="icon-calendar"></i>Schedule & Assign </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="change_status_ticket" style="color:black" data-toggle="modal" data-target="#modal_change_status_ticket"><i class="icon-pencil5"></i> Change Status</a></div></div></div>';
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
                               //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                               //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                   $('#tbl_of_open_tickets tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var ticket_data = v_list_of_open_tickets.row($row).data();
                       
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
                            load_data_to_grid_entries_list(ticket_data.ticket_ref_code);
                             clear_view_controls();
               
            			 }
            			  if($(this).attr("name")=='schedule_ticket')
                         {
                            $('#txt_hidden_ticket_ref_code_schedule_ticket').val(ticket_data.ticket_ref_code);
                             $('#span_ticket_ref_no_schedule_ticket').html(ticket_data.ticket_ref_code);
                             $('#span_customer_schedule_ticket').html('  ,Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_customer_schedule_location').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_customer_schedule_building').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                            
                            load_data_to_grid_ticket_schedules_list(ticket_data.ticket_ref_code);
                          
                          
                            var d = new Date();
                             month = '' + (d.getMonth() + 1),
                                day = '' + d.getDate(),
                                year = d.getFullYear();
                        
                            if (month.length < 2) 
                                month = '0' + month;
                            if (day.length < 2) 
                                day = '0' + day;
                        
                            var cur_date=[year, month, day].join('-');

                            $("#txt_visit_date_assign_hidden").val(cur_date);
                            $("#txt_visit_slot_assign_hidden").val(1);
                             $("#txt_visit_slot_assign_hidden_for_sch").val('slot_1="1"');
                            $("#txt_visit_added_slot").val(0);
                            $("#txt_ticket_id_assign_hidden").val('0');
                            $("#txt_vist_start_time_hidden").val('00:00');
                            
                             $("#txt_customer_id_assign_hidden").val(ticket_data.customer_id);
                              $("#txt_customer_code_assign_hidden").val(ticket_data.customer_code);
                               $("#txt_customer_name_assign_hidden").val(ticket_data.customer_name);
                            
                            load_data_to_grid_available_technicians(cur_date,'slot_1="0"');
               
            			 }
            			  if($(this).attr("name")=='schedule_ticket_multiple')
                         {
                            $('#txt_hidden_ticket_ref_code_schedule_ticket_multiple').val(ticket_data.ticket_ref_code);
                             $('#span_ticket_ref_no_schedule_ticket_multiple').html(ticket_data.ticket_ref_code);
                             $('#span_customer_schedule_ticket_multiple').html('  ,Customer - '+ticket_data.customer_code+' - '+ticket_data.customer_name);
                              $('#span_customer_schedule_location_multiple').html('  ,Location - '+ticket_data.location_code+' - '+ticket_data.location_name);
                              $('#span_customer_schedule_building_multiple').html('  ,Building - '+ticket_data.building_code+' - '+ticket_data.building_name);
                            
                            load_data_to_grid_ticket_schedules_list_multiple(ticket_data.ticket_ref_code);
                          
                           
                        
                            
                            $("#txt_visit_added_slot_multiple").val($("#duration_multiple option:selected").val());
                           
                            $("#txt_vist_start_time_hidden_multiple").val($("#txt_time_multiple").val());
                             var visit_date=$("#txt_date_multiple").val();
                             var visit_slot=$("#select_slots_multiple option:selected").val();
                             var visit_duration=$("#duration_multiple option:selected").val();
                             var i=visit_slot;
                             var slot_sql_string="";
                             var sch_slot_sql_string="";
                             var t=parseInt(visit_slot)+parseInt(visit_duration);
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
                                                
                            
                            
                            
                             $("#txt_customer_id_assign_hidden_multiple").val(ticket_data.customer_id);
                              $("#txt_customer_code_assign_hidden_multiple").val(ticket_data.customer_code);
                               $("#txt_customer_name_assign_hidden_multiple").val(ticket_data.customer_name);
                           
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
                           load_data_to_grid_open_ticket_list();
                            
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
                                 'url': '../controller/ticket/ticket_controller.php',
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
                                 },
                                 
                                 { "data": "ticket_ref_code",
                                      render: function ( data, type, rows, meta ) {
                                          if(rows['ticket_status']=='Cancelled')
                                          {
                                               str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"></div></div></div>';
                                               
                                          }
                                          else
                                          {
                                              str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="cancel_ticket_entries" style="color:black" data-toggle="modal" data-target="#modal_cancel_ticket_entry"><i class="icon-cancel-circle2"></i> Cancel Ticket Entry</a></div></div></div>';
                                          }
                                         
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                              //   $("td:eq(0)", nRow).html(iDisplayIndex + 1);
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
                            load_data_to_grid_open_ticket_list();
                            
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
              $('#txt_quote_ref_no1').val(data.quote_ref_no);
              
               $('#txt_ticket_book_date_needed1').val(data.date_needed);
                $('#txt_hidden_ticket_image').val(data.ticket_image);
                $('#txt_hidden_ticket_image3').val(data.ticket_image2);

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
	
	
	 var v_session_image3;
     $('#session_image3').change(function (e) {
                         
            v_session_image3 = $("#session_image3").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image3==="")
            {
                v_session_image3=$('#txt_hidden_ticket_image3').val();
                // $('#txt_hidden_ticket_image').val(v_session_image1);
            }
            else
            {
                var doc_file_obj = $("#session_image3")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image3=$.trim(randomNum+'_'+doc_file1);
                 $('#txt_hidden_ticket_image3').val(v_session_image3);
                
            }     
      });
     
     $("#btn_remove_ticket_image3").click(function(){
	    $('#session_image3').val('');
        //$("#hidden_image_show1").val('default.jpg');
        v_session_image3="";
	});
		$("#i_image3").click(function(){
	    var img_to_load=$("#txt_hidden_ticket_image3").val();
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
        var v_session_image3=$('#txt_hidden_ticket_image3').val();
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
    		        $.post("../controller/ticket/ticket_controller.php",{action:'update_ticket_entry',ticket_id:ticket_id,additional_info:additional_info,priority_val:priority_val,quote_val:quote_val,complaint_description:complaint_description,SQLString:SQLString,quote_date:quote_date,date_needed:date_needed,job_category:job_category,service_request:service_request,v_session_image:v_session_image1,v_session_image2:v_session_image3,quote_ref_no:quote_ref_no}
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
              $('#txt_quote_ref_no1').val('');
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
                 $('#txt_hidden_ticket_image3').val('default.jpg');
           
            
           load_data_to_grid_all_services_list(0,0,0);
            load_data_to_grid_selected_services_list(0);
     }
      //Schedule Tickets      
            
            var v_ticket_scchedules_category_list_table = $('#tbl_ticket_schedule_category_list').DataTable({});
                 
            function load_data_to_grid_ticket_schedules_list(ticket_ref_code)
                {
                 
                  v_ticket_scchedules_category_list_table.destroy();
                        
                   v_ticket_scchedules_category_list_table = $('#tbl_ticket_schedule_category_list').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_controller.php',
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
								  { "data": "date_needed",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data;
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                { "data": "cur_date",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:200px;"><input type="date"  class="form-control daterange-single schcalender"  value="'+data+'" id="txt_date_'+rows["ticket_id"]+'"></td>';
                                        
                                    }   
                                },
                                 { "data": "cur_date",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:200px;"> <select  class="form-control select"   name="select_slots'+rows["ticket_id"]+'" id="select_slots'+rows["ticket_id"]+'" ><option value="1">Slot 1</option><option value="2">Slot 2</option><option value="3">Slot 3</option><option value="4">Slot 4</option><option value="5">Slot 5</option><option value="6">Slot 6</option><option value="7">Slot 7</option><option value="8">Slot 8</option><option value="9">Slot 9</option><option value="10">Slot 10</option><option value="11">Slot 11</option><option value="12">Slot 12</option><option value="13">Slot 13</option><option value="14">Slot 14</option><option value="15">Slot 15</option><option value="16">Slot 16</option><option value="17">Slot 17</option><option value="18">Slot 18</option><option value="19">Slot 19</option><option value="20">Slot 20</option><option value="21">Slot 21</option><option value="22">Slot 22</option><option value="23">Slot 23</option><option value="24">Slot 24</option></select></td>';
                                        
                                    }   
                                },
                                  { "data": "cur_date",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:200px;"> <select  class="form-control select"   name="duration_'+rows["ticket_id"]+'" id="duration_'+rows["ticket_id"]+'" ><option value="0" selected>0</option><option value="1" >1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select></td>';
                                        
                                    }   
                                },
                                { "data": "cur_date",
                                render: function ( data, type, rows, meta ) {
                                        
                                    return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:150px;"><input class="form-control starttime"  type="time" name="time" width="50px;" value="00:00" id="txt_time_'+rows["ticket_id"]+'"></td>';
                                     
                                    }   
                                },
                                
                                { "data": "ticket_id",
                                     render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services_schedule" name="view_services_schedule" ><i class="icon-pencil5"></i> View Services</a></div></div></div>';
                                         
                                     }   
                                }
                                
                                
                                
                                
                      
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [1,2,3,4,5,6,7,8,9,10] },
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
                
	              $('#tbl_ticket_schedule_category_list tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_ticket_scchedules_category_list_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_schedule_category(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_schedule_category(d)
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
	            
//  $('#select_slots').on('change', function(){
  
 
//           var visit_date=$("#txt_visit_date_assign_hidden").val();
//             var visit_slot=$("#select_slots").val();
//             var slot_sql_string="";
//             var sch_slot_sql_string="";
//               $('#select_slots option:selected').each(function(){
//                     slot_sql_string=slot_sql_string+' slot_'+this.value+' =0 and';
//                     sch_slot_sql_string=sch_slot_sql_string+' slot_'+this.value+' =1 ,';
                    
//                 });
                
//               var new_slot_sql_string = slot_sql_string.split(" ").slice(0, -1).join(" ");
//               var new_sch_slot_sql_string = sch_slot_sql_string.replace(/,\s*$/, "");
              
//               $("#txt_visit_slot_assign_hidden_for_sch").val(new_sch_slot_sql_string);
//              $("#txt_visit_slot_assign_hidden").val(new_slot_sql_string);
//              load_data_to_grid_available_technicians(visit_date,new_slot_sql_string);
       
//  });
	 $('#tbl_ticket_schedule_category_list tbody').on('change', 'select', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_scchedules_category_list_table.row($row).data();
        var visit_date=$("#txt_date_"+data.ticket_id).val();
         var visit_slot=$("#select_slots"+data.ticket_id).val();
         var visit_duration=$("#duration_"+data.ticket_id).val();
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
             load_data_to_grid_available_technicians(visit_date,new_slot_sql_string);
         
             $("#txt_visit_date_assign_hidden").val(visit_date);
             $("#txt_visit_slot_assign_hidden").val(visit_slot);
             $("#txt_visit_slot_assign_hidden_for_sch").val(new_sch_slot_sql_string);
             $("#txt_visit_added_slot").val(visit_duration);
             $("#txt_vist_start_time_hidden").val(visit_slot+':00');
             
          }
         
	 });
	  $('#tbl_ticket_schedule_category_list tbody').on('change', '.starttime', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_scchedules_category_list_table.row($row).data();
        var visit_date=$("#txt_date_"+data.ticket_id).val();
        $("#txt_vist_start_time_hidden").val($("#txt_time_"+data.ticket_id).val());
	  });
	  $('#tbl_ticket_schedule_category_list tbody').on('change', '.schcalender', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_scchedules_category_list_table.row($row).data();
        var visit_date=$("#txt_date_"+data.ticket_id).val();
         var visit_slot=$("#select_slots"+data.ticket_id).val();
         var visit_duration=$("#duration_"+data.ticket_id).val();
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
         load_data_to_grid_available_technicians(visit_date,new_slot_sql_string);
       
         $("#txt_visit_date_assign_hidden").val(visit_date);
         $("#txt_visit_slot_assign_hidden").val(visit_slot);
         $("#txt_visit_slot_assign_hidden_for_sch").val(new_sch_slot_sql_string);
         $("#txt_visit_added_slot").val(visit_duration);
         
          }
        
         
	 });   
	 
	   var v_list_of_techsavail = $('#tbl_techs_schedule_ticket').DataTable({});
                      //load_data_to_grid_open_ticket_list();
					  
           
        function load_data_to_grid_available_technicians(visit_date,visit_slot)
                 {
                     
                    v_list_of_techsavail.destroy();
                         
                     v_list_of_techsavail = $('#tbl_techs_schedule_ticket').DataTable( {
                           
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
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                //  { "data": null,"width": "5%"},
                                
								 { "data": "employee_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['employee_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "employee_id","width": "100px",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=' <div style="padding-bottom:30px;padding-left:30px;padding-right:60px;width:200px;"><td ><input type="checkbox"  class="form-check-input chk selected" id="'+rows["employee_id"]+'"></td></div>';
                                        
                                    }   
                                },
                                
                                 
                                 { "data": "employee_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_tech_expertise" data-toggle="modal" data-target="#modal_view_expertise" style="color:black"><i class="icon-eye"></i> View Expertise</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="view_schs" style="color:black" data-toggle="modal" data-target="#modal_view_schs"><i class="icon-calendar"></i> View Schedules</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2] }, 
            					
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
	
	   $('#tbl_techs_schedule_ticket tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            
             var $checkbox = $(this).find('td:first-child input[type="checkbox"]')
                    if($checkbox.is(':checked')){
                        $checkbox.prop('checked', false);
                    }
       
        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_list_of_techsavail.row($row).data();
           
        }
    } ); 
  
    $("#tbl_techs_schedule_ticket tbody").on('change',"input[type='checkbox']",function(e){
       
         var table = $('#tbl_techs_schedule_ticket').DataTable();
        table.$("input[type=checkbox]").prop("checked", false);
        $(this).prop("checked", true);
        alert($(this).attr('id'));
    });
     
    
	 
    $('#tbl_ticket_schedule_category_list tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_scchedules_category_list_table.row($row).data();
       
        
        //  if($(this).attr("name")=='confirm_ticket_schedule')
        //  {
        //   var visit_date=$("#txt_date_"+data.ticket_id).val();
        //   var visit_time=$("#txt_time_"+data.ticket_id).val();
         
        //   function pad2(n) {
        //       return (n < 10 ? '0' : '') + n;
        //     }
            
        //     var date = new Date();
        //     var month = pad2(date.getMonth()+1);//months (0-11)
        //     var day = pad2(date.getDate());//day (1-31)
        //     var year= date.getFullYear();
            
        //     var formattedDate =  year+"-"+month+"-"+day;
        //   if(visit_date<formattedDate)
        //   {
        //       swal("Warning", "Sorry! Not able to schedule to past dates...", "warning");
        //       return false;
               
        //   }
        //   else
        //   {
        //   $.post("../controller/ticket/ticket_controller.php",{action:'schedule_ticket_visit_entries',ticket_id:data.ticket_id,visit_date:visit_date,visit_time:visit_time,ticket_ref_code:data.ticket_ref_code,customer_id:data.customer_id,customer_code:data.customer_code,customer_name:data.customer_name}
        //   , function(result,status)
        //      {
              
        //             result = $.trim(result);
                    
        //             if(status=='success')
        //                 {
                            
        //                     swal("Success", "Successfully scheduled the ticket entry...", "success");
        //                     load_data_to_grid_ticket_schedules_list(data.ticket_ref_code);
        //                     load_data_to_grid_assigned_services_list(0);
        //                     load_data_to_grid_open_ticket_list();
                            
        //                 }
        //             else 
        //                 {
                            
        //                         swal("Error", "Sorry! Could not schedule...", "error");
        //                         return false;
                                
        //                 }
        //      });
             
        //   }
        // }
       
       if($(this).attr("name")=='view_services_schedule')
         {
             $("#span_ticket_ref_no_view_services").html(data.ticket_ref_code);
             
             
           load_data_to_grid_assigned_services_list(data.ticket_id);
         }
    });
 
 
       var v_btn_ticket_entries_schedule_all = $('#btn_schudle_all').ladda();
    $("#btn_schudle_all").click(function(){
        
		v_btn_ticket_entries_schedule_all.ladda( 'start' );
		
	       var leadr_emp_id;
		   var ticket_id=$("#txt_ticket_id_assign_hidden").val();
           var visit_date=$("#txt_visit_date_assign_hidden").val();
           //var visit_slot_update=$("#txt_visit_slot_assign_hidden_for_sch").val();
           var visit_slot=$("#txt_visit_slot_assign_hidden").val();
           var visit_duration=$("#txt_visit_added_slot").val();
           var ticket_ref_code=$("#txt_hidden_ticket_ref_code_schedule_ticket").val();
           
           var customer_id=$("#txt_customer_id_assign_hidden").val();
           var customer_code=$("#txt_customer_code_assign_hidden").val();
           var customer_name=$("#txt_customer_name_assign_hidden").val();
           var visit_start_time=$("#txt_vist_start_time_hidden").val();
         
           
           function pad2(n) {
              return (n < 10 ? '0' : '') + n;
            }
            
            var date = new Date();
            var month = pad2(date.getMonth()+1);//months (0-11)
            var day = pad2(date.getDate());//day (1-31)
            var year= date.getFullYear();
            
            var formattedDate =  year+"-"+month+"-"+day;
           if(ticket_id==0)
            {
                swal("Warning", "Please select the entry before scheduling...", "warning");
                 v_btn_ticket_entries_schedule_all.ladda( 'stop' );
               return false; 
            }
            if(visit_date=='')
            {
                swal("Warning", "Please specify the date of schedule", "warning");
                 v_btn_ticket_entries_schedule_all.ladda( 'stop' );
               return false; 
            }
             if(visit_slot=='')
            {
                swal("Warning", "Please specify the slot of schedule", "warning");
                 v_btn_ticket_entries_schedule_all.ladda( 'stop' );
               return false; 
            }
           if(visit_date<formattedDate)
           {
               swal("Warning", "Sorry! Not able to schedule to past dates...", "warning");
                v_btn_ticket_entries_schedule_all.ladda( 'stop' );
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
         
             //  for(i=visit_slot;i<=t;i++)
             //    {
                      
              //        sch_slot_sql_string=sch_slot_sql_string+' slot_'+i+' ='+ticket_id+',';
             //    }
                
             //     var new_sch_slot_sql_string = sch_slot_sql_string.replace(/,\s*$/, "");
                       
               
               
               	var tech_table_selected_count = v_list_of_techsavail.rows('.selected').data().length;
		
        		  var techTableSelectedValues = $.map(v_list_of_techsavail.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var empidarray = [];
                var empcodearray = [];
                var empnamearray = [];
                for(x=0;x<=tech_table_selected_count-1;x++)
        				{
        				    
        				     empidarray.push(techTableSelectedValues[x].employee_id);
        				     empcodearray.push(techTableSelectedValues[x].employee_code);
        				     empnamearray.push(techTableSelectedValues[x].employee_name);
        				
        				}
        			 var table = $('#tbl_techs_schedule_ticket').DataTable();

                      var checkedvalues = table.$('input:checked').map(function () {
                          leadr_emp_id=this.id;
                        }).get().join(',');

                if(tech_table_selected_count==0)
                {
                           $.post("../controller/ticket/ticket_controller.php",{action:'schedule_ticket_visit_entries',ticket_id:ticket_id,visit_date:visit_date,visit_slot:visit_slot,ticket_ref_code:ticket_ref_code,customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,visit_duration:visit_duration,total_slots:t,visit_start_time:visit_start_time}
                           , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                            
                                            swal("Success", "Successfully scheduled the ticket entry...", "success");
                                            v_btn_ticket_entries_schedule_all.ladda( 'stop' );
                                           //  $("#modal_schedule_ticket").modal('hide');
                                            
                                            load_data_to_grid_open_ticket_list();
                                              load_data_to_grid_ticket_schedules_list(ticket_ref_code);
                          
                          
                                        var d = new Date();
                                         month = '' + (d.getMonth() + 1),
                                            day = '' + d.getDate(),
                                            year = d.getFullYear();
                                    
                                        if (month.length < 2) 
                                            month = '0' + month;
                                        if (day.length < 2) 
                                            day = '0' + day;
                                    
                                        var cur_date=[year, month, day].join('-');
            
                                        $("#txt_visit_date_assign_hidden").val(cur_date);
                                        $("#txt_visit_slot_assign_hidden").val(1);
                                         $("#txt_visit_slot_assign_hidden_for_sch").val('slot_1=1');
                                        $("#txt_visit_added_slot").val(0);
                                        $("#txt_ticket_id_assign_hidden").val('0');
                                         $("#txt_customer_id_assign_hidden").val(ticket_data.customer_id);
                                          $("#txt_customer_code_assign_hidden").val(ticket_data.customer_code);
                                           $("#txt_customer_name_assign_hidden").val(ticket_data.customer_name);
                                        
                                        load_data_to_grid_available_technicians(cur_date,'slot_1=0');
                                            
                                        }
                                    else 
                                        {
                                            
                                                swal("Error", "Sorry! Could not schedule...", "error");
                                                 v_btn_ticket_entries_schedule_all.ladda( 'stop' );
                                                return false;
                                                
                                        }
                             });
                }
                else
                {
                   console.log('Leader'+leadr_emp_id);
                 $.post("../controller/ticket/ticket_controller.php",{action:'schedule_assign_ticket_visit',ticket_id:ticket_id,visit_date:visit_date,visit_slot:visit_slot,ticket_ref_code:ticket_ref_code,customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,tech_table_selected_count:tech_table_selected_count,empidarray:empidarray,empcodearray:empcodearray,empnamearray:empnamearray,leadr_emp_id:leadr_emp_id,visit_duration:visit_duration,total_slots:t,visit_start_time:visit_start_time}
                          , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                            v_btn_ticket_entries_schedule_all.ladda( 'stop' );
                                            swal("Success", "Successfully scheduled and assigned ticket entry...", "success");
                                             v_btn_ticket_entries_schedule_all.ladda( 'stop' );
                                           // $("#modal_schedule_ticket").modal('hide');
                                            load_data_to_grid_open_ticket_list();
                                            load_data_to_grid_ticket_schedules_list(ticket_ref_code);
                          
                          
                                        var d = new Date();
                                         month = '' + (d.getMonth() + 1),
                                            day = '' + d.getDate(),
                                            year = d.getFullYear();
                                    
                                        if (month.length < 2) 
                                            month = '0' + month;
                                        if (day.length < 2) 
                                            day = '0' + day;
                                    
                                        var cur_date=[year, month, day].join('-');
            
                                        $("#txt_visit_date_assign_hidden").val(cur_date);
                                        $("#txt_visit_slot_assign_hidden").val(1);
                                         $("#txt_visit_slot_assign_hidden_for_sch").val('slot_1=1');
                                        $("#txt_visit_added_slot").val(0);
                                        $("#txt_ticket_id_assign_hidden").val('0');
                                         $("#txt_customer_id_assign_hidden").val(ticket_data.customer_id);
                                          $("#txt_customer_code_assign_hidden").val(ticket_data.customer_code);
                                           $("#txt_customer_name_assign_hidden").val(ticket_data.customer_name);
                                        
                                        load_data_to_grid_available_technicians(cur_date,'slot_1=0');
                                            
                                        }
                                    else 
                                        {
                                             v_btn_ticket_entries_schedule_all.ladda( 'stop' );
                                                swal("Error", "Sorry! Could not schedule...", "error");
                                                return false;
                                                
                                        }
                             });
                }
               
             
           }
    }); 
    
    $('#tbl_ticket_schedule_category_list tbody').on( 'click', 'tr', function () {
       
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $("#txt_ticket_id_assign_hidden").val(0);
             $('#select_slots').prop('disabled', true);
            
        }
        else {
            v_ticket_scchedules_category_list_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            
        var data = v_ticket_scchedules_category_list_table.row($row).data();
            $("#txt_ticket_id_assign_hidden").val(0);
             $('#select_slots').prop('disabled', false);
          $("#txt_ticket_id_assign_hidden").val(data.ticket_id);
        }
    } );
          
          
            var list_of_assigned_services = $('#tbl_assigned_services_list').DataTable();
    
     function load_data_to_grid_assigned_services_list(ticket_id)
                 {
                    
                    list_of_assigned_services.destroy();
                         
                     list_of_assigned_services = $('#tbl_assigned_services_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
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
                                 { "data": "service_description" }
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//{ "bSortable": false, "aTargets": [ 0,1] }, 
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
                 
    //Tab in complaint Booking
                 
      $("#tab_open_complaints").click(function(){
          load_data_to_grid_open_ticket_list();
      });
      
      //Add New ticket entries
      
      $("#btn_add_new_tkt_entries").click(function(){
           clear_fields_add_entires();
    	   $("#txt_hidden_ticket_ref_code_add_new_entries_ticket").val($("#txt_hidden_ticket_ref_code_view_ticket").val());
    	   $("#txt_hidden_cust_id_add_new_entries_ticket").val($("#txt_hidden_cust_id_view_ticket").val());
    	   $("#txt_hidden_cust_code_add_new_entries_ticket").val($("#txt_hidden_cust_code_view_ticket").val());
    	   $("#txt_hidden_cust_name_add_new_entries_ticket").val($("#txt_hidden_cust_name_view_ticket").val());
    	   $("#txt_hidden_loc_id_add_new_entries_ticket").val($("#txt_hidden_loc_id_view_ticket").val());
    	   $("#txt_hidden_loc_code_add_new_entries_ticket").val($("#txt_hidden_loc_code_view_ticket").val());
    	   $("#txt_hidden_loc_name_add_new_entries_ticket").val($("#txt_hidden_loc_name_view_ticket").val());
    	   $("#txt_hidden_build_id_add_new_entries_ticket").val($("#txt_hidden_build_id_view_ticket").val());
    	   $("#txt_hidden_build_code_add_new_entries_ticket").val($("#txt_hidden_build_code_view_ticket").val());
    	   $("#txt_hidden_build_name_add_new_entries_ticket").val($("#txt_hidden_build_name_view_ticket").val());
    	   $("#txt_hidden_ref_add_entries").val($("#txt_hidden_ref_view_ticket").val());
    	   
      });
      
      
            					
    function load_category_combo_add_entries()
     {
      
         $.ajax({
		type: "POST",
		url: "tickets/asset_category_add_entries.php",
			data: {} 
		 }).done(function(data){
		     
			
			$("#div_category_select_add_entries").html(data);
			$("#select_category_add_entries").select2();
		    
		 });
     }
     $('#div_category_select_add_entries').on('change', '.classcategory_add_entries', function(){
         
         $('#txt_hidden_ticket_customer_asset_category_id_add_entries').val($("#select_category_add_entries option:selected").val());
         $('#txt_hidden_ticket_customer_asset_category_name_add_entries').val($("#select_category_add_entries option:selected").text());
         load_type_combo_add_entries('select');
         load_data_to_grid_services_list_add_entries($("#select_category_add_entries option:selected").val(),0);
    });
 
    function load_type_combo_add_entries()
     {
         
         var category_id=$.trim($("#select_category_add_entries option:selected").val());
       
         $.ajax({
		type: "POST",
		url: "tickets/assets_type_combo_add_entries.php",
		data: { category_id:category_id} 
		 }).done(function(data){
		     
			$("#div_asset_type_combo_add_entries").html(data);
			$("#select_asset_type_add_entries").select2();
		 });
     }


    $('#div_asset_type_combo_add_entries').on('change', '.classtype_add_entries', function(){
        $('#txt_hidden_ticket_customer_asset_type_id_add_entries').val($("#select_asset_type_add_entries option:selected").val());
        $('#txt_hidden_ticket_customer_asset_type_name_add_entries').val($("#select_asset_type_add_entries option:selected").text());
        load_data_to_grid_services_list_add_entries($("#select_category_add_entries option:selected").val(),$("#select_asset_type_add_entries option:selected").val());
        load_asset_combo_add_entries();
    });
    
function load_asset_combo_add_entries()
     {
         
         var category_ids=$.trim($("#select_category_add_entries option:selected").val());
         var type_ids=$.trim($("#select_asset_type_add_entries option:selected").val());
         var customer_id=$.trim($("#txt_hidden_cust_id_add_new_entries_ticket").val());
         var location_id=$.trim($("#txt_hidden_loc_id_add_new_entries_ticket").val());
         var building_id=$.trim($("#txt_hidden_build_id_add_new_entries_ticket").val());
       
         $.ajax({
		type: "POST",
		url: "tickets/assets_combo_add_entries.php",
		data: { category_id:category_ids,type_id:type_ids,customer_id:customer_id,location_id:location_id,building_id:building_id} 
		 }).done(function(data){
		     
			$("#div_assets_combo_add_entries").html(data);
			$("#select_asset_add_entries").select2();
		 });
     }

    var list_of_services_add_entries = $('#tbl_ticket_all_services_add_entries').DataTable();
    
     function load_data_to_grid_services_list_add_entries(cate_ids,type_ids)
                 {
                    
                    list_of_services_add_entries.destroy();
                         
                     list_of_services_add_entries = $('#tbl_ticket_all_services_add_entries').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                         action: 'list_services',category_id:cate_ids,type_id:type_ids
                                    
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
                               
                                 { "data": "service_description" }
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0] }, 
            					
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
    
    
    $('#tbl_ticket_all_services_add_entries tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_services_add_entries.row($row).data();
           
        }
    } ); 
    

	
    
     var v_session_image_add_entries;
     $('#session_image_add_entries').change(function (e) {
                         
            v_session_image_add_entries = $("#session_image_add_entries").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image_add_entries==="")
            {
                v_session_image_add_entries="default.jpg";
                 $('#hidden_image_show_add_entries').val(v_session_image_add_entries);
            }
            else
            {
                var doc_file_obj = $("#session_image_add_entries")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image_add_entries=$.trim(randomNum+'_'+doc_file1);
                 $('#hidden_image_show_add_entries').val(v_session_image_add_entries);
                
            }     
      });
    $("#btn_remove_ticket_image_add_entries").click(function(){
    
    $('#session_image_add_entries').val('');
    $("#hidden_image_show_add_entries").val('default.jpg');
    v_session_image_add_entries="";
	});
	
	$("#i_image_add_entries").click(function(){
	    var img_to_load=$("#hidden_image_show_add_entries").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
	
	    var v_session_image_add_entries2;
     $('#session_image_add_entries2').change(function (e) {
                         
            v_session_image_add_entries2 = $("#session_image_add_entries2").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image_add_entries2==="")
            {
                v_session_image_add_entries2="default.jpg";
                 $('#hidden_image_show_add_entries2').val(v_session_image_add_entries2);
            }
            else
            {
                var doc_file_obj = $("#session_image_add_entries2")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image_add_entries2=$.trim(randomNum+'_'+doc_file1);
                 $('#hidden_image_show_add_entries2').val(v_session_image_add_entries2);
                
            }     
      });
    $("#btn_remove_ticket_image_add_entries2").click(function(){
    
    $('#session_image_add_entries2').val('');
    $("#hidden_image_show_add_entries2").val('default.jpg');
    v_session_image_add_entries2="";
	});
	
	$("#i_image_add_entries2").click(function(){
	    var img_to_load=$("#hidden_image_show_add_entries2").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
    var v_btn_book_ticket_add_entries = $('#btn_submit_new_tkt_entries').ladda(); 
    
    $("#btn_submit_new_tkt_entries").click(function(){
        
		v_btn_book_ticket_add_entries.ladda( 'start' );
		
		
		var ticket_ref_val=$('#txt_hidden_ref_add_entries').val();
		var ticket_ref_code=$('#txt_hidden_ticket_ref_code_add_new_entries_ticket').val();
		var customer_id=$('#txt_hidden_cust_id_add_new_entries_ticket').val();
		var customer_code=$('#txt_hidden_cust_code_add_new_entries_ticket').val();
		var customer_name=$('#txt_hidden_cust_name_add_new_entries_ticket').val();
	    var location_id=$('#txt_hidden_loc_id_add_new_entries_ticket').val();
		var location_code=$('#txt_hidden_loc_code_add_new_entries_ticket').val();
		var location_name=$('#txt_hidden_loc_name_add_new_entries_ticket').val();	
		var building_id=$('#txt_hidden_build_id_add_new_entries_ticket').val();
		var building_code=$('#txt_hidden_build_code_add_new_entries_ticket').val();
		var building_name=$('#txt_hidden_build_name_add_new_entries_ticket').val();
		var asset_id=$("#select_asset_add_entries option:selected").val();
		var asset_code=$("#select_asset_add_entries option:selected").text();
		var category_id=$("#select_category_add_entries option:selected").val();
		var category_name=$("#select_category_add_entries option:selected").text();
		var type_id=$("#select_asset_type_add_entries option:selected").val();
		var type_name=$("#select_asset_type_add_entries option:selected").text();
		var additional_info=$('#txt_additional_info_add_entries').val();
		var priority_val = $("input[name='radio-styled-color_add_entries']:checked").val();
		var quote_val = $("input[name='radio-quote_add_entries']:checked").val();
	    var service_request = $("input[name='radio_service_request_add_entries']:checked").val();
		var job_category = $("input[name='radio_job_category_add_entries']:checked").val();
		var quote_date = $('#txt_quote_date_add_entries').val();
		var quote_ref_no = $('#quote_ref_no_add_entries').val();
		var date_needed = $('#txt_ticket_book_date_needed_add_entries').val();
		//var date_scheduled = $('#txt_ticket_book_visit_date').val();
       // var complaint_description=$(".summernote-height").summernote('code');
        var complaint_description=$("#txt_complaints_add_entries").val();

		var service_table_selected_count = list_of_services_add_entries.rows('.selected').data().length;
		
		  var ServiceTableSelectedValues = $.map(list_of_services_add_entries.rows('.selected').data(), function (item) {
			return item;
		}); 

        var serviceidarray = [];
        var servicedesarray = [];
        for(x=0;x<=service_table_selected_count-1;x++)
				{
				    
				     serviceidarray.push(ServiceTableSelectedValues[x].service_id);
				     servicedesarray.push(ServiceTableSelectedValues[x].service_description);
				
				}
				
				if($.trim(category_id)=="select"||$.trim(type_id)=="select")
                                
                                {
                                    swal("Warning","Please select category and type...", "warning");
                                    v_btn_book_ticket.ladda( 'stop' );
                                    return false;
                                }
                 else
                    {
                       
                       if(quote_date=='')
                       {
                           quote_date='0000-00-00';
                       }
                       if(date_needed=='')
                       {
                           date_needed='0000-00-00';
                       }
                       
                        if(ticket_ref_val==0)
                        {
                            ticket_ref_code=0;
                        }
                        if(asset_id==0)
        				{
        				    
        				    asset_code=0;
        				}
                            
                         var v_session_image_add_entries=$('#hidden_image_show_add_entries').val();
                         var v_session_image_add_entries2=$('#hidden_image_show_add_entries2').val();
    		        $.post("../controller/ticket/ticket_controller.php",{action:'book_complaint',customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,location_id:location_id,location_code:location_code,location_name:location_name,building_id:building_id,building_code:building_code,building_name:building_name,asset_id:asset_id,asset_code:asset_code,category_id:category_id,category_name:category_name,type_id:type_id,type_name:type_name,additional_info:additional_info,priority_val:priority_val,quote_val:quote_val,complaint_description:complaint_description,service_table_selected_count:service_table_selected_count,serviceidarray:serviceidarray,servicedesarray:servicedesarray,ticket_ref_val:ticket_ref_val,ticket_ref_code:ticket_ref_code,service_request:service_request,job_category:job_category,quote_date:quote_date,date_needed:date_needed,v_session_image:v_session_image_add_entries,v_session_image2:v_session_image_add_entries2,quote_ref_no:quote_ref_no}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				    var res = $.trim(result).split("@");
            				   
            					v_btn_book_ticket_add_entries.ladda( 'stop' );
            					swal("Success", "Complaint entry booked successfully..", "success");
            					$("#modal_add_entries").modal('hide');
            					load_data_to_grid_entries_list(ticket_ref_code);
            					clear_fields_add_entires();
            				
            				   
            			}
        				else
        				{
        					v_btn_book_ticket_add_entries.ladda( 'stop' );
        					swal("Error", result, "error");
        				}
    		
    		    	});
            }
	}); 
	 function clear_fields_add_entires()
	 {
	     	load_category_combo_add_entries();
    	    load_type_combo_add_entries();
			load_data_to_grid_services_list_add_entries(0,0);
			load_asset_combo_add_entries();
		    $('#txt_additional_info_add_entries').val('');
		    $('#quote_ref_no_add_entries').val('');
		    $('#txt_complaints_add_entries').val('');
		    $('#txt_quote_date_add_entries').val('0000-00-00');
		    $('#txt_ticket_book_date_needed_add_entries').val('0000-00-00');
		    $('#session_image_add_entries').val('');
            $("#hidden_image_show_add_entries").val('default.jpg');
             $("#hidden_image_show_add_entries2").val('default.jpg');
             $('#quote_ref_no_add_entries').val('');
             
            v_session_image_add_entries="";
            v_session_image_add_entries2="";
	 }
	 
	 
	 
     $('#div_quote_ref_no').hide();
    $('input[type=radio][name=radio-quote_add_entries]').change(function() {
    if (this.value == 'No') {
        $('#div_quote_ref_no').hide();
        $('#quote_ref_no_add_entries').val('');
        
    }
    else
    {
       $('#div_quote_ref_no').show();
        
    }
   
    });
	 
	 //Schedule multiple
	 
	      
            
            var v_ticket_scchedules_category_list_table_multiple = $('#tbl_ticket_schedule_category_list_multiple').DataTable({});
                 
            function load_data_to_grid_ticket_schedules_list_multiple(ticket_ref_code)
                {
                 
                  v_ticket_scchedules_category_list_table_multiple.destroy();
                        
                   v_ticket_scchedules_category_list_table_multiple = $('#tbl_ticket_schedule_category_list_multiple').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_controller.php',
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
								  { "data": "complaints_description",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data;
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                               
                                { "data": "ticket_id",
                                     render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services_schedule_multiple" name="view_services_schedule_multiple" ><i class="icon-pencil5"></i> View Services</a></div></div></div>';
                                         
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
                
    $('#tbl_ticket_schedule_category_list_multiple tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_ticket_scchedules_category_list_table_multiple.row($row).data();
           
        }
    } ); 
                
	              $('#tbl_ticket_schedule_category_list_multiple tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_ticket_scchedules_category_list_table_multiple.row( tr );
                   
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
            				'<td ><div align="center">Quote Required</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.service_request+'</div></td>'+
            				'<td><div align="center">'+d.job_category+'</div></td>'+
            				'<td><div align="center">'+d.quote_required+'</div></td>'+
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	            
    $('#select_slots_multiple').on('change', function(){
         var visit_date=$("#txt_date_multiple").val();
         var visit_slot=$("#select_slots_multiple option:selected").val();
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
         var visit_slot=$("#select_slots_multiple option:selected").val();
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
         var visit_slot=$("#select_slots_multiple option:selected").val();
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
                                        
                                        return str_actions='<div style="padding-bottom:30px;padding-left:30px;padding-right:60px;width:200px;"> <td ><input type="checkbox"  class="form-check-input chk selected" id="'+rows["employee_id"]+'"></td></div>';
                                        
                                    }   
                                },
                                
                                 
                                 { "data": "employee_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="view_tech_expertise_multiple" data-toggle="modal" data-target="#modal_view_expertise_multiple" style="color:black"><i class="icon-eye"></i> View Expertise</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" name="view_schs_multiple" style="color:black" data-toggle="modal" data-target="#modal_view_tech_schedules_multiple"><i class="icon-calendar"></i> View Schedules</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 10,
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
     
    
	 
    $('#tbl_ticket_schedule_category_list_multiple tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_ticket_scchedules_category_list_table_multiple.row($row).data();
       
        
      
       
       if($(this).attr("name")=='view_services_schedule_multiple')
         {
             $("#span_ticket_ref_no_view_services_multiple").html(data.ticket_ref_code);
             
             
           load_data_to_grid_assigned_services_list_multiple(data.ticket_id);
         }
    });
 
 
       var v_btn_ticket_entries_schedule_all_multiple = $('#btn_schudle_all_multiple').ladda();
    $("#btn_schudle_all_multiple").click(function(){
        
		v_btn_ticket_entries_schedule_all_multiple.ladda( 'start' );
		
	       var leadr_emp_id;
	       var ticket_count = v_ticket_scchedules_category_list_table_multiple.rows('.selected').data().length;
		
        		  var ticketTableSelectedValues = $.map(v_ticket_scchedules_category_list_table_multiple.rows('.selected').data(), function (item) {
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
                       // alert(table.find('input.checkbox:checked').length);

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
                                           
                                            
                                            load_data_to_grid_open_ticket_list();
                                              load_data_to_grid_ticket_schedules_list_multiple(ticket_ref_code);
                          
                          
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
                    console.log('Leader '+leadr_emp_id);
                    if(typeof(leadr_emp_id) === "undefined" || leadr_emp_id=='')
                    {
                        swal("Warning", "Please specify a leader...", "warning");
                        le.ladda( 'stop' );
                        return false;
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
                                            load_data_to_grid_open_ticket_list();
                                            load_data_to_grid_ticket_schedules_list_multiple(ticket_ref_code);
                          
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
               
             
           }
    }); 
    
   
          
          
            var list_of_assigned_services_multiple = $('#tbl_assigned_services_list_multiple').DataTable();
    
     function load_data_to_grid_assigned_services_list_multiple(ticket_id)
                 {
                    
                    list_of_assigned_services_multiple.destroy();
                         
                     list_of_assigned_services_multiple = $('#tbl_assigned_services_list_multiple').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
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
                                 { "data": "service_description" }
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1] }, 
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