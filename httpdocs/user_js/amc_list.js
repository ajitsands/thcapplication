$(document).ready(function(){
    var v_amc_start_date,data_service=[],v_asset_child_ref_no, flag_payment,v_amc_date_of_payment_update,v_amc_description_update,v_amc_invoice_ref_no_update,v_amc_paid_vat_amt_update,v_amc_total_paid_amt_update,v_amc_company_closing_entry_update,v_amc_paid_amount_update,v_amc_payments_ids,v_check_closing_entry,v_amc_payable_vat_amt,v_amc_payable_amt,v_amc_payable_vat_perct,v_amc_ref_no,v_cust_code,v_cust_id,v_cust_name,v_contract_type,v_amc_id,checked_val_edit,v_first_attachment_edit,v_second_attachment_edit,v_third_attachment_edit,result,v_third_attachment_edit,v_second_attachment_edit,v_first_attachment_edit,randomNum,location_id,asset_building_combo,asset_cate_combo,assettype_combo,attachments =[];
var checked_val;
 var v_amc_list_table = $('#tbl_amc_list').DataTable({}); 
$( '#btn_edit_assign_subcontractors').hide();
 var v_amc_service_list_table = $('#tbl_amc_asset_list_display').DataTable({"destroy": true});
 var v_amc_serviceslist_display = $('#tbl_amc_serviceslist_display').DataTable({"destroy": true});
var v_tbl_amc_assigned_subcontractor_list = $('#tbl_amc_assigned_subcontractor_list').DataTable({});  
var v_tbl_amc_assigned_subcontractor_list1 = $('#tbl_amc_assigned_subcontractor_list1').DataTable({});  
var v_tbl_amc_assigned_subcontractor_list1_new =  $('#tbl_amc_assigned_subcontractor_list1_new').DataTable({});  
var v_tbl_two = $('#tbl_two').DataTable({}); 
var v_tbl_for_list_renew_amc = $('#tbl_for_list_renew_amc').DataTable({});    
   $('#btn_edit_assign_subcontractor_renew').hide();
   $( '#btn_edit_assign_subcontractor_renew1').hide();
   $('#btn_assign_subcontractors_renew1').hide();
   $('#btn_exit_assign_subcontractor_renew').hide();
   $('#div_subcontractor_content').hide();
   var v_amc_assign_asset_list_table = $('#tbl_amc_asset_list_display_for_assign').DataTable({
       "bLengthChange": false,
       "bFilter": false,
       "bInfo": false,
       searching: false,
       
       "destroy": true,
        "aoColumnDefs": [
                 //  { "bSortable": false, "aTargets": [1,2,3,4,5] },
                   { "width": "5%", "targets": 0 } ,
                   { "width": "20%", "targets": 1 } ,
                   { "width": "15%", "targets": 2 } ,
                   { "width": "15%", "targets": 3 } ,
                   { "width": "15%", "targets": 4 } ,
                   { "width": "30%", "targets": 5 } ,
				   { "width": "30%", "targets": 6 } 
                   
               ]
   });
     var tbl_amc_assigned_subcontractor_list = $('#tbl_amc_assigned_subcontractor_list').DataTable({
       "bLengthChange": false,
       "bFilter": false,
       "bInfo": false,
       searching: false,
       
       "destroy": true,
	   "aoColumnDefs": [
                 //  { "bSortable": false, "aTargets": [1,2,3,4,5] },
                   { "width": "5%", "targets": 0 } ,
                   { "width": "20%", "targets": 1 } ,
                   { "width": "15%", "targets": 2 } ,
                   { "width": "15%", "targets": 3 } ,
                   { "width": "15%", "targets": 4 } ,
                   { "width": "30%", "targets": 5 } 
                   
               ]
        
   });
   var v_amc_assignasset_serviceslist_display = $('#tbl_amc_serviceslist_display_for_assign').DataTable({"destroy": true});
  
   
   
    var v_btn_add_child = $('#btn_add_child').ladda();
	var v_btn_asset_search = $('#asset_search').ladda();
	var v_btn_assign_asset_search = $('#assign_asset_search').ladda();
    var v_btn_amc_update_payment= $('#btn_update_payment').ladda();
    var v_btn_amc_assign_assets= $('#btn_assign_assets').ladda();
    
	v_btn_amc_update_payment.hide();
	var v_btn_amc_new_payment= $('#btn_new_payment').ladda();
	v_btn_amc_new_payment.hide();
	
	$('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });

    
    
    
 $(".nav-link").click(function () {   
     
     var ids = $(this).attr("id"); 
     if(ids==2)
     {

        load_data_to_grid_amc_list();
       
     }
     
 }); 
 
 $('#tbl_amc_asset_list_display tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');

        }
        else {
            //v_amc_service_list_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_service_list_table.row($row).data();
           
        }
    } );
    $('#tbl_amc_serviceslist_display tbody').on( 'click',  'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
         
        }
        else {
           // v_amc_service_list_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_serviceslist_display.row($row).data();
           
        }
    } );

