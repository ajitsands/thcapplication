$(document).ready(function(){
    
    var v_list_of_customer_facility = $('#tbl_customer_facility').DataTable({});
    var v_list_of_customer_assets = $('#tbl_customer_assets').DataTable({});
    var v_list_of_customer_amc = $('#tbl_customer_amc_list').DataTable({});
    var v_list_of_customer_ticket = $('#tbl_customer_tickets').DataTable({});
    
    $( '#btn_customer_details_view' ).click(function(){
        
      var v_customer_id=$("#select_customer option:selected").val();
      load_data_to_grid_customer_facility_list(v_customer_id);
      load_data_to_grid_customer_assets_list(v_customer_id);
      load_data_to_grid_customer_amc_list(v_customer_id);
      load_data_to_grid_customer_ticket_list(v_customer_id)
       
       $.post("../controller/customer_directory/customer_directory_controller.php",{action:'fetch_customer_details',v_customer_id:v_customer_id}
				, function(result,status)
        { 
			var obj = jQuery.parseJSON(result);
			$("#txt_customer_code").val(obj.data[0].customer_code);
			$("#txt_customer_name").val(obj.data[0].customer_name);
			$("#txt_customer_contact_no").val(obj.data[0].customer_contact_no);
			$("#txt_email_id").val(obj.data[0].customer_email_id);
			$("#txt_cpr_no").val(obj.data[0].customer_cpr_cr_no);
			$("#txt_vat_no").val(obj.data[0].customer_vat_no);
			$("#txt_contact_person_name").val(obj.data[0].customer_contact_person_name);
			$("#txt_alt_contact_no").val(obj.data[0].customer_location);
			$("#txt_contact_person_no").val(obj.data[0].customer_contact_person_no);
			$("#txt_address").val(obj.data[0].customer_address);
			$("#txt_status").val(obj.data[0].customer_status);
			$("#txt_othr_dertails").val(obj.data[0].customer_description);
			
	    });
    });
    $( '#li_customer_print' ).click(function(){
         var v_customer_id=$("#select_customer option:selected").val();
         if(v_customer_id=='select')
         {
             swal("Error", "Please select customer", "warning");
             return false;
         }
         else
         {
             window.open('reports/customer_profile.php?cust_id='+v_customer_id, '_blank');
         }
         
    });
    $( '#select_customer' ).change(function(){
        
      var v_customer_id=$("#select_customer option:selected").val();
      load_data_to_grid_customer_facility_list(v_customer_id);
      load_data_to_grid_customer_assets_list(v_customer_id);
      load_data_to_grid_customer_amc_list(v_customer_id);
      load_data_to_grid_customer_ticket_list(v_customer_id)
       
       $.post("../controller/customer_directory/customer_directory_controller.php",{action:'fetch_customer_details',v_customer_id:v_customer_id}
				, function(result,status)
        { 
			var obj = jQuery.parseJSON(result);
			$("#txt_customer_code").val(obj.data[0].customer_code);
			$("#txt_customer_name").val(obj.data[0].customer_name);
			$("#txt_customer_contact_no").val(obj.data[0].customer_contact_no);
			$("#txt_email_id").val(obj.data[0].customer_email_id);
			$("#txt_cpr_no").val(obj.data[0].customer_cpr_cr_no);
			$("#txt_vat_no").val(obj.data[0].customer_vat_no);
			$("#txt_contact_person_name").val(obj.data[0].customer_contact_person_name);
			$("#txt_alt_contact_no").val(obj.data[0].customer_location);
			$("#txt_contact_person_no").val(obj.data[0].customer_contact_person_no);
			$("#txt_address").val(obj.data[0].customer_address);
			$("#txt_status").val(obj.data[0].customer_status);
			$("#txt_othr_dertails").val(obj.data[0].customer_description);
			
	    });
    });

    
    function load_data_to_grid_customer_facility_list(v_customer_id)
         {
             
            v_list_of_customer_facility.destroy();
                 
             v_list_of_customer_facility = $('#tbl_customer_facility').DataTable( {
                   
                     "ajax": {
                         'type': 'POST',
                         'url': '../controller/customer_directory/customer_directory_controller.php',
                         'data': {
                            action: 'list_customer_facilities',
                            v_customer_id:v_customer_id
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
                        { "data": null},
                         
                        { "data": "building_image",
                          render: function ( data, type, rows, meta ) {
                                  if(data=='default.jpg' || data=="" || data==null)
                                  {
                                     return '<div align="center"><img src="../httpdocs/images/building_image/default.jpg" class="rounded-circle" height="30px" width="30px"/></div>';
     
                                  }
                                  else
                                  {
                                      return '<div align="center"><img src="../httpdocs/images/building_image/'+data+'" class="rounded-circle" height="50px" width="50px"/></div>';
    
                                  }
                                 
    							 },
                             
                        },
                        { "data": "building_name",
                        
                            render: function ( data, type, rows, meta ) {
                                          
                                          return rows['building_name']+' - '+rows['location_name'];
            
            							 },
                        },
				        { "data": "building_name",
				            render: function ( data, type, rows, meta ) {
                                          
                                          return rows['building_address']+'<br>'+rows['contact_person_name']+' - '+rows['contact_person_no'];
            
            							 },
				        }
                       
                         
               
                     ],
                     pageLength: 20,
    				 searching: true,
                     responsive: true,
                     
        //              "aoColumnDefs": [
    				// 	{ "bSortable": false, "aTargets": [ 1,2,3] }, 
    					
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
         
         
     function load_data_to_grid_customer_assets_list(v_customer_id)
         {
             
            v_list_of_customer_assets.destroy();
                 
             v_list_of_customer_assets = $('#tbl_customer_assets').DataTable( {
                   
                     "ajax": {
                         'type': 'POST',
                         'url': '../controller/customer_directory/customer_directory_controller.php',
                         'data': {
                            action: 'list_customer_assets',
                            v_customer_id:v_customer_id
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
                            "width": "5%"
                            
                        },
                        { "data": null},
                         
                        
                        { "data": "asset_building" ,
                             render: function ( data, type, rows, meta ) {
                                          
                                          return rows['asset_building']+' - '+rows['asset_location'];
            
            							 },
                        },
				        { "data": "asset_category_name",
			                render: function ( data, type, rows, meta ) {
                                          
                                          return rows['asset_category_name']+', '+rows['asset_type_name'];
            
            							 },
				            
				        },
				        
				        { "data": "asset_ref_no",
				            render: function ( data, type, rows, meta ) {
                                            
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Brand</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['asset_brand'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Model Number</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['asset_serial_no'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Warrantee/Guarantee</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['warentee_end_date'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Capacity</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['asset_capacity'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Cost</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['asset_cost'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b>Asset Description </b>: '+rows['asset_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }  
				            
				        },
				        /*{ "data": "asset_id",
				            render: function ( data, type, rows, meta ) {
                                            
                                           str_ref='<a href="../../httpdocs/images/amc_attachements/'+rows['asset_attachment']+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a>';
                                             return str_ref;
                                     }  
				            
				        }*/
                        
                     ],
                     pageLength: 20,
    				 searching: true,
                     responsive: true,
                     
        //              "aoColumnDefs": [
    				// 	{ "bSortable": false, "aTargets": [ 1,2,3] }, 
    					
    				// ],
                    
    				
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
         
          $('#tbl_customer_assets tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_customer_assets.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_asset_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
            });
            
        function format_asset_details(d)
       	{

			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
			 '<tr style="background: #989898;color:#ffffff;">'+
			  '<td ><div align="center">Zone Floor</div></td>'+
				'<td ><div align="center">Flat Area </div></td>'+
				'<td ><div align="center">Room No </div></td>'+
			    '<td ><div align="center">Attachment</div></td>'+
			  '</tr>'+
			  '<tr>'+
			  '<td><div align="center">'+d.zone_floor+'</div></td>'+
				'<td><div align="center">'+d.flat_area_code+'</div></td>'+
				'<td><div align="center">'+d.room_no+'</div></td>'+
				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.asset_attachment+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
			  '</tr>'+
			  	 
			  
			'</table>' ;
           
        }
         
         $('#tbl_customer_assets tbody').on('click', 'tr', function(e){
                if($('.popoverButton').length>1)
                    $('.popoverButton').popover('hide');
                    $(e.target).popover('toggle'); 
              
          })
    
    
    //  var minDate, maxDate;
    // minDate = new DateTime($('#min'), {
    //     format: 'YYYY-MM-DD'
    // });
    // maxDate = new DateTime($('#max'), {
    //     format: 'YYYY-MM-DD'
    // });
    
   
 

    function load_data_to_grid_customer_amc_list(v_customer_id)
     {
         
        v_list_of_customer_amc.destroy();
             
         v_list_of_customer_amc = $('#tbl_customer_amc_list').DataTable( {
               
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/customer_directory/customer_directory_controller.php',
                     'data': {
                        action: 'list_customer_amc',
                        v_customer_id:v_customer_id
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
				
			    columnDefs: [
                            { type: 'date-eu', targets: [4,5] }
                             ],
                "columns": [
                     {
                        "className":  'details-control',
                        "orderable":  false,
                        "data":        null,
                        "defaultContent": '',
                        "width": "5%"
                        
                    },
                    { "data": null},
                    { "data": "amc_ref_no" },
			        { "data": "contract_type_name"},
			        
			        { "data": "amc_start_date",
			            render: function ( data, type, rows, meta ) {
                                  str_amc_date = rows['amc_start_date'];
                                  return str_amc_date;
                                  
                              }    
			            
			        },
			         { "data": "amc_end_date",
			            render: function ( data, type, rows, meta ) {
                                  str_amc_date = rows['amc_end_date'];
                                  return str_amc_date;
                                  
                              }    
			            
			        },
			        { "data": "amc_status",
			            render: function ( data, type, rows, meta ) {
                          
                              if(data=='Active')
                              {
                                str_active_status='<span class="badge badge-success" >'+data+'</span>'
                              }
                             
                              else if(data=='Hold')
                              {
    
                                 str_active_status='<span class="badge badge-primary">'+data+'</span>'
                           
                              }
                              else if(data=='Cancelled')
                              {
                                str_active_status='<span class="badge badge-warning">'+data+'</span>'  
                              }
                              else if(data=='Completed')
                              {
                                str_active_status='<span class="badge badge-info">'+data+'</span>'   
                              }
                         	return str_active_status;
                              
                          }
			            
			        }
                 ],
                 pageLength: 30,
				 searching: true,
                 responsive: true,
                 
                
                
				
                 "initComplete": function( settings, json ) {
                        
                // $.fn.dataTable.ext.search.push(
                // function( settings, data, dataIndex ) {
                //         var min = minDate.val();
                //         var max = maxDate.val();
                //         var date = new Date( data[4] );
                
                //         if (
                //             ( min === null && max === null ) ||
                //             ( min === null && date <= max ) ||
                //             ( min <= date   && max === null ) ||
                //             ( min <= date   && date <= max )
                //         ) {
                //             return true;
                //         }
                //         return false;
                //     }
                // );
                  },
                    "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                     $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                     return nRow;
                  },
                  
                  "drawCallback": function () {
                       
                    }
                
         });  
    
     }
     // Custom filtering function which will search data in column four between two values
     
    //  $('#min, #max').on('change', function () {
    //     v_list_of_customer_amc.draw();
    // });
  
     
      $('#tbl_customer_amc_list tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_customer_amc.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                
                
        function format_amc_details(d)
       	{

			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
			 '<tr style="background: #989898;color:#ffffff;">'+
			    '<td ><div align="center">Signed Date </div></td>'+
				'<td ><div align="center">Amount Details </div></td>'+
				'<td ><div align="center">VAT Details </div></td>'+
			    
			
			  '</tr>'+
			  '<tr>'+
			  	'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
				'<td><div align="center">'+d.amc_amount+'</div></td>'+
				'<td><div align="center">'+d.amc_vat_amt+' ('+d.amc_vat_perct+' )'+'</div></td>'+
					
				
			  '</tr>'+
			  	 '<tr style="background: #989898;color:#ffffff;">'+
			    '<td ><div align="center">AMC Description </div></td>'+
				'<td ><div align="center">RFP? </div></td>'+
				'<td ><div align="center">Contract Type </div></td>'+
			
			
			  '</tr>'+
			  '<tr>'+
			  	'<td><div align="center">'+d.amc_description+'</div></td>'+
				'<td><div align="center">'+d.is_rfp+'</div></td>'+
			    '<td><div align="center">'+d.contract_type_name+'</div></td>'+
				
			  '</tr>'+
			   	 '<tr style="background: #989898;color:#ffffff;">'+
			    '<td ><div align="center">AMC Attachment 1</div></td>'+
				'<td ><div align="center">AMC Attachment 2</div></td>'+
				'<td ><div align="center">AMC Attachment 3</div></td>'+
			
			
			  '</tr>'+
			  '<tr>'+
			  
				'<td><div align="center">'+d.amc_attachment1_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
				'<td><div align="center">'+d.amc_attachment2_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
				'<td><div align="center">'+d.amc_attachment3_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
			  '</tr>'+
			 
			
			'</table>' ;
            			


    }
    
     function load_data_to_grid_customer_ticket_list(v_customer_id)
     {
         
        v_list_of_customer_ticket.destroy();
             
         v_list_of_customer_ticket = $('#tbl_customer_tickets').DataTable( {
               
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/customer_directory/customer_directory_controller.php',
                     'data': {
                        action: 'list_customer_ticket',
                        v_customer_id:v_customer_id
                     }
                 },
                 "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                  },
                "order": [[ 2, "desc" ]],
               
				"Paginate": true,
				"bLengthChange": true,
				"bFilter": true,
				"bInfo": true,
				"autoWidth": false,
				
			    columnDefs: [
                    { type: 'date-eu', targets: 3 }
                             ],
                "columns": [
                     {
                        "className":  'details-control',
                        "orderable":  false,
                        "data":        null,
                        "defaultContent": '',
                        "width": "5%"
                        
                    },
                    { "data": null},
                    { "data": "ticket_status", "visible":false},
                    { "data": "created_date_time" },
			        { "data": "ticket_ref_code",
			            render: function ( data, type, rows, meta ) {
                              
                              str_active_status='<a href="../view/work_order_print.php?ticket_id='+rows['ticket_id']+'" target="_blank">WO-'+data+'-'+rows["ticket_id"]+'</a>';
                                        
                              
                         	return str_active_status;

							 },
			        },
			        { "data": "location_code",
                          render: function ( data, type, rows, meta ) {
                              
                              str_active_status=data+' - '+rows['location_name'];
                              
                         	return str_active_status;

							 },
                     },
                     { "data": "building_code",
                          render: function ( data, type, rows, meta ) {
                              
                              str_active_status=data+' - '+rows['building_name'];
                              
                         	return str_active_status;

							 },
                     }
			       
                     
                 ],
                 pageLength: 100,
				 searching: true,
                 responsive: true,
                 
    //              "aoColumnDefs": [
				// 	{ "bSortable": false, "aTargets": [ 1,2,3] }, 
					
				// ],
                
				
                 "initComplete": function( settings, json ) {
                        
                   
 
                  },
                    "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                     $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                     return nRow;
                  },
                  "drawCallback": function (settings) {
                                       
                        var api = this.api();
                    
                      var rows = api.rows({
                        page: 'current'
                      }).nodes();
                      var last = null;
            
                      api.column(2, {
                        page: 'current'
                      }).data().each(function (group, i) {
                        if (last !== group) {
                            switch(group)
                              {
                                case 'Opened':
                                   $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:black"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Scheduled':
                                   $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#39C0ED"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Assigned':
                                
                                    $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#3F51B5"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Completed':
                                
                                    $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#795548"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Closed':
                                
                                    $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#4CAF50"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Cancelled':
                                
                                    $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#B23CFD"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                                case 'Extended':
                                
                                    $(rows).eq(i).before(
                                       
                                        '<tr class="group" style="font-size: 12px;color:white;font-weight: bold; "><td colspan="15" style="color:#ffc107"> ' + group + ' Tickets</td></tr>'
                                      ); 
                                break;
                          
                              }
                            last = group;
                      }
                      });
                      $('.dataTables_paginate > .pagination').addClass('pagination-sm');
                 }
                
         });  
    
     }
     
     $('#tbl_customer_tickets tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = v_list_of_customer_ticket.row( tr );
       
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format_amc_ticket_details(row.data()) ).show();
            tr.addClass('shown');
           
             
        }
     });
                
                
                
     function format_amc_ticket_details(d)
       	{

			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
			 '<tr style="background: #989898;color:#ffffff;">'+
			  '<td ><div align="center">Category</div></td>'+
				'<td ><div align="center">type </div></td>'+
				'<td colspan="2" ><div align="center">Complaints Description </div></td>'+
			
			  '</tr>'+
			  '<tr>'+
			  '<td><div align="center">'+d.category_name+'</div></td>'+
				'<td><div align="center">'+d.type_name+'</div></td>'+
				'<td colspan="2"><div align="center">'+d.complaints_description+'</div></td>'+
			  '</tr>'+
			  	 '<tr style="background: #989898;color:#ffffff;">'+
			  	 
			    '<td colspan="2" ><div align="center">Service Request</div></td>'+
				'<td colspan="2" ><div align="center">Job Category </div></td>'+
				
			
			  '</tr>'+
			  '<tr>'+
			  
			  	'<td colspan="2"><div align="center">'+d.service_request+'</div></td>'+
				'<td colspan="2"><div align="center">'+d.job_category+'</div></td>'+
			    
				
			  '</tr>'+
			  
			'</table>' ;
           
        }
    
   

});