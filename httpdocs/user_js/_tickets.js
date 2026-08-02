$(document).ready(function() {
    console.log('Loaded..!');
    var list_of_customer = $('#list_of_customer').DataTable();
    var list_of_customer_location = $('#list_of_customer_location_building').DataTable();
    clear_hidden_values();
    var ticket_caption="";
    function clear_hidden_values()
    {
        $('#txt_customer_id').val('');
        $('#txt_hidden_ticket_customer_id').val('');
        $('#txt_hidden_ticket_customer_code').val('');
        $('#txt_hidden_ticket_customer_name').val('');
        $('#txt_hidden_ticket_customer_location_id').val('');
        $('#txt_hidden_ticket_customer_location_code').val('');
        $('#txt_hidden_ticket_customer_location_name').val('');
        $('#txt_hidden_ticket_customer_building_id').val('');
        $('#txt_hidden_ticket_customer_building_code').val('');
        $('#txt_hidden_ticket_customer_building_name').val('');
        $('#txt_hidden_ticket_customer_asset_id').val('');
        $('#txt_hidden_ticket_customer_asset_name').val('');
         $('#span_ticket_details').html('');
        ticket_caption=="";
    }
    
    function clear_location_building_hidden_values()
    {
        $('#txt_hidden_ticket_customer_location_id').val('');
        $('#txt_hidden_ticket_customer_location_code').val('');
        $('#txt_hidden_ticket_customer_location_name').val('');
        $('#txt_hidden_ticket_customer_building_id').val('');
        $('#txt_hidden_ticket_customer_building_code').val('');
        $('#txt_hidden_ticket_customer_building_name').val('');
        ticket_caption="Customer : "+ids.customer_code+" "+ids.customer_name;
        $('#span_ticket_details').html(ticket_caption);
    }
    
    $('#list_of_customer tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_hidden_values();
        }
        else {
            list_of_customer.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = list_of_customer.row($row).data();
            $('#txt_customer_id').val(ids.customer_id);
            $('#txt_hidden_ticket_customer_id').val(ids.customer_id);
            $('#txt_hidden_ticket_customer_code').val(ids.customer_code);
            $('#txt_hidden_ticket_customer_name').val(ids.customer_name);
            ticket_caption="Customer : "+ids.customer_code+" "+ids.customer_name;
            $('#span_ticket_details').html(ticket_caption);
        }
    } );
    
    
     $('#tab_location').click(function(){
       if($.trim($('#txt_hidden_ticket_customer_id').val())=="") 
       {
           swal("Warning","Please select a customer ....", "warning");
            return false;
       }
       else
       {
           load_data_to_grid_customer_building_list($.trim($('#txt_hidden_ticket_customer_id').val()))
       }
     });
    
    
    
       function load_data_to_grid_customer_building_list(customer_ids)
                 {
                     
                    list_of_customer_location.destroy();
                         
                     list_of_customer_location = $('#list_of_customer_location_building').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_controller.php',
                                 'data': {
                                    action: 'customer_location_list_view',customer_id:customer_ids
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            //"order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                
                                 { "data": null},
                                 { "data": "location_name" },
								 { "data": "building_name"},
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
                                 }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,4,5,6] }, 
            					
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
    
    
    
    
                     $('#div_building_code').hide();
                     $('#div_building_name').hide();
                     $('#div_select_building').hide();    
                    
                     $('#sel_new_existing').change(function (e) {
                        var v_new_exist=$("#sel_new_existing option:selected").text();
                           
                            if(v_new_exist=='New')
                            {
                                    $('#div_building_code').show();
                                    $('#div_building_name').show();
                                    $('#div_select_building').hide();
                            }
                            else
                            {
                                    $('#div_building_code').hide();
                                    $('#div_building_name').hide();
                                    $('#div_select_building').show();
                            }
                     });
                    $('#select_building_for_location').change(function (e) {
                         
                            var v_building_name_code=$("#select_building_for_location option:selected").text();
                            
                            v_building_name_code = v_building_name_code.split("--");
                            
                            $('#txt_building_code').val(v_building_name_code[0]);
                            $('#txt_building_name').val(v_building_name_code[1]);
                     });
                    
    
    
                     $('#txt_building_code').keydown(function (e) {
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
                    
                    
                      $('#txt_building_code').change(function (e) {
                          
                       var v_building_code_test=$("#txt_building_code").val();
                          $.post("../controller/ticket/ticket_controller.php",{action:'check_building_code',building_code:v_building_code_test}
                                            , function(result,status)
                                            {
                                                
                                          
                                            if(result==1)
                                            {
                                                v_btn_customer_location_add.ladda( 'stop' );
                                                swal("Warning", "Building code already exists...", "warning");
                                                $("#txt_building_code").val('');
                                            }
                                            else 
                                            {
                                                return true;
                                            }
                                            
                                             
                                        
                                    });
                    });
                    
                    
                         var v_btn_customer_location_add = $('#btn_customer_location_add').ladda(); 
                     
                        v_btn_customer_location_add.click(function(){
                            
                                v_btn_customer_location_add.ladda( 'start' );
                                var customer_id=$("#txt_hidden_ticket_customer_id").val();
                                var customer_name=$("#txt_hidden_ticket_customer_name").val();
                                var customer_code=$("#txt_hidden_ticket_customer_code").val();
                               
                                var location_id=$("#select_location_for_customer_location option:selected").val();
                                var location_name_val=$("#select_location_for_customer_location option:selected").text();
                                var location_split_val=location_name_val.split("--");
                                var location_code=location_split_val[0];
                                var location_name=location_split_val[1];
                                var building_code="";
                                var building_name="";
                                switch($("#sel_new_existing option:selected").text())
                                {
                                   case 'New':
                                       building_name=$.trim($("#txt_building_name").val());
                                       building_code=$.trim($("#txt_building_code").val());
                                   break;
                                   case 'Existing':
                                        var building_details=$("#select_building_for_location option:selected").text();
                                        var building_split_val=building_details.split("--");
                                        building_code=location_split_val[0];
                                        building_name=location_split_val[1];
                                        if($("#select_building_for_location option:selected").val()=='select')
                                        {
                                             swal("Warning","Please select building ....", "warning");
                                            v_btn_customer_location_add.ladda( 'stop' );
                                            return false;
                                        }
                                   break;
                                   case 'select':
                                       swal("Warning","Please providing building details ....", "warning");
                                        v_btn_customer_location_add.ladda( 'stop' );
                                        return false;
                                   break;
                                }
                              
                                var building_address=$("#txt_building_address").val();
                                var conact_person_name=$("#txt_contact_person_name").val();
                                var contact_person_no=$("#txt_contact_person_number_build").val();
                               
                                if($.trim(customer_id)==""||$.trim(customer_name)==""||$.trim(customer_code)==""||$.trim(building_code)==""||$.trim(building_name)==""|| $.trim(building_address)=="" || $.trim(building_code)=="" || $.trim(location_id)=="select")
                                
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_customer_location_add.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                {         
                                     $.post("../controller/ticket/ticket_controller.php",{action:'add_customer_location',customer_id:customer_id,customer_name:customer_name,customer_code:customer_code,location_id:location_id,location_code:location_code,location_name:location_name,building_code:building_code,building_name:building_name,building_address:building_address,conact_person_name:conact_person_name,contact_person_no:contact_person_no}
                                            , function(result,status)
                                            {
                                              
                                            result = $.trim(result);
                                          
                                            if(status=='success')
                                            {
                                               
                                                 v_btn_customer_location_add.ladda( 'stop' );
                                                 swal("Success", "Customer building details added successfully..", "success");
                                                 load_data_to_grid_customer_building_list($.trim($('#txt_hidden_ticket_customer_id').val()));
                                                  clear_location_text();
                                                 
                                                
                                            }
                                            else 
                                            {
                                                v_btn_customer_location_add.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_location_text();
                                            }
                                   
                                            });
                                 }
                  
                });
   
    
                 function clear_location_text()
                 {
                   
                   
                    $("#select_location_for_customer_location").val(null).trigger("change");
                     $("#select_building_for_location").val(null).trigger("change");
                    $("#sel_new_existing").val(null).trigger("change");
                     $("#txt_building_code").val('');
					 $("#txt_building_name").val('');
					 $("#txt_building_address").val('');
					 $("#txt_contact_person_name").val('')
                     $("#txt_contact_person_number_build").val('');
                     $('#div_building_code').hide();
                     $('#div_building_name').hide();
                     $('#div_select_building').hide();   
                 }
                 
                 
                 
    $('#list_of_customer_location_building tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            clear_location_building_hidden_values();
        }
        else {
            list_of_customer_location.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var customer_loc_buildings = list_of_customer_location.row($row).data();
           
            $('#txt_hidden_ticket_customer_id').val(customer_loc_buildings.customer_id);
            $('#txt_hidden_ticket_customer_code').val(customer_loc_buildings.customer_code);
            $('#txt_hidden_ticket_customer_name').val(customer_loc_buildings.customer_name);
            ticket_caption=ticket_caption+" Location : "+customer_loc_buildings.location_name+" Building : "+customer_loc_buildings.building_name;
            $('#span_ticket_details').html(ticket_caption);
        }
    } );        
                 
    //tab location click
  $('#tab_location1').click(function(){
        console.log($('#txt_customer_id').val()+' Text Value');
        
 //load customer details
		 $.ajax({
		type: "POST",
		url: "../view/customer_location/customer_combo_customer_location.php",
		data: { v_cust_id : $('#txt_customer_id').val() } 
		 }).done(function(data){

			$("#div_customer_details").html(data);
			$("#select_customer_for_customer_location").select2();
		});
		
		//load location
		 $.ajax({
                		type: "POST",
                		url: "../view/customer_location/location_combo_customer_location.php",
                		data: { v_cust_id : $('#txt_customer_id').val() } 
                		
                		 }).done(function(data){
                
                			$("#div_customer_location_details").html(data);
                			$("#select_location_for_customer_location").select2();
        		});
		
  });
  //end of tab location click
  
    $('#tab_asset').click(function(){
        console.log($('#txt_customer_id').val()+' Text Value');
        
	    //fill combo_customer combo
        $.ajax({
		type: "POST",
		url: "../view/amc/location_combo_customer_location.php",
		data: { v_cust_id : $('#txt_customer_id').val() } 
		 }).done(function(data){

			$("#div_cust_location").html(data);
			$("#select_location_for_customer_location_assets").select2();
		});
		
		$.ajax({
		type: "POST",
		url: "../view/amc/building_combo_customer_location.php",
		data: { v_cust_id : $('#txt_customer_id').val() } 
		 }).done(function(data){

			$("#div_cust_building").html(data);
			$("#select_building_for_customer_location").select2();
		});
        
        //fill combo_customer combo
                             $.ajax({
                    		type: "POST",
                    		url: "../view/amc/customer_combo_customer_location_modal.php",
                    		data: { v_cust_id : $('#txt_customer_id').val() } 
                    		 }).done(function(data){

                    			$("#div_cust_load_modal").html(data);
								    $("#select_customer_for_customer_location").select2();
								});
		$('#bootbox_location_btn').hide();
		$('#bootbox_building_btn').hide();
		
		
		
    });
    

    
    
    
} );