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
                                 'url': '../controller/amc_schedule/amc_schedule_controller.php',
                                 'data': {
                                    action: 'amc_list_new'
                                    
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
    
    // $('#list_of_amc tbody').on( 'click', 'tr', function () {
    //     if ( $(this).hasClass('selected') ) {
    //         $(this).removeClass('selected');
    //         clear_hidden_values();
    //     }
    //     else {
    //         list_of_amc.$('tr.selected').removeClass('selected');
    //         $(this).addClass('selected');
            
    //         var $row = $(this).closest('tr');
    //         var ids = list_of_amc.row($row).data();
    //         $('#txt_amc_id').val(ids.amc_id);
    //         $('#txt_amc_ref_no').val(ids.amc_ref_no);
    //         $('#txt_hidden_ticket_customer_code').val(ids.customer_code);
    //         $('#txt_hidden_ticket_customer_name').val(ids.customer_name);

    //         $("#txt_from_date").val(ids.amc_start_dates);
    //         $("#txt_hiddem_amc_st_date").val(ids.amc_start_dates);
    //         $("#txt_to_date").val(ids.amc_end_dates);
    //          $("#txt_hiddem_amc_ed_date").val(ids.amc_end_dates);
    //         $("#txt_from_date").attr("min",ids.amc_start_dates);
    //         $("#txt_from_date").attr("max",ids.amc_end_dates);
    //          $("#txt_to_date").attr("min",ids.amc_start_dates);
    //         $("#txt_to_date").attr("max",ids.amc_end_dates);
            
           
    //         $('#span_amc_details').html("AMC Ref No : "+ids.amc_ref_no+" , Customer : "+ids.customer_name+" - "+ids.customer_code);
    //     }
    // } );
    
    $('#list_of_amc tbody').on('click', 'tr', function () {

    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        clear_hidden_values();
        return;
    }

    var $row = $(this);
    var ids = list_of_amc.row($row).data();
    list_of_amc.$('tr.selected').removeClass('selected');
    $row.addClass('selected');
    // Check AMC Status
    if (ids.amc_status && ids.amc_status.toLowerCase() == "completed") {

        swal({
            title: "Warning",
            text: "The selected AMC is Completed.",
            type: "warning",
            confirmButtonText: "OK"
        });

        $row.removeClass('selected');
        clear_hidden_values();
        return false;
    }

    // Check AMC Expiry Date
    var today = new Date();
    today.setHours(0,0,0,0);

    var amcEndDate = new Date(ids.amc_end_dates);
    amcEndDate.setHours(0,0,0,0);

    if (amcEndDate < today) {

        swal({
            title: "Warning",
            text: "Unable to create the work order. The selected AMC has expired.",
            type: "warning",
            confirmButtonText: "OK"
        });

        $row.removeClass('selected');
        clear_hidden_values();
        return false;
    }


    // Remove previous selection and add new selection
    list_of_amc.$('tr.selected').removeClass('selected');
    $row.addClass('selected');


    // Load AMC Details
    $('#txt_amc_id').val(ids.amc_id);
    $('#txt_amc_ref_no').val(ids.amc_ref_no);
    $('#txt_hidden_ticket_customer_code').val(ids.customer_code);
    $('#txt_hidden_ticket_customer_name').val(ids.customer_name);

    $("#txt_from_date").val(ids.amc_start_dates);
    $("#txt_hiddem_amc_st_date").val(ids.amc_start_dates);

    $("#txt_to_date").val(ids.amc_end_dates);
    $("#txt_hiddem_amc_ed_date").val(ids.amc_end_dates);

    $("#txt_from_date").attr("min", ids.amc_start_dates);
    $("#txt_from_date").attr("max", ids.amc_end_dates);

    $("#txt_to_date").attr("min", ids.amc_start_dates);
    $("#txt_to_date").attr("max", ids.amc_end_dates);

    $('#span_amc_details').html(
        "AMC Ref No : " + ids.amc_ref_no +
        " , Customer : " + ids.customer_name +
        " - " + ids.customer_code
    );

});
    
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
    
     $('#tab_amc_assets').click(function(){
       if($.trim($('#txt_amc_id').val())=="") 
       {
           swal("Warning","Please select an AMC ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_amc_asset_list($.trim($('#txt_amc_id').val()));
           
       }
     });
    
     var list_of_amc_assets = $('#list_of_amc_assets').DataTable();
    
    
       function load_data_to_grid_amc_asset_list(amc_id)
                 {
                    
                    list_of_amc_assets.destroy();
                         
                     list_of_amc_assets = $('#list_of_amc_assets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_schedule/amc_schedule_controller.php',
                                 'data': {
                                    action: 'amc_child_list',amc_id:amc_id
                                    
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
                                 { "data": "asset_ref_no" },
								 { "data": "category_name"},
								 { "data": "asset_type_name"}
								 
                                 
                       
                             ],
                             pageLength: 25,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3] }, 
            					
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
                 
                 
    $('#list_of_amc_assets tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_amc_assets.row($row).data();
           
        }
    } ); 
                 
         
         
          //AMC SCHEDULE VISITS
    $('#tab_schedule_list').click(function(){
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
      $('#btn_cancel_all_workorders').click(function(){
           swal({                                      
							title: "Are you sure to cancel all scheduled work orders?",
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
						
						        $.post("../controller/amc_schedule/amc_schedule_controller.php",{action:'cancel_all_visit',amc_ref_nos:$.trim($('#txt_amc_ref_no').val())}
                                   , function(result,status)
                                     {
                                      
                                            result = $.trim(result);
                                            
                                            if(status=='success')
                                                {
                                                    
                                                    swal("Success", "Successfully cancelled all the schedules...", "success");
                                                    
                                                    load_data_to_grid_amc_schedules_list($.trim($('#txt_amc_ref_no').val()));
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
      });
     
    
    var v_btn_amc_generate_schedule = $('#btn_generate_schedule').ladda();
    var v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable({"destroy": true}); 
    
      
    
    function load_data_to_grid_amc_schedules_list(amc_ref_nos)
    {
     
      v_amc_schedules_list_table.destroy();
            
       v_amc_schedules_list_table = $('#list_of_amc_schedules').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc_schedule/amc_schedule_controller.php',
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
                   
                   
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="amc_cancel_schedule"><i class="icon-quill4"></i> Cancel Schedule</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 25,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,3,4,5,6,7] },
                   { "width": "5%", "targets": 0 },
                   { "width": "5%", "targets": 7 },
                   { "width": "15%", "targets": 2 }
                   
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


    $('#list_of_amc_schedules tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_schedules_list_table.row($row).data();
        var v_amc_visit_id  = data.amc_visit_id;
        var v_amc_ref_no  = data.amc_ref_no;
       
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
    
    v_btn_amc_generate_schedule.click(function(){ 
       var amc_id = $("#txt_amc_id").val();
       var amc_ref_no = $("#txt_amc_ref_no").val();
       
       var frequency_array=$("#select_visit_frequency").val();
       var start_date = dateconvert($("#txt_from_date").val());
       var amc_start_date = $("#txt_hiddem_amc_st_date").val();
       var end_date =dateconvert($("#txt_to_date").val());
        var amc_end_date = $("#txt_hiddem_amc_ed_date").val();
       var start_slot=$("#select_slots_multiple_extended").val();
       var add_slot=$("#duration_multiple").val();
       var schedule_time=$("#txt_time_multiple").val();
       
       
       var asset_table_selected_count = list_of_amc_assets.rows('.selected').data().length;
		
	
    
    if($("#txt_from_date").val()>amc_end_date || $("#txt_from_date").val()<amc_start_date)
    {
         swal("Warning","Invalid start date....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
    }
    if($("#txt_to_date").val()>amc_end_date || $("#txt_to_date").val()<amc_start_date)
    {
         swal("Warning","Invalid end date....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
    }
        if($.trim(asset_table_selected_count)==0)
       {
           swal("Warning","Please select the AMC assets to schedule ....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
       }				
       if($.trim(amc_id)==""||$.trim(amc_ref_no)=="")
       {
           swal("Warning","Please select the AMC details ....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
       }
       if(frequency_array=="")
       {
           swal("Warning","Please select Frequency of Visits ....", "warning");
           v_btn_amc_generate_schedule.ladda( 'stop' );
           return false;
       }
       var t=parseInt(start_slot)+parseInt(add_slot);
    
              if(t>24)
              {
                   swal("Warning", "Sorry! the slots schedule exceeds the slots available for the day...", "warning");
                   v_btn_amc_generate_schedule.ladda( 'stop' );
                  return false;
              }
       else
       {         
     
         var assetsTableSelectedValues = $.map(list_of_amc_assets.rows('.selected').data(), function (item) {
			return item;
		}); 
        
        var amc_childarray = [];
         var amc_assetarray = [];
        for(x=0;x<=asset_table_selected_count-1;x++)
				{
				    
				     amc_childarray.push(assetsTableSelectedValues[x].amc_child_id);
				      amc_assetarray.push(assetsTableSelectedValues[x].asset_ref_no);
				}
				  swal({                                      
        							title: "Are you sure to proceed with AMC Scheduling?",
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
        						
        						         $.post("../view/amc_schedule/amc_generate_dates_new.php",{action:'schedule_visits',amc_id:amc_id,amc_ref_no:amc_ref_no,frequency_array:frequency_array,start_date:start_date,end_date:end_date,schedule_time:schedule_time,amc_childarray:amc_childarray,asset_table_selected_count:asset_table_selected_count,amc_assetarray:amc_assetarray,start_slot:start_slot,add_slot:add_slot}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                       if(result.charAt(0)=='S')
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                               swal("Success", "Visits scheduled successfully..", "success");
                            
                               $('#select_visit_frequency').val(null).trigger('change');
                              // load_data_to_grid_amc_schedules_list(amc_id);
                           }
                       else 
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                                swal("Error", "Sorry! Could not schedule the visits..", "error");
                                return false;
                                
                           }
           });
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
     
   
       }
   });  
   
    //AMC VISIT SCHEDULE CLOSE
         
         
         
         
} );