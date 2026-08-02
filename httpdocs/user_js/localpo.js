
$(document).ready(function(){
    
    //$(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
  var v_vendor_id,v_vendor_name,item_name,item_qty,item_unit,discount_percent,tax_percent,vat_percent,v_lpo_child_id,total_amount,vendor_name,lpo_ref,v_grand_total,v_total,v_discount_amount,v_total_discount,v_tax_amount,v_total_tax,v_lpo_date,var_vendor_id_val,var_vendor_name,var_vat_no,var_qtn_ref_no,var_po_box,var_lpo_date,var_tele_ph,var_fax_no,var_lpo_subject,var_terms_cond;
					$( '#add_des').show();
                    $( '#btn_lpo_edit').hide();
					var v_btn_lpo_add = $('#add_des').ladda();
					var v_btn_lpo_print = $('#btn_lpo_print').ladda();
					var v_btn_lpo_generate = $('#btn_lpo_generates').ladda();
					var v_btn_lpo_edit = $('#btn_lpo_edit').ladda();
					
					 
                    var v_list_of_lpo_table = $('#list_data').DataTable({});
                     
                    $( '#add_des').show();
                     $( '#btn_lpo_edit').hide();
					 $('#select_vendor').change(function (e) {
                         
					v_vendor_id=$("#select_vendor option:selected").val();
			
					v_vendor_name=$("#select_vendor option:selected").text();
			//console.log(v_user_type_name);
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
	
						 
							 
            //Product item insert details starts
					$("#add_des").click(function(){
						
						//v_btn_lpo_add.ladda( 'start' );

						  var item_name=$("#txt_descri_name").val();
						  item_qty=$("#txt_quantity").val();
						  var item_unit=$("#txt_unit").val();
					   
						  var unit_price=$("#txt_unit_price").val();
						  
						  var discount_percent=$("#txt_discount").val();
						  var tax_percent=$("#txt_tax").val();
						  //var vat_percent=$("#txt_vat").val();
						  total_amount=(parseFloat(item_qty)*parseFloat(unit_price));

						  var vendor_name=$("#select_vendor option:selected").text();
						  var vendor_id_val=$("#select_vendor option:selected").val();
						  var po_box=$("#txt_lpo_po_box").val();
						  var vat_no=$("#txt_vat_no").val();
						  var tele_ph=$("#txt_tel_no").val();
						  var fax_no=$("#txt_fax_no").val();
						  var qtn_ref_no=$("#lpo_qtn_ref_no").val();
						  var lpo_date=$("#lpo_date").val();
						  var lpo_subject=$("#txt_subject").val();
						  var v_prepared_by_id=$("#txt_prepared_by_id").val();
						  var v_prepared_by_name=$("#txt_prepared_by_name").val();
						  var  v_approved_by_id=$("#txt_prepared_by_id").val();
						  var v_approved_by_name=$("#txt_prepared_by_name").val();
						   
						  var lpo_ref_no=$("#txt_lpo_ref_no").val();
						  
							  
						 if(discount_percent==''&& tax_percent=='')
							{
								v_grand_total= parseFloat(item_qty)*parseFloat(unit_price);
								if(isNaN(v_grand_total))
                                {
                                     $("#txt_grand_total").val(v_grand_total.toFixed(3));
                                }
                            else
                                {
                                     $("#txt_grand_total").val(v_grand_total.toFixed(3));
                                }
							}
							else{
								v_total= parseFloat(item_qty)*parseFloat(unit_price);
								v_discount_amount= parseFloat(v_total)*parseFloat(discount_percent)/100;
								v_total_discount=parseFloat(v_total)-parseFloat(v_discount_amount);
								v_tax_amount=parseFloat(v_total_discount)*parseFloat(tax_percent)/100;
								v_grand_total=parseFloat(v_total_discount)+parseFloat(v_tax_amount);
								if(isNaN(v_grand_total))
                                {
                                     $("#txt_grand_total").val(0);
                                }
                                else
                                {
                                     $("#txt_grand_total").val(0);
                                }
							}
						    
						    

							if($.trim(vendor_name)==""||$.trim(lpo_date)===""||$.trim(item_name)===""||$.trim(qtn_ref_no)===""||$.trim(lpo_subject)===""||$.trim(item_qty)===""||$.trim(item_unit)===""||$.trim(unit_price)==="")
							
							{
								swal("Warning","Please provide all the details ....", "warning");
								v_btn_lpo_add.ladda( 'stop' );
								return false;
							}
                   
								else{
							
							$.post("../controller/localpo/localpo_controller.php",{action:'insert_lpo_details',vendor_id_val:vendor_id_val,vendor_name:vendor_name,lpo_ref_no:lpo_ref_no,po_box:po_box,vat_no:vat_no,tele_ph:tele_ph,fax_no:fax_no,qtn_ref_no:qtn_ref_no,lpo_date:lpo_date,lpo_subject:lpo_subject,item_name:item_name,item_qty:item_qty,item_unit:item_unit,unit_price:unit_price,discount_percent:discount_percent,tax_percent:tax_percent,total_amount:total_amount,v_grand_total:v_grand_total,v_prepared_by_id:v_prepared_by_id,v_prepared_by_name:v_prepared_by_name},function(res1)		
								{
								$("#txt_lpo_ref_no").val(res1);
										console.log(res1);
										//alert(res1);
								 lpo_ref=$("#txt_lpo_ref_no").val();
								 $('#localpo_ref_no').val(lpo_ref);
								// alert(lpo_ref);
									if(res1==0)
									{
										swal(
									{
										type: 'error',
										title: 'Oops...',
										text: 'Something went wrong!',
									}
									)
								//	v_btn_lpo_add.ladda( 'stop' );
								
									}
									else
									{
									
									 swal("Success", "Local Purchase Order added successfully..", "success");
									 load_data_to_grid_lpo_details_list(lpo_ref);
									// v_btn_lpo_add.ladda( 'stop' );
									clear_text();}
									});
									}

								});
						 //Product item insert details ends

                         $("#btn_reload_lpo").click(function () {   
				     location.reload();
		             });
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

                      
            //load data to lpo  datatable
				   function load_data_to_grid_lpo_details_list(lpo_ref)
					 {
						 
						v_list_of_lpo_table.destroy();
							 
						 v_list_of_lpo_table = $('#list_data').DataTable( {
							   
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/localpo/localpo_controller.php',
                                 'data': {
                                    action: 'lpo_list_view',
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
                                          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:info">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right">	<a href="#" class="dropdown-item" name="Edit_lpo" style="color:orange"><i class="icon-database-edit2"></i> Edit</a><a href="#" class="dropdown-item" name="Delete_lpo" style="color:red"><i class="icon-book2"></i> DELETE</a></div></div></div>';
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
					 
                    $('#list_data tbody').on('click', 'a', function(){
                       //$('#div_list_product_type').show();
                        var $row = $(this).closest('tr');
                        var list_lpo_data = v_list_of_lpo_table.row($row).data();
                        v_lpo_child_id  = list_lpo_data.lpo_child_id;
						
						  item_name=list_lpo_data.description;
						  item_qty=list_lpo_data.quantity;
						  item_unit=list_lpo_data.unit;
					   
						  unit_price=list_lpo_data.unit_price;
						   discount_percent=list_lpo_data.discount;
						 tax_percent=list_lpo_data.tax;
						 v_grand_total=list_lpo_data.grand_total;
						  //vat_percent=list_lpo_data.vat;
                         
                         if($(this).attr("name")=='Edit_lpo')
                         {
                         
                            edit_lpo_details(v_lpo_child_id);
            			    $( '#add_des').hide();
                            $( '#btn_lpo_edit').show();

            			 }
						 if($(this).attr("name")=="Delete_lpo" ){
								$.ajax({
									type: "POST",
									url: "../controller/localpo/localpo_controller.php",
									data: {
											action: 'delete_lpo',
											v_lpo_child_id_delete : v_lpo_child_id 
										 }
									
										
							 })
							 load_data_to_grid_lpo_details_list(lpo_ref);
							$( '#add_des').show();
                            $( '#btn_lpo_edit').hide();
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
             //edit click starts
                    v_btn_lpo_edit.click(function(){
							
                            v_btn_lpo_edit.ladda( 'start' );
                            var v_description=$("#txt_descri_name").val(); 
							var v_quantity=$("#txt_quantity").val();
							var v_unit=$("#txt_unit").val();
							var unit_price=$("#txt_unit_price").val();
							var v_discount=$("#txt_discount").val();
							var v_tax=$("#txt_tax").val();
					        var v_grand_total=$("#txt_grand_total").val();
                            lpo_ref=$("#txt_lpo_ref_no").val();
                            if($.trim(v_description)===""||$.trim(v_quantity)===""||$.trim(v_unit)===""||$.trim(unit_price)==="")
                            
                            {
                                swal("Warning","Please provide all the details ....", "warning");
                                v_btn_lpo_edit.ladda( 'stop' );
                                return false;
                            }
                           
                            else
                            {         
                                 $.post("../controller/localpo/localpo_controller.php",{action:'update_lpo',v_lpo_child_id:v_lpo_child_id,v_description:v_description,v_quantity:v_quantity,v_unit:v_unit,unit_price:unit_price,v_discount:v_discount,v_tax:v_tax,v_grand_total:v_grand_total,v_total:v_total}
                                        , function(result,status)
                                        {
                                            result = $.trim(result);
                                            if(result.charAt(0)=='U')
                                            {
                                                v_btn_lpo_edit.ladda( 'stop' );
                                                swal("Error", result, "error");
                                                clear_text();
                                            }
                                            else 
                                            {
                                                v_btn_lpo_edit.ladda( 'stop' );
                                                 swal("Success", " LPO details updated successfully..", "success");
                                                 load_data_to_grid_lpo_details_list(lpo_ref);
                                                 clear_text();
                                                 $( '#add_des').show();
                                                $( '#btn_lpo_edit').hide();
                                            }
                                        });
                                
                             }
                          
						});  
				
				//edit click ends here
							v_btn_lpo_generate.click(function(){
                            v_btn_lpo_generate.ladda( 'start' );

							var lpo_ref=$("#txt_lpo_ref_no").val();

							var_vendor_id_val=$("#select_vendor option:selected").val();
							var_vendor_name=$("#select_vendor option:selected").text();
							var_vat_no=$("#txt_vat_no").val();
							var_qtn_ref_no=$("#lpo_qtn_ref_no").val();
							var_po_box=$("#txt_lpo_po_box").val();
							var_lpo_date=$("#lpo_date").val();
							var_tele_ph=$("#txt_tel_no").val();
							var_fax_no=$("#txt_fax_no").val();
							var_lpo_subject=$("#txt_subject").val();
							var_terms_cond=$("#txt_terms_and_condition").val();
							
							if($.trim(var_vendor_name)==""||$.trim(var_vat_no)===""||$.trim(var_qtn_ref_no)===""||$.trim(var_po_box)===""||$.trim(var_lpo_date)===""||$.trim(var_tele_ph)===""||$.trim(var_fax_no)===""||$.trim(var_lpo_subject)==="")
							
							{
								swal("Warning","Please provide all the details ....", "warning");
								v_btn_lpo_generate.ladda( 'stop' );
								return false;
							}
                   
								else{
							

						$.post("../controller/localpo/localpo_controller.php",{action:'update_lpo_generate_status',v_reference:lpo_ref,var_vendor_id_val:var_vendor_id_val,var_vendor_name:var_vendor_name,var_vat_no:var_vat_no,var_qtn_ref_no:var_qtn_ref_no,var_po_box:var_po_box,var_lpo_date:var_lpo_date,var_tele_ph:var_tele_ph,var_fax_no:var_fax_no,var_lpo_subject:var_lpo_subject,var_terms_cond:var_terms_cond}

                                , function(result,status)
                                {
                                  
                                result = $.trim(result);
                                
                                if(result.charAt(0)=='U')
                                {
                                    v_btn_lpo_generate.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                   
                                }
                                else 
                                {
                                     v_btn_lpo_generate.ladda( 'stop' );
                                     swal("Success", "LPO generated successfully", "success");
                                     
                                    load_data_to_grid_lpo_details_list(lpo_ref);
                                    
                                }
                                
  
                        });
								}
      
                      });  
                    
                    //function clear text
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
                  

});