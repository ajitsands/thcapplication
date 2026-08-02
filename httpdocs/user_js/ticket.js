$(document).ready(function() {
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
    
    
    console.log('Loaded..!');
    var list_of_customer = $('#list_of_customer').DataTable();
   
    clear_hidden_values();
    var customer_caption="";
    var location_caption="";
    var building_caption="";
    var asset_caption="";
    var asset_addr="";
    $('#txt_hidden_ticket_ref_val').val(0);
     $('#txt_hidden_ticket_ref_code').val('');
     $('#span_ticketref_code').html('');
     $('#span_workorder_code').html('');
     
    function clear_hidden_values()
    {
        $('#txt_customer_id').val('');
        $('#txt_hidden_ticket_customer_id').val('');
        $('#txt_hidden_ticket_customer_code').val('');
        $('#txt_hidden_ticket_customer_name').val('');
        $('#txt_hidden_ticket_customer_contact_no').val('');
        $('#txt_hidden_ticket_customer_location_id').val('');
        $('#txt_hidden_ticket_customer_location_code').val('');
        $('#txt_hidden_ticket_customer_location_name').val('');
        $('#txt_hidden_ticket_customer_building_id').val('');
        $('#txt_hidden_ticket_customer_building_code').val('');
        $('#txt_hidden_ticket_customer_building_name').val('');
        $('#txt_hidden_ticket_customer_asset_id').val('');
        $('#txt_hidden_ticket_customer_asset_name').val('');
        $('#txt_hidden_ticket_customer_asset_category_id').val('');
        $('#txt_hidden_ticket_customer_asset_category_name').val('');
        $('#txt_hidden_ticket_customer_asset_type_id').val('');
        $('#txt_hidden_ticket_customer_asset_type_name').val('');
        $('#txt_hidden_ticket_customer_asset_zone').val('');
        $('#txt_hidden_ticket_customer_asset_flat').val('');
        $('#txt_hidden_ticket_customer_asset_room').val('');
         $('#span_customer_details').html('');
         $('#span_location_details').html('');
         $('#span_building_details').html('');
          $('#span_asset_details').html('');
        customer_caption=="";
        location_caption="";
        building_caption="";
        asset_caption="";
        asset_addr="";
        $('#txt_hidden_ticket_ref_val').val(0);
         $('#txt_hidden_ticket_ref_code').val('');
         $('#span_ticketref_code').html('');
         $('#span_workorder_code').html('');
    }
    
    function clear_location_hidden_values()
    {
        $('#txt_hidden_ticket_customer_location_id').val('');
        $('#txt_hidden_ticket_customer_location_code').val('');
        $('#txt_hidden_ticket_customer_location_name').val('');
        location_caption="";
        $('#span_location_details').html('');
        $('#txt_hidden_ticket_ref_val').val(0);
         $('#txt_hidden_ticket_ref_code').val('');
         $('#span_ticketref_code').html('');
         $('#span_workorder_code').html('');
    }
    
    function clear_building_hidden_values()
    {
        $('#txt_hidden_ticket_customer_building_id').val('');
        $('#txt_hidden_ticket_customer_building_code').val('');
        $('#txt_hidden_ticket_customer_building_name').val('');
        building_caption="";
        $('#span_building_details').html('');
        $('#txt_hidden_ticket_ref_val').val(0);
         $('#txt_hidden_ticket_ref_code').val('');
         $('#span_ticketref_code').html('');
         $('#span_workorder_code').html('');
    }
    
    function clear_asset_hidden_values()
    {
        $('#txt_hidden_ticket_customer_asset_id').val('');
        $('#txt_hidden_ticket_customer_asset_name').val('');
        $('#txt_hidden_ticket_customer_asset_category_id').val('');
        $('#txt_hidden_ticket_customer_asset_category_name').val('');
        $('#txt_hidden_ticket_customer_asset_type_id').val('');
        $('#txt_hidden_ticket_customer_asset_type_name').val('');
        $('#txt_hidden_ticket_customer_asset_zone').val('');
        $('#txt_hidden_ticket_customer_asset_flat').val('');
        $('#txt_hidden_ticket_customer_asset_room').val('');
        
        asset_caption="";
        asset_addr="";
        $('#span_asset_details').html('');
    }
   
    
    $('#list_of_customer tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_hidden_values();
        }
        else {
            list_of_customer.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_customer.row($row).data();
            $('#txt_customer_id').val(ids.customer_id);
            $('#txt_hidden_ticket_customer_id').val(ids.customer_id);
            $('#txt_hidden_ticket_customer_code').val(ids.customer_code);
            $('#txt_hidden_ticket_customer_name').val(ids.customer_name);
            $('#txt_hidden_ticket_customer_contact_no').val(ids.customer_contact_no);
            customer_caption="Customer : "+ids.customer_code+" "+ids.customer_name;
            $('#span_customer_details').html(customer_caption);
            clear_location_hidden_values();
            clear_building_hidden_values();
            clear_asset_hidden_values();
            
            $("#txt_hidden_contact_person_name").val(ids.customer_contact_person_name);
            $("#txt_hidden_contact_person_no").val(ids.customer_contact_person_no);
        }
    } );
    
    
     $('#tab_location').click(function(){
       if($.trim($('#txt_hidden_ticket_customer_id').val())=="") 
       {
           swal("Warning","Please select a customer ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_location_list();
           load_data_to_grid_building_list();
           load_data_to_grid_customer_building_list();
           
       }
     });
     
     var list_of_customer_building = $('#list_ofticket_customer_building').DataTable();
    
    
       function load_data_to_grid_customer_building_list()
                 {
                    
                    list_of_customer_building.destroy();
                    var customer_id_val=$('#txt_hidden_ticket_customer_id').val();
                        
                     list_of_customer_building = $('#list_ofticket_customer_building').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_customer_building',customer_id:customer_id_val
                                    
                                 },
								  beforeSend: function () {
									$("#list_ofticket_customer_building").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#list_ofticket_customer_building").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#list_ofticket_customer_building").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
                                { "data": null},
                                 { "data": "location_id",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status=rows["location_name"];
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "building_id",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status=rows["building_name"];
                                     	return str_active_status;
            
            							 },
                                 },
                                  { "data": "contact_person_name",
                                      render: function ( data, type, rows, meta ) {
                                         str_active_status=rows["contact_person_name"]+' ( '+rows["contact_person_no"]+' )';
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "building_address" },
								
                                 { "data": "customer_location_status",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='Active')
                                          {
                                          str_active_status='<span class="badge badge-success">'+data+'</span>'
                                          }
                                         
                                          else
                                          {
                                          str_active_status='<span class="badge badge-danger">'+data+'</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5] }, 
            					
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
                 
    $('#list_ofticket_customer_building tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_location_hidden_values();
             clear_building_hidden_values();
            
            clear_asset_hidden_values();
			$("#btn_view_work_order_building").prop("disabled", true);
        }
        else {
            list_of_customer_building.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $("#btn_view_work_order_building").prop("disabled", false);
            var $row = $(this).closest('tr');
            var loc = list_of_customer_building.row($row).data();
            $('#txt_hidden_ticket_customer_location_id').val(loc.location_id);
            $('#txt_hidden_ticket_customer_location_code').val(loc.location_code);
            $('#txt_hidden_ticket_customer_location_name').val(loc.location_name);
            location_caption=" Location : "+loc.location_code+" "+loc.location_name;
            $('#span_location_details').html(location_caption);
            
             $('#txt_hidden_ticket_customer_building_id').val(loc.building_id);
            $('#txt_hidden_ticket_customer_building_code').val(loc.building_code);
            $('#txt_hidden_ticket_customer_building_name').val(loc.building_name);
            building_caption=" Building : "+loc.building_code+" "+loc.building_name;
            $('#span_building_details').html(building_caption);
            clear_asset_hidden_values();
            
             
        }
    } );
    
     var list_of_location = $('#tbl_of_location').DataTable();
    
    
       function load_data_to_grid_location_list()
                 {
                    
                    list_of_location.destroy();
                         
                     list_of_location = $('#tbl_of_location').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_location'
                                    
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
                                
                                
                                 { "data": "location_code" },
								 { "data": "location_name"}
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 0,1] }, 
            					
            				// ],
                            
            				
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
                 
     var list_of_building = $('#tbl_of_building').DataTable();
    
     function load_data_to_grid_building_list()
                 {
                     
                    list_of_building.destroy();
                         
                     list_of_building = $('#tbl_of_building').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_building'
                                    
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
                                
                                 
                                 { "data": "building_code" },
								 { "data": "building_name"},
								  { "data": "building_address"}
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 0,1,2] }, 
            					
            				// ],
                            
            				
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
    

    
      $('#tbl_of_location tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_location_hidden_values();
            clear_asset_hidden_values();
            clear_building_hidden_values();
        }
        else {
            list_of_location.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var loc = list_of_location.row($row).data();
            $('#txt_hidden_ticket_customer_location_id').val(loc.location_id);
            $('#txt_hidden_ticket_customer_location_code').val(loc.location_code);
            $('#txt_hidden_ticket_customer_location_name').val(loc.location_name);
            location_caption=" Location : "+loc.location_code+" "+loc.location_name;
            $('#span_location_details').html(location_caption);
            clear_building_hidden_values();
            clear_asset_hidden_values();
        }
    } );
    
    $('#tbl_of_building tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_building_hidden_values();
            clear_asset_hidden_values();
             
        }
        else {
            list_of_building.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var build = list_of_building.row($row).data();
            $('#txt_hidden_ticket_customer_building_id').val(build.building_id);
            $('#txt_hidden_ticket_customer_building_code').val(build.building_code);
            $('#txt_hidden_ticket_customer_building_name').val(build.building_name);
            building_caption=" Building : "+build.building_code+" "+build.building_name;
            $('#span_building_details').html(building_caption);
            clear_asset_hidden_values();
        }
    } );
    
    
     $('#tab_assets').click(function(){
       if($.trim($('#txt_hidden_ticket_customer_id').val())=="") 
       {
           swal("Warning","Please select a customer ....", "warning");
            return false;
       }
       else if ($.trim($('#txt_hidden_ticket_customer_location_id').val())=="")
       {
            swal("Warning","Please select a customer building ....", "warning");
            return false;
       }
        else if ($.trim($('#txt_hidden_ticket_customer_building_id').val())=="")
       {
            swal("Warning","Please select a customer building ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_asset_list($.trim($('#txt_hidden_ticket_customer_id').val()),$.trim($('#txt_hidden_ticket_customer_location_id').val()),$.trim($('#txt_hidden_ticket_customer_building_id').val()));
          
       }
     }); 
    
    
    var list_of_assets = $('#tbl_of_assets').DataTable();
    
     function load_data_to_grid_asset_list(cust_ids,loc_ids,build_ids)
                 {
                     
                    list_of_assets.destroy();
                         
                     list_of_assets = $('#tbl_of_assets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_assets',customer_id:cust_ids,location_id:loc_ids,building_id:build_ids
                                    
                                 },
								  beforeSend: function () { 
									$("#tbl_of_assets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_of_assets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_of_assets").LoadingOverlay("hide");
                                   },    
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
                                 { "data": "asset_category_name" },
								 { "data": "asset_type_name"},
								 { "data": "asset_ref_no"},
								 { "data": "zone_floor"},
								 { "data": "flat_area_code"},
								 { "data": "room_no"}
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6] }, 
            					
            				// ],
                            
            				
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
    
                 $('#tbl_of_assets tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = list_of_assets.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_assets(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_assets(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Brand </div></td>'+
							'<td ><div align="center">Serial No </div></td>'+
            				'<td ><div align="center">Capacity </div></td>'+
            				'<td ><div align="center">Cost </div></td>'+
            				'<td ><div align="center">Warrant/Guarantee </div></td>'+
            				'<td ><div align="center">W/G End Date</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.asset_brand+'</div></td>'+
							'<td><div align="center">'+d.asset_serial_no+'</div></td>'+
            				'<td><div align="center">'+d.asset_capacity+' </div></td>'+
            			    '<td><div align="center">'+d.asset_cost+' </div></td>'+
            				'<td><div align="center">'+d.is_warentee+' </div></td>'+
            				'<td><div align="center">'+d.warentee_end_date+'</div></td>'+
            				
            				
            			  '</tr>'+
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Area Description </div></td>'+
							'<td ><div align="center">Asset Description </div></td>'+
            			
            			  '</tr>'+
            			   '<tr>'+
            				
            				'<td><div align="center">'+d.asset_sp_des+'</div></td>'+
							'<td><div align="center">'+d.asset_description+'</div></td>'+
            				
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
	            }
    
      $('#tbl_of_assets tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_asset_hidden_values();
			$("#btn_view_work_order_asset").prop("disabled", true);
        }
        else {
            list_of_assets.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $("#btn_view_work_order_asset").prop("disabled", false);
            var $row = $(this).closest('tr');
            var assets = list_of_assets.row($row).data();
            console.log(assets.asset_category_name);
            $('#txt_hidden_ticket_customer_asset_id').val(assets.asset_id);
            $('#txt_hidden_ticket_customer_asset_name').val(assets.asset_ref_no);
            $('#txt_hidden_ticket_customer_asset_category_id').val(assets.asset_category_id);
            $('#txt_hidden_ticket_customer_asset_category_name').val(assets.asset_category_name);
            $('#txt_hidden_ticket_customer_asset_type_id').val(assets.asset_type_id);
            $('#txt_hidden_ticket_customer_asset_type_name').val(assets.asset_type_name);
            $('#txt_hidden_ticket_customer_asset_zone').val(assets.zone_floor);
            $('#txt_hidden_ticket_customer_asset_flat').val(assets.flat_area_code);
            $('#txt_hidden_ticket_customer_asset_room').val(assets.room_no);
            asset_caption=" Asset : "+assets.asset_ref_no;
            $('#span_asset_details').html(asset_caption);
        }
    } );
    
     $('#tab_book_complaints').click(function(){
        
         asset_addr="";
       if($.trim($('#txt_hidden_ticket_customer_id').val())=="") 
       {
           swal("Warning","Please select a customer ....", "warning");
            return false;
       }
       else if ($.trim($('#txt_hidden_ticket_customer_location_id').val())=="")
       {
            swal("Warning","Please select a customer building ....", "warning");
            return false;
       }
        else if ($.trim($('#txt_hidden_ticket_customer_building_id').val())=="")
       {
            swal("Warning","Please select a customer building ....", "warning");
            return false;
       }
       else
       {
          
           if($.trim($('#txt_hidden_ticket_customer_asset_zone').val())!='')
           {
               asset_addr=asset_addr+' Zone/Floor : '+$.trim($('#txt_hidden_ticket_customer_asset_zone').val())+',';
           }
           if($.trim($('#txt_hidden_ticket_customer_asset_flat').val())!='')
           {
               asset_addr=asset_addr+' Flat : '+$.trim($('#txt_hidden_ticket_customer_asset_flat').val())+',';
           }
           if($.trim($('#txt_hidden_ticket_customer_asset_room').val())!='')
           {
               asset_addr=asset_addr+' Room : '+$.trim($('#txt_hidden_ticket_customer_asset_room').val());
           }
          
           $('#txt_additional_info').val(asset_addr);
          
          if($.trim($('#txt_hidden_ticket_customer_asset_category_name').val())!='')
           {
               $('#div_category_text').hide();
               $('#div_category_select').show();
                load_category_combo($.trim($('#txt_hidden_ticket_customer_asset_category_id').val()));
              // $('#div_category_text').show();
           
            //  $('#txt_category').val($.trim($('#txt_hidden_ticket_customer_asset_category_name').val()));
               
           }
           else
           {
                $('#div_category_text').hide();
                $('#div_category_select').show();
                load_category_combo('select');
           }
          if($.trim($('#txt_hidden_ticket_customer_asset_type_name').val())!='')
           {
               $('#div_asset_type_combo').show();
               $('#div_type_text').hide();
               load_type_combo($.trim($('#txt_hidden_ticket_customer_asset_type_id').val()));
              // $('#txt_type').val($.trim($('#txt_hidden_ticket_customer_asset_type_name').val()));
               load_data_to_grid_services_list($.trim($('#txt_hidden_ticket_customer_asset_category_id').val()),$.trim($('#txt_hidden_ticket_customer_asset_type_id').val()));
           }
           else
           {
                $('#div_type_text').hide();
                $('#div_asset_type_combo').show();
                 load_type_combo('select');
           }
       }
     }); 
    
     $('#div_quote_ref').hide();
    $('input[type=radio][name=radio-quote]').change(function() {
    if (this.value == 'No') {
        $('#div_quote_ref').hide();
        $('#txt_quote_date').val('');
        
    }
    else
    {
       $('#div_quote_ref').show();
        
    }
   
    });
    
    function load_category_combo(sel_ids)
     {
      
         $.ajax({
		type: "POST",
		url: "tickets/asset_category.php",
			data: { sel_ids:sel_ids } 
		 }).done(function(data){
		     
			
			$("#div_category_select").html(data);
			$("#select_category").select2();
		    
		 });
     }
     $('#div_category_select').on('change', '.classcategory', function(){
         
         $('#txt_hidden_ticket_customer_asset_category_id').val($("#select_category option:selected").val());
         $('#txt_hidden_ticket_customer_asset_category_name').val($("#select_category option:selected").text());
         load_type_combo('select');
    });
 
    function load_type_combo(sel_type_ids)
     {
         
         var category_id=$.trim($('#txt_hidden_ticket_customer_asset_category_id').val());
       
         $.ajax({
		type: "POST",
		url: "tickets/assets_type_combo.php",
		data: { category_id:category_id,sel_type_ids:sel_type_ids} 
		 }).done(function(data){
		     
			$("#div_asset_type_combo").html(data);
			$("#select_asset_type").select2();
		 });
     }


    $('#div_asset_type_combo').on('change', '.classtype', function(){
        $('#txt_hidden_ticket_customer_asset_type_id').val($("#select_asset_type option:selected").val());
        $('#txt_hidden_ticket_customer_asset_type_name').val($("#select_asset_type option:selected").text());
        load_data_to_grid_services_list($("#txt_hidden_ticket_customer_asset_category_id").val(),$("#select_asset_type option:selected").val());
    });
    

    var list_of_services = $('#tbl_ticket_services').DataTable({
                            "Paginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				 "searching": false,
            				 "bInfo": false,
            				"autoWidth": false,
        
    });
    
     function load_data_to_grid_services_list(cate_ids,type_ids)
                 {
                    
                    list_of_services.destroy();
                         
                     list_of_services = $('#tbl_ticket_services').DataTable( {
                           
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
                           
            				"Paginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                               
                                 { "data": "service_description" }
                       
                             ],
                           //  pageLength: 10,
            				 searching: false,
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
    
    
    $('#tbl_ticket_services tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_services.row($row).data();
           
        }
    } ); 
    
    var v_session_image;
     $('#session_image').change(function (e) {
                         
            v_session_image = $("#session_image").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image==="")
            {
                v_session_image="default.jpg";
                 $('#hidden_image_show').val(v_session_image);
            }
            else
            {
                var doc_file_obj = $("#session_image")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                v_session_image=$.trim(randomNum+'_'+doc_file1);
                 $('#hidden_image_show').val(v_session_image);
                
            }     
      });
      var v_session_image2;
     $('#session_image2').change(function (e) {
                         
            v_session_image2 = $("#session_image2").val();
          
            randomNum2 = Math.ceil(Math.random() * 999999);
                if(v_session_image2==="")
            {
                v_session_image2="default.jpg";
                 $('#hidden_image_show2').val(v_session_image2);
            }
            else
            {
                var doc_file_obj2 = $("#session_image2")[0].files[0];
                var upload2 = new ns.Upload(doc_file_obj2);
                doc_file2= doc_file_obj2.name;
                upload2.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum2);
                v_session_image2=$.trim(randomNum2+'_'+doc_file2);
                 $('#hidden_image_show2').val(v_session_image2);
                
            }     
      });
    
    var v_btn_book_ticket = $('#btn_book_ticket').ladda(); 
    
    $("#btn_book_ticket").click(function(){
        
		v_btn_book_ticket.ladda( 'start' );
		
		
		var ticket_ref_val=$('#txt_hidden_ticket_ref_val').val();
		var ticket_ref_code=$('#txt_hidden_ticket_ref_code').val();
		var customer_id=$('#txt_hidden_ticket_customer_id').val();
		var customer_code=$('#txt_hidden_ticket_customer_code').val();
		var customer_name=$('#txt_hidden_ticket_customer_name').val();
		var customer_contact_no=$('#txt_hidden_ticket_customer_contact_no').val();
	    var location_id=$('#txt_hidden_ticket_customer_location_id').val();
		var location_code=$('#txt_hidden_ticket_customer_location_code').val();
		var location_name=$('#txt_hidden_ticket_customer_location_name').val();	
		var building_id=$('#txt_hidden_ticket_customer_building_id').val();
		var building_code=$('#txt_hidden_ticket_customer_building_code').val();
		var building_name=$('#txt_hidden_ticket_customer_building_name').val();
		var asset_id=$('#txt_hidden_ticket_customer_asset_id').val();
		var asset_code=$('#txt_hidden_ticket_customer_asset_name').val();
		var category_id=$('#txt_hidden_ticket_customer_asset_category_id').val();
		var category_name=$('#txt_hidden_ticket_customer_asset_category_name').val();
		var type_id=$('#txt_hidden_ticket_customer_asset_type_id').val();
		var type_name=$('#txt_hidden_ticket_customer_asset_type_name').val();
		var additional_info=$('#txt_additional_info').val();
		var priority_val = $("input[name='radio-styled-color']:checked").val();
		var quote_val = $("input[name='radio-quote']:checked").val();
	    var service_request = $("input[name='radio_service_request']:checked").val();
		var job_category = $("input[name='radio_job_category']:checked").val();
		var quote_date = $('#txt_quote_date').val();
		var quote_ref_no = $('#txt_quote_ref').val();
		var date_needed = $('#txt_ticket_book_date_needed').val();
		//var date_scheduled = $('#txt_ticket_book_visit_date').val();
       // var complaint_description=$(".summernote-height").summernote('code');
        var complaint_description=$("#txt_complaints").val();

		var service_table_selected_count = list_of_services.rows('.selected').data().length;
		
		  var ServiceTableSelectedValues = $.map(list_of_services.rows('.selected').data(), function (item) {
			return item;
		}); 

        var serviceidarray = [];
        var servicedesarray = [];
       
        for(x=0;x<=service_table_selected_count-1;x++)
				{
				    
				     serviceidarray.push(ServiceTableSelectedValues[x].service_id);
				     servicedesarray.push(ServiceTableSelectedValues[x].service_description);
				
				}
				
				if($.trim(category_id)=="select"||$.trim(type_id)=="select" || $.trim(category_id)==""||$.trim(type_id)=="")
                                
                                {
                                    swal("Warning","Please select category and type...", "warning");
                                    v_btn_book_ticket.ladda( 'stop' );
                                    return false;
                                }
                else if(service_table_selected_count==""||service_table_selected_count==0)
                {
                     swal("Warning","Please select services...", "warning");
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
                        if(asset_id=="")
        				{
        				    asset_id=0;
        				    asset_code=0;
        				}
                        //  v_session_image = $("#session_image").val();
                      
                        //     randomNum = Math.ceil(Math.random() * 999999);
                        //     if(v_session_image==="")
                        // {
                        //     v_session_image="default.jpg";
                        // }
                        // else
                        // {
                        //     var doc_file_obj = $("#session_image")[0].files[0];
                        //     var upload = new ns.Upload(doc_file_obj);
                        //     doc_file1= doc_file_obj.name;
                        //     upload.doUpload("../httpdocs/user_upload/ticket_book_image_upload.php?random_no="+randomNum);
                        //     v_session_image=$.trim(randomNum+'_'+doc_file1);
                        //      $('#hidden_image_show').val(v_session_image);
                            
                        // }     
                         var v_session_image1=$('#hidden_image_show').val();
                         var v_session_image2=$('#hidden_image_show2').val();
    		        $.post("../controller/ticket/ticket_controller.php",{action:'book_complaint',customer_id:customer_id,customer_code:customer_code,customer_name:customer_name,location_id:location_id,location_code:location_code,location_name:location_name,building_id:building_id,building_code:building_code,building_name:building_name,asset_id:asset_id,asset_code:asset_code,category_id:category_id,category_name:category_name,type_id:type_id,type_name:type_name,additional_info:additional_info,priority_val:priority_val,quote_val:quote_val,complaint_description:complaint_description,service_table_selected_count:service_table_selected_count,serviceidarray:serviceidarray,servicedesarray:servicedesarray,ticket_ref_val:ticket_ref_val,ticket_ref_code:ticket_ref_code,service_request:service_request,job_category:job_category,quote_date:quote_date,date_needed:date_needed,v_session_image:v_session_image1,quote_ref_no:quote_ref_no,v_session_image2:v_session_image2,customer_contact_no:customer_contact_no}
                       , function(result,status)
                        {
            		
            				if(status=='success')
            			{
            			
            				    var res = $.trim(result).split("@");
            				    $('#txt_hidden_ticket_ref_val').val(res[0]);
            				    $('#txt_hidden_ticket_ref_code').val(res[1]);
            				    $('#span_ticketref_code').html('Ticket Ref No : '+res[1]);
            				    $('#span_workorder_code').html('Work Order No : WO-'+res[1]+'-'+res[2]);
            					v_btn_book_ticket.ladda( 'stop' );
            					swal("Success", "Complaint booked successfully..", "success");
            					clear_asset_hidden_values();
            					load_category_combo('select');
            					load_type_combo('select');
            					load_data_to_grid_services_list($("#txt_hidden_ticket_customer_asset_category_id").val(),$("#select_asset_type option:selected").val());
            				    $('#txt_additional_info').val('');
            				    $('#txt_complaints').val('');
            				    // $('.summernote-height'). summernote('code', '')
            				   
            			}
        				else
        				{
        					v_btn_book_ticket.ladda( 'stop' );
        					swal("Error", result, "error");
        				}
    		
    		    	});
            }
	}); 
	
	$("#btn_remove_ticket_image").click(function(){
	    
	    $('#session_image').val('');
        $("#hidden_image_show").val('default.jpg');
        v_session_image="";
	});
	$("#hidden_image_show").val('default.jpg');
	$("#i_image").click(function(){
	    var img_to_load=$("#hidden_image_show").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
	
	$("#btn_remove_ticket_image2").click(function(){
	    
	    $('#session_image2').val('');
        $("#hidden_image_show2").val('default.jpg');
        v_session_image2="";
	});
	$("#hidden_image_show2").val('default.jpg');
	$("#i_image2").click(function(){
	    var img_to_load=$("#hidden_image_show2").val();
	    var filePath='http://thc.sianlab.com/httpdocs/images/ticket_book_image/';
	    window.open(filePath + img_to_load );
	});
    var v_btn_new_ticket = $('#btn_new_ticket').ladda(); 
    
    $("#btn_new_ticket").click(function(){
        
		v_btn_new_ticket.ladda( 'start' );
		location.reload();
		v_btn_new_ticket.ladda( 'stop' );
    });
    
     var v_btn_location_add = $( '#btn_location_add' ).ladda();
    
      $('#txt_location_code').keydown(function (e) {
           var k = e.which;
            var ok = k >= 65 && k <= 90 || // A-Z
                k >= 96 && k <= 105 || // a-z
                k >= 35 && k <= 40 || // arrows
                k == 8 || // Backspaces
                k == 9 ||//Tab
                k >= 48 && k <= 57; // 0-9
    
            if (!ok){
                e.preventDefault();
            }        
        });
                    
         $('#txt_location_code').change(function (e) {
            var v_location_code_test=$("#txt_location_code").val();
             $.post("../controller/location/location_controller.php",{action:'check_location_code',v_location_code:v_location_code_test }
                    , function(result,status)
                    {
                       
                  
                   
                    if(result==1)
                    {
                        v_btn_location_add.ladda( 'stop' );
                         swal("Warning", "Location code already exists..", "warning");
                       $("#txt_location_code").val('');
                    }
                    else 
                    {
                        return true;
                    }
                    
                     
                
            });
            
        });
                    
                    
            
 
     v_btn_location_add.click(function(){
                    
        v_btn_location_add.ladda( 'start' );
        var v_location_name=$("#txt_location_name").val();
         var v_location_code=$("#txt_location_code").val();
            
            if($.trim(v_location_name)===""||$.trim(v_location_code)==="")
            
            {
                swal("Warning","Please provide location details ....", "warning");
                v_btn_location_add.ladda( 'stop' );
                return false;
            }
           
            else
            {         
                 $.post("../controller/location/location_controller.php",{action:'add_location',location_name:v_location_name,v_location_code:v_location_code }
                        , function(result,status)
                        {
                           result = $.trim(result);
                               
                                if(result.charAt(0)=='L')
                                {
                                    v_btn_location_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                    v_btn_location_add.ladda( 'stop' );
                                     swal("Success", "New location added successfully..", "success");
                                     
                                    clear_location_hidden_values();
                                    load_data_to_grid_location_list();
                                    $("#txt_location_name").val('');
                                     $("#txt_location_code").val('');
                                }
                      
                        
                         
                    
                });
                
               
                
             }
                  
    });
            
      	$("#txt_building_code").blur(function(){
							
							var v_building_code=$("#txt_building_code").val();
							
							 $.post("../controller/building/building_controller.php",{action:'check_building_code',v_building_code:v_building_code}
									, function(result,status)
							 { 
								var obj = jQuery.parseJSON(result);
								 if(obj.length==0)
								{
									return true;
								}
								else
								{
									
									swal("Warning","Building code already exists", "warning");
									$("#txt_building_code").val('');
									return false;
								}

							 });
							
						});
					var v_btn_building_add = $('#btn_building_add').ladda();
                    v_btn_building_add.click(function(){
                                v_btn_building_add.ladda( 'start' );
								v_building_name=$("#txt_building_name").val();
								//v_building_code=$("#txt_building_code").val();
								v_building_address=$("#txt_building_address").val();
                                 v_building_address='NA';
                                if($.trim(v_building_name)==""||$.trim(v_building_address)=="")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_building_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/building/building_controller.php",{action:'add_building',v_building_name:v_building_name,v_building_address:v_building_address}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                               
                                            if(result.charAt(0)=='B')
                                            {
                                                 v_btn_building_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                               
                                            }
                                            else 
                                            {
                                                 //start--update building code
                                                
                                                    if(result>=1 && result<=9)
                    								{
                    									 v_building_code= 'F000'+result;
                    								}
                    								if(result>=10 && result<=99)
                    								{
                    									v_building_code= 'F00'+result;
                    								}
                    								if(result>=100 && result<=999)
                    								{
                    									v_building_code= 'F0'+result;
                    								}
                    								if(result>=1000 )
                    								{
                    									v_building_code= 'F'+result;
                    								}
                    								
                    								//console.log(v_customer_code);
                    													
                    								 $.post("../controller/building/building_controller.php",{action:'update_building_code',v_building_code:v_building_code,v_building_id:result}					
                    								 , function(result,status)
                    									{ 
                    								
                    								
                                                                if(result.charAt(0)=='U')
                                                                {
                                                                    v_btn_customer_add.ladda( 'stop' );
                                                                    swal("Error", result, "error");
                                                                   
                                                                    clear_text();
                                                                   
                                
                                                                
                                                                }
                                                                else 
                                                                {
                                                                     v_btn_building_add.ladda( 'stop' );
                                                                     swal("Success", "New building added successfully..", "success");
                                                                     load_data_to_grid_building_list();
                                            						clear_building_hidden_values();
                                            						$("#txt_building_name").val("");
                                            						$("#txt_building_code").val("");
                                            						$("#txt_building_address").val("");
                                                                }
                                                                
                                                                 
                                                            
                                                          });
                                                
                                                //end
                                                
                                            }
                                            
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                
        //New Customer Creation      
        $('#error_email').hide();
         $('#btn_customer_edit').hide();
        $('#btn_customer_new').hide();            
        var v_btn_customer_add = $('#btn_customer_add').ladda();
                $("#txt_customer_email_id").on('blur', function () {
     
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_customer_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                            return true;
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid email", "warning");
                                return false;
                            }
                                                 
                    });
                 
          	$("#txt_contact_person").blur(function(){
					var v_customer_contact_no=$("#txt_contact_person").val();
					 $.post("../controller/customer/customer_controller.php",{action:'check_contact_person_number',v_customer_contact_no:v_customer_contact_no}
							, function(result,status)
					 { 
						var obj = jQuery.parseJSON(result);
						 if(obj.length==0)
						{
							return true;
						}
						else
						{
							
							swal("Warning","Customer contact number already exists", "warning");
							$("#txt_contact_person_number").val('');
							return false;
						}

					 });
					
				});
				
					$("#txt_cpr_cr_number").blur(function(){
					var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
					if(v_cpr_cr_number!="")
					{
					 $.post("../controller/customer/customer_controller.php",{action:'check_cpr_cr_number',v_cpr_cr_number:v_cpr_cr_number}
							, function(result,status)
					 { 
						var obj = jQuery.parseJSON(result);
						if(obj.length==0)
						{
							return true;
						}
						else
						{
							
							swal("Warning","CPR/CR number already exists", "warning");
							$("#txt_cpr_cr_number").val('');
							return false;
						}

					 });
					}
					 
				});
				
				 $('#txt_customer_name').blur(function() {
			  
    			  var v_customer_name=$("#txt_customer_name").val();   
                  $("#txt_contact_person").val(v_customer_name);
                  
                });
                
                $('#txt_customer_contact_no').blur(function() {
    			  
    			  var v_customer_contact_no=$("#txt_customer_contact_no").val();
                  $("#txt_contact_person_number").val(v_customer_contact_no);
                  
                });
				
				  v_btn_customer_add.click(function(){
                    v_btn_customer_add.ladda( 'start' );
					
                    var v_customer_name=$("#txt_customer_name").val();				
                    var v_customer_contact_no=$("#txt_customer_contact_no").val();
                    var v_customer_email_id=$("#txt_customer_email_id").val();
                    //var v_customer_po_box=$("#txt_customer_po_box").val();
					//var v_customer_location=$("#txt_customer_location").val();
					var v_alternate_contact_no=$("#txt_alternate_contact_no").val();
                    var v_contact_person=$("#txt_contact_person").val();
                    var v_contact_person_number=$("#txt_contact_person_number").val();
                    var v_cpr_cr_number=$("#txt_cpr_cr_number").val();
                    var v_vat_number=$("#txt_vat_number").val();					
                    var v_customer_address=$("#txt_customer_address").val();
					var v_description=$("#txt_description").val();
				
                    if($.trim(v_customer_name)==""|| v_customer_contact_no == "")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_customer_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/customer/customer_controller.php",{action:'add_customer',v_customer_name:v_customer_name,v_customer_contact_no:v_customer_contact_no,v_customer_email_id:v_customer_email_id,v_contact_person:v_contact_person,v_contact_person_number:v_contact_person_number,v_cpr_cr_number:v_cpr_cr_number,v_vat_number:v_vat_number,v_customer_address:v_customer_address,v_description:v_description,v_alternate_contact_no:v_alternate_contact_no}
                                , function(result,status)
                                {                     
                                result = $.trim(result);
                                 if(result.charAt(0)=='C')
                                   {
                                       swal("Error", result, "error");
                                       v_btn_customer_add.ladda( 'stop' );
                                       
                                       return false;
                                       if(result.charAt(1)=='P')
                                         {
                                             $('#txt_cpr_cr_number').val("");
                                         }
                                         else
                                         {
                                             $('#txt_customer_contact_no').val("");
                                         }
                                   
                                   }
                                   else
                                   {
                                     	    if(result>=1 && result<=9)
                								{
                									 v_customer_code= 'C000'+result;
                								}
                								if(result>=10 && result<=99)
                								{
                									v_customer_code= 'C00'+result;
                								}
                								if(result>=100 && result<=999)
                								{
                									v_customer_code= 'C0'+result;
                								}
                								if(result>=1000 )
                								{
                									v_customer_code= 'C'+result;
                								}
                								
                								//console.log(v_customer_code);
                													
                								 $.post("../controller/customer/customer_controller.php",{action:'update_customer_code',v_customer_code:v_customer_code,v_customer_id:result}					
                								 , function(result,status)
                									{ 
                								
                								
                                                if(result.charAt(0)=='U')
                                                {
                                                    v_btn_customer_add.ladda( 'stop' );
                                                    swal("Error", result, "error");
                                                   
                                                    clear_text();
                                                   
                
                                                
                                                }
                                                else 
                                                {
                                                     v_btn_customer_add.ladda( 'stop' );
                                                     swal("Success", "New customer added successfully..", "success");
                                                      load_data_to_grid_customer_details_list();
                                                    // location.reload();
                                                    
                                                     clear_text();
                                                }
                                                
                                                 
                                            
                                          });
                        
                                   }
							
                        });
                        
                     }
					 
				 
                  
     });
     
     
   
      load_data_to_grid_customer_details_list();
      //load data to customer grid
                 function load_data_to_grid_customer_details_list()
                 {
                    var i = 1; 
                    list_of_customer.destroy();
                         
                     list_of_customer = $('#list_of_customer').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/customer/customer_controller.php',
                                 'data': {
                                    action: 'list_customer_complaint'
                                    
                                 },
								  beforeSend: function () {
									$("#list_of_customer").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#list_of_customer").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#list_of_customer").LoadingOverlay("hide");
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
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null,
								 "render": function(data, type, full, meta) {
                                            return i++;
                                        },
								 },
                                 { "data": "customer_name" },
								 { "data": "customer_code"},
                                 { "data": "customer_contact_no"},
                                 { "data": "customer_cpr_cr_no"},
                                 { "data": "customer_email_id"},
                                 { "data": "date_active1"},
								 
                                 
                    //              { "data": "customer_status",
                    //                   render: function ( data, type, rows, meta ) {
                    //                       if(data=='Active')
                    //                       {
                    //                       str_active_status='<span class="badge badge-success">'+data+'</span>'
                    //                       }
                                         
                    //                       else
                    //                       {
                    //                       str_active_status='<span class="badge badge-danger">'+data+'</span>'   
                    //                       }
                    //                  	return str_active_status;
            
            							 //},
                    //              }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 // $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                 // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                 
                     function clear_text()
                 {

					$("#txt_customer_name").val('');
                    $("#txt_customer_cpwd").val('');
                    //$("#txt_customer_pwd").val('');
								
                    $("#txt_customer_contact_no").val('');
                    $("#txt_customer_email_id").val('');
                    $("#txt_customer_po_box").val('');
								
					$("#txt_customer_location").val('');
                    $("#txt_contact_person").val('');
                    $("#txt_contact_person_number").val('');
								
                    $("#txt_cpr_cr_number").val('');
                    $("#txt_vat_number").val('');
								
                    $("#txt_customer_address").val('');
				    $("#txt_description").val('');
    
                 }
                 
                    $('#list_of_customer tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = list_of_customer.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_customer(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
                 function format_customer(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				//'<td ><div align="center">PO Box </div></td>'+
							'<td ><div align="center">Alternate Contact Number </div></td>'+
            				'<td ><div align="center">VAT No. </div></td>'+
            				'<td ><div align="center">Contact Point </div></td>'+
            				'<td ><div align="center">Address </div></td>'+
            				'<td ><div align="center">Add. Info.</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				//'<td><div align="center">'+d.customer_po_box+'</div></td>'+
							'<td><div align="center">'+d.customer_location+'</div></td>'+
            				'<td><div align="center">'+d.customer_vat_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_contact_person_name+' - '+d.customer_contact_person_no+' </div></td>'+
            				'<td><div align="center">'+d.customer_address+'</div></td>'+
            				'<td><div align="center">'+d.customer_description+'</div></td>'+
            				
            				
            			  '</tr>'+
            			'</table>' ;
                        			
		
		
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
                    console.log('In');
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
                           
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"bSearch": false,
            				"autoWidth": false,
            				 "columns": [
                                 { "data": "employee_name" }
                             ],
            			
                           
                           pageLength: 100,
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
                 
                 
                 
//Category Add
  $("#btn_category_add").click(function(){
                    
                  
                    var v_cat_name=$("#txt_cat_name").val();
					
                  
                    if($.trim(v_cat_name)=="")
                    
                    {
                        swal("Warning","Please provide category....", "warning");
                        
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/category/category_controller.php",{action:'add_category',v_category_name:v_cat_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                   
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                   
                                     swal("Success", "New category added successfully..", "success");
                                    $("#select_category_asset_type").val(null).trigger("change");
                                   if($.trim($('#txt_hidden_ticket_customer_asset_category_name').val())!='')
                                       {
                                           $('#div_category_text').hide();
                                           $('#div_category_select').show();
                                            load_category_combo($.trim($('#txt_hidden_ticket_customer_asset_category_id').val()));
                                         
                                       }
                                       else
                                       {
                                            $('#div_category_text').hide();
                                            $('#div_category_select').show();
                                            load_category_combo('select');
                                       }
                                    $("#txt_cat_name").val('');
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                
                
                 $("#btn_asset_type_add").click(function(){
                    
                   
					var v_category_id_asset_type=$("#select_category_asset_type option:selected").val();
                    var v_category_name_asset_type=$("#select_category_asset_type option:selected").text()
                    var v_asset_type_name=$("#txt_asset_type_name").val();
					
                  
                    if($.trim(v_asset_type_name)==""||v_category_name_asset_type=="" )
                    
                    {
                        swal("Warning","Please provide all fields....", "warning");
                       
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/asset_type/asset_type_controller.php",{action:'add_asset_type',v_category_id:v_category_id_asset_type,v_category_name:v_category_name_asset_type,v_asset_name:v_asset_type_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                   
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                    
                                     swal("Success", "New asset type added successfully..", "success");
                                    
                                    $("#txt_asset_type_name").val('');
									$("#select_category_asset_type").val(null).trigger("change");
										
									
									
									 if($.trim($('#txt_hidden_ticket_customer_asset_type_name').val())!='')
                                   {
                                       $('#div_asset_type_combo').show();
                                       $('#div_type_text').hide();
                                       load_type_combo($.trim($('#txt_hidden_ticket_customer_asset_type_id').val()));
                                     
                                   }
                                   else
                                   {
                                        $('#div_type_text').hide();
                                        $('#div_asset_type_combo').show();
                                         load_type_combo('select');
                                   }
									
									
									
									
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                
                $("#btn_assign_customer_building1").click(function(){
                   
                   var contact_person_name= $("#txt_hidden_contact_person_name").val();
                   var contact_person_number= $("#txt_hidden_contact_person_no").val();
                   
                   $("#txt_contact_person_name").val(contact_person_name);
                   $("#txt_contact_person_number_build").val(contact_person_number);
                   
                    $.ajax({
                		type: "POST",
                		url: "tickets/location_combo_assign_building.php"
                		 }).done(function(data){
                		     
                			
                			$("#div_customer_location_details").html(data);
                			$("#select_location_for_customer_location").select2();
                		    
                		 });
                		 
                		  $.ajax({
                		type: "POST",
                		url: "tickets/building_combo_assign_building.php"
                		 }).done(function(data){
                		     
                			
                			$("#div_select_building").html(data);
                			$("#select_building_for_location").select2();
                		    
                		 });
                
                });
                	var v_bldng_session_image;
                	$('#building_session_image').change(function (e) {
                         
                            v_bldng_session_image = $("#building_session_image").val();
                            randomNum = Math.ceil(Math.random() * 999999);
                            if(v_bldng_session_image=="")
                            {
                                v_bldng_session_image="default.jpg";
                            }
                            else
                            {
                                var doc_file_obj = $("#building_session_image")[0].files[0];
                                var upload = new ns.Upload(doc_file_obj);
                                doc_file1= doc_file_obj.name;
                                 v_bldng_session_image=$.trim(randomNum+'_'+doc_file1);
                                var success = upload.doUpload("../httpdocs/user_upload/building_image_upload.php?random_no="+randomNum,v_bldng_session_image);
                            }  
                         });
                	
                	   $("#btn_customer_location_add").click(function(){
                               
                                
                                var v_building_id=$("#select_building_for_location option:selected").val();
                                var v_customer_id_customer_location=$("#txt_hidden_ticket_customer_id").val();
                                
		
                               var v_customer_name_customer_location=$("#txt_hidden_ticket_customer_name").val();
                                 var v_customer_name_customer_location_code=$("#txt_hidden_ticket_customer_code").val();
                                var v_location_id_customer_location=$("#select_location_for_customer_location option:selected").val();
                                var v_location_name_customer_location=$("#select_location_for_customer_location option:selected").text();
                                v_location_name_customer_location_dis=v_location_name_customer_location.split("||");
                               
                                v_location_name_customer_location=v_location_name_customer_location_dis[1];
                                v_location_name_customer_location_code=v_location_name_customer_location_dis[0];
                                
                                var v_building_select=$("#select_building_for_location option:selected").text();
                               var  v_building_select_split=v_building_select.split("||");
                               
                                v_building_name_customer_location=v_building_select_split[1];
                                v_contact_person_building_code=v_building_select_split[0];
                                
                               
                                var v_building_address_customer_location=$("#txt_Building_address").val();
                                var v_contact_person_name_customer_location=$("#txt_contact_person_name").val();
                                var v_contact_person_number_customer_location=$("#txt_contact_person_number_build").val();
                              
                                 v_bldng_session_image = $("#building_session_image").val();
                      
                                randomNum = Math.ceil(Math.random() * 999999);
                                if(v_bldng_session_image==="")
                                {
                                    v_bldng_session_image="default.jpg";
                                }
                                else
                                {
                                    var doc_file_obj = $("#building_session_image")[0].files[0];
                                    var upload = new ns.Upload(doc_file_obj);
                                    doc_file1= doc_file_obj.name;
                                    upload.doUpload("../httpdocs/user_upload/building_image_upload.php?random_no="+randomNum);
                                    v_bldng_session_image=$.trim(randomNum+'_'+doc_file1);
                                } 
                                       
                                if($.trim(v_building_id)===""||$.trim(v_location_id_customer_location)==="")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                  
                                    return false;
                                }
                                else if($.trim(v_customer_id_customer_location)==="")
                                
                                {
                                    swal("Warning","Please select customer ....", "warning");
                                  
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/customer_location/customer_location_controller.php",{action:'add_customer_location',v_customer_id_customer_location:v_customer_id_customer_location,v_customer_name_customer_location:v_customer_name_customer_location,v_location_id_customer_location:v_location_id_customer_location,v_location_name_customer_location:v_location_name_customer_location,v_building_name_customer_location:v_building_name_customer_location,v_building_address_customer_location:v_building_address_customer_location,v_contact_person_name_customer_location:v_contact_person_name_customer_location,v_contact_person_number_customer_location:v_contact_person_number_customer_location,v_contact_person_building_code:v_contact_person_building_code,v_location_name_customer_location_code:v_location_name_customer_location_code,v_customer_name_customer_location_code:v_customer_name_customer_location_code,v_building_id:v_building_id,v_building_image:v_bldng_session_image}
                                            , function(result,status)
                                            {
                                            
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                               
                                                swal("Error", result, "error");
                                                
                                            }
                                            else 
                                            {
                                                
                                                 swal("Success", "Building assigned to the customer successfully..", "success");
                                                 load_data_to_grid_customer_building_list();
                                                 $("#select_building_for_location").val(null).trigger("change");
                                        $("#select_customer_for_customer_location").val(null).trigger("change");
                                        $("#select_location_for_customer_location").val(null).trigger("change");
                                        
                                        $("#txt_customer_location_id").val('');
                                        $("#txt_contact_person_number_build").val('');
                                         $("#txt_contact_person_name").val('');
                    					 $("#txt_building_name").val('');
                    					 $("#txt_Building_address").val('');
                    					 $("#txt_contact_person_building_name").val('')
                                         $("#txt_contact_person_building_code").val('');
                                                 
                                             }                  
                                    });
                                    
                                 }
                 });
				 
				$('#btn_view_work_order_building').click(function(){
					var cust_id = $('#txt_customer_id').val();
					var v_location_id = $('#txt_hidden_ticket_customer_location_id').val();
					var v_building_id = $('#txt_hidden_ticket_customer_building_id').val();
					//alert(cust_id+','+v_building_id+','+v_location_id);
					load_data_previous_workorder_list(cust_id,v_location_id,v_building_id);
				}); 
				
				var tbl_list_of_previous_work_order = $('#list_of_previous_work_order').DataTable();
    
    
				function load_data_previous_workorder_list(cust_id,v_location_id,v_building_id)
                 {
                    var i =1;
                    tbl_list_of_previous_work_order.destroy();
                         
                     tbl_list_of_previous_work_order = $('#list_of_previous_work_order').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_previous_workorder_building',customer_id:cust_id,location_id:v_location_id,building_id:v_building_id
                                    
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
                                
                                { "data": null,className: "text-center",
                                        // "render": function(data, type, full, meta) {
                                            // return i++;
                                        // },
                                },
								{ "data": "created_date_time"},
								{ "data": "ticket_id",
								  render: function ( data, type, rows, meta ) {
									 str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"]+'</a>';
									 
										return str_active_status;
		
									},
                                },
								{ "data": "complaints_description"},
							    { "data": "ticket_status",
									render: function ( data, type, rows, meta ) {
									  switch(data)
									  {
										  case 'Closed':
											   str_active_status='<span class="badge badge-danger">'+data+'</span>'
										  break;
										  case 'Cancelled':
											   str_active_status='<span class="badge badge-warning">'+data+'</span>'
										  break;
										  case 'Assigned':
											   str_active_status='<span class="badge badge-info">'+data+'</span>'
										  break;
										  case 'Completed':
											   str_active_status='<span class="badge badge-success">'+data+'</span>'
										  break;
										  case 'Scheduled':
											   str_active_status='<span class="badge badge-primary">'+data+'</span>'
										  break;
										  // default:
										  // str_active_status='<span class="badge bg-slate">'+data+'</span>'
										  // break;
									  }
									 
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
                                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
                	 
        $('#div_asset_type_select').load("tickets/assets_type_combo_add_assets.php");        	 
        $('#select_category_add_assets').change(function (e) {
            
            var v_asset_category_id=$("#select_category_add_assets option:selected").val();
            
            $('#div_asset_type_select').load("tickets/assets_type_combo_add_assets.php?category_id="+v_asset_category_id); 
            
        });
        
        
         var ID = function () {
          
           var d = new Date();
           var UniqueCode = (Math.random().toString(36).substr(2, 3)).toUpperCase();
           return UniqueCode;
        
        };
        
      function generateBarcode(txtvalget){
         var timestamp = ID();
         $("#barcodeValue").val(txtvalget+'-'+timestamp);
        var value = $("#barcodeValue").val();
       
        var btype = $("input[name=btype]:checked").val();
        var renderer = $("input[name=renderer]:checked").val();

        var settings = {
          output:renderer,
          bgColor: $("#bgColor").val(),
          color: $("#color").val(),
          barWidth: $("#barWidth").val(),
          barHeight: $("#barHeight").val(),
          moduleSize: $("#moduleSize").val(),
          posX: $("#posX").val(),
          posY: $("#posY").val(),
          addQuietZone: $("#quietZoneSize").val()
        };
        if ($("#rectangular").is(':checked') || $("#rectangular").attr('checked')){
          value = {code:value, rect: true};
        }
        if (renderer == 'canvas'){
          clearCanvas();
          $("#barcodeTarget").hide();
          $("#canvasTarget").show().barcode(value, btype, settings);
        } else {
          $("#canvasTarget").hide();
          $("#barcodeTarget").html("").show().barcode(value, btype, settings);
        }
      }
          
          var v_assets_attachment,attachments =[];

             $("#btn_generate_barcode").click(function(){
                 generateBarcode($('#txt_barcode_generate_values').val());
                 
             });
           $("#mdl_add_assets").click(function(){
                     var location_code=$("#txt_hidden_ticket_customer_location_code").val();
               	    var v_asset_building_code=$("#txt_hidden_ticket_customer_building_code").val();
               		var cust_code_view=$("#txt_hidden_ticket_customer_code").val();
                     var assetref='THC'+'-'+cust_code_view+'-'+location_code+'-'+v_asset_building_code;
        			        
        			         $('#txt_barcode_generate_values').val(assetref);
        		  });
                
              
            $("#btn_add_assets_tickets").click(function(){
                        
								var assets_attachment_file=attachments[0];
								var v_asset_ref_no=$("#barcodeValue").val();
								var v_cust_id=$("#txt_hidden_ticket_customer_id").val();
								var cust_code_view=$("#txt_hidden_ticket_customer_code").val();
								var cust_code_name=$("#txt_hidden_ticket_customer_name").val();
								var v_asset_category_id=$("#select_category_add_assets option:selected").val();
							    var v_asset_category_name=$("#select_category_add_assets option:selected").text();
								var v_asset_type_id=$("#select_asset_type_add_assets option:selected").val();
								var v_asset_type_name=$("#select_asset_type_add_assets option:selected").text();
								
								var v_location_id=$("#txt_hidden_ticket_customer_location_id").val();
								
								var v_asset_location=$("#txt_hidden_ticket_customer_location_name").val();
								var location_code=$("#txt_hidden_ticket_customer_location_code").val();
								var v_asset_building_id=$("#txt_hidden_ticket_customer_building_id").val();
								
								var v_asset_building_code=$("#txt_hidden_ticket_customer_building_code").val();
								var v_asset_building_name=$("#txt_hidden_ticket_customer_building_name").val();
								
								var v_flat_area_code=$("#txt_flat_area_no").val();
								var v_asset_serial_no=$("#txt_modal_no").val();
								var v_asset_brand=$("#txt_brand").val();
								var v_asset_capacity=$("#txt_capacity").val();
								var v_asset_cost=$("#txt_cost").val();
								var v_is_warentee=$("#txt_is_warrantee option:selected").text();
								var v_warentee_end_date=$("#warrantee_date").val();
								
								var v_asset_description=$("#txt_des").val();
								
								var v_zone_or_floor_no=$("#txt_zone_or_floor_no").val();
								var v_asset_roon_no=$("#txt_room_no").val();
								var v_asset_specify_description=$("#txt_specify_if_any").val();
						
								if(assets_attachment_file===""||typeof assets_attachment_file === "undefined")
                                    {
                                        
                                        assets_attachment_file="default.jpg";
                                    }
								
								if($.trim(v_is_warentee)=="YES" && $.trim(v_warentee_end_date)==="")
                                    {
                                        swal("Warning","Please provide Warentee End Date ....", "warning");
										return false;
                                    }
								 if($.trim(v_asset_ref_no)==="")
								 {
								     
									 swal("Warning","Please generate asset code", "warning");
																		
																		return false;
								 }

                                if($.trim(v_asset_ref_no)===""||typeof v_asset_category_name === "undefined"||typeof v_asset_type_name === "undefined"|| $.trim(v_asset_category_id) == ""|| $.trim(v_asset_category_name) == "Select Category"|| $.trim(v_asset_type_id) == ""|| $.trim(v_asset_type_name) == "Select Type")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/amc/amc_assets_controller.php",{action:'add_amc_assets',location_code:location_code,v_asset_building_id:v_asset_building_id,v_zone_or_floor_no:v_zone_or_floor_no,v_asset_roon_no:v_asset_roon_no,v_asset_specify_description:v_asset_specify_description,v_asset_ref_no:v_asset_ref_no,v_asset_category_id:v_asset_category_id,v_asset_category_name:v_asset_category_name,v_asset_type_id:v_asset_type_id,v_asset_type_name:v_asset_type_name,v_cust_id:v_cust_id,v_cust_code:cust_code_view,v_cust_name:cust_code_name,v_location_id:v_location_id,v_asset_location:v_asset_location,v_asset_building:v_asset_building_name,v_asset_building_code:v_asset_building_code,v_flat_area_code:v_flat_area_code,v_asset_serial_no:v_asset_serial_no,v_asset_brand:v_asset_brand,v_asset_capacity:v_asset_capacity,v_asset_cost:v_asset_cost,v_is_warentee:v_is_warentee,v_warentee_end_date:v_warentee_end_date,assets_attachment_file:assets_attachment_file,v_asset_description:v_asset_description}
                                            , function(result,status)
                                            {
                                                
                                                if(result!='')
                                                {
												    
											        swal("Success", "New Assets added successfully..", "success");
											        load_data_to_grid_asset_list(v_cust_id,v_location_id,v_asset_building_id);
											         clear_text_asset_add_modal();
											
                                                }
                                                else
                                                {
                                                     
											        swal("Error", "Sorry not able to add new assets..", "error");
											         clear_text_asset_add_modal();
											
                                                }
                                                
                                                
                                    });
  
                                }
                        });//close of Assets add button
						
				$('#btn_view_work_order_asset').click(function(){
					var cust_id = $('#txt_customer_id').val();
					var v_location_id = $('#txt_hidden_ticket_customer_location_id').val();
					var v_building_id = $('#txt_hidden_ticket_customer_building_id').val();
					var v_asset_id = $('#txt_hidden_ticket_customer_asset_id').val();
					//alert(cust_id+','+v_building_id+','+v_location_id+','+v_asset_id);
					load_data_previous_workorder_asset_list(cust_id,v_location_id,v_building_id,v_asset_id);
				}); 
				
				var tbl_list_of_previous_work_order_asset = $('#list_of_previous_work_order_asset').DataTable();
    
    
				function load_data_previous_workorder_asset_list(cust_id,v_location_id,v_building_id,v_asset_id)
                 {
                    var i =1; 
                    tbl_list_of_previous_work_order_asset.destroy();
                         
                     tbl_list_of_previous_work_order_asset = $('#list_of_previous_work_order_asset').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'list_previous_workorder_asset',customer_id:cust_id,location_id:v_location_id,building_id:v_building_id,asset_id:v_asset_id
                                    
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
                                
                                { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                        },
                                },
								{ "data": "created_date_time"},
								{ "data": "ticket_id",
								  render: function ( data, type, rows, meta ) {
									 str_active_status='<a href="../view/work_order_print.php?ticket_id='+data+'" target="_blank">WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"]+'</a>';
									 
										return str_active_status;
		
									},
                                },
								{ "data": "complaints_description"},
							    { "data": "ticket_status",
									render: function ( data, type, rows, meta ) {
									  switch(data)
									  {
										  case 'Closed':
											   str_active_status='<span class="badge badge-danger">'+data+'</span>'
										  break;
										  case 'Cancelled':
											   str_active_status='<span class="badge badge-warning">'+data+'</span>'
										  break;
										  case 'Assigned':
											   str_active_status='<span class="badge badge-info">'+data+'</span>'
										  break;
										  case 'Completed':
											   str_active_status='<span class="badge badge-success">'+data+'</span>'
										  break;
										  case 'Scheduled':
											   str_active_status='<span class="badge badge-success">'+data+'</span>'
										  break;
										  // default:
										  // str_active_status='<span class="badge bg-slate">'+data+'</span>'
										  // break;
									  } 
									 
									return str_active_status;
		
									 },
								},
                       
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
                        
                    $('#assets_attachment').change(function (e) {
					    attachment_upload('#assets_attachment',v_assets_attachment);
                    });
                    function attachment_upload(txt_param,v_attachment)
            		 {
            				v_attachment = $(txt_param).val();
            				randomNum = Math.ceil(Math.random() * 999999);
            			   
            				if(v_attachment=="")
            				{
            					
            					v_attachment="default.jpg";
            				}
            				else
            				{
            					var doc_file_obj = $(txt_param)[0].files[0];
            					var upload = new ns.Upload(doc_file_obj);
            					doc_file1= doc_file_obj.name;
            					 v_attachment=$.trim(randomNum+'_'+doc_file1);
            					 attachments.push(v_attachment);
            					var success = upload.doUpload("../httpdocs/user_upload/amc_attachements.php?random_no="+randomNum);
            				} 
            		 }
            		 
            function clear_text_asset_add_modal()
                 {
                    
					$("#select_category_add_assets").val(null).trigger("change");
                    $("#select_asset_type_add_assets").val(null).trigger("change");
                    $("#barcodeValue").val('');
                    $("#txt_flat_area_no").val('');
                    $("#txt_modal_no").val('');
                    $("#txt_brand").val('');
                    $("#txt_capacity").val('');
                    $("#txt_cost").val('');
                    $("#warrantee_date").val('');
                    $("#txt_des").val('');
                    $("#barcodeTarget").empty();
                    $("#barcodeValue").val('');
                    $("#txt_zone_or_floor_no").val('');
					$("#txt_room_no").val('');
					$("#txt_specify_if_any").val('');
					$("#assets_attachment").val('');
					$("#assets_img_name").text('');
					$( "#img_assets_preview" ).empty();
					 $("#txt_barcode_generate_values").val('');
					
                   
                 }
                  $("#btn_modal_new_type").click(function(){
                      
                       $('#div_asset_type_add_category_combo').load("tickets/asset_category_combo_add_type.php");
                  });
                 
                   $("#btn_modal_add_services").click(function(){
                      
                       $('#div_services_add_category_combo').load("tickets/asset_category_combo_add_service.php");
                       $('#div_services_add_type_combo').load("tickets/asset_type_combo_add_service.php");
                  });
                    $('#div_services_add_category_combo').on('change', '.categoryservices', function(){
            
                    var v_asset_category_id=$("#select_category_add_services option:selected").val();
                   
                    $('#div_services_add_type_combo').load("tickets/asset_type_combo_add_service.php?category_id="+v_asset_category_id); 
                    
                });
             
                 
                 $('#btn_service_add').click(function(){
                                
                                v_category_type_id=$("#select_category_add_services option:selected").val();
                                v_category_type_name=$("#select_category_add_services option:selected").text();
                                v_category_asset_type_id=$("#select_asset_type_add_services option:selected").val();
                                v_category_asset_type_name=$("#select_asset_type_add_services option:selected").text();
                                v_service_desc=$("#txt_add_services").val();
                                 
                                if($.trim(v_service_desc)==""||typeof v_category_type_id === "undefined"|| typeof v_category_asset_type_id === "undefined")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                   
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/services/service_controller.php",{action:'add_service',v_category_type_id:v_category_type_id,v_category_type_name:v_category_type_name,v_category_asset_type_id:v_category_asset_type_id,v_category_asset_type_name:v_category_asset_type_name,v_service_desc:v_service_desc}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                               
                                                swal("Error", result, "error");
                                                $("#select_category_add_services").val(null).trigger("change");
                                        $("#select_asset_type_add_services").val(null).trigger("change");
                                        $("#txt_add_services").val('');
                                            }
                                            else 
                                            {
                                                
                                                 swal("Success", "New service added successfully..", "success");
                                                 load_data_to_grid_services_list($("#txt_hidden_ticket_customer_asset_category_id").val(),$("#select_asset_type option:selected").val());
                                                 
                                                                     $("#select_category_add_services").val(null).trigger("change");
                                        $("#select_asset_type_add_services").val(null).trigger("change");
                                        $("#txt_add_services").val('');
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
        
} );