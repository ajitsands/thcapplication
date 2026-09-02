$(document).ready(function(){
 
  $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
 var v_customer_location_id,v_customer_location_status;
                  
                    $('#btn_customer_location_edit').hide();
                    $('#btn_customer_location_new').hide();
                     $('#div_contact_person_building_code').hide();
                     $('#div_contact_person_building_name').hide();
                     
                   
                     
                //  select_building_for_location
                  
                  //load customer details
        		 $.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_combo_customer_location.php"
                		
                		 }).done(function(data){
                
                			$("#div_customer_details").html(data);
                			$("#select_customer_for_customer_location").select2();
        		});
        		
        		
        		 $.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_facility_location_combo.php"
                		
                		 }).done(function(data){
                
                			$("#div_customer_location_details").html(data);
                			$("#select_location_for_customer_location").select2();
        		});
        		$.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_facility_building_combo.php"
                		
                		 }).done(function(data){
                
                			$("#div_select_building").html(data);
                			$("#select_building_for_location").select2();
        		});
        		   $(document.body).on('change','#select_customer_for_customer_location',function(){  
        		      
        		     var v_customer_id_customer_location=$("#select_customer_for_customer_location option:selected").val();
        		     console.log("inside");
        		     $.post("../controller/customer_location/customer_location_controller.php",{action:'select_contact_person_details',v_customer_id_customer_location:v_customer_id_customer_location}
                            , function(result,status)
                            {
                                var obj= jQuery.parseJSON(result);
                                
                                $("#txt_contact_person_name").val(obj.data[0].customer_contact_person_name);
                                $("#txt_contact_person_number_build").val(obj.data[0].customer_contact_person_no);
                                
                            });
        		     
        		 });
                     
                      $(document.body).on('change','#select_building_for_location',function(){ 
                          
                       
                            var v_building_id=$("#select_building_for_location option:selected").val();
                            var v_building_name_code=$("#select_building_for_location option:selected").text();
                             v_building_name_code = v_building_name_code.split("--");
                           
                             $('#txt_contact_person_building_code').val(v_building_name_code[0]);
                             $('#txt_contact_person_building_name').val(v_building_name_code[1]);
                            
                           
                            });
                   
                    
                    
                     
                    var v_btn_customer_location_add = $('#btn_customer_location_add').ladda();
                    var v_btn_customer_location_edit = $('#btn_customer_location_edit').ladda();
                    var v_btn_customer_location_new = $('#btn_customer_location_new').ladda();

                    var v_list_of_customer_location_table = $('#list_of_customer_location').DataTable({});
                     load_data_to_grid_customer_location_details_list();
                      
                     
                    
                   $('#txt_contact_person_building_code').keydown(function (e) {
                       var k = e.which;
                        var ok = k >= 65 && k <= 90 || // A-Z
                            k >= 96 && k <= 105 || // a-z
                            k >= 35 && k <= 40 || // arrows
                            k == 8 || // Backspaces
                            k >= 48 && k <= 57; // 0-9
                
                        if (!ok){
                            e.preventDefault();
                        }        
                    });
                         
                         $('#session_image').change(function (e) {
                             var fileInput = $("#session_image")[0];
                             if (fileInput.files && fileInput.files[0]) {
                                 var doc_file_obj = fileInput.files[0];
                                 var randomNum = Math.ceil(Math.random() * 999999);
                                 var doc_file1 = doc_file_obj.name.replace(/[^a-zA-Z0-9._-]/g, "_");
                                 v_session_image = $.trim(randomNum + '_' + doc_file1);
                                 $('#building_img_name').text(v_session_image);
                                 var upload = new ns.Upload(doc_file_obj, $("#session_image"));
                                 upload.doUpload("../httpdocs/user_upload/building_image_upload.php?random_no=" + randomNum, v_session_image);
                             } else {
                                 v_session_image = "default.jpg";
                                 $('#building_img_name').text('default.jpg');
                                 $('#building_img_preview').empty();
                             }
                         });
                          
                          
                          //Customer location details
                     v_btn_customer_location_add.click(function(){
                                 v_btn_customer_location_add.ladda( 'start' );
                                 var v_building_id=$("#select_building_for_location option:selected").val();
                                 
                                 var v_customer_id_customer_location=$("#select_customer_for_customer_location option:selected").val();
                                 var v_customer_name_customer_location_code_name=$("#select_customer_for_customer_location  option:selected").text();
                                 v_customer_name_customer_location_code_name=v_customer_name_customer_location_code_name.split("--");
                                var v_customer_name_customer_location=v_customer_name_customer_location_code_name[1];
                                  var v_customer_name_customer_location_code=v_customer_name_customer_location_code_name[0];
                                 var v_location_id_customer_location=$("#select_location_for_customer_location option:selected").val();
                                 var v_location_name_customer_location=$("#select_location_for_customer_location option:selected").text();
                                 v_location_name_customer_location_dis=v_location_name_customer_location.split("--");
                                 //alert(v_location_name_customer_location);
                                 v_location_name_customer_location=v_location_name_customer_location_dis[1];
                                 v_location_name_customer_location_code=v_location_name_customer_location_dis[0];
                                 console.log(v_location_name_customer_location);
                                  console.log(v_location_name_customer_location_code);
                                 var v_building_name_customer_location=$("#txt_contact_person_building_name").val();
                                 var v_building_address_customer_location=$("#txt_Building_address").val();
                                 var v_contact_person_name_customer_location=$("#txt_contact_person_name").val();
                                 var v_contact_person_number_customer_location=$("#txt_contact_person_number_build").val();
                                 var v_contact_person_building_code=$('#txt_contact_person_building_code').val();
                                        
                                 var v_saved_img = $.trim($('#building_img_name').text());
                                 if (!v_saved_img || v_saved_img === "" || v_saved_img === "null" || v_saved_img.indexOf('fakepath') !== -1) {
                                     v_saved_img = "default.jpg";
                                 }
                                 v_session_image = v_saved_img;
                                     
                                 if($.trim(v_building_name_customer_location)==""||typeof v_customer_id_customer_location === "undefined"|| typeof v_location_id_customer_location === "undefined")
                                 
                                 {
                                     swal("Warning","Please provide all the details ....", "warning");
                                     v_btn_customer_location_add.ladda( 'stop' );
                                     return false;
                                 }
                               
                                else
                                {         
                                     $.post("../controller/customer_location/customer_location_controller.php",{action:'add_customer_location',v_customer_id_customer_location:v_customer_id_customer_location,v_customer_name_customer_location:v_customer_name_customer_location,v_location_id_customer_location:v_location_id_customer_location,v_location_name_customer_location:v_location_name_customer_location,v_building_name_customer_location:v_building_name_customer_location,v_building_address_customer_location:v_building_address_customer_location,v_contact_person_name_customer_location:v_contact_person_name_customer_location,v_contact_person_number_customer_location:v_contact_person_number_customer_location,v_contact_person_building_code:v_contact_person_building_code,v_location_name_customer_location_code:v_location_name_customer_location_code,v_customer_name_customer_location_code:v_customer_name_customer_location_code,v_building_id:v_building_id,v_building_image:v_session_image}
                                            , function(result,status)
                                            {
                                              //alert(result);
                                             // console.log(result);
                                            result = $.trim(result);
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_customer_location_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 v_btn_customer_location_add.ladda( 'stop' );
                                                 swal("Success", "Customer building details added successfully..", "success");
                                                 load_data_to_grid_customer_location_details_list();
                                                 clear_text();
                                                
                                                                            }
                                                                            
                                                                             
                                                                        
                                                                    });
                                    
                                   
                                    
                                 }
                  
                });
                    
                    //load data to customer location datatable
                    function load_data_to_grid_customer_location_details_list()
                     {
                         var i=1;
                    v_list_of_customer_location_table.destroy();
                     v_list_of_customer_location_table = $('#list_of_customer_location').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/customer_location/customer_location_controller.php',
                                 'data': {
                                    action: 'customer_location_list_view'
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
                            "columns": [
                                
                                  { "data": null,className: "text-center",
                                        "render": function(data, type, full, meta) {
                                            return i++;
                                          },
                                    },
                                 
                                 { "data": "customer_location_id","visible":false },
                                 { "data": "customer_id","visible":false },
                                 
                                 { "data": "customer_name" },
                                 { "data": "location_id","visible":false },
                                 { "data": "location_name"},
                                { "data": "building_code","visible":false },
                                { "data": "building_image",
                                  render: function ( data, type, rows, meta ) {
                                      var raw = $.trim(data || '');
                                      if (!raw || raw === 'null' || raw === 'NA' || raw === 'default.jpg') {
                                          return '<div align="center"><img src="../httpdocs/images/building_image/default.jpg" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;border:1px solid #cbd5e1;box-shadow:0 1px 2px rgba(0,0,0,0.08);"/></div>';
                                      }
                                      var clean = raw.split('\\').pop().split('/').pop();
                                      var sanitized = clean.replace(/[^a-zA-Z0-9._-]/g, '_');
                                      var primarySrc = '../httpdocs/images/building_image/' + sanitized;
                                      var rawSrc = '../httpdocs/images/building_image/' + encodeURIComponent(clean);
                                      var fallbackSrc = '../httpdocs/images/' + sanitized;
                                      var defaultSrc = '../httpdocs/images/building_image/default.jpg';
                                      return '<div align="center"><img src="' + primarySrc + '" onerror="if(this.getAttribute(\'data-step\')!==\'1\'){this.setAttribute(\'data-step\',\'1\');this.src=\'' + rawSrc + '\';}else if(this.getAttribute(\'data-step\')===\'1\'){this.setAttribute(\'data-step\',\'2\');this.src=\'' + fallbackSrc + '\';}else{this.onerror=null;this.src=\'' + defaultSrc + '\';}" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;border:1px solid #cbd5e1;box-shadow:0 1px 2px rgba(0,0,0,0.08);"/></div>';
                                  }
                                },
                                 { "data": "building_name",
            					   render: function ( data, type, rows, meta ) {
            						return rows['building_code']+'--'+rows['building_name'];
            								
            									
            
            							 },
                                     
                                 },
            					  
                                 { "data": "building_address"},
                                 { "data": "contact_person_name"},
                                 { "data": "contact_person_no"},
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
                                 },
                                 {
                                    "data": "customer_location_id",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "CustomerFacilityModify": "Edit",
                                            "CustomerFacilityModify": "Active",
                                            "CustomerFacilityModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="CustomerFacilityModify")
                                        {
                                             dropdownHTML += '<a href="#" class="dropdown-item" name="name_Edit" style="color: orange;"><i class="icon-database-edit2"></i>Edit</a><a href="#" class="dropdown-item" name="name_Active" style="color: green;"><i class="icon-checkmark2"></i>Active</a><a href="#" class="dropdown-item" name="name_Deactive" style="color: red;"><i class="icon-cross3"></i>Deactive</a>';
                                        }
                                        else
                                        {
                                             dropdownHTML += '<label class="dropdown-item text-danger">You have no privilege</label>';
                                        }
                                
                                        dropdownHTML += '</div></div></div>';
                                
                                        return dropdownHTML;
                                
                                    }
                                }
                                //  { "data": "customer_location_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           var dropdownOptions = {
                                //             "Edit": "Edit",
                                //             "Activate": "Active",
                                //             "Deactivate": "Deactive"
                                //         };
                                
                                //         var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                //             return permissions.includes(option);
                                //         });
                                
                                //         var dropdownHTML = '<div class="list-icons divDropdownForExpertise"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                //         if (filteredOptions.length === 0) {
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
                                //  { "data": "customer_location_id",
                                //       render: function ( data, type, rows, meta ) {
                                //           str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_product_master" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Active" style="color:green"><i class="icon-database-edit2"></i> Active</a><a href="#" class="dropdown-item" name="Deactive" style="color:red"><i class="icon-database-edit2"></i> Deactive</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                                
                             ],
                             pageLength: 30,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7,8,9,10,11] }, 
            					
            				// ],

                             "initComplete": function( settings, json ) {
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 //$("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                 
                 
                     $('#list_of_customer_location tbody').on('click', 'a', function(){
                      
                        var $row = $(this).closest('tr');
                        var customer_location_data = v_list_of_customer_location_table.row($row).data();
                        v_customer_location_id  = customer_location_data.customer_location_id;
                         v_customer_location_status  = customer_location_data.customer_location_status;
                          $('#div_contact_person_building_code').show();
                            $('#div_contact_person_building_name').show();
                             
                         if($(this).attr("name")=='name_Edit')
                         {
                         
                            edit_customer_location_details(v_customer_location_id);
            			    $( '#btn_customer_location_add').hide();
                            $( '#btn_customer_location_edit').show();
                            $( '#btn_customer_location_new').show();
                            $( '#div_contact_person_building_name').hide();
                            	
               
            			 }
            			 
            			  function edit_customer_location_details(v_customer_location_id)
                            {
                                $("#txt_customer_location_id").val(v_customer_location_id);  
                                $("#txt_Building_address").val(customer_location_data.building_address);
                                $("#select_customer_for_customer_location").val(customer_location_data.customer_id).trigger("change");
								$("#txt_contact_person_name").val(customer_location_data.contact_person_name	);
								$("#txt_contact_person_number_build").val(customer_location_data.contact_person_no);
                                $.ajax({
                                    type: "POST",
                                    url: "../view/customer_location/customer_facility_building_combo_edit.php"
                                }).done(function(data) {
                                
                                    $("#div_select_building").html(data);
                                
                                    $("#select_building_for_location").select2({
                                        width: '100%'
                                    });
                                
                                    // Set selected building after loading
                                    $("#select_building_for_location")
                                        .val(customer_location_data.building_id)
                                        .trigger("change");
                                
                                });
                                // $("#select_building_for_location").val(customer_location_data.building_id).trigger("change");
                               
                                $("#select_location_for_customer_location").val(customer_location_data.location_id).trigger("change");
                                
                               
                                 $("#txt_contact_person_building_code").val(customer_location_data.building_code);
                                 var rawImg = $.trim(customer_location_data.building_image || '');
                                 var cleanImg = rawImg.split('\\').pop().split('/').pop();
                                 var sanitizedImg = cleanImg.replace(/[^a-zA-Z0-9._-]/g, '_');
                                 $('#building_img_name').text(sanitizedImg || cleanImg);
                                 if (sanitizedImg && sanitizedImg !== 'null' && sanitizedImg !== 'NA' && sanitizedImg !== 'default.jpg') {
                                     var primaryP = '../httpdocs/images/building_image/' + sanitizedImg;
                                     var rawP = '../httpdocs/images/building_image/' + encodeURIComponent(cleanImg);
                                     var fallbackP = '../httpdocs/images/' + sanitizedImg;
                                     var defaultP = '../httpdocs/images/building_image/default.jpg';
                                     $("#building_img_preview").html("<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='" + primaryP + "' onerror=\"if(this.getAttribute('data-step')!=='1'){this.setAttribute('data-step','1');this.src='" + rawP + "';}else if(this.getAttribute('data-step')==='1'){this.setAttribute('data-step','2');this.src='" + fallbackP + "';}else{this.onerror=null;this.src='" + defaultP + "';}\">");
                                 } else {
                                     $("#building_img_preview").html("<img style='width:38px;height:38px;object-fit:cover;border-radius:4px;border:1px solid #c2daeb;' src='../httpdocs/images/building_image/default.jpg'>");
                                 }
                                
                            }
                            
                             if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
							 var v_action_status=$(this).attr("name");
							 v_action_status = v_action_status.split("_");
                             $.post("../controller/customer_location/customer_location_controller.php",{action:'change_customer_location_status',v_customer_location_id:v_customer_location_id,v_customer_location_status:v_customer_location_status,v_action_status:v_action_status[1]}
                                , function(result,status)
                                {
                                   //alert(result);
                                   load_data_to_grid_customer_location_details_list();
                                
                            });
                        }
                          
                        
        }); 
                     //edit click
                    v_btn_customer_location_edit.click(function(){
                            v_btn_customer_location_edit.ladda( 'start' );
                                var v_customer_id_customer_location=$("#select_customer_for_customer_location option:selected").val();
                                var v_customer_name_customer_location=$("#select_customer_for_customer_location option:selected").text();
                                var v_location_id_customer_location=$("#select_location_for_customer_location option:selected").val();
                                var v_location_name_customer_location=$("#select_location_for_customer_location option:selected").text();
                                var v_location_name_customer_location_dis=v_location_name_customer_location.split("--");
                                //alert(v_location_name_customer_location);
                                v_location_name_customer_location=v_location_name_customer_location_dis[1];
                                v_location_name_customer_location_code=v_location_name_customer_location_dis[0];
                                var v_building_name_customer_location=$("#txt_contact_person_building_name").val();
                                var v_building_address_customer_location=$("#txt_Building_address").val();
                                var v_contact_person_name_customer_location=$("#txt_contact_person_name").val();
                                var v_contact_person_number_customer_location=$("#txt_contact_person_number_build").val();
                                var v_customer_location_id=$("#txt_customer_location_id").val();
                                var v_contact_person_building_code=$('#txt_contact_person_building_code').val();
                                var v_customer_location_status = 'Active';
                                var v_saved_img = $.trim($('#building_img_name').text());
                                if (!v_saved_img || v_saved_img === "" || v_saved_img === "null" || v_saved_img.indexOf('fakepath') !== -1) {
                                    v_saved_img = "default.jpg";
                                }
                                v_session_image = v_saved_img;
                                if($.trim(v_customer_location_id)===""|| $.trim(v_customer_name_customer_location)===""|| $.trim(v_location_name_customer_location)===""||$.trim(v_building_name_customer_location)===""||typeof v_customer_id_customer_location === "undefined"||typeof v_location_id_customer_location === "undefined")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_customer_location_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/customer_location/customer_location_controller.php",{action:'update_customer_location',v_customer_id_customer_location:v_customer_id_customer_location,v_customer_name_customer_location:v_customer_name_customer_location,v_location_id_customer_location:v_location_id_customer_location,v_location_name_customer_location:v_location_name_customer_location,v_building_name_customer_location:v_building_name_customer_location,v_building_address_customer_location:v_building_address_customer_location,v_contact_person_name_customer_location:v_contact_person_name_customer_location,v_contact_person_number_customer_location:v_contact_person_number_customer_location,v_customer_location_id:v_customer_location_id,v_customer_location_status:v_customer_location_status,v_contact_person_building_code:v_contact_person_building_code,v_building_image:v_session_image,v_location_name_customer_location_code:v_location_name_customer_location_code}
                                        , function(result,status)
                                        {
                                            v_btn_customer_location_edit.ladda( 'stop' );
                                            console.log(result);
                                            result = $.trim(result);
                                            if(result.charAt(0)==='U')
                                            {
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                 swal("Success", "Customer location details updated successfully..", "success");
                                                 load_data_to_grid_customer_location_details_list();
                                                 clear_text();
												 location.reload();
                                            }
                                        }).fail(function() {
                                            v_btn_customer_location_edit.ladda( 'stop' );
                                            swal("Error", "Server error while updating.", "error");
                                        });
                                
                             }
                          
                });  
                    
                    $( '#btn_customer_location_new' ).click(function(){
                  
                        // $( '#btn_customer_location_add' ).show();
                        // $( '#btn_customer_location_edit' ).hide();
                        // $( '#btn_customer_location_new' ).hide();
                        // $( '#div_contact_person_building_name').hide();
                        // clear_text();
                        location.reload();
                    })
                    
                    //function clear text
                   function clear_text()
                 {
                     
                      $("#select_building_for_location").val(null).trigger("change");
                    $("#select_customer_for_customer_location").val(null).trigger("change");
                    $("#select_location_for_customer_location").val(null).trigger("change");
                     $("#select_product_item_for_master").val(null).trigger("change");
                     $("#sel_new_existing").val(null).trigger("change");
                     
                    $("#txt_customer_location_id").val('');
                    $("#txt_contact_person_number_build").val('');
                     $("#txt_contact_person_name").val('');
					 $("#txt_building_name").val('');
					 $("#txt_Building_address").val('');
					 $("#txt_contact_person_building_name").val('')
                     $("#txt_contact_person_building_code").val('');
                     $("#session_image").val('');
                     $("#building_img_name").text('');
                     $("#building_img_preview").empty();
                      $.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_combo_customer_location.php"
                		
                		 }).done(function(data){
                
                			$("#div_customer_details").html(data);
                			$("#select_customer_for_customer_location").select2();
        		});
        		
        		
        		 $.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_facility_location_combo.php"
                		
                		 }).done(function(data){
                
                			$("#div_customer_location_details").html(data);
                			$("#select_location_for_customer_location").select2();
        		});
        		$.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_facility_building_combo.php"
                		
                		 }).done(function(data){
                
                			$("#div_select_building").html(data);
                			$("#select_building_for_location").select2();
        		});
                      
                 }
    
	$("#bootbox_location_btn").click(function(){
      
        $('#modal_location').modal('show');
  });
    //add building_modal
	$("#bootbox_building_btn").click(function(){
      
        $('#modal_building').modal('show');
       
  });    
  
     //New Customer Creation      
        $('#error_email').hide();
         $('#btn_customer_edit').hide();
        $('#btn_customer_new').hide();            
        var v_btn_customer_add = $('#btn_customer_add').ladda();
                    
               
                    
