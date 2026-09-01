$(document).ready(function(){
  var v_user_type_id,v_user_type_name,v_emp_code,v_employee_id,v_session_image,randomNum,v_employee_status,v_expertise_id=[],v_expertise_name=[],checked_val;
            var v_item_img;         
                    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                    
                    // Fetch active employees for leave dropdown
                    $.ajax({
                        url: '../controller/employees/employees_controller.php',
                        type: 'POST',
                        data: { action: 'fetch_active_employees' },
                        success: function(response) {
                            try {
                                var employees = JSON.parse(response);
                                var $select = $('#leave_emp_name');
                                $select.empty().append('<option value=""></option>');
                                $.each(employees, function(i, emp) {
                                    $select.append($('<option>', {
                                        value: emp.employee_name,
                                        text: emp.employee_name,
                                        'data-id': emp.employee_id,
                                        'data-code': emp.employee_code
                                    }));
                                });
                            } catch (e) {
                                console.error("Error parsing employees JSON:", e);
                            }
                        }
                    });
                    
                    $('#leave_emp_name').on('change', function() {
                        var selectedOption = $(this).find('option:selected');
                        $('#leave_emp_id').val(selectedOption.data('id'));
                        $('#leave_emp_code').val(selectedOption.data('code'));
                    });

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
              
                      $('#select_expertise').on('change select2:select select2:unselect', function (e) {
                         v_expertise_name = $('#select_expertise option:selected').toArray().map(item => item.text);
                         v_expertise_id = $('#select_expertise option:selected').toArray().map(item => item.value);
                      });
                 var v_session_image = "default.jpg";
                 var v_session_image_new = "";

                 $('#session_image').change(function (e) {
                     var fileInput = $("#session_image")[0];
                     if (fileInput && fileInput.files && fileInput.files[0]) {
                         var doc_file_obj = fileInput.files[0];
                         var randomNum = Math.ceil(Math.random() * 999999);
                         var clean_name = doc_file_obj.name.replace(/[^a-zA-Z0-9._-]/g, '_');
                         v_session_image = $.trim(randomNum + '_' + clean_name);

                         var reader = new FileReader();
                         reader.onload = function(evt) {
                             $("#img_preview").show().html("<img style='width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='" + evt.target.result + "'>");
                         };
                         reader.readAsDataURL(doc_file_obj);

                         var upload = new ns.Upload(doc_file_obj);
                         upload.doUpload("../httpdocs/user_upload/employee_image_upload.php?random_no=" + randomNum, v_session_image);
                     } else {
                         v_session_image = "default.jpg";
                         $("#img_preview").empty().hide();
                     }
                 });
              
                    
                    
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
                     var v_emp_image_to_save = (v_session_image && v_session_image !== "" && v_session_image.indexOf("fakepath") === -1) ? v_session_image : "default.jpg";
                    if($.trim(v_emp_name)===""||$.trim(v_emp_pwd)===""||typeof v_user_type_id === "undefined"||$.trim(v_emp_contact_no)===""|| typeof v_expertise_id === "undefined"||v_emp_joining_date===""||v_emp_visa_validity===""||v_emp_cpr_expiry_date===""||v_emp_passport_no==="")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_employee_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {     
                       
                         $.post("../controller/employees/employees_controller.php",{action:'add_employee',v_employee_name:v_emp_name,v_employee_type_id:v_user_type_id,v_employee_type_name:v_user_type_name,v_employee_password:v_emp_pwd,v_employee_contact_no:v_emp_contact_no,v_employee_email_id:v_emp_email_id,v_employee_address:v_emp_address,v_employee_image:v_emp_image_to_save,v_expertise_id:v_expertise_id,v_expertise_name:v_expertise_name,v_emp_cpr_number:v_emp_cpr_number,v_emp_blood_group:v_emp_blood_group,v_emp_passport_no:v_emp_passport_no,v_emp_joining_date:v_emp_joining_date,v_emp_cpr_expiry_date:v_emp_cpr_expiry_date,v_emp_visa_validity:v_emp_visa_validity,v_checked_val:checked_val,v_emp_tech_type_name:v_emp_tech_type_name,v_emp_native_no:v_emp_native_no,v_emp_native_address:v_emp_native_address,v_emp_visa_type:v_emp_visa_type}
                                , function(result,status)
                                {
                                   console.log(result);
                                result = $.trim(result);
                               
                                 if(result=="" || result.toLowerCase().indexOf("error") !== -1)
                                 {
                                     v_btn_employee_add.ladda( 'stop' );
                                     swal("Error", result || "Failed to add employee", "error");
                                 }
                                 else 
                                 {
                                     v_btn_employee_add.ladda( 'stop' );
                                      swal("Success", "New employee added successfully..", "success");
                                      load_data_to_grid_employees_details_list();
                                      location.reload();
                                 }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
                //load data to employeegrid
                 function load_data_to_grid_employees_details_list()
                 {
                     var i=1;
                    v_list_of_employees_table.destroy();
                         
                     v_list_of_employees_table = $('#list_of_employees').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/employees/employees_controller.php',
                                 'data': {
                                     action: 'employee_list_view'
                                 },
                                
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
                                 { 
                                      "data": null,
                                      "className": "text-center",
                                      "render": function(data, type, full, meta) {
                                          return meta.row + 1;
                                      }
                                 },
                                 { "data": "employee_id", "visible": false },
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name" },
                                 { 
                                      "data": "employee_code",
                                      "render": function ( data, type, rows, meta ) {
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
                                      }
                                 },
                                 { 
                                      "data": "employee_image",
                                      "render": function ( data, type, rows, meta ) {
                                          var img_name = (data && $.trim(data) != '' && data != 'null' && data != 'undefined') ? $.trim(data) : 'default.jpg';
                                          return '<div align="center"><img src="../httpdocs/images/employee_image/'+img_name+'" onerror="this.onerror=null;this.src=\'../httpdocs/images/employee_image/default.jpg\';" class="rounded-circle" style="object-fit:cover;border:1px solid #c2daeb;" height="36px" width="36px"/></div>';
                                      }
                                 },
                                  { 
                                      "data": "employee_status",
                                      "render": function ( data, type, rows, meta ) {
                                          var str_active_status = '';
                                          if(data == 'Active') {
                                              str_active_status = '<span class="badge badge-success">'+data+'</span>';
                                          } else {
                                              str_active_status = '<span class="badge badge-danger">'+data+'</span>';
                                          }
                                          return str_active_status;
                                      }
                                  },
                                  {
                                      "data": "employee_id",
                                      "render": function (data, type, rows, meta) {
                                          var hasPrivilege = true;
                                          if (typeof permissions !== 'undefined' && Array.isArray(permissions)) {
                                              hasPrivilege = permissions.length === 0 || permissions.includes("EmployeesModify") || permissions.includes("EmployeesView");
                                          }
                                          
                                          var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" data-boundary="window" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                          if (hasPrivilege) {
                                              dropdownHTML += '<a href="#" class="dropdown-item" name="name_Edit" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="name_ApplyLeave" style="color: blue;"><i class="icon-calendar"></i>Apply Leave</a><a href="#" class="dropdown-item" name="name_Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="name_Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a>';
                                          } else {
                                              dropdownHTML += '<label class="dropdown-item text-danger">You have no privilege</label>';
                                          }
                                          dropdownHTML += '</div></div></div>';
                                          return dropdownHTML;
                                      }
                                  }
                                 
                       
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
                               //  $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
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
                         if($(this).attr("name")=='name_Edit')
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
                         
                         if($(this).attr("name")=='name_ApplyLeave')
                         {
                             $("#leave_emp_id").val(v_employee_id);
                             $("#leave_emp_code").val(emp_data.employee_code);
                             if ($("#leave_emp_name option[value='" + emp_data.employee_name + "']").length == 0) {
                                 $("#leave_emp_name").append(new Option(emp_data.employee_name, emp_data.employee_name, true, true));
                             }
                             $("#leave_emp_name").val(emp_data.employee_name).trigger('change');
                             $("#leave_emp_name").prop('disabled', true);
                             
                             // Reset form fields
                             $("#leave_type").val('').trigger('change');
                             $("#leave_start_date").val('');
                             $("#leave_end_date").val('');
                             $("#leave_duration").val('Full Day').trigger('change');
                             $("#leave_reason").val('');
                             
                             // Initialize Select2 with tags if not already done
                             if (!$('#leave_type').hasClass("select2-hidden-accessible")) {
                                 $('#leave_type').select2({ tags: true });
                             }
                             
                             $("#modal_apply_leave").modal('show');
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
                                 var cur_img = (emp_data.employee_image && $.trim(emp_data.employee_image) != '' && emp_data.employee_image != 'null') ? $.trim(emp_data.employee_image) : 'default.jpg';
                                 v_session_image_new = cur_img;
                                 v_session_image = cur_img;
                                 $("#img_preview").show().html("<img style='width:36px;height:36px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' onerror=\"this.onerror=null;this.src='../httpdocs/images/employee_image/default.jpg';\" src='../httpdocs/images/employee_image/"+cur_img+"'>");
                                 $('#emp_img_name').text(cur_img);
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
                            
                             if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_employee_action=$(this).attr("name");
                              v_employee_action = v_employee_action.split("_");
                             $.post("../controller/employees/employees_controller.php",{action:'change_employee_status',v_employee_id:v_employee_id,v_employee_status:v_employee_status,v_employee_action:v_employee_action[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_employees_details_list();
                                
                            });
                         }  
                          
                        
        });

        $(document).on('show.bs.dropdown', '#list_of_employees .dropdown', function () {
            var $dropdown = $(this);
            var $toggle = $dropdown.find('[data-toggle="dropdown"]');
            if ($toggle.length) {
                var offset = $toggle.offset();
                var windowHeight = $(window).height();
                var scrollTop = $(window).scrollTop();
                var spaceBelow = windowHeight - (offset.top - scrollTop);

                if (spaceBelow < 180) {
                    $dropdown.addClass('dropup');
                } else {
                    $dropdown.removeClass('dropup');
                }
            }
        });
       
                 
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
                    var v_session_image_new = $("#emp_img_name").text();
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
                     var v_emp_image_to_save = "default.jpg";
                     if(v_session_image && v_session_image !== "" && v_session_image !== "default.jpg" && v_session_image.indexOf("fakepath") === -1) {
                         v_emp_image_to_save = v_session_image;
                     } else if(v_session_image_new && v_session_image_new !== "" && v_session_image_new.indexOf("fakepath") === -1) {
                         v_emp_image_to_save = v_session_image_new;
                     }  
                    if($.trim(v_emp_name)==""||v_emp_pwd==""||v_user_type_id=="select"||v_emp_contact_no=="")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_employee_add.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/employees/employees_controller.php",{action:'update_employee',v_employee_name:v_emp_name,v_employee_type_id:v_user_type_id,v_employee_type_name:v_user_type_name,v_employee_password:v_emp_pwd,v_employee_contact_no:v_emp_contact_no,v_employee_email_id:v_emp_email_id,v_employee_address:v_emp_address,v_employee_image:v_emp_image_to_save,v_expertise_id:v_expertise_id,v_expertise_name:v_expertise_name,v_employee_id:v_employee_id,v_emp_cpr_number:v_emp_cpr_number,v_emp_blood_group:v_emp_blood_group,v_emp_passport_no:v_emp_passport_no,v_emp_joining_date:v_emp_joining_date,v_emp_cpr_expiry_date:v_emp_cpr_expiry_date,v_emp_visa_validity:v_emp_visa_validity,v_checked_val:checked_val,v_emp_tech_type_name:v_emp_tech_type_name,v_emp_native_no:v_emp_native_no,v_emp_native_address:v_emp_native_address,v_emp_visa_type:v_emp_visa_type,v_employee_code:v_emp_code}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                result = $.trim(result);
                               
                                 if(result=="" || result.toLowerCase().indexOf("error") !== -1)
                                 {
                                     v_btn_employee_edit.ladda( 'stop' );
                                     swal("Error", result || "Failed to update employee", "error");
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
                    v_session_image = "default.jpg";
                    v_session_image_new = "";
                    $("#session_image").val(null);
                    $("#emp_img_name").empty();
                    $("#img_preview").empty().hide();
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
                  
                 $('#btn_submit_leave').click(function(){
                     var btn = $('#btn_submit_leave').ladda();
                     btn.ladda('start');
                     
                     var emp_id = $("#leave_emp_id").val();
                     var emp_code = $("#leave_emp_code").val();
                     var emp_name = $("#leave_emp_name").val();
                     var leave_type = $("#leave_type").val();
                     var leave_start_date = $("#leave_start_date").val();
                     var leave_end_date = $("#leave_end_date").val();
                     var leave_duration = $("#leave_duration").val();
                     var leave_reason = $("#leave_reason").val();
                     
                     if(emp_name == '' || emp_name == null || leave_type == '' || leave_start_date == '' || leave_end_date == '' || leave_duration == '' || leave_reason == '') {
                         swal("Warning", "Please fill all required fields including Employee Name.", "warning");
                         btn.ladda('stop');
                         return false;
                     }
                     
                     if (leave_end_date < leave_start_date) {
                         swal("Warning", "End Date cannot be before Start Date.", "warning");
                         btn.ladda('stop');
                         return false;
                     }
                     
                     $.post("../controller/employees/employees_controller.php", {
                         action: 'apply_leave',
                         leave_emp_id: emp_id,
                         leave_emp_code: emp_code,
                         leave_emp_name: emp_name,
                         leave_type: leave_type,
                         leave_start_date: leave_start_date,
                         leave_end_date: leave_end_date,
                         leave_duration: leave_duration,
                         leave_reason: leave_reason
                     }, function(result, status) {
                         btn.ladda('stop');
                         result = $.trim(result);
                         if(result == "Success") {
                             swal("Success", "Leave applied successfully.", "success");
                             $("#modal_apply_leave").modal('hide');
                         } else {
                             swal("Error", result, "error");
                         }
                     });
                 });
                 
                 
                 $('#btn_leave_calendar').click(function(){
                     $("#modal_leave_calendar").modal('show');
                 });
                 
                 $('#modal_leave_calendar').on('shown.bs.modal', function () {
                     if ($('#leave_calendar_view').hasClass('fc')) {
                         $('#leave_calendar_view').fullCalendar('refetchEvents');
                         $('#leave_calendar_view').fullCalendar('render');
                     } else {
                         $('#leave_calendar_view').fullCalendar({
                         header: {
                             left: 'prev,next today',
                             center: 'title',
                             right: 'month,agendaWeek,agendaDay'
                         },
                         buttonIcons: {
                             prev: 'left-single-arrow',
                             next: 'right-single-arrow'
                         },
                         buttonText: {
                             prev: '‹',
                             next: '›',
                             today: 'today',
                             month: 'month',
                             week: 'week',
                             day: 'day'
                         },
                         editable: false,
                         events: function(start, end, timezone, callback) {
                             $.ajax({
                                 url: '../controller/employees/employees_controller.php',
                                 type: 'POST',
                                 data: {
                                     action: 'fetch_leave_calendar'
                                 },
                                 success: function(doc) {
                                     var events = [];
                                     try {
                                         var data = JSON.parse(doc);
                                         $.each(data, function(i, item) {
                                             events.push({
                                                 leave_id: item.leave_id,
                                                 table_source: item.table_source,
                                                 employee_code: item.employee_code,
                                                 employee_name: item.employee_name,
                                                 leave_type: item.leave_type,
                                                 leave_reason: item.leave_reason,
                                                 start_date_raw: item.start_date_raw,
                                                 end_date_raw: item.end_date_raw,
                                                 title: item.title,
                                                 start: item.start,
                                                 end: item.end,
                                                 color: item.color
                                             });
                                         });
                                     } catch (e) {
                                         console.error("Error parsing JSON:", e);
                                     }
                                     callback(events);
                                 }
                             });
                         },
                         eventClick: function(calEvent, jsEvent, view) {
                             $('#edit_leave_id').val(calEvent.leave_id || '');
                             $('#edit_leave_table_source').val(calEvent.table_source || 'short');
                             $('#edit_leave_emp_code').val(calEvent.employee_code || '');
                             var empDisplay = (calEvent.employee_code ? '[' + calEvent.employee_code + '] ' : '') + (calEvent.employee_name || '');
                             $('#edit_leave_emp_name').val(empDisplay);

                             if (calEvent.leave_type) {
                                 $('#edit_leave_type').val(calEvent.leave_type);
                             }

                             var sDate = calEvent.start_date_raw || (calEvent.start ? moment(calEvent.start).format('YYYY-MM-DD') : '');
                             var eDate = calEvent.end_date_raw || '';
                             if (!eDate && calEvent.end) {
                                 eDate = moment(calEvent.end).subtract(1, 'days').format('YYYY-MM-DD');
                             } else if (!eDate) {
                                 eDate = sDate;
                             }

                             $('#edit_leave_start_date').val(sDate);
                             $('#edit_leave_end_date').val(eDate);
                             $('#edit_leave_reason').val(calEvent.leave_reason || '');

                             $('#modal_edit_leave').modal('show');
                         },
                         dayClick: function(date, jsEvent, view) {
                             var clickCount = $(this).data('clickCount') || 0;
                             var clickTimer = $(this).data('clickTimer');
                             
                             clickCount++;
                             $(this).data('clickCount', clickCount);
                             
                             if (clickCount === 1) {
                                 var elem = this;
                                 clickTimer = setTimeout(function() {
                                     $(elem).data('clickCount', 0);
                                 }, 300);
                                 $(this).data('clickTimer', clickTimer);
                             } else if (clickCount === 2) {
                                 clearTimeout(clickTimer);
                                 $(this).data('clickCount', 0);
                                 
                                 // Handle double click
                                 $("#modal_leave_calendar").modal('hide');
                                 
                                 setTimeout(function() {
                                     $("#modal_apply_leave").modal('show');
                                     $("#leave_start_date").val(date.format());
                                     $("#leave_end_date").val(date.format());
                                     $('#leave_emp_name').val("").trigger('change');
                                     $('#leave_emp_name').prop('disabled', false);
                                 }, 500);
                             }
                         }
                     });
                     $('#leave_calendar_view').fullCalendar('render');
                     }
                 });

                  $('#btn_update_leave').off('click').on('click', function() {
                      var leave_id = $('#edit_leave_id').val();
                      var table_source = $('#edit_leave_table_source').val();
                      var leave_type = $('#edit_leave_type').val();
                      var start_date = $('#edit_leave_start_date').val();
                      var end_date = $('#edit_leave_end_date').val();
                      var leave_reason = $('#edit_leave_reason').val();

                      if (!leave_id || !start_date || !end_date) {
                          swal("Warning", "Please provide Start Date and End Date.", "warning");
                          return;
                      }

                      if (end_date < start_date) {
                          swal("Warning", "End Date cannot be before Start Date.", "warning");
                          return;
                      }

                      $.post('../controller/employees/employees_controller.php', {
                          action: 'update_leave_record',
                          leave_id: leave_id,
                          table_source: table_source,
                          leave_type: leave_type,
                          start_date: start_date,
                          end_date: end_date,
                          leave_reason: leave_reason
                      }, function(res) {
                          res = $.trim(res);
                          if (res === 'Success') {
                              swal("Success", "Leave record updated successfully!", "success");
                              $('#modal_edit_leave').modal('hide');
                              if ($('#leave_calendar_inline').length) {
                                  $('#leave_calendar_inline').fullCalendar('refetchEvents');
                              }
                              if ($('#leave_calendar_view').length) {
                                  $('#leave_calendar_view').fullCalendar('refetchEvents');
                              }
                              if (typeof load_data_to_grid_employees_on_leave_list === 'function') {
                                  load_data_to_grid_employees_on_leave_list();
                              }
                          } else {
                              swal("Error", res, "error");
                          }
                      });
                  });

                  $('#btn_delete_leave').off('click').on('click', function() {
                      var leave_id = $('#edit_leave_id').val();
                      var table_source = $('#edit_leave_table_source').val();
                      var employee_code = $('#edit_leave_emp_code').val();

                      if (!leave_id) {
                          swal("Warning", "Invalid leave record.", "warning");
                          return;
                      }

                      swal({
                          title: "Delete Leave Record?",
                          text: "Are you sure you want to delete this leave entry? This action cannot be undone.",
                          icon: "warning",
                          buttons: {
                              cancel: "No, Cancel",
                              confirm: {
                                  text: "Yes, Delete",
                                  className: "btn-danger"
                              }
                          },
                          dangerMode: true,
                      }).then(function(willDelete) {
                          if (willDelete) {
                              $.post('../controller/employees/employees_controller.php', {
                                  action: 'delete_leave_record',
                                  leave_id: leave_id,
                                  table_source: table_source,
                                  employee_code: employee_code
                              }, function(res) {
                                  res = $.trim(res);
                                  if (res === 'Success') {
                                      swal("Deleted!", "Leave record deleted successfully.", "success");
                                      $('#modal_edit_leave').modal('hide');
                                      if ($('#leave_calendar_inline').length) {
                                          $('#leave_calendar_inline').fullCalendar('refetchEvents');
                                      }
                                      if ($('#leave_calendar_view').length) {
                                          $('#leave_calendar_view').fullCalendar('refetchEvents');
                                      }
                                      if (typeof load_data_to_grid_employees_on_leave_list === 'function') {
                                          load_data_to_grid_employees_on_leave_list();
                                      }
                                  } else {
                                      swal("Error", res, "error");
                                  }
                              });
                          }
                      });
                  });

    // ---- Employee Attachments & Documents Management -------------------
    var v_tbl_employee_attachments;

    function load_employee_attachments_grid() {
        var emp_filter_id = $('#select_filter_attachment_emp').val() || 0;
        if ($.fn.DataTable.isDataTable('#tbl_employee_attachments')) {
            $('#tbl_employee_attachments').DataTable().destroy();
        }

        v_tbl_employee_attachments = $('#tbl_employee_attachments').DataTable({
            "ajax": {
                "type": "POST",
                "url": "../controller/employees/employees_controller.php",
                "data": {
                    action: "list_employee_attachments",
                    employee_id: emp_filter_id
                }
            },
            "columns": [
                { "data": null },
                { "data": "employee_code" },
                { "data": "employee_name" },
                { 
                    "data": "document_name",
                    "render": function(data) {
                        return '<span class="badge badge-primary font-weight-bold p-1">' + data + '</span>';
                    }
                },
                { "data": "expiry_date_format" },
                { "data": "remarks" },
                { 
                    "data": "file_path",
                    "render": function(data, type, row) {
                        if (data) {
                            return '<a href="../view/' + data + '" target="_blank" class="btn btn-sm btn-outline-info"><i class="icon-file-download mr-1"></i> View / Download</a>';
                        }
                        return '<span class="text-muted">No File</span>';
                    }
                },
                { "data": "created_at_format" },
                { 
                    "data": "attachment_id",
                    "render": function(data) {
                        return '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-attachment" data-id="' + data + '"><i class="icon-trash"></i></button>';
                    }
                }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                return nRow;
            },
            "order": [[ 0, "desc" ]],
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false
        });
    }

    // Initialize select2 on attachment dropdowns
    if ($.fn.select2) {
        $('#select_attach_employee').select2({
            placeholder: "Select Employee",
            allowClear: true,
            width: '100%'
        });
        $('#select_attach_doc_name').select2({
            placeholder: "Select Document Type",
            width: '100%'
        });
        $('#select_filter_attachment_emp').select2({
            placeholder: "All Employees",
            width: '100%'
        });
    }

    // Load attachments list when switching tabs or filtering
    $('a[href="#tab_employee_attachments"]').on('shown.bs.tab', function (e) {
        if ($.fn.select2) {
            $('#select_attach_employee').select2({ placeholder: "Select Employee", allowClear: true, width: '100%' });
            $('#select_attach_doc_name').select2({ placeholder: "Select Document Type", width: '100%' });
            $('#select_filter_attachment_emp').select2({ placeholder: "All Employees", width: '100%' });
        }
        load_employee_attachments_grid();
    });

    $('#select_filter_attachment_emp').change(function(){
        load_employee_attachments_grid();
    });

    // Form Submit: Upload Attachment
    $('#form_employee_attachment').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('action', 'save_employee_attachment');

        var $btn = $('#btn_upload_attachment');
        $btn.prop('disabled', true).html('<b><i class="icon-spinner2 spinner mr-2"></i></b> Uploading...');

        $.ajax({
            url: '../controller/employees/employees_controller.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $btn.prop('disabled', false).html('<b><i class="icon-upload mr-2"></i></b> Upload Attachment');
                try {
                    var res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.status === 'success') {
                        swal("Success", res.message, "success");
                        $('#form_employee_attachment')[0].reset();
                        $('#select_attach_employee').val('').trigger('change');
                        $('#select_attach_doc_name').val('Passport').trigger('change');
                        load_employee_attachments_grid();
                    } else {
                        swal("Error", res.message || "Failed to upload document.", "error");
                    }
                } catch (err) {
                    swal("Error", "Server error while saving attachment.", "error");
                }
            },
            error: function() {
                $btn.prop('disabled', false).html('<b><i class="icon-upload mr-2"></i></b> Upload Attachment');
                swal("Error", "Network connection failed.", "error");
            }
        });
    });

    // Delete Attachment Handler
    $('#tbl_employee_attachments tbody').on('click', '.btn-delete-attachment', function(){
        var attId = $(this).data('id');
        swal({
            title: "Delete Attachment?",
            text: "Are you sure you want to delete this document attachment?",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.post('../controller/employees/employees_controller.php', {
                    action: 'delete_employee_attachment',
                    attachment_id: attId
                }, function(res) {
                    try {
                        var resp = typeof res === 'string' ? JSON.parse(res) : res;
                        if (resp.status === 'success') {
                            swal("Deleted", resp.message, "success");
                            load_employee_attachments_grid();
                        } else {
                            swal("Error", resp.message || "Failed to delete.", "error");
                        }
                    } catch (e) {
                        load_employee_attachments_grid();
                    }
                });
            }
        });
    });

    // ==========================================
    // EMPLOYEE TYPE TAB FUNCTIONALITY
    // ==========================================
    var v_btn_emp_type_add = $('#btn_emp_type_add').ladda();
    var v_btn_emp_type_edit = $('#btn_emp_type_edit').ladda();
    var v_btn_emp_type_new = $('#btn_emp_type_new').ladda();

    var employee_type_table = $('#tbl_employee_types').DataTable({});
    load_data_to_grid_employee_types();

    // Tab switch to Employee Type tab (handle both click and shown.bs.tab)
    $('a[href="#tab_employee_type"]').on('click shown.bs.tab', function (e) {
        load_data_to_grid_employee_types();
    });

    // Function to reload Employee Type grid
    function load_data_to_grid_employee_types() {
        if ($.fn.DataTable.isDataTable('#tbl_employee_types')) {
            $('#tbl_employee_types').DataTable().destroy();
        }
        employee_type_table = $('#tbl_employee_types').DataTable({
            "ajax": {
                'type': 'POST',
                'url': '../controller/employees/employees_controller.php',
                'data': {
                    action: 'list_employee_types'
                }
            },
            "language": {
                "zeroRecords": "No employee types configured yet",
                "infoEmpty": "No employee types available"
            },
            "order": [[1, "asc"]],
            "Paginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "autoWidth": false,
            "columns": [
                { 
                    "data": null, 
                    "className": "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                { 
                    "data": "user_type_name",
                    render: function(data) {
                        return '<span class="font-weight-semibold text-primary"><i class="icon-user-check mr-2"></i>' + data + '</span>';
                    }
                },
                { 
                    "data": "user_type_description",
                    render: function(data) {
                        return (data && $.trim(data) !== '') ? data : '<span class="text-muted font-italic">No description</span>';
                    }
                },
                {
                    "data": "assigned_count",
                    "className": "text-center",
                    render: function(data) {
                        var count = parseInt(data) || 0;
                        if (count > 0) {
                            return '<span class="badge badge-primary px-2 py-1"><i class="icon-users4 mr-1"></i>' + count + ' Assigned</span>';
                        } else {
                            return '<span class="badge badge-light text-muted px-2 py-1 border"><i class="icon-user-cancel mr-1"></i>0 Assigned</span>';
                        }
                    }
                },
                {
                    "data": "user_type_status",
                    "className": "text-center",
                    render: function(data) {
                        if (data === 'Active') {
                            return '<span class="badge badge-success px-2 py-1">Active</span>';
                        } else {
                            return '<span class="badge badge-danger px-2 py-1">Deactive</span>';
                        }
                    }
                },
                {
                    "data": null,
                    "className": "text-center",
                    render: function(data, type, row) {
                        var count = parseInt(row.assigned_count) || 0;
                        var dropdownHTML = '<div class="list-icons"><div class="dropdown">' +
                            '<a href="#" class="list-icons-item" data-toggle="dropdown" data-boundary="window" style="color: #2196f3;"><i class="icon-menu9"></i></a>' +
                            '<div class="dropdown-menu dropdown-menu-right" style="z-index: 999999 !important;">' +
                            '<a href="#" class="dropdown-item name_Type_Edit" style="color: #ff9800;"><i class="icon-database-edit2 mr-2"></i>Edit</a>';
                        
                        if (row.user_type_status === 'Active') {
                            dropdownHTML += '<a href="#" class="dropdown-item name_Type_Deactive text-danger"><i class="icon-cross3 mr-2"></i>Deactivate</a>';
                        } else {
                            dropdownHTML += '<a href="#" class="dropdown-item name_Type_Active text-success"><i class="icon-checkmark2 mr-2"></i>Activate</a>';
                        }

                        if (count === 0) {
                            dropdownHTML += '<div class="dropdown-divider"></div>';
                            dropdownHTML += '<a href="#" class="dropdown-item name_Type_Delete text-danger font-weight-semibold"><i class="icon-trash mr-2"></i>Delete</a>';
                        } else {
                            dropdownHTML += '<div class="dropdown-divider"></div>';
                            dropdownHTML += '<a href="#" class="dropdown-item name_Type_Delete_Disabled text-muted" title="Cannot delete: ' + count + ' employee(s) assigned"><i class="icon-lock mr-2"></i>Delete (Disabled)</a>';
                        }

                        dropdownHTML += '</div></div></div>';
                        return dropdownHTML;
                    }
                }
            ],
            pageLength: 25,
            responsive: true,
            "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
    }

    // Refresh Employee Type dropdown in Employee Form dynamically
    function refresh_employee_type_dropdowns() {
        $.post("../controller/employees/employees_controller.php", {
            action: 'get_active_employee_types'
        }, function(response) {
            try {
                var types = typeof response === 'string' ? JSON.parse(response) : response;
                var currentVal = $("#select_employee_type").val();
                var $select = $("#select_employee_type");
                
                $select.empty().append('<option value="select">Select</option>');
                $.each(types, function(i, item) {
                    $select.append($('<option>', {
                        value: item.user_type_id,
                        text: item.user_type_name
                    }));
                });

                if (currentVal && currentVal !== 'select') {
                    $select.val(currentVal).trigger('change');
                } else {
                    $select.val('select').trigger('change');
                }
            } catch (e) {
                console.error("Error updating employee type dropdown:", e);
            }
        });
    }

    // Add Employee Type
    v_btn_emp_type_add.click(function() {
        var name = $.trim($('#txt_emp_type_name').val());
        var desc = $.trim($('#txt_emp_type_description').val());

        if (name === "") {
            swal("Warning", "Please provide Employee Type Name.", "warning");
            return false;
        }

        v_btn_emp_type_add.ladda('start');

        $.post("../controller/employees/employees_controller.php", {
            action: 'add_employee_type',
            v_employee_type_name: name,
            v_employee_type_description: desc
        }, function(result) {
            v_btn_emp_type_add.ladda('stop');
            result = $.trim(result);
            if (result === 'Success') {
                swal("Success", "New Employee Type added successfully!", "success");
                reset_emp_type_form();
                load_data_to_grid_employee_types();
                refresh_employee_type_dropdowns();
            } else {
                swal("Error", result, "error");
            }
        });
    });

    // Update Employee Type
    v_btn_emp_type_edit.click(function() {
        var id = $('#txt_emp_type_id').val();
        var name = $.trim($('#txt_emp_type_name').val());
        var desc = $.trim($('#txt_emp_type_description').val());

        if (name === "" || !id) {
            swal("Warning", "Please provide Employee Type Name.", "warning");
            return false;
        }

        v_btn_emp_type_edit.ladda('start');

        $.post("../controller/employees/employees_controller.php", {
            action: 'update_employee_type',
            v_employee_type_id: id,
            v_employee_type_name: name,
            v_employee_type_description: desc
        }, function(result) {
            v_btn_emp_type_edit.ladda('stop');
            result = $.trim(result);
            if (result === 'Success') {
                swal("Success", "Employee Type updated successfully!", "success");
                reset_emp_type_form();
                load_data_to_grid_employee_types();
                refresh_employee_type_dropdowns();
            } else {
                swal("Error", result, "error");
            }
        });
    });

    // Cancel / New Employee Type button
    $('#btn_emp_type_new').click(function() {
        reset_emp_type_form();
    });

    function reset_emp_type_form() {
        $('#txt_emp_type_id').val('');
        $('#txt_emp_type_name').val('');
        $('#txt_emp_type_description').val('');
        $('#btn_emp_type_add').show();
        $('#btn_emp_type_edit').hide();
        $('#btn_emp_type_new').hide();
    }

    // Row Actions for Employee Type DataTable
    $('#tbl_employee_types tbody').on('click', 'a.dropdown-item', function(e) {
        e.preventDefault();
        var $row = $(this).closest('tr');
        var data = employee_type_table.row($row).data();
        if (!data) return;

        var v_id = data.user_type_id;
        var count = parseInt(data.assigned_count) || 0;

        // Edit
        if ($(this).hasClass('name_Type_Edit')) {
            $('#txt_emp_type_id').val(v_id);
            $('#txt_emp_type_name').val(data.user_type_name);
            $('#txt_emp_type_description').val(data.user_type_description || '');

            $('#btn_emp_type_add').hide();
            $('#btn_emp_type_edit').show();
            $('#btn_emp_type_new').show();

            $('#txt_emp_type_name').focus();
            $('html, body').animate({ scrollTop: $('#form_employee_type').offset().top - 100 }, 'fast');
        }

        // Activate
        if ($(this).hasClass('name_Type_Active')) {
            $.post("../controller/employees/employees_controller.php", {
                action: 'change_employee_type_status',
                v_employee_type_id: v_id,
                v_employee_type_action: 'Active'
            }, function(res) {
                if ($.trim(res) === 'Success') {
                    swal("Activated", "Employee Type is now Active.", "success");
                    load_data_to_grid_employee_types();
                    refresh_employee_type_dropdowns();
                } else {
                    swal("Error", res, "error");
                }
            });
        }

        // Deactivate
        if ($(this).hasClass('name_Type_Deactive')) {
            swal({
                title: "Deactivate Employee Type?",
                text: "When deactivated, this type will not appear in the Employee Type dropdown when adding new employees.",
                icon: "warning",
                buttons: ["Cancel", "Yes, Deactivate"],
                dangerMode: true
            }).then((willDeactivate) => {
                if (willDeactivate) {
                    $.post("../controller/employees/employees_controller.php", {
                        action: 'change_employee_type_status',
                        v_employee_type_id: v_id,
                        v_employee_type_action: 'Deactive'
                    }, function(res) {
                        if ($.trim(res) === 'Success') {
                            swal("Deactivated", "Employee Type has been deactivated.", "success");
                            load_data_to_grid_employee_types();
                            refresh_employee_type_dropdowns();
                        } else {
                            swal("Error", res, "error");
                        }
                    });
                }
            });
        }

        // Delete (When 0 employees assigned)
        if ($(this).hasClass('name_Type_Delete')) {
            swal({
                title: "Delete Employee Type?",
                text: "Are you sure you want to permanently delete '" + data.user_type_name + "'?",
                icon: "warning",
                buttons: ["Cancel", "Yes, Delete"],
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("../controller/employees/employees_controller.php", {
                        action: 'delete_employee_type',
                        v_employee_type_id: v_id
                    }, function(res) {
                        res = $.trim(res);
                        if (res === 'Success') {
                            swal("Deleted", "Employee Type deleted successfully!", "success");
                            reset_emp_type_form();
                            load_data_to_grid_employee_types();
                            refresh_employee_type_dropdowns();
                        } else {
                            swal("Cannot Delete", res, "error");
                        }
                    });
                }
            });
        }

        // Disabled Delete clicked
        if ($(this).hasClass('name_Type_Delete_Disabled')) {
            swal("Cannot Delete", "This Employee Type currently has " + count + " employee(s) assigned to it. It cannot be deleted. You can deactivate it instead.", "warning");
        }
    });

});