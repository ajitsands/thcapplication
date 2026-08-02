$(document).ready(function(){
    var v_amc_id,checked_val_edit,v_first_attachment_edit,v_second_attachment_edit,v_third_attachment_edit,result,v_third_attachment_edit,v_second_attachment_edit,v_first_attachment_edit,randomNum,attachments =[];
    var v_location_id=0,v_building_id=0,v_asset_type_id=0,v_category_id=0,v_cust_id,v_amc_ref_no,combo_on_change,start_date,start_dd,start_mm,start_yyyy,start_date_base_form,amc_start_date,amc_end_date;
    var v_amc_asset_schedule_list_table = $('#tbl_amc_asset_schedule_list').DataTable({});   
    var v_btn_amc_generate_schedule = $('#btn_generate_schedule').ladda();
   // load_data_to_grid_amc_list();
//load data to amc_list table
        $('#select_customer_for_amc').change(function (e) {
        
                var v_amc_cust_code = $('#select_customer_for_amc option:selected').text();
                v_amc_cust_code =v_amc_cust_code.split("-");
                v_amc_cust_code=v_amc_cust_code[0];
                
                
                         $.ajax({
                    		type: "POST",
                    		url: "amc_asset_schedule/amc_combo.php",
                    		data: { v_amc_cust_code : v_amc_cust_code } 
                    		 }).done(function(data){
                                //console.log(data);
                    			$("#div_amc_schedule_combo").html(data);
								$("#select_amc_for_schedule").select2();
							});
                
 									
        });
        
        $('#div_amc_schedule_combo').change(function (e) {
        
                v_cust_id = $('#select_customer_for_amc option:selected').val();
                v_amc_ref_no = $('#select_amc_for_schedule option:selected').text();
                v_amc_ref_no =v_amc_ref_no.split("-");
                v_amc_ref_no=v_amc_ref_no[1];
                
                $.post("../controller/amc_asset_schedule/amc_asset_schedule_controller.php",{action:'start_date_end_date_list',v_amc_ref_no:v_amc_ref_no}
                      , function(result,status)
                      {
                         var obj = jQuery.parseJSON(result); 
                        
                        $("#txt_amc_start_date").val(obj.data[0].amc_start_date);
                        $("#txt_amc_end_date").val(obj.data[0].amc_end_date);
                      });
                
                combo_on_change='amc';
               load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);
               
                         $.ajax({
                    		type: "POST",
                    		url: "amc_asset_schedule/location_schedule_combo.php",
                    		data: { v_cust_id : v_cust_id,
                    		        v_amc_ref_no : v_amc_ref_no,con:'amc_schedule_assets_nu'} 
                    		 }).done(function(data){
                                //console.log(data);
                    			$("#div_location_schedule_combo").html(data);
								$("#select_location_for_schedule").select2();
							});
							
							
						$.ajax({
                    		type: "POST",
                    		url: "amc_asset_schedule/building_schedule_combo.php",
                    		data: { v_cust_id : v_cust_id,
                    		        v_amc_ref_no : v_amc_ref_no,con:'amc_schedule_assets_nu'} 
                    		 }).done(function(data){
                                //console.log(data);
                    			$("#div_building_combo_for_schedule").html(data);
								$("#select_building_for_schedule").select2();
							});
							
							
						$.ajax({
                    		type: "POST",
                    		url: "amc_asset_schedule/asset_type_schedule_combo.php",
                    		data: { v_cust_id : v_cust_id,
                    		        v_amc_ref_no : v_amc_ref_no,con:'amc_schedule_assets_nu'} 
                    		 }).done(function(data){
                                //console.log(data);
                    			$("#div_assets_type_schedule_combo").html(data);
								$("#select_asset_type_for_schedule").select2();
							});
							
						$.ajax({
                    		type: "POST",
                    		url: "amc_asset_schedule/category_schedule_combo.php",
                    		data: { v_cust_id : v_cust_id,
                    		        v_amc_ref_no : v_amc_ref_no,con:'amc_schedule_assets_nu'} 
                    		 }).done(function(data){
                               // console.log(data);
                    			$("#div_category_schedule_combo").html(data);
								$("#select_category_for_schedule").select2();
							});
                
 									
        });
   
   
        $('#div_location_schedule_combo').change(function (e) {

                v_location_id = $('#select_location_for_schedule option:selected').val();
               combo_on_change='location';
               load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);
    
        });
        $('#div_building_combo_for_schedule').change(function (e) {

                v_building_id = $('#select_building_for_schedule option:selected').val();
               combo_on_change='building';
               load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);
    
        });
        $('#div_assets_type_schedule_combo').change(function (e) {

                v_asset_type_id = $('#select_asset_type_for_schedule option:selected').val();
               combo_on_change='asset_type';
               load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);
    
        });
        $('#div_category_schedule_combo').change(function (e) {

                v_category_id = $('#select_category_for_schedule option:selected').val();
               combo_on_change='category';
               load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);
    
        });
        
         $('#div_from_date').change(function (e) {
             
                 amc_start_date=$("#txt_amc_start_date").val();
                 var amc_start_date_converted=dateconvert($("#txt_amc_start_date").val());
                 amc_end_date= $("#txt_amc_end_date").val();
                 console.log(amc_start_date+':'+amc_end_date);
                
                start_date = dateconvert($("#txt_from_date").val());
                start_date_base_form =$("#txt_from_date").val();
                
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
                //console.log(dd+'-'+mm+'-'+yyyy);
                //console.log(start_date_base_form > today_date_base_form)
                if(start_date_base_form < today_date_base_form)
                {
                    
                     swal("Warning","Please select a date after today's date ....", "warning");
                      $('#txt_from_date').val("");
                       
                }
                
                if(start_date_base_form < amc_start_date)
                {
                    
                     swal("Warning","Please select a date after AMC start date "+amc_start_date_converted+" ....", "warning");
                      $('#txt_from_date').val("");
                       
                }
                
        });
        
        $('#div_to_date').change(function (e) {

             if(typeof start_date_base_form === 'undefined')
                {
                    
                     swal("Warning","Please select a start date ....", "warning");
                      $('#txt_to_date').val("");
                       
                }
                var end_date_base_form=$("#txt_to_date").val();
               var amc_end_date_converted=dateconvert($("#txt_amc_end_date").val());
                 //console.log(end_date_base_form +':'+start_date_base_form);
                if(end_date_base_form < start_date_base_form)
                {
                    
                     swal("Warning","Please select a date after start date ....", "warning");
                      $('#txt_to_date').val("");
                       
                }
                
                if(amc_end_date < end_date_base_form)
                {
                    
                     swal("Warning","Please select a date before AMC end date "+amc_end_date_converted+" ....", "warning");
                      $('#txt_to_date').val("");
                       
                }
                 var end_date =dateconvert($("#txt_to_date").val());
               
        });
        
        $("#schedule_search").click(function () {  
            
            
            var v_cust_id = $('#select_customer_for_amc option:selected').val();
            var v_amc_ref_no = $('#select_amc_for_schedule option:selected').text();
             v_amc_ref_no =v_amc_ref_no.split("-");
                v_amc_ref_no=v_amc_ref_no[1];
            v_location_id = $('#select_location_for_schedule option:selected').val();
            v_building_id = $('#select_building_for_schedule option:selected').val();
            v_asset_type_id = $('#select_asset_type_for_schedule option:selected').val();
            v_category_id = $('#select_category_for_schedule option:selected').val();
            var combo_on_change='btn_search';
                
            load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change);    
        });

                 function load_data_to_grid_amc_list(v_cust_id,v_amc_ref_no,v_location_id,v_building_id,v_asset_type_id,v_category_id,combo_on_change)
                 {
                     
                    v_amc_asset_schedule_list_table.destroy();
                         
                     v_amc_asset_schedule_list_table = $('#tbl_amc_asset_schedule_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_asset_schedule/amc_asset_schedule_controller.php',
                                 'data': {
                                    action: 'amc_asset_schedule_list_view',
                                    v_customer_id:v_cust_id,
                                    v_amc_ref_no:v_amc_ref_no,
                                    v_location_id:v_location_id,
                                    v_building_id:v_building_id,
                                    v_asset_type_id:v_asset_type_id,
                                    v_category_id:v_category_id,
                                    combo_on_change:combo_on_change
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
            				"autoWidth": true,
            				
            			
                            "columns": [
                               
                                 { "data": null},
                                 { "data": "asset_id","visible":false },
                                 { "data": "asset_ref_no"},
                                 { "data": "asset_brand"},
                                 { "data": "asset_capacity"},
                                 { "data": "asset_cost"},
                                 { "data": "asset_attachment"},
                                 { "data": "asset_description"}
                                
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7] }, 
            					
            				],
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              drawCallback: function (settings) {
                               
                            },
                            //Start Grouping
                              "order": [
                                  [4, 'asc']
                                ],
                               
                            
                     });  
                
                 }
                 
                 
                 
            $('#tbl_amc_asset_schedule_list tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
        
                }
                else {
                     $(this).addClass('selected');
                    
                    var $row = $(this).closest('tr');
                    var ids = v_amc_asset_schedule_list_table.row($row).data();
                   
                }
            } );
                 
            $("#btn_generate_schedule").click(function () {  
            
                v_btn_amc_generate_schedule.ladda( 'start' );
                    var v_cust_id = $('#select_customer_for_amc option:selected').val();
                    var v_cust_details = $('#select_customer_for_amc option:selected').text();
                    v_cust_details =v_cust_details.split("-");
                        v_cust_code=v_cust_details[0];
                        v_cust_name=v_cust_details[1];
                    var v_amc_ref_details = $('#select_amc_for_schedule option:selected').text();
                    v_amc_ref_details =v_amc_ref_details.split("-");
                        v_amc_ref_no=v_amc_ref_details[1];
                        v_amc_ref_id=v_amc_ref_details[0];
                    
                    var frequency_array=$("#select_visit_frequency").val();
                    var start_date = dateconvert($("#txt_from_date").val());
                    var end_date =dateconvert($("#txt_to_date").val());
                    var schedule_time = $("#time").val();
                   
                    var asset_table_selected_count = v_amc_asset_schedule_list_table.rows('.selected').data().length;
        		
        		    var assetTableSelectedValues = $.map(v_amc_asset_schedule_list_table.rows('.selected').data(), function (item) {
            			return item;
            		}); 
            		
            		
            		if((typeof start_date === 'undefined')||(typeof end_date === 'undefined')||(frequency_array == "")||(schedule_time == ""))
            		{
            		     swal("Warning","Please fill all the fields ....", "warning");
            		     v_btn_amc_generate_schedule.ladda( 'stop' );
                        return false;
                       
                    }
                    else
                    {
            		var SQLString =[];
            		
            		
	
	   //             	$.ajax({
    //                 		type: "POST",
    //                 		url: "../view/amc_asset_schedule/amc_generate_dates.php",
    //                 		data: { action: 'schedule_visits',
    //                 		        amc_id:v_amc_ref_id,
    //                                 amc_ref_no:v_amc_ref_no,
    //                                 v_cust_id:v_cust_id,
    //                                 v_cust_code:v_cust_code,
    //                                 v_cust_name:v_cust_name,
    //                                 //asset_id:assetTableSelectedValues[firstcounter].asset_id,
    //                                 //asset_code:assetTableSelectedValues[firstcounter].asset_ref_no,
    //                                 frequency_array:frequency_array,
    //                                 start_date:start_date,
    //                                 end_date:end_date,
    //                                 schedule_time:schedule_time} 
    //                 		 }).done(function(data){
    //                             console.log(data);
    //                 		//v_btn_amc_generate_schedule.ladda( 'stop' );
				// 			});
	
            		for(firstcounter=0;firstcounter<=asset_table_selected_count-1;firstcounter++)
            		{
    //         		SQLString = SQLString +'("'+v_amc_ref_no+'","'+v_amc_ref_id+'","'+v_cust_id+'","'+v_cust_code+'","'+v_cust_name+'","'+frequency_array+'","'+start_date+'","'+end_date+'","'+schedule_time+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_id+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_type_id+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_type_name+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_category_id+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_category_name+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_ref_no+'","'+
				// 	assetTableSelectedValues[firstcounter].location_id+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_location+'","'+
				// 	assetTableSelectedValues[firstcounter].building_id+'","'+
				// 	assetTableSelectedValues[firstcounter].asset_building+'"),'; 
            		
            		SQLString[firstcounter] = ''+
					assetTableSelectedValues[firstcounter].asset_id+','+
					assetTableSelectedValues[firstcounter].asset_type_id+','+
					assetTableSelectedValues[firstcounter].asset_type_name+','+
					assetTableSelectedValues[firstcounter].asset_category_id+','+
					assetTableSelectedValues[firstcounter].asset_category_name+','+
					assetTableSelectedValues[firstcounter].asset_ref_no+','+
					assetTableSelectedValues[firstcounter].location_id+','+
					assetTableSelectedValues[firstcounter].asset_location+','+
					assetTableSelectedValues[firstcounter].building_id+','+
					assetTableSelectedValues[firstcounter].asset_building+''; 		
            				 	 
   
            				
            				
            		}
            	 //	SQLString =  SQLString.replace(/,\s*$/, "");
            		console.log(SQLString); 
            		        $.ajax({
                    		type: "POST",
                    		url: "../view/amc_asset_schedule/amc_generate_dates.php",
                    		data: { action: 'schedule_visits',
                    		       SQLString:SQLString,
                    		       start_date:start_date,
                    		       end_date:end_date,
                    		       frequency_array:frequency_array,
                    		       schedule_time:schedule_time,
                    		       v_amc_ref_no:v_amc_ref_no,
                    		       v_amc_ref_id:v_amc_ref_id,
                    		       v_cust_id:v_cust_id,
                    		       v_cust_code:v_cust_code,
                    		       v_cust_name:v_cust_name,
                    		       asset_table_selected_count:asset_table_selected_count
                    		} 
                    		 }).done(function(data){
                                console.log(data);
                    		v_btn_amc_generate_schedule.ladda( 'stop' );
                    		clear_text();
            
							});
		
                   
                   if($.trim(v_amc_ref_id)==""||$.trim(v_amc_ref_no)=="")
                   {
                       swal("Warning","Please select the AMC details ....", "warning");
                       v_btn_amc_generate_schedule.ladda( 'stop' );
                       return false;
                   }
                   if(frequency_array=="")
                   {
                       swal("Warning","Please select Frequency of Visits ....", "warning");
                       v_btn_amc_generate_schedule.ladda( 'stop' );
                       return false;
                   }
                   else
                   {         
                   var schedule_time = $("#time").val();
                   
                   	
                   
                   
                //   $.post("../view/amc_asset_schedule/amc_generate_dates.php",{action:'schedule_visits',amc_id:v_amc_ref_id,amc_ref_no:amc_ref_no,frequency_array:frequency_array,start_date:start_date,end_date:end_date,schedule_time:schedule_time}
                //               , function(result,status)
                //               {
                                  
                //                   result = $.trim(result);
                //                   if(result.charAt(0)=='S')
                //                       {
                //                           v_btn_amc_generate_schedule.ladda( 'stop' );
                //                           swal("Success", "Visits scheduled successfully..", "success");
                                        
                //                           $('#select_visit_frequency').val(null).trigger('change');
                //                           load_data_to_grid_amc_schedules_list(amc_id);
                //                       }
                //                   else 
                //                       {
                //                           v_btn_amc_generate_schedule.ladda( 'stop' );
                //                             swal("Error", "Sorry! Could not schedule the visits..", "error");
                //                             return false;
                                            
                //                       }
                //       });
               
                   }
                        
            }
        });  
        
        
         function dateconvert(dates)
            {
               
               return dates.split("-").reverse().join("-");
            }
    
    
        function clear_text()
        {
            $('#txt_from_date').val("");
            $('#txt_to_date').val("");
            $('#select_visit_frequency').val(null).trigger('change');
            $("#txt_from_date").val("");
            $("#txt_to_date").val("");
            $("#time").val("");
        }
                 
});