$(document).ready(function(){
  
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
        var v_expertise_name;
        var v_expertise_id = [];
        $("#div_expertise_select").hide();
        $("#div_select_emp_tech_type").hide();
        
         
         
        var v_btn_employee_search = $('#btn_employee_search').ladda();
       
     
        var v_list_of_employees_table = $('#list_of_employees').DataTable({});
                   
                   
                    $('#btn_employee_search').click(function (e) {
                           
                        v_employee_type_id=$("#select_employee_type option:selected").val();
                        v_user_type_name=$("#select_employee_type option:selected").text() ;
                        v_emp_tech_type_name="";
                        if(v_user_type_name=='Technician')
                            {
                                v_emp_tech_type_name=$("#select_emp_tech_type option:selected").val();
                                
                                
                            }  
                            
                        load_data_to_grid_employees_details_list(v_employee_type_id,v_emp_tech_type_name,v_expertise_id);
                    });
                
               
                    $('#btn_employee_download').click(function (e) {
                        
                        employee_type_id=$("#select_employee_type option:selected").val();
                        employee_type_name=$("#select_employee_type option:selected").text() ;
                        emp_tech_type_name="";
                        if(employee_type_name=='Technician')
                            {
                                emp_tech_type_name=$("#select_emp_tech_type option:selected").val();
                                
                                
                            } 
                        window.open("employee_list.php?v_employee_type_id="+employee_type_id+"&v_emp_tech_type_name="+emp_tech_type_name+"&v_expertise_id="+v_expertise_id,"_blank");  
                        
                    });
                    
                     $('#select_employee_type').change(function (e) {
                         
                            v_user_type_id=$("#select_employee_type option:selected").val();
                            v_user_type_name=$("#select_employee_type option:selected").text()
                            //console.log(v_user_type_name);
                            if(v_user_type_name=='Technician')
                            {
                                 $("#div_expertise_select").show();
                                 $("#div_select_emp_tech_type").show();
                            }
                            else
                            {
                                $("#div_expertise_select").hide();
                                $("#div_select_emp_tech_type").hide();
                            }
                    });
              
                      $('#select_expertise').on('select2:select', function (e) {
                        
                         var data = e.params.data;
                          
                       
                         expertise_id= data.id;
                         //v_expertise_id = $('#select_expertise option:selected') .toArray().map(item => item.value);
                         v_expertise_id = $('#select_expertise option:selected') .toArray().map(item => item.value).join(', ');
                        
                       
                        });
                        
                
                       
           
              
                 function load_data_to_grid_employees_details_list(v_employee_type_id,v_emp_tech_type_name,v_expertise_id)
                 {
                     var i=1;
                    v_list_of_employees_table.destroy();
                         
                     v_list_of_employees_table = $('#list_of_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/employees/employees_report_controller.php',
                                 'data': {
                                    action: 'employee_list_view',
                                    v_employee_type_id:v_employee_type_id,
                                    v_emp_tech_type_name:v_emp_tech_type_name,
                                    v_expertise_id:v_expertise_id
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 1, "asc" ]],
                           
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
                                 
                                 { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 { "data": "employee_id","visible":false },
                                   { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='default.jpg')
                                          {
                                             return '<div align="center"><img src="../httpdocs/images/employee_image/'+data+'" class="rounded-circle" height="30px" width="30px"/></div>';
             
                                          }
                                          else
                                          {
                                              return '<div align="center"><img src="../httpdocs/images/employee_image/'+data+'" class="rounded-circle" height="50px" width="50px"/></div>';
            
                                          }
                                         
            							 },
                                 },
                                { "data": "employee_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                 { "data": "employee_contact_no"},
                                 { "data": "cpr_no"},
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
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8,9] }, 
            					
            				],
                            
            				
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
                 
               
                 
                  $('#list_of_employees tbody').on('click', 'td.details-control', function () {
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
            				
            				'<td ><div align="center">Email Id</div></td>'+
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
            				'<td ><div align="center">Date of Join </div></td>'+
            				'<td ><div align="center">CPR Expiry Date </div></td>'+
            				'<td ><div align="center">Visa Validity Upto </div></td>'+
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