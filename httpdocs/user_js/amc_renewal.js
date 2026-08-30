$(document).ready(function(){

   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
   var v_amc_list_table = $('#tbl_amc_list').DataTable({});  
   var v_list_of_amc_subcontractors = $('#tbl_of_amc_subcontractors_details').DataTable({});     
   var v_tbl_for_list_renew_amc = $('#tbl_for_list_renew_amc').DataTable({});    
   var v_tbl_amc_assigned_subcontractor_list = $('#tbl_amc_assigned_subcontractor_list').DataTable({});   
   var v_tbl_amc_assigned_subcontractor_list_new = $('#tbl_amc_assigned_subcontractor_list_new').DataTable({});    
   var v_tbl_two = $('#tbl_two').DataTable({}); 
   $('#btn_assign_subcontractors_renew').hide();
   
   $('#btn_exit_assign_subcontractor_renew').hide();
   $('#btn_test').hide();
   $('#div_subcontractor_content').hide();
   load_data_to_grid_amc_list();
//load data to amc_list table

                    $("#btn_amc_renewal_search").click(function(){
                        var search_date=$("#txt_end_date").val();
                        var search_date = new Date(search_date);
                        var dd = String(search_date.getDate()).padStart(2, '0');
                        var mm = String(search_date.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = search_date.getFullYear();
                         search_date = yyyy + '-' + mm + '-' + dd; 
                          load_data_to_grid_amc_list_search(search_date);
                      })
                     
                function load_data_to_grid_amc_list_search(search_date)
                 {
                    var i=1; 
                     
                    v_amc_list_table.destroy();
                         
                     v_amc_list_table = $('#tbl_amc_renewal_list').DataTable( {
                           		
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_renewal/amc_renewal_controller.php',
                                 'data': {
                                    action: 'amc_renewal_list_search',
                                    search_date:search_date
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
            			    "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction',
                                        exportOptions: {
                                            columns: [1,2,5,6,7,8,9,11,12,13,14]  
                                        },
										filename: 'List of AMC Renewal',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
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
                                    }
                                ],
            		
            	
                            "columns": [
                               
                                 { "data": null},
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "amc_ref_no","className":"text-center","visible":false ,
                                     render: function ( data, type, rows, meta ) {
                                         retun_qr_code = '<img src="../httpdocs/qr_lib/asset_qr/amc_renew_qr/'+data+'.png"/>';
								         return retun_qr_code;
                                     }
                                 },
                                 { "data": "customer_name"},
                                 { "data": "contract_type_name"},
                                 { "data": "amc_signed_date"},
                                 
                                 { "data": "amc_start_date",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_start_date']+'  -  '+rows['amc_end_date_format'];
                                          return str_amc_date;
                                          
                                      }   
                                 },
                               
                                 { "data": "amc_status",
                                      render: function ( data, type, rows, meta ) {
                                          var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['amc_end_date'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          } 
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['amc_end_date']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
                                     
                                          
                                      }     
                                 },
                                 
                                  { "data": "amc_ id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                         
                                          return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_amc_renew" name="renew_amc"><i class="icon-reload-alt"></i> Renew</a><a href="#" class="dropdown-item" data-toggle="" data-target="#" name="renew_amc_complete"><i class="icon-task"></i> Complete</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a></div></div></div>';
                                        
                                      }   
                                 },
                                 
                                 { "data": "amc_amount","visible":false },
                                 { "data": "amc_vat_perct","visible":false },
                                 { "data": "amc_vat_perct","visible":false,
                                    render: function ( data, type, rows, meta )
                                    {
                                       var netAmount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                       return '<span>'+netAmount+'</span>';
                                    }
                                 },
                                 { "data": "amc_description","visible":false }
                             ],
                             pageLength: 10,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [0,1,2,3,4,5,6,7,8] }, 
            					
            				],
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
                      
                 function load_data_to_grid_amc_list()
                 {
                     var i=1;  
                    v_amc_list_table.destroy();
                         
                     v_amc_list_table = $('#tbl_amc_renewal_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_renewal/amc_renewal_controller.php',
                                 'data': {
                                    action: 'amc_renewal_list'
                                    
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
            				"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button exportToExcelAction',
                                        exportOptions: {
                                            columns: [1,2,5,6,7,8,9,11,12,13,14] 
                                        },
										filename: 'List of AMC Renewal',
										customize: function(xlsx) {
											var sheet = xlsx.xl.worksheets['sheet1.xml'];
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
                                    }
                                ],
            				
            			
                            "columns": [
                               
                                 { "data": null},
                                 { "data": "amc_id","visible":false },
                                 { "data": "amc_ref_no","visible":false },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "amc_ref_no","className":"text-center","visible":false ,
                                     render: function ( data, type, rows, meta ) {
                                         retun_qr_code = '<img src="../httpdocs/qr_lib/asset_qr/amc_renew_qr/'+data+'.png"/>';
								         return retun_qr_code;
                                     }
                                 },
                                 { "data": "customer_name"},
                                 { "data": "contract_type_name"},
                                 { "data": "amc_signed_date"},
                                 
                                 { "data": "amc_start_date",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_start_date']+'  -  '+rows['amc_end_date_format'];
                                          return str_amc_date;
                                          
                                      }   
                                 },
                               
                                 { "data": "amc_status",
                                      render: function ( data, type, rows, meta ) {
                                          var today = new Date();
                                            var dd = String(today.getDate()).padStart(2, '0');
                                            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                            var yyyy = today.getFullYear();
                                            
                                            today = yyyy + '-' + mm + '-' + dd;
                                          if(rows['amc_end_date'] < today)
                                          {
                                          str_active_status='<span class="badge badge-danger">Expired</span>'
                                          }
                                         
                                          else
                                          {
                                              var startDay = new Date(today);
                                             var endDay = new Date(rows['amc_end_date']);
                                             var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                        
                                             var millisBetween = endDay.getTime() - startDay.getTime();
                                             var days = millisBetween / millisecondsPerDay;
                                        
                                          str_active_status='<span class="badge badge-primary">Expiring After '+Math.floor(days)+' Days</span>'   
                                          }
                                     	return str_active_status;
                                     
                                          
                                      }   
                                 },
                                 { "data": "amc_id","className":"text-center", 
                                      render: function ( data, type, rows, meta ) {
                                         
                                           //return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_amc_renew"><i class="icon-reload-alt"></i> Renew</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-arrow-right7"></i> View Subcontractors</a></div></div></div>';
                                          return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_view_amc_renew" name="renew_amc"><i class="icon-reload-alt" ></i> Renew</a><a href="#" class="dropdown-item" data-toggle="" data-target="#" name="renew_amc_complete"><i class="icon-task"></i> Complete</a><a href="#" class="dropdown-item" name="view_amc_subcontractors_details" data-toggle="modal" data-target="#modal_view_amc_subcontractors_details" style="color:black"><i class="icon-users"></i> View Subcontractors</a><a href="#" class="dropdown-item" name="renew_amc_report" data-toggle="" data-target="#" style="color:black"><i class="icon-printer2"></i> Report</a><div class="dropdown-divider"></div><a href="../printpdf/qr_code/generate_amc_qr.php?amc_ref_no='+rows['amc_ref_no']+'&amc_id=' + rows['amc_id'] + '" class="dropdown-item" name="" data-toggle="" data-target="#" style="color:black" target="_blank"><i class="icon-qrcode"></i> QR Customer Feedback</a></div></div></div>';
                                        
                                      }   
                                 },
                                 
                                 { "data": "amc_amount","visible":false },
                                 { "data": "amc_vat_perct","visible":false },
                                 { "data": "amc_vat_perct","visible":false,
                                    render: function ( data, type, rows, meta )
                                    {
                                       var netAmount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                       return '<span>'+netAmount+'</span>';
                                    }
                                 },
                                 { "data": "amc_description","visible":false }
                                 
                                 
                       
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
                 
                 
                  $('#tbl_amc_renewal_list tbody').on('click', 'tr', function(e){
                        if($('.popoverButton').length>1)
                            $('.popoverButton').popover('hide');
                            $(e.target).popover('toggle'); 
                      
                  })
             
               var v_amc_parent_parent_ref_no,amc_ref_no,v_customer_name,v_contract_type;
                $('#tbl_amc_renewal_list tbody').on('click', 'a', function(e){
                        var $row = $(this).closest('tr');
                        var data = v_amc_list_table.row($row).data();
                        v_amc_id  = data.amc_id;
                        v_amc_ref_no  = data.amc_ref_no;
						v_customer_name = data.customer_name;
						v_contract_type = data.contract_type_name;
                        
                        $("#txt_amc_ref_no").val(v_amc_ref_no);
                         if($(this).attr("name")=='amc_change_status')
                         {
                           $("#txt_amc_ref_no").val(v_amc_ref_no); 
                             $("#amc_no_view_head").html("Change Status [AMC No : <b>"+v_amc_ref_no+"</b>]");
                             
                         }
                         
                         if($(this).attr("name")=='view_amc_subcontractors_details')
						 {
							
						   $('#span_amc_ref_no1').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name); 
                           load_data_to_grid_amc_subcontractors_details(data.amc_ref_no);
						 } 
						 if($(this).attr("name")=='renew_amc')
						 {
							
						   $('#span_amc_renew_ref_no').html(data.amc_ref_no+' - '+data.customer_name+' - '+data.contract_type_name);
						   $('#txt_amc_parent_parent_ref_no').val(data.amc_parent_parent_ref_no);
						   $('#txt_amc_signed_date').val(data.amc_signed_date);
						   $('#txt_amc_start_date').val(data.amc_start_date);
						   
						   var originalDate = data.amc_end_date;
							var parts = originalDate.split('-');
							var formattedDate = parts[2] + '/' + parts[1] + '/' + parts[0];
						   $('#txt_amc_end_date').val(formattedDate);
						   
						   $('#txt_amc_amount').val(data.amc_amount); 
						   $('#txt_amc_vat').val(data.amc_vat_perct);
						   
						   
						   var net_amount = (parseFloat(data.amc_amount) + parseFloat(data.amc_vat_amt)).toFixed(3);
						   $('#txt_amc_vat_amount').val(net_amount);
						   
						   v_amc_parent_parent_ref_no = data.amc_parent_parent_ref_no;
						   load_data(v_amc_ref_no,v_amc_parent_parent_ref_no);
						   load_amc_related_subcontractor_details();
						 }
						 
						 if($(this).attr("name")=='renew_amc_complete')
						 {
							swal({            
								title: "Do you want to change the status of AMC to Completed !",
								text: "Are you sure!",
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
									$.post("../controller/amc/amc_controller.php",{action:"renew_complete_status",v_amc_ref_no:v_amc_ref_no},function(result,status){
										swal("Completed!", "", "success");
										
									});
									
								} 
								else {
									
								}
								}); 
						 }
						 
						 
						 if($(this).attr("name")=='renew_amc_report')
						 {
							var filePath='amc_print.php?v_amc_ref_no='+v_amc_ref_no;
	    
							window.open(filePath, '_blank'); 
						 }
						 
						 
						 
                         
                       
                });
				
				
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
					 load_amc_related_subcontractor_details(amc_ref_no)
				 });
				
				
				function load_data_to_grid_amc_subcontractors_details(amc_ref_no)
                 {
                    
                    v_list_of_amc_subcontractors.destroy();
                         
                     v_list_of_amc_subcontractors= $('#tbl_of_amc_subcontractors_details').DataTable( {
                           
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
                                 
                                 { "data": null,"width": "5%",
                                    "render": function (data, type, row, meta) {
                                        return meta.row + 1; 
                                    }
								},
                                
								 { "data": "subcontractor_name","width": "15%"},
								 { "data": "contract_amount"},
								 { "data": "contract_vat","width": "10%"},
								 { "data": "contract_total_amount","width": "10%" },
                                 { "data": "contract_start_date","width": "15%",
								 render: function(data, type, row) {
										 
										return row.contract_start_date + ' - ' + row.contract_end_date;
									}
								 },
								 { "data": "file_name","width": "20%",
								  render: function ( data, type, rows, meta ) {
									  
                                          return '<div align="left"><a href="../httpdocs/images/amc_subcontractor_file_upload/'+data+'" target = "_blank" height="50px" width="50px">View Doc</a></div>';
									 },
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

								v_list_of_amc_subcontractors.column(4).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }
				 
				 
				 function load_amc_related_subcontractor_details(amc_ref_no)
                 {
                    
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
                 
               
	
				  
 //Renew AMC
    
                //  $("#txt_amc_renewal_start_end_date").change(function(){
                  
                //     var v_amc_renewal_start_end_date=$("#txt_amc_renewal_start_end_date").val();
                //     var res_start_end = v_amc_renewal_start_end_date.split("-");
                    
                //     var v_amc_renewal_start_date=convertDate($.trim(res_start_end[0]));
                //     var v_amc_renewal_end_date=convertDate($.trim(res_start_end[1]));
                    
                //     var v_amc_end_date=$("#txt_amc_end_date_renew").val();
                //     v_amc_end_date = v_amc_end_date.split("-").reverse().join("-");
                //   alert(v_amc_end_date);
                //   alert(v_amc_renewal_start_end_date);
                //     if(v_amc_renewal_start_date<=v_amc_renewal_end_date)
                //     {
                //       swal("Warning","Please select correct end date...","warning");
                //         return false;  
                //     }
                   
                //     if(v_amc_renewal_start_date < v_amc_end_date)
                //     {
                //         swal("Warning","The start date will be greater than the end date of last AMC","warning");
                //         return false;
                //     }
                //  })
    
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
                                //alert(v_amc_ref_no);
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
											// $.post("../controller/amc/amc_controller.php",{action:"add_amc_sub_renew",v_amc_ref_no:d.msg,v_amc_id:d.p_ids,v_old_amc_ref_no:v_amc_ref_no},function(result,status){
												
												
											// });
											$('#modal_assign_to_subcontractors_renew').modal('show');
											load_subcontractor_old(v_amc_ref_no);
											load_subcontractor_new(d.msg);
											//alert(v_amc_ref_no)
											
											$('#amc_old_ref_no').html(v_amc_ref_no);
											$('#amc_old_ref_no_details').html(v_amc_ref_no+' - '+v_customer_name+' - '+v_contract_type);
											$('#amc_new_ref_no').html(d.msg);
											$('#amc_new_ref_no_details').html(d.msg+' - '+v_customer_name+' - '+v_contract_type); 
											
											$("#span_amc_ref_no_new_subcontractor").html(d.msg);
											$('#span_amc_ref_no_new_subcontractor_details').html(d.msg+' - '+v_customer_name+' - '+v_contract_type);
											$('#txt_amc_id').val(d.p_ids);
											$('#div_subcontractors_load').load("../view/amc/subcontractor_combo.php");
											//clear_text_renew();
											load_data_to_grid_amc_list();
										} 
										else {
											location.reload();
										}
										});
                                      // load_data_to_grid_amc_list();
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
            
	
               
       
              $("#btn_amc_new").click(function(){
				location.reload();
	           });   
			   
			   
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
			
			
			
             function load_subcontractor_old(amc_ref_no)
                 {
                    //alert(amc_ref_no);
                    v_tbl_amc_assigned_subcontractor_list.destroy();
                         
                     v_tbl_amc_assigned_subcontractor_list= $('#tbl_amc_assigned_subcontractor_list').DataTable( {
                           
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
								// { "data": "amc_subcontractor_status",
								  // render: function ( data, type, rows, meta ) {
									  // if(data=='Active')
									  // {
									  // str_active_status='<span class="badge badge-success">'+data+'</span>'
									  // }
									 
									  // else
									  // {
									  // str_active_status='<span class="badge badge-danger">'+data+'</span>'   
									  // }
									// return str_active_status;
		
									 // },
                                 // },
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

								v_tbl_amc_assigned_subcontractor_list.column(4).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }  
				 
				 function load_subcontractor_new(v_amc_ref_no)
                 {
                    //alert(v_amc_ref_no);
                    v_tbl_amc_assigned_subcontractor_list_new.destroy();
                         
                     v_tbl_amc_assigned_subcontractor_list_new= $('#tbl_amc_assigned_subcontractor_list_new').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: 'amc_subcontractor_list_view_before_renew',v_amc_ref_no:v_amc_ref_no
                                    
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
								// { "data": "amc_subcontractor_status",
								  // render: function ( data, type, rows, meta ) {
									  // if(data=='Active')
									  // {
									  // str_active_status='<span class="badge badge-success">'+data+'</span>'
									  // }
									 
									  // else
									  // {
									  // str_active_status='<span class="badge badge-danger">'+data+'</span>'   
									  // }
									// return str_active_status;
		
									 // },
                                 // },
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

								v_tbl_amc_assigned_subcontractor_list_new.column(4).footer().innerHTML = total_amount_rec.toFixed(3);
                                }
                            
                     });  
                
                 }  
				 
				 
				 
				 $('#tbl_amc_assigned_subcontractor_list_new tbody').on('click', 'a', function(){
					var $row = $(this).closest('tr');
					var subcontractor_data = v_tbl_amc_assigned_subcontractor_list_new.row($row).data();
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

			// $('#tbl_amc_assigned_subcontractor_list tbody').on('click', 'td.details-control', function () {
                    // var tr = $(this).closest('tr');
                    // var row = v_tbl_amc_assigned_subcontractor_list.row( tr );
                   
                    // if ( row.child.isShown() ) {
                        
                        // row.child.hide();
                        // tr.removeClass('shown');
                    // }
                    // else {
                   
                        // row.child( format_subcontractors(row.data()) ).show();
                        // tr.addClass('shown');
                       
                         
                    // }
                // } );
        
                 // function format_subcontractors(d)
	               	// {
		
            			// return '<table style="table-layout: fixed; width: 100%; word-wrap: break-word;">'+
            			 // '<tr style="background: #989898;color:#ffffff;">'+
            			    
							// '<td ><div align="center">Description</div></td>'+
            				// '<td ><div align="center">Start Date</div></td>'+
            				// '<td ><div align="center">End Date</div></td>'+
            			
            			  // '</tr>'+
            			  // '<tr>'+
            				
							// '<td><div align="center">'+d.contractor_description+'</div></td>'+
            				// '<td><div align="center">'+d.contract_start_date+'</div></td>'+
            				// '<td><div align="center">'+d.contract_end_date+'</div></td>'+
            				
            			  // '</tr>'+
            			  
            			// '</table>' ;
	            // }
				
				$('#tbl_amc_assigned_subcontractor_list tbody').on('click', 'a', function(){
							var $row = $(this).closest('tr');
							var subcontractor_data = v_tbl_amc_assigned_subcontractor_list.row($row).data();
							v_amc_subcontractor_ids = subcontractor_data.amc_subcontractor_ids;
							v_amc_ref_no = subcontractor_data.amc_number;
							 v_amc_subcontractor_status  = subcontractor_data.amc_subcontractor_status;
							
							 if($(this).attr("name")=='Renew')
							 {
								$('#div_subcontractor_content').show();
								$('#btn_assign_subcontractors_renew').show();
								$('#btn_exit_assign_subcontractor_renew').show();
								$("#select_amc_subcontractors").val(subcontractor_data.subcontractor_id).trigger("change");
								$("#txt_contractor_description").val(subcontractor_data.contractor_description);
								$("#txt_contractor_amount").val(subcontractor_data.contract_amount);
								$("#txt_contractor_vat").val(subcontractor_data.contract_vat);
								$("#txt_contractor_total_amount").val(subcontractor_data.contract_total_amount);
								 $("#img_preview").show();
								
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
								//alert(start_date+ ' '+end_date+' '+start_date_end_date);
								$("#txt_list_contractor_start_end_date").val(start_date_end_date);
								
								$("#img_preview").html("<img style='width:60px;height:60px;'src='../httpdocs/images/amc_subcontractor_file_upload/"+$.trim(subcontractor_data.file_name)+"'>");
								$('#amc_contractor_file_name').text(subcontractor_data.file_name);
								// $( '#btn_assign_subcontractors_renew').hide();
								// $( '#btn_edit_assign_subcontractor_renew').show();
				   
							 }
							
							 
							// if($(this).attr("name")=='Renew')
							// {
								
							// }
							
							
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


							
				$('#btn_assign_subcontractors_renew').click(function(){
					 
					var v_amc_contractor_id=$("#select_amc_subcontractors option:selected").val();
                    var v_amc_contractor_name=$("#select_amc_subcontractors option:selected").text();
					var v_contractor_description = $('#txt_contractor_description').val();
					var v_contractor_amount = $('#txt_contractor_amount').val();
					var v_contractor_vat = $('#txt_contractor_vat').val();
					var v_contractor_total_amount = $('#txt_contractor_total_amount').val();
					var v_amc_ref_no = $("#span_amc_ref_no_new_subcontractor").text();
					var v_amc_id = $('#txt_amc_id').val();
					var v_amc_ref_no_old=$("#amc_old_ref_no").text();
					
					//alert(v_amc_id+' '+v_amc_ref_no);
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
                       
                         $.post("../controller/amc/amc_controller.php",{action:'renew_assign_subcontractor',v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_contractor_id:v_amc_contractor_id,v_amc_contractor_name:v_amc_contractor_name,v_contractor_description:v_contractor_description,v_session_image:v_session_image,v_contractor_amount:v_contractor_amount,v_contractor_vat:v_contractor_vat,v_contractor_total_amount:v_contractor_total_amount,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date}
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
                                     clear_text_assigned();
									 $('#div_subcontractor_content').hide();
									 $('#btn_assign_subcontractors_renew').hide();
									 $('#btn_exit_assign_subcontractor_renew').hide();
                                     //location.reload();
                                }
                                
                                 
                            
                        });
                        
                       
                        
                     }
					
				});	
				
				
				
				// $('#btn_edit_assign_subcontractor_renew').click(function(){
                    
					// var v_amc_contractor_id=$("#select_amc_subcontractors option:selected").val();
                    // var v_amc_contractor_name=$("#select_amc_subcontractors option:selected").text();
					// var v_contractor_description = $('#txt_contractor_description').val();
                    // var v_contractor_amount = $('#txt_contractor_amount').val();
					// var v_contractor_vat = $('#txt_contractor_vat').val();
					// var v_contractor_total_amount = $('#txt_contractor_total_amount').val();
					
					// var v_amc_start_end_date=$("#txt_list_contractor_start_end_date").val();
					// var res_start_end = v_amc_start_end_date.split("-");
					// var v_amc_start_date=$.trim(res_start_end[0]);
					// var v_amc_end_date=$.trim(res_start_end[1]);
					// v_amc_start_date = v_amc_start_date.split("/").reverse();
					// var tmpstart = v_amc_start_date[2];
					// v_amc_start_date[2] = v_amc_start_date[1];
					// v_amc_start_date[0] = v_amc_start_date[0];
					// v_amc_start_date[1] = tmpstart;
					// v_amc_start_date = v_amc_start_date.join("-");
					// v_amc_end_date = v_amc_end_date.split("/").reverse();
					// var tmpend = v_amc_end_date[2];
					// v_amc_end_date[2] = v_amc_end_date[1];
					// v_amc_end_date[0] = v_amc_end_date[0];
					// v_amc_end_date[1] = tmpend;
					// v_amc_end_date = v_amc_end_date.join("-");
					
                    // v_session_image = $("#session_image").val();
                    // var v_session_image_new = $("#amc_contractor_file_name").text();
                    // var randomNum = Math.ceil(Math.random() * 999999);   
					
                     // if(v_session_image=="" && v_session_image_new!="")
                        // {
                            // v_session_image=v_session_image_new;
                           
                            
                        // }
                        // else if(v_session_image=="")
                        // {
                            // v_session_image="default.jpg";
                        // }
                        // else
                        // {
                            // var doc_file_obj = $("#session_image")[0].files[0];
                            // var upload = new ns.Upload(doc_file_obj);
                            // doc_file1= doc_file_obj.name;
                            // upload.doUpload("../httpdocs/user_upload/amc_subcontractor_file_upload.php?random_no="+randomNum);
                            // v_session_image=randomNum+'_'+doc_file1;
                        // }  
						
                    // if($.trim(v_amc_contractor_id)==="select"||$.trim(v_contractor_amount)===""||$.trim(v_contractor_vat)===""||$.trim(v_contractor_total_amount)===""||v_amc_start_end_date===""||$.trim(v_contractor_description) === "")
                    
                    // {
                        // swal("Warning","Please provide all the details ....", "warning");
                     
                        // return false;
                    // }
                   
                    // else
                    // {         
                         // $.post("../controller/amc/amc_controller.php",{action:'update_amc_subcontractor',v_amc_subcontractor_ids:v_amc_subcontractor_ids,v_amc_id:v_amc_id,v_amc_ref_no:v_amc_ref_no,v_amc_contractor_id:v_amc_contractor_id,v_amc_contractor_name:v_amc_contractor_name,v_contractor_description:v_contractor_description,v_session_image:v_session_image,v_contractor_amount:v_contractor_amount,v_contractor_vat:v_contractor_vat,v_contractor_total_amount:v_contractor_total_amount,v_amc_start_date:v_amc_start_date,v_amc_end_date:v_amc_end_date}
                                // , function(result,status)
                                // {
                                    // console.log(result);
                                    
                                   // result = $.trim(result);
                               
                                // if(result == "0")
                                // {
                                  
                                    // swal("Error", result, "error");
                                    // clear_text_assigned();
                                // }
                                // else 
                                // {
                                   
                                    // swal("Success", "Subcontractors details updated successfully..", "success");
                                    // load_subcontractor(v_amc_ref_no);
                                    // clear_text_assigned();
									// $('#btn_edit_assign_subcontractor_renew').hide();
									// $('#btn_assign_subcontractors_renew').show();
                                    
                                // }
                        // });
                        
                     // }
                  
                // });


				function clear_text_assigned()
				{
					$('#txt_contractor_amount').val('');
					$('#txt_contractor_vat').val('');
					$('#txt_contractor_total_amount').val('');
					$('#txt_contractor_description').val('');
					$("#txt_list_contractor_start_end_date").val();
					$('#div_subcontractors_load').load("../view/amc/subcontractor_combo.php");
					$("#session_image").val(null);
					$('.filename').val(null);
					$('.filename').html('');
                    $("#amc_contractor_file_name").empty();
                    $("#img_preview").hide();
				}

				$('#btn_exit_assign_subcontractor_renew').click(function(){
					$('#div_subcontractor_content').hide();
					$('#btn_assign_subcontractors_renew').hide();
					$('#btn_exit_assign_subcontractor_renew').hide();
				});
				
				
			 // v_amc_list_table.on( 'order.dt search.dt', function () {
    //             v_amc_list_table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //             cell.innerHTML = i + 1;
    //             v_amc_list_table.cell(cell).invalidate('dom'); 
    //             } );
    //             } ).draw();	
				
// 			$('#btn_amcrenewal_excell').click(function(){
// 			   v_amc_list_table.button('.excel-button').trigger();
// 			});

      var txt_amcnumber = $('#txt_amcnumber').val();
      if(txt_amcnumber!=="")
      {
          v_amc_list_table.search(txt_amcnumber).draw();
      }
      
      setInterval(function() {
            var index = $.inArray("AMCRenewalExportExcel", permissions);
            if (index === -1) {
                $('.excel-button').css('display', 'none');
            }
            //renew_amc_report
            //AMCRenewalReport
            var AMCRenewalReport = $.inArray("AMCRenewalReport", permissions);
            if (index === -1) {
                $('[name="renew_amc_report"]').hide();
            }
       }, 1000);  


});