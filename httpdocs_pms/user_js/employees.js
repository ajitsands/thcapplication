$(document).ready(function(){
  var v_user_type_id,v_user_type_name,v_emp_code,v_employee_id,v_session_image,randomNum,v_employee_status,v_expertise_id=[],v_expertise_name=[],checked_val;
            var v_item_img;         
                    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    
                    $('#btn_employee_edit').hide();
                    $('#btn_employee_new').hide();
                    $('#error_email').hide();
                    $("#div_expertise_select").hide();
                    $("#div_select_emp_tech_type").hide();
                    
                     
                    var v_btn_employee_add = $('#btn_employee_add').ladda();
                    var v_btn_employee_edit = $('#btn_employee_edit').ladda();
                    var v_btn_employee_new = $('#btn_employee_new').ladda();
                 
                    var v_list_of_employees_table = $('#list_of_employees').DataTable({});
                      load_data_to_grid_employees_details_list();
                     //check email
                    //   $("#txt_emp_email_id").blur(function(){
                    //   var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                    //   var valueToTest=$("#txt_emp_email_id").val();
                    //         if (testEmail.test(valueToTest))
                    //         {
                    //         return true;
                    //         }
                                
                    //         else
                    //         {
                               
                    //             return false;
                    //         }
                                                 
                    // });
  
                      //check the employee code
                    
                    /*   $("#txt_emp_code").blur(function(){
                          var emp_code_check=$("#txt_emp_code").val();
    					   $.post("../controller/employees/employees_controller.php",{action:'employee_code_check',v_employee_code:emp_code_check }
                                    , function(result,status)
                                    {
                                        if (result==1)
                                        {
                                        swal("Error", "Employee code already exist", "warning");
                                        $("#txt_emp_code").val('');
                                            return false;
                                        }
                                            
                                        else
                                        {
                                            return true;
                                        }
    						});
                                                 
                    });*/
                           
                                    
                //start date validation
                
                /*$('#emp_joining_date, #emp_cpr_expiry_date, #emp_visa_validity').formatter({
                    'pattern': '{{99}}/{{99}}/{{9999}}',
                  });
                  $('#txt_date, #txt_search_date').blur(function(){
                    vailddate($(this).val(),this.id);
                  });
                 
                  function vailddate(sub_date,ctrl)
                  {
                      var newdate = sub_date.split("/");
                      var ctrl_name='#'+ctrl;
                      if(newdate[1]>12 || newdate[0]>31 || newdate[2].toString().length!=4 || newdate[2]<1900)
                      {
                        swal("Warning",'Date is not vaild ....', "warning");
                        $(ctrl_name).val('');
                   
                        return false;
              
                      }
                      else{
                          if(!(newdate[2] % 4 || !(newdate[2] % 100) && newdate[2] % 400)==false && newdate[0]>28 && newdate[1]=='02')
                          {
                            swal("Warning",'Date is not vaild ....', "warning");
                            $(ctrl_name).val('');
                           
                            return false;
                           }
                           else
                           if(!(newdate[2] % 4 || !(newdate[2] % 100) && newdate[2] % 400)==true && newdate[0]>29 && newdate[1]=='02'){
                            swal("Warning",'Date is not vaild ....', "warning");
                            $(ctrl_name).val('');
                            return false;
                           }
                           
              
                      }
                  }*/
                
                //end date validation
                    
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
                 // var v_expertise_id=[];
                 // var v_expertise_name=[];
              
                      $('#select_expertise').on('select2:select', function (e) {
                        
                         var data = e.params.data;
                          
                       
                         expertise_id= data.id;
                         v_expertise_name= $('#select_expertise option:selected') .toArray().map(item => item.text);
                         v_expertise_id = $('#select_expertise option:selected') .toArray().map(item => item.value);
                        
                        
                       
                        });
                $('#session_image').change(function (e) {
         
                 
                v_item_img = $("#session_image").val();
                var  randomNum = Math.ceil(Math.random() * 999999);
                    if(v_item_img=="")
                {
                    v_item_img="default.jpg";
                }
                else
                {
                    var doc_file_obj = $("#session_image")[0].files[0];
                    var upload = new ns.Upload(doc_file_obj);
                    var doc_file1= doc_file_obj.name;
                    v_item_img=$.trim(randomNum+'_'+doc_file1);
					//alert(v_item_img);
                    var success = upload.doUpload("../../httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum,v_item_img);

                }  
        });   
               
            //          $('#session_image').change(function (e) {
                         
            //                 v_session_image = $("#session_image").val();
            //                 randomNum = Math.ceil(Math.random() * 999999);
            //                 if(v_session_image=="")
            //             {
            //                 v_session_image="default.jpg";
            //             }
            //             else
            //             {
            //                 var doc_file_obj = $("#session_image")[0].files[0];
            //                 var upload = new ns.Upload(doc_file_obj);
            //                 doc_file1= doc_file_obj.name;
            //                  v_session_image=$.trim(randomNum+'_'+doc_file1);
            //                 var success = upload.doUpload("https://thc.sianlab.com/httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum);
            //             }  
            //   });
              
                    
                    
                     $('input[type="checkbox"]').click(function(){
                        if($(this).prop("checked") === true)
                        {
                            checked_val='Yes';
                        }
                    
                        else 
                        {
                         checked_val='No';
                        }
                 });
                        
            // Insert employee details....
 
                v_btn_employee_add.click(function(){
                    v_btn_employee_add.ladda( 'start' );
                    v_emp_name=$("#txt_emp_name").val();
                    //v_emp_code=$("#txt_emp_code").val();
                    var v_emp_pwd=$("#txt_emp_password").val();
                    var v_emp_contact_no=$("#txt_emp_contact_no").val();
                    var v_emp_email_id=$("#txt_emp_email_id").val();
                    var v_emp_address=$("#txt_emp_address").val();
                    v_session_image = $("#session_image").val();
                    randomNum = Math.ceil(Math.random() * 999999);   
                    v_expertise_id=$('#select_expertise option:selected') .toArray().map(item => item.value);
                    v_expertise_name=$('#select_expertise option:selected') .toArray().map(item => item.text);
                    var v_emp_tech_type_id=$("#select_emp_tech_type option:selected").val();
                    var v_emp_tech_type_name=$("#select_emp_tech_type option:selected").text()
                    var v_emp_blood_group=$("#select_employee_blood_group option:selected").val();
                    var v_emp_cpr_number=$("#txt_cpr_no").val();
                    var v_emp_passport_no=$("#txt_emp_passport_no").val();
                    var v_emp_joining_date=$("#emp_joining_date").val();
                    var v_emp_visa_validity=$("#emp_visa_validity").val();
                    var v_emp_cpr_expiry_date=$("#emp_cpr_expiry_date").val();
                    
                    var v_emp_native_no=$("#txt_emp_native_no").val();
					var v_emp_native_address=$("#txt_emp_native_address").val();
					var v_emp_visa_type=$("#select_employee_visa_type option:selected").val();
                   
                     if(v_emp_email_id!="")
                    {
                      var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                      var valueToTest=$("#txt_emp_email_id").val();
                            if (testEmail.test(valueToTest))
                            {
                           // return true;
                            
                            }
                                
                            else
                            {
                                swal("Error", "Please enter valid Email", "warning");
                                v_btn_employee_add.ladda( 'stop' );
                               $("#txt_emp_email_id").val("");
                               return false;
                            }
                                                 
                     }
                    
                     if( v_emp_tech_type_id=='select')
                         {
                           
                            v_emp_tech_type_name='NA'
                         
                         }
                         
                         if( v_expertise_id=='select')
                         {
                            v_expertise_id=0;
                            v_expertise_name='NA'
                         
                         }
                        v_session_image = $("#session_image").val();
                      
                            randomNum = Math.ceil(Math.random() * 999999);
                            if(v_session_image==="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                            upload.doUpload("../httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum);
                            v_session_image=$.trim(randomNum+'_'+doc_file1);
                        }  
                    //alert(v_session_image);
                    if($.trim(v_emp_name)===""||$.trim(v_emp_pwd)===""||typeof v_user_type_id === "undefined"||$.trim(v_emp_contact_no)===""|| typeof v_expertise_id === "undefined"||v_emp_joining_date===""||v_emp_visa_validity===""||v_emp_cpr_expiry_date===""||v_emp_passport_no==="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_employee_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {     
                       
                         $.post("../controller/employees/employees_controller.php",{action:'add_employee',v_employee_name:v_emp_name,v_employee_type_id:v_user_type_id,v_employee_type_name:v_user_type_name,v_employee_password:v_emp_pwd,v_employee_contact_no:v_emp_contact_no,v_employee_email_id:v_emp_email_id,v_employee_address:v_emp_address,v_employee_image:v_session_image,v_expertise_id:v_expertise_id,v_expertise_name:v_expertise_name,v_emp_cpr_number:v_emp_cpr_number,v_emp_blood_group:v_emp_blood_group,v_emp_passport_no:v_emp_passport_no,v_emp_joining_date:v_emp_joining_date,v_emp_cpr_expiry_date:v_emp_cpr_expiry_date,v_emp_visa_validity:v_emp_visa_validity,v_checked_val:checked_val,v_emp_tech_type_name:v_emp_tech_type_name,v_emp_native_no:v_emp_native_no,v_emp_native_address:v_emp_native_address,v_emp_visa_type:v_emp_visa_type}
                                , function(result,status)
                                {
                                   console.log(result);
                                result = $.trim(result);
                               
                                if(result=="")
                                {
                                    v_btn_employee_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                    
                                   
                                    v_btn_employee_add.ladda( 'stop' );
                                     swal("Success", "New employee added successfully..", "success");
                                     load_data_to_grid_employees_details_list();
                                     clear_text();
                                     location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                //load data to employeegrid
                 function load_data_to_grid_employees_details_list()
                 {
                     
                    v_list_of_employees_table.destroy();
                         
                     v_list_of_employees_table = $('#list_of_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/employees/employees_controller.php',
                                 'data': {
                                    action: 'employee_list_view'
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                // {
                                //     "className":  'details-control',
                                //     "orderable":  false,
                                //     "data":        null,
                                //     "defaultContent": '',
                                    
                                //  },
                                 
                                 { "data": null},
                                   { "data": "employee_id",
                                      render: function ( data, type, rows, meta ) {
                                        //   str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a><a href="#" class="dropdown-item" name="view_employee" style="color:blue"><i class="icon-book2"></i> View</a></div></div></div>';
                                           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 },
                                 
                                 { "data": "employee_id","visible":false },
                                 { "data": "employee_name" },
                                  { "data": "employee_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
                                 { "data": "employee_type_name"},
                                 
                                 { "data": "employee_contact_no"},
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
                                 },
                                 
                               
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
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
                 
                   $('#list_of_employees tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var emp_data = v_list_of_employees_table.row($row).data();
                        v_employee_id  = emp_data.employee_id;
                         v_employee_status  = emp_data.employee_status;
                         if($(this).attr("name")=='Edit_Employee')
                         {
                         
                            edit_employee_details(v_employee_id);
                            $( '#div_emp_code').show();
            			    $( '#btn_employee_add').hide();
                            $( '#btn_employee_edit').show();
                            $( '#btn_employee_new').show();
               
            			 }
            			 if($(this).attr("name")=='view_employee')
                         {
                           window.open("reports/employee_details.php?employee_id="+v_employee_id,"_blank","width=850, height=550");
            			 }
            			 
            			 
            			  function edit_employee_details(v_employee_id)
                            {
                                $("#txt_emp_id").val(v_employee_id);  
                                $("#txt_emp_name").val(emp_data.employee_name);
                                $("#txt_emp_code").val(emp_data.employee_code);
                                $("#txt_emp_password").val(emp_data.employee_password);
                                $("#txt_emp_contact_no").val(emp_data.employee_contact_no);
                                $("#txt_emp_email_id").val(emp_data.employee_email_id);
                                $("#txt_emp_address").val(emp_data.employee_address);
                                $("#txt_cpr_no").val(emp_data.cpr_no);  
                                $("#select_employee_blood_group").val($.trim(emp_data.blood_group)).trigger('change');
                                $("#txt_emp_passport_no").val(emp_data.passport_no);
                                $("#emp_joining_date").val(emp_data.joining_date);
                                console.log(emp_data.joining_date);
                                $("#emp_visa_validity").val(emp_data.visa_validity_on);
                                $("#emp_cpr_expiry_date").val(emp_data.cpr_expiry_date);
                                
                                $("#txt_emp_native_no").val(emp_data.native_number);
								$("#txt_emp_native_address").val(emp_data.native_address);
								$("#select_employee_visa_type").val($.trim(emp_data.visa_type)).trigger('change');
                                
                                var chk_val=emp_data.is_driving_license;
                                   if($.trim(chk_val)=='Yes')
                                   {
                                       $("#chk_driving").prop("checked", true);
                                      
                                   }

                                $("#select_emp_tech_type").val($.trim(emp_data.technician_type)).trigger('change');
                                $("#img_preview").html("<img style='width:60px;height:60px;'src='../httpdocs/images/employee_image/"+$.trim(emp_data.employee_image)+"'>");
                                $('#emp_img_name').text(emp_data.employee_image);
                                $("#select_employee_type").val($.trim(emp_data.employee_type_id)).trigger('change');
                                if(emp_data.employee_type_name=='Technician')
                                    {
                                            $.post("../controller/employees/employees_controller.php",{action:'select_expertise_names',v_employee_id:v_employee_id }
                                            , function(result,status)
                                                 {

                                                    var obj= jQuery.parseJSON(result);
                                                    var datalength=obj.data.length;
                                                    for(i=0;i<datalength;i++)
                                                    {
                                                         var empSelect = $('#select_expertise');
                                                        var exper_name=obj.data[i].expertise_name;
                                                        var exper_id=obj.data[i].expertise_id;
                                                        
                                                         var option = new Option(exper_name, exper_id, true, true);
                                                        empSelect.append(option).trigger('change');
                                                    }

                                                });      
                                    }
                                   
                            }
                            
                             if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
                         {
                             var v_employee_action=$(this).attr("name");
                             $.post("../controller/employees/employees_controller.php",{action:'change_employee_status',v_employee_id:v_employee_id,v_employee_status:v_employee_status,v_employee_action:v_employee_action}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_employees_details_list();
                                
                            });
                        }
                          
                        
        });
       
                 
                //   $('#list_of_employees tbody').on('click', 'td.details-control', function () {
                //     var tr = $(this).closest('tr');
                //     var row = v_list_of_employees_table.row( tr );
                   
                //     if ( row.child.isShown() ) {
                //         // This row is already open - close it
                //         row.child.hide();
                //         tr.removeClass('shown');
                //     }
                //     else {
                //         // Open this row
                //         row.child( format_employees(row.data()) ).show();
                //         tr.addClass('shown');
                       
                         
                //     }
                // } );
        
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
            				'<td><div align="center">'+d.joining_date_format+' </div></td>'+
            				'<td><div align="center">'+d.cpr_expiry_date_format+'</div></td>'+
            				'<td><div align="center">'+d.visa_validity_on_format+'</div></td>'+
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
	             // Edit employee details....
 
                v_btn_employee_edit.click(function(){
                    
                    v_btn_employee_edit.ladda( 'start' );
                    var v_emp_name=$("#txt_emp_name").val();
                    var v_employee_id= $("#txt_emp_id").val(); 
                    var v_emp_code=$("#txt_emp_code").val();
                    var v_emp_pwd=$("#txt_emp_password").val();
                    var v_emp_contact_no=$("#txt_emp_contact_no").val();
                    var v_emp_email_id=$("#txt_emp_email_id").val();
                    var v_emp_address=$("#txt_emp_address").val();
                    v_session_image = $("#session_image").val();
                    var v_session_image_new = $("#emp_img_name").text();
                    var randomNum = Math.ceil(Math.random() * 999999);   
                    v_expertise_id=$('#select_expertise option:selected') .toArray().map(item => item.value);
                    v_expertise_name=$('#select_expertise option:selected') .toArray().map(item => item.text);
                    
                    
                     var v_emp_tech_type_id=$("#select_emp_tech_type option:selected").val();
                    var v_emp_tech_type_name=$("#select_emp_tech_type option:selected").text()
                    var v_emp_blood_group=$("#select_employee_blood_group option:selected").val();
                    
                    var v_emp_cpr_number=$("#txt_cpr_no").val();
                    
                    var v_emp_passport_no=$("#txt_emp_passport_no").val();
                    var v_emp_joining_date=$("#emp_joining_date").val();
                    var v_emp_visa_validity=$("#emp_visa_validity").val();
                    var v_emp_cpr_expiry_date=$("#emp_cpr_expiry_date").val();
                    
                    var v_emp_native_no=$("#txt_emp_native_no").val();
					var v_emp_native_address=$("#txt_emp_native_address").val();
					var v_emp_visa_type=$("#select_employee_visa_type option:selected").val();
                    
                    var chk_val = document.getElementById("chk_driving");
                        if (chk_val.checked) {
                            checked_val='Yes';
                        } else {
                            checked_val='No';
                        }
                                   
                     if(v_expertise_id=='')
                     {
                        v_expertise_id=0;
                        v_expertise_name='NA'
                     
                     }
                  // alert(v_session_image+'session val'+v_session_image_new+'new val');
                     if(v_session_image=="" && v_session_image_new!="")
                        {
                            v_session_image=v_session_image_new;
                           
                            
                        }
                        else if(v_session_image=="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                            upload.doUpload("../httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum);
                            v_session_image=randomNum+'_'+doc_file1;
                        }  
                    if($.trim(v_emp_name)==""||v_emp_pwd==""||v_user_type_id=="select"||v_emp_contact_no=="")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_employee_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/employees/employees_controller.php",{action:'update_employee',v_employee_name:v_emp_name,v_employee_type_id:v_user_type_id,v_employee_type_name:v_user_type_name,v_employee_password:v_emp_pwd,v_employee_contact_no:v_emp_contact_no,v_employee_email_id:v_emp_email_id,v_employee_address:v_emp_address,v_employee_image:v_session_image,v_expertise_id:v_expertise_id,v_expertise_name:v_expertise_name,v_employee_id:v_employee_id,v_emp_cpr_number:v_emp_cpr_number,v_emp_blood_group:v_emp_blood_group,v_emp_passport_no:v_emp_passport_no,v_emp_joining_date:v_emp_joining_date,v_emp_cpr_expiry_date:v_emp_cpr_expiry_date,v_emp_visa_validity:v_emp_visa_validity,v_checked_val:checked_val,v_emp_tech_type_name:v_emp_tech_type_name,v_emp_native_no:v_emp_native_no,v_emp_native_address:v_emp_native_address,v_emp_visa_type:v_emp_visa_type,v_employee_code:v_emp_code}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_employee_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     v_btn_employee_edit.ladda( 'stop' );
                                     swal("Success", "Employee details updated successfully..", "success");
                                     load_data_to_grid_employees_details_list();
                                    clear_text();
                                    
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                
                 $( '#btn_employee_new' ).click(function(){
                  
                        $( '#btn_employee_add' ).show();
                        $( '#div_emp_code').hide();
                        $( '#btn_employee_edit' ).hide();
                        $( '#btn_employee_new' ).hide();
                        clear_text();
                    })
            
                //function clear text
                   function clear_text()
                 {
                   // $( "#select_employee_type" ).val('').trigger('change');
                    $("#select_expertise").val(null).trigger("change");
                    $("#select_employee_type").val(null).trigger("change");
                    $("#txt_emp_id").val('');
                    $("#txt_emp_name").val('');
                    $("#txt_emp_code").val('');
                    $("#txt_emp_password").val('');
                    $("#txt_emp_contact_no").val('');
                    $("#txt_emp_email_id").val('');
                    $("#txt_emp_address").val('');
                    $("#session_image").val(null);
                    $("#emp_img_name").empty()
                    $("#img_preview").hide()
                    $("#select_employee_blood_group").val(null).trigger("change");
                    $("#select_emp_tech_type").val(null).trigger("change");
                    $("#txt_cpr_no").val('');
                    $("#txt_emp_passport_no").val('');
                    $("#emp_joining_date").val('');
                    $("#emp_visa_validity").val('');
                    $("#emp_cpr_expiry_date").val('');
                    $("#chk_driving").prop('checked', false);
                    
                    $("#txt_emp_native_no").val('');
					$("#txt_emp_native_address").val('');
					$("#select_employee_visa_type").val(null).trigger("change");
                 }
                  

});