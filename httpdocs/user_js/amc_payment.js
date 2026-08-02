$(document).ready(function(){
   var v_amc_list_table = $('#tbl_amc_list').DataTable({});  
   var v_amc_payment_completed_table = $('#tbl_amc_completed_payment').DataTable({}); 
   var v_amc_payment_list_completed = $('#tbl_amc_payment_completed_list').DataTable( {});
    load_data_to_grid_amc_list();
//load data to amc_list table
var v_btn_amc_update_payment= $('#btn_update_payment').ladda();
    var v_btn_amc_assign_assets= $('#btn_assign_assets').ladda();
    
	v_btn_amc_update_payment.hide();
	var v_btn_amc_new_payment= $('#btn_new_payment').ladda();
	v_btn_amc_new_payment.hide();
                    $("#btn_amc_renewal_search").click(function(){
                        var search_date=$("#txt_end_date").val();
                        var search_date = new Date(search_date);
                        var dd = String(search_date.getDate()).padStart(2, '0');
                        var mm = String(search_date.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = search_date.getFullYear();
                         search_date = yyyy + '-' + mm + '-' + dd;
                          load_data_to_grid_amc_list_search(search_date);
                      })
                      
                 load_data_to_grid_amc_completed_list();   
                      
                 function load_data_to_grid_amc_list()
                 {
                     
                    v_amc_list_table.destroy();
                         
                     v_amc_list_table = $('#tbl_amc_payment').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_payment/amc_payment_controller.php',
                                 'data': {
                                    action: 'amc_payment_list'
                                    
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
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                             struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Customer Name</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+(rows['customer_name'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Mobile No</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+(rows['customer_contact_no'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Email</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_email_id']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b> Contact Person </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_contact_person_name']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b> Contact Person Number</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_contact_person_no']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b>AMC Start & End Date</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['amc_start_date']+'  -  '+rows['amc_end_date_format']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                               
                                 { "data": "amc_amount",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '') },
                                 { "data": "amc_vat_amt",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                               { "data": "amc_ref_no",className: "text-right",
                                 
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            
                                         return $.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount);
                                     }     
                                     
                                 },
                                 { "data": "total_paid_amt" ,className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                                 { "data": "paid_vat_amt",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                                 { "data": "amc_ref_no",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, ''),
                                    render: function ( data, type, rows, meta ) {
                                            str_paid_amount=parseFloat(rows['total_paid_amt'])+parseFloat(rows['paid_vat_amt']);
                                            
                                         return $.fn.dataTable.render.number(',', '.', 3, '').display(str_paid_amount);
                                     } 
                                     
                                 },
                                 { "data": "amc_ref_no",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, ''),
                                 
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat((rows['amc_vat_amt']))+parseFloat(rows['amc_amount'])-(parseFloat(rows['total_paid_amt'])+parseFloat(rows['paid_vat_amt']));
                                            
                                         return $.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount);
                                     } 
                                     
                                 },
                               
                                 { "data": "amc_id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                         
                                           return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="a_amc_payments" data-toggle="modal" data-target="#modal_backdrop_amc_payments1"><i class="icon-calculator4"></i> Payment</a></div></div></div>';
                                          
                                        
                                      }   
                                 }
                                 
                                 
                                 
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7,8] }, 
            					
            				],
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              drawCallback: function (settings) {
                                //   var api = this.api();
                                //     $('.popoverButton').popover({
                                //             "html": true,
                                //             trigger: 'manual',
                                //             placement: 'left',
                                //             "content": function () {
                                //                 return "<div>Popover content</div>";
                                //             }
                                //     })
                            }
                            
                     });  
                
                 }
                  function load_data_to_grid_amc_completed_list()
                 {
                     
                    v_amc_payment_completed_table.destroy();
                         
                     v_amc_payment_completed_table = $('#tbl_amc_completed_payment').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_payment/amc_payment_controller.php',
                                 'data': {
                                    action: 'amc_payment_completed_list'
                                    
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
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                             struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Customer Name</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+(rows['customer_name'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Mobile No</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+(rows['customer_contact_no'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Email</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_email_id']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b> Contact Person </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_contact_person_name']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b> Contact Person Number</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['customer_contact_person_no']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-12" ><b>AMC Start & End Date</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['amc_start_date']+'  -  '+rows['amc_end_date_format']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "customer_name"},
                                 { "data": "customer_contact_no"},
                               
                                 { "data": "amc_amount",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '') },
                                 { "data": "amc_vat_amt",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                              
                                 { "data": "paid_amount" ,className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                                 
                               
                               
                                 { "data": "amc_id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                         
                                           return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="a_amc_payments" data-toggle="modal" data-target="#modal_amc_payments_completed"><i class="icon-calculator4"></i> Payment</a></div></div></div>';
                                          
                                        
                                      }   
                                 }
                                 
                                 
                                 
                                 
                       
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7,8] }, 
            					
            				],
                            
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              drawCallback: function (settings) {
                                //   var api = this.api();
                                //     $('.popoverButton').popover({
                                //             "html": true,
                                //             trigger: 'manual',
                                //             placement: 'left',
                                //             "content": function () {
                                //                 return "<div>Popover content</div>";
                                //             }
                                //     })
                            }
                            
                     });  
                
                 }
                 
                 $('#tbl_amc_completed_payment tbody').on('click', 'a', function(e){
                     var $row = $(this).closest('tr');
                        var data = v_amc_payment_completed_table.row($row).data();
                        v_amc_id  = data.amc_id;
                         v_amc_ref_no  = data.amc_ref_no;
                         v_amc_id  = data.amc_id;
                        v_cust_id  = data.customer_id;
						v_cust_code  = data.customer_code;
						v_cust_name  = data.customer_name;
                        v_amc_ref_no  = data.amc_ref_no;
                        v_amc_payable_vat_perct  = data.amc_vat_perct;
						v_amc_payable_vat_amt  = data.amc_vat_amt;
						v_amc_payable_amt  = data.amc_amount;
                        v_amc_end_date = data.amc_end_date;
                        v_amc_start_date = data.amc_start_date;
                        if($(this).attr("name")=='a_amc_payments')
                         {
                              $("#amc_no_view_head_amc_payment_completed").html("AMC Payments - Customer - ["+data.customer_name+"] AMC - ["+v_amc_ref_no+"] ");
                     load_data_to_grid_amc_payment_list_completed(v_amc_id); 
                         }
                 });
                 
                 
                  $('#tbl_amc_completed_payment tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_amc_payment_completed_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_entries_completed(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                 function format_entries_completed(d)
           {

            return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
             '<tr style="background: #989898;color:#ffffff;">'+
                
                
                '<td ><div align="center">Description </div></td>'+
                '<td ><div align="center">VAT % </div></td>'+
                '<td ><div align="center">VAT Amount </div></td>'+
                '<td ><div align="center">Invoice Ref No</div></td>'+
            
              '</tr>'+
              '<tr>'+
                
                '<td><div align="center">'+d.description+'</div></td>'+
                '<td><div align="center">'+parseFloat(d.paid_vat_perct).toFixed(2)+' </div></td>'+
                '<td><div align="center">'+parseFloat(d.paid_vat_amt).toFixed(3)+'</div></td>'+
                '<td><div align="center">'+d.invoice_ref_no+'</div></td>'+
                
              '</tr>'+
              
              
            '</table>' ;
                        


        } 
                
                
function clear_text()
                 {

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
                    
                    $("#txt_amc_cust_payment_date").val('');
						//$("#txt_amc_cust_payment_amount").val('');
						//$("#txt_amc_cust_payment_vat_per").val('');
						$("#txt_amc_cust_payment_vat_amount").val('');
						$("#txt_amc_cust_payment_total_amount").val('');
						$("#txt_amc_cust_invoice_ref_no").val('');
						$("#txt_amc_cust_payment_description").val('');
						 $('#check_closing_entry').prop('checked',false);
						 
						  v_check_closing_entry='No';
						 $("#txt_amc_cust_payment_description").val('');
						 $('#txt_amc_cust_payment_description').attr('readonly', false);
						 $('#txt_amc_cust_payment_description').removeClass('input-disabled');
						 
                    $("#select_type").val(null).trigger("change");
                     $("#txt_is_warrantee").val(null).trigger("change");
                    $("#select_location_for_customer_location_assets").val(null).trigger("change");
                    $("#select_building_for_customer_location").val(null).trigger("change");
                    $("#txt_type_des").val('');
                   
                 }
     
         
                
                 
                  $('#tbl_amc_payment tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                     
                  })
            
               
                $('#tbl_amc_payment tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data = v_amc_list_table.row($row).data();
                        v_amc_id  = data.amc_id;
                        v_amc_ref_no  = data.amc_ref_no;
                         v_amc_id  = data.amc_id;
                        v_cust_id  = data.customer_id;
						v_cust_code  = data.customer_code;
						v_cust_name  = data.customer_name;
                        v_amc_ref_no  = data.amc_ref_no;
                        v_amc_payable_vat_perct  = data.amc_vat_perct;
						v_amc_payable_vat_amt  = data.amc_vat_amt;
						v_amc_payable_amt  = data.amc_amount;
                        v_amc_end_date = data.amc_end_date;
                        v_amc_start_date = data.amc_start_date;
                        
                        
                        $("#txt_amc_ref_no").val(v_amc_ref_no);
                         if($(this).attr("name")=='amc_change_status')
                         {
                           $("#txt_amc_ref_no").val(v_amc_ref_no);
                             $("#amc_no_view_head").html("Change Status [AMC No : <b>"+v_amc_ref_no+"</b>]");
                             
                         }
                         
                           if($(this).attr("name")=='a_amc_payments')
                         {
                            
                              $("#txt_amc_cust_payment_vat_per").val(v_amc_payable_vat_perct);
                           $("#txt_amc_id_amc_payments").val(v_amc_id);
                           $("#txt_amc_ref_no_payments").val(v_amc_ref_no);
                           $("#txt_cust_id_amc_payments").val(data.customer_id);
                           $("#txt_cust_ref_no_payments").val(data.customer_code);
                             $("#amc_no_view_head_amc_payments").html("AMC Payments - Customer - ["+data.customer_name+"] AMC - ["+v_amc_ref_no+"] ");
                            load_data_to_grid_amc_payment_list(v_amc_id);
                           
                         }
                         
                       
                });
                 
               
	
				  
  //AMC PAYMENTS
     
     var v_btn_amc_submit_payment= $('#btn_submit_payment').ladda();
    var v_amc_payment_list_table = $('#tbl_amc_payment_list').DataTable({"destroy": true}); 
    
   
   function load_data_to_grid_amc_payment_list(amc_ids)
    {
		
       var str_balance=0;
        v_amc_payment_list_table.destroy();
            
        v_amc_payment_list_table = $('#tbl_amc_payment_list').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_payment_controller.php',
                    'data': {
                       action: 'amc_list_payments',amc_id:amc_ids,v_cust_id:v_cust_id,v_amc_ref_no:v_amc_ref_no
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": false,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
              
           
               "columns": [
                    {
                        "className":  'details-control',
                        "orderable":  false,
                        "data":        null,
                        "defaultContent": '',
                        
                    },
                    
					//description,Balance,`amc_payments_ids`,customer_code, amc_code,date_of_payment,invoice_ref_no, payable_vat_perct, `total_payable_amt`, `total_paid_amt`,
                    { "data": null},
					{ "data": "invoice_ref_no","visible":false },
					{ "data": "paid_vat_amt","visible":false },
					{ "data": "total_paid_amt","visible":false },
					{ "data": "company_closing_entry","visible":false },
					//,style="width:20px;"
                    { "data": "date_of_payment"},
                    { "data": "total_payable_amt",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                    { "data": "paid_amount",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
					//{ "data": "Balance",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                    { "data": "amc_payments_ids",className: "text-centre",render: $.fn.dataTable.render.number(',', '.', 3, ''),
                     render: function ( data, type, rows, meta ) {
                                    
                        str_balance = (parseFloat(str_balance)+parseFloat(rows['total_payable_amt']))-parseFloat(rows['paid_amount']);
                        return $.fn.dataTable.render.number(',', '.', 3, '').display(str_balance);
                        } 
                        
                    }, 
                    //{ "data": "description"},
                    
                   { "data": "total_payable_amt",className: "text-center",
                                  render: function ( data, type, rows ) {
									  
            						
            								if(rows['total_payable_amt']!=0)
            								{
												return str_actions='';
											}
            								 
											else
											{
												 return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"  name="amc_update_payments" ><i class="icon-pencil5"></i> Update Payments</a><a href="#" class="dropdown-item" name="amc_cancel_payments"><i class="icon-quill4"></i> Cancel Payments</a></div></div></div>';
											}
            								
											
            
            							 }
                    }
          
                ],
               // pageLength: 20,
                searching: true,
                responsive: true,
                
                "ColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                   { "width": "5%", "targets": 0 } ,
                   { "width": "5%", "targets": 1 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  $("#txt_amc_cust_payment_amount").val( parseFloat((str_balance)/3).toFixed(3));
                  
				  $("#txt_amc_payable_amt").val(parseFloat(str_balance)/3);
				
				     var v_vat_percentage=parseFloat(v_amc_payable_vat_perct)/100;
    				 var v_txt_total_amount=parseFloat(str_balance/3)/(1+v_vat_percentage);
    				 var v_txt_vat_amount=parseFloat(v_txt_total_amount)*(parseFloat(v_amc_payable_vat_perct)/100);
    				v_txt_vat_amount=parseFloat(v_txt_vat_amount).toFixed(3);
    				v_txt_total_amount=parseFloat(v_txt_total_amount).toFixed(3);
    				 $('#txt_amc_cust_payment_vat_amount').val(v_txt_vat_amount);
    				 $('#txt_amc_cust_payment_total_amount').val(v_txt_total_amount);
				  
				  if(str_balance/3==0)
				  {
				    $("#txt_amc_cust_payment_amount").attr("disabled", "disabled") ; 
				  }
				  else
				  {
				      $("#txt_amc_cust_payment_amount").removeAttr('disabled') ; 
				  }
				  
				  
                  $("#txt_amc_cust_payment_vat_amount").val();
   
   
                 },
                 "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages Income
                    total1 = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            
                            return intVal(a) + intVal(b);
                        }, 0 );
                   
                    // Total over this page Income
                    pageTotal1 = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                    // Update footer
                   
                    $( api.column( 7 ).footer() ).html($.fn.dataTable.render.number(',', '.', 3, '').display( pageTotal1 ) );
                     
                           /*    if((parseFloat(str_balance)/2)==0)
                                 {
                                   $("#txt_amc_cust_payment_amount").attr("disabled", "disabled"); 
                                 }
                                 else
                                 {
                                   $("#txt_amc_cust_payment_amount").removeAttr('disabled');  
                                 } */
                     
              }, 
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
                  
               },
               "createdRow": function (row, data, dataIndex, cells) {
					
						if(data.company_closing_entry=='Yes')
						{
							//console.log('in');
							$(row).css("background-color", "#FDB6A7");
							
						}
					  
					}
               
        });  
   
    }
     function load_data_to_grid_amc_payment_list_completed(amc_ids)
    {
		
       var str_balance=0;
        v_amc_payment_list_completed.destroy();
            
        v_amc_payment_list_completed = $('#tbl_amc_payment_completed_list').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_payment_controller.php',
                    'data': {
                       action: 'amc_list_payments',amc_id:amc_ids,v_cust_id:v_cust_id,v_amc_ref_no:v_amc_ref_no
                       
                    }
                },
                "language": {
                    "zeroRecords": "No records available",
                    "infoEmpty": "No records available",
                 },
               //"order": [[ 0, "desc" ]],
              
               "Paginate": false,
               "bLengthChange": false,
               "bFilter": false,
               "bInfo": false,
               "autoWidth": false,
              
           
               "columns": [
                    {
                        "className":  'details-control',
                        "orderable":  false,
                        "data":        null,
                        "defaultContent": '',
                        
                    },
                    
					//description,Balance,`amc_payments_ids`,customer_code, amc_code,date_of_payment,invoice_ref_no, payable_vat_perct, `total_payable_amt`, `total_paid_amt`,
                    { "data": null},
					{ "data": "invoice_ref_no","visible":false },
					{ "data": "paid_vat_amt","visible":false },
					{ "data": "total_paid_amt","visible":false },
					{ "data": "company_closing_entry","visible":false },
					//,style="width:20px;"
                    { "data": "date_of_payment"},
                    { "data": "total_payable_amt",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                    { "data": "paid_amount",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
					//{ "data": "Balance",className: "text-right",render: $.fn.dataTable.render.number(',', '.', 3, '')},
                    { "data": "amc_payments_ids",className: "text-centre",render: $.fn.dataTable.render.number(',', '.', 3, ''),
                     render: function ( data, type, rows, meta ) {
                                    
                        str_balance = (parseFloat(str_balance)+parseFloat(rows['total_payable_amt']))-parseFloat(rows['paid_amount']);
                        return $.fn.dataTable.render.number(',', '.', 3, '').display(str_balance);
                        } 
                        
                    }, 
                    //{ "data": "description"},
                    
                   { "data": "total_payable_amt",className: "text-center",
                                  render: function ( data, type, rows ) {
									  
            						
            								if(rows['total_payable_amt']!=0)
            								{
												return str_actions='';
											}
            								 
											else
											{
												 return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"  name="amc_update_payments" ><i class="icon-pencil5"></i> Update Payments</a><a href="#" class="dropdown-item" name="amc_cancel_payments"><i class="icon-quill4"></i> Cancel Payments</a></div></div></div>';
											}
            								
											
            
            							 }
                    }
          
                ],
               // pageLength: 20,
                searching: true,
                responsive: true,
                
                "ColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                   { "width": "5%", "targets": 0 } ,
                   { "width": "5%", "targets": 1 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  $("#txt_amc_cust_payment_amount").val( parseFloat((str_balance)/3).toFixed(3));
                  
				  $("#txt_amc_payable_amt").val(parseFloat(str_balance)/3);
				
				     var v_vat_percentage=parseFloat(v_amc_payable_vat_perct)/100;
    				 var v_txt_total_amount=parseFloat(str_balance/3)/(1+v_vat_percentage);
    				 var v_txt_vat_amount=parseFloat(v_txt_total_amount)*(parseFloat(v_amc_payable_vat_perct)/100);
    				v_txt_vat_amount=parseFloat(v_txt_vat_amount).toFixed(3);
    				v_txt_total_amount=parseFloat(v_txt_total_amount).toFixed(3);
    				 $('#txt_amc_cust_payment_vat_amount').val(v_txt_vat_amount);
    				 $('#txt_amc_cust_payment_total_amount').val(v_txt_total_amount);
				  
				  if(str_balance/3==0)
				  {
				    $("#txt_amc_cust_payment_amount").attr("disabled", "disabled") ; 
				  }
				  else
				  {
				      $("#txt_amc_cust_payment_amount").removeAttr('disabled') ; 
				  }
				  
				  
                  $("#txt_amc_cust_payment_vat_amount").val();
   
   
                 },
                 "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages Income
                    total1 = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            
                            return intVal(a) + intVal(b);
                        }, 0 );
                   
                    // Total over this page Income
                    pageTotal1 = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                    // Update footer
                   
                    $( api.column( 7 ).footer() ).html($.fn.dataTable.render.number(',', '.', 3, '').display( pageTotal1 ) );
                     
                           /*    if((parseFloat(str_balance)/2)==0)
                                 {
                                   $("#txt_amc_cust_payment_amount").attr("disabled", "disabled"); 
                                 }
                                 else
                                 {
                                   $("#txt_amc_cust_payment_amount").removeAttr('disabled');  
                                 } */
                     
              }, 
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
                  
               },
               "createdRow": function (row, data, dataIndex, cells) {
					
						if(data.company_closing_entry=='Yes')
						{
							//console.log('in');
							$(row).css("background-color", "#FDB6A7");
							
						}
					  
					}
               
        });  
   
    }
    
    

    $('#tbl_amc_payment_list tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = v_amc_payment_list_table.row( tr );
       
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format_entries(row.data()) ).show();
            tr.addClass('shown');
           
             
        }
    } );

     function format_entries(d)
           {

            return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
             '<tr style="background: #989898;color:#ffffff;">'+
                
                
                '<td ><div align="center">Description </div></td>'+
                '<td ><div align="center">VAT % </div></td>'+
                '<td ><div align="center">VAT Amount </div></td>'+
                '<td ><div align="center">Invoice Ref No</div></td>'+
            
              '</tr>'+
              '<tr>'+
                
                '<td><div align="center">'+d.description+'</div></td>'+
                '<td><div align="center">'+parseFloat(d.paid_vat_perct).toFixed(2)+' </div></td>'+
                '<td><div align="center">'+parseFloat(d.paid_vat_amt).toFixed(3)+'</div></td>'+
                '<td><div align="center">'+d.invoice_ref_no+'</div></td>'+
                
              '</tr>'+
              
              
            '</table>' ;
                        


    } 
       $('#tbl_amc_payment_list tbody').on('click', 'a', function () {
        
		var $row = $(this).closest('tr');
		var data = v_amc_payment_list_table.row($row).data();
        
		v_amc_payments_ids  = data.amc_payments_ids;
		v_amc_paid_amount_update = data.paid_amount;
		
		v_amc_invoice_ref_no_update = data.invoice_ref_no;
		v_amc_paid_vat_amt_update = data.paid_vat_amt;
		v_amc_total_paid_amt_update = data.total_paid_amt;
		v_amc_company_closing_entry_update = data.company_closing_entry;
		v_amc_description_update = data.description;
		v_amc_date_of_payment_update  = data.date_of_payment;
		
		
		   //amc_update_payments
                       if($(this).attr("name")=='amc_update_payments')
                         {
							 v_btn_amc_update_payment.show();
							 v_btn_amc_submit_payment.hide();
							 v_btn_amc_new_payment.show();
						 flag_payment=0;
						    $("#txt_amc_cust_payment_amount").removeAttr('disabled');
							 var text_balance_hidden=$('#txt_amc_payable_amt').val();//11-3
							 var amc_update_with_balance=parseFloat(v_amc_paid_amount_update)+parseFloat(text_balance_hidden);//11-3
							 //alert(amc_update_with_balance);//11-3 
							 $('#txt_amc_payable_amt_for_update').val(amc_update_with_balance);//11-3 hidden
							 $('#txt_amc_cust_payment_amount').val(amc_update_with_balance);//11-3
							 
							 //$('#txt_amc_cust_payment_amount').val(v_amc_paid_amount_update);
							 	$('#txt_amc_cust_payment_vat_amount').val(v_amc_paid_vat_amt_update);
								$('#txt_amc_cust_payment_total_amount').val(v_amc_total_paid_amt_update);
								$('#txt_amc_cust_invoice_ref_no').val(v_amc_invoice_ref_no_update);
								$('#txt_amc_cust_payment_description').val(v_amc_description_update);
							//	$('#txt_amc_cust_payment_date').val(v_amc_date_of_payment_update);
							
							v_amc_date_of_payment_update = v_amc_date_of_payment_update.split("-").reverse();
                                var tmp = v_amc_date_of_payment_update[2];
                                v_amc_date_of_payment_update[0] = v_amc_date_of_payment_update[0];
                                v_amc_date_of_payment_update[1] = v_amc_date_of_payment_update[1];
                                v_amc_date_of_payment_update[2] = tmp;
                                v_amc_date_of_payment_update = v_amc_date_of_payment_update.join("-");
								//alert(' with temp '+v_amc_date_of_payment_update);
								$("#txt_amc_cust_payment_date").val(v_amc_date_of_payment_update);
								//$("#txt_amc_cust_payment_date").val('2015-02-21');
								
								
								if(v_amc_company_closing_entry_update=='Yes')
									   {
										   $('#check_closing_entry').prop('checked',true);
										   $('#txt_amc_cust_payment_description').attr('readonly', true);
									       $('#txt_amc_cust_payment_description').addClass('input-disabled');

									   }
									   else
									   {
										   $('#check_closing_entry').prop('checked',false);
										   v_check_closing_entry='No';
										   $('#txt_amc_cust_payment_description').attr('readonly', false);
								           $('#txt_amc_cust_payment_description').removeClass('input-disabled');

									   }	


							
								
                        }
		//amc_cancel_payments
					 if($(this).attr("name")=='amc_cancel_payments')
                         {
							 //alert(v_amc_payments_ids);
                             $.ajax({
                    		type: "POST",
                    		url: "../controller/amc/amc_payment_controller.php",
                    		data: { v_amc_payments_ids : v_amc_payments_ids,action:"delete_amc_customer_payments" } 
                    		 }).done(function(data){
								 
								 load_data_to_grid_amc_payment_list(v_amc_id);
                    			//$("#div_cust_location").html(data);
								//$("#select_location_for_customer_location_assets").select2();
							});
						
                        }
		
    } ); 
    //AMC PAYMENTS CLOSE
         
       	//change function of payment amount
					$("#txt_amc_cust_payment_amount").blur(function(){
							
                        
                          //flag_payment
						if (flag_payment==0)
						{
							var v_txt_payment_amount_hidden=$('#txt_amc_payable_amt_for_update').val();
						}
						if (typeof flag_payment=="undefined")
						{
							var v_txt_payment_amount_hidden=$('#txt_amc_payable_amt').val();
						}
						//alert(v_txt_payment_amount_hidden);
						
                          var v_txt_payment_amount=$('#txt_amc_cust_payment_amount').val();
						  //var v_txt_payment_amount_hidden=$('#txt_amc_payable_amt').val();
						  if(parseFloat(v_txt_payment_amount) <= parseFloat(v_txt_payment_amount_hidden))
						  {
								
								 var v_vat_percentage=parseFloat(v_amc_payable_vat_perct)/100;
								 var v_txt_total_amount=parseFloat(v_txt_payment_amount)/(1+v_vat_percentage);
								 var v_txt_vat_amount=parseFloat(v_txt_total_amount)*(parseFloat(v_amc_payable_vat_perct)/100);
								v_txt_vat_amount=parseFloat(v_txt_vat_amount).toFixed(3);
								v_txt_total_amount=parseFloat(v_txt_total_amount).toFixed(3);
								 $('#txt_amc_cust_payment_vat_amount').val(v_txt_vat_amount);
								 $('#txt_amc_cust_payment_total_amount').val(v_txt_total_amount);
								 
						  }
						  else
						  { 
								swal("Warning","Please provide lower value ....", "warning");
								$('#txt_amc_cust_payment_amount').val(v_txt_payment_amount_hidden);
						  }
                      });
					  //check_closing_entry
					  $("#check_closing_entry").click(function(){
						  
							if($(this).prop("checked") === true)
								{
									v_check_closing_entry='Yes';
									$("#txt_amc_cust_payment_description").val('Closing Entry');
									$('#txt_amc_cust_payment_description').attr('readonly', true);
									$('#txt_amc_cust_payment_description').addClass('input-disabled');
								}
						
							else 
								{
								 v_check_closing_entry='No';
								 $("#txt_amc_cust_payment_description").val('');
								 $('#txt_amc_cust_payment_description').attr('readonly', false);
								 $('#txt_amc_cust_payment_description').removeClass('input-disabled');
								}
								
							});

					
					  //amc_add_customer_payments -Payment details
                    v_btn_amc_submit_payment.click(function(){
                        
                                v_btn_amc_submit_payment.ladda( 'start' );
							    var v_amc_cust_id_payments=$("#txt_cust_id_amc_payments").val();
								var v_amc_cust_ref_no_payments=$("#txt_cust_ref_no_payments").val();
							
								var v_amc_cust_payment_date=$("#txt_amc_cust_payment_date").val();
								var v_amc_cust_paid_amount=$("#txt_amc_cust_payment_amount").val();
							
								var v_amc_cust_paid_vat_per=$("#txt_amc_cust_payment_vat_per").val();
								var v_amc_cust_paid_vat_amount=$("#txt_amc_cust_payment_vat_amount").val();
								var v_amc_cust_paid_total_amount=$("#txt_amc_cust_payment_total_amount").val();
								var v_amc_cust_invoice_ref_no=$("#txt_amc_cust_invoice_ref_no").val();
								var v_amc_cust_payment_description=$("#txt_amc_cust_payment_description").val();
									
									if(v_amc_cust_invoice_ref_no=="")
									   {
										   v_amc_cust_invoice_ref_no=0;
									   }
									   else
									   {
										   v_amc_cust_invoice_ref_no=$("#txt_amc_cust_invoice_ref_no").val();
									   }
									   
									 if(v_amc_cust_payment_description=="")
									   {
										   v_amc_cust_payment_description="NA";
									   }
									   else
									   {
										   v_amc_cust_payment_description=$("#txt_amc_cust_payment_description").val();
									   }
									   
									  if(typeof v_check_closing_entry=="undefined")
									   {
										   v_check_closing_entry='No';
									   }
									   
								if($.trim(v_amc_cust_payment_date)===""||$.trim(v_amc_cust_paid_amount)===""||$.trim(v_amc_cust_paid_vat_per)===""||$.trim(v_amc_cust_paid_vat_amount)===""||$.trim(v_amc_cust_paid_total_amount)==="")								
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_amc_submit_payment.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                { 
									$.post("../controller/amc/amc_payment_controller.php",{action:'add_amc_customer_payments',v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_cust_id_payments:v_amc_cust_id_payments,v_amc_cust_ref_no_payments:v_amc_cust_ref_no_payments,v_amc_cust_payment_date:v_amc_cust_payment_date,v_amc_cust_paid_amount:v_amc_cust_paid_amount,v_amc_cust_paid_vat_per:v_amc_cust_paid_vat_per,v_amc_cust_paid_vat_amount:v_amc_cust_paid_vat_amount,v_amc_cust_paid_total_amount:v_amc_cust_paid_total_amount,v_amc_cust_invoice_ref_no:v_amc_cust_invoice_ref_no,v_amc_cust_payment_description:v_amc_cust_payment_description,v_check_closing_entry:v_check_closing_entry}
                                            , function(result,status)
                                            {
													   if($.trim(result)!='')
														   {
															   v_btn_amc_submit_payment.ladda( 'stop' );
																swal("Success", "New Payment added successfully..", "success");
															   load_data_to_grid_amc_payment_list(v_amc_id);
															    clear_text();
														   }
													   else 
														   {
															   v_btn_amc_submit_payment.ladda( 'stop' );
																swal("Error", "Sorry! Could not added the Payment..", "error");
																return false;
																
														   }
                                                
                                    });
  
                                }
									
										 	
                               
                        });//close of amc_add_customer_payments -Payment details 
	
					 //amc_update_customer_payments -Payment details
                    v_btn_amc_update_payment.click(function(){
                        
                                v_btn_amc_update_payment.ladda( 'start' );
								var v_upd_cust_payment_date=$("#txt_amc_cust_payment_date").val();
								var v_upd_cust_paid_amount=$("#txt_amc_cust_payment_amount").val();
								var v_upd_cust_paid_vat_per=$("#txt_amc_cust_payment_vat_per").val();
								var v_upd_cust_paid_vat_amount=$("#txt_amc_cust_payment_vat_amount").val();
								var v_upd_cust_paid_total_amount=$("#txt_amc_cust_payment_total_amount").val();
								var v_upd_cust_invoice_ref_no=$("#txt_amc_cust_invoice_ref_no").val();
								var v_upd_cust_payment_description=$("#txt_amc_cust_payment_description").val();
								if(v_upd_cust_invoice_ref_no=="")
									   {
										   v_upd_cust_invoice_ref_no=0;
									   }
									   else
									   {
										   v_upd_cust_invoice_ref_no=$("#txt_amc_cust_invoice_ref_no").val();
									   }
									   
									 if(v_upd_cust_payment_description=="")
									   {
										   v_upd_cust_payment_description="NA";
									   }
									   else
									   {
										   v_upd_cust_payment_description=$("#txt_amc_cust_payment_description").val();
									   }
							
								if($.trim(v_upd_cust_payment_date)===""||$.trim(v_upd_cust_paid_amount)===""||$.trim(v_upd_cust_paid_vat_per)===""||$.trim(v_upd_cust_paid_vat_amount)===""||$.trim(v_upd_cust_paid_total_amount)==="")								
                                {
                                    swal("Warning","Please provide all the details ....", "warning");
                                    v_btn_amc_update_payment.ladda( 'stop' );
                                    return false;
                                }
                               
                                else
                                { 
									$.post("../controller/amc/amc_payment_controller.php",{action:'update_amc_customer_payments',v_amc_payments_ids:v_amc_payments_ids,v_amc_cust_payment_date:v_upd_cust_payment_date,v_amc_cust_paid_amount:v_upd_cust_paid_amount,v_amc_cust_paid_vat_per:v_upd_cust_paid_vat_per,v_amc_cust_paid_vat_amount:v_upd_cust_paid_vat_amount,v_amc_cust_paid_total_amount:v_upd_cust_paid_total_amount,v_amc_cust_invoice_ref_no:v_upd_cust_invoice_ref_no,v_amc_cust_payment_description:v_upd_cust_payment_description,v_check_closing_entry:v_check_closing_entry}
                                            , function(result,status)
                                            {
								
													    if(status=='success')
														   {
															   v_btn_amc_update_payment.ladda( 'stop' );
																swal("Success", "Payment updated successfully..", "success");
															   load_data_to_grid_amc_payment_list(v_amc_id);
															   v_btn_amc_submit_payment.show();
															   v_btn_amc_update_payment.hide();
															   clear_text();
														   }
													   else 
														   {
															   v_btn_amc_update_payment.ladda( 'stop' );
																swal("Error", "Sorry! Could not update the Payment..", "error");
																return false;
																
														   }
                                                
                                    });
  
                                }
									
										 	
                               
                        });//close of amc_update_customer_payments -Payment details
                        
                        v_btn_amc_new_payment.click(function(){
							//clear_text(); 
							v_btn_amc_update_payment.hide();
							v_btn_amc_submit_payment.show();
							v_btn_amc_new_payment.hide();
							load_data_to_grid_amc_payment_list(v_amc_id);
							
						});
                        
                        
                        $('#btn_close_payment').click(function(){
							clear_text();
							v_btn_amc_update_payment.hide();
							v_btn_amc_submit_payment.show();
							v_btn_amc_new_payment.hide();
							
						});
						$('#btn_close').click(function(){
							clear_text();
							v_btn_amc_update_payment.hide();
							v_btn_amc_submit_payment.show();
							v_btn_amc_new_payment.hide();
							
						});
						
              $("#btn_amc_new").click(function(){
			location.reload();
	           });   
                        

});