var emailTouched = false;

$('#modal_customer_add').on('shown.bs.modal', function () {

    emailTouched = false;

    $("#txt_customer_email_id")
        .off('input blur')
        .on('input', function () {
            emailTouched = true;
        })
        .on('blur', function () {

            if (!emailTouched) {
                return;
            }

            var valueToTest = $.trim($(this).val());

            if (valueToTest == "") {
                return;
            }

            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;

            if (!testEmail.test(valueToTest)) {
                swal("Error", "Please enter a valid email address.", "warning");
                $(this).focus();
            }

        });

});
                 
				// Check if customer contact number already exists
				$('#txt_customer_contact_no').blur(function() {
					var v_customer_contact_no = $.trim($("#txt_customer_contact_no").val());
					$("#txt_contact_person_number").val(v_customer_contact_no);
					if(v_customer_contact_no != "")
					{
						$.post("../controller/customer/customer_controller.php", {action:'check_contact_person_number', v_customer_contact_no:v_customer_contact_no}, function(result, status) { 
							try {
								var obj = jQuery.parseJSON(result);
								var count = (obj && obj.data) ? obj.data.length : (Array.isArray(obj) ? obj.length : 0);
								if(count > 0)
								{
									swal("Warning", "Customer contact number already exists", "warning");
									$("#txt_customer_contact_no").val('');
									$("#txt_contact_person_number").val('');
								}
							} catch(e) {}
						});
					}
				});
				
				// Check if CPR/CR number already exists
				$("#txt_cpr_cr_number").blur(function(){
					var v_cpr_cr_number = $.trim($("#txt_cpr_cr_number").val());
					if(v_cpr_cr_number != "")
					{
						$.post("../controller/customer/customer_controller.php", {action:'check_cpr_cr_number', v_cpr_cr_number:v_cpr_cr_number}, function(result, status) { 
							try {
								var obj = jQuery.parseJSON(result);
								var count = (obj && obj.data) ? obj.data.length : (Array.isArray(obj) ? obj.length : 0);
								if(count > 0)
								{
									swal("Warning", "CPR/CR number already exists", "warning");
									$("#txt_cpr_cr_number").val('');
								}
							} catch(e) {}
						});
					}
				});
				
				$('#txt_customer_name').blur(function() {
					var v_customer_name = $("#txt_customer_name").val();   
					$("#txt_contact_person").val(v_customer_name);
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
                                                   
                                                    clear_text_customer();
                                                   
                
                                                
                                                }
                                                else 
                                                {
                                                     v_btn_customer_add.ladda( 'stop' );
                                                     swal("Success", "New customer added successfully..", "success");
                                                      
                                                     clear_text_customer();
                                                      $.ajax({
                		type: "POST",
                		url: "../view/customer_location/customer_combo_customer_location.php"
                		
                		 }).done(function(data){
                
                			$("#div_customer_details").html(data);
                			$("#select_customer_for_customer_location").select2();
        		});
                                                 
                                            
                                         
                                   }
							
                        });
                        
                     }
					 
                                });
                    }
                  
     });
  function clear_text_customer()
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
                    //var v_exp_id=$("#txt_exp_id").val();
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
                                   console.log(result);
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
                                     
                                  
                                    $("#txt_location_name").val('');
                                     $("#txt_location_code").val('');
                                     
                                   $.ajax({
                                    		type: "POST",
                                    		url: "../view/customer_location/customer_facility_location_combo.php"
                                    		
                                    		 }).done(function(data){
                                    
                                    			$("#div_customer_location_details").html(data);
                                    			$("#select_location_for_customer_location").select2();
                            		});
                						
                                }
                                
                                 
                            
                        });
                         
                       
                        
                     }
                  
                });
            
        var v_btn_building_add = $('#btn_building_add').ladda();
        
					   	$("#txt_building_code").blur(function(){
							var v_building_code = $.trim($("#txt_building_code").val());
							if(v_building_code != '')
							{
								$.post("../controller/building/building_controller.php", {action:'check_building_code', v_building_code:v_building_code}, function(result, status) { 
									try {
										var obj = jQuery.parseJSON(result);
										var count = (obj && obj.data) ? obj.data.length : (Array.isArray(obj) ? obj.length : 0);
										if(count > 0)
										{
											swal("Warning", "Building code already exists", "warning");
											$("#txt_building_code").val('');
										}
									} catch(e) {}
								});
							}
						});
							   
					   
					   
					   //end check


                v_btn_building_add.click(function(){
                                v_btn_building_add.ladda( 'start' );
								v_building_name=$("#txt_building_name").val();
							//	v_building_code=$("#txt_building_code").val();
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
                                          
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_building_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                $("#txt_building_name").val('');
                                            $("#txt_building_code").val('');
                                            $("#txt_building_address").val('');
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
                                                                   
                                            $("#txt_building_name").val('');
                                            $("#txt_building_code").val('');
                                            $("#txt_building_address").val('');
                                                                   
                                
                                                                
                                                                }
                                                                else 
                                                                {
                                                                     v_btn_building_add.ladda( 'stop' );
                                                                     swal("Success", "New building added successfully..", "success");
                                            $("#txt_building_name").val('');
                                            $("#txt_building_code").val('');
                                            $("#txt_building_address").val('');              
                                                                  
                                                                     $.ajax({
                                                            		type: "POST",
                                                            		url: "../view/customer_location/customer_facility_building_combo.php"
                                                            		 
                                                            		 }).done(function(data){
                                        
                                                            			$("#div_select_building").html(data);
                                        								$("#select_building_for_location").select2();
                        						                    });
                                                                }
                                                                
                                                                 
                                                            
                                                          });
                                                
                                                //end
                                                 
                                                 
                                                 
                						
                                            }
                                            
                                             
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
             
});