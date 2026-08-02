$(document).ready(function(){
                 
    display_ticket_details();
    function display_ticket_details()
    {
        var ref_no=$('#txt_ref_code').val();
        $.post('../controller/ticket/ticket_assign_controller.php',{action:'load_ticket_details',ticket_ref_code:ref_no},function(result,status){
            
            if(status=='success')
            {
            
                d = JSON.parse(result);
               
                       
                       
                        $('#span_customer_details').html('Customer Details : '+d.data[0].customer_code+' - '+d.data[0].customer_name);
                        $('#span_location_details').html(' Location : '+d.data[0].location_code+' - '+d.data[0].location_name);
                        $('#span_building_details').html(' Building : '+d.data[0].building_code+' - '+d.data[0].building_name);
                        
                       
            }
          
        });
        
    }  
             var v_list_entries = $('#tbl_entries_ref_no').DataTable({});
                     
					  
           load_data_to_grid_entries_list();
                 function load_data_to_grid_entries_list()
                 {
                     var ref_no=$('#txt_ref_code').val();
                    v_list_entries.destroy();
                        
                     v_list_entries = $('#tbl_entries_ref_no').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_assign_controller.php',
                                 'data': {
                                    action: 'list_ticket_entries',ticket_ref_code:ref_no
                                    
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
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                  { "data": "date_of_visits" },
                                   { "data": "time_of_visit" },
                                 { "data": "category_name" },
								 { "data": "type_name"},
								  { "data": "asset_code"},
								   { "data": "amc_visit_status",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Scheduled':
                                                   str_active_status='<span class="badge badge-primary">'+data+'</span>'
                                              break;
                                              case 'Assigned':
                                                   str_active_status='<span class="badge bg-purple">'+data+'</span>'
                                              break;
                                              case 'Completed':
                                                   str_active_status='<span class="badge bg-violet">'+data+'</span>'
                                              break;
                                              case 'Closed':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                               case 'Cancelled':
                                                   str_active_status='<span class="badge badge-danger">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 },
							
                                 
                                 { "data": "amc_visit_status",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Scheduled':
                                                   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="assign_view_team" style="color:black" data-toggle="modal" data-target="#modal_visit_team"><i class="icon-collaboration"></i> Assign / View Team</a><a href="#" class="dropdown-item" name="visit_reschedule" style="color:black" data-toggle="modal" data-target="#modal_visit_reschedule"><i class="icon-rotate-cw"></i> Reschedule Visit</a><a href="#" class="dropdown-item" name="visit_cancel" style="color:black" data-toggle="modal" data-target="#modal_visit_cancel"><i class="icon-cancel-circle2"></i> Cancel Visit</a></div></div></div>';
                                              break;
                                              case 'Assigned':
                                                 str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="assign_view_team" style="color:black" data-toggle="modal" data-target="#modal_visit_team"><i class="icon-collaboration"></i> Assign / View Team</a><a href="#" class="dropdown-item" name="visit_reschedule" style="color:black" data-toggle="modal" data-target="#modal_visit_reschedule"><i class="icon-rotate-cw"></i> Reschedule Visit</a><a href="#" class="dropdown-item" name="visit_cancel" style="color:black" data-toggle="modal" data-target="#modal_visit_cancel"><i class="icon-cancel-circle2"></i> Cancel Visit</a></div></div></div>';
                                              break;
                                              case 'Completed':
                                                 
                                              break;
                                              case 'Closed':
                                                 
                                              break;
                                              case 'Cancelled':
                                              break;
                                          }
                                         
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
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
                 
                 
                  
	              $('#tbl_entries_ref_no tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_entries.row( tr );
                   
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
            				'<td ><div align="center">Priority </div></td>'+
            				'<td ><div align="center">Additional Info </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.complaints_description+'</div></td>'+
            				'<td><div align="center">'+d.ticket_priority+'</div></td>'+
            				'<td><div align="center">'+d.additional_info+'</div></td>'+
							
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
	                           
                 
                 
                 
                 
                 
     $('#tbl_entries_ref_no tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_list_entries.row($row).data();
       
        
         if($(this).attr("name")=='assign_view_team')
         {
              $('#txt_hidden_ticket_ref_code_assign_team').val(data.amc_tkt_ref_no);
              $('#txt_hidden_ticket_id_assign_team').val(data.amc_tkt_id);
               $('#txt_hidden_date_assign_team').val(data.visit_date);
               $('#txt_hidden_time_assign_team').val(data.visit_time);
               $('#txt_hidden_visit_id_assign_team').val(data.amc_visit_id);
                $('#span_ticket_ref_no_assign_tem').html(data.amc_tkt_ref_no);
                $('#span_date_assign_team').html(' Visit Date : '+data.date_of_visits);
                $('#span_time_assign_team').html(' Visit Time : '+data.time_of_visit);
                var ref_no=$('#txt_ref_code').val();
            $.post('../controller/ticket/ticket_assign_controller.php',{action:'load_ticket_details',ticket_ref_code:data.amc_tkt_ref_no},function(result,status){
            
            if(status=='success')
            {
            
                d = JSON.parse(result);
               
                       
                       
                        $('#span_customer_details_assign_team').html('Customer Details : '+d.data[0].customer_code+' - '+d.data[0].customer_name);
                        $('#span_location_details_assign_team').html(' Location : '+d.data[0].location_code+' - '+d.data[0].location_name);
                        $('#span_building_details_assign_team').html(' Building : '+d.data[0].building_code+' - '+d.data[0].building_name);
                       
            }
          
        });
          
          load_data_to_grid_all_employees_list(data.amc_visit_id);
          load_data_to_grid_assigned_employees_list(data.amc_visit_id);
         }
        if($(this).attr("name")=='visit_reschedule')
         {
             $('#span_ticket_ref_no_visit_reschedule').html(data.amc_tkt_ref_no);
             $('#txt_visit_id_reschedule').val(data.amc_visit_id);
             $('#txt_visit_date_rech').val(data.visit_date);
              $('#txt_visit_time_resch').val(data.time_of_visit);
             
         }
       
       
    });
    
    
      var v_all_employees_list_table = $('#tbl_employee').DataTable({});
            
             function load_data_to_grid_all_employees_list(visit_id)
                {
                 
                  v_all_employees_list_table.destroy();
                        
                   v_all_employees_list_table = $('#tbl_employee').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_assign_controller.php',
                                'data': {
                                   action: 'list_all_employees',visit_id:visit_id
                                   
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
                              
                                { "data": null,"width": "5%"},
                                  { "data": "employee_code",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data+' - '+rows["employee_name"];
                                        
                                    }   
                                },
								 { "data": "employee_contact_no",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                },
                                 { "data": "employee_code",
                                      render: function ( data, type, rows, meta ) {
                                         
                                             
                                                 
                                             
                                                 str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="view_expertise" style="color:black" data-toggle="modal" data-target="#modal_emp_view_expertise"><i class="icon-steam"></i> View Expertise</a><a href="#" class="dropdown-item" name="view_emp_schedule" style="color:black" data-toggle="modal" data-target="#modal_emp_view_schedule"><i class="icon-inbox"></i> View Schedule</a></div></div></div>';
                                          
                                         
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [0,1,2,3] }
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
                
        $('#tbl_employee tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_all_employees_list_table.row($row).data();
           
        }
    } );    
        
    
      var v_assigned_employees_list_table = $('#tbl_assigned_team').DataTable({});
    
    
     function load_data_to_grid_assigned_employees_list(visit_id)
                {
                 
                  v_assigned_employees_list_table.destroy();
                        
                   v_assigned_employees_list_table = $('#tbl_assigned_team').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_assign_controller.php',
                                'data': {
                                   action: 'list_assigned_employees',visit_id:visit_id
                                   
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
                              
                                { "data": null,"width": "5%"},
                                  { "data": "employee_code",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data+' - '+rows["employee_name"];
                                        
                                    }   
                                },
								 { "data": "is_leader",
                                render: function ( data, type, rows, meta ) {
                                        
                                         switch(data)
                                          {
                                              case 'Yes':
                                                   str_active_status='<span class="badge badge-success">Leader</span>'
                                              break;
                                              case 'No':
                                                   str_active_status='<span class="badge bg-indigo">Technician</span>'
                                              break;
                                             
                                          }
                                          return str_active_status;
                                        
                                    }   
                                },
                                 { "data": "ticket_team_ids",
                                      render: function ( data, type, rows, meta ) {
                                         
                                             
                                         switch(rows['is_leader'])
                                          {
                                              case 'Yes':
                                                   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="make_technician" style="color:black" ><i class="icon-arrow-resize7"></i> Change To Technician</a><a href="#" class="dropdown-item" name="delete_member_from_team" style="color:black" ><i class="icon-x"></i> Remove From Team</a><a href="#" class="dropdown-item" name="view_expertise" style="color:black" data-toggle="modal" data-target="#modal_emp_view_expertise"><i class="icon-steam"></i> View Expertise</a><a href="#" class="dropdown-item" name="view_emp_schedule" style="color:black" data-toggle="modal" data-target="#modal_emp_view_schedule"><i class="icon-inbox"></i> View Schedule</a></div></div></div>';
                                          
                                              break;
                                              case 'No':
                                                   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="make_leader" style="color:black" ><i class="icon-arrow-resize7"></i> Change To Leader</a><a href="#" class="dropdown-item" name="delete_member_from_team" style="color:black" ><i class="icon-x"></i> Remove From Team</a><a href="#" class="dropdown-item" name="view_expertise" style="color:black" data-toggle="modal" data-target="#modal_emp_view_expertise"><i class="icon-steam"></i> View Expertise</a><a href="#" class="dropdown-item" name="view_emp_schedule" style="color:black" data-toggle="modal" data-target="#modal_emp_view_schedule"><i class="icon-inbox"></i> View Schedule</a></div></div></div>';
                                              break;
                                             
                                          }
                                                 
                                             
                                                
                                         
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [0,1,2,3] }
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
    
     $('#tbl_employee tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_all_employees_list_table.row($row).data();
       
        
         if($(this).attr("name")=='view_expertise')
         {
            
                $('#span_employee_details').html(data.employee_code+'  '+data.employee_name);
               
           
          load_data_to_grid_expertise_employees_list(data.employee_id);
         }
        if($(this).attr("name")=='view_emp_schedule')
         {
            
                $('#span_employee_schedule_details').html(data.employee_code+'  '+data.employee_name);
                
               $('#txt_emp_id_cur_sch').val(data.employee_id);
               $('#txt_visit_date_search_sch').val($('#txt_hidden_date_assign_team').val());
            
          load_data_to_grid_cur_sch_employees_list(data.employee_id,$('#txt_hidden_date_assign_team').val());
         }
       
    });
    
    
    $('#tbl_assigned_team tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_assigned_employees_list_table.row($row).data();
       
        
         if($(this).attr("name")=='view_expertise')
         {
            
                $('#span_employee_details').html(data.employee_code+'  '+data.employee_name);
               
           
          load_data_to_grid_expertise_employees_list(data.employee_id);
         }
       
        if($(this).attr("name")=='view_emp_schedule')
         {
            
                $('#span_employee_schedule_details').html(data.employee_code+'  '+data.employee_name);
                $('#txt_emp_id_cur_sch').val(data.employee_id);
                $('#txt_visit_date_search_sch').val($('#txt_hidden_date_assign_team').val());
                
            
          load_data_to_grid_cur_sch_employees_list(data.employee_id,$('#txt_hidden_date_assign_team').val());
         }
         
         if($(this).attr("name")=='make_technician')
         {
             var visit_id=$('#txt_hidden_visit_id_assign_team').val();
           $.post("../controller/ticket/ticket_assign_controller.php",{action:'make_technician',ticket_team_ids:data.ticket_team_ids}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				     load_data_to_grid_assigned_employees_list(visit_id);
            				     
            				   
            			}
        				else
        				{
        				
        					swal("Error", result, "error");
        				}     
             });
         }
         
         if($(this).attr("name")=='make_leader')
         {
            var visit_id=$('#txt_hidden_visit_id_assign_team').val();
           $.post("../controller/ticket/ticket_assign_controller.php",{action:'make_leader',ticket_team_ids:data.ticket_team_ids}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				     load_data_to_grid_assigned_employees_list(visit_id);
            				   
            			}
        				else
        				{
        				
        					swal("Error", result, "error");
        				}     
             });
         }
         if($(this).attr("name")=='delete_member_from_team')
         {
            var visit_id=$('#txt_hidden_visit_id_assign_team').val();
           $.post("../controller/ticket/ticket_assign_controller.php",{action:'delete_member_from_team',ticket_team_ids:data.ticket_team_ids}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				     load_data_to_grid_all_employees_list(visit_id);
                                load_data_to_grid_assigned_employees_list(visit_id);
            				   
            			}
        				else
        				{
        				
        					swal("Error", result, "error");
        				}     
             });
         }
    });
    
    
    
    
      var v_expertise_employees_list_table = $('#tbl_employee_expertises').DataTable({});
    
    
     function load_data_to_grid_expertise_employees_list(employee_id)
                {
                 
                  v_expertise_employees_list_table.destroy();
                        
                   v_expertise_employees_list_table = $('#tbl_employee_expertises').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_assign_controller.php',
                                'data': {
                                   action: 'list_employee_expertise',employee_id:employee_id
                                   
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
                              
                               
                                  { "data": "expertise_name",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                }
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
                               // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                              //  return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
    
    
    
    
     var v_schedules_employees_list_table = $('#tbl_employee_cur_schedules').DataTable({});
    
    
     function load_data_to_grid_cur_sch_employees_list(employee_id,visit_date)
                {
                 
                  v_schedules_employees_list_table.destroy();
                        
                   v_schedules_employees_list_table = $('#tbl_employee_cur_schedules').DataTable( {
                          
                            "ajax": {
                                'type': 'POST',
                                'url': '../controller/ticket/ticket_assign_controller.php',
                                'data': {
                                   action: 'list_employee_schedule',employee_id:employee_id,visit_date:visit_date
                                   
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
                              
                               { "data": null,"width": "5%"},
                                  { "data": "location_name",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                },
                                 { "data": "building_name",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                },
                                { "data": "visit_date",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                },
                                 { "data": "visit_time",
                                render: function ( data, type, rows, meta ) {
                                        
                                        return str_actions=data;
                                        
                                    }   
                                }
                            ],
                            pageLength: 20,
                            searching: false,
                            responsive: true,
                            
                            "aoColumnDefs": [
                               { "bSortable": false, "aTargets": [0,1,,3] }
                               
                           ],
                           
                            "initComplete": function( settings, json ) {
                                   
                              
               
                             },
                               "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                
                                return nRow;
                             },
                             drawCallback: function (settings) {
                              
                           }
                           
                    });  
               
                }
    
    
  $('#btn_search_emp_sch').click(function(){
      
       var employee_id=$('#txt_emp_id_cur_sch').val();
       var visit_date=$('#txt_visit_date_search_sch').val();
       if(employee_id=='')
         {
               swal("Warning", "Employee id is missing to search the visits...", "warning");
         }
           else
           {
            load_data_to_grid_cur_sch_employees_list(employee_id,visit_date);
             
           }
  });
       
    
  var v_btn_assign = $('#btn_assign').ladda(); 
    
    $("#btn_assign").click(function(){
        
		v_btn_assign.ladda( 'start' );
		
		
		var ticket_ref_code=$('#txt_hidden_ticket_ref_code_assign_team').val();
		var ticket_id=$('#txt_hidden_ticket_id_assign_team').val();
		var visit_date=$('#txt_hidden_date_assign_team').val();
		var visit_time=$('#txt_hidden_time_assign_team').val();
		var visit_id=$('#txt_hidden_visit_id_assign_team').val();
		
		var emp_table_selected_count = v_all_employees_list_table.rows('.selected').data().length;
		
		  var EmpeTableSelectedValues = $.map(v_all_employees_list_table.rows('.selected').data(), function (item) {
			return item;
		}); 

        var empidarray = [];
        var empcodearray = [];
        var empnamearray = [];
        for(x=0;x<=emp_table_selected_count-1;x++)
				{
				    
				     empidarray.push(EmpeTableSelectedValues[x].employee_id);
				     empcodearray.push(EmpeTableSelectedValues[x].employee_code);
				     empnamearray.push(EmpeTableSelectedValues[x].employee_name);
				
				}
				
				if($.trim(ticket_id)==""||$.trim(visit_id)==""||$.trim(ticket_ref_code)=="")
                                
                                {
                                    swal("Warning","Token is missing...Please reload the page.", "warning");
                                    v_btn_assign.ladda( 'stop' );
                                    return false;
                                }
                 else
                    {
                       
                               
    		        $.post("../controller/ticket/ticket_assign_controller.php",{action:'ticket_visit_assign_team',ticket_ref_code:ticket_ref_code,ticket_id:ticket_id,visit_date:visit_date,visit_time:visit_time,visit_id:visit_id,emp_table_selected_count:emp_table_selected_count,empidarray:empidarray,empcodearray:empcodearray,empnamearray:empnamearray}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				    load_data_to_grid_all_employees_list(visit_id);
                                 load_data_to_grid_assigned_employees_list(visit_id);
                                 load_data_to_grid_entries_list();
            				    
            					v_btn_assign.ladda( 'stop' );
            					swal("Success", "Successfully assigned the team...", "success");
            					
            				   
            			}
        				else
        				{
        					v_btn_assign.ladda( 'stop' );
        					swal("Error", result, "error");
        				}
    		
    		    	});
            }
	});    
          
    $('#btn_resch_visit1').click(function(){
      
       var visit_id=$('#txt_visit_id_reschedule').val();
       var visit_date=$('#txt_visit_date_rech').val();
        var visit_time=$('#txt_visit_time_resch').val();
        
       if(visit_id=='')
         {
               swal("Warning", "Token is missing...", "warning");
         }
           else
           {
             $.post("../controller/ticket/ticket_assign_controller.php",{action:'reschedule_ticket',visit_id:visit_id,visit_date:visit_date,visit_time:visit_time}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				    
            					swal("Success", "Successfully rescheuled the visit...", "success");
            					load_data_to_grid_entries_list();
            					
            				   
            			}
        				else
        				{
        				
        					swal("Error", result, "error");
        				}
    		
    		    	});
             
           }
  });           
          
    

});