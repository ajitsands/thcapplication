$(document).ready(function(){
    var cust_code_view_name,v_cust_id,v_assets_attachment,attachments =[];
	

 //$(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });

   $('#btn_edit_assets').hide();
     $('#btn_new_assets').hide();
  $('#div_asset_type_select').load("amc/assets_type_combo.php"); 
    var v_btn_add_assets = $('#btn_add_assets').ladda();
	var v_btn_edit_assets = $('#btn_edit_assets').ladda();
	var v_btn_new_assets = $('#btn_new_assets').ladda();
	
	var v_list_of_customer_assets_details_table = $('#list_of_customer_asset_details').DataTable({});
       load_data_to_grid_customer__assets_details_list();
    
	
	$('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });
    
    //add location_modal
						$("#bootbox_location_btn").click(function(){
                          
                            $('#modal_location').modal('show');
                      });
					    //add building_modal
						$("#bootbox_building_btn").click(function(){
                          
                            $('#modal_building').modal('show');
                           
                      });    

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
            					 doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
            					 v_attachment=$.trim(randomNum+'_'+doc_file1);
            					 attachments.push(v_attachment);
            					var success = upload.doUpload("../httpdocs/user_upload/amc_attachements.php?random_no="+randomNum);
            				} 
            		 }
    
    
 //fill combo_customer location
                             $.ajax({
                        		type: "POST",
                        		url: "../view/amc/select_location.php"
                        		
                        		 }).done(function(data){
    
                        			$("#div_cust_location").html(data);
    								$("#select_location_for_customer_location").select2();
							});
						//fill combo_building  Building				
						 $.ajax({
                        		type: "POST",
                        		url: "../view/amc/select_building.php"
                        	
                        		 }).done(function(data){
                        		     
                        			
                        			$("#div_cust_building").html(data);
    								$("#select_building_for_location").select2();
							});
										
										 //fill combo_customer combo
                             $.ajax({
                            		type: "POST",
                            		url: "../view/amc/customer_combo_customer_location_modal.php"
                            		
                            		 }).done(function(data){
        
                            			$("#div_cust_load_modal").html(data);
        								$("#select_customer_for_customer_location").select2();
							});
							
						
    							 $.ajax({
                                		type: "POST",
                                		url: "../view/customer_location/customer_combo_customer_location.php",
                                		
                                		
                                		 }).done(function(data){
            
                                			$("#div_customer_details_asset").html(data);
            								$("#select_customer_for_customer_location").select2();
    							});
    							
    							 $.ajax({
                                		type: "POST",
                                		url: "../view/amc/category_combo_div_load.php",
                                		
                                		
                                		 }).done(function(data){
            
                                			$("#div_category_select").html(data);
            								$("#select_category").select2();
    							});
										

                //for barcode generation
                var location_code_view,building_code_view,cust_location_building,cust_code_view,cust_code_name;
                  $('#div_cust_location').change(function (e) {
        			        location_code_view=$("#select_location_for_customer_location option:selected").text();
        			      
        			        location_code_view=location_code_view.split('--');
        			        location_code_view=location_code_view[0];
        			        cust_location_building='THC'+'-'+cust_code_view+'-'+location_code_view+'-'+building_code_view;
        			        
        			         $('#txt_barcode_generate_values').val(cust_location_building);
        			         //alert(location_code_view+building_code_view);
							 // generateBarcode(cust_location_building);
							// alert(cust_location_building);
        		            });
	             $('#div_cust_building').change(function (e) {
		        building_code_view=$("#select_building_for_location option:selected").text();
		        
		        building_code_view=building_code_view.split('--');
		        building_code_view=building_code_view[0];
		        cust_location_building='THC'+'-'+cust_code_view+'-'+location_code_view+'-'+building_code_view;
		        $('#txt_barcode_generate_values').val(cust_location_building);
		        //alert(location_code_view+building_code_view);
				// generateBarcode(cust_location_building);
				// alert(cust_location_building);
	            });
	            
             $('#div_customer_details_asset').change(function (e) {
		         v_cust_id=$("#select_customer_for_customer_location option:selected").val();
		         cust_code_view_name=$("#select_customer_for_customer_location option:selected").text();
		        
		        cust_code_view_name=cust_code_view_name.split('--');
		        cust_code_view=cust_code_view_name[0];
		        cust_code_name=cust_code_view_name[1];
		        
		        cust_location_building='THC'+'-'+cust_code_view+'-'+location_code_view+'-'+building_code_view;
		        $('#txt_barcode_generate_values').val(cust_location_building);
		        //alert(location_code_view);
				// generateBarcode(cust_location_building);
				// alert(cust_location_building);
	            });
               //Assets  insert details
                    v_btn_add_assets.click(function(){
                        
                                v_btn_add_assets.ladda( 'start' );
								var assets_attachment_file=attachments[0];
								var v_asset_ref_no=$("#barcodeValue").val();
								var v_asset_category_id=$("#select_category option:selected").val();
							    var v_asset_category_name=$("#select_category option:selected").text();
								var v_asset_type_id=$("#select_asset_type option:selected").val();
								var v_asset_type_name=$("#select_asset_type option:selected").text();
								
								var v_location_id=$("#select_location_for_customer_location option:selected").val();
								var v_asset_location_details=$("#select_location_for_customer_location option:selected").text();
								v_asset_location_details=v_asset_location_details.split("--");
								var v_asset_location=v_asset_location_details[1];
								var location_code=v_asset_location_details[0];
								
								var v_asset_building_id=$("#select_building_for_location option:selected").val();
								var v_asset_building_details=$("#select_building_for_location option:selected").text();
							
								v_asset_building_details=v_asset_building_details.split("--");
								v_asset_building_code=v_asset_building_details[0];
								v_asset_building_name=v_asset_building_details[1];
								
								//alert(v_location_id+','+v_asset_location+','+location_code+','+v_asset_building_id+','+v_asset_building_name+','+v_asset_building_code);
								
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
							
								
							//	var v_asset_spgen=$("#select_type option:selected").text();
								//var v_asset_sp_des=$("#txt_type_des").val();
							

								if(assets_attachment_file===""||typeof assets_attachment_file === "undefined")
                                    {
                                        
                                        assets_attachment_file="default.jpg";
                                    }
								//if($.trim(v_is_warentee)!="NA" && $.trim(v_warentee_end_date)==="")
								if($.trim(v_is_warentee)=="YES" && $.trim(v_warentee_end_date)==="")
                                    {
                                        swal("Warning","Please provide Warentee End Date ....", "warning");
										v_btn_add_assets.ladda( 'stop' );
										return false;
                                    }
								 if($.trim(v_asset_ref_no)==="")
								 {
								     //console.log(result);
									 swal("Warning","Please generate asset code", "warning");
																		v_btn_add_assets.ladda( 'stop' );
																		return false;
								 }

                                if($.trim(v_asset_ref_no)===""||typeof v_asset_category_name === "undefined"||typeof v_asset_type_name === "undefined"||typeof cust_code_view === "undefined"|| $.trim(cust_code_name) === ""||typeof v_asset_location === "undefined"|| $.trim(v_location_id) == ""|| $.trim(v_asset_location_details) == "SELECT LOCATION"|| $.trim(v_cust_id) == ""|| $.trim(cust_code_view_name) == "SELECT CUSTOMER NAME"|| $.trim(v_asset_building_id) == ""|| $.trim(v_asset_building_details) == "SELECT BUILDING"|| $.trim(v_asset_category_id) == ""|| $.trim(v_asset_category_name) == "Select Category"|| $.trim(v_asset_type_id) == ""|| $.trim(v_asset_type_name) == "Select Type")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_add_assets.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/amc/amc_assets_controller.php",{action:'add_amc_assets',location_code:location_code,v_asset_building_id:v_asset_building_id,v_zone_or_floor_no:v_zone_or_floor_no,v_asset_roon_no:v_asset_roon_no,v_asset_specify_description:v_asset_specify_description,v_asset_ref_no:v_asset_ref_no,v_asset_category_id:v_asset_category_id,v_asset_category_name:v_asset_category_name,v_asset_type_id:v_asset_type_id,v_asset_type_name:v_asset_type_name,v_cust_id:v_cust_id,v_cust_code:cust_code_view,v_cust_name:cust_code_name,v_location_id:v_location_id,v_asset_location:v_asset_location,v_asset_building:v_asset_building_name,v_asset_building_code:v_asset_building_code,v_flat_area_code:v_flat_area_code,v_asset_serial_no:v_asset_serial_no,v_asset_brand:v_asset_brand,v_asset_capacity:v_asset_capacity,v_asset_cost:v_asset_cost,v_is_warentee:v_is_warentee,v_warentee_end_date:v_warentee_end_date,assets_attachment_file:assets_attachment_file,v_asset_description:v_asset_description}
                                            , function(result,status)
                                            {
                                               
                                                if(result!='')
                                                {
												    v_btn_add_assets.ladda( 'stop' );
											        swal("Success", "New Assets added successfully..", "success");
											        load_data_to_grid_customer__assets_details_list();
											         clear_text();
											
                                                }
                                                else
                                                {
                                                     v_btn_add_assets.ladda( 'stop' );
											        swal("Error", "New Assets added Failed..", "error");
											         //clear_text();
											
                                                }
                                                
                                                
                                    });
  
                                }
                        });//close of Assets add button
	var abc = 123;
	

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
    
    //load data to customer assets grid
       function load_data_to_grid_customer__assets_details_list()
           {
                     var i=1;
                    v_list_of_customer_assets_details_table.destroy();
                         
                     v_list_of_customer_assets_details_table = $('#list_of_customer_asset_details').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_assets_controller.php',
                                 'data': {
                                    action: 'list_amc_assets'
                                    
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
                                 { "data": "asset_id","visible":false},  
								 { "data": "asset_ref_no"},
								 { "data": "asset_ref_no",
								     render: function ( data, type, rows, meta ) {
								          var retun_qr_code = '<a href="../printpdf/qr_code/generate_asset_qr.php?asset_ref_no='+data+'&asset_id=' + rows['asset_id'] + '" target="_blank">';
                                            retun_qr_code += '<img src="../httpdocs/qr_lib/asset_qr/customer_asset/' + data + '.png" alt="QR Code Image"/>';
                                            retun_qr_code += '</a>';
                                            
                                            return retun_qr_code;
                                          
								     }
								     
								 },  
                                 { "data": "customer_name"},
                                 { "data": "asset_location"},
                                 { "data": "asset_building"},
								 { "data": "asset_category_name"},
                                 { "data": "asset_type_name"},
								 
                                 
                                 { "data": "asset_status",
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
                                    "data": "asset_id","width":"8%",
                                    render: function (data, type, rows, meta) {
                                        var dropdownOptions = {
                                            "CustomerAssetModify": "Edit",
                                            "CustomerAssetModify": "Active",
                                            "CustomerAssetModify": "Deactive"
                                        };
                                
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });
                                
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color: info;"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                       
                                        if(filteredOptions=="CustomerAssetModify")
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
                             ],
                             pageLength: 50,
            				 searching: true,
                             responsive: true,
                             
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
       //close of customer assets grid   

    //details control of customer assets starts
		
				$('#list_of_customer_asset_details tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_customer_assets_details_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_customer_assets_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
               function format_customer_assets_details(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            		
            				'<td ><div align="center">Zone/Floor No</div></td>'+
							'<td ><div align="center">Flat No/Area Code</div></td>'+
            				'<td ><div align="center">Room Number</div></td>'+
            				// '<td ><div align="center">Specify if any</div></td>'+
            				'<td ><div align="center">Asset Name</div></td>'+
            				'<td ><div align="center">Brand</div></td>'+
            				'<td ><div align="center">Model Number</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            				'<td><div align="center">'+d.zone_floor+'</div></td>'+
							'<td><div align="center">'+d.flat_area_code+'</div></td>'+
            				'<td><div align="center">'+d.room_no+' </div></td>'+
            				'<td><div align="center">'+d.asset_sp_des+' - '+d.customer_contact_person_no+' </div></td>'+
            				'<td><div align="center">'+d.asset_brand+'</div></td>'+
            				'<td><div align="center">'+d.asset_serial_no+'</div></td>'+
            				
            				
            			  '</tr>'+
						  
						  '<tr style="background: #989898;color:#ffffff;">'+
            		
            				
							'<td ><div align="center">Warrantee/Guarantee</div></td>'+
            				'<td ><div align="center">Capacity</div></td>'+
            				'<td ><div align="center">Cost</div></td>'+
            				'<td colspan="2"><div align="center">Asset Description </div></td>'+
            				'<td ><div align="center">Attachment</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
            			
							'<td><div align="center">'+d.warentee_end_date+'</div></td>'+
            				'<td><div align="center">'+d.asset_capacity+' </div></td>'+
            				'<td><div align="center">'+d.asset_cost+' </div></td>'+
            				'<td colspan="2"><div align="center">'+d.asset_description+'</div></td>'+
            				'<td><div align="center"><a href="../../httpdocs/images/amc_attachements/'+d.asset_attachment+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
            				
            				
            			  '</tr>'+
						  
            			'</table>' ;
                        			
		
		
	            }
		
		
		//details control of customer assets ends
    $('#list_of_customer_asset_details tbody').on('click', 'a', function(){
                        var $row = $(this).closest('tr');
                        var custmr_asset_data = v_list_of_customer_assets_details_table.row($row).data();
                        v_asset_id  = custmr_asset_data.asset_id;
						//console.log(v_customer_id);
                         v_asset_status  = custmr_asset_data.asset_status;
                         if($(this).attr("name")=='name_Edit')
                         {
                         
                            edit_customer_assets_details(custmr_asset_data.asset_id);
            			    $( '#btn_add_assets').hide();
                            $( '#btn_edit_assets').show();
                            $( '#btn_new_assets').show();
               
            			 }
            			 
            			  function edit_customer_assets_details(v_asset_id)
                            {
                                $("#btn_generate_barcode").hide();
                                $("#txt_assets_id").val(v_asset_id);
                                $("#txt_asset_id").val(custmr_asset_data.asset_type_id);   
								//console.log(v_asset_id);
								$("#select_customer_for_customer_location").val(custmr_asset_data.customer_id).trigger("change");
								$("#select_location_for_customer_location").val(custmr_asset_data.location_id).trigger("change");
								$("#select_building_for_location").val(custmr_asset_data.building_id).trigger("change");
								$("#txt_zone_or_floor_no").val(custmr_asset_data.zone_floor);
                                $("#txt_flat_area_no").val(custmr_asset_data.flat_area_code);
                                $("#txt_room_no").val(custmr_asset_data.room_no);
                                $("#txt_specify_if_any").val(custmr_asset_data.asset_sp_des);
								$("#select_category").val(custmr_asset_data.asset_category_id).trigger("change");
							//	$("#select_asset_type").val(custmr_asset_data.asset_type_id).trigger("change");
								 
								//console.log(custmr_asset_data.asset_type_id);
                                $("#txt_brand").val(custmr_asset_data.asset_brand);
								$("#txt_modal_no").val(custmr_asset_data.asset_serial_no);
								$("#txt_is_warrantee").val(custmr_asset_data.is_warentee).trigger("change");
								$("#warrantee_date").val(custmr_asset_data.warentee_end_date);
								$("#txt_capacity").val(custmr_asset_data.asset_capacity);
								$("#txt_cost").val(custmr_asset_data.asset_cost);
								$("#txt_des").val(custmr_asset_data.asset_description);
							
								// file attachment start
								
								$("#img_assets_preview").html("<img style='width:70px;height:50px;'src=../httpdocs/images/amc_attachements/"+$.trim(custmr_asset_data.asset_attachment)+">");
                                $('#assets_img_name').text(custmr_asset_data.asset_attachment);
										
								 //file attachment ends
								 
								$("#barcodeValue").val(custmr_asset_data.asset_ref_no);
								
                            }
                            
                        if($(this).attr("name")=='name_Active' || $(this).attr("name")=='name_Deactive')
                         {
                             var v_customer_assets_action=$(this).attr("name");
                             v_customer_assets_action = v_customer_assets_action.split("_");
                             $.post("../controller/amc/amc_assets_controller.php",{action:'change_customer_assets_status',v_assets_id:v_asset_id,v_asset_status:v_asset_status,v_customer_assets_action:v_customer_assets_action[1]}
                                , function(result,status)
                                {
                                   
                                   load_data_to_grid_customer__assets_details_list();
                                
                            });
                        }
                          
                        // if($(this).attr("name")=='asset_qr_code')
						// {
							
							// generateQRcode(v_text);
						// }
        });
		
		  // Edit customer assets details....
 
                v_btn_edit_assets.click(function(){
                    
                    v_btn_edit_assets.ladda( 'start' );
					var v_assets_id=$("#txt_assets_id").val();
					//console.log('updatebutton'+v_assets_id);
					var v_asset_ref_no=$("#barcodeValue").val();
					
					var v_customer_id=$("#select_customer_for_customer_location option:selected").val();
					var v_asset_customer_details=$("#select_customer_for_customer_location option:selected").text();
					var v_asset_customer_details=v_asset_customer_details.split("--");
					var v_asset_customer_code=v_asset_customer_details[0];
					var v_asset_customer_name=v_asset_customer_details[1];
					
					var v_location_id=$("#select_location_for_customer_location option:selected").val();
					var v_asset_location_details=$("#select_location_for_customer_location option:selected").text();
					var v_asset_location_details=v_asset_location_details.split("--");
					var v_asset_location_code=v_asset_location_details[0];
					var v_asset_location_name=v_asset_location_details[1];
					
					var v_asset_building_id=$("#select_building_for_location option:selected").val();
					var v_asset_building_details=$("#select_building_for_location option:selected").text();
					var v_asset_building_details=v_asset_building_details.split("--");
					var v_asset_building_code=v_asset_building_details[0];
					var v_asset_building_name=v_asset_building_details[1];
					
					var v_zone_or_floor_no=$("#txt_zone_or_floor_no").val();
					var v_flat_area_code=$("#txt_flat_area_no").val();
					var v_asset_roon_no=$("#txt_room_no").val();
					var v_asset_specify_description=$("#txt_specify_if_any").val();
					var v_asset_category_id=$("#select_category option:selected").val();
					var v_asset_category_name=$("#select_category option:selected").text();
					var v_asset_type_id=$("#select_asset_type option:selected").val();
					var v_asset_type_name=$("#select_asset_type option:selected").text();
					var v_asset_brand=$("#txt_brand").val();
					var v_asset_serial_no=$("#txt_modal_no").val();
					var v_is_warentee=$("#txt_is_warrantee option:selected").text();
					var v_warentee_end_date=$("#warrantee_date").val();
					var v_asset_capacity=$("#txt_capacity").val();
					var v_asset_cost=$("#txt_cost").val();
					var v_asset_description=$("#txt_des").val();
					var v_assets_attachment = $("#assets_attachment").val();
                    var v_assets_attachment_new = $("#assets_img_name").text();
                    var randomNum = Math.ceil(Math.random() * 999999); 

				
						if(v_assets_attachment=="" && v_assets_attachment_new!="")
                        {
                            v_assets_attachment=v_assets_attachment_new;
                           
                            
                        }
                        else if(v_assets_attachment=="")
                        {
                            v_assets_attachment="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#assets_attachment")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                             doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                            upload.doUpload("../httpdocs/user_upload/amc_attachements.php?random_no="+randomNum);
                            v_assets_attachment=randomNum+'_'+doc_file1;
                        }
		
                     if($.trim(v_asset_ref_no)===""|| $.trim(v_location_id) == ""|| $.trim(v_asset_location_details) == "SELECT LOCATION"|| $.trim(v_customer_id) == ""|| $.trim(v_asset_customer_details) == "SELECT CUSTOMER NAME"|| $.trim(v_asset_building_id) == ""|| $.trim(v_asset_building_details) == "SELECT BUILDING"|| $.trim(v_asset_category_id) == ""|| $.trim(v_asset_category_name) == "Select Category"|| $.trim(v_asset_type_id) == ""|| $.trim(v_asset_type_name) == "Select Type")
                    
                    {
                        swal("Success","Please provide all the details ....", "success");
                        v_btn_edit_assets.ladda( 'stop' );
                        return false;
                         
                    }
                   
                    else
                    {         
                         $.post("../controller/amc/amc_assets_controller.php",{action:'edit_amc_assets',v_assets_id:v_assets_id,v_asset_ref_no:v_asset_ref_no,v_asset_category_id:v_asset_category_id,v_asset_category_name:v_asset_category_name,v_asset_type_id:v_asset_type_id,v_asset_type_name:v_asset_type_name,v_cust_id:v_customer_id,v_cust_code:v_asset_customer_code,v_cust_name:v_asset_customer_name,v_location_id:v_location_id,v_asset_location_code:v_asset_location_code,v_asset_location:v_asset_location_name,v_asset_building_id:v_asset_building_id,v_asset_building_code:v_asset_building_code,v_asset_building:v_asset_building_name,v_zone_or_floor_no:v_zone_or_floor_no,v_flat_area_code:v_flat_area_code,v_asset_roon_no:v_asset_roon_no,v_asset_specify_description:v_asset_specify_description,v_asset_serial_no:v_asset_serial_no,v_asset_brand:v_asset_brand,v_asset_capacity:v_asset_capacity,v_asset_cost:v_asset_cost,v_is_warentee:v_is_warentee,v_warentee_end_date:v_warentee_end_date,assets_attachment_file:v_assets_attachment,v_asset_description:v_asset_description}
                                , function(result,status)
                                {
                                    //console.log(result);
                                    
                                result = $.trim(result);
                               
                               if(result!='')
									{
										v_btn_edit_assets.ladda( 'stop' );
										swal("Success", "Assets updated successfully..", "success");
										load_data_to_grid_customer__assets_details_list();
										 clear_text();
								
									}
									else
									{
										v_btn_edit_assets.ladda( 'stop' );
										swal("Error", "Assets updation Failed..", "error");
										clear_text();
										//$( '#btn_customer_add' ).show();
                                        //$( '#btn_customer_edit' ).hide();
                                        //$( '#btn_customer_new' ).hide();
								
									}
				  
					
                                 
                            
                        });
                        
                       
                        
                     }
                  
                }); 
				
				
				$('#btn_new_assets').click(function(){
                  
						  $( '#btn_add_assets' ).show();
						  $( '#btn_edit_assets' ).hide();
						  $( '#btn_new_assets' ).hide(); 
						  $("#btn_generate_barcode").show();
						  clear_text();
                 
              })
function clear_text()
                 {
                     location.reload();
                 
                   
                 }
      
                        //add location_modal
						$("#bootbox_location_btn").click(function(){
                          
                            $('#add_new_building_assets').modal('show');
                      });
					    //add building_modal
						$("#bootbox_building_btn").click(function(){
                          
                            $('#add_new_building_assets').modal('show');
                           
                      }); 
                      
        $(document.body).on('change','#select_category',function(){             
           
           asset_type_load();

        });
        function asset_type_load()
        {
             var v_asset_category_id=$("#select_category option:selected").val();
            var v_category_id=$("#txt_asset_id").val();
          
            	if(v_category_id!=''){
            $('#div_asset_type_select').load("amc/assets_type_combo.php?category_id="+v_asset_category_id, function() {
              $("#select_asset_type").val(v_category_id).trigger("change");
            });
            	}
            	else
            	{
            	    $('#div_asset_type_select').load("amc/assets_type_combo.php?category_id="+v_asset_category_id); 
            	}
            	   
        }
             //New Customer Creation      
        $('#error_email').hide();
         $('#btn_customer_edit').hide();
        $('#btn_customer_new').hide();            
        var v_btn_customer_add = $('#btn_customer_add').ladda();
                    
                $("#txt_customer_email_id").change(function(){
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
                                                   
                                                    clear_text_customer();
                                                   
                
                                                
                                                }
                                                else 
                                                {
                                                     v_btn_customer_add.ladda( 'stop' );
                                                     swal("Success", "New customer added successfully..", "success");
                                                      
                                                     
                                                     $.ajax({
                                		type: "POST",
                                		url: "../view/customer_location/customer_combo_customer_location.php",
                                		
                                		
                                		 }).done(function(data){
            
                                			$("#div_customer_details_asset").html(data);
            								$("#select_customer_for_customer_location").select2();
    							});
                                            
                                       clear_text_customer();  
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
     var v_btn_category_add = $('#btn_category_add').ladda();
      v_btn_category_add.click(function(){
                    
                    v_btn_category_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
                    var v_cat_name=$("#txt_cat_name").val();
					
                  
                    if($.trim(v_cat_name)=="")
                    
                    {
                        swal("Warning","Please provide category....", "warning");
                        v_btn_category_add.ladda( 'stop' );
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
                                    v_btn_category_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_category_add.ladda( 'stop' );
                                     swal("Success", "New category added successfully..", "success");
                                     $("#txt_cat_name").val('');
                                     $.ajax({
                                		type: "POST",
                                		url: "../view/amc/category_combo_div_load.php",
                                		
                                		
                                		 }).done(function(data){
            
                                			$("#div_category_select").html(data);
            								$("#select_category").select2();
    							});
                                     load_category_modal_options();
                                     
                                 }
                                 
                                  
                             
                         });
                         
                        
                         
                      }
                   
                 });

              function load_category_modal_options() {
                  $.post("../view/amc/category_combo_options.php", function(data) {
                      if ($.trim(data) != "") {
                          $("#select_category_modal").html(data);
                      }
                  });
              }
              $('#modal_asset_type_add').on('show.bs.modal', function() {
                  if ($("#select_category_modal option").length <= 1) {
                      load_category_modal_options();
                  }
              });

              var v_btn_asset_type_add = $('#btn_asset_type_add').ladda();
              v_btn_asset_type_add.click(function(){
                    
                    v_btn_asset_type_add.ladda( 'start' );
                    //var v_exp_id=$("#txt_exp_id").val();
					var v_category_id=$("#select_category_modal option:selected").val();
                    var v_category_name=$("#select_category_modal option:selected").text()
                    var v_asset_name=$("#txt_asset_name").val();
					
                  
                    if($.trim(v_asset_name)==""||v_category_id=="select" )
                    
                    {
                        swal("Warning","Please provide all field....", "warning");
                        v_btn_asset_type_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/asset_type/asset_type_controller.php",{action:'add_asset_type',v_category_id:v_category_id,v_category_name:v_category_name,v_asset_name:v_asset_name }
                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_asset_type_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_asset_type_add.ladda( 'stop' );
                                     swal("Success", "New asset type added successfully..", "success");
                                     
                                    $("#txt_asset_name").val('');
									$("#select_category_modal").val(null).trigger("change");
									asset_type_load();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
						
});