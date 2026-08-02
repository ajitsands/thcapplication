$(document).ready(function() {
    $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
    
    
   
    var list_of_amc = $('#list_of_amc').DataTable();
   
    clear_hidden_values();
    
    
    function clear_hidden_values()
    {
        $('#txt_amc_id').val('');
        $('#txt_amc_ref_no').val('');
         $('#span_amc_details').html('');
    }
    
    load_data_to_grid_amc_details_list();
     
                 function load_data_to_grid_amc_details_list()
                 {
                     
                    list_of_amc.destroy();
                         
                     list_of_amc = $('#list_of_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_assign_controller.php',
                                 'data': {
                                    action: 'amc_list'
                                    
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
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "amc_ref_no" },
								 { "data": "customer_code"},
                                 { "data": "customer_name"},
                                 { "data": "contract_type_name"},
                                 { "data": "amc_start_date"},
                                 { "data": "amc_end_date"}
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,4,5,6,7] }, 
            					
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
    
    $('#list_of_amc tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_hidden_values();
        }
        else {
            list_of_amc.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_amc.row($row).data();
            $('#txt_amc_id').val(ids.amc_id);
            $('#txt_amc_ref_no').val(ids.amc_ref_no);
            $('#txt_hidden_ticket_customer_code').val(ids.customer_code);
            $('#txt_hidden_ticket_customer_name').val(ids.customer_name);
          
            $('#span_amc_details').html("AMC Ref No : "+ids.amc_ref_no+" , Customer : "+ids.customer_name+" - "+ids.customer_code);
        }
    } );
    
        $('#list_of_amc tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = list_of_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_amc(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Signed Date </div></td>'+
							'<td ><div align="center">Description </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
							'<td><div align="center">'+d.amc_description+'</div></td>'+
            				
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		
		
	            }
    
  
    
                 
    
                 
         
         
          //AMC SCHEDULE VISITS
    $('#tab_scheduled_visits').click(function(){
       if($.trim($('#txt_amc_id').val())=="") 
       {
           swal("Warning","Please select an AMC ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_amc_schedules_list($.trim($('#txt_amc_ref_no').val()));
           
       }
     });
     
    
    
  
    var v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable({"destroy": true,
        "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
    }); 
    
      
    
    function load_data_to_grid_amc_schedules_list(amc_ref_nos)
    {
     
      v_amc_schedules_list_table.destroy();
            
       v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_assign_controller.php',
                    'data': {
                       action: 'amc_list_schedules',amc_ref_nos:amc_ref_nos
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": true,
               "bLengthChange": true,
               "bFilter": true,
               "bInfo": true,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
                   { "data": "amc_visit_id",
                          render: function ( data, type, rows, meta ) {
                             str_active_status='WO-'+rows["amc_ref_no"]+'-'+rows["amc_visit_id"];
                             
                         	return str_active_status;

							 },
                     },
                    { "data": "date_of_visits"},
                    
                    { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
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
                        },
                    { "data": "asset_ref_no"},
                    { "data": "category_name"},
                    { "data": "asset_type_name"},
                     
                   
                    // { "data": "visit_start_time"},
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_update_schedule" name="amc_update_schedule"><i class="icon-pencil"></i> Update Schedule</a><a href="#" class="dropdown-item" name="amc_cancel_schedule"><i class="icon-quill4"></i> Cancel Schedule</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services" name="amc_view_services"><i class="icon-eye"></i> View Services</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 25,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,6,7] },
                   { "width": "5%", "targets": 0 },
                   { "width": "5%", "targets": 7 },
                   { "width": "20%", "targets": 4 }
                   
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




$('#list_of_amc_schedules tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            
        }
        else {
            v_amc_schedules_list_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_schedules_list_table.row($row).data();
            $('#txt_visit_date_asg').val(ids.date_of_visits1);
            $("#select_slots_asg").val(ids.time_of_visit).change();
             $("#duration_asg").val(ids.additional_slots).change();
           
            
           
        }
     
        
    } ); 
    $('#list_of_amc_schedules tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_schedules_list_table.row($row).data();
        var v_amc_visit_id  = data.amc_visit_id;
        var v_amc_ref_no  = data.amc_ref_no;
        var v_amc_asset_code  = data.asset_ref_no;
       if($(this).attr("name")=='amc_view_services')
         {
             
            load_data_to_grid_services(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id);
             $('#span_ticket_ref_no_view_services').html(data.asset_ref_no);
         }
       if($(this).attr("name")=='amc_update_schedule')
         {
             $('#amc_no_view_head_update_visit').html('AMC Ref No : '+v_amc_ref_no+' , Asset Code : '+v_amc_asset_code);
             $('#txt_amc_visit_id_hidden').val(v_amc_visit_id);
             $('#txt_amc_refno_update_hidden').val(v_amc_ref_no);
             
         }
         if($(this).attr("name")=='amc_cancel_schedule')
         {
             
             
              swal({                                      
        							title: "Are you sure to cancel the schedule?",
        						//	text: "Do you want to add item?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'Do not Proceed !',
        							  delete: 'Yes Please Proceed.'
        							}
        							}).then(function (willadd) {
        							if (willadd) {
        						
        						        $.post("../controller/amc_schedule/amc_schedule_controller.php",{action:'cancel_visit',amc_visit_id:v_amc_visit_id}
                                           , function(result,status)
                                             {
                                              
                                                    result = $.trim(result);
                                                    
                                                    if(status=='success')
                                                        {
                                                            
                                                            swal("Success", "Successfully cancelled the schedule...", "success");
                                                            
                                                            load_data_to_grid_amc_schedules_list(v_amc_ref_no);
                                                        }
                                                    else 
                                                        {
                                                            
                                                                swal("Error", "Sorry! Could not cancel the schedule...", "error");
                                                                return false;
                                                                
                                                        }
                                             });
            
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
             
             
           
             
         }
       
});
 

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
      var v_btn_amc_change_schedule = $('#btn_change_schedule').ladda();
    v_btn_amc_change_schedule.click(function(){ 
       var amc_visit_id = $("#txt_amc_visit_id_hidden").val();
       var visit_date = $("#txt_visit_date_update").val();
       var start_slot=$("#select_slots_updated").val();
       var add_slot=$("#duration_update").val();
       var schedule_time=$("#txt_time_update").val();
       var amc_ref_no=$("#txt_amc_refno_update_hidden").val();
     		
       if($.trim(amc_visit_id)=="")
       {
           swal("Warning","Please select the schedule ....", "warning");
           v_btn_amc_change_schedule.ladda( 'stop' );
           return false;
       }
       if(visit_date=="")
       {
           swal("Warning","Please select visit date ....", "warning");
           v_btn_amc_change_schedule.ladda( 'stop' );
           return false;
       }
       else
       {         
     
        
       
				  swal({                                      
        							title: "Are you sure to proceed with Schedule Update?",
        						//	text: "Do you want to add item?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Proceed.'
        							}
        							}).then(function (willadd) {
        							if (willadd) {
        						
        						         $.post("../controller/amc_schedule/amc_assign_controller.php",{action:'update_visits',amc_visit_id:amc_visit_id,visit_date:visit_date,schedule_time:schedule_time,start_slot:start_slot,add_slot:add_slot}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                      v_btn_amc_change_schedule.ladda( 'stop' );
                      load_data_to_grid_amc_schedules_list(amc_ref_no);
                    });
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
     
   
       }
   });  
   
    //AMC VISIT SCHEDULE CLOSE
        
        
   //ASSIGN TECHNICIAN
     $('#tab_assign_tech').click(function(){
       if($.trim($('#txt_amc_id').val())=="") 
       {
           swal("Warning","Please select an AMC ....", "warning");
            return false;
       }
       else
       {
          load_two_datatables();
           
       }
     });
        
      $('#select_slots_asg').on('change', function(){
          load_two_datatables();
        
    }); 
     $('#duration_asg').on('change', function(){
          load_two_datatables();
        
    }); 
     $('#txt_visit_date_asg').on('change', function(){
         load_two_datatables();
     });
      $('#select_tech_type_asg').on('change', function(){
         load_two_datatables();
     });
    function load_two_datatables()
    {
        var amc_ref_no=$.trim($('#txt_amc_ref_no').val());
         var visit_date=$("#txt_visit_date_asg").val();
         var visit_slot=$("#select_slots_asg option:selected").val();
         var visit_duration=$("#duration_asg option:selected").val();
         var tech_type=$("#select_tech_type_asg option:selected").val();
         
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
             load_data_to_grid_tech_avail_list(visit_date,new_slot_sql_string,tech_type);
         load_data_to_grid_amc_asset_sch_list(amc_ref_no,visit_date,visit_slot,visit_duration);
           
          }
    }
        var v_amc_assets_sch_list_table = $('#list_of_amc_assets_schs').DataTable({"destroy": true,
            
                "Paginate": false,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
               searching: false,
                responsive: true
        }); 
    
      
    
    function load_data_to_grid_amc_asset_sch_list(amc_ref_nos,visit_date,start_slot,add_slot)
    {
     
      v_amc_assets_sch_list_table.destroy();
            
       v_amc_assets_sch_list_table = $('#list_of_amc_assets_schs').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_assign_controller.php',
                    'data': {
                       action: 'amc_list_schedules_for_assign',amc_ref_nos:amc_ref_nos,visit_date:visit_date,start_slot:start_slot,add_slot:add_slot
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": true,
               "bLengthChange": true,
               "bFilter": true,
               "bInfo": true,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
                    { "data": "amc_visit_id",
                          render: function ( data, type, rows, meta ) {
                             str_active_status='WO-'+rows["amc_ref_no"]+'-'+rows["amc_visit_id"];
                             
                         	return str_active_status;

							 },
                     },
                    { "data": "asset_ref_no"},
                    { "data": "category_name"},
                    { "data": "asset_type_name"},
                     { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services" name="amc_view_services"><i class="icon-eye"></i> View Services</a></div></div></div>';
                             
                         }   
                    }
          
                ],
                pageLength: 30,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5] },
                   { "width": "5%", "targets": 0 }
                   
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
    $('#list_of_amc_assets_schs tbody').on( 'click', 'tr', function () {
         if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_assets_sch_list_table.row($row).data();
           
        }
    } );
    
    $('#list_of_amc_assets_schs tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_assets_sch_list_table.row($row).data();
       
       if($(this).attr("name")=='amc_view_services')
         {
             
            load_data_to_grid_services(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id);
             $('#span_ticket_ref_no_view_services').html(data.asset_ref_no);
         }
         
    });
   
      var list_of_services = $('#tbl_assigned_services_list').DataTable();
    
     function load_data_to_grid_services(amc_child_id,amc_ref_nos,amc_visit_id)
                 {
                    
                    list_of_services.destroy();
                         
                     list_of_services = $('#tbl_assigned_services_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_assign_controller.php',
                                 'data': {
                                         action: 'list_services',amc_child_id:amc_child_id,amc_ref_nos:amc_ref_nos,amc_visit_id:amc_visit_id
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"bPaginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"bSearch": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                { "data": null},
                                { "data": "service_description" },
                                { "data": "tech_remarks" },
                                { "data": "amc_service_status",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Pending':
                                                   str_active_status='<span class="badge badge-info">'+data+'</span>'
                                              break;
                                              case 'Completed':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                              case 'Cancelled':
                                                   str_active_status='<span class="badge badge-danger">'+data+'</span>'
                                              break;
                                              case 'Start':
                                                   str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                              break;
                                               default:
                                              str_active_status='<span class="badge bg-slate-400">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 }
                                 
                       
                             ],
                             pageLength: 30,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3] }
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
                      
     var v_tech_avil_list_table = $('#list_of_techs_avail_agn').DataTable({            "destroy": true,
                "Paginate": false,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
               searching: false,
                responsive: true
     }); 
    
      
    
    function load_data_to_grid_tech_avail_list(visit_date,sql_str,tech_type)
    {
     
      v_tech_avil_list_table.destroy();
            
       v_tech_avil_list_table = $('#list_of_techs_avail_agn').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_assign_controller.php',
                    'data': {
                       action: 'list_avail_tech_in_schedule_ticket',visit_date:visit_date,visit_slot:sql_str,tech_type:tech_type
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": false,
               "bLengthChange": true,
               "bFilter": true,
               "bInfo": true,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
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
                pageLength: 30,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3] },
                   { "width": "5%", "targets": 0 }
                   
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
        
	   $('#list_of_techs_avail_agn tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_tech_avil_list_table.row($row).data();
           
        }
    } ); 
    
    $("#list_of_techs_avail_agn tbody").on('change',"input[type='checkbox']",function(e){
        var table = $('#list_of_techs_avail_agn').DataTable();
        table.$("input[type=checkbox]").prop("checked", false);
        $(this).prop("checked", true);
         var $row = $(this).closest('tr');
        $row.addClass('selected');
         
    });
      
