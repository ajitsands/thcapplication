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
                                 'url': '../controller/amc_schedule/amc_service_controller.php',
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
           load_data_to_grid_amc_services_list(0,0);
           load_data_to_grid_amc_schedules_list($.trim($('#txt_amc_ref_no').val()),0,0);
           
       }
     });
      $('#select_category').on('change', function(){
          load_type_combo_box();
         load_data_to_grid_amc_services_list($("#select_category option:selected").val(),0);
         load_data_to_grid_amc_schedules_list($.trim($('#txt_amc_ref_no').val()),$("#select_category option:selected").val(),0);
    });
    $('#div_assettype_select').change(function (e) {
          load_data_to_grid_amc_services_list($("#select_category option:selected").val(),$("#select_type option:selected").val());
        load_data_to_grid_amc_schedules_list($.trim($('#txt_amc_ref_no').val()),$("#select_category option:selected").val(),$("#select_type option:selected").val());
    });
     function load_type_combo_box()
    {
         var category_id=$("#select_category option:selected").val();
        	$.ajax({
                    		type: "POST",
                    		url: "../view/amc_schedule/type_combo.php",
                    		data: { category_id:category_id } 
                    		 }).done(function(data){
                    			$("#div_assettype_select").html(data);
								$("#select_type").select2();
										}); 
    }
  
  
   var v_amc_service_list_table = $('#list_of_services').DataTable({"destroy": true}); 
    
      
    
    function load_data_to_grid_amc_services_list(category_id,type_id)
    {
    // var category_id=$("#select_category option:selected").val();
    // var type_id=$("#select_type option:selected").val()
     
      v_amc_service_list_table.destroy();
            
       v_amc_service_list_table = $('#list_of_services').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_service_controller.php',
                    'data': {
                       action: 'amc_list_services',category_id:category_id,type_id:type_id
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": false,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
              
           
               "columns": [
                  
                    { "data": null},
                   
                    { "data": "service_description"},
                ],
                pageLength: 30,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1] },
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

