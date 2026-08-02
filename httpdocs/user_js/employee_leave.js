$(document).ready(function(){
    var start_date,end_date;
                    
    var v_btn_employee_leave_add = $('#btn_employee_leave_add').ladda();
     $("#div_reason_for_leave").hide();              
                 
            var v_list_of_employees_on_leave_table = $('#list_of_employees_on_leave').DataTable({});
                      load_data_to_grid_employees_on_leave_list();
                 
                 
                $("#div_reason_select").change(function(){
                
                        var v_reason_id=$("#select_reason_for_leave option:selected").val();
                        var v_emp_details=$("#select_employee_for_leave option:selected").text();
                        v_emp_details=v_emp_details.split("-");
                        var v_emp_code=$.trim(v_emp_details[0]);
                        var v_emp_name=v_emp_details[1];
                          if(v_reason_id=='add_reason')
                          {
                              
                             $('#div_reason_for_leave').show(); 
                             
                          }
                        
            
                });
                    
                 
                 $('#txt_leave_from_date').change(function (e) {
             
                        start_date = $("#txt_leave_from_date").val();
                       
                        var today = new Date();
                        //console.log(today);
                        var dd = today.getDate();
                        var mm = today.getMonth()+1; //As January is 0.
                        var yyyy = today.getFullYear();
                        if(dd<10) 
                        {
                            dd='0'+dd;
                        }
                        if(mm<10) 
                        {
                            mm='0'+mm;
                        }
                        var today_date=dd+'-'+mm+'-'+yyyy;
                        var today_date_base_form=yyyy+'-'+mm+'-'+dd;
                        if(start_date < today_date_base_form)
                        {
                            
                             swal("Warning","Please select a date after today's date ....", "warning");
                              $('#txt_leave_from_date').val("");
                               
                        }
                 });         
              
                $('#txt_leave_to_date').change(function (e) {  
                    
                     
                     end_date =$("#txt_leave_to_date").val();
                    
                    if(end_date < start_date)
                            {
                                
                                 swal("Warning","Please select a date after start date ....", "warning");
                                  $('#txt_leave_to_date').val("");
                                   
                            }
                    
                });       
            // Insert employee details....
 
                v_btn_employee_leave_add.click(function(){
                    v_btn_employee_leave_add.ladda( 'start' );
                   // v_emp_id=$("#select_employee_for_leave option:selected").val();
                    var v_emp_details=$("#select_employee_for_leave option:selected").text();
                    v_emp_details=v_emp_details.split("-");
                    var v_emp_code=$.trim(v_emp_details[0]);
                    var v_emp_name=v_emp_details[1];
                    start_date = $("#txt_leave_from_date").val();
                    end_date =$("#txt_leave_to_date").val();
                    var type_of_leave =$("#select_type_of_leave option:selected").text();
                    var v_reason_id=$("#select_reason_for_leave option:selected").val();
                    if(v_reason_id=='add_reason')
                          {
                              
                             var reason_for_leave =$("#txt_reason_for_leave").val(); 
                             
                          }
                          else
                          {
                            var reason_for_leave =$("#select_reason_for_leave option:selected").text();
                          }
                   
                    if((typeof start_date === 'undefined')||(typeof end_date === 'undefined')|| reason_for_leave===""||v_emp_name==="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_employee_leave_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {        
                        
                        
                        
                        
                         $.post("../controller/employee_leave/employee_leave_controller.php",{action:'add_leave_for_employee',v_employee_code:v_emp_code,v_employee_name:v_emp_name,start_date:start_date,end_date:end_date,type_of_leave:type_of_leave,reason_for_leave:reason_for_leave}
                                , function(result,status)
                                {
                                  console.log(result);
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_employee_leave_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     v_btn_employee_leave_add.ladda( 'stop' );
                                     swal("Success", "Employee leave added successfully..", "success");
                                     load_data_to_grid_employees_on_leave_list();
                                     clear_text();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                //load data to employeegrid
                 function load_data_to_grid_employees_on_leave_list()
                 {
                     
                    v_list_of_employees_on_leave_table.destroy();
                         
                     v_list_of_employees_on_leave_table = $('#list_of_employees_on_leave').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/employee_leave/employee_leave_controller.php',
                                 'data': {
                                    action: 'employee_on_leave_list'
                                    
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
                                 { "data": null},
                                 { "data": "employee_code"},
                                 { "data": "employee_name" },
                                 { "data": "leave_reason"},
                                 { "data": "start_time"},
                                 { "data": "end_time" },
                                 { "data": "employee_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                         // str_active_status='<span class="badge badge-success">'+data+'</span>';
                                         //str_active_status='<button type="button" id="btn_employee_status_change" class="btn btn-primary btn-sm"><b>Deactive</b></button>';
                                         str_active_status='<a href="#" class="dropdown-item" name="btn_employee_status_change" id="btn_employee_status_change" style="color:orange"><i class="icon-database-remove mr-3 icon-2x"></i></a>';
                                         	

    								 
                                     	return str_active_status;
            
            							 }
                                 }
                                 
                                
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6] }, 
            					
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
                 
                  $('#list_of_employees_on_leave tbody').on('click', 'td a', function(){
                        var $row = $(this).closest('tr');
                        var emp_data = v_list_of_employees_on_leave_table.row($row).data();
                        employee_code  = emp_data.employee_code;
                        
                        
                        swal({
                                
    							title: "Are you sure?",
    							text: "Do you want to mark the employee back to work ?",
    							icon: 'warning',
    							dangerMode: true,
    							allowOutsideClick: false,
                                closeOnClickOutside: false,
    							buttons: {
    							  cancel: 'No Cancel !',
    							  delete: 'Yes Proceed'
    							}
    							}).then(function (willDelete) {
    							if (willDelete) {
    						
    						       $.post("../controller/employee_leave/employee_leave_controller.php",{action:'change_employee_leave_status',v_employee_code:employee_code}
                                , function(result,status)
                                {
                                   
                                  load_data_to_grid_employees_on_leave_list();
                                
                                });
                 						 
    							} else {
    							    
    							   
    							 
    							}
    						 });
                          
                         //var v_employee_action=$(this).attr("name");
                            //  $.post("../controller/employee_leave/employee_leave_controller.php",{action:'change_employee_leave_status',v_employee_code:employee_code}
                            //     , function(result,status)
                            //     {
                                   
                            //       load_data_to_grid_employees_on_leave_list();
                                
                            // });
                        
                          
                        
        });
       
            
                //  $( '#btn_employee_new' ).click(function(){
                  
                //         $( '#btn_employee_leave_add' ).show();
                        
                //         clear_text();
                //     })
            
                // //function clear text
                  function clear_text()
                     {
                       
                        $("#txt_leave_from_date").val("");
                        $("#txt_leave_to_date").val("");
                        $("#select_employee_for_leave").val(null).trigger("change");
                        $("#select_type_of_leave").val(null).trigger("change");
                        $("#select_reason_for_leave").val(null).trigger("change");
                       
                     }
                  

        
});