var v_btn_ticket_entries_assign = $('#btn_amc_assign').ladda();
 $("#btn_amc_assign").click(function(){
        
		v_btn_ticket_entries_assign.ladda( 'start' );
		
	       var leadr_emp_id;
	       var ticket_count = v_amc_assets_sch_list_table.rows('.selected').data().length;
		
        		  var ticketTableSelectedValues = $.map(v_amc_assets_sch_list_table.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var visitidarray = [];
                var amc_tkt_idarray = [];
                var amc_ref_noarray = [];
                var customer_idarray = [];
                var customer_codearray = [];
                var customer_namearray = [];
                var location_idarray = [];
                var location_codearray = [];
                var location_namearray = [];
                var building_idarray = [];
                var building_codearray = [];
                var building_namearray = [];
                var visit_date_array = [];
                var startslot_array = [];
                var additional_slotsarray = [];
                var visit_start_timearray = [];
                var totalslot_array = [];
               
                for(t=0;t<=ticket_count-1;t++)
        				{
        				    
        				     visitidarray.push(ticketTableSelectedValues[t].amc_visit_id);
        				     amc_tkt_idarray.push(ticketTableSelectedValues[t].amc_tkt_id);
        				     amc_ref_noarray.push(ticketTableSelectedValues[t].amc_ref_no);
        				     customer_idarray.push(ticketTableSelectedValues[t].customer_id);
        				     customer_codearray.push(ticketTableSelectedValues[t].customer_code);
        				     customer_namearray.push(ticketTableSelectedValues[t].customer_name);
        				     location_idarray.push(ticketTableSelectedValues[t].location_id);
        				     location_codearray.push(ticketTableSelectedValues[t].location_code);
        				     location_namearray.push(ticketTableSelectedValues[t].location_name);
        				     building_idarray.push(ticketTableSelectedValues[t].building_id);
        				     building_codearray.push(ticketTableSelectedValues[t].building_code);
        				     building_namearray.push(ticketTableSelectedValues[t].building_name);
        				     visit_date_array.push(ticketTableSelectedValues[t].date_of_visits);
        				     startslot_array.push(ticketTableSelectedValues[t].time_of_visit);
        				     additional_slotsarray.push(ticketTableSelectedValues[t].additional_slots);
        				     visit_start_timearray.push(ticketTableSelectedValues[t].visit_start_time);
        				      totalslot_array.push(parseInt(ticketTableSelectedValues[t].time_of_visit)+parseInt(ticketTableSelectedValues[t].additional_slots));
        				
        				}
		
         
         	var tech_table_selected_count = v_tech_avil_list_table.rows('.selected').data().length;
		
        		  var techTableSelectedValues = $.map(v_tech_avil_list_table.rows('.selected').data(), function (item) {
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
        			 var table = $('#list_of_techs_avail_agn').DataTable();

                      var checkedvalues = table.$('input:checked').map(function () {
                          leadr_emp_id=this.id;
                        }).get().join(',');
           
          
           if(ticket_count==0)
            {
                swal("Warning", "Please select the entry before scheduling...", "warning");
                 v_btn_ticket_entries_assign.ladda( 'stop' );
               return false; 
            }
           if(tech_table_selected_count==0)
                {
                      swal("Warning", "Please select the technicians...", "warning");
                      v_btn_ticket_entries_assign.ladda( 'stop' );
                  return false;    
                }
          
           else
           {
         
               
               swal({                                      
        							title: "Are you sure to proceed with AMC Assigning?",
        						//	text: "Do you want to add item?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Proceed.'
        							}
        							}).then(function (willadd) {
        							if (willadd) {
        						    
              
        						         $.post("../controller/amc_schedule/amc_assign_controller.php",{action:'assign_technician',visitidarray:visitidarray,amc_tkt_idarray:amc_tkt_idarray,amc_ref_noarray:amc_ref_noarray,customer_idarray:customer_idarray,customer_codearray:customer_codearray,customer_namearray:customer_namearray,location_idarray:location_idarray,location_codearray:location_codearray,location_namearray:location_namearray,building_idarray:building_idarray,building_codearray:building_codearray,building_namearray:building_namearray,visit_date_array:visit_date_array,startslot_array:startslot_array,additional_slotsarray:additional_slotsarray,visit_start_timearray:visit_start_timearray,empidarray:empidarray,empcodearray:empcodearray,empnamearray:empnamearray,leadr_emp_id:leadr_emp_id,totalslot_array:totalslot_array,emp_count:tech_table_selected_count,ticket_count:ticket_count,empcontactnoarray:empcontactnoarray}
                          , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                            v_btn_ticket_entries_assign.ladda( 'stop' );
                                            swal("Success", "Successfully assigned the visits...", "success");
                                             
                                           load_two_datatables();
                                        
                                            
                                        }
                                    else 
                                        {
                                             v_btn_ticket_entries_assign.ladda( 'stop' );
                                                swal("Error", "Sorry! Could not schedule...", "error");
                                                return false;
                                                
                                        }
                             });
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
                    
             
           }
    }); 
    
         
       //ASSIGN TECHNICIAN CLOSE  
        
        
        
            
          
    $('#list_of_techs_avail_agn tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_tech_avil_list_table.row($row).data();
       
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
                                 'url': '../controller/amc_schedule/amc_assign_controller.php',
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
                    var visit_date=$('#txt_visit_date_asg').val();
                    
                    list_of_tech_schedules_multiple.destroy();
                         
                     list_of_tech_schedules_multiple = $('#tbl_tech_schedules_multiple').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_assign_controller.php',
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
        
        
        
        //Assigned List
        
         $('#tab_assigned_list').click(function(){
       if($.trim($('#txt_amc_id').val())=="") 
       {
           swal("Warning","Please select an AMC ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_amc_assigned_list($.trim($('#txt_amc_ref_no').val()));
           
       }
     });
      var v_amc_assigned_list_table = $('#list_of_amc_assigned_visits').DataTable({"destroy": true,
          "bLengthChange": false,
               "bFilter": false,
               "bInfo": false
      }); 
    
      
    
    function load_data_to_grid_amc_assigned_list(amc_ref_nos)
    {
     
      v_amc_assigned_list_table.destroy();
            
       v_amc_assigned_list_table = $('#list_of_amc_assigned_visits').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_assign_controller.php',
                    'data': {
                       action: 'amc_list_assigned_visits',amc_ref_nos:amc_ref_nos
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": true,
               "bLengthChange": true,
               "bFilter": true,
               "bInfo": true,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
                   { "data": "amc_visit_id",
                          render: function ( data, type, rows, meta ) {
                             str_active_status='WO-'+rows["amc_ref_no"]+'-'+rows["amc_visit_id"];
                             
                         	return str_active_status;

							 },
                     },
                    { "data": "date_of_visits"},
                    
                    { "data": "time_of_visit",
                                  render: function ( data, type, rows, meta ) {
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
                        },
                    { "data": "asset_ref_no"},
                    { "data": "category_name"},
                    { "data": "asset_type_name"},
                    
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                           
                           
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services" name="amc_view_services"><i class="icon-eye"></i> View Services</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_assigned_team" name="amc_view_team"><i class="icon-collaboration"></i> View Team</a><a href="#" class="dropdown-item"  name="amc_remove_team"><i class="icon-user-cancel"></i> Remove Team</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 30,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,6,7] },
                   { "width": "5%", "targets": 0 },
                   { "width": "5%", "targets": 7 }
                   
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

$('#list_of_amc_assigned_visits tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_assigned_list_table.row($row).data();
           
        }
    } ); 
    $('#list_of_amc_assigned_visits tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_assigned_list_table.row($row).data();
        var v_amc_visit_id  = data.amc_visit_id;
        var v_amc_ref_no  = data.amc_ref_no;
        var v_amc_asset_code  = data.asset_ref_no;
       if($(this).attr("name")=='amc_view_services')
         {
             
            load_data_to_grid_services(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id);
             $('#span_ticket_ref_no_view_services').html(data.asset_ref_no);
         }
          if($(this).attr("name")=='amc_view_team')
         {
             
            load_data_to_grid_assign_team(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id);
             $('#span_ticket_ref_no_view_team').html(data.asset_ref_no);
         }
        if($(this).attr("name")=='amc_remove_team')
         {
            var total_slots= parseInt(data.time_of_visit)+parseInt(data.additional_slots)
            remove_team(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id,data.date_of_visits1,data.time_of_visit,data.additional_slots,total_slots);
         }
    
});   

function remove_team(amc_child_id,amc_ref_nos,amc_visit_id,visit_date,start_slot,add_slot,total_slots)
{
     swal({                                      
        							title: "Are you sure to remove the team?",
        							text: "The complete team will be removed and the status of WO will become scheduled",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Proceed.'
        							}
        							}).then(function (willadd) {
        							if (willadd) {
        						    
              
        						         $.post("../controller/amc_schedule/amc_assign_controller.php",{action:'remove_team',amc_visit_id:amc_visit_id,amc_ref_nos:amc_ref_nos,amc_child_id:amc_child_id,visit_date:visit_date,start_slot:start_slot,add_slot:add_slot,total_slots:total_slots}
                          , function(result,status)
                             {
                              
                                    result = $.trim(result);
                                    
                                    if(status=='success')
                                        {
                                           
                                            swal("Success", "Successfully removed the team...", "success");
                                             
                                           load_data_to_grid_amc_assigned_list(amc_ref_nos);
                                        
                                            
                                        }
                                    else 
                                        {
                                            
                                                swal("Error", "Sorry! Could not remove the team...", "error");
                                                return false;
                                                
                                        }
                             });
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
}
        var list_of_assigned_team = $('#tbl_assigned_team').DataTable();
    
     function load_data_to_grid_assign_team(amc_child_id,amc_ref_nos,amc_visit_id)
                 {
                    
                    list_of_assigned_team.destroy();
                         
                     list_of_assigned_team = $('#tbl_assigned_team').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_assign_controller.php',
                                 'data': {
                                         action: 'list_assign_team',amc_visit_id:amc_visit_id,amc_child_id:amc_child_id,amc_ref_nos:amc_ref_nos
                                    
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
                               { "data": null},
                                 { "data": "employee_name",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status=data+' - '+rows["employee_code"];
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "employee_contact_no" },
                                 { "data": "is_leader" }
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3] }
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
          //Check Technician Availability
	  
	            
      	$("#btn_list_techs_check_avail").click(function(){
      	    
      	  
      	   var check_date=$("#txt_search_date_check_avail").val();
      	    var slot=$("#select_slots_check_avail").val();
           var expertise_array=$("#select_tech_expertise").val();
           if(check_date=='' || slot=='select' || expertise_array=='select')
           {
                swal("Warning","Please provide all the details ....", "warning");
                      
                        return false;
           }
           else
           {
               load_data_to_grid_techs_list(expertise_array,check_date,slot);
           }
           	
      	});
      	
      var list_of_techs = $('#tbl_techs_check_avail').DataTable();
    
    
       function load_data_to_grid_techs_list(expertise_array,check_date,slot)
                 {
                    
                    list_of_techs.destroy();
                         
                     list_of_techs = $('#tbl_techs_check_avail').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_technicians',expertise_array:expertise_array,check_date:check_date,slot:slot
                                    
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
                                
                                 { "data": "employee_name",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status=data+' - '+rows["employee_code"];
                                     	return str_active_status;
            
            							 },
                                 }
                       
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
                 
                 $("#btn_reload").click(function(){
                     location.reload();
                 });
         
         
} );