$('#list_of_services tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_service_list_table.row($row).data();
           
        }
    } ); 

  
  
    var v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable({"destroy": true}); 
    
      
    
    function load_data_to_grid_amc_schedules_list(amc_ref_nos,category_id,type_id)
    {
     
      v_amc_schedules_list_table.destroy();
            
       v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_service_controller.php',
                    'data': {
                       action: 'amc_list_schedules',amc_ref_nos:amc_ref_nos,category_id:category_id,type_id:type_id
                       
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
                   
                     { "data": "amc_visit_status",
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Scheduled':
                                                   str_active_status='<span class="badge badge-info">'+data+'</span>'
                                              break;
                                              case 'Assigned':
                                                   str_active_status='<span class="badge bg-indigo">'+data+'</span>'
                                              break;
                                              case 'Completed':
                                                   str_active_status='<span class="badge bg-brown">'+data+'</span>'
                                              break;
                                              case 'Closed':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                              case 'Cancelled':
                                                   str_active_status='<span class="badge badge-secondary">'+data+'</span>'
                                              break;
                                               default:
                                              str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                    },
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
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                   { "width": "5%", "targets": 0 },
                   { "width": "5%", "targets": 6 },
                   { "width": "20%", "targets": 3 }
                   
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
             
            load_data_to_grid_services(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id);
             $('#span_ticket_ref_no_view_services').html(data.asset_ref_no);
             $('#txt_amc_visit_id_hid').val(data.amc_visit_id);
              $('#txt_amc_child_id_hid').val(data.amc_tkt_id);
               $('#txt_amc_ref_nos_hid').val(data.amc_ref_no);
             
         }
       if($(this).attr("name")=='amc_view_team')
         {
             
           $('#span_ticket_ref_no_view_team').html(data.asset_ref_no);
            load_data_to_grid_assign_team(data.amc_tkt_id,data.amc_ref_no,data.amc_visit_id)
             
         }
       
});
 

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
      
      var v_btn_amc_assign_services = $('#btn_amc_assign_services').ladda();
    v_btn_amc_assign_services.click(function(){
        
        var ticket_count = v_amc_schedules_list_table.rows('.selected').data().length;
		  		  var ticketTableSelectedValues = $.map(v_amc_schedules_list_table.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var visit_idarray = [];
                var amc_tkt_idarray = [];
                var amc_ref_noarray = [];
                var asset_idarray = [];
                var asset_codearray = [];
               
               
                for(t=0;t<=ticket_count-1;t++)
        				{
        				    
        				     visit_idarray.push(ticketTableSelectedValues[t].amc_visit_id);
        				     amc_tkt_idarray.push(ticketTableSelectedValues[t].amc_tkt_id);
        				     amc_ref_noarray.push(ticketTableSelectedValues[t].amc_ref_no);
        				     asset_idarray.push(ticketTableSelectedValues[t].asset_id);
        				     asset_codearray.push(ticketTableSelectedValues[t].asset_ref_no);
        				    
        				
        				}
		
         
         	var service_selected_count = v_amc_service_list_table.rows('.selected').data().length;
		
        		  var serviceTableSelectedValues = $.map(v_amc_service_list_table.rows('.selected').data(), function (item) {
        			return item;
        		}); 
        
                var serviceidarray = [];
                var service_desearray = [];
                for(x=0;x<=service_selected_count-1;x++)
        				{
        				    
        				     serviceidarray.push(serviceTableSelectedValues[x].service_id);
        				     service_desearray.push(serviceTableSelectedValues[x].service_description);
        				
        				}
     		
       if($.trim(service_selected_count)==0)
       {
           swal("Warning","Please select the services ....", "warning");
           v_btn_amc_assign_services.ladda( 'stop' );
           return false;
       }
        if($.trim(ticket_count)==0)
       {
           swal("Warning","Please select the schedules ....", "warning");
           v_btn_amc_assign_services.ladda( 'stop' );
           return false;
       }
       else
       {         
     
        
       
				  swal({                                      
        							title: "Are you sure to proceed assign services to the schedules?",
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
        						
        						         $.post("../controller/amc_schedule/amc_service_controller.php",{action:'assign_services',visit_idarray:visit_idarray,amc_tkt_idarray:amc_tkt_idarray,amc_ref_noarray:amc_ref_noarray,asset_idarray:asset_idarray,asset_codearray:asset_codearray,serviceidarray:serviceidarray,service_desearray:service_desearray,ticket_count:ticket_count,service_selected_count:service_selected_count}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                      v_btn_amc_assign_services.ladda( 'stop' );
                      swal("Success","Successfully assigned services to the schedules ....", "success");
                    });
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
     
   
       }
   });  
   
   
        
   
  
   
      var list_of_services = $('#tbl_assigned_services_list').DataTable();
    
     function load_data_to_grid_services(amc_child_id,amc_ref_nos,amc_visit_id)
                 {
                    
                    list_of_services.destroy();
                         
                     list_of_services = $('#tbl_assigned_services_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_service_controller.php',
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
                                 },
                                   { "data": "service_description",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_active_status='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"  name="amc_delete_services"><i class="icon-x"></i> Delete Service</a></div></div></div>';
                             
                         }   
                    }
                    
                                 
                       
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
  
    
    $('#tbl_assigned_services_list tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = list_of_services.row($row).data();
       
       if($(this).attr("name")=='amc_delete_services')
         {
             
            delete_services(data.amc_service_id);
             
         }
      
       
});
          
   function delete_services(amc_service_id)
   {
        swal({                                      
        							title: "Are you sure to delete the service from the schedule?",
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
        						
        						         $.post("../controller/amc_schedule/amc_service_controller.php",{action:'delete_services',amc_service_id:amc_service_id}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                       var amc_visit_id=$('#txt_amc_visit_id_hid').val();
                        var amc_tkt_id= $('#txt_amc_child_id_hid').val();
                         var amc_ref_no=$('#txt_amc_ref_nos_hid').val();
                      swal("Success","Successfully deleted the service from the schedule ....", "success");
                      load_data_to_grid_services(amc_tkt_id,amc_ref_no,amc_visit_id);
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
                 $("#btn_reload").click(function(){
                     location.reload();
                 });
         
         
} );