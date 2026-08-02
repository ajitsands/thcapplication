$(document).ready(function(){
    
  //  $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
  var v_customer_id,v_customer_name,v_po_box,v_address,v_contact_no,v_attension,v_date,v_subject,v_description,v_quantity,v_unit,v_rate,v_discount,v_tax,v_reference_number,v_terms_and_condition,v_quotation_number,v_reference_number,v_terms_and_condition,v_list_of_quotation_table,v_quotation_child_id;
         
		var v_btn_quotation_add = $('#btn_quotation_add').ladda();
		var v_btn_quotation_print = $('#btn_quotation_print').ladda();
		var v_btn_quotation_generate = $('#btn_quotation_generate').ladda();
		var v_btn_quotation_edit = $('#btn_quotation_edit').ladda();
		var v_btn_quotation_list_edit = $( '#btn_quotation_list_edit' ).ladda();
		var v_btn_quotation_search = $( '#btn_quotation_search' ).ladda();
	    $( '#quotation_list_table' ).hide();
		$( '#quotation_table' ).show();
		$( '#car_footer_edit' ).hide();
		var v_list_of_quotation_table = $('#list_of_quotation').DataTable({searching: false, paging: false, info: false,"ordering": false});
        load_data_to_grid_quotation_details_list();
			
		var list_of_quotation_view11_table = $('#list_of_quotation_view11').DataTable({searching: false, paging: false, info: false,"ordering": false});
		load_data_to_grid_quotation_view11_list_details_list();
		var v_list_of_quotation_table_edit = $('#list_of_quotation_edit').DataTable({searching: false, paging: false, info: false,"ordering": false});	
		$( '#btn_quotation_edit' ).hide();
		$( '#btn_quotation_master_edit' ).hide();
		
		//customer details change function starts
		
        $('#select_customer').change(function (e) {
                         
			v_customer_id=$("#select_customer option:selected").val();
		
			v_customer_name=$("#select_customer option:selected").text();
		
			$.ajax({
				type: "POST",
				url: "../controller/quotation/quotation_controller.php",
				 'data': {
					action: 'customer_list_view',
					v_customer_id:v_customer_id  
				 }
				 }).done(function(data){
				
					var obj = jQuery.parseJSON(data);
					
					$("#txt_customer_po_box").val(obj.data[0].customer_po_box); 
					$("#txt_customer_address").val(obj.data[0].customer_address); 
					$("#txt_customer_contact_no").val(obj.data[0].customer_contact_no); 
					
				 });
		});
		//customer details change function ends
		
		
		$("#txt_grand_total").val(0);
		$("#txt_quantity,#txt_rate").change(function(){
			var v_quantity=$("#txt_quantity").val();
			v_rate=$("#txt_rate").val();
			v_discount=$("#txt_discount").val();
			v_tax=$("#txt_tax").val(); 
			//alert(v_quantity);
			if(v_quantity=='')
			{
				v_quantity = 0.000;
			}
			else if(v_rate=='')
			{
			v_rate =0.000;	
			}

				v_total= parseFloat(v_quantity)*parseFloat(v_rate);
				
				$("#txt_grand_total").val(v_total.toFixed(3));
	
		});
		
		
		
	    //quotation button reload ends
		 
        $("#btn_reload_qtn").click(function () {   
			location.reload();
	    });
            
		 //quotation button reload ends
		 
		 
		
		//qoutation data insertion starts

        v_btn_quotation_add.click(function(){
			
            v_btn_quotation_add.ladda( 'start' );
			
            v_customer_id=$("#select_customer option:selected").val();
			v_customer_name=$("#select_customer option:selected").text();
			v_po_box=$("#txt_customer_po_box").val();
			v_address=$("#txt_customer_address").val();
			v_contact_no=$("#txt_customer_contact_no").val();
			v_attension=$("#txt_attension").val();
			v_quotation_date=$("#quotation_date").val();
			v_vat_content=$("#select_vat_content option:selected").val();
			v_subject=$("#txt_quotation_subject").val();
			v_description=$("#txt_quotation_description").val();
			v_quantity=$("#txt_quantity").val();
			v_unit=$("#txt_unit").val();
			v_rate=$("#txt_rate").val();
			v_quotation_number=$("#txt_quotation_number").val();
			v_created_by_id=$("#txt_created_by_id").val();
			v_created_by_name=$("#txt_created_by_name").val();
			v_approved_by_id=$("#txt_created_by_id").val();
			v_approved_by_name=$("#txt_created_by_name").val();
			var quotation_date_split=v_quotation_date.split('-');
			var v_date_month=quotation_date_split[1];
			var quotation_year=quotation_date_split[0];
			var v_date_year = quotation_year[quotation_year.length -2]+quotation_year[quotation_year.length -1];
			var reference_number_date=v_date_month+v_date_year;
			var v_total=parseFloat(v_quantity)*parseFloat(v_rate);
			
            if(typeof v_customer_id === "undefined"||$.trim(v_po_box)===""||$.trim(v_address)===""||$.trim(v_contact_no)===""||$.trim(v_attension)===""||$.trim(v_quotation_date)===""||$.trim(v_subject)===""||$.trim(v_description)==="")
            
            {
                swal("Warning","Please provide all the details ....", "warning");
                v_btn_quotation_add.ladda( 'stop' );
                return false;
            }
            else if($.trim(v_quantity)===""||$.trim(v_unit)===""||$.trim(v_rate)==="")
            {
                
                swal({                                      
        							title: "The amount is missing....",
        							text: "Do you want to add item?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Add'
        							}
        							}).then(function (willadd) {
        							if (willadd) {
        						
        						       add_quotation();
                     						 
        							} else {
        							    
        							   return false;
        							 
        							}
        			});
                
            }
            else
            {
             add_quotation();   
            }
           
           	function add_quotation()
           {
                 $.post("../controller/quotation/quotation_controller.php",{action:'add_quotation',v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_po_box:v_po_box,v_address:v_address,v_contact_no:v_contact_no,v_attension:v_attension,v_quotation_date:v_quotation_date,v_subject:v_subject,v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_quotation_number:v_quotation_number,v_total:v_total,v_created_by_id:v_created_by_id,v_created_by_name:v_created_by_name,v_approved_by_id:v_approved_by_id,v_approved_by_name:v_approved_by_name,reference_number_date:reference_number_date,v_vat_content:v_vat_content}
                        , function(result,status)
                        {
							v_reference_number = $.trim(result);
							
                        $('#txt_quotation_number').val(v_reference_number);
                        if(result.charAt(0)=='U')
                        {
                            v_btn_quotation_add.ladda( 'stop' );
                            swal("Error", result, "error");
                            clear_text();
                        }
                        else 
                        {
                             v_btn_quotation_add.ladda( 'stop' );
                             load_data_to_grid_quotation_details_list(v_reference_number);
                             load_data_to_grid_quotation_details_edit_list_view(v_reference_number);
                             clear_text_add_button();
                        }
                        
                         
                    
                });
                
               
                
             }
          
        });
		
		//quotation data insertion ends
		
	
		
		
		
		
		
		 //load data to quotation grid starts
		 
                 function load_data_to_grid_quotation_details_list(v_reference_number)
                 {
                  
                    v_list_of_quotation_table.destroy();
                         
                     v_list_of_quotation_table = $('#list_of_quotation').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/quotation/quotation_controller.php',
                                 'data': {
                                    action: 'quotation_list_view',
									v_quotation_number:v_reference_number
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
                            "searching": false,
                            "paging": false,
                            "info": false,
                            "ordering": false,
            				"Paginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                              
                                 { "data": null},
                                 { "data": "description",},
								 { "data": "quantity" },
                                 { "data": "unit" },
                                 { "data": "rate"},
                                 { "data": "total"},
                                 { "data": "quotation_child_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Quotation" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Delete_Quotation" style="color:red"><i class="icon-book2"></i> DELETE</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: false,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
							  "drawCallback": function () {
                                   
                                },
							  
							  //footer total calculation starts here
							  
									 "footerCallback": function ( row, data, start, end, display ) {
										var api = this.api(), data;
							 
										// Remove the formatting to get integer data for summation
										var intVal = function ( i ) {
											return typeof i === 'string' ?
												i.replace(/[\$,]/g, '')*1 :
												typeof i === 'number' ?
													i : 0;
										};
										
										//amount total
										// Total over all pages
										total = api
											.column( 5 )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Total over this page
										pageTotal1 = api
											.column( 5, { page: 'current'} )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Update footer
										$( api.column( 5 ).footer() ).html(
											''+pageTotal1.toFixed(3) 
										);
														  
									
															  
									 }
							  //footer total calculation ends here
		
                             
                            
                     });  
                
                 }
                 
                 
                 
			
                            
                            
                            
				
                v_btn_quotation_generate.click(function(){
                  
					
                    v_btn_quotation_generate.ladda( 'start' );
                    v_terms_and_condition=CKEDITOR.instances.txt_terms_and_condition.getData();
					var v_quotation_number=$('#txt_quotation_number').val();
					v_description=$("#txt_quotation_description").val();
					v_quantity=$("#txt_quantity").val();
					v_unit=$("#txt_unit").val();
					v_rate=$("#txt_rate").val();
					v_discount=$("#txt_discount").val();
					v_tax=$("#txt_tax").val();
					v_customer_id=$("#select_customer option:selected").val();
					v_customer_name=$("#select_customer option:selected").text();
					v_po_box=$("#txt_customer_po_box").val();
					v_address=$("#txt_customer_address").val();
					v_contact_no=$("#txt_customer_contact_no").val();
					v_attension=$("#txt_attension").val();
					v_quotation_date=$("#quotation_date").val();
					v_subject=$("#txt_quotation_subject").val();
					v_created_by_id=$("#txt_created_by_id").val();
					v_created_by_name=$("#txt_created_by_name").val();
					v_approved_by_id=$("#txt_created_by_id").val();
					v_approved_by_name=$("#txt_created_by_name").val();
					var v_total=parseFloat(v_quantity)*parseFloat(v_rate);

								

					
					           $.post("../controller/quotation/quotation_controller.php",{action:'generate_quotation',v_quotation_number:v_quotation_number,v_terms_and_condition:v_terms_and_condition,v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_po_box:v_po_box,v_address:v_address,v_contact_no:v_contact_no,v_attension:v_attension,v_quotation_date:v_quotation_date,v_subject:v_subject,v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_total:v_total,v_created_by_id:v_created_by_id,v_created_by_name:v_created_by_name,v_approved_by_id:v_approved_by_id,v_approved_by_name:v_approved_by_name}
                                , function(result,status)
                                {

                                if(result.charAt(0)=='U')
                                {
                                    v_btn_quotation_generate.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                }
                                else 
                                {
                                     v_btn_quotation_generate.ladda( 'stop' );
                                     swal("Success", "Quotation generated successfully..", "success");
                                    
                                    
                                }
                                
                                 
                            
                        });
				});
			 //generate quotations button ends
			 
			 //edit and delete quotation starts  
			 
				$('#list_of_quotation tbody').on('click', 'a', function (){
                      
                       var $row = $("#list_of_quotation tr").css("background", "#fff"); //reset to original color
                  
                      var $row = $(this).closest('tr').css("background-color", "#E0E0E0");
                      var data = v_list_of_quotation_table.row($row).data();
					  //console.log(data);
                      v_quotation_number  = data.quotation_ref_no;
					  //alert(v_quotation_number);
                         if($(this).attr("name")=='Edit_Quotation')
                         {
                             
            			   edit_child_quotation_data(); 
            			
            			 }
            			 
            			  if($(this).attr("name")=='Delete_Quotation')
                         {
                             
            			    swal({
                                                                    
        							title: "Are you sure?",
        							text: "Do you want to delete the entry?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Delete'
        							}
        							}).then(function (willDelete) {
        							if (willDelete) {
        						
        						       cancel_quotation_items_list(data.quotation_child_id,data.quotation_ref_no);
                     						 
        							} else {
        							    
        							   
        							 
        							}
        						 });
            			
            			 }
                        
                  
            
                   
            function edit_child_quotation_data()
                 {
  
                        $("#txt_quotation_child_id").val(data.quotation_child_id);
						$("#txt_quotation_master_id").val(data.quotation_id);
                        $('#txt_quotation_description').val(data.description);
						$("#txt_quotation_ref_no").val(data.quotation_ref_no);
                        $('#txt_quantity').val(data.quantity);
                        $('#txt_unit').val(data.unit);
                        $('#txt_rate').val(data.rate);
                       $("#txt_grand_total").val(data.total);
                     
                        $( '#btn_quotation_add' ).hide();
                        $( '#btn_quotation_edit' ).show();
                 }
                      
                  });
				  
				  function cancel_quotation_items_list(v_quotation_child_id,quotation_ref_no)
                    {
                        //alert(v_quotation_child_id);
                        $.post("../controller/quotation/quotation_controller.php",{action:'cancel_quotation_item',v_quotation_child_list_id:v_quotation_child_id
                                                }
                                                , function(result,status)
                                                {
                                                     swal("Quotation has been deleted!", {
                        							    icon: "success",
                        							  });
                                                   v_reference_number= quotation_ref_no;
                                                   //alert(v_reference_number);
                                             load_data_to_grid_quotation_details_list(v_reference_number);
                                              //$('#txt_quotation_description,#txt_quotation_quantity,#txt_quotation_unit,#txt_quotation_rate,#txt_discount_percentage,#txt_tax_percentage').val('');
                                                   
                         });
                       
                    }   
			 
				 v_btn_quotation_edit.click(function(){
                      
                    v_btn_quotation_edit.ladda( 'start' );
					
                    	v_description=$("#txt_quotation_description").val();
						v_quantity=$("#txt_quantity").val();
						v_unit=$("#txt_unit").val();
						v_rate=$("#txt_rate").val();
						v_discount=$("#txt_discount").val();
						v_tax=$("#txt_tax").val(); 
						v_quotation_child_id=$("#txt_quotation_child_id").val();
						v_quotation_master_id=$("#txt_quotation_master_id").val();
						v_quotation_ref_no=$("#txt_quotation_ref_no").val();
		
						var v_total=parseFloat(v_quantity)*parseFloat(v_rate);

						if(v_discount!='')
						{
							var discount_value=parseFloat(v_total)*(parseFloat(v_discount)/100);
							var discount_amount=parseFloat(v_total)-parseFloat(discount_value);
							var discount_tax_amount=parseFloat(discount_amount)*(parseFloat(v_tax)/100);
							var v_grand_total=parseFloat(discount_amount)+parseFloat(discount_tax_amount);
						}
						else
						{
							var vat_amount=parseFloat(v_total)*(parseFloat(v_tax)/100);
							var v_grand_total=parseFloat(v_total)+parseFloat(vat_amount);
						}
					  
                  
                    if($.trim(v_description)===""||$.trim(v_quantity)===""||$.trim(v_unit)===""||$.trim(v_rate)===""||$.trim(v_tax)==="")
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_quotation_edit.ladda( 'stop' );
                        return false;
                    }
                    
                    
                   
                    else
                    {         
                         $.post("../controller/quotation/quotation_controller.php",{action:'edit_quotation',v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_discount:v_discount,v_tax:v_tax,v_total:v_total,v_grand_total:v_grand_total,v_quotation_child_id:v_quotation_child_id,v_quotation_master_id:v_quotation_master_id,v_quotation_number:v_quotation_ref_no
                                }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_quotation_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    load_data_to_grid_quotation_details_list(v_reference_number);
                                    clear_text();
                                   
                                   

                                
                                }
                                else
                                {
                                     v_btn_quotation_edit.ladda( 'stop' );

                                     swal("Success", "Quotation Updated successfully..", "success");
                                     $( '#btn_quotation_add' ).show();
                                     $( '#btn_quotation_edit' ).hide();
                                    load_data_to_grid_quotation_details_list(v_reference_number);
                                     clear_text_add_button()
                                    
                                }
                            
                        }); 
                     }
            
                   
                }); 
			 
			 //edit and delete quotation ends
                  
			 //function clear text
                   function clear_text()
                 {

					$('#txt_quotation_number').val('');
					$("#txt_quotation_description").val('');
					$("#txt_quantity").val('');
					$("#txt_unit").val('');
					$("#txt_rate").val('');
					$("#txt_discount").val('');
					$("#txt_tax").val('');
					$("#select_customer").val(null).trigger("change");
					$("#txt_customer_po_box").val('');
					$("#txt_customer_address").val('');
					$("#txt_customer_contact_no").val('');
					$("#txt_attension").val('');
					$("#quotation_date").val('');
					$("#txt_quotation_subject").val('');

                    
                 }
				 
		// quotation list search button click starts
		
		 v_btn_quotation_search.click(function(){
					
                    v_btn_quotation_search.ladda( 'start' );
                    var v_quotation_start_date=$("#quotation_start_date").val();
					var v_quotation_end_date=$("#quotation_end_date").val();
					var v_quotation_customer_id=$("#select_customer option:selected").val();
					var v_quotation_customer_name=$("#select_customer option:selected").text();
					 // alert(v_quotation_customer_id);
					load_data_to_grid_quotation_view11_list_details_list(v_quotation_start_date,v_quotation_end_date,v_quotation_customer_id);
					 v_btn_quotation_search.ladda( 'stop' );
                    
		 });
		
    //quotation list page js starts here

			function load_data_to_grid_quotation_view11_list_details_list(v_quotation_start_date,v_quotation_end_date,v_quotation_customer_id)
                 {
					 
                     list_of_quotation_view11_table.destroy();
                         
                     list_of_quotation_view11_table = $('#list_of_quotation_view11').DataTable( {
                            
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/quotation/quotation_controller.php',
                                 'data': {
                                    action: 'quotation_details_list_view',
                                    v_quotation_start_date:v_quotation_start_date,
                                    v_quotation_end_date:v_quotation_end_date,
                                    v_quotation_customer_id:v_quotation_customer_id
                                  
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 0, "desc" ]],
            				"bPaginate": false,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
                            "columns": [
                                 { "data": null },
                                 { "data": "quotation_ref_no"},
                                 { "data": "customer_name"},
                                 { "data": "date"},
                                 { "data": "quotation_id" ,
					 
                     
                                      render: function ( data, type, rows, meta ) {
                                                return '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="quotation.php?RefNo='+rows["quotation_ref_no"]+'" class="dropdown-item" style="color:orange"><i class="icon-database-edit2"></i> Edit</a></div></div></div>';
												 //return '<a href="quotation.php?RefNo='+rows["quotation_ref_no"]+'">Edit</a>';
												//return '<a href="quotation.php?RefNo=rows["quotation_ref_no"]" class="dropdown-item" name="Edit_Quotation_List" style="color:orange"><i class="icon-database-edit2"></i>Edit</a>'
            									//str_active_status_view = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="quotation.php" class="dropdown-item" name="Edit_Quotation_List" style="color:orange"><i class="icon-database-edit2"></i>Edit</a></div></div></div>';
            								
            								//return str_active_status_view;
            
            							 },
            							 
            					

					 
					         },
            				
                             ],
                             pageLength: 25,
            				 searching: false,
                             responsive: true,
            				
                            
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                              "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                             },
                              "fnDrawCallback": function() {
                               
             
                             },
                        
                         
                     });  
                
                 }

		v_reference_number=$('#txt_ref_no_edit').val();	
		if(v_reference_number!='')
		{
			$( '#quotation_list_table' ).show();
			$( '#quotation_table' ).hide();
			$( '#card_footer_generate').hide();
			$( '#car_footer_edit').show();
			
			
			$.post("../controller/quotation/quotation_controller.php",{action:'quotation_details_list_edit_master',v_quotation_number:v_reference_number			
													}
													, function(result,status)
													{
													
														var obj = jQuery.parseJSON(result);
													
														$("#select_customer").val(obj.data[0].customer_id).trigger('change');
														$("#txt_customer_po_box").val(obj.data[0].po_box); 
														$("#txt_customer_address").val(obj.data[0].address); 
														$("#txt_customer_contact_no").val(obj.data[0].contact_no);
														$("#txt_quotation_number").val(obj.data[0].quotation_ref_no);
														$("#txt_quotation_master_id").val(obj.data[0].quotation_id);
														$("#txt_attension").val(obj.data[0].attention); 
														$("#quotation_date").val(obj.data[0].date);
														$("#txt_quotation_subject").val(obj.data[0].subject); 
														var v_quotation_id=obj.data[0].quotation_id;
														CKEDITOR.instances['txt_terms_and_condition'].setData(obj.data[0].terms_and_condition);
													
														load_data_to_grid_quotation_details_edit_list_view(v_reference_number);
														
							 });
							 
		}				 
					//load data to quotation grid starts
         	//load data to quotation grid starts
                 function load_data_to_grid_quotation_details_edit_list_view(v_reference_number)
                 {
                    //alert(v_reference_number);
                    v_list_of_quotation_table_edit.destroy();
                         
                     v_list_of_quotation_table_edit = $('#list_of_quotation_edit').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/quotation/quotation_controller.php',
                                 'data': {
                                    action: 'quotation_details_list_edit_child',
									v_quotation_number:v_reference_number
                                    
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
                                /* {
                                    "className":  'details-control',
                                    "orderable":  false,
                                    "data":        null,
                                    "defaultContent": '',
                                    
                                 }, */
                                 
                                 { "data": null},
                                 { "data": "description",},
								 { "data": "quantity" },
                                 { "data": "unit" },
                                 { "data": "rate"},
                                 { "data": "total"},
        //                          { "data": "discount" },
        //                          //{ "data": "discount","visible":false },
								//  { "data": "vat" },
								//  { "data": "grant_total"},
                                 { "data": "quotation_child_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_Quotation" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Delete_Quotation" style="color:red"><i class="icon-book2"></i> DELETE</a></div></div></div>';
                                          return str_active_status_edit;
                                          
                                      }   
                                 }
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
							  "drawCallback": function () {
                                   
                                },
							  
							  //footer total calculation starts here
							  
									 "footerCallback": function ( row, data, start, end, display ) {
										var api = this.api(), data;
							 
										// Remove the formatting to get integer data for summation
										var intVal = function ( i ) {
											return typeof i === 'string' ?
												i.replace(/[\$,]/g, '')*1 :
												typeof i === 'number' ?
													i : 0;
										};
										
										//amount total
										// Total over all pages
										total = api
											.column( 5 )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Total over this page
										pageTotal1 = api
											.column( 5, { page: 'current'} )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Update footer
										$( api.column( 5 ).footer() ).html(
											''+pageTotal1.toFixed(3) 
										);
														  
									
															  
									 }
							  //footer total calculation ends here
		
                             
                            
                     });  
                
                 }       
		$('#list_of_quotation_edit tbody').on('click', 'a', function (){
		    
                      var $row=  $("#list_of_quotation_edit tr").css("background", "#fff"); //reset to original color
                      
                      var $row = $(this).closest('tr').css("background-color", "#E0E0E0");
                      var data = v_list_of_quotation_table_edit.row($row).data();
					  //console.log(data);
                      v_quotation_number  = data.quotation_ref_no;
					  //alert(v_quotation_number);
                         if($(this).attr("name")=='Edit_Quotation')
                         {
                             
            			   edit_child_quotation_data(); 
            			
            			 }
            			 
            			  if($(this).attr("name")=='Delete_Quotation')
                         {
                             
            			    swal({
                                                                    
        							title: "Are you sure?",
        							text: "Do you want to delete the entry?",
        							icon: 'warning',
        							dangerMode: true,
        							allowOutsideClick: false,
                                    closeOnClickOutside: false,
        							buttons: {
        							  cancel: 'No Cancel !',
        							  delete: 'Yes Please Delete'
        							}
        							}).then(function (willDelete) {
        							if (willDelete) {
        						
        						       cancel_quotation_item_list(data.quotation_child_id,data.quotation_ref_no);
                     						 
        							} else {
        							    
        							   
        							 
        							}
        						 });
            			
            			 }
                        
                  
            
                   
            function edit_child_quotation_data()
                 {
  
                        $("#txt_quotation_child_id").val(data.quotation_child_id);
						$("#txt_quotation_master_id").val(data.quotation_id);
                        $('#txt_quotation_description').val(data.description);
						$("#txt_quotation_ref_no").val(data.quotation_ref_no);
						//alert(data.quotation_ref_no);
                        $('#txt_quantity').val(data.quantity);
                        $('#txt_unit').val(data.unit);
                        $('#txt_rate').val(data.rate);
                        //$('#txt_quotation_amount').val(data.amount);
                        $('#txt_discount').val(data.discount);
                        //$('#txt_amt_after_discount').val(data.discount_amount);
                        $('#txt_tax').val(data.vat);
                        $('#txt_grand_total').val(data.grant_total);
                       
                     
                        $( '#btn_quotation_add' ).hide();
                        $( '#btn_quotation_edit' ).show();
                 }
                      
                  });
		
		 function cancel_quotation_item_list(v_quotation_child_id,quotation_ref_no)
                    {
                        //alert(v_quotation_child_id);
                        $.post("../controller/quotation/quotation_controller.php",{action:'cancel_quotation_item',v_quotation_child_list_id:v_quotation_child_id
                                                }
                                                , function(result,status)
                                                {
													//location.reload();
                                             load_data_to_grid_quotation_details_edit_list_view(v_reference_number);
                                              //$('#txt_quotation_description,#txt_quotation_quantity,#txt_quotation_unit,#txt_quotation_rate,#txt_discount_percentage,#txt_tax_percentage').val('');
                                                   
                         });
                       
                    }   
		
					 
				 v_btn_quotation_edit.click(function(){
                      
                    v_btn_quotation_edit.ladda( 'start' );
					
                    	v_description=$("#txt_quotation_description").val();
						
						v_quantity=$("#txt_quantity").val();
						v_unit=$("#txt_unit").val();
						v_rate=$("#txt_rate").val();
						v_discount=$("#txt_discount").val();
						v_tax=$("#txt_tax").val(); 
						
						v_quotation_child_id=$("#txt_quotation_child_id").val();
						v_quotation_master_id=$("#txt_quotation_master_id").val();
						v_quotation_ref_no=$("#txt_quotation_ref_no").val();
						//alert(v_description+ v_quantity+v_rate+v_discount+v_tax+v_quotation_ref_no);
					
						
						var v_total=parseFloat(v_quantity)*parseFloat(v_rate);

						if(v_discount!='')
						{
							var discount_value=parseFloat(v_total)*(parseFloat(v_discount)/100);
							var discount_amount=parseFloat(v_total)-parseFloat(discount_value);
							var discount_tax_amount=parseFloat(discount_amount)*(parseFloat(v_tax)/100);
							var v_grand_total=parseFloat(discount_amount)+parseFloat(discount_tax_amount);
						}
						else
						{
							var vat_amount=parseFloat(v_total)*(parseFloat(v_tax)/100);
							var v_grand_total=parseFloat(v_total)+parseFloat(vat_amount);
						}
					  
                  
                    if($.trim(v_description)===""||$.trim(v_quantity)===""||$.trim(v_unit)===""||$.trim(v_rate)===""||$.trim(v_tax)==="")
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        v_btn_quotation_edit.ladda( 'stop' );
                        return false;
                    }
                    
                    
                   
                    else
                    {         
                         $.post("../controller/quotation/quotation_controller.php",{action:'edit_quotation',v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_discount:v_discount,v_tax:v_tax,v_total:v_total,v_grand_total:v_grand_total,v_quotation_child_id:v_quotation_child_id,v_quotation_master_id:v_quotation_master_id,v_quotation_number:v_reference_number
                                }
                                , function(result,status)
                                {
                                   
                                result = $.trim(result);
                               
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_quotation_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    load_data_to_grid_quotation_details_edit_list_view(v_reference_number);
                                    clear_text();
                                   
                                   

                                
                                }
                                else
                                {
                                     v_btn_quotation_edit.ladda( 'stop' );

                                     swal("Success", "Quotation Updated successfully..", "success");
                                     $( '#btn_quotation_add' ).show();
                                     $( '#btn_quotation_edit' ).hide();
									
                                    load_data_to_grid_quotation_details_edit_list_view(v_reference_number);
                                     //clear_text()
                                     //location.reload();
                                }
                            
                        }); 
                     }
            
                   
                }); 
			 
			 //edit and delete quotation ends
		
		v_btn_quotation_list_edit.click(function(){
			
					v_btn_quotation_list_edit.ladda( 'start' );
					//v_terms_and_condition = CKEDITOR.instances.editor.getData();
					//v_terms_and_condition=$("#txt_terms_and_condition").val();
					v_terms_and_condition=CKEDITOR.instances.txt_terms_and_condition.getData();
					var v_reference_no=$('#txt_quotation_number').val();
					v_description=$("#txt_quotation_description").val();
					v_quantity=$("#txt_quantity").val();
					v_unit=$("#txt_unit").val();
					v_rate=$("#txt_rate").val();
					v_discount=$("#txt_discount").val();
					v_tax=$("#txt_tax").val();
					
					v_customer_id=$("#select_customer option:selected").val();
					v_customer_name=$("#select_customer option:selected").text();
					v_po_box=$("#txt_customer_po_box").val();
					v_address=$("#txt_customer_address").val();
					v_contact_no=$("#txt_customer_contact_no").val();
					v_attension=$("#txt_attension").val();
					v_quotation_date=$("#quotation_date").val();
					v_subject=$("#txt_quotation_subject").val();
					v_created_by_id=$("#txt_created_by_id").val();
					v_created_by_name=$("#txt_created_by_name").val();
					v_approved_by_id=$("#txt_created_by_id").val();
					v_approved_by_name=$("#txt_created_by_name").val();
					v_quotation_master_id=$("#txt_quotation_master_id").val();
					
					v_reference_number=v_reference_no+'r';
					//alert(v_reference_number);
					var v_total=parseFloat(v_quantity)*parseFloat(v_rate);
					

					if(v_discount!='')
					{
						var discount_value=parseFloat(v_total)*(parseFloat(v_discount)/100);
						var discount_amount=parseFloat(v_total)-parseFloat(discount_value);
						var discount_tax_amount=parseFloat(discount_amount)*(parseFloat(v_tax)/100);
						var v_grand_total=parseFloat(discount_amount)+parseFloat(discount_tax_amount);
					}
					else
					{
						var vat_amount=parseFloat(v_total)*(parseFloat(v_tax)/100);
						var v_grand_total=parseFloat(v_total)+parseFloat(vat_amount);
					}					
			
			swal({
                                                                    
					title: "Are you sure?",
					text: "Do you want to revise the quotation?",
					icon: 'warning',
					dangerMode: true,
					allowOutsideClick: false,
					closeOnClickOutside: false,
					buttons: {
					  cancel: 'No !',
					  delete: 'Yes '
					}
					}).then(function (willDelete) {
					if (willDelete) {
				
					  
			$.post("../controller/quotation/quotation_controller.php",{action:'rivision_quotation_add',v_quotation_number:v_quotation_number,v_terms_and_condition:v_terms_and_condition,v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_po_box:v_po_box,v_address:v_address,v_contact_no:v_contact_no,v_attension:v_attension,v_quotation_date:v_quotation_date,v_subject:v_subject,v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_discount:v_discount,v_tax:v_tax,v_total:v_total,v_grand_total:v_grand_total,v_created_by_id:v_created_by_id,v_created_by_name:v_created_by_name,v_approved_by_id:v_approved_by_id,v_approved_by_name:v_approved_by_name,v_quotation_number:v_reference_no,v_quotation_number_rivision:v_reference_number,v_quotation_master_id:v_quotation_master_id,v_quotation_child_id:v_quotation_child_id
                                                }
                                                , function(result,status)
                                                {
                                             load_data_to_grid_quotation_view11_list_details_list();
											  v_btn_quotation_list_edit.ladda( 'stop' );
											   swal("Success", "Quotation revised successfully..", "success");
											 
                                              //$('#txt_quotation_description,#txt_quotation_quantity,#txt_quotation_unit,#txt_quotation_rate,#txt_discount_percentage,#txt_tax_percentage').val('');
                                              clear_text()     
                         });
							 
					} else {
						
					   $.post("../controller/quotation/quotation_controller.php",{action:'generate_quotation',v_quotation_number:v_quotation_number,v_terms_and_condition:v_terms_and_condition,v_customer_id:v_customer_id,v_customer_name:v_customer_name,v_po_box:v_po_box,v_address:v_address,v_contact_no:v_contact_no,v_attension:v_attension,v_quotation_date:v_quotation_date,v_subject:v_subject,v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,v_rate:v_rate,v_discount:v_discount,v_tax:v_tax,v_total:v_total,v_grand_total:v_grand_total,v_created_by_id:v_created_by_id,v_created_by_name:v_created_by_name,v_approved_by_id:v_approved_by_id,v_approved_by_name:v_approved_by_name,v_reference_number:v_reference_number
                                                }
                                                , function(result,status)
                                                {
                                             load_data_to_grid_quotation_view11_list_details_list();
											  v_btn_quotation_list_edit.ladda( 'stop' );
											  swal("Success", "Quotation Updated successfully..", "success");
                                              //$('#txt_quotation_description,#txt_quotation_quantity,#txt_quotation_unit,#txt_quotation_rate,#txt_discount_percentage,#txt_tax_percentage').val('');
                                               clear_text()    
                         });
					 
					}
			});

			 //load_data_to_grid_quotation_details_list(v_reference_number);
			 //clear_text();
		});
		
		// edit child datatable ends
