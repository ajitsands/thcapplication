$(document).ready(function(){
    
var tbl_emergency_work_orders = $('#tbl_emergency_work_orders').DataTable({});   
var tbl_urgent_work_orders = $('#tbl_urgent_work_orders').DataTable({});
var tbl_normal_work_orders = $('#tbl_normal_work_orders').DataTable({});

load_tbl_emergency_work_orders();
load_tbl_urgent_work_orders();
load_tbl_normal_work_orders();

function load_tbl_emergency_work_orders()
{
                var i=1; 
                tbl_emergency_work_orders.destroy();
                                     
                tbl_emergency_work_orders = $('#tbl_emergency_work_orders').DataTable({
                                       
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/ticket/ticket_completed_controller.php',
                     'data': {
                        action: 'list_emergency_work_orders'
                        
                     },
            		  beforeSend: function () {
            			$("#tbl_emergency_work_orders").LoadingOverlay("show", {
            				background: "rgba(132, 194, 0, 0.2)",
            				text: "Loading..."
            			});
                      },
            		    complete: function () {
            			  $("#tbl_emergency_work_orders").LoadingOverlay("hide");
            		  },
            		   error: function (XMLHttpRequest, textStatus, errorThrown) {
                          $("#tbl_emergency_work_orders").LoadingOverlay("hide");
                       },    
                 },
                 "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                  },
                                       
                	"Paginate": true,
                	"bLengthChange": false,
                	"bFilter": true,
                	"bInfo": true,
                	"autoWidth": false,
            				
            			
                "columns": [
                   
                    { "data": "ticket_id","width": "5%",
                      "render": function(data, type, rows, meta) {
                            return i++;
                        },
                    },
                    { "data": "created_date_time","type": "dom-date" },
					{ "data": "ticket_ref_code",
                        "render": function(data, type, row, meta) {
                            return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                        }
                    },
					{ "data": "customer_name" },
					{ "data": "building_name" },
					{ "data": "location_name" },
					{ "data": "complaints_description" },
					{ "data": "ticket_priority",
					   "render": function(data, type, row, meta) {
					       return '<span class="badge bg-danger">'+data+'</span>';
                        }
					}
                 ],
                 pageLength: 20,
				 searching: true,
                 responsive: true,

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
                        }
                    });
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    // return nRow;
                }
            });  
                
}

function load_tbl_urgent_work_orders()
{
                var i=1; 
                tbl_urgent_work_orders.destroy();
                                     
                tbl_urgent_work_orders = $('#tbl_urgent_work_orders').DataTable({
                                       
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/ticket/ticket_completed_controller.php',
                     'data': {
                        action: 'list_urgent_work_orders'
                        
                     },
            		  beforeSend: function () {
            			$("#tbl_urgent_work_orders").LoadingOverlay("show", {
            				background: "rgba(132, 194, 0, 0.2)",
            				text: "Loading..."
            			});
                      },
            		    complete: function () {
            			  $("#tbl_urgent_work_orders").LoadingOverlay("hide");
            		  },
            		   error: function (XMLHttpRequest, textStatus, errorThrown) {
                          $("#tbl_urgent_work_orders").LoadingOverlay("hide");
                       },    
                 },
                 "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                  },
                                       
                	"Paginate": true,
                	"bLengthChange": false,
                	"bFilter": true,
                	"bInfo": true,
                	"autoWidth": false,
            				
            			
                "columns": [
                   
                    { "data": "ticket_id","width": "5%",
                      "render": function(data, type, rows, meta) {
                            return i++;
                        },
                    },
                    { "data": "created_date_time","type": "dom-date" },
					{ "data": "ticket_ref_code",
                        "render": function(data, type, row, meta) {
                            return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                        }
                    },
					{ "data": "customer_name" },
					{ "data": "building_name" },
					{ "data": "location_name" },
					{ "data": "complaints_description" },
					{ "data": "ticket_priority",
					   "render": function(data, type, row, meta) {
					       return '<span class="badge bg-warning">'+data+'</span>';
                        }
					}
                 ],
                 pageLength: 20,
				 searching: true,
                 responsive: true,

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
                        }
                    });
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    // $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    // return nRow;
                }
            });  
                
}

function load_tbl_normal_work_orders()
{
                var i=1; 
                tbl_normal_work_orders.destroy();
                                     
                tbl_normal_work_orders = $('#tbl_normal_work_orders').DataTable({
                                       
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/ticket/ticket_completed_controller.php',
                     'data': {
                        action: 'list_normal_work_orders'
                        
                     },
            		  beforeSend: function () {
            			$("#tbl_normal_work_orders").LoadingOverlay("show", {
            				background: "rgba(132, 194, 0, 0.2)",
            				text: "Loading..."
            			});
                      },
            		    complete: function () {
            			  $("#tbl_normal_work_orders").LoadingOverlay("hide");
            		  },
            		   error: function (XMLHttpRequest, textStatus, errorThrown) {
                          $("#tbl_normal_work_orders").LoadingOverlay("hide");
                       },    
                 },
                 "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                  },
                                       
                	"Paginate": true,
                	"bLengthChange": false,
                	"bFilter": true,
                	"bInfo": true,
                	"autoWidth": false,
            				
            			
                "columns": [
                   
                    { "data": null,"width": "5%",
                    //   "render": function(data, type, rows, meta) {
                    //         return i++;
                    //     },
                    },
                    { "data": "created_date_time","type": "dom-date" },
					{ "data": "ticket_ref_code",
                        "render": function(data, type, row, meta) {
                            return '<a href="work_order_print.php?ticket_id=' + row['ticket_id'] + '" target="_blank">WO-' + data + '-' + row['ticket_id'] + '</a>';
                        }
                    },
					{ "data": "customer_name" },
					{ "data": "building_name" },
					{ "data": "location_name" },
					{ "data": "complaints_description" },
					{ "data": "ticket_priority",
					   "render": function(data, type, row, meta) {
					       return '<span class="badge bg-primary">'+data+'</span>';
                        }
					}
                 ],
                 pageLength: 20,
				 searching: true,
                 responsive: true,

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
                        }
                    });
                },
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                    return nRow;
                }
            });  
                
}
      
    
});