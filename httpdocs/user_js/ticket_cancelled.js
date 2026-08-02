$(document).ready(function(){
                 
       $('.modal').on("hidden.bs.modal", function (e) { //fire on closing modal box
        if ($('.modal:visible').length) { // check whether parent modal is opend after child modal close
            $('body').addClass('modal-open'); // if open mean length is 1 then add a bootstrap css class to body of the page
        }
    });  
	
	var v_list_of_tickets_cancelled = $('#tbl_cancelled_tickets').DataTable({});	
	load_data_to_completed_ticket_list();
	
	 function load_data_to_completed_ticket_list()
                 {
                    var i=1; 
                    v_list_of_tickets_cancelled.destroy();
                         
                     v_list_of_tickets_cancelled = $('#tbl_cancelled_tickets').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/ticket_cancelled_controller.php',
                                 'data': {
                                    action: 'list_cancelled_ticket'
                                     
                                 },
								  beforeSend: function () {
									$("#tbl_cancelled_tickets").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#tbl_cancelled_tickets").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#tbl_cancelled_tickets").LoadingOverlay("hide");
                                   },    
                             },
                             "language": {
                                 "zeroRecords": "No records available",
                                 "infoEmpty": "No records available",
                              },
                           // "order": [[ 0, "desc" ]],
                           
            				"Paginate": true,
            				"bLengthChange": false,
            				"bFilter": true,
            				"bInfo": true,
            				"autoWidth": false,
            				
							"dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] 
                                        },
										filename: 'List of Work Order - Cancelled',
									},
								],
            			
                            "columns": [
                               
                                { "data": null,"width": "5%",
                                        "render": function (data, type, row, meta) {
											return meta.row + 1; 
										}
                                    },
                                 { "data": "created_date_time","type": "dom-date" },
								 { "data": "ticket_ref_code"},
								 { "data": "customer_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=data+' - '+rows['customer_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "location_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=rows['location_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "building_code",
                                      render: function ( data, type, rows, meta ) {
                                          
                                          str_active_status=rows['building_name'];
                                          
                                     	return str_active_status;
            
            							 },
                                 },
                               
                                 { "data": "ticket_priority",visible:false,
                                      render: function ( data, type, rows, meta ) {
                                          switch(data)
                                          {
                                              case 'Emergency':
                                                   str_active_status='<span class="badge badge-danger">'+data+'</span>'
                                              break;
                                              case 'Urgent':
                                                   str_active_status='<span class="badge badge-warning">'+data+'</span>'
                                              break;
                                              case 'Essential':
                                                   str_active_status='<span class="badge badge-info">'+data+'</span>'
                                              break;
                                              case 'Normal':
                                                   str_active_status='<span class="badge badge-success">'+data+'</span>'
                                              break;
                                              default:
                                              str_active_status='<span class="badge bg-slate">'+data+'</span>'
                                              break;
                                          }
                                         
                                     	return str_active_status;
            
            							 },
                                 },
                                 { "data": "cancelled_date_time1"},
                                 { "data": "cancelled_reason"},
                                 { "data": "ticket_ref_code",
                                      render: function ( data, type, rows, meta ) {
                                        
                                        var dropdownOptions = {
                                            "WoCancelledModify": "Print WO",
                                            "WoCancelledModify": "Print SR"
                                        };
                                        
                                        var filteredOptions = Object.keys(dropdownOptions).filter(function (option) {  
                                            return permissions.includes(option);
                                        });  
                                    
                                        var dropdownHTML = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right">';
                                          if(filteredOptions=="WoCancelledModify")
                                          {
                                              dropdownHTML += '<a  class="dropdown-item"  style="color:black" name="cancelledPrintWO" href="../view/work_order_print.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" name="cancelledPrintSR" href="../view/service_report.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a>';
                                          }
                                          else
                                          {
                                              dropdownHTML += '<label class="dropdown-item text-danger">You have no Privilege</label>';
                                          }
                                        
                                        dropdownHTML += '</div></div></div>';
                                        return dropdownHTML;
                                      }   
                                 }
                                //  { "data": "ticket_ref_code",
                                //       render: function ( data, type, rows, meta ) {
                                //          str_active_status_edit = '<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown" style="color:black">	<i class="icon-menu9"></i>	</a>	<div class="dropdown-menu dropdown-menu-right"><a  class="dropdown-item"  style="color:black" href="../view/work_order_print.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print WO</a>	<a  class="dropdown-item"  style="color:black" href="../view/service_report.php?ticket_id='+rows["ticket_id"]+'" target="_blank"><i class="icon-printer4"></i>Print SR</a></div></div></div>';
                                //           return str_active_status_edit;
                                          
                                //       }   
                                //  }
                                 
                       
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                //              "aoColumnDefs": [
            				// 	{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				// ],
                            
            				
                             "initComplete": function( settings, json ) {
                                    
                                $.extend($.fn.dataTableExt.oSort, {
                                    "dom-date-pre": function(a) {
                                        return moment(a, "DD-MM-YYYY HH:mm:ss")
                                    },
                                    "dom-date-asc": function(a, b) {
                                        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                                    },
                                    "dom-date-desc": function(a, b) {
                                        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                                    },
									
									
                                });
								$('.excel-button').hide();
             
                              },
							  
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                // return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 }
				 
			  $('#cancelled_pdf').on('click', function() {
					//alert(start_date+end_date+v_customer_id+v_customer);
					var filePath='cancelled_workorder_management_print.php';
					 window.open(filePath, '_blank'); 
				});	

				$('#cancelled_excel').on('click', function() {
					v_list_of_tickets_cancelled.button('.excel-button').trigger();
				});		
				
	setInterval(function() {
        var CancelledWOPrint = $.inArray("CancelledWOPrint", permissions);
        if (CancelledWOPrint === -1) {
             $('[name="cancelledPrintWO"]').hide();
        }
        var CancelledSRPrint = $.inArray("CancelledSRPrint", permissions);
        if (CancelledSRPrint === -1) {
           $('[name="cancelledPrintSR"]').hide();
        }
    }, 1000);
});