//load data to amc_list
				var sheet;
                 function load_data_to_grid_amc_list()
                 {
                     
                    v_amc_list_table.destroy();
                         
                     v_amc_list_table = $('#tbl_amc_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'amc_list_view'
                                    
                                 },
								 
								 beforeSend: function () {
									$("#tbl_amc_list").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_amc_list").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_amc_list").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 2, "asc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": true,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": true,
            				
            				columnDefs: [
                                    { type: 'date-eu', targets: [6,7] }
                             ], 
							 
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excelHtml5',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            //columns: [1,12,5,4,13,10,9,11, 6,7]  
                                            columns: [1,4,5,6,7,9,10,11,12,13]
                                        },
										filename: 'List of AMC',
										customize: function(xlsx) {
											 sheet = xlsx.xl.worksheets['sheet1.xml'];
											//Loop over the cells
											$('row c', sheet).each(function() {
											//select the index of the row
											var numero=$(this).parent().index() ;
												var residuo = numero%2;
												if (numero==1){           
													$(this).attr('s','22');//22 - Bold, blue background
												}else if (numero==0){
													// if(residuo ==0  ){//'is t',
													//$(this).attr('s','40');//25 - Normal text, fine black border
													// }else{
													// $(this).attr('s','32');//32 - Bold, gray background, fine black border
													// }
												}
											});  
										},
										action: function (e, dt, button, config) {
											// Show a popup message after the export button is clicked
											//swal('Excel export button clicked!');
											
											$.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
											sheet.childNodes[0].setAttribute('password', 'your_password');
										}
                                    }
                                ],
								
            			
                            "columns": [
                                {
                                    "className":  'details-control',
                                    "orderable":  false, 
                                    "data":        null,
                                    "defaultContent": '',
                                    "width": "5%"
                                    
                                 },
                                 { "data": null,
									"width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
								 },
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                //                  { "data": "amc_ref_no","className":"text-center", "visible":false,
                //                      render: function ( data, type, rows, meta ) {
                //                          //retun_qr_code = '<img src="../httpdocs/qr_lib/qr_code.php?qr='+data+'"/>';
                //                          retun_qr_code = '<img src="../httpdocs/qr_lib/asset_qr/amc_qr/'+data+'.png"/>';
								        //  return retun_qr_code;
                //                      }
                //                  },
                                 { "data": "customer_name","width":"15%"},
                                 { "data": "contract_type_name","width":"15%"},
                               //  { "data": "amc_signed_date","width":"15%"},
                                 { "data": "amc_start_date","width":"20%",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_start_date'];
                                          return str_amc_date;
                                          
                                      }   
                                 },
                               { "data": "amc_end_date","width":"20%",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_end_date'];
                                          return str_amc_date;
                                          
                                      }   
                                 },
                                 { "data": "amc_status",
                                      render: function ( data, type, rows, meta ) {
                                          if(data=='Active')
                                          {
                                          str_active_status='<span class="badge badge-success">'+data+'</span>'
                                          }
                                         
                                          else if(data=='Hold')
                                          {

                                             
                                            struct = '<div class="border-left-1 border-left-primary rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" ><div class="col-lg-12 col-md-12 col-sm-12" >'+rows['hold_description']+'</div></div></div>';
                                            str_active_status="<span class='badge badge-primary'> <a href='#' data-popup='popover' class='popoverButton' title='Hold Description' data-trigger='hover' data-html='true' data-content=' "+ struct +"    ' style='color:white'>";
                                            str_active_status  = str_active_status + data+"</a></span>";
                                       
                                          }
                                          else if(data=='Cancelled')
                                          {
                                            struct = '<div class="border-left-1 border-left-danger rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" ><div class="col-lg-12 col-md-12 col-sm-12" > Cancelled   Date : '+rows['cancelled_on'] + '<br>' +rows['cancelled_description']+'</div></div></div>';
                                            str_active_status="<span class='badge badge-danger'> <a href='#' data-popup='popover' class='popoverButton' title='Cancelled Description' data-trigger='hover' data-html='true' data-content=' "+ struct +"    ' style='color:white'>";
                                            str_active_status  = str_active_status + data+"</a></span>";   
                                          }
                                          else if(data=='Completed')
                                          {
                                            str_active_status='<span class="badge badge-info">'+data+'</span>'   
                                          }
                                     	return str_active_status;
                                          
                                      }   
                                 },
                                  { "data": "amc_vat_perct","visible":false },
								 { "data": "amc_amount","visible":false ,
									"render": function (data, type, row) {
										return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
									}
								 },
								 { "data": "total_amc_amount","visible":false ,
									"render": function (data, type, row) {
										return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
									}
								 },
								 { "data": "amc_vat_amt","visible":false ,
								 "render": function (data, type, row) {
										return parseFloat(data).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
									}
								 },
								 { "data": "amc_ref_no","visible":false },
								 { "data": "amc_description","visible":false },
                                 { "data": "amc_id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                               if(rows['renewal_status']=='YES')
                                               {
                                     	      return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> Edit AMC Details</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_assets" name="assign_assets"><i class="icon-redo2"></i> Assign Assets To AMC </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_amc_child_details" name="assigned_assets"><i class="icon-stack3"></i> View Assets </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_to_subcontractors" name="assign_subcontractor"><i class="icon-users4"></i> Assign to Subcontractors </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_payments1" name="a_amc_payments"><i class="icon-calculator3"></i> Payment Collection</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> AMC QR Code</a></div></div></div>';
                                     	        //return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> View Details</a><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_add_assets" name="add_assets"><i class="icon-barcode2"></i> Add Assets </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_assets" name="assign_assets"><i class="icon-redo2"></i> Assign Assets </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_payments1" name="a_amc_payments"><i class="icon-calculator3"></i> Payment Collection</a><div class="dropdown-divider"></div></div></div></div>';
                                               }
                                               else
                                               {
                                                   return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> Edit AMC Details</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_assets" name="assign_assets"><i class="icon-redo2"></i> Assign Assets To AMC</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_amc_child_details" name="assigned_assets"><i class="icon-stack3"></i> View Assets </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_to_subcontractors" name="assign_subcontractor"><i class="icon-users4"></i> Assign to Subcontractors </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><a href="#" class="dropdown-item" data-toggle="modal" name="amc_renew" data-target="#modal_view_amc_renew"><i class="icon-reload-alt"></i> Renew</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_payments1" name="a_amc_payments"><i class="icon-calculator3"></i> Payment Collection</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a></div></div></div>';
                                               //  return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> View Details</a><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><a href="#" class="dropdown-item" data-toggle="modal" name="amc_renew" data-target="#modal_amc_renew"><i class="icon-reload-alt"></i> Renew</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_add_assets" name="add_assets"><i class="icon-barcode2"></i> Add Assets </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_assign_assets" name="assign_assets"><i class="icon-redo2"></i> Assign Assets </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_payments1" name="a_amc_payments"><i class="icon-calculator3"></i> Payment Collection</a><div class="dropdown-divider"></div></div></div></div>';
                                                
                                               }
                                       
                                      }   
                                 },
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                            
                             "aoColumnDefs": [
            				//	{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7,8,9,10,11] }, 
            					
            					
            				],
                            
                             "initComplete": function( settings, json ) {
                                   //console.log("permissions:"+permissions);
                               
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(1)", nRow).html(iDisplayIndex + 1);
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
                 
                 
           
                setInterval(function() {
                    var index = $.inArray("ListOfAMCExcel", permissions);
                    if (index === -1) {
                        $('.excel-button').css('display', 'none');
                    }
                }, 1000); 

                
                
                
                 
                 
                  $('#tbl_amc_list tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_amc_list_table.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                 
                 
                  function format_amc_details(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Signed Date </div></td>'+
            				'<td ><div align="center">Amount Details </div></td>'+
            				'<td ><div align="center">VAT Details </div></td>'+
						    
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_signed_date+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_amount).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+'</div></td>'+
            				'<td><div align="center">'+parseFloat(d.amc_vat_amt).toLocaleString(undefined, {minimumFractionDigits: 3, maximumFractionDigits: 3})+' ('+d.amc_vat_perct+' )'+'</div></td>'+
								
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Description </div></td>'+ 
            				'<td ><div align="center">RFP? </div></td>'+
            				'<td ><div align="center">Contract Type </div></td>'+
            			
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.amc_description+'</div></td>'+
            				'<td><div align="center">'+d.is_rfp+'</div></td>'+
            			    '<td><div align="center">'+d.contract_type_name+'</div></td>'+
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Attachment 1</div></td>'+
            				'<td ><div align="center">AMC Attachment 2</div></td>'+
            				'<td ><div align="center">AMC Attachment 3</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  //	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment1_desc+'</div></td>'+
            			//	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment2_desc+'</div></td>'+
            			//	'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i>'+d.amc_attachment3_desc+'</div></td>'+
							
            				'<td><div align="center">'+d.amc_attachment1_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment1+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
            				'<td><div align="center">'+d.amc_attachment2_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment2+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
            				'<td><div align="center">'+d.amc_attachment3_desc+'&nbsp;&nbsp;<a href="../httpdocs/images/amc_attachements/'+d.amc_attachment3+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">AMC Renewal Notes</div></td>'+
            				'<td ><div align="center">AMC Renewal Attachment</div></td>'+
            			  '</tr>'+
            			 '<tr>'+
            			  	'<td><div align="center">'+d.amc_renewal_notes+'</div></td>'+
            			
            			    	'<td><div align="center"><a href="../httpdocs/images/amc_renewal_attachments/'+d.amc_renewal_attachment+'" target="_BLANK"><i class="icon-attachment mr-3 icon-2x"></i> </a> </div></td>'+
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		
		
	            }
                 
                  $('#tbl_amc_list tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                      
                  })
             
               
                $('#tbl_amc_list tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data = v_amc_list_table.row($row).data();
                        v_amc_id  = data.amc_id;
                        v_cust_id  = data.customer_id;
						v_cust_code  = data.customer_code;
						v_cust_name  = data.customer_name;
						v_contract_type = data.contract_type_name;
                        v_amc_ref_no  = data.amc_ref_no;
                        v_amc_payable_vat_perct  = data.amc_vat_perct;
						v_amc_payable_vat_amt  = data.amc_vat_amt;
						v_amc_payable_amt  = data.amc_amount;
                        v_amc_end_date = data.amc_end_date;
                        v_amc_start_date = data.amc_start_date;
                       // alert(v_amc_start_date);
                        
                        
                        	$("#txt_amc_start_date").val(v_amc_start_date);
                        		$("#txt_amc_end_date").val(v_amc_end_date);
                        $("#txt_amc_ref_no").val(v_amc_ref_no);
                         if($(this).attr("name")=='amc_change_status')
                         {
                           $("#txt_amc_ref_no").val(v_amc_ref_no);
                             $("#amc_no_view_head").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                             
                         }
                          if($(this).attr("name")=='amc_renew')
                         {
                           // $("#txt_amc_ref_no").val(v_amc_ref_no);
                           // $("#txt_amc_end_date_renew").val(v_amc_end_date);
                           
                               $("#amc_no_view_renew").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name);
							   $('#span_amc_renew_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name);
							   $('#txt_amc_parent_parent_ref_no').val(data.amc_parent_parent_ref_no);
							   $('#txt_amc_signed_date1').val(data.amc_signed_date);
							   $('#txt_amc_start_date').val(v_amc_start_date);
							   $('#txt_amc_end_date').val(v_amc_end_date);
							   $('#txt_amc_amount1').val(v_amc_payable_amt); 
							   $('#txt_amc_vat').val(v_amc_payable_vat_perct);
							   
							   
							   var net_amount = (parseFloat(v_amc_payable_amt) + parseFloat(v_amc_payable_vat_amt)).toFixed(3);
							   $('#txt_amc_vat_amount1').val(net_amount);
							   
							   v_amc_parent_parent_ref_no = data.amc_parent_parent_ref_no;
							   load_data(v_amc_ref_no,v_amc_parent_parent_ref_no);
							   load_amc_related_subcontractor_details(v_amc_ref_no);
                             
                         }
                         if($(this).attr("name")=='assigned_assets')
                         {
                          load_data_to_grid_amc_child_details(v_amc_ref_no);
                           
                             $("#span_amc_ref_no").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                             
                         }
                         
                         if($(this).attr("name")=='Edit_data')
						 {
						     
					        
						     //open tab
						    $("#2").removeClass("active");
                            $("#1").addClass("active");
                            $("#highlighted-tab2").removeClass("show active");
						    $("#highlight-tab1").addClass("show active"); 
						 
							$('#btn_amc_edit').show();
							$('#btn_amc_add').hide();
							$('#btn_amc_new').show();
							$("#txt_amc_number").val(data.amc_ref_no);
							$("#select_customer_for_amc").val(data.customer_id).trigger("change");
							$("#select_contract_type_for_amc").val(data.contract_type_id).trigger("change");
							
							
							var signed_date=data.amc_signed_date;
							   
                                signed_date = signed_date.split("-").reverse();
                                var tmp = signed_date[0];
                                //alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
                                signed_date[0] = signed_date[1];
                                signed_date[1] = signed_date[2];
                                signed_date[2] = tmp;
                                signed_date = signed_date.join("/");

							$("#txt_amc_signed_date").val(signed_date);
							
							
							var start_date=data.amc_start_date;
							   
                                start_date = start_date.split("-").reverse();
                                var tmp = start_date[0];
                                //alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
                                start_date[0] = start_date[1];
                                start_date[1] = start_date[2];
                                start_date[2] = tmp;
                                start_date = start_date.join("/");
                                
                                	var end_date=data.amc_end_date;
							   
                                end_date = end_date.split("-").reverse();
                                var tmp = end_date[0];
                                //alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
                                end_date[0] = end_date[1];
                                end_date[1] = end_date[2];
                                end_date[2] = tmp;
                                end_date = end_date.join("/");
                                
							var start_date_end_date=start_date+'-'+end_date;
							
							$("#txt_amc_start_end_date").val(start_date_end_date);
							
							   checked_val=data.is_rfp;
                                    						 
								if(checked_val==='No'||checked_val==='')	
								{
									$('input[type="checkbox"]').prop('checked', false);
								}
							    else if(checked_val==='Yes')	
								{								
							$('input[type="checkbox"]').prop('checked', true);
								} 
							$("#txt_amc_amount").val(data.amc_amount);
							
							    var startDate_val =  new Date(data.amc_start_date1);
                                var endDate_val =  new Date(data.amc_end_date1); 
                                var monthsDifference = (endDate_val.getFullYear() - startDate_val.getFullYear()) * 12 + (endDate_val.getMonth() - startDate_val.getMonth());
                                if (endDate_val.getDate() < startDate_val.getDate()) {
                                    monthsDifference--;
                                }
                                var TotalAmc = parseFloat(data.amc_amount/12)*monthsDifference;
                                TotalAmc = TotalAmc.toFixed(3);
                                
							$("#txt_total_amc_amount").val(TotalAmc);  
							$("#txt_vat_percentage").val(data.amc_vat_perct);
							$("#txt_amc_vat_amount").val(data.amc_vat_amt);
							$("#txt_amc_description").val(data.amc_description);
							$("#txt_first_attachment_desc").val(data.amc_attachment1_desc);
							$("#txt_sec_attachment_desc").val(data.amc_attachment2_desc);
							$("#txt_third_attachment_desc").val(data.amc_attachment3_desc);
							
							$("#first_image_name").html(data.amc_attachment1);
							
							$("#second_image_name").html(data.amc_attachment2);
							$("#thrid_image_name").html(data.amc_attachment3);
							
							
							$("#img_attachment1_preview").html("<a href='../httpdocs/images/amc_attachements/"+data.amc_attachment1+"' target='_BLANK'  title='Click here to view atatchment' data-toggle='tooltip'><i class='icon-attachment' style='font-size:30px;color:#0d6efd;'></i></a>");
						
						
							$("#img_attachment2_preview").html("<a href='../httpdocs/images/amc_attachements/"+data.amc_attachment2+"' target='_BLANK' title='Click here to view atatchment' data-toggle='tooltip'><i class='icon-attachment' style='font-size:30px;color:#0d6efd;'></i></a>");
							$("#img_attachment3_preview").html("<a href='../httpdocs/images/amc_attachements/"+data.amc_attachment3+"' target='_BLANK' title='Click here to view atatchment' ><i class='icon-attachment' style='font-size:30px;color:#0d6efd;position:relative;top:3px;'></i></a>");
							
						     attachments[0]=$("#first_image_name").text();
                            attachments[1]=$("#second_image_name").text();
                            attachments[2]=$("#thrid_image_name").text();
						 }
                          if($(this).attr("name")=='a_schedule_visits')
                         {
                           $("#txt_amc_id_schedule_visit").val(v_amc_id);
                           $("#txt_amc_ref_no_schedule_visit").val(v_amc_ref_no);
                              $("#amc_no_view_head_schedule_visit").html("Schedule Visits - Customer - ["+data.customer_name+"] AMC - ["+v_amc_ref_no+"] ");
                             $("#txt_from_date").val("");
                             $("#txt_to_date").val("");  
                             load_data_to_grid_amc_schedules_list(v_amc_id);                
                             $('#select_visit_frequency').val(null).trigger('change');
                            
                             
                         }
                          if($(this).attr("name")=='a_amc_payments')
                         {
                              $("#txt_amc_cust_payment_vat_per").val(v_amc_payable_vat_perct);
                           $("#txt_amc_id_amc_payments").val(v_amc_id);
                           $("#txt_amc_ref_no_payments").val(v_amc_ref_no);
                           $("#txt_cust_id_amc_payments").val(data.customer_id);
                           $("#txt_cust_ref_no_payments").val(data.customer_code);
                             $("#amc_no_view_head_amc_payments").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                            load_data_to_grid_amc_payment_list(v_amc_id);
                           
                         }
                         //add assets 
                         
                       if($(this).attr("name")=='add_assets')
                         {
							asset_page_load();
                        }
                       function asset_page_load()
                       {
                            $("#txt_amc_master_id").val(v_amc_id);
                            $("#span_cust_code").text(v_cust_code);
							 $("#span_cust_name").text(v_cust_name);
							 $("#span_cust_amcno").text(v_amc_ref_no);
							 
                             //fill combo_customer location
    //                          $.ajax({
    //                     		type: "POST",
    //                     		url: "../view/amc/location_combo_customer_location.php",
    //                     		data: { v_cust_id : v_cust_id } 
    //                     		 }).done(function(data){
    
    //                     			$("#div_cust_location").html(data);
    // 								$("#select_location_for_customer_location_assets").select2();
				// 			});
						//fill combo_building  Building				
				// 		 $.ajax({
    //                     		type: "POST",
    //                     		url: "../view/amc/building_combo_customer_location.php",
    //                     		data: { v_cust_id : v_cust_id } 
    //                     		 }).done(function(data){
                        		     
                        			
    //                     			$("#div_cust_building").html(data);
    // 								$("#select_building_for_customer_location").select2();
				// 			});
										
										 //fill combo_customer combo
                             $.ajax({
                            		type: "POST",
                            		url: "../view/amc/customer_combo_customer_location_modal.php",
                            		data: { v_cust_id : v_cust_id } 
                            		 }).done(function(data){
        
                            			$("#div_cust_load_modal").html(data);
        								$("#select_customer_for_customer_location").select2();
							});
							
							if(v_cust_id=='')
							{
    							 $.ajax({
                                		type: "POST",
                                		url: "../view/customer_location/customer_combo_customer_location.php",
                                		
                                		
                                		 }).done(function(data){
            
                                			$("#div_customer_details_asset").html(data);
            								$("#select_customer_for_customer_location").select2();
    							});
										
							}				
                       }
                       
                       if($(this).attr("name")=='add_service')
                         {
                            // alert("inside");
							 
							 $("#span_location_cust_code").text(v_cust_code);
							 $("#span_location_cust_name").text(v_cust_name);
							 $("#span_location_cust_amcno").text(v_amc_ref_no);
                             //fill combo_customer location
                             $.ajax({
                    		type: "POST",
                    		url: "../view/amc/location_service_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){

                    			$("#div_location_select").html(data);
								$("#select_location").select2();
										});
							
													
						//fill combo_customer Building				
						 $.ajax({
                    		type: "POST",
                    		url: "../view/amc/building_service_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){
                    			$("#div_building_select").html(data);
								$("#select_building").select2();
										}); 
						 
								//fill combo_customer Building		
						  $.ajax({
                    		type: "POST",
                    		url: "../view/amc/category_service_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){
                    			$("#div_cate_select").html(data);
								$("#select_cate").select2();
										}); 


										
							$.ajax({
                    		type: "POST",
                    		url: "../view/amc/assettype_service_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){
                    			$("#div_assettype_select").html(data);
								$("#select_assettype").select2();
										}); 
                        }
                        
                        
                        if($(this).attr("name")=='assign_assets')
                         {
                             v_amc_assign_asset_list_table.clear().draw();
							 $("#txt_amc_master_id_assign").val(v_amc_id);
							 // $("#span_location_cust_code_assign_assets").text(v_cust_code);
							 // $("#span_location_cust_name_assign_assets").text(v_cust_name);
							 $("#span_location_cust_amcno_assign_assets").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
							 
                             //fill combo_customer location
                             $.ajax({
                    		type: "POST",
                    		url: "../view/amc/location_assets_assign_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){

                    			$("#div_location_select_assign_assets").html(data);
								$("#select_location_assign_asset").select2();
										});
							
													
						//fill combo_customer Building				
						 $.ajax({
                    		type: "POST",
                    		url: "../view/amc/building_asset_assign_combo.php",
                    		data: { v_cust_id : v_cust_id } 
                    		 }).done(function(data){
                    			$("#div_building_select_assign_assets").html(data);
								$("#select_building_new").select2();
										}); 
						  
                        } 
						
						
						if($(this).attr("name")=='assign_subcontractor')
                         {
						  //v_amc_assigned_subcon_list_table = $('#tbl_amc_assigned_subcontractor_list').DataTable({});
						  
						  $("#amc_ref_no_sub").html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
						  load_data_to_grid_assign_subcontractor_list(v_amc_id);
						  $('#div_subcontractors_load').load("../view/amc/subcontractor_combo.php");
						 }
						 
						  if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+v_amc_ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
                });
				
				$("#txt_contractor_vat").change(function() {
                var v_txt_contractor_amount=$("#txt_contractor_amount").val();
				var vat = $("#txt_contractor_vat").val();
				
                    var txt_vat_amount=v_txt_contractor_amount * (parseFloat(vat)/100);
                    var total_amount=(parseFloat(txt_vat_amount)+parseFloat($("#txt_contractor_amount").val()));
                    $("#txt_contractor_total_amount").val((total_amount.toFixed(3)));
                    //alert(v_txt_contractor_amount+' '+vat+' '+txt_vat_amount+' '+total_amount);
               });
			   
			   $("#txt_contractor_amount").change(function() {
                var v_txt_contractor_amount=$("#txt_contractor_amount").val();
				var vat = $("#txt_contractor_vat").val();
				
                    var txt_vat_amount=v_txt_contractor_amount * (parseFloat(vat)/100);
                    var total_amount=(parseFloat(txt_vat_amount)+parseFloat($("#txt_contractor_amount").val()));
                    $("#txt_contractor_total_amount").val((total_amount.toFixed(3)));
                    //alert(v_txt_contractor_amount+' '+vat+' '+txt_vat_amount+' '+total_amount);
               });
			   
				$('#btn_assign_subcontractors').click(function(){
					
					var v_amc_contractor_id=$("#select_amc_subcontractors option:selected").val();
                    var v_amc_contractor_name=$("#select_amc_subcontractors option:selected").text();
					var v_contractor_description = $('#txt_contractor_description').val();
					var v_contractor_amount = $('#txt_contractor_amount').val();
					var v_contractor_vat = $('#txt_contractor_vat').val();
					var v_contractor_total_amount = $('#txt_contractor_total_amount').val();
					
					var v_amc_start_end_date=$("#txt_list_contractor_start_end_date").val();
					var res_start_end = v_amc_start_end_date.split("-");
					var v_amc_start_date=$.trim(res_start_end[0]);
					var v_amc_end_date=$.trim(res_start_end[1]);
					v_amc_start_date = v_amc_start_date.split("/").reverse();
					var tmpstart = v_amc_start_date[2];
					v_amc_start_date[2] = v_amc_start_date[1];
					v_amc_start_date[0] = v_amc_start_date[0];
					v_amc_start_date[1] = tmpstart;
					v_amc_start_date = v_amc_start_date.join("-");
					v_amc_end_date = v_amc_end_date.split("/").reverse();
					var tmpend = v_amc_end_date[2];
					v_amc_end_date[2] = v_amc_end_date[1];
					v_amc_end_date[0] = v_amc_end_date[0];
					v_amc_end_date[1] = tmpend;
					v_amc_end_date = v_amc_end_date.join("-");
					
					var amcRefNoReasonText = $('#amc_ref_no_sub').text();
					var splitValues = amcRefNoReasonText.split('-');
					var cust_name = splitValues[1];
					var contract_type = splitValues[2];
					
					
					v_session_image = $("#session_image").val();
                    randomNum = Math.ceil(Math.random() * 999999);   
                    
                        if(v_session_image==="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                             doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                            upload.doUpload("../httpdocs/user_upload/amc_subcontractor_file_upload.php?random_no="+randomNum);
                            v_session_image=$.trim(randomNum+'_'+doc_file1);
                        }  
						
					if($.trim(v_amc_contractor_id)==="select"||$.trim(v_contractor_amount)===""||$.trim(v_contractor_vat)===""||$.trim(v_contractor_total_amount)===""||v_amc_start_end_date===""||$.trim(v_contractor_description) === "")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        //v_btn_subcontractor_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {     
                       
                         $.post("../controller/amc/amc_controller.php",{action:'assign_subcontractor',v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_contractor_id:v_amc_contractor_id,v_amc_contractor_name:v_amc_contractor_name,v_contractor_description:v_contractor_description,v_session_image:v_session_image,v_contractor_amount:v_contractor_amount,v_contractor_vat:v_contractor_vat,v_contractor_total_amount:v_contractor_total_amount,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date}
                                , function(result,status)
                                {
                                    console.log(result);
									result = $.trim(result);
                               
                                if(result=="")
                                {
                                    //v_btn_subcontractor_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text_assigned_sub();
                                   
                                }
                                else 
                                {
                                    //v_btn_subcontractor_add.ladda( 'stop' );
                                     swal("Success", "Subcontractor assigned successfully..", "success");
									 
									 assignSubJSONPost(document.getElementById('assign_sub_form'),'AMC','Assign Subcontractors',v_amc_contractor_name,v_amc_start_end_date,v_amc_ref_no,v_session_image,cust_name,contract_type);
									 
                                     load_data_to_grid_assign_subcontractor_list(v_amc_id);
                                     clear_text_assigned_sub();
                                     //location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
					
				});
                
                
                //for barcode generation
                var location_code_view,building_code_view,cust_location_building;
                  $('#div_cust_location').change(function (e) {
        			        location_code_view=$("#select_location_for_customer_location_assets option:selected").text();
        			       // alert(location_code_view);
        			        location_code_view=location_code_view.split('--');
        			        location_code_view=location_code_view[0];
        			        cust_location_building='THC'+'-'+v_cust_code+'-'+location_code_view+'-'+building_code_view;
        			        
        			         $('#txt_barcode_generate_values').val(cust_location_building);
        		            });
	             $('#div_cust_building').change(function (e) {
		        building_code_view=$("#select_building_for_customer_location option:selected").text();
		        
		        building_code_view=building_code_view.split('--');
		        building_code_view=building_code_view[0];
		        cust_location_building='THC'+'-'+v_cust_code+'-'+location_code_view+'-'+building_code_view;
		        $('#txt_barcode_generate_values').val(cust_location_building);
	            });
	            
	            
        		            
                 $('#first_attachment').change(function (e) {
			        attachment_upload('#first_attachment',v_first_attachment_edit,1);
		            });
	        	$('#second_attachment').change(function (e) {
			 
				 attachment_upload('#second_attachment',v_second_attachment_edit,2);
		});
        		$('#third_attachment').change(function (e) {
        			 
        				 attachment_upload('#third_attachment',v_third_attachment_edit,3);
        		});
				  

          
		 
		          
    function attachment_upload(txt_param, v_attachment, attachment_no)
{
    v_attachment = $(txt_param).val();

    var randomNum = Math.ceil(Math.random() * 999999);

    if (v_attachment == "")
    {
        v_attachment = "default.jpg";
    }
    else
    {
        var doc_file_obj = $(txt_param)[0].files[0];

        if (!doc_file_obj) {
            return;
        }

        var doc_file1 = doc_file_obj.name;

        // Remove spaces and special characters from filename
        doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");

        // Final filename (same as DB value)
        v_attachment = randomNum + "_" + doc_file1;

        if (attachment_no == 1)
        {
            attachments[0] = v_attachment;
        }
        else if (attachment_no == 2)
        {
            attachments[1] = v_attachment;
        }
        else
        {
            attachments[2] = v_attachment;
        }

        var upload = new ns.Upload(doc_file_obj);

        var success = upload.doUpload(
            "../httpdocs/user_upload/amc_attachements.php?random_no=" + randomNum,
            v_attachment
        );
    }
}
               //Assets  insert details
  
               //AMC UPDATE STARTS
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
            		$("#btn_amc_edit").click(function(){
            						
            				if($("#custom_checkbox_inline_right_checked").prop('checked') == true){
                                checked_val='Yes';
                            }	
                            else
                            {
                               checked_val='No'; 
                            }
						var amc_ref = $("#txt_amc_number").val();
						$("#update").val(v_amc_id);
						v_first_attachment_edit=attachments[0];
                        v_second_attachment_edit=attachments[1];
                        v_third_attachment_edit=attachments[2];
						var v_amc_hidden_id=$("#update").val();
						
						var v_amc_cust_id_edit=$("#select_customer_for_amc option:selected").val();
						var v_amc_cust_name_code_edit=$("#select_customer_for_amc option:selected").text();
						var res_edit = v_amc_cust_name_code_edit.split("-");
						var v_amc_cust_code_edit=res_edit[0];
						var v_amc_cust_name_edit=res_edit[1]; 
						var v_amc_contract_type_id_edit=$("#select_contract_type_for_amc option:selected").val();
						var v_amc_contract_type_name_edit=$("#select_contract_type_for_amc option:selected").text();

						 var v_amc_signed_date_edit=$("#txt_amc_signed_date").val();
                        v_amc_signed_date_edit = v_amc_signed_date_edit.split("/").reverse();
                        var tmp = v_amc_signed_date_edit[2];
                        v_amc_signed_date_edit[2] = v_amc_signed_date_edit[1];
                        v_amc_signed_date_edit[0] = v_amc_signed_date_edit[0];
                        v_amc_signed_date_edit[1] = tmp;
                        v_amc_signed_date_edit = v_amc_signed_date_edit.join("-");
                        
						var v_amc_start_end_date_edit=$("#txt_amc_start_end_date").val();
						var res_start_end_edit = v_amc_start_end_date_edit.split("-");
						var v_amc_start_date_edit=$.trim(res_start_end_edit[0]);
						var v_amc_end_date_edit=$.trim(res_start_end_edit[1]);
						v_amc_start_date_edit = v_amc_start_date_edit.split("/").reverse();
						var tmpstart_edit = v_amc_start_date_edit[2];
						v_amc_start_date_edit[2] = v_amc_start_date_edit[1];
						v_amc_start_date_edit[0] = v_amc_start_date_edit[0];
						v_amc_start_date_edit[1] = tmpstart_edit;
						v_amc_start_date_edit = v_amc_start_date_edit.join("-");
						v_amc_end_date_edit = v_amc_end_date_edit.split("/").reverse();
						var tmpend_edit = v_amc_end_date_edit[2];
						v_amc_end_date_edit[2] = v_amc_end_date_edit[1];
						v_amc_end_date_edit[0] = v_amc_end_date_edit[0];
						v_amc_end_date_edit[1] = tmpend_edit;
						v_amc_end_date_edit = v_amc_end_date_edit.join("-");
						var v_amc_amount_edit = $("#txt_amc_amount").val();
						var v_total_amc_amnt = $('#txt_total_amc_amount').val();
						var v_amc_vat_percentage_edit = $("#txt_vat_percentage").val();
						var v_amc_vat_per_amount_edit=$("#txt_amc_vat_amount").val();
						var v_amc_is_rfp_edit=checked_val;
					
						var v_amc_description_edit=$("#txt_amc_description").val();
						var v_amc_first_desc_edit=$("#txt_first_attachment_desc").val();
						var v_amc_second_desc_edit=$("#txt_sec_attachment_desc").val();
                        var v_amc_third_desc_edit=$("#txt_third_attachment_desc").val();
                        // v_first_attachment_edit=$("#first_image_name").text();
						// v_second_attachment_edit=$("#second_image_name").text();
                        // v_third_attachment_edit=$("#thrid_image_name").text();

						var v_total_payable_amt=(parseFloat(v_total_amc_amnt)+parseFloat(v_amc_vat_per_amount_edit));
						
						if(v_first_attachment_edit==="")
								{
									v_first_attachment_edit="default.jpg";
								}
								
							if(v_second_attachment_edit==="")
								{
									   
									v_second_attachment_edit="default.jpg";
								}
									
							if(v_third_attachment_edit==="")
								{
										   
									v_third_attachment_edit="default.jpg";
								}
								
				$.post("../controller/amc/amc_controller.php",{action:'update_amc',v_amc_cust_id_edit:v_amc_cust_id_edit,v_amc_cust_code_edit:v_amc_cust_code_edit,v_amc_cust_name_edit:v_amc_cust_name_edit,v_amc_contract_type_id_edit:v_amc_contract_type_id_edit,v_amc_contract_type_name_edit:v_amc_contract_type_name_edit,v_amc_signed_date_edit:v_amc_signed_date_edit,v_amc_start_date_edit:v_amc_start_date_edit,v_amc_end_date_edit:v_amc_end_date_edit,v_amc_amount_edit:v_amc_amount_edit,v_amc_vat_percentage_edit:v_amc_vat_percentage_edit,v_amc_vat_per_amount_edit:v_amc_vat_per_amount_edit,v_amc_is_rfp_edit:v_amc_is_rfp_edit,v_amc_description_edit:v_amc_description_edit,v_first_attachment_edit:v_first_attachment_edit,v_second_attachment_edit:v_second_attachment_edit,v_third_attachment_edit:v_third_attachment_edit,v_amc_first_desc_edit:v_amc_first_desc_edit,v_amc_second_desc_edit:v_amc_second_desc_edit,v_amc_third_desc_edit:v_amc_third_desc_edit,v_amc_hidden_id:v_amc_hidden_id,v_total_payable_amt:v_total_payable_amt,v_total_amc_amnt:v_total_amc_amnt}, function(result,status)
				{
							
				
						result = $.trim(result);
						if(result.charAt(0)=='U')
							{
								
								swal("Error", result, "error");
							  
							}
						else 
							{
								 JSONPost(document.getElementById('amc_form'),'AMC','Update AMC',v_amc_cust_code_edit,v_amc_cust_name_edit,v_amc_contract_type_name_edit,amc_ref,v_first_attachment_edit,v_second_attachment_edit,v_third_attachment_edit,v_amc_is_rfp_edit,v_total_payable_amt);
								 swal("Success", "AMC details updated successfully..", "success");
								 //location.reload();
							}
							
						
				});
						
	});	//close the update of AMC
	  
                         $("#btn_amc_new").click(function(){
			                    location.reload();
	                     });   
	
	
	 
	
	
                $("#btn_change_status").click(function(){
                 var v_amc_status_value=   $("input[name='radio-styled-color']:checked").val();
                 var v_amc_staus_description= $("#txt_status_description").val();
                 var v_amc_ref_no=$("#txt_amc_ref_no").val();
				 
				 var amcRefNoReasonText = $('#amc_no_view_head').text();
				 var splitValues = amcRefNoReasonText.split('-');
				 var cust_name = splitValues[1];
				 var contract_type = splitValues[2];
				 
                 if(v_amc_status_value==1){
                     v_amc_status="Active";
                 }
                 else if(v_amc_status_value==2)
                 {
                    v_amc_status="Cancelled" 
                 }
                 else if(v_amc_status_value==3)
                 {
                    v_amc_status="Hold" 
                 }
                 else if(v_amc_status_value==4)
                 {
                    v_amc_status="Completed" 
                 }
                 if(v_amc_status_value==3 || v_amc_status_value==2)
                 {
                     if(v_amc_staus_description=='')
                     {
                         swal("Warning","Please provide status description... ","warning")
                     }
                     else
                     {
                        $.post("../controller/amc/amc_controller.php",{action:"change_status",v_amc_status:v_amc_status,v_amc_staus_description:v_amc_staus_description,v_amc_ref_no:v_amc_ref_no},function(result,res){
                             swal("Success","AMC status changed successfully....","success");
							 changeStatusJSONPost('AMC','AMC Status Change',v_amc_status,cust_name,contract_type,v_amc_staus_description,v_amc_ref_no);
                             $("#txt_status_description").val('');
                             load_data_to_grid_amc_list();
                         })  
                     }
                 }
                     else
                     {
                         $.post("../controller/amc/amc_controller.php",{action:"change_status",v_amc_status:v_amc_status,v_amc_staus_description:v_amc_staus_description,v_amc_ref_no:v_amc_ref_no},function(result,res){
                             swal("Success","AMC status changed successfully....","success");
							 changeStatusJSONPost('AMC','AMC Status Change',v_amc_status,cust_name,contract_type,v_amc_staus_description,v_amc_ref_no);
                             $("#txt_status_description").val('');
                             load_data_to_grid_amc_list();
                         })
                     }
                    
                })         
    $.fn.modal.Constructor.prototype._enforceFocus = function() {}; 
    
    
    //Renew AMC
    
                 // $("#txt_amc_renewal_start_end_date").change(function(){
                  
                    // var v_amc_renewal_start_end_date=$("#txt_amc_renewal_start_end_date").val();
                    // var res_start_end = v_amc_renewal_start_end_date.split("-");
                    
                    // var v_amc_renewal_start_date=convertDate($.trim(res_start_end[0]));
                    // var v_amc_renewal_end_date=convertDate($.trim(res_start_end[1]));
                    
                    // var v_amc_end_date=$("#txt_amc_end_date_renew").val();
                    // v_amc_end_date = v_amc_end_date.split("-").reverse().join("-");
                   
                    // if(v_amc_renewal_start_date<=v_amc_renewal_end_date)
                    // {
                      // swal("Warning","Please select correct end date...","warning");
                        // return false;  
                    // }
                   
                    // if(v_amc_renewal_start_date < v_amc_end_date)
                    // {
                        // swal("Warning","The start date will be greater than the end date of last AMC","warning");
                        // return false;
                    // }
                 // })
    
                   $('#txt_amc_renewal_amount').change(function (e) {
                         CalculateVatAmountRenewal();
                    });
                        
                    $('#txt_vat_renewal_percentage').change(function (e) {
                         CalculateVatAmountRenewal();
                          
                        });
                    function CalculateVatAmountRenewal()
                        {
                            var v_amc_renewal_amount = $("#txt_amc_renewal_amount").val();
                            var v_amc_renewal_vat_percentage = $("#txt_vat_renewal_percentage").val();
                            var vat_renewal_per=parseFloat(v_amc_renewal_vat_percentage)/100;
                            var v_renewal_vat_amount= v_amc_renewal_amount * vat_renewal_per;
                           
                            if(isNaN(v_renewal_vat_amount))
                                {
                                     $("#txt_amc_renewal_vat_amount").val(0);
                                }
                            else
                                {
                                     $("#txt_amc_renewal_vat_amount").val(v_renewal_vat_amount);
                                }
                       
                        }
           var convertDate = function(usDate) {
              var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
              return dateParts[3] + "-" + dateParts[1] + "-" + dateParts[2];
            }     
    
    
    
      var v_session_image;
     $('#session_image_close').change(function (e) {
                         
            v_session_image = $("#session_image_close").val();
          
            randomNum = Math.ceil(Math.random() * 999999);
                if(v_session_image=="")
            {
                v_session_image="default.jpg";
                 $("#txt_hidden_ticket_image_close").val('default.jpg');
            }
            else
            {
                var doc_file_obj = $("#session_image_close")[0].files[0];
                var upload = new ns.Upload(doc_file_obj);
                doc_file1= doc_file_obj.name;
                upload.doUpload("../httpdocs/user_upload/amc_renewal_image_upload.php?random_no="+randomNum);
                v_session_image=$.trim(randomNum+'_'+doc_file1);
                 $('#txt_hidden_ticket_image_close').val(v_session_image);
                
            }     
      });
          
          
          
      $("#txt_hidden_ticket_image_close").val('NA');     
          
    $("#btn_remove_ticket_image_close").click(function(){
	    
	    $('#session_image_close').val('');
        $("#txt_hidden_ticket_image_close").val('NA');
        v_session_image="";
	});
	

	$("#i_image").click(function(){
	    var img_to_load=$("#txt_hidden_ticket_image_close").val();
	    if(img_to_load=='NA')
	    {
	        img_to_load='default.jpg';
	    }
	    var filePath='../httpdocs/images/amc_renewal_attachments/';
	    window.open(filePath + img_to_load );
	});
    
            // $("#btn_renewal_amc").click(function(){
             
                              
                                // var v_amc_renewal_signed_date=convertDate($("#txt_amc_renewal_signed_date").val());
                                
                                // var v_amc_renewal_start_end_date=$("#txt_amc_renewal_start_end_date").val();
                                // var res_start_end = v_amc_renewal_start_end_date.split("-");
                                
                                // var v_amc_renewal_start_date=convertDate($.trim(res_start_end[0]));
                                // var v_amc_renewal_end_date=convertDate($.trim(res_start_end[1]));
                               // var renew_remarks=$("#txt_renew_remarks").val();
                                // var v_amc_renewal_amount = $("#txt_amc_renewal_amount").val();
                                // var v_amc_renewal_vat_percentage = $("#txt_vat_renewal_percentage").val();
                                // var v_amc_renewal_vat_per_amount=$("#txt_amc_renewal_vat_amount").val();
                                // var v_amc_ref_no=$("#txt_amc_ref_no").val();
                                // var v_amc_end_date=$("#txt_amc_end_date_renew").val();
                                // v_amc_end_date = v_amc_end_date.split("-").reverse().join("-");
                    
                               // if($.trim(v_amc_renewal_amount)==''||$.trim(v_amc_renewal_vat_percentage)==''||$.trim(v_amc_renewal_vat_per_amount)==''||$.trim(v_amc_renewal_start_date)==''||$.trim(v_amc_renewal_end_date)==''|| $.trim(v_amc_renewal_signed_date)=='')
                               // {
                                   // swal("Warning","Please provide all the fields..","warning");
                                   // return false;
                               // }
                               // else if(v_amc_renewal_start_date > v_amc_end_date)
                               // {
                                  // swal("Warning","The start date will be greater than the end date","warning");
                                   // return false; 
                               // }
                               // else
                               // {	var v_session_image1=$('#txt_hidden_ticket_image_close').val();
                                  // $.post("../controller/amc/amc_controller.php",{action:"renewal_amc",v_amc_renewal_amount:v_amc_renewal_amount,v_amc_renewal_vat_percentage:v_amc_renewal_vat_percentage,v_amc_renewal_vat_per_amount:v_amc_renewal_vat_per_amount,v_amc_renewal_start_date:v_amc_renewal_start_date,v_amc_renewal_end_date:v_amc_renewal_end_date,v_amc_renewal_signed_date:v_amc_renewal_signed_date,v_amc_ref_no:v_amc_ref_no,amc_renew_image:v_session_image1,renew_remarks:renew_remarks},function(){
                                      // swal('Success',"AMC Renewed successfully...","success");
                                      // load_data_to_grid_amc_list();
                                      // clear_text_renew();
                                  // })
                               // }
                
            // })
            
           // function clear_text_renew()
           // {
               // $("#txt_amc_renewal_signed_date").val('');
               // $("#txt_amc_renewal_start_end_date").val('');
               // $("#txt_amc_renewal_amount").val('');
               // $("#txt_vat_renewal_percentage").val('');
               // $("#txt_amc_renewal_vat_amount").val('');
           // }
            
    
    //AMC SCHEDULE VISITS
    
    var v_btn_amc_generate_schedule = $('#btn_generate_schedule').ladda();
    var v_amc_scchedules_list_table = $('#tbl_amc_date_list').DataTable({"destroy": true}); 
    
      
    
    function load_data_to_grid_amc_schedules_list(amc_ids)
    {
     
      v_amc_scchedules_list_table.destroy();
            
       v_amc_scchedules_list_table = $('#tbl_amc_date_list').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_schedule_controller.php',
                    'data': {
                       action: 'amc_list_schedules',amc_id:amc_ids
                       
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
                   
                    { "data": "year_of_visits"},
                    { "data": "month_of_visits"},
                    { "data": "day_of_visits"},
                    { "data": "date_of_visits",
                    render: function ( data, type, rows, meta ) {
                            
                            return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:200px;"><input type="date" class="form-control daterange-single" value="'+data+'" id="txt_date_'+rows["amc_visit_id"]+'"></td>';
                            
                        }   
                    },
                    { "data": "time_of_visit",
                    render: function ( data, type, rows, meta ) {
                            
                        return str_actions=' <td style="padding:0px;padding-left:30px;padding-right:30px;width:150px;"><input class="form-control" type="time" name="time" width="50px;" value="'+data+'" id="txt_time_'+rows["amc_visit_id"]+'"></td>';
                         
                        }   
                    },
                    { "data": "amc_visit_id",
                         render: function ( data, type, rows, meta ) {
                            
                            return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"  name="amc_visit_update" ><i class="icon-pencil5"></i> Update Schedule</a><a href="#" class="dropdown-item" name="amc_cancel_schedule"><i class="icon-quill4"></i> Cancel Schedule</a></div></div></div>';
                             
                         }   
                    }
                    
                    
                    
                    
          
                ],
                pageLength: 20,
                searching: true,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5,6] },
                   { "width": "5%", "targets": 0 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }


    $('#tbl_amc_date_list tbody').on('click', 'a', function(e){
        var $row = $(this).closest('tr');
        var data = v_amc_scchedules_list_table.row($row).data();
        var v_amc_visit_id  = data.amc_visit_id;
        var v_amc_ids=data.amc_id;
         if($(this).attr("name")=='amc_visit_update')
         {
           var visit_date=$("#txt_date_"+v_amc_visit_id).val();
           var visit_time=$("#txt_time_"+v_amc_visit_id).val();
           $.post("../controller/amc/amc_schedule_controller.php",{action:'update_visit',amc_visit_id:v_amc_visit_id,visit_date:visit_date,visit_time:visit_time}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully updated the schedule...", "success");
                            
                            
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not update the schedule...", "error");
                                return false;
                                
                        }
             });
             
         }
         if($(this).attr("name")=='amc_cancel_schedule')
         {
            $.post("../controller/amc/amc_schedule_controller.php",{action:'cancel_visit',amc_visit_id:v_amc_visit_id}
           , function(result,status)
             {
              
                    result = $.trim(result);
                    
                    if(status=='success')
                        {
                            
                            swal("Success", "Successfully cancelled the schedule...", "success");
                            
                            load_data_to_grid_amc_schedules_list(v_amc_ids);
                        }
                    else 
                        {
                            
                                swal("Error", "Sorry! Could not cancel the schedule...", "error");
                                return false;
                                
                        }
             });
            
             
         }
       
});
 

    function dateconvert(dates)
    {
       
       return dates.split("-").reverse().join("-");
    }
    
    v_btn_amc_generate_schedule.click(function(){ 
       var amc_id = $("#txt_amc_id_schedule_visit").val();
       var amc_ref_no = $("#txt_amc_ref_no_schedule_visit").val();
       //var amc_id = 1;
       //var amc_ref_no = 1;
       var frequency_array=$("#select_visit_frequency").val();
       var start_date = dateconvert($("#txt_from_date").val());
       var end_date =dateconvert($("#txt_to_date").val());
       var schedule_time = $("#time").val();
       
       if($.trim(amc_id)==""||$.trim(amc_ref_no)=="")
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
       $.post("../view/amc/amc_generate_dates.php",{action:'schedule_visits',amc_id:amc_id,amc_ref_no:amc_ref_no,frequency_array:frequency_array,start_date:start_date,end_date:end_date,schedule_time:schedule_time}
                   , function(result,status)
                   {
                      
                       result = $.trim(result);
                       if(result.charAt(0)=='S')
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                               swal("Success", "Visits scheduled successfully..", "success");
                            
                               $('#select_visit_frequency').val(null).trigger('change');
                               load_data_to_grid_amc_schedules_list(amc_id);
                           }
                       else 
                           {
                               v_btn_amc_generate_schedule.ladda( 'stop' );
                                swal("Error", "Sorry! Could not schedule the visits..", "error");
                                return false;
                                
                           }
           });
   
       }
   });  
   
    //AMC VISIT SCHEDULE CLOSE
    
    
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
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            
                            return intVal(a) + intVal(b);
                        }, 0 );
                   
                    // Total over this page Income
                    pageTotal1 = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    
                    // Update footer
                   
                  /*  $( api.column( 3 ).footer() ).html($.fn.dataTable.render.number(',', '.', 3, '').display( pageTotal1 ) );
                     
                               if((parseFloat(str_balance)/2)==0)
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
     
     $('#btn_add_new_asset_assign_assets').click(function(){ 
        
        $('#txt_customer_ids_add_assets').val(v_cust_id);
        $('#txt_customer_code_add_assets').val(v_cust_code);
        $('#txt_customer_name_add_assets').val(v_cust_name);
        var amc_no = $("#span_location_cust_amcno_assign_assets").text();
		$('#span_assign_asset_add_amc_ref').html(amc_no);
     });
    
    //AMC PAYMENTS CLOSE
     
                        //add location_modal
						
                      //starting of 2 datatable for service modal
function load_data_to_grid_amc_service_list(asset_cate_combo,assettype_combo)
    {
     
      v_amc_service_list_table.destroy();
            
       v_amc_service_list_table = $('#tbl_amc_asset_list_display').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_asset_service_controller.php',
                    'data': {
                       action: 'amc_list_service',
					  
                       assettype_combo:assettype_combo,
					   asset_cate_combo:asset_cate_combo,
					   asset_building_combo:asset_building_combo,
					   v_amc_ref_no:v_amc_ref_no
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
                  
                    { "data": null},
                   
                    { "data": "asset_ref_no"},
                    { "data": "asset_brand"},
                     { "data": "asset_cost"},
                    { "data": "asset_description"},
                ],
                pageLength: 20,
                searching: false,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2] },
                   { "width": "5%", "targets": 0 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }
    
    function load_data_to_grid_amc_service_list_for_assign(location_id,v_building_id)
    {
     
      v_amc_assign_asset_list_table.destroy();
            
       v_amc_assign_asset_list_table = $('#tbl_amc_asset_list_display_for_assign').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_asset_service_controller.php',
                    'data': {
                       action: 'amc_list_asset_for_assign',
					   location_id:location_id,
					   v_cust_id : v_cust_id,
                        v_building_id : v_building_id
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
                   
                    { "data": "asset_ref_no"},
                    { "data": "asset_category_name"},
                    { "data": "asset_type_name"},
                     { "data": "asset_brand"},
                    { "data": "asset_description"},
                ],
                pageLength: 30,
                searching: false,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1,2,3,4,5] },
                   { "width": "5%", "targets": 0 } ,
                   { "width": "20%", "targets": 1 } ,
                   { "width": "15%", "targets": 2 } ,
                   { "width": "15%", "targets": 3 } ,
                   { "width": "15%", "targets": 4 } ,
                   { "width": "30%", "targets": 5 } 
                   
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }
    
    
    $('#tbl_amc_asset_list_display_for_assign tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            
        }
        else {
            //v_amc_service_list_table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            
            var $row = $(this).closest('tr');
            var ids = v_amc_assign_asset_list_table.row($row).data();
           
        }
        
    });
    
    
     v_btn_amc_assign_assets.click(function(){ 
				//	v_btn_amc_assign_assets.ladda( 'start' );
					var	location_id_new=$("#select_location_assign_asset option:selected").val();
				    var	v_building_id_new=$("#select_building_new option:selected").val();
				    var v_amc_id=$("#txt_amc_master_id_assign").val();
			         var assign_assets_table_selected_count = v_amc_assign_asset_list_table.rows('.selected').data().length;
		
            		    var assignAssetsSelectedValues = $.map(v_amc_assign_asset_list_table.rows('.selected').data(), function (item) {
            			return item;
            		     });
		        
		     	                v_amc_start_date = v_amc_start_date.split("-").reverse();
                                var tmp = v_amc_start_date[2];
                                v_amc_start_date[0] = v_amc_start_date[0];
                                v_amc_start_date[1] = v_amc_start_date[1];
                                v_amc_start_date[2] = tmp;
                                v_amc_start_date = v_amc_start_date.join("-");
                                
                                v_amc_end_date = v_amc_end_date.split("-").reverse();
                                var tmp = v_amc_end_date[2];
                                v_amc_end_date[0] = v_amc_end_date[0];
                                v_amc_end_date[1] = v_amc_end_date[1];
                                v_amc_end_date[2] = tmp;
                                v_amc_end_date = v_amc_end_date.join("-");
                                
                                
                                
                                
		        var SQLString1 = 'UPDATE `tbl_assets` set  `amc_ref_no`="'+v_amc_ref_no+'",`amc_start_date`="'+v_amc_start_date+'",`amc_end_date`="'+v_amc_end_date+'" where `asset_id` IN (';
		       // var SQLString2 = 'INSERT INTO `tbl_amc_child` (`amc_master_id`, `amc_ref_no`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`)  SELECT  FROM table1 WHERE condition;'
		       var SQLString ="";
	            var SQLString2 ="";
        		for(firstcounter=0;firstcounter<=assign_assets_table_selected_count-1;firstcounter++)
        		{
		          SQLString2 = SQLString2 +'("'+v_amc_id+'","'+v_amc_ref_no+'","'+assignAssetsSelectedValues[firstcounter].asset_category_id+'","'+assignAssetsSelectedValues[firstcounter].asset_category_name+'","'+assignAssetsSelectedValues[firstcounter].asset_type_id+'","'+assignAssetsSelectedValues[firstcounter].asset_type_name+'","'+
					assignAssetsSelectedValues[firstcounter].asset_id+'","'+assignAssetsSelectedValues[firstcounter].asset_ref_no+'"),'; 
				
			    SQLString = SQLString +'"'+assignAssetsSelectedValues[firstcounter].asset_id+'",';  
				}
		
	    SQLString2=SQLString2.replace(/,\s*$/,"" );
	 	SQLString =  SQLString1+SQLString.replace(/,\s*$/, "")+")";
	 	
	 	
		var select_len=v_amc_assign_asset_list_table.rows( '.selected' ).count();
		//console.log('Length : '+select_len);
		if ( select_len!=0 )
             {
                		 $.post("../controller/amc/amc_asset_service_controller.php",{action:'assign_asset_for_amc',"sql_string":SQLString,"sql_string2":SQLString2}
                          , function(result,status)
                            {
                				if(status=='success')
                				{
                					v_btn_amc_assign_assets.ladda( 'stop' );
                					swal("Success", "Asset assigned to AMC successfully..", "success");
                					load_data_to_grid_amc_service_list_for_assign(location_id_new,v_building_id_new);		
                				}
                                else
                					{
                				 		v_btn_amc_assign_assets.ladda( 'stop' );
                						swal("Warning", "Error", "warning");
                						load_data_to_grid_amc_service_list_for_assign(location_id_new,v_building_id_new);
                				    }
                            });
             }
            else
            {
            swal("Warning", "Please select an asset to continue..", "warning");  
            }
    
	});
    
    function load_data_to_grid_amc_service_category_list(asset_cate_combo,assettype_combo)
    {
     
      v_amc_serviceslist_display.destroy();
            
       v_amc_serviceslist_display = $('#tbl_amc_serviceslist_display').DataTable( {
              
                "ajax": {
                    'type': 'POST',
                    'url': '../controller/amc/amc_asset_service_controller.php',
                    'data': {
                       action: 'amc_list_service_category',
                       assettype_combo:assettype_combo,
					   asset_cate_combo:asset_cate_combo,
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
                 
                    { "data": null},
                   
                    //{ "data": "category_name"},
                    //{ "data": "asset_type_name"},
                     { "data": "service_description"}, 
                ],
                pageLength: 20,
                searching: false,
                responsive: true,
                
                "aoColumnDefs": [
                   { "bSortable": false, "aTargets": [1] },
                   { "width": "5%", "targets": 0 } 
                   
               ],
               
                "initComplete": function( settings, json ) {
                       
                  
   
                 },
                   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
					 //$('tr', nRow).css('background-color', 'Red');    
                    return nRow;
                 },
                 drawCallback: function (settings) {
                  
               }
               
        });  
   
    }//close of datatable for service modal

    $("#asset_search").click(function(){ 
					v_btn_asset_search.ladda( 'start' );
				 	//location_id=$("#select_location option:selected").val();
					//asset_building_combo=$("#select_building option:selected").val();
					asset_cate_combo=$("#select_cate option:selected").val();
					assettype_combo=$("#select_assettype option:selected").val();
					
					if($.trim(asset_cate_combo)=="Select Category"||$.trim(asset_cate_combo)==""||$.trim(assettype_combo)==="Select Asset Type"||$.trim(assettype_combo)=="" )
					{
						v_btn_asset_search.ladda( 'stop' );
						swal("Warning","Please provide all field....", "warning");
						$("#select_location").val(null).trigger("change");
						$("#select_building").val(null).trigger("change");
						$("#select_cate").val(null).trigger("change");
						$("#select_assettype").val(null).trigger("change");
                        return false;
						
						
					}
					else
					{
						v_btn_asset_search.ladda( 'stop' );
						//swal("Success", "New asset type added successfully..", "success");
						load_data_to_grid_amc_service_list(asset_cate_combo,assettype_combo);
						load_data_to_grid_amc_service_category_list(asset_cate_combo,assettype_combo);
						
					}
	});  
	
	$("#assign_asset_search").click(function(){ 
					v_btn_assign_asset_search.ladda( 'start' );
				 	location_id=$("#select_location_assign_asset option:selected").val();
				    var	v_building_id=$("#select_building_new option:selected").val();
				    
					if($.trim(location_id)==="Select Location"||$.trim(location_id)==""||$.trim(v_building_id)==="Select Building")
					{
						v_btn_assign_asset_search.ladda( 'stop' );
						swal("Warning","Please provide all field....", "warning");
						$("#select_location").val(null).trigger("change");
						$("#select_building").val(null).trigger("change");
						$("#select_cate").val(null).trigger("change");
						$("#select_assettype").val(null).trigger("change");
                        return false;
						
						
					}
					else
					{
					    
						v_btn_assign_asset_search.ladda( 'stop' );
						//swal("Success", "New asset type added successfully..", "success");
						
						load_data_to_grid_amc_service_list_for_assign(location_id,v_building_id);
						
						
					}
	});
	
	$("#btn_add_child").click(function(){
		//getting data from First Table
		v_btn_add_child.ladda( 'start' );
		var first_table_selected_count = v_amc_service_list_table.rows('.selected').data().length;
		
		  var FirstTableSelectedValues = $.map(v_amc_service_list_table.rows('.selected').data(), function (item) {
			return item;
		}); 
		
		
		var second_table_selected_count = v_amc_serviceslist_display.rows('.selected').data().length;
		var SecondTableSelectedValues = $.map(v_amc_serviceslist_display.rows('.selected').data(), function (item) {
			return item;
		}); 
		var SQLString ="";
	
		for(firstcounter=0;firstcounter<=first_table_selected_count-1;firstcounter++)
		{
		
				for(secondcounter=0;secondcounter<=second_table_selected_count-1;secondcounter++)
				{
					SQLString = SQLString +'("'+v_amc_ref_no+'","'+v_amc_id+'","'+
					
					FirstTableSelectedValues[firstcounter].asset_id+'","'+
				
				// 	FirstTableSelectedValues[firstcounter].asset_type_id+'","'+
				// 	FirstTableSelectedValues[firstcounter].asset_type_name+'","'+
				// 	FirstTableSelectedValues[firstcounter].asset_category_id+'","'+
				// 	FirstTableSelectedValues[firstcounter].asset_category_name+'","'+
					FirstTableSelectedValues[firstcounter].asset_ref_no+'","'+
					SecondTableSelectedValues[secondcounter].service_id+'","'+
					SecondTableSelectedValues[secondcounter].service_description+'"),'; 
					//console.log(FirstTableSelectedValues[firstcounter]);
					//console.log(SecondTableSelectedValues[secondcounter]);
				}
		
		}
	 	SQLString =  SQLString.replace(/,\s*$/, "");
		console.log(SQLString); 
		
		 $.post("../controller/amc/amc_asset_service_controller.php",{action:'add_amc_child',"sql_string":SQLString}
           , function(result,status)
            {
				console.log(result);
				if(result!='')
				{
					v_btn_add_child.ladda( 'stop' );
					swal("Success", "Services added successfully..", "success");
					$("#select_location").val(null).trigger("change");
					$("#select_building").val(null).trigger("change");
					$("#select_cate").val(null).trigger("change");
					$("#select_assettype").val(null).trigger("change");	
					load_data_to_grid_amc_service_category_list();
					load_data_to_grid_amc_service_list();					
				}
				else
				{
					v_btn_add_child.ladda( 'stop' );
					swal("Error", result, "error");
				}
		
			});
	
	}); 
	//End AMC service 
	
	//End AMC service
	
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
								//alert(v_amc_cust_paid_amount);
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
						
		var v_list_of_amc_child = $('#tbl_of_amc_child_details').DataTable({});				
		    function load_data_to_grid_amc_child_details(amc_ref_no)
                 {
                    
                    v_list_of_amc_child.destroy();
                         
                     v_list_of_amc_child= $('#tbl_of_amc_child_details').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'action_view_amc_child_details',amc_ref_no:amc_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
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
                                    "width": "5%"
                                    
                                 },
                                 { "data": null,"width": "5%"},
                                
								 { "data": "category_name"},
								 { "data": "asset_type_name"},
								 { "data": "asset_ref_no","width": "20%"},
								 { "data": "location_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['asset_location'];
                                          
                                     	return str_active_status;
            
            							 }
                                 },
                                 { "data": "building_code","width": "20%",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['asset_building'];
                                          
                                     	return str_active_status;
            
            							 }
                                 }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(1)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                              },
                              "drawCallback": function () {
                                  
                                }
                            
                     });  
                
                 }
                 
                   $('#tbl_of_amc_child_details tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = v_list_of_amc_child.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_amc_child_details(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
                      function format_amc_child_details(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Zone/Floor </div></td>'+
            				'<td ><div align="center"> Area Code </div></td>'+
            				'<td ><div align="center">Room No </div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.zone_floor+'</div></td>'+
            				'<td><div align="center">'+d.flat_area_code+'</div></td>'+
            				'<td><div align="center">'+d.room_no+'</div></td>'+
							
            				
            			  '</tr>'+
            			  	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Location Details </div></td>'+
            				'<td ><div align="center">Brand </div></td>'+
            				'<td ><div align="center">Serial No</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.asset_sp_des+'</div></td>'+
            				'<td><div align="center">'+d.asset_brand+'</div></td>'+
            				'<td><div align="center">'+d.asset_serial_no+'</div></td>'+
							
            				
            			  '</tr>'+
            			   	 '<tr style="background: #989898;color:#ffffff;">'+
            			    '<td ><div align="center">Capacity</div></td>'+
            				'<td ><div align="center">Cost</div></td>'+
            				'<td ><div align="center">Is Warrenty</div></td>'+
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.asset_capacity+'</div></td>'+
            				'<td><div align="center">'+d.asset_cost+'</div></td>'+
            				'<td><div align="center">'+d.is_warentee+'</div></td>'+
							
            				
            			  '</tr>'+
            			  '<tr style="background: #989898;color:#ffffff;">'+
            			  '<td ><div align="center">Warrenty End Date</div></td>'+
            			    '<td ><div align="center">Asset Description</div></td>'+
            				'<td ><div align="center">Asset Image</div></td>'+
            				
						
            			
            			  '</tr>'+
            			  '<tr>'+
            			  	'<td><div align="center">'+d.warentee_end_date+'</div></td>'+
            				'<td><div align="center">'+d.asset_description+'</div></td>'+
            				'<td><div align="center"><a href="../httpdocs/images/amc_attachements/'+d.asset_attachment+'" target="_blank" rel="noopener"><i class="icon-image4 mr-3 icon-2x"></a></i></div></td>'+
							
            				
            			  '</tr>'+
            			
            			'</table>' ;
                        			
		
		
	            }
				
				function load_data_to_grid_assign_subcontractor_list(v_amc_id)
                 {
                  
                    tbl_amc_assigned_subcontractor_list.destroy();
                         
                     tbl_amc_assigned_subcontractor_list = $('#tbl_amc_assigned_subcontractor_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'assigned_subcontractor_list_view',
									v_amc_id:v_amc_id
                                    
                                 },
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                            "order": [[ 1, "desc" ]],
                           
            				"Paginate": true,
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
                                    "width": "5%"
                                    
                                 },
                                 { "data": null,
									// "width": "5%",
                                    // "render": function (data, type, row, meta) {
                                        // return meta.row + 1; 
                                    // }
								 },
								{ "data": "subcontractor_name"},
								{ "data": "contract_amount"},
								{ "data": "contract_vat"},
								{ "data": "contract_total_amount"},
								{ "data": "amc_subcontractor_status",
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
								{ "data": "amc_subcontractor_ids",
								 render: function ( data, type, rows, meta ) {
									 if(rows['amc_subcontractor_status'] === 'Active')
									 {
										str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-database-edit2"></i> Edit </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_deactive_reason" name="Deactive"><i class="icon-cross3"></i> Deactive </a><a href="../httpdocs/images/amc_subcontractor_file_upload/'+rows["file_name"]+'" target="_blank" class="dropdown-item" name="view_doc"><i class="icon-file-text3"></i> View Doc </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" name="delete_data" data-target="#"><i class="icon-trash"></i> Delete</a></div></div>'; 
									 }
									else
									{
										str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-database-edit2"></i> Edit </a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#" name="Active"><i class="icon-checkmark2"></i> Active </a><a href="../httpdocs/images/amc_subcontractor_file_upload/'+rows["file_name"]+'" target="_blank" class="dropdown-item" name="view_doc"><i class="icon-file-text3"></i> View Doc </a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" name="delete_data" data-target="#"><i class="icon-trash"></i> Delete</a></div></div>';
									}
									return str_actions; 
								 }
								},
							
							],
							pageLength: 30,
							searching: false, 
							responsive: true,
							
							"aoColumnDefs": [
							   { "bSortable": false, "aTargets": [1,2,3,4,5,6,7] },
							   { "width": "5%", "targets": 0 } ,
							   { "width": "20%", "targets": 1 } ,
							   { "width": "15%", "targets": 2 } ,
							   { "width": "15%", "targets": 3 } ,
							   { "width": "15%", "targets": 4 } ,
							   { "width": "30%", "targets": 5 } ,
							   { "width": "30%", "targets": 6 } ,
							   { "width": "30%", "targets": 7 }
							   
							   
						   ],
						   
							"initComplete": function( settings, json ) {
								   
							  
			   
							 },
							   "fnRowCallback": function (nRow, aData, iDisplayIndex) {
								   $("td:eq(1)", nRow).html(iDisplayIndex + 1);
								   return nRow;
							 },
							 drawCallback: function (settings) {
							  
						   },
						   "footerCallback": function (rows, data, start, end, display) {
                                var api = this.api();
								var intVal = function (i) {
									return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; 
								};

								var total_amount_rec = api
									.column(5, { page: 'current' })
									.data()
									.reduce(function (a, b) {
										return intVal(a) + intVal(b);
									}, 0);

								tbl_amc_assigned_subcontractor_list.column(5).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                     });  
                
                 }
				 
				 $('#tbl_amc_assigned_subcontractor_list tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = tbl_amc_assigned_subcontractor_list.row( tr );
                   
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format_subcontractors(row.data()) ).show();
                        tr.addClass('shown');
                       
                         
                    }
                } );
        
                 function format_subcontractors(d)
	               	{
		
            			return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 '<tr style="background: #989898;color:#ffffff;">'+
            			    
							'<td ><div align="center">Description</div></td>'+
            				'<td ><div align="center">Start Date</div></td>'+
            				'<td ><div align="center">End Date</div></td>'+
            			
            			  '</tr>'+
            			  '<tr>'+
            				
							'<td><div align="center">'+d.contractor_description+'</div></td>'+
            				'<td><div align="center">'+d.contract_start_date+'</div></td>'+
            				'<td><div align="center">'+d.contract_end_date+'</div></td>'+
            				
            			  '</tr>'+
            			  
            			'</table>' ;
	            }

					$('#tbl_amc_assigned_subcontractor_list tbody').on('click', 'a', function(){
							var $row = $(this).closest('tr');
							var subcontractor_data = tbl_amc_assigned_subcontractor_list.row($row).data();
							v_amc_subcontractor_ids = subcontractor_data.amc_subcontractor_ids;
							 v_amc_subcontractor_status  = subcontractor_data.amc_subcontractor_status;
							 
							 if($(this).attr("name")=='Edit_data')
							 {
								$("#select_amc_subcontractors").val(subcontractor_data.subcontractor_id).trigger("change");
								$("#txt_contractor_description").val(subcontractor_data.contractor_description);
								$("#txt_contractor_amount").val(subcontractor_data.contract_amount);
								$("#txt_contractor_vat").val(subcontractor_data.contract_vat);
								$("#txt_contractor_total_amount").val(subcontractor_data.contract_total_amount);
								$("#img_preview").show();
								var start_date=subcontractor_data.contract_start_date;
								   
								start_date = start_date.split("-").reverse();
								var tmp = start_date[0];
								//alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
								start_date[0] = start_date[1];
								start_date[1] = start_date[2];
								start_date[2] = tmp;
								start_date = start_date.join("/");
								
								var end_date=subcontractor_data.contract_end_date;
							   
								end_date = end_date.split("-").reverse();
								var tmp = end_date[0];
								//alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
								end_date[0] = end_date[1];
								end_date[1] = end_date[2];
								end_date[2] = tmp;
								end_date = end_date.join("/");
								
								var start_date_end_date=start_date+'-'+end_date;
								
								$("#txt_list_contractor_start_end_date").val(start_date_end_date);
								
								$("#img_preview").html("<img style='width:60px;height:60px;'src='../httpdocs/images/amc_subcontractor_file_upload/"+$.trim(subcontractor_data.file_name)+"'>");
								$('#amc_contractor_file_name').text(subcontractor_data.file_name);
								$( '#btn_assign_subcontractors').hide();
								$( '#btn_edit_assign_subcontractors').show();
				   
							 }
							
							 
							if($(this).attr("name")=='Active')
							{
								var v_subcontractor_action=$(this).attr("name");
								var amcRefNoReasonText = $('#amc_ref_no_sub').text();
								var splitValues = amcRefNoReasonText.split('-');
								var cust_name = splitValues[1];
								var contract_type = splitValues[2];
								var v_status = 'Active';
								
								 $.post("../controller/amc/amc_controller.php",{action:'change_amc_subcontractor_status',v_amc_subcontractor_ids:v_amc_subcontractor_ids,v_amc_subcontractor_status:v_amc_subcontractor_status,v_subcontractor_action:v_subcontractor_action}
									, function(result,status)
									{
									   changeStatusJSONPost('AMC','Activate Subcontractor',v_status,cust_name,contract_type,'Nil',subcontractor_data.amc_number);
									   load_data_to_grid_assign_subcontractor_list(v_amc_id);
									
								});
							}
							if($(this).attr("name")=='Deactive')
							{
								var cust_name = $('#amc_ref_no_sub').text();

								$('#amc_ref_no_reason').html(cust_name); 
							}
							
							if($(this).attr("name")=='delete_data')
							{
								swal({
                                                        
    							title: "Are you sure?",
    							text: "Do you want to Delete This Entry?",
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
									$.post("../controller/amc/amc_controller.php",{action:'delete_amc_subcontractor',v_amc_subcontractor_ids:v_amc_subcontractor_ids}
										, function(result,status)
										{
											if(status=='success')
											{
											   swal("Success", "Deleted successfully..", "success");
											   load_data_to_grid_assign_subcontractor_list(v_amc_id);
											}
									});
								}
								else {
    							}
								});
							}
							
						});	 
						
						
						
			$('#btn_edit_assign_subcontractors').click(function(){
                    
					var v_amc_contractor_id=$("#select_amc_subcontractors option:selected").val();
                    var v_amc_contractor_name=$("#select_amc_subcontractors option:selected").text();
					var v_contractor_description = $('#txt_contractor_description').val();
                    var v_contractor_amount = $('#txt_contractor_amount').val();
					var v_contractor_vat = $('#txt_contractor_vat').val();
					var v_contractor_total_amount = $('#txt_contractor_total_amount').val();
					
					var v_amc_start_end_date=$("#txt_list_contractor_start_end_date").val();
					var res_start_end = v_amc_start_end_date.split("-");
					var v_amc_start_date=$.trim(res_start_end[0]);
					var v_amc_end_date=$.trim(res_start_end[1]);
					v_amc_start_date = v_amc_start_date.split("/").reverse();
					var tmpstart = v_amc_start_date[2];
					v_amc_start_date[2] = v_amc_start_date[1];
					v_amc_start_date[0] = v_amc_start_date[0];
					v_amc_start_date[1] = tmpstart;
					v_amc_start_date = v_amc_start_date.join("-");
					v_amc_end_date = v_amc_end_date.split("/").reverse();
					var tmpend = v_amc_end_date[2];
					v_amc_end_date[2] = v_amc_end_date[1];
					v_amc_end_date[0] = v_amc_end_date[0];
					v_amc_end_date[1] = tmpend;
					v_amc_end_date = v_amc_end_date.join("-");
					
					var amcRefNoReasonText = $('#amc_ref_no_sub').text();
					var splitValues = amcRefNoReasonText.split('-');
					var cust_name = splitValues[1];
					var contract_type = splitValues[2];
					
                    v_session_image = $("#session_image").val();
                    var v_session_image_new = $("#amc_contractor_file_name").text();
                    var randomNum = Math.ceil(Math.random() * 999999);   
					
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
                            upload.doUpload("../httpdocs/user_upload/amc_subcontractor_file_upload.php?random_no="+randomNum);
                            v_session_image=randomNum+'_'+doc_file1;
                        }  
						//alert(v_session_image);
                    if($.trim(v_amc_contractor_id)==="select"||$.trim(v_contractor_amount)===""||$.trim(v_contractor_vat)===""||$.trim(v_contractor_total_amount)===""||v_amc_start_end_date===""||$.trim(v_contractor_description) === "")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        //v_btn_subcontractor_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {         
                         $.post("../controller/amc/amc_controller.php",{action:'update_amc_subcontractor',v_amc_subcontractor_ids:v_amc_subcontractor_ids,v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_contractor_id:v_amc_contractor_id,v_amc_contractor_name:v_amc_contractor_name,v_contractor_description:v_contractor_description,v_session_image:v_session_image,v_contractor_amount:v_contractor_amount,v_contractor_vat:v_contractor_vat,v_contractor_total_amount:v_contractor_total_amount,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date}
                                , function(result,status)
                                {
                                    console.log(result);
                                    
                                   result = $.trim(result);
                               
                                if(result == "0")
                                {
                                    //v_btn_btn_subcontractor_edit.ladda( 'stop' );
                                    swal("Error", result, "error");
                                    clear_text_assigned_sub();
                                }
                                else 
                                {
                                     //v_btn_btn_subcontractor_edit.ladda( 'stop' );
                                    swal("Success", "Subcontractors details updated successfully..", "success");
									
									assignSubJSONPost(document.getElementById('assign_sub_form'),'AMC','Update Subcontractors',v_amc_contractor_name,v_amc_start_end_date,v_amc_ref_no,v_session_image,cust_name,contract_type);
									
                                    load_data_to_grid_assign_subcontractor_list(v_amc_id);
                                    clear_text_assigned_sub();
									$('#btn_edit_assign_subcontractors').hide();
									$('#btn_assign_subcontractors').show();
                                    
                                }
                        });
                        
                     }
                  
                });
				
				function clear_text_assigned_sub()
				{
					$('#txt_contractor_amount').val('');
					$('#txt_contractor_vat').val('');
					$('#txt_contractor_total_amount').val('');
					$("#txt_list_contractor_start_end_date").val();
					$('#txt_contractor_description').val('');
					$('#div_subcontractors_load').load("../view/amc/subcontractor_combo.php");
					$("#session_image").val(null);
					$('.filename').val(null);
					$('.filename').html('');
                    $("#amc_contractor_file_name").empty();
                    $("#img_preview").hide();
				}
				 
				$('#btn_deactive').click(function(){
					var amcRefNoReasonText = $('#amc_ref_no_reason').text();
					var splitValues = amcRefNoReasonText.split('-');
					var amc_ref_no = splitValues[0];
					var cust_name = splitValues[1];
					var contract_type = splitValues[2];
					
					var v_status = 'Deactive';
					var v_txt_deactive_reason = $("#txt_deactive_reason").val();
					//alert(v_amc_subcontractor_ids);
					if($.trim(v_txt_deactive_reason) === '')
					{
						swal("Warning","Please provide reason..","warning");
                        return false;
					}
					else{
						$.post("../controller/amc/amc_controller.php",{action:'deactive_amc_subcontractor_status',v_amc_subcontractor_ids:v_amc_subcontractor_ids,v_txt_deactive_reason:v_txt_deactive_reason}
							, function(result,status)
							{
							   swal("Success","Deactivated Successfully","success");
							   changeStatusJSONPost('AMC','Deactivate Subcontractor',v_status,cust_name,contract_type,v_txt_deactive_reason,amc_ref_no);
							   $('#modal_deactive_reason').modal('hide');
							   load_data_to_grid_assign_subcontractor_list(v_amc_id);
							   $("#txt_deactive_reason").val('');
							
						});
					}
				}); 
				
				
				 $("#btn_renewal_amc").click(function(){
             
                              
                                var v_amc_renewal_signed_date=convertDate($("#txt_amc_renewal_signed_date").val());
                                
                                var v_amc_renewal_start_end_date=$("#txt_amc_renewal_start_end_date").val();
                                var res_start_end = v_amc_renewal_start_end_date.split("-");
                                
                                var v_amc_renewal_start_date=convertDate($.trim(res_start_end[0]));
                                var v_amc_renewal_end_date=convertDate($.trim(res_start_end[1]));
                               
                                var v_amc_renewal_amount = $("#txt_amc_renewal_amount").val();
                                var v_amc_renewal_vat_percentage = $("#txt_vat_renewal_percentage").val();
                                var v_amc_renewal_vat_per_amount=$("#txt_amc_renewal_vat_amount").val();
                                var v_amc_ref_no=$("#txt_amc_ref_no").val();
                                var v_amc_end_date=$("#txt_amc_end_date_renew").val();
                                v_amc_end_date = v_amc_end_date.split("-").reverse().join("-");
                    
                               if($.trim(v_amc_renewal_amount)==''||$.trim(v_amc_renewal_vat_percentage)==''||$.trim(v_amc_renewal_vat_per_amount)==''||$.trim(v_amc_renewal_start_date)==''||$.trim(v_amc_renewal_end_date)==''|| $.trim(v_amc_renewal_signed_date)=='')
                               {
                                   swal("Warning","Please provide all the fields..","warning");
                                   return false;
                               }
                               else if(v_amc_renewal_start_date < v_amc_end_date)
                               {
                                  swal("Warning","The start date will be greater than the end date of last AMC","warning");
                                   return false; 
                               }
                               else
                               {
                                  $.post("../controller/amc/amc_controller.php",{action:"renewal_amc",v_amc_renewal_amount:v_amc_renewal_amount,v_amc_renewal_vat_percentage:v_amc_renewal_vat_percentage,v_amc_renewal_vat_per_amount:v_amc_renewal_vat_per_amount,v_amc_renewal_start_date:v_amc_renewal_start_date,v_amc_renewal_end_date:v_amc_renewal_end_date,v_amc_renewal_signed_date:v_amc_renewal_signed_date,v_amc_ref_no:v_amc_ref_no},function(result,status){
                                     
                                       result = $.trim(result);
                                       
                                       d = JSON.parse(result);
                                      // alert($.trim(d.msg)+' Id '+$.trim(d.p_ids));
									  clear_text_renew(); 
                                     swal({            
										title: "AMC renewed successfully",
										text: "Do you want to proceed with subcontractors !",
										icon: 'warning',
										dangerMode: true,
										allowOutsideClick: false,
										closeOnClickOutside: false,
										buttons: {
										cancel: 'No!',
										 delete: 'Yes'
										},
										}).then(function (willDelete) {
										if (willDelete) {
											
											$('#modal_assign_to_subcontractors_renew').modal('show');
											load_subcontractor_old(v_amc_ref_no);
											load_subcontractor_new(d.msg);
											
											$('#amc_old_ref_no').html(v_amc_ref_no);
											$('#amc_old_ref_no_details').html(v_amc_ref_no+' - '+v_cust_name+' - '+v_contract_type);
											$('#amc_new_ref_no').html(d.msg );
											$('#amc_new_ref_no_details').html(d.msg+' - '+v_cust_name+' - '+v_contract_type);
										
											$("#span_amc_ref_no_new_subcontractor1").html(d.msg);
											$('#span_amc_ref_no_new_subcontractor1_details').html(d.msg+' - '+v_cust_name+' - '+v_contract_type); 
											$('#txt_amc_id').val(d.p_ids);
											$('#txt_amc_id1').val(d.p_ids);
											$('#div_subcontractors_load1').load("../view/amc/subcontractor_combo.php");
											clear_text_renew(); 
											load_data_to_grid_amc_list();
											$('#modal_view_amc_renew').modal('hide');
										}
										else { 
										    load_data_to_grid_amc_list();
										    $('#modal_view_amc_renew').modal('hide');
											load_amc_related_subcontractor_details();
											load_data();
											clear_text_renew(); 
										}
										});
                                      //load_data_to_grid_amc_list();
                                      // $.modal.close();
                                      
                                  });
                               }
                
            })
            
           function clear_text_renew()
           {
               $("#txt_amc_renewal_signed_date").val('');
               $("#txt_amc_renewal_start_end_date").val('');
               $("#txt_amc_renewal_amount").val('');
               $("#txt_vat_renewal_percentage").val('');
               $("#txt_amc_renewal_vat_amount").val('');
           }
		   
		   
		   function formatDate(dateString) {
				var date = new Date(dateString);
				var day = date.getDate();
				var month = date.getMonth() + 1; // Month is zero-based
				var year = date.getFullYear();

				// Add leading zeros if needed
				if (day < 10) {
					day = '0' + day;
				}

				if (month < 10) {
					month = '0' + month;
				}

				return day + '-' + month + '-' + year;
			}
			
			
			function load_data(v_amc_ref_no,v_amc_parent_parent_ref_no)
                 {
                    
                    v_tbl_for_list_renew_amc.destroy();
                         
                     v_tbl_for_list_renew_amc= $('#tbl_for_list_renew_amc').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'renewal_amc_list',
									v_amc_ref_no:v_amc_ref_no,
									v_amc_parent_parent_ref_no:v_amc_parent_parent_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 
                                 { "data": null,"width": "10%"},
								 { "data": "amc_ref_no","width": "15%"},
								 { "data": "amc_start_date","width": "20%",
									render: function(data, type, row) {
										
										return row.amc_start_date + ' - ' + row.amc_end_date;
									}
								 },
								 { "data": "amc_amount","width": "10%",
									render: function(data, type, row) {
										var v_net_amount = parseFloat(data) + parseFloat(row.amc_vat_amt);
										return v_net_amount.toFixed(3);
									}
								 },
								 { "data": "amc_status","width": "10%" ,
									render: function ( data, type, rows, meta ) {
										if(data === 'Completed')
										{
											return str_active_status='<span class="badge badge-success">'+data+'</span>';
										}
										else{
											return str_active_status='<span class="badge badge-primary">'+data+'</span>';
										}
									}
								 },
                             ],
                             pageLength: 50,
            				 searching: true, 
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4] }, 
            					
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
				 
				 
				 $('#tbl_for_list_renew_amc tbody').on('click', 'tr', function(e){
					 var $row = $(this).closest('tr');
				
					$('#tbl_for_list_renew_amc tbody tr').removeClass('selected');
					$row.addClass('selected');
					
					 var data = v_tbl_for_list_renew_amc.row($row).data();
					 amc_ref_no = data.amc_ref_no;
					 load_amc_related_subcontractor_details(amc_ref_no);
				 });
				 
				  function load_amc_related_subcontractor_details(amc_ref_no)
                 {
                    //alert(amc_ref_no);
                    v_tbl_two.destroy();
                         
                     v_tbl_two= $('#tbl_two').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_search_controller.php',
                                 'data': {
                                    action: 'action_view_amc_subcontractors_details',amc_ref_no:amc_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 
                                 { "data": null,"width": "",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
								},
								{ "data": "subcontractor_name","width": "20%"},
                                { "data": "contract_start_date","width": "20%",
									render: function(data, type, row) {
										
										return row.contract_start_date + ' - ' + row.contract_end_date;
									}
								 },
								 
								 { "data": "contract_total_amount","width": "10%" }, 	
								 { "data": "contractor_description"},
                             ],
                             pageLength: 20,
            				 searching: true, 
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                              },
                              "drawCallback": function () {
                                  
                                },
								"footerCallback": function (rows, data, start, end, display) {
                                var api = this.api();
								var intVal = function (i) {
									return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
								};
 
								var total_amount_rec = api
									.column(3, { page: 'current' }) 
									.data()
									.reduce(function (a, b) {
										return intVal(a) + intVal(b);
									}, 0);

								v_tbl_two.column(3).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }
				 
				 
				 
				  function load_subcontractor_old(amc_ref_no)
                 {
                    
                    v_tbl_amc_assigned_subcontractor_list1.destroy();
                         
                     v_tbl_amc_assigned_subcontractor_list1= $('#tbl_amc_assigned_subcontractor_list1').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'amc_subcontractor_list_view_before_renew',v_amc_ref_no:amc_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 // {
                                    // "className":  'details-control',
                                    // "orderable":  false,
                                    // "data":        null,
                                    // "defaultContent": '',
                                    // "width": "5%"
                                    
                                 // },
                                 { "data": null,"width": "",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1;  
                                    }
								},
								{ "data": "subcontractor_name"},
								{ "data": "contract_amount"},
								{ "data": "contract_vat"},
								{ "data": "contract_total_amount"},
								{ "data": "contractor_description"},
								{ "data": "contract_start_date","width": "20%",
									render: function(data, type, row) {
										
										return row.contract_start_date + ' - ' + row.contract_end_date;
									}
								 },
								{ "data": "amc_subcontractor_ids",
								 render: function ( data, type, rows, meta ) {
									return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#" name="Renew"><i class="icon-cross3"></i> Renew </a><a href="../httpdocs/images/amc_subcontractor_file_upload/'+rows["file_name"]+'" target="_blank" class="dropdown-item" name="view_doc"><i class="icon-file-text3"></i> View Doc </a></div>';
								 }
								},
							
                             ],
                             pageLength: 20,
            				 searching: true, 
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                              },
                              "drawCallback": function () {
                                  
                                },
								"footerCallback": function (rows, data, start, end, display) {
                                var api = this.api();
								var intVal = function (i) {
									return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
								};

								var total_amount_rec = api
									.column(4, { page: 'current' })
									.data()
									.reduce(function (a, b) {
										return intVal(a) + intVal(b);
									}, 0);

								v_tbl_amc_assigned_subcontractor_list1.column(4).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }  
				 
				
				
				$('#tbl_amc_assigned_subcontractor_list1 tbody').on('click', 'a', function(){
							var $row = $(this).closest('tr');
							var subcontractor_data = v_tbl_amc_assigned_subcontractor_list1.row($row).data();
							v_amc_subcontractor_ids = subcontractor_data.amc_subcontractor_ids;
							v_amc_ref_no = subcontractor_data.amc_number;
							 v_amc_subcontractor_status  = subcontractor_data.amc_subcontractor_status;
							 $("#img_preview").show();
							 if($(this).attr("name")=='Renew')
							 {
								$('#div_subcontractor_content').show();
								$('#btn_assign_subcontractors_renew1').show();
								$('#btn_exit_assign_subcontractor_renew').show();
								$("#select_amc_subcontractors").val(subcontractor_data.subcontractor_id).trigger("change");
								$("#txt_contractor_description1").val(subcontractor_data.contractor_description);
								$("#txt_contractor_amount1").val(subcontractor_data.contract_amount);
								$("#txt_contractor_vat1").val(subcontractor_data.contract_vat);
								$("#txt_contractor_total_amount1").val(subcontractor_data.contract_total_amount);
								
								var start_date=subcontractor_data.contract_start_date;
								   
								start_date = start_date.split("/").reverse();
								var tmp = start_date[0];
								//alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
								start_date[0] = start_date[1];
								start_date[1] = start_date[2];
								start_date[2] = tmp;
								start_date = start_date.join("/");
								
								var end_date=subcontractor_data.contract_end_date;
							   
								end_date = end_date.split("/").reverse();
								var tmp = end_date[0];
								//alert( signed_date[2]+'-' +signed_date[1]+''+ signed_date[0])
								end_date[0] = end_date[1];
								end_date[1] = end_date[2];
								end_date[2] = tmp;
								end_date = end_date.join("/");
								
								var start_date_end_date=start_date+'-'+end_date;
								
								$("#txt_list_contractor_start_end_date1").val(start_date_end_date);
								
								$("#img_preview1").html("<img style='width:60px;height:60px;'src='../httpdocs/images/amc_subcontractor_file_upload/"+$.trim(subcontractor_data.file_name)+"'>");
								$('#amc_contractor_file_name1').text(subcontractor_data.file_name);
								// $( '#btn_assign_subcontractors_renew1').hide();
								// $( '#btn_edit_assign_subcontractor_renew1').show();
				   
							 }
							
							 
							// if($(this).attr("name")=='Active' || $(this).attr("name")=='Deactive')
							// {
								 // var v_subcontractor_action=$(this).attr("name");
								 // $.post("../controller/amc/amc_controller.php",{action:'change_amc_subcontractor_status',v_amc_subcontractor_ids:v_amc_subcontractor_ids,v_amc_subcontractor_status:v_amc_subcontractor_status,v_subcontractor_action:v_subcontractor_action}
									// , function(result,status)
									// {
									   
									   // load_subcontractor(v_amc_ref_no);
									
								// });
							// }
							
							
						});	

			function load_subcontractor_new(amc_ref_no)
                 {
                    
                    v_tbl_amc_assigned_subcontractor_list1_new.destroy();
                         
                     v_tbl_amc_assigned_subcontractor_list1_new= $('#tbl_amc_assigned_subcontractor_list1_new').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'amc_subcontractor_list_view_before_renew',v_amc_ref_no:amc_ref_no
                                    
                                 }
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                          //  "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
            				
            			
                            "columns": [
                                 // {
                                    // "className":  'details-control',
                                    // "orderable":  false,
                                    // "data":        null,
                                    // "defaultContent": '',
                                    // "width": "5%"
                                    
                                 // },
                                 { "data": null,"width": "",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1;  
                                    }
								},
								{ "data": "subcontractor_name"},
								{ "data": "contract_amount"},
								{ "data": "contract_vat"},
								{ "data": "contract_total_amount"},
								{ "data": "contractor_description"},
								{ "data": "contract_start_date","width": "20%",
									render: function(data, type, row) {
										
										return row.contract_start_date + ' - ' + row.contract_end_date;
									}
								 },
								{ "data": "amc_subcontractor_ids",
								 render: function ( data, type, rows, meta ) {
									return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#" name="delete_data"><i class="icon-cross3"></i> Delete </a><a href="../httpdocs/images/amc_subcontractor_file_upload/'+rows["file_name"]+'" target="_blank" class="dropdown-item" name="view_doc"><i class="icon-file-text3"></i> View Doc </a></div>';
								 }
								},
							
                             ],
                             pageLength: 20,
            				 searching: true, 
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4] }, 
            					
            				],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                               
             
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                              },
                              "drawCallback": function () {
                                  
                                },
								"footerCallback": function (rows, data, start, end, display) {
                                var api = this.api();
								var intVal = function (i) {
									return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
								};

								var total_amount_rec = api
									.column(4, { page: 'current' })
									.data()
									.reduce(function (a, b) {
										return intVal(a) + intVal(b);
									}, 0);

								v_tbl_amc_assigned_subcontractor_list1_new.column(4).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 } 

			$('#tbl_amc_assigned_subcontractor_list1_new tbody').on('click', 'a', function(){
				var $row = $(this).closest('tr');
				var subcontractor_data = v_tbl_amc_assigned_subcontractor_list1_new.row($row).data();
				v_amc_subcontractor_ids = subcontractor_data.amc_subcontractor_ids;
					
					var v_amc_new_no = $('#amc_new_ref_no').text();
							
						 if($(this).attr("name")=='delete_data')
						 {
							swal({
                                                        
							title: "Are you sure?",
							text: "Do you want to Delete This Entry?",
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
								$.post("../controller/amc/amc_controller.php",{action:"delete_amc_subcontractor",v_amc_subcontractor_ids:v_amc_subcontractor_ids},function(result,status){
									if(status=='success')
									{
									   swal("Success", "Deleted successfully..", "success");
									   load_subcontractor_new(v_amc_new_no);
									}
									
								});
							}
							});
						 	
						 }								 
			});							
			
            
				 

			$("#txt_contractor_vat1").change(function() {
                var v_txt_contractor_amount=$("#txt_contractor_amount1").val();
				var vat = $("#txt_contractor_vat1").val();
				
                    var txt_vat_amount=v_txt_contractor_amount * (parseFloat(vat)/100);
                    var total_amount=(parseFloat(txt_vat_amount)+parseFloat($("#txt_contractor_amount1").val()));
                    $("#txt_contractor_total_amount1").val((total_amount.toFixed(3)));
                    //alert(v_txt_contractor_amount+' '+vat+' '+txt_vat_amount+' '+total_amount);
               });
			   
			   $("#txt_contractor_amount1").change(function() {
                var v_txt_contractor_amount=$("#txt_contractor_amount1").val();
				var vat = $("#txt_contractor_vat1").val();
				
                    var txt_vat_amount=v_txt_contractor_amount * (parseFloat(vat)/100);
                    var total_amount=(parseFloat(txt_vat_amount)+parseFloat($("#txt_contractor_amount1").val()));
                    $("#txt_contractor_total_amount1").val((total_amount.toFixed(3)));
                    //alert(v_txt_contractor_amount+' '+vat+' '+txt_vat_amount+' '+total_amount);
               });


							
				$('#btn_assign_subcontractors_renew1').click(function(){
					
					var v_amc_contractor_id=$("#select_amc_subcontractors option:selected").val();
                    var v_amc_contractor_name=$("#select_amc_subcontractors option:selected").text();
					var v_contractor_description = $('#txt_contractor_description1').val();
					var v_contractor_amount = $('#txt_contractor_amount1').val();
					var v_contractor_vat = $('#txt_contractor_vat1').val();
					var v_contractor_total_amount = $('#txt_contractor_total_amount1').val();
					var v_amc_ref_no = $("#span_amc_ref_no_new_subcontractor1").text();
					var v_amc_id = $('#txt_amc_id1').val();
					var v_amc_ref_no_old=$("#amc_old_ref_no").text();
					
					var v_amc_start_end_date=$("#txt_list_contractor_start_end_date1").val();
					var res_start_end = v_amc_start_end_date.split("-");
					var v_amc_start_date=$.trim(res_start_end[0]);
					var v_amc_end_date=$.trim(res_start_end[1]);
					v_amc_start_date = v_amc_start_date.split("/").reverse();
					var tmpstart = v_amc_start_date[2];
					v_amc_start_date[2] = v_amc_start_date[1];
					v_amc_start_date[0] = v_amc_start_date[0];
					v_amc_start_date[1] = tmpstart;
					v_amc_start_date = v_amc_start_date.join("-");
					v_amc_end_date = v_amc_end_date.split("/").reverse();
					var tmpend = v_amc_end_date[2];
					v_amc_end_date[2] = v_amc_end_date[1];
					v_amc_end_date[0] = v_amc_end_date[0];
					v_amc_end_date[1] = tmpend;
					v_amc_end_date = v_amc_end_date.join("-");
					
					v_session_image = $("#session_image1").val();
                    randomNum = Math.ceil(Math.random() * 999999);   
                    
                        if(v_session_image==="")
                        {
                            v_session_image="default.jpg";
                        }
                        else
                        {
                            var doc_file_obj = $("#session_image")[0].files[0];
                            var upload = new ns.Upload(doc_file_obj);
                            doc_file1= doc_file_obj.name;
                             doc_file1 = doc_file1.replace(/[^a-zA-Z0-9._-]/g, "_");
                            upload.doUpload("../httpdocs/user_upload/amc_subcontractor_file_upload.php?random_no="+randomNum);
                            v_session_image=$.trim(randomNum+'_'+doc_file1);
                        }  
						
					if($.trim(v_amc_contractor_id)==="select"||$.trim(v_contractor_amount)===""||$.trim(v_contractor_vat)===""||$.trim(v_contractor_total_amount)===""||v_amc_start_end_date===""||$.trim(v_contractor_description) === "")
                    
                    {
                        swal("Warning","Please provide all the details ....", "warning");
                        //v_btn_subcontractor_add.ladda( 'stop' );
                        return false;
                    }
                   
                    else
                    {     
                       
                         $.post("../controller/amc/amc_controller.php",{action:'assign_subcontractor',v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_contractor_id:v_amc_contractor_id,v_amc_contractor_name:v_amc_contractor_name,v_contractor_description:v_contractor_description,v_session_image:v_session_image,v_contractor_amount:v_contractor_amount,v_contractor_vat:v_contractor_vat,v_contractor_total_amount:v_contractor_total_amount,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date}
                                , function(result,status)
                                {
                                    console.log(result);
									result = $.trim(result);
                               
                                if(result=="")
                                {
                                    //v_btn_subcontractor_add.ladda( 'stop' );
                                    swal("Error", result, "error");
                                   
                                    clear_text_assigned();
                                   
                                }
                                else 
                                {
                                    //v_btn_subcontractor_add.ladda( 'stop' );
                                     swal("Success", "Subcontractor assigned successfully..", "success");
                                     load_subcontractor_old(v_amc_ref_no_old);
									 load_subcontractor_new(v_amc_ref_no);
									 $('#div_subcontractor_content').hide();
									 $('#btn_assign_subcontractors_renew1').hide();
									 $('#btn_exit_assign_subcontractor_renew').hide();
                                     clear_text_assigned();
                                     //location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
					
				});	
				
				
				
			

				function clear_text_assigned()
				{
					$('#txt_contractor_amount1').val('');
					$('#txt_contractor_vat1').val('');
					$('#txt_contractor_total_amount1').val('');
					$('#txt_contractor_description1').val('');
					$("#txt_list_contractor_start_end_date1").val();
					$('#div_subcontractors_load1').load("../view/amc/subcontractor_combo.php");
					$("#session_image1").val(null);
					$('.filename').val(null);
					$('.filename').html('');
                    $("#amc_contractor_file_name1").empty();
                    $("#img_preview1").hide();
				}				
					
					
					$('#btn_exit_assign_subcontractor_renew').click(function(){
						$('#div_subcontractor_content').hide();
						$('#btn_assign_subcontractors_renew1').hide();
						$('#btn_exit_assign_subcontractor_renew').hide();
					});
					
					 
		function JSONPost(formName,moduleName,event,v_amc_cust_code,v_amc_cust_name,v_amc_contract_type_name,amcNumber,v_first_attachment,v_second_attachment,v_third_attachment,v_amc_is_rfp,v_total_payable_amt)
		{
			var formData = new FormData(formName);
				formData.append('module', moduleName);
				formData.append('event', event);
				formData.append('amc_ref_no', amcNumber);
				formData.append('first_attachment', v_first_attachment);
				formData.append('second_attachment', v_second_attachment);
				formData.append('third_attachment', v_third_attachment);
				formData.append('RFP', v_amc_is_rfp);
				formData.append('total_amount', v_total_payable_amt);
				formData.append('customer_code', v_amc_cust_code);
				formData.append('customer_name', v_amc_cust_name);
				formData.append('contract_type', v_amc_contract_type_name);
				formData.append('action', 'amc_log');
		
			
			$.ajax({
				type: 'POST',
				url: '../controller/amc/amc_controller.php',
				data: formData,
				contentType: false, // Ensure that the content type is set to false for FormData
				processData: false, // Prevent jQuery from processing the data
				success: function (response) {
					console.log(response); // Display a success message or handle as needed
					location.reload();
				},
				error: function (error) {
					console.log(error);
					console.log('Error inserting data'); // Display an error message
				}
			});
		}
		
		 function changeStatusJSONPost(moduleName,event,v_amc_status,cust_name,contract_type,v_amc_staus_description,amcNumber)
			{
				var formData = new FormData();
					formData.append('module', moduleName);
					formData.append('event', event);
					formData.append('amc_ref_no', amcNumber);
					formData.append('Status', v_amc_status);
					formData.append('Description', v_amc_staus_description);
					formData.append('Customer_name', cust_name);
					formData.append('Contract Type', contract_type);
					formData.append('action', 'amc_log');
			
				
				$.ajax({
					type: 'POST',
					url: '../controller/amc/amc_controller.php',
					data: formData,
					contentType: false, // Ensure that the content type is set to false for FormData
					processData: false, // Prevent jQuery from processing the data
					success: function (response) {
						console.log(response); // Display a success message or handle as needed
					},
					error: function (error) {
						console.log(error);
						console.log('Error inserting data'); // Display an error message
					}
				});
			}
			
			function assignSubJSONPost(formName,moduleName,event,v_amc_contractor_name,v_amc_start_end_date,amcNumber,v_session_image,cust_name,contract_type)
				{
					var formData = new FormData(formName);
						formData.append('module', moduleName);
						formData.append('event', event);
						formData.append('amc_ref_no', amcNumber);
						formData.append('Subcontractor Name', v_amc_contractor_name);
						formData.append('Date', v_amc_start_end_date);
						formData.append('Subcontractor File', v_session_image);
						formData.append('Customer_name', cust_name);
						formData.append('Contract Type', contract_type);
						formData.append('action', 'amc_log');
				
					
					$.ajax({
						type: 'POST',
						url: '../controller/amc/amc_controller.php',
						data: formData,
						contentType: false, // Ensure that the content type is set to false for FormData
						processData: false, // Prevent jQuery from processing the data
						success: function (response) {
							console.log(response); // Display a success message or handle as needed
						},
						error: function (error) {
							console.log(error);
							console.log('Error inserting data'); // Display an error message
						}
					});
				}
	});