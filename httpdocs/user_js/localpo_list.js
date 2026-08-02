$(document).ready(function(){
	
	var v_lpo_child_id,item_name,item_qty,unit_price,discount_percent,v_lpo_start_date,v_lpo_end_date,v_vendor_list_id,tax_percent,v_grand_total,v_ref,v_terms_and_condition,v_vendor_id,v_vendor_name,v_vat_no,v_qtn_ref_no,v_lpo_po,v_tel_no,v_lpo_date,v_fax_no,v_subject	;
	
	var v_btn_lpo_update = $( '#btn_lpo_update' ).ladda(); 
	var v_btn_lpo_master_edit = $( '#btn_lpo_master_edit' ).ladda();
	var v_btn_lpo_master_add = $( '#btn_lpo_add' ).ladda(); 
	var v_btn_lpo_list_search = $( '#btn_lpo_list_search' ).ladda();

	$( '#btn_lpo_generate' ).hide();
    $( '#btn_lpo_master_edit' ).hide();	
	$( '#btn_lpo_add' ).hide();
	clear_text();
	var list_of_lpo_view_table = $('#tbl_lpo_list').DataTable({searching: false, paging: false, info: false,"ordering": false});
	load_data_to_grid_lpo_view_list_details(v_lpo_start_date,v_lpo_end_date,v_vendor_list_id);
	
	
	var list_of_lpo_second_view_table = $('#tbl_list_second_child_data').DataTable({searching: false, paging: false, info: false,"ordering": false});

	function load_data_to_grid_lpo_view_list_details(v_lpo_start_date,v_lpo_end_date,v_vendor_list_id)
                 {
			 list_of_lpo_view_table.destroy();
				 
			 list_of_lpo_view_table = $('#tbl_lpo_list').DataTable( {
					
					 "ajax": {
						 'type': 'POST',
						 'url': '../controller/localpo/localpo_controller.php',
						 'data': {
							action: 'lpo_details_list_view',
							v_lpo_start_date:v_lpo_start_date,
							v_lpo_end_date:v_lpo_end_date,
							v_vendor_list_id:v_vendor_list_id
						  
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
						 { "data": "lpo_ref_no"},
						 { "data": "vendor_name"},
						 { "data": "lpo_date"},
						 { "data": "lpo_ref_no" ,
			 
			 
							  render: function ( data, type, rows, meta ) {
							
										str_active_status_view = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" data-toggle="modal" name="lpo_edit" data-target="#modal_lpo_renew"><i class="icon-pencil5"></i> Edit</a></div></div></div>';
									
									return str_active_status_view;
	
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
				 $("#lpo_list_reload").click(function () {   
				     location.reload();
		             });
				 // lpo list search button click starts
		
            		 v_btn_lpo_list_search.click(function(){
            					
                                v_btn_lpo_list_search.ladda( 'start' );
                                 v_lpo_start_date=$("#lpo_start_date").val();
            					 v_lpo_end_date=$("#lpo_end_date").val();
            					 v_vendor_list_id=$("#select_vendor_list option:selected").val();
            					var v_vendor_list_name=$("#select_vendor_list option:selected").text();
            					 // alert(v_quotation_customer_id);
            					load_data_to_grid_lpo_view_list_details(v_lpo_start_date,v_lpo_end_date,v_vendor_list_id);
            					 v_btn_lpo_list_search.ladda( 'stop' );
                                
            		 });
            		
                //lpo list page js starts here
				   
				 
			 $('#tbl_lpo_list tbody').on('click', 'a', function (){
                      
                      var $row = $(this).closest('tr');
                      var data = list_of_lpo_view_table.row($row).data();
					  console.log(data);
                      v_ref_no  = data.lpo_ref_no;
					  //alert(v_quotation_number);

                         if($(this).attr("name")=='lpo_edit')
                         {
                             
            			   edit_master_lpo_data(); 
            			
            			 }
						var v_btn_lpo_add= $( '#btn_lpo_add' ).ladda();
						var v_btn_lpo_update = $( '#btn_lpo_update' ).ladda(); 
						$( '#btn_lpo_add' ).hide();
						$( '#btn_lpo_update' ).hide();
						$( '#btn_lpo_update' ).show();
						
						load_data_to_grid_lpo_second_list_details(v_ref_no);
									   
                     function edit_master_lpo_data()
                      {
  
                        //alert(data.lpo_ref_no);
						$("#txt_lpo_ref_no").val(data.lpo_ref_no);
						$("#select_vendor_list_second").val($.trim(data.vendor_id)).trigger('change');
						
						var v_date=data.lpo_date;
							   
						v_date = v_date.split("-").reverse();
						
						var tmp =  v_date[2]+"-"+v_date[1]+"-"+v_date[0];

						$("#txt_lpo_date").val(tmp);
                        $('#txt_vat_no').val(data.vendor_vat_no);
						$("#txt_lpo_po_box").val(data.vendor_po);
						
						$("#lpo_qtn_ref_no").val(data.quotation_ref_no);
						$("#txt_tel_no").val(data.vendor_tel);
						$("#txt_fax_no").val(data.vendor_fax);
						$("#txt_subject").val(data.subject);
						/* $("#txt_descri_name").val(data.description);
						
						
						//$("#txt_quotation_child_id").val(data.quotation_child_id);
                        $('#txt_quantity').val(data.quantity);
                        $('#txt_unit').val(data.unit);
                        $('#txt_unit_price').val(data.unit_price);
                        $('#txt_discount').val(data.discount);
                        $('#txt_tax').val(data.tax);
                        $('#txt_grand_total').val(data.grand_total); */
       
                 }
                      
                  });
				  
				 function load_data_to_grid_lpo_second_list_details(lpo_ref)
                 {
                     
                    list_of_lpo_second_view_table.destroy();
                         
                     list_of_lpo_second_view_table = $('#tbl_list_second_child_data').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/localpo/localpo_controller.php',
                                 'data': {
                                    action: 'view_child_details',
									lpo_ref:lpo_ref
                                    
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
                                 { "data": "unit_price"},
                                 { "data": "total_price"},
                                
                                 //{ "data": "discount","visible":false },
								 { "data": "tax" },
								 { "data": "discount"},
								 { "data": "grand_total"},
                                 { "data": "lpo_child_id",
                                      render: function ( data, type, rows, meta ) {
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_second_lpo" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Delete_second_lpo" style="color:red"><i class="icon-book2"></i> DELETE</a></div></div></div>';
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
											pageTotal1.toFixed(3) 
										);
														  
										//grand total
										// Total over all pages
											total = api
											.column( 8 )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Total over this page
										pageTotal1 = api
											.column( 8, { page: 'current'} )
											.data()
											.reduce( function (a, b) {
												return intVal(a) + intVal(b);
											}, 0 );
							 
										// Update footer
										$( api.column( 8 ).footer() ).html(
											pageTotal1.toFixed(3) 
										);
															  
									 }
							  //footer total calculation ends here
		
                             
                            
                     });  
                
                 }
				  
				 
				  $('#tbl_list_second_child_data tbody').on('click', 'a', function(){
                       //$('#div_list_product_type').show();
                        var $row = $(this).closest('tr');
                        var list_lpo_child_data = list_of_lpo_second_view_table.row($row).data();
                        v_lpo_child_id  = list_lpo_child_data.lpo_child_id;
                        v_ref=list_lpo_child_data.lpo_ref_no;
						
						  item_name=list_lpo_child_data.description;
						  item_qty=list_lpo_child_data.quantity;
						  item_unit=list_lpo_child_data.unit;
				   
						  unit_price=list_lpo_child_data.unit_price;
						  discount_percent=list_lpo_child_data.discount;
						 tax_percent=list_lpo_child_data.tax;
						 v_grand_total=list_lpo_child_data.grand_total
						  //vat_percent=list_lpo_child_data.vat;
                         
                         if($(this).attr("name")=='Edit_second_lpo')
                         {
                         
                            edit_lpo_details(v_lpo_child_id);
            			    $( '#btn_lpo_add' ).hide();
							$( '#btn_lpo_master_edit' ).show();

            			 }
						 if($(this).attr("name")=="Delete_second_lpo" ){
								$.ajax({
									type: "POST",
									url: "../controller/localpo/localpo_controller.php",
									data: {
											action: 'delete_second_lpo',
											v_lpo_child_second_id : v_lpo_child_id 
										 }
										
							 })
							 load_data_to_grid_lpo_second_list_details(v_ref);
							
						  }  
                     
						});
						function edit_lpo_details(v_lpo_child_id)
                            {
                                $("#txt_descri_name").val(item_name);  
                                $("#txt_quantity").val(item_qty);  
								$("#txt_unit").val(item_unit);  
								$("#txt_unit_price").val(unit_price);  
								$("#txt_discount").val(discount_percent);  
								$("#txt_tax").val(tax_percent);  
                                $("#txt_grand_total").val(v_grand_total); 
                                
                            }
							
                     //edit click
                    v_btn_lpo_master_edit.click(function(){
							
                            v_btn_lpo_master_edit.ladda( 'start' );
                            var v_description=$("#txt_descri_name").val(); 
							var v_quantity=$("#txt_quantity").val();
							var v_unit=$("#txt_unit").val();
							var unit_price=$("#txt_unit_price").val();
							var v_discount=$("#txt_discount").val();
							var v_tax=$("#txt_tax").val();
					        var v_grand_total=$("#txt_grand_total").val();
                            
                            if($.trim(v_description)===""||$.trim(v_quantity)===""||$.trim(v_unit)===""||$.trim(unit_price)==="")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_lpo_master_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/localpo/localpo_controller.php",{action:'update_second_lpo',v_lpo_list_child_id:v_lpo_child_id,v_list_description:v_description,v_list_quantity:v_quantity,v_list_unit:v_unit,list_unit_price:unit_price,v_list_discount:v_discount,v_list_tax:v_tax,v_list_grand_total:v_grand_total,v_total:v_total}
                                        , function(result,status)
                                        {
                                            result = $.trim(result);
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_lpo_master_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                v_btn_lpo_master_edit.ladda( 'stop' );
                                                 //swal("Success", " LPO details updated successfully..", "success");
                                                 load_data_to_grid_lpo_second_list_details(v_ref);
                                                 clear_text();
                                                 $( '#btn_lpo_master_edit' ).hide();
                                            }
                                        });
                                
                             }
                          
                });  
                 $("#btn_reload_lpo_list").click(function () {   
				location.reload();
		          });
				
				function clear_text()
                 {
                   
                    $("#txt_descri_name").val('');
                    $("#txt_quantity").val('');
					$("#txt_unit").val('');
                    $("#txt_unit_price").val('');
					$("#txt_discount").val('');
                    $("#txt_tax").val('');
					$("#txt_grand_total").val('');
                   
                    
                 }
			
				           
                    $("#txt_quantity,#txt_unit_price,#txt_discount,#txt_tax").change(function(){
							v_quantity=$("#txt_quantity").val();
							v_price=$("#txt_unit_price").val();
							v_discount=$("#txt_discount").val();
							v_tax=$("#txt_tax").val(); 
							if(v_quantity=='')
							{
								v_quantity = 0.000;
							}
							else if(v_price=='')
							{
							v_price =0.000;	
							}
							else if(v_discount=='')
							{
							v_discount =0.000;	
							}
							else if(v_tax=='')
							{
							v_tax =0.000;	
							}
							
							if(v_discount==''&& v_tax=='')
							{
								v_grand_total= parseFloat(v_quantity)*parseFloat(v_price);
								if(isNaN(v_grand_total))
                                {
                                     $("#txt_grand_total").val(0);
                                }
                            else
                                {
                                     $("#txt_grand_total").val(v_grand_total.toFixed(3));
                                }
							}
							else{
								v_total= parseFloat(v_quantity)*parseFloat(v_price);
								v_discount_amount= parseFloat(v_total)*parseFloat(v_discount)/100;
								v_total_discount=parseFloat(v_total)-parseFloat(v_discount_amount);
								v_tax_amount=parseFloat(v_total_discount)*parseFloat(v_tax)/100;
								v_grand_total=parseFloat(v_total_discount)+parseFloat(v_tax_amount);
								//alert("Total :"+v_total+"Disc:"+v_discount_amount+"After Disc"+v_after_discount_amount+"tax_amount"+v_tax_amount+"AfterTax"+v_after_tax);
							if(isNaN(v_grand_total))
                                {
                                     $("#txt_grand_total").val(0);
                                }
                            else
                                {
                                     $("#txt_grand_total").val(v_grand_total.toFixed(3));
                                }
							}
							
						
						
						});

                      
				  

					  $('#select_vendor').change(function (e) {
                         
					v_vendor_id=$("#select_vendor option:selected").val();
			
					v_vendor_name=$("#select_vendor option:selected").text();
			
					$.ajax({
						type: "POST",
						url: "../controller/localpo/localpo_controller.php",
						'data': {
						action: 'vendor_list',
						v_vendor_id:v_vendor_id  
				 }
				 }).done(function(data){
					//console.log(data);
					var obj = jQuery.parseJSON(data);
					//console.log(obj);
					
					$("#txt_vat_no").val(obj.data[0].vendor_vat_reg_no);
					$("#txt_lpo_po_box").val(obj.data[0].vendor_po_box); 
					$("#txt_tel_no").val(obj.data[0].vendor_tel_no); 
					$("#txt_fax_no").val(obj.data[0].vendor_fax); 
					
					});
					});
				  

					 v_btn_lpo_update.click(function(){
                        
						v_btn_lpo_update.ladda( 'start' );
						
						v_terms_and_condition=$("#txt_terms_and_condition").val();
						var v_reference_no=$('#txt_lpo_ref_no').val();
						
						v_vendor_id=$("#select_vendor_list_second option:selected").val();
						v_vendor_name=$("#select_vendor_list_second option:selected").text();
						v_vat_no=$("#txt_vat_no").val();
						v_qtn_ref_no=$("#lpo_qtn_ref_no").val();
						v_lpo_po=$("#txt_lpo_po_box").val();
						v_tel_no=$("#txt_tel_no").val();
						v_lpo_date=$("#txt_lpo_date").val();
						v_fax_no=$("#txt_fax_no").val();
						v_subject=$("#txt_subject").val();
						/* v_created_by_id=$("#txt_created_by_id").val();
						v_created_by_name=$("#txt_created_by_name").val();
						v_approved_by_id=$("#txt_created_by_id").val();
						v_approved_by_name=$("#txt_created_by_name").val(); */
						
						if($.trim(v_vendor_name)==""||$.trim(v_vat_no)===""||$.trim(v_qtn_ref_no)===""||$.trim(v_lpo_po)===""||$.trim(v_tel_no)===""||$.trim(v_fax_no)===""||$.trim(v_subject)===""||$.trim(v_lpo_date)==="")
							
							{
								swal("Warning","Please provide all the details ....", "warning");
								v_btn_lpo_update.ladda( 'stop' );
								return false;
							}
                   
								else{
							

						$.post("../controller/localpo/localpo_controller.php",{action:'update_final_lpo',v_reference_no:v_reference_no,v_vendor_id:v_vendor_id,v_vendor_name:v_vendor_name,v_vat_no:v_vat_no,v_qtn_ref_no:v_qtn_ref_no,v_lpo_po:v_lpo_po,v_tel_no:v_tel_no,v_lpo_date:v_lpo_date,v_fax_no:v_fax_no,v_subject:v_subject,v_terms_and_condition:v_terms_and_condition}
                                , function(result,status)
                                {

									console.log(result);
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_lpo_update.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text();
                                   

                                
                                }
                                else 
                                {
                                     v_btn_lpo_update.ladda( 'stop' );
                                     swal("Success", "LPO updated successfully..", "success");
                                      load_data_to_grid_lpo_second_list_details(lpo_ref);
                                     clear_text();
                                }
                                
                            
                        }); 
					}
                    }); 
	
});