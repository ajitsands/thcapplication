$(document).ready(function(){
    var v_assets_attachment,attachments =[];

  
    
  $("#div_category_select_add_assets").on('change','#select_category',function(){ 
   
          load_asset_type();	   

        });
	
  
     $('#assets_attachment').change(function (e) {
					    asset_attachment_upload('#assets_attachment',v_assets_attachment);
                    });
                     function asset_attachment_upload(txt_param,v_attachment)
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

                                var doc_file1 = doc_file_obj.name;
                            
                                // Remove spaces and special characters from filename
                                doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                            
                                // Final filename (same as DB value)
                                v_attachment = randomNum + "_" + doc_file1;
                            
                                attachments.push(v_attachment);
                            
                                upload.doUpload(
                                    "../httpdocs/user_upload/amc_attachements.php?random_no=" + randomNum
                                );
            				} 
            		 }
    
          function load_location()
          {
              var v_cust_id=$("#txt_customer_ids_add_assets").val();
   
                        $.ajax({
                        		type: "POST",
                        		url: "../view/amc/location_combo_customer_location.php",
                        			data: {v_cust_id:v_cust_id } 
                        		 }).done(function(data){
    
                        			$("#div_cust_location_assign_add_assets").html(data);
    								$("#select_location_for_customer_location_assets").select2();
							});
    						
          }
          
          function load_building()
          {
              var v_cust_id=$("#txt_customer_ids_add_assets").val();
   
                      
    						//fill combo_building  Building				
    						 $.ajax({
                            		type: "POST",
                            		url: "../view/amc/building_combo_customer_location.php",
                            		data: {v_cust_id:v_cust_id } 
                            		 }).done(function(data){
                            		     
                            			
                            			$("#div_cust_building_assign_add_assets").html(data);
        								$("#select_building_for_customer_location").select2();
    							});
    										
							
          }
    
   function load_category()
    {
         $.ajax({
                        		type: "POST",
                        		url: "../view/amc/category_combo.php",
                        		 }).done(function(data){
    
                        			$("#div_category_select_add_assets").html(data);
    								$("#select_category").select2();
							});
    }
    
    function load_asset_type()
    {
        var v_asset_category_id=$("#select_category option:selected").val();
      
           
             $('#div_asset_type_select').load("amc/assets_type_combo.php?category_id="+v_asset_category_id);
            	   
    }
    $("#btn_add_new_asset_assign_assets").click(function(){
         
        load_location();			
		load_building();
		load_category(); 
		$('#div_asset_type_select').load("amc/assets_type_combo.php?category_id=0");
    });
             //for barcode generation
                var location_code_view,building_code_view,cust_location_building,cust_code_view,cust_code_name;
                  $('#div_cust_location_assign_add_assets').change(function (e) {
        			        location_code_view=$("#select_location_for_customer_location_assets option:selected").text();
        			        cust_code_view=$("#txt_customer_code_add_assets").val();
        			        location_code_view=location_code_view.split('--');
        			        location_code_view=location_code_view[0];
        			        cust_location_building='THC'+'-'+cust_code_view+'-'+location_code_view+'-'+building_code_view;
        			        
        			         $('#txt_barcode_generate_values').val(cust_location_building);
        		            });
	             $('#div_cust_building_assign_add_assets').change(function (e) {
		        building_code_view=$("#select_building_for_customer_location option:selected").text();
		        
		        building_code_view=building_code_view.split('--');
		        building_code_view=building_code_view[0];
		        cust_location_building='THC'+'-'+cust_code_view+'-'+location_code_view+'-'+building_code_view;
		        $('#txt_barcode_generate_values').val(cust_location_building);
	            });
	            
           
               //Assets  insert details
                    $('#btn_add_assets').click(function(){
                        
                               var v_cust_id=$("#txt_customer_ids_add_assets").val();
                               var cust_code_name=$("#txt_customer_name_add_assets").val();
                               var cust_code_view=$("#txt_customer_code_add_assets").val();
								var assets_attachment_file=attachments[0];
								var v_asset_ref_no=$("#barcodeValue").val();
								var v_asset_category_id=$("#select_category option:selected").val();
							    var v_asset_category_name=$("#select_category option:selected").text();
								var v_asset_type_id=$("#select_asset_type option:selected").val();
								var v_asset_type_name=$("#select_asset_type option:selected").text();
								
								var v_location_id=$("#select_location_for_customer_location_assets option:selected").val();
								var v_asset_location_details=$("#select_location_for_customer_location_assets option:selected").text();
								v_asset_location_details=v_asset_location_details.split("--");
								var v_asset_location=v_asset_location_details[1];
								var location_code=v_asset_location_details[0];
								var v_asset_building_id=$("#select_building_for_customer_location option:selected").val();
								var v_asset_building_details=$("#select_building_for_customer_location option:selected").text();
								//alert(v_asset_building);
								v_asset_building_details=v_asset_building_details.split("--");
								v_asset_building_code=v_asset_building_details[0];
								v_asset_building_name=v_asset_building_details[1];
								
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
									
										return false;
                                    }
								 if($.trim(v_asset_ref_no)==="")
								 {
								     //console.log(result);
									 swal("Warning","Please generate asset code", "warning");
																		
																		return false;
								 }

                                if($.trim(v_asset_ref_no)===""||typeof v_asset_category_name === "undefined"||typeof v_asset_type_name === "undefined"||typeof cust_code_view === "undefined"|| $.trim(cust_code_name) === ""||typeof v_asset_location === "undefined"|| $.trim(v_location_id) == ""|| $.trim(v_asset_location_details) == "SELECT LOCATION"|| $.trim(v_cust_id) == ""||$.trim(v_asset_building_id) == ""|| $.trim(v_asset_building_details) == "SELECT BUILDING"|| $.trim(v_asset_category_id) == ""|| $.trim(v_asset_category_name) == "Select Category"|| $.trim(v_asset_type_id) == ""|| $.trim(v_asset_type_name) == "Select Type")
                                
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
                                                console.log(result);
                                                //alert(result);
                                                if(result!='')
                                                {
												   
											        swal("Success", "New Assets added successfully..", "success");
											         clear_text_assets();
											
                                                }
                                                else
                                                {
                                                     
											        swal("Error", "New Assets added Failed..", "error");
											         //clear_text();
											
                                                }
                                                
                                                
                                    });
  
                                }
                        });//close of Assets add button

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
    
   
function clear_text_assets()
                 {
                    $("#select_customer_for_customer_location").val(null).trigger("change");
					$("#select_category").val(null).trigger("change");
                    $("#select_asset_type").val(null).trigger("change");
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
                     $("#txt_is_warrantee").val(null).trigger("change");
                    $("#select_location_for_customer_location_assets").val(null).trigger("change");
                    $("#select_building_for_customer_location").val(null).trigger("change");
                    $("#txt_type_des").val('');
                    
                    $("#txt_zone_or_floor_no").val('');
					$("#txt_room_no").val('');
					$("#txt_specify_if_any").val('');
					$("#assets_attachment").val('');
					$("#assets_img_name").text('');
				
						$( "#img_assets_preview" ).empty();
						$("input[name=file]").val('');
					
                   
                 }
      
                       
            $("#btn_x_add_assets").click(function(){
                $('#modal_add_assets_assign_assets_to_amc').hide();
            });
             $("#btn_close_add_assets_modal").click(function(){
                $('#modal_add_assets_assign_assets_to_amc').hide();
            });       
         
        
         //add location_modal
	    $("#bootbox_location_btn").click(function(){
          
            $('#modal_location').modal('show');
      });
	    //add building_modal
		$("#bootbox_building_btn").click(function(){
          
            $('#modal_building').modal('show');
           
      }); 
      $("#bootbox_asset_category_btn").click(function(){
          
            $('#modal_asset_category').modal('show');
           
      }); 
       $("#bootbox_asset_type_btn").click(function(){
          
            $('#modal_asset_type').modal('show');
             $.ajax({
                        		type: "POST",
                        		url: "../view/amc/category_combo1.php",
                        		 }).done(function(data){
    
                        			$("#div_category_combo1").html(data);
    								$("#select_category1").select2();
							});
           
      });
      $("#btn_close_new_bldg").click(function(){
                $('#modal_building').hide();
      });
     $("#btn_close_new_loc").click(function(){
                $('#modal_location').hide();
      });
      $("#btn_close_new_category").click(function(){
                $('#modal_asset_category').hide();
      });
      $("#btn_close_new_asset_type").click(function(){
                $('#modal_asset_type').hide();
      });
      $("#btn_x_new_bldg").click(function(){
                $('#modal_building').hide();
      });
     $("#btn_x_new_loc").click(function(){
                $('#modal_location').hide();
      });
      $("#btn_x_new_category").click(function(){
                $('#modal_asset_category').hide();
      });
      $("#btn_x_new_asset_type").click(function(){
                $('#modal_asset_type').hide();
      });
         $('#txt_location_code').keydown(function (e) {
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
                    
         $('#txt_location_code').change(function (e) {
            var v_location_code_test=$("#txt_location_code").val();
             $.post("../controller/location/location_controller.php",{action:'check_location_code',v_location_code:v_location_code_test }
                    , function(result,status)
                    {
                       
                  
                   
                    if(result==1)
                    {
                       
                         swal("Warning", "Location code already exists..", "warning");
                       $("#txt_location_code").val('');
                    }
                    else 
                    {
                        return true;
                    }
                    
                     
                
            });
            
        });
                    
                    
            
 
     $("#btn_location_add").click(function(){
                    
        
        var v_location_name=$("#txt_location_name").val();
         var v_location_code=$("#txt_location_code").val();
            
            if($.trim(v_location_name)===""||$.trim(v_location_code)==="")
            
            {
                swal("Warning","Please provide location details ....", "warning");
               
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
                                   
                                    swal("Error", result, "error");
                                   
                                }
                                else 
                                {
                                   
                                     swal("Success", "New location added successfully..", "success");
                                     
                                   $('#modal_location').hide();
                                    $("#txt_location_name").val('');
                                     $("#txt_location_code").val('');
                                     	load_location();
                                }
                      
                        
                         
                    
                });
                
               
                
             }
                  
    });
            
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
					
                    $('#btn_building_add').click(function(){
                                
								v_building_name=$("#txt_building_name").val();
								v_building_code=$("#txt_building_code").val();
								v_building_address=$("#txt_building_address").val();
                                 v_building_address='NA';
                                if($.trim(v_building_name)==""||$.trim(v_building_code)==""||$.trim(v_building_address)=="")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/building/building_controller.php",{action:'add_building',v_building_name:v_building_name,v_building_code:v_building_code,v_building_address:v_building_address}
                                            , function(result,status)
                                            {
                                            result = $.trim(result);
                               
                                            if(result.charAt(0)=='B')
                                            {
                                                
                                                swal("Error", result, "error");
                                               
                                            }
                                            else 
                                            {
                                               
                                                 swal("Success", "New building added successfully..", "success");
                                                
                        						$("#txt_building_name").val("");
                        						$("#txt_building_code").val("");
                        						$("#txt_building_address").val("");
                        								$('#modal_building').hide();
		                                        load_building();
                                            }
                                            
                                        
                                    });
                                    
                                   
                                    
                                 }
                  
                });
                
                
       $('#btn_category_add').click(function(){
                    
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
                             
                            $("#txt_cat_name").val('');
                            $('#modal_asset_category').modal('hide');
                            load_category();
                        }
                        
                         
                    
                });
                
               
                
             }
          
        });
        
         $('#btn_asset_type_add').click(function(){
                    
                    var v_category_id=$("#select_category1 option:selected").val();
                    var v_category_name=$("#select_category1 option:selected").text()
                    var v_asset_name=$("#txt_asset_name").val();
					
                  
                    if($.trim(v_asset_name)==""||v_category_name=="" )
                    
                    {
                        swal("Warning","Please provide all field....", "warning");
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
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     swal("Success", "New asset type added successfully..", "success");
                                     
                                    $("#txt_asset_name").val('');
                                     $('#modal_asset_type').hide();
                                   $('#div_asset_type_select').load("amc/assets_type_combo.php?category_id=0"); 
									$("#select_category1").val(null).trigger("change");
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
                  
                });
						
});