//quotation list js ends here

//function clear text
           function clear_text()
                 {
                   
                    $("#select_customer").val(null).trigger("change");
                  
                    $("#txt_quotation_number").val('');
                    $("#txt_customer_po_box").val('');
                    $("#txt_customer_address").val('');
                    $("#txt_customer_contact_no").val('');
                    $("#txt_attension").val('');
                    $("#quotation_date").val('');
                    $("#txt_quotation_subject").val('');
                   
                    $("#txt_quotation_description").val('');
                    $("#txt_quantity").val('');
                    $("#txt_unit").val('');
                    $("#txt_rate").val('');
                    $("#txt_discount").val('');
                   
					
					$("#txt_tax").val('');
					$("#txt_grand_total").val('');
					
					
                 }
            function clear_text_add_button()
                 {
                  
                   
                    $("#txt_quotation_description").val('');
                    $("#txt_quantity").val('');
                    $("#txt_unit").val('');
                    $("#txt_rate").val('');
                    $("#txt_discount").val('');
                   
					
					$("#txt_tax").val('');
					$("#txt_grand_total").val('');
					
					
                 } 
                 
                 
                 	
		$("#btn_quotation_print").click(function(){
		   
		    var quotation_number=$('#txt_quotation_number').val();
                           if($.trim(quotation_number)=="")
                    {
                                    
                        swal("Error",'Please select or create quotation for print','error');            
                        
                    }
                    else
                    {
                       $.post("../controller/quotation/quotation_controller.php",{action:'check_quotation_status_for_print',v_quotation_number:quotation_number},function(result,status){
                       var obj= jQuery.parseJSON(result);
                        var v_quotation_status=obj.data[0].req_status;
                        alert(v_quotation_status);
                       if(v_quotation_status =='Pending')
                       {
                                  
                         swal("Error",'Please generate quotation for print','error');  
                       }
                       else
                       {
                          window.open("print/print_quotation.php?quotation_number="+quotation_number,"_blank"); 
                       }
                       
                       
                       });
                    }
                        
		    
		});
                  
});