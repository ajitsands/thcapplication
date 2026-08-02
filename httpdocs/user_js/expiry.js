$(document).ready(function(){
  
                     $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    var v_btn_employee_add = $('#btn_employee_add').ladda();
                    
                        var d = new Date();
                        var dd = String(d.getDate()).padStart(2, '0');
                        var mm = String(d.getMonth() + 1).padStart(2, '0');
                        var yyyy = d.getFullYear();
                        var today_date = yyyy + '-' + mm + '-' + dd;
                       
                        $("#txt_end_date_visa").val(today_date);
                        $("#txt_end_date").val(today_date);
                 
                    var v_list_of_employees_table = $('#list_of_CPR_employees').DataTable({
                         columnDefs: [
                         { type: 'date-eu', targets: 6 }
                         ]
                    });
                    var v_list_of_employees_visa_table = $('#list_of_visa_employees').DataTable({});
                    
                      load_data_to_grid_employees_details_list();
                      load_data_to_grid_employees_visa_details_list();
                      
                     $("#btn_customer_search").click(function(){
                        var search_date=$("#txt_end_date").val();
                        if (search_date=='')
                            {
                            swal("Error", "Please select date", "warning");
                            
                                return false;
                            }
                            else
                            {
                        var search_date = new Date(search_date);
                        var dd = String(search_date.getDate()).padStart(2, '0');
                        var mm = String(search_date.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = search_date.getFullYear();
                         search_date = yyyy + '-' + mm + '-' + dd;
                          load_data_to_grid_employees_details_list_date_search(search_date);
                            }
                      })
                      $("#btn_customer_search_visa").click(function(){
                        var search_date_visa=$("#txt_end_date_visa").val();
                       
                        if (search_date_visa=='')
                            {
                            swal("Error", "Please select date", "warning");
                            
                                return false;
                            }
                            else
                            {
                                var search_date_visa = new Date(search_date_visa);
                             var dd = String(search_date_visa.getDate()).padStart(2, '0');
                            var mm = String(search_date_visa.getMonth() + 1).padStart(2, '0'); //January is 0!
                            var yyyy = search_date_visa.getFullYear();
                             search_date_visa = yyyy + '-' + mm + '-' + dd;
                             load_data_to_grid_employees_visa_details_list_search(search_date_visa);
                            }
                        
                      })
                      
                      
                     $('#btn_cpr_export').click(function (e) {
                         var search_date=$("#txt_end_date").val();
                        if (search_date=='')
                            {
                            swal("Error", "Please select date", "warning");
                            
                                return false;
                            }
                            else
                            {
                                window.open("cpr_expiry_list.php?search_date="+search_date,"_blank");  
                        
                            }
                     });
                      $('#btn_visa_export').click(function (e) {
                         var search_date=$("#txt_end_date_visa").val();
                        if (search_date=='')
                            {
                            swal("Error", "Please select date", "warning");
                            
                                return false;
                            }
                            else
                            {
                                window.open("visa_expiry_list.php?search_date="+search_date,"_blank");  
                        
                            }
                     });
  
                 function load_data_to_grid_employees_details_list_date_search(search_date)
                 {
                     
                    v_list_of_employees_table.destroy();
                         
                     v_list_of_employees_table = $('#list_of_CPR_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/expiry/expiry_controller.php',
                                 'data': {
                                    action: 'employee_cpr_expire_list_view_search_date',
                                    search_date : search_date
                                    
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
                                    { type: 'date-eu', targets: 6 }
                             ],
                                    			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "employee_id","visible":false },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                  { "data": "employee_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
                                 { "data": "cpr_expiry_date_format"},
                                
                                 { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          return '<div align="center"><img src=../httpdocs/images/employee_image/'+$.trim(data)+' class="rounded-circle" height="40px" width="40px"/></div>';
            
            							 },
                                 },
                                
                                 
                                 { "data": "employee_status",
                                      render: function ( data, type, rows, meta ) {
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['cpr_expiry_date'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          }
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['cpr_expiry_date']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                 
                                  { "data": "employee_status",
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
                           
                                    
 
                 function load_data_to_grid_employees_details_list()
                 {
                     
                    v_list_of_employees_table.destroy();
                         
                     v_list_of_employees_table = $('#list_of_CPR_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/expiry/expiry_controller.php',
                                 'data': {
                                    action: 'employee_cpr_expire_list_view'
                                    
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
                                    { type: 'date-eu', targets: 6 }
                             ],
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "employee_id","visible":false },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                  { "data": "employee_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
                                 
                                { "data": "cpr_expiry_date_format"},
                                 { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          return '<div align="center"><img src=../httpdocs/images/employee_image/'+$.trim(data)+' class="rounded-circle" height="40px" width="40px"/></div>';
            
            							 },
                                 },
                                
                                 
                                 { "data": "employee_status",
                                      render: function ( data, type, rows, meta ) {
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['cpr_expiry_date'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          }
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['cpr_expiry_date']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                  { "data": "employee_status",
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
                 
                  $('#list_of_CPR_employees tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_employees_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_employees(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
        
                 function format_employees(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Contact Number </div></td>'+
            				
            				'<td ><div align="center">Email </div></td>'+
            				'<td ><div align="center">Expertise Name </div></td>'+
            				'<td ><div align="center">Native Number </div></td>'+
            				'<td ><div align="center">Blood Group </div></td>'+
            				'<td ><div align="center">CPR Number </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.employee_contact_no+'</div></td>'+
            				
            				'<td><div align="center">'+d.employee_email_id+'</div></td>'+
            				'<td><div align="center">'+d.expertise_name+'</div></td>'+
            			    '<td><div align="center">'+d.native_number+'</div></td>'+
            				'<td><div align="center">'+d.blood_group+'</div></td>'+
            				'<td><div align="center">'+d.cpr_no+'</div></td>'+
            				
            				
            			  '</tr>'+
            			  
            			  
            			  
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Passport Number </div></td>'+
            				'<td ><div align="center">Joining Date </div></td>'+
            				'<td ><div align="center">CPR Expiry Date </div></td>'+
            				'<td ><div align="center">Visa Validity </div></td>'+
            				'<td ><div align="center">Driving Licence </div></td>'+
            				'<td ><div align="center">Technician Type </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.passport_no+'</div></td>'+
            				'<td><div align="center">'+d.joining_date+' </div></td>'+
            				'<td><div align="center">'+d.cpr_expiry_date+'</div></td>'+
            				'<td><div align="center">'+d.visa_validity_on+'</div></td>'+
            				'<td><div align="center">'+d.is_driving_license+'</div></td>'+
            				'<td><div align="center">'+d.technician_type+'</div></td>'+
            				
            				
            			  '</tr>'+
            			  
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            			
            				'<td colspan="2"><div align="center" >Employee Address </div></td>'+
            				'<td colspan="2"><div align="center" >Native Address </div></td>'+
            				'<td colspan="2"><div align="center" >VISA Type </div></td>'+
							
            			  '</tr>'+
            			  '<tr>'+
            				
            				
            				'<td colspan="2"><div align="center" >'+d.employee_address+' </div></td>'+
            				'<td colspan="2"><div align="center" >'+d.native_address+' </div></td>'+
            				'<td colspan="2"><div align="center" >'+d.visa_type+'</div></td>'+
            				
            			  '</tr>'+
            			  
            			'</table>' ;
                        			
		
		
	            }
	            
	            
	             function load_data_to_grid_employees_visa_details_list_search(search_date_visa)
                 {
                     
                    v_list_of_employees_visa_table.destroy();
                         
                     v_list_of_employees_visa_table = $('#list_of_visa_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/expiry/expiry_controller.php',
                                 'data': {
                                    action: 'employee_visa_expire_list_search',
                                    search_date_visa:search_date_visa
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
                                    { type: 'date-eu', targets: 6 }
                             ],
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "employee_id","visible":false },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                 { "data": "employee_code"},
                                 { "data": "visa_validity_on_format"},
                                
                                 { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          return '<div align="center"><img src=../httpdocs/images/employee_image/'+$.trim(data)+' class="rounded-circle" height="40px" width="40px"/></div>';
            
            							 },
                                 },
                                
                                 
                                 { "data": "employee_status",
                                      render: function ( data, type, rows, meta ) {
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['visa_validity_on'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          }
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['visa_validity_on']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                  { "data": "employee_status",
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
	            
                 function load_data_to_grid_employees_visa_details_list()
                 {
                     
                    v_list_of_employees_visa_table.destroy();
                         
                     v_list_of_employees_visa_table = $('#list_of_visa_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/expiry/expiry_controller.php',
                                 'data': {
                                    action: 'employee_visa_expire_list_view'
                                    
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
                                    { type: 'date-eu', targets: 6 }
                             ],
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 },
                                 
                                 { "data": null},
                                 { "data": "employee_id","visible":false },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                 { "data": "employee_code"},
                                 { "data": "visa_validity_on_format"},
                                
                                 { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          return '<div align="center"><img src=../httpdocs/images/employee_image/'+$.trim(data)+' class="rounded-circle" height="40px" width="40px"/></div>';
            
            							 },
                                 },
                                
                                 
                                 { "data": "employee_status",
                                      render: function ( data, type, rows, meta ) {
                                            var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['visa_validity_on'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          }
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['visa_validity_on']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
            
            							 },
                                 },
                                  { "data": "employee_status",
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
                             
                            // "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8] }, 
            					
            				//],
                            
            				
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
                 
                  $('#list_of_visa_employees tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_employees_visa_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_employees_visa(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
        
                 function format_employees_visa(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Contact Number </div></td>'+
            				
            				'<td ><div align="center">Email </div></td>'+
            				'<td ><div align="center">Expertise Name </div></td>'+
            				'<td ><div align="center">Native Number </div></td>'+
            				'<td ><div align="center">Blood Group </div></td>'+
            				'<td ><div align="center">CPR Number </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.employee_contact_no+'</div></td>'+
            				
            				'<td><div align="center">'+d.employee_email_id+'</div></td>'+
            				'<td><div align="center">'+d.expertise_name+'</div></td>'+
            			    '<td><div align="center">'+d.native_number+'</div></td>'+
            				'<td><div align="center">'+d.blood_group+'</div></td>'+
            				'<td><div align="center">'+d.cpr_no+'</div></td>'+
            				
            				
            			  '</tr>'+
            			  
            			  
            			  
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            				'<td ><div align="center">Passport Number </div></td>'+
            				'<td ><div align="center">Joining Date </div></td>'+
            				'<td ><div align="center">CPR Expiry Date </div></td>'+
            				'<td ><div align="center">Visa Validity </div></td>'+
            				'<td ><div align="center">Driving Licence </div></td>'+
            				'<td ><div align="center">Technician Type </div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.passport_no+'</div></td>'+
            				'<td><div align="center">'+d.joining_date+' </div></td>'+
            				'<td><div align="center">'+d.cpr_expiry_date+'</div></td>'+
            				'<td><div align="center">'+d.visa_validity_on+'</div></td>'+
            				'<td><div align="center">'+d.is_driving_license+'</div></td>'+
            				'<td><div align="center">'+d.technician_type+'</div></td>'+
            				
            				
            			  '</tr>'+
            			  
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			    
            				
            			
            				'<td colspan="2"><div align="center" >Employee Address </div></td>'+
            				'<td colspan="2"><div align="center" >Native Address </div></td>'+
            				'<td colspan="2"><div align="center" >VISA Type </div></td>'+
							
            			  '</tr>'+
            			  '<tr>'+
            				
            				
            				'<td colspan="2"><div align="center" >'+d.employee_address+' </div></td>'+
            				'<td colspan="2"><div align="center" >'+d.native_address+' </div></td>'+
            				'<td colspan="2"><div align="center" >'+d.visa_type+'</div></td>'+
            				
            			  '</tr>'+
            			  
            			'</table>' ;
                        			
		
		
	            }
	            
	            
	            
	            
 
                  

});