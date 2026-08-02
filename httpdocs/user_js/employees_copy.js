$(document).ready(function(){
    const baseUrl = window.location.origin+'/thc/';
    console.log(baseUrl);
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
    					   $.post("../controller/employees/employees_controller_copy.php",{action:'employee_code_check',v_employee_code:emp_code_check }
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
                    var success = upload.doUpload(baseUrl+"httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum,v_item_img);

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
            
            
                // var documentData = [];
                // $('.document_row').each(function() {
                //     var docType = $(this).find('.document_type').val();
                //     var docFiles = $(this).find('.document_file')[0].files;
                //     var expiryDate = $(this).find('.expiry_date').val();
                //     var remark = $(this).find('.document_remark').val();
                    
                //     if (docType && docFiles.length > 0) {
                //         var fileNames = [];
                //         for (var i = 0; i < docFiles.length; i++) {
                //             fileNames.push(docFiles[i].name);
                //         }
                        
                //         documentData.push({
                //             type: docType,
                //             files: fileNames.join(','), // Comma separated file names
                //             expiry: expiryDate,
                //             remark: remark
                //         });
                //     }
                // });
                // var documentDataJSON = JSON.stringify(documentData);
 
               v_btn_employee_add.click(function(){
    v_btn_employee_add.ladda('start');
    v_emp_name = $("#txt_emp_name").val();
    var v_emp_pwd = $("#txt_emp_password").val();
    var v_emp_contact_no = $("#txt_emp_contact_no").val();
    var v_emp_email_id = $("#txt_emp_email_id").val();
    var v_emp_address = $("#txt_emp_address").val();
    v_session_image = $("#session_image").val();
    randomNum = Math.ceil(Math.random() * 999999);   
    v_expertise_id = $('#select_expertise option:selected').toArray().map(item => item.value);
    v_expertise_name = $('#select_expertise option:selected').toArray().map(item => item.text);
    var v_emp_tech_type_id = $("#select_emp_tech_type option:selected").val();
    var v_emp_tech_type_name = $("#select_emp_tech_type option:selected").text();
    var v_emp_blood_group = $("#select_employee_blood_group option:selected").val();
    var v_emp_cpr_number = $("#txt_cpr_no").val();
    var v_emp_passport_no = $("#txt_emp_passport_no").val();
    var v_emp_joining_date = $("#emp_joining_date").val();
    var v_emp_visa_validity = $("#emp_visa_validity").val();
    var v_emp_cpr_expiry_date = $("#emp_cpr_expiry_date").val();
    
    var v_emp_native_no = $("#txt_emp_native_no").val();
    var v_emp_native_address = $("#txt_emp_native_address").val();
    var v_emp_visa_type = $("#select_employee_visa_type option:selected").val();
   
    // Email validation
    if(v_emp_email_id != "") {
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        var valueToTest = $("#txt_emp_email_id").val();
        if (testEmail.test(valueToTest)) {
            // Valid, proceed
        } else {
            swal("Error", "Please enter valid Email", "warning");
            v_btn_employee_add.ladda('stop');
            $("#txt_emp_email_id").val("");
            return false;
        }
    }
    
    // Handle tech type if 'select'
    if(v_emp_tech_type_id == 'select') {
        v_emp_tech_type_name = 'NA';
    }
     
    // Handle expertise if 'select' or empty
    if(v_expertise_id == 'select' || (Array.isArray(v_expertise_id) && v_expertise_id.length === 0) || v_expertise_id === '') {
        v_expertise_id = 0;
        v_expertise_name = 'NA';
    }
    
    // Session image handling
    var v_session_image_name = "default.jpg";
    if(v_session_image !== "") {
        var doc_file_obj = $("#session_image")[0].files[0];
        if (doc_file_obj) {
            var doc_file1 = doc_file_obj.name;
            v_session_image_name = $.trim(randomNum + '_' + doc_file1);
            // Note: File will be sent via FormData below, no separate ns.Upload needed
        }
    }  
    
    // Main validation
    if($.trim(v_emp_name) === "" || $.trim(v_emp_pwd) === "" || typeof v_user_type_id === "undefined" || $.trim(v_emp_contact_no) === "" || typeof v_expertise_id === "undefined" || v_emp_joining_date === "" || v_emp_visa_validity === "" || v_emp_cpr_expiry_date === "" || v_emp_passport_no === "") {
        swal("Warning", "Please provide all the details ....", "warning");
        v_btn_employee_add.ladda('stop');
        return false;
    }
   
    else {     
        // Checkbox value
        checked_val = ($("#chk_driving").prop("checked")) ? 'Yes' : 'No';
        
        // Collect documents and prepare FormData
        var formData = new FormData();
        var documentData = [];
        $('.document_row').each(function(index) {
            var docType = $(this).find('.document_type').val();
            var docFiles = $(this).find('.document_file')[0].files;
            var expiryDate = $(this).find('.expiry_date').val();
            var remark = $(this).find('.document_remark').val();
            
            if (docType && docFiles.length > 0) {
                var fileNames = [];
                for (var i = 0; i < docFiles.length; i++) {
                    var fileName = randomNum + '_' + docFiles[i].name;
                    fileNames.push(fileName);
                    formData.append('document_files_' + index + '_' + i, docFiles[i], fileName);
                }
                
                documentData.push({
                    type: docType,
                    files: fileNames.join(','),
                    expiry: expiryDate,
                    remark: remark
                });
            }
        });
        var documentDataJSON = JSON.stringify(documentData);
        
        // Debug: Log to console
        console.log("Documents JSON:", documentDataJSON);
        
        // Append all form data to FormData
        formData.append('action', 'add_employee');
        formData.append('v_employee_name', v_emp_name);
        formData.append('v_employee_type_id', v_user_type_id);
        formData.append('v_employee_type_name', v_user_type_name);
        formData.append('v_employee_password', v_emp_pwd);
        formData.append('v_employee_contact_no', v_emp_contact_no);
        formData.append('v_employee_email_id', v_emp_email_id);
        formData.append('v_employee_address', v_emp_address);
        formData.append('v_employee_image', v_session_image_name);
        formData.append('v_expertise_id', JSON.stringify(v_expertise_id)); // Stringify if array
        formData.append('v_expertise_name', JSON.stringify(v_expertise_name)); // Stringify if array
        formData.append('v_emp_cpr_number', v_emp_cpr_number);
        formData.append('v_emp_blood_group', v_emp_blood_group);
        formData.append('v_emp_passport_no', v_emp_passport_no);
        formData.append('v_emp_joining_date', v_emp_joining_date);
        formData.append('v_emp_cpr_expiry_date', v_emp_cpr_expiry_date);
        formData.append('v_emp_visa_validity', v_emp_visa_validity);
        formData.append('v_checked_val', checked_val);
        formData.append('v_emp_tech_type_name', v_emp_tech_type_name);
        formData.append('v_emp_native_no', v_emp_native_no);
        formData.append('v_emp_native_address', v_emp_native_address);
        formData.append('v_emp_visa_type', v_emp_visa_type);
        formData.append('v_document_data', documentDataJSON);
        
        // Append session image file if selected
        if(v_session_image !== "" && $("#session_image")[0].files[0]) {
            formData.append('employee_image', $("#session_image")[0].files[0], v_session_image_name);
        }
        
        // Send AJAX request
        $.ajax({
            url: "../controller/employees/employees_controller_copy.php",
            type: 'POST',
            data: formData,
            contentType: false, // Required for multipart/form-data
            processData: false, // Prevent jQuery from processing FormData
            success: function(result, status) {
                console.log(result);
                result = $.trim(result);
               
                if(result == "") {
                    v_btn_employee_add.ladda('stop');
                    swal("Error", result || "An error occurred", "error");
                    clear_text();
                } else {
                    v_btn_employee_add.ladda('stop');
                    swal("Success", "New employee added successfully..", "success");
                    load_data_to_grid_employees_details_list();
                    clear_text();
                }
            },
            error: function(xhr, status, error) {
                v_btn_employee_add.ladda('stop');
                swal("Error", "Failed to save employee: " + error, "error");
                console.error("AJAX Error:", status, error);
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
                                 'url': '../controller/employees/employees_controller_copy.php',
                                 'data': {
                                    action: 'employee_list_view'
                                    
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
                                 { "data": "employee_name" },
                                 { "data": "employee_type_name"},
                                  { "data": "employee_code",
                                     render: function ( data, type, rows, meta ) {
                                         
                                          return '<a href="reports/employee_profile.php?employee_id='+rows['employee_id']+'" target="_BLANK">'+data+'</a>';
             
                                     }
                                },
                                
                                 { "data": "employee_image",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='default.jpg')
                                          {
                                             return '<div align="center"><img src=baseUrl+"/thc/httpdocs/images/employee_image/'+data+'" class="rounded-circle" height="30px" width="30px"/></div>';
             
                                          } 
                                          else
                                          {
                                              return '<div align="center"><img src="httpdocs/images/employee_image/'+data+'" class="rounded-circle" height="50px" width="50px"/></div>';
            
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
                                 
                                //  { "data": "employee_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Employee" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-checkmark2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-cross3"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                
                                //  { "data": "employee_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           var dropdownOptions = {
                                //             "Edit": "Edit",
                                //             "Activate": "Active",
                                //             "Deactivate": "Deactive"
                                //         };
                                        
                                //          var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                //             return permissions.includes(option);
                                //         });
                                        
                                //         var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                //             if (filteredOptions.length === 0) {
                                //             dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
                                //         } else {
                                //             filteredOptions.forEach(function (option) {
                                //                 if (dropdownOptions[option] == "Edit") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: orange;"><i class="icon-database-edit2"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Active") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: green;"><i class="icon-checkmark2"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //                 if (dropdownOptions[option] == "Deactive") {
                                //                     dropdownHTML += '<a href="#" class="dropdown-item" name="name_' + dropdownOptions[option] + '" style="color: red;"><i class="icon-cross3"></i>' + dropdownOptions[option] + '</a>';
                                //                 }
                                //             });
                                //         }
                                
                                //         dropdownHTML += '</div></div></div>';
                                
                                //         return dropdownHTML;  
                                //       } 
                                //  }
                                 {
                                    "data": "employee_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "EmployeesModify": "Edit",
                                            "EmployeesModify": "Active",
                                            "EmployeesModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions.includes("EmployeesModify"))
                                        {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="name_Edit" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="name_Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="name_Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a><a href="#" class="dropdown-item" name="name_ViewDoc" style="color: blue;"><i class="icon-file-eye"></i>View Doc</a>';
                                        }
                                        else
                                        {
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
            			 
            			 
            			  function edit_employee_details(v_employee_id) {
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
                                
                                var chk_val = emp_data.is_driving_license;
                                if ($.trim(chk_val) == 'Yes') {
                                    $("#chk_driving").prop("checked", true);
                                }
                            
                                $("#select_emp_tech_type").val($.trim(emp_data.technician_type)).trigger('change');
                                $("#img_preview").html("<img style='width:60px;height:60px;' src='httpdocs/images/employee_image/" + $.trim(emp_data.employee_image) + "'>");
                                $('#emp_img_name').text(emp_data.employee_image);
                                $("#select_employee_type").val($.trim(emp_data.employee_type_id)).trigger('change');
                            
                                if (emp_data.employee_type_name == 'Technician') {
                                    $.post("../controller/employees/employees_controller_copy.php", { action: 'select_expertise_names', v_employee_id: v_employee_id }, function(result, status) {
                                        var obj = jQuery.parseJSON(result);
                                        var datalength = obj.data.length;
                                        for (i = 0; i < datalength; i++) {
                                            var empSelect = $('#select_expertise');
                                            var exper_name = obj.data[i].expertise_name;
                                            var exper_id = obj.data[i].expertise_id;
                                            var option = new Option(exper_name, exper_id, true, true);
                                            empSelect.append(option).trigger('change');
                                        }
                                    });
                                }
                            
                                $.post("../controller/employees/employees_controller_copy.php", { action: 'get_employee_documents', v_employee_id: v_employee_id }, function(result) {
                                    var docs = JSON.parse(result);
                                    $('#document_container').empty(); // Clear existing rows
                                    $(this).closest(".col-md-12").find("span.action.btn.btn-light").addClass("bg-pink");
                                
                                    if (docs.length === 0) {
                                        // Add one empty row if no documents
                                        var templateRow = `
                                            <div class="document_row mb-2 align-items-center" style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Document Type</label>
                                                        <select class="form-control document_type" id="document_type" tabindex="18" style="border-radius: 4px;">
                                                            <option value="">Select Document Type</option>
                                                            <option value="PASSPORT">PASSPORT</option>
                                                            <option value="VISA">VISA</option>
                                                            <option value="CPR">CPR</option>
                                                            <option value="DRIVING LICENSE">DRIVING LICENSE</option>
                                                            <option value="OFFER LETTER">OFFER LETTER</option>
                                                            <option value="RESUME & CERTIFICATES">RESUME & CERTIFICATES</option>
                                                            <option value="EMPLOYMENT CONTRACT">EMPLOYMENT CONTRACT</option>
                                                            <option value="OTHERS">OTHERS</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 expiry_date_container" style="display: none;">
                                                        <label>Expiry Date</label>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control expiry_date" placeholder="Expiry Date" tabindex="20" style="border-radius: 4px;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Remark</label>
                                                        <textarea class="form-control document_remark" placeholder="Remark" tabindex="21" rows="1" style="border-radius: 4px;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row" style="padding-top:15px;">
                                                    <div class="col-md-12">
                                                        <label>Upload Document</label>
                                                        <input type="file" class="form-input-styled document_file" accept="image/*,application/pdf" multiple tabindex="19" style="border-radius: 4px; display: block !important;" data-fouc="">
                                                        <div class="document_preview d-flex flex-wrap mt-2" style="gap: 8px;"></div>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end"></div>
                                                </div>
                                            </div>
                                        `;
                                        $('#document_container').append(templateRow);
                                    } else {
                                        docs.forEach(function(doc) {
                                            var templateRow = `
                                                <div class="document_row mb-2 align-items-center" style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Document Type</label>
                                                            <select class="form-control document_type" id="document_type" tabindex="18" style="border-radius: 4px;">
                                                                <option value="">Select Document Type</option>
                                                                <option value="PASSPORT">PASSPORT</option>
                                                                <option value="VISA">VISA</option>
                                                                <option value="CPR">CPR</option>
                                                                <option value="DRIVING LICENSE">DRIVING LICENSE</option>
                                                                <option value="OFFER LETTER">OFFER LETTER</option>
                                                                <option value="RESUME & CERTIFICATES">RESUME & CERTIFICATES</option>
                                                                <option value="EMPLOYMENT CONTRACT">EMPLOYMENT CONTRACT</option>
                                                                <option value="OTHERS">OTHERS</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 expiry_date_container" style="display: none;">
                                                            <label>Expiry Date</label>
                                                            <div class="input-group">
                                                                <input type="date" class="form-control expiry_date" placeholder="Expiry Date" tabindex="20" style="border-radius: 4px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Remark</label>
                                                            <textarea class="form-control document_remark" placeholder="Remark" tabindex="21" rows="1" style="border-radius: 4px;"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="padding-top:15px;">
                                                        <div class="col-md-12">
                                                            <label>Upload Document</label>
                                                            <input type="file" class="form-input-styled document_file" accept="image/*,application/pdf" multiple tabindex="19" style="border-radius: 4px; display: block !important;" data-fouc="">
                                                            <div class="document_preview d-flex flex-wrap mt-2" style="gap: 8px;"></div>
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end"></div>
                                                    </div>
                                                </div>
                                            `;
                                            var newRow = $(templateRow);
                                            newRow.find('.document_type').val(doc.document_type);
                                            newRow.find('.expiry_date').val(doc.expiry_date === '0000-00-00' ? '' : doc.expiry_date);
                                            newRow.find('.document_remark').val(doc.remark);
                                
                                            var preview = newRow.find('.document_preview');
                                            var files = doc.document_name.split(',');
                                            files.forEach(function(file) {
                                                if (file.trim() === '') return;
                                                
                                                var previewItem = $('<div class="preview-item" style="display: inline-block; margin-right: 10px;"></div>');
                                                
                                                // Create paper clip icon instead of image preview
                                                var paperClip = $('<i class="icon-attachment" style="font-size: 20px; cursor: pointer;"></i>');
                                                paperClip.attr('title', file); // Show filename on hover
                                                
                                                // Open file in new tab when clicked
                                                paperClip.click(function() {
                                                    window.open('httpdocs/employeeDoc/' + file, '_blank');
                                                });
                                                
                                                previewItem.append(paperClip);
                                                previewItem.append(`<span class="delete-file" data-file="${file}" data-existing="true" title="delete" style="margin-left: 5px; cursor: pointer; color: red;">&times;</span>`);
                                                preview.append(previewItem);
                                            });
                                
                                            // Show expiry date for specific document types
                                            if (['PASSPORT', 'VISA', 'CPR', 'DRIVING LICENSE'].includes(doc.document_type)) {
                                                newRow.find('.expiry_date_container').show();
                                            }
                                            $('#document_container').append(newRow);
                                        });
                                    }
                                    $('#add_document_row').show();
                                    // Reinitialize Uniform for all file inputs in document_container
                                    if (typeof $.fn.uniform !== 'undefined') {
                                        $('#document_container').find('.form-input-styled').uniform();
                                    
                                        // Add bg-pink to the "Choose Files" span inside each .col-md-12
                                        $('#document_container').find('.col-md-12').each(function () {
                                            $(this).find('span.action.btn.btn-light').addClass('bg-pink');
                                        });
                                    }
                                });
                            }
                            
                             if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_employee_action=$(this).attr("name");
                              v_employee_action = v_employee_action.split("_");
                             $.post("../controller/employees/employees_controller_copy.php",{action:'change_employee_status',v_employee_id:v_employee_id,v_employee_status:v_employee_status,v_employee_action:v_employee_action[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_employees_details_list();
                                
                            });
                        }  
                        if($(this).attr("name")=='name_ViewDoc') {
                            // Fetch documents and populate modal table
                            $.post("../controller/employees/employees_controller_copy.php", {action: 'get_employee_documents', v_employee_id: v_employee_id}, function(result) {
                                var docs = JSON.parse(result);
                                var tbody = $('#employeeDocsTable tbody');
                                tbody.empty();
                                if (docs.length === 0) {
                                    tbody.append('<tr><td colspan="4" class="text-center">No documents available</td></tr>');
                                } else {
                                    docs.forEach(function(doc) {
                                        var filesHtml = '';
                                        var files = doc.document_name.split(',');
                                        files.forEach(function(file) {
                                            file = file.trim();
                                            if (file) {
                                                filesHtml += '<a href="httpdocs/employeeDoc/' + file + '" target="_blank">' + file + '</a><br>';
                                            }
                                        });
                                        var expiry = (doc.expiry_date === '0000-00-00') ? '' : doc.expiry_date;
                                        tbody.append('<tr><td>' + doc.document_type + '</td><td>' + filesHtml + '</td><td>' + expiry + '</td><td>' + doc.remark + '</td></tr>');
                                    });
                                }
                                $('#viewDocsModal').modal('show');
                            }).fail(function(xhr, status, error) {
                                console.error("Failed to fetch documents: " + error);
                                swal("Error", "Failed to load documents", "error");
                            });
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
                    var deleted_files = [];
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
                            upload.doUpload("httpdocs/user_upload/employee_image_upload.php?random_no="+randomNum);
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
                        var formData = new FormData();
                        var documentData = [];
                        $('.document_row').each(function(index) {
                            var docType = $(this).find('.document_type').val();
                            var expiryDate = $(this).find('.expiry_date').val();
                            var remark = $(this).find('.document_remark').val();
                            
                            // Collect file names: existing from previews with data-existing, plus new
                            var fileNames = [];
                            
                            // Existing files (not deleted)
                            $(this).find('.document_preview .preview-item .delete-file[data-existing="true"]').each(function() {
                                fileNames.push($(this).data('file'));
                            });
                            
                            // New files
                            var docFiles = $(this).find('.document_file')[0].files;
                            for (var i = 0; i < docFiles.length; i++) {
                                var fileName = randomNum + '_' + docFiles[i].name;
                                fileNames.push(fileName);
                                formData.append('document_files_' + index + '_' + i, docFiles[i], fileName);
                            }
                            
                            if (docType && fileNames.length > 0) {
                                documentData.push({
                                    type: docType,
                                    files: fileNames.join(','),
                                    expiry: expiryDate,
                                    remark: remark
                                });
                            }
                        });
                        var documentDataJSON = JSON.stringify(documentData);
                        
                        formData.append('action', 'update_employee');
                        formData.append('v_employee_name', v_emp_name);
                        formData.append('v_employee_type_id', v_user_type_id);
                        formData.append('v_employee_type_name', v_user_type_name);
                        formData.append('v_employee_code', v_emp_code);
                        formData.append('v_employee_password', v_emp_pwd);
                        formData.append('v_employee_contact_no', v_emp_contact_no);
                        formData.append('v_employee_email_id', v_emp_email_id);
                        formData.append('v_employee_address', v_emp_address);
                        formData.append('v_employee_image', v_session_image);
                        formData.append('v_expertise_id', JSON.stringify(v_expertise_id)); // Stringify if array
                        formData.append('v_expertise_name', JSON.stringify(v_expertise_name)); // Stringify if array
                        formData.append('v_employee_id', v_employee_id);
                        formData.append('v_emp_cpr_number', v_emp_cpr_number);
                        formData.append('v_emp_blood_group', v_emp_blood_group);
                        formData.append('v_emp_passport_no', v_emp_passport_no);
                        formData.append('v_emp_joining_date', v_emp_joining_date);
                        formData.append('v_emp_cpr_expiry_date', v_emp_cpr_expiry_date);
                        formData.append('v_emp_visa_validity', v_emp_visa_validity);
                        formData.append('v_checked_val', checked_val);
                        formData.append('v_emp_tech_type_name', v_emp_tech_type_name);
                        formData.append('v_emp_native_no', v_emp_native_no);
                        formData.append('v_emp_native_address', v_emp_native_address);
                        formData.append('v_emp_visa_type', v_emp_visa_type);
                        formData.append('v_document_data', documentDataJSON);
                        formData.append('deleted_files', JSON.stringify(deleted_files));
                        
                        // Append session image file if selected
                        if(v_session_image !== "" && $("#session_image")[0].files[0]) {
                            formData.append('employee_image', $("#session_image")[0].files[0], v_session_image);
                        }
                        
                        // Send AJAX request
                        $.ajax({
                            url: "../controller/employees/employees_controller_copy.php",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(result, status) {
                                console.log(result);
                                result = $.trim(result);
                                if(result.charAt(0)=='U') {
                                    v_btn_employee_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    clear_text();
                                } else {
                                     v_btn_employee_edit.ladda( 'stop' );
                                     swal("Success", "Employee details updated successfully..", "success");
                                     load_data_to_grid_employees_details_list();
                                    clear_text();
                                }
                            },
                            error: function(xhr, status, error) {
                                v_btn_employee_edit.ladda('stop');
                                swal("Error", "Failed to update employee: " + error, "error");
                                console.error("AJAX Error:", status, error);
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
					
					// Clear documents
                    $('#document_container').empty();
                    addNewDocumentRow(); // Add one empty row
                 }
                 
               
             
                // Handle document type change to show/hide expiry date
                $(document).on('change', '.document_type', function() {
                    var selectedType = $(this).val();
                    var expiryContainer = $(this).closest('.document_row').find('.expiry_date_container');
                    var expiryInput = expiryContainer.find('.expiry_date');
                
                    if (['PASSPORT', 'VISA', 'CPR', 'DRIVING LICENSE'].includes(selectedType)) {
                        expiryContainer.show();
                
                        // Determine top value based on type
                        var topValue = null;
                        if (selectedType === 'VISA') {
                            topValue = $('#emp_visa_validity').val();
                        } else if (selectedType === 'CPR') {
                            topValue = $('#emp_cpr_expiry_date').val();
                        }
                
                        // Always update expiry date based on top value (if available)
                        if (topValue) {
                            expiryInput.val(topValue);
                            expiryInput.prop('readonly', true);
                        } else {
                            // If no top value, clear the field (for VISA/CPR) and make editable
                            if (['VISA', 'CPR'].includes(selectedType)) {
                                expiryInput.val('');
                            }
                            expiryInput.prop('readonly', false);
                        }
                    } else {
                        expiryContainer.hide();
                        expiryInput.val('').prop('readonly', false);
                    }
                });
            
                // Handle multiple file selection and preview for new files
               $(document).on('change', '.document_file', function() {
                    var previewContainer = $(this).closest('.document_row').find('.document_preview');
                    var files = Array.from(this.files);
                    
                    files.forEach(function(file, index) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var previewItem = $('<div class="preview-item"></div>');
                            var deleteButton = $('<span class="delete-file" data-existing="false">&times;</span>');
                            
                            if (file.type.startsWith('image/')) {
                                previewItem.append(
                                    $('<img>').attr('src', e.target.result)
                                             .attr('alt', file.name)
                                             .css({'max-width': '100px', 'height': 'auto'})
                                );
                            } else if (file.type === 'application/pdf') {
                                previewItem.append(
                                    $('<div class="pdf-preview">').text('PDF: ' + file.name)
                                );
                            } else {
                                previewItem.append(
                                    $('<div class="pdf-preview">').text('Unsupported: ' + file.name)
                                );
                            }
                            
                            previewItem.append(deleteButton);
                            previewContainer.append(previewItem);
                        };
                        reader.readAsDataURL(file);
                    });
                });
            
                // Handle deleting a specific file from preview
                $(document).on('click', '.delete-file', function(e) {
                    e.preventDefault();
                    console.log('Delete file clicked:', $(this).data());
                    var previewItem = $(this).closest('.preview-item');
                    var fileInput = $(this).closest('.document_row').find('.document_file');
                    var previewContainer = $(this).closest('.document_preview');
                    
                    // Check if it's an existing file or a new file
                    if ($(this).data('existing') === true) {
                        console.log('Deleting existing file:', $(this).data('file'));
                        // For existing files, just remove from preview and mark for deletion
                        previewItem.remove();
                        
                        // Add to deleted_files array for server processing
                        if (typeof deleted_files === 'undefined') {
                            deleted_files = [];
                        }
                        deleted_files.push($(this).data('file'));
                    } else {
                        console.log('Deleting new file');
                        // For new files, we need to remove from the file input
                        var files = Array.from(fileInput[0].files);
                        var fileNameToDelete = $(this).closest('.preview-item').find('img, .pdf-preview').text() || 
                                              $(this).closest('.preview-item').find('img').attr('alt');
                        
                        // Remove the file from the input
                        var dataTransfer = new DataTransfer();
                        for (var i = 0; i < files.length; i++) {
                            if (files[i].name !== fileNameToDelete) {
                                dataTransfer.items.add(files[i]);
                            }
                        }
                        fileInput[0].files = dataTransfer.files;
                        
                        // Remove the preview
                        previewItem.remove();
                    }
                });

                // Function to add new document row (empty or populated)
                function addNewDocumentRow(doc = null) {
                    var templateRow = `
                        <div class="document_row mb-2 align-items-center" style="background: white; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Document Type</label>
                                    <select class="form-control document_type" id="document_type" tabindex="18" style="border-radius: 4px;">
                                        <option value="">Select Document Type</option>
                                        <option value="PASSPORT">PASSPORT</option>
                                        <option value="VISA">VISA</option>
                                        <option value="CPR">CPR</option>
                                        <option value="DRIVING LICENSE">DRIVING LICENSE</option>
                                        <option value="OFFER LETTER">OFFER LETTER</option>
                                        <option value="RESUME & CERTIFICATES">RESUME & CERTIFICATES</option>
                                        <option value="EMPLOYMENT CONTRACT">EMPLOYMENT CONTRACT</option>
                                        <option value="OTHERS">OTHERS</option>
                                    </select>
                                </div>
                                <div class="col-md-3 expiry_date_container" style="display: none;">
                                    <label>Expiry Date</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control expiry_date" placeholder="Expiry Date" tabindex="20" style="border-radius: 4px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Remark</label>
                                    <textarea class="form-control document_remark" placeholder="Remark" tabindex="21" rows="1" style="border-radius: 4px;"></textarea>
                                </div>
                            </div>
                            <div class="row" style="padding-top:15px;">
                                <div class="col-md-12">
                                    <label>Upload Document</label>
                                    <input type="file" class="form-input-styled document_file bg-pink" accept="image/*,application/pdf" multiple tabindex="19" style="border-radius: 4px;" data-fouc="">
                                    <div class="document_preview d-flex flex-wrap mt-2" style="gap: 8px;"></div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end"></div>
                            </div>
                        </div>
                    `;
                    var newRow = $(templateRow);
                    if (doc) {
                        newRow.find('.document_type').val(doc.document_type).change();
                        newRow.find('.expiry_date').val(doc.expiry_date === '0000-00-00' ? '' : doc.expiry_date);
                        newRow.find('.document_remark').val(doc.remark);
                        var preview = newRow.find('.document_preview');
                        var files = doc.document_name.split(',');
                        files.forEach(function(file) {
                            if (file.trim() === '') return;
                            var truncatedFileName = truncateFileName(file, 10);
                            var previewItem = $('<div class="preview-item" style="display: flex; align-items: center; gap: 5px;"></div>');
                            previewItem.append(`
                                <a href="httpdocs/employeeDoc/${file}" target="_blank" style="text-decoration: none;">
                                    <i class="icon-paper-clip" style="color: #555;"></i>
                                    <span>${truncatedFileName}</span>
                                </a>
                            `);
                            previewItem.append(`<span class="delete-file" data-file="${file}" data-existing="true" style="cursor: pointer; color: red;">&times;</span>`);
                            preview.append(previewItem);
                        });
                    }
                    $('#document_container').append(newRow);
                    newRow.find('.document_type').change();
                    // Reinitialize form styling library for new file inputs
                    if (typeof $.fn.uniform !== 'undefined') {
                        newRow.find('.form-input-styled').uniform();
                    }
                }

                // Handle adding new document row
                $(document).on('click', '#add_document_row', function() {
                    addNewDocumentRow();
                    $(this).closest(".col-md-12").find("span.action.btn.btn-light").addClass("bg-pink");
                });
                
                  
                

});