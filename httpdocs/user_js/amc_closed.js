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
    $('#tab_customer').click(function(){
        load_data_to_grid_amc_details_list();
    });
    load_data_to_grid_amc_details_list();
     
                 function load_data_to_grid_amc_details_list()
                 {
                   
                     
                    list_of_amc.destroy();
                         
                     list_of_amc = $('#list_of_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_closed/amc_closed_controller.php',
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
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
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
                             pageLength: 20,
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
    
  
    
                 
    
                 
         
         
//AMC ASSIGN SERVICES
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
     
     
  
   
  
    var v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable({"destroy": true}); 
    
      
    
    function load_data_to_grid_amc_schedules_list(amc_ref_nos)
    {
     
      v_amc_schedules_list_table.destroy();
            
       v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_closed/amc_closed_controller.php',
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
                   { "data": "amc_visit_id",
                          render: function ( data, type, rows, meta ) {
                             str_active_status='WO-'+rows["amc_ref_no"]+'-'+rows["amc_visit_id"];
                             
                         	return str_active_status;

							 },
                     },
                    { "data": "asset_ref_no"},
                   
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
                   
                       { "data": "amc_service_report_no"},
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_services" name="amc_view_services"><i class="icon-eye"></i> View Services</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_assigned_team" name="amc_view_team"><i class="icon-collaboration"></i> View Team</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 30,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6,7] },
                   { "width": "5%", "targets": 1 },
                   { "width": "5%", "targets": 7 },
                   { "width": "20%", "targets": 4 }
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }
    
     $('#list_of_amc_schedules tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_amc_schedules_list_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_visit(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_visit(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				'<td ><div align="center">Servcie Report </div></td>'+
            				'<td ><div align="center">Closed Date </div></td>'+
							'<td ><div align="center">Close Remarks </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				'<td><div align="center"><a href="../../httpdocs/images/ticket_close_image/'+d.amc_service_report_image+'" target="_BLANK"><img src="../../httpdocs/images/ticket_close_image/'+d.amc_service_report_image+'" class="rounded-circle" height="40px" width="40px"/> </a></div></td>'+
            				'<td><div align="center">'+d.amc_close_date_time+'</div></td>'+
							'<td><div align="center">'+d.amc_close_remarks+'</div></td>'+
            				
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		
		
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
           
         $('#span_ticket_ref_no_completed_view_services').html(data.amc_ref_no);
             $.ajax({
        		type: "POST",
        		url: "amc_closed/services_list_closed_modal.php",
        		data: {visit_id:data.amc_visit_id} 
        		 }).done(function(data){
        		     
        			$("#div_services_list").html(data);
        		 });
        
            
             
         }
       if($(this).attr("name")=='amc_view_team')
         {
             
           $('#span_ticket_ref_no_view_team').html(data.asset_ref_no);
            load_data_to_grid_assign_team(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id)
             
         }
          if($(this).attr("name")=='amc_close_wo')
         {
             
          
           $('#txt_service_report_no').val(data.amc_service_report_no);
           $('#txt_hidden_ticket_image_close').val(data.amc_service_report_image);
           $('#txt_remarks').val(data.amc_close_remarks);
           
         }
         
       
});
 

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
      
   

    var list_of_assigned_team = $('#tbl_assigned_team').DataTable();
    
     function load_data_to_grid_assign_team(amc_child_id,amc_ref_nos,amc_visit_id)
                 {
                    
                    list_of_assigned_team.destroy();
                         
                     list_of_assigned_team = $('#tbl_assigned_team').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_closed/amc_closed_controller.php',
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
                                 { "data": "is_leader" },
                                  { "data": "is_attend" }
                       
                             ],
                             pageLength: 20,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4] }
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
                 $("#btn_reload").click(function(){
                     location.reload();
                 });
         
         
} );