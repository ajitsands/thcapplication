$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
 var v_list_of_asset_codes_table = $('#list_of_asset_codes').DataTable({
     "bLengthChange": false,
            				"bFilter": false,
            				"bInfo": false,
            				"autoWidth": false,
      "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6] }, 
            					
            				]
 });
 var v_btn_search_asset_codes = $('#btn_search_asset_codes').ladda();
 var v_customer_id,v_building_id,v_category_id;
  v_btn_search_asset_codes.click(function(){
        
                              //  v_btn_search_asset_codes.ladda( 'start' );
        v_customer_id=$("#select_asset_customer option:selected").val();    
        v_building_id=$("#select_building_for_location option:selected").val();
        v_category_id=$("#select_asset_category_customer option:selected").val();
        
            if(v_customer_id=='select')
            {
                swal("Warning", "Please select location...", "warning");
              return false;
            }
            else if(v_building_id=='select')
            {
                swal("Warning", "Please select building...", "warning");
              return false;
            }
            else if(v_category_id=='select')
            {
                swal("Warning", "Please select category...", "warning");
              return false;
            }
            else
            {
                load_data_to_grid_asset_codes_details_list(v_customer_id,v_building_id,v_category_id);
            }
                                
    });
    
 
  function load_data_to_grid_asset_codes_details_list(v_customer_id,v_building_id,v_category_id)
                     {
                    v_list_of_asset_codes_table.destroy();
                     v_list_of_asset_codes_table = $('#list_of_asset_codes').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/ticket/asset_code_download_controller.php',
                                 'data': {
                                    action: 'asset_code_list',
                                    v_customer_id:v_customer_id,
                                    v_building_id:v_building_id,
                                    v_category_id:v_category_id
                                    
                                 },
                                 beforeSend: function () {
									$("#list_of_asset_codes").LoadingOverlay("show", {
										background: "rgba(132, 194, 0, 0.2)",
										text: "Loading..."
									});
                                  },
								    complete: function () {
									  $("#list_of_asset_codes").LoadingOverlay("hide");
								  },
								   error: function (XMLHttpRequest, textStatus, errorThrown) {
                                      $("#list_of_asset_codes").LoadingOverlay("hide");
                                   },   
                             },
                              "select": {
                                style: 'multi'
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
            				// dom: 'Bfrtip',
            				 
            				//  buttons: [
                //             {
                                
                //                 extend: 'excelHtml5',
                //                 //filename:'Bill Of Quantity - '+project_name,
                //                 filename:'List of Assets',
                //                 title: 'LIST OF ASSETS',
                //               // className: 'advisorsExportButton' ,
                //               //text: 'Export to excel',
                //               text: 'Excel Download',
                              
                              
                //                 exportOptions: {
                //                 columns: [1]
                //                 },
                //                 customize: function(doc) {
                                
                //                 console.log(doc);
                               
                //                 }
                            
                                
                //             }
                            // ],
                             initComplete: function () {
                                var btns = $('.dt-button');
                                btns.addClass('btn btn-success');
                                btns.removeClass('dt-button');
                                  
                            },
                            "dom": '<"datatable-header"lfB>rtip',
                            "buttons": [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel', 
                                        className: 'excel-button',
                                        exportOptions: {
                                            columns: [0, 1, 3, 4, 5, 6, 7] 
                                        },
										filename: 'List of Assets',
									},
								],
								
                            "columns": [
                                
                                 { "data": null,
                                     "render": function (data, type, row, meta) {
										    if (row['asset_id'] === 'NA' || data === null || data === '') {
												return '';
											} else {
												return meta.row + 1;
											}
										}
                                 },
                                 { "data": "asset_ref_no",
                                     render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
                                 },
                                 { "data": "asset_ref_no",
								     render: function ( data, type, rows, meta ) {
								         if (data === 'NA') {
											return '';
								        }	
								         var qrCodeHtml = '<a href="../printpdf/qr_code/generate_asset_qr.php?asset_ref_no='+data+'&asset_id=' + rows['asset_id'] + '" target="_blank">';
                                            qrCodeHtml += '<img src="../httpdocs/qr_lib/asset_qr/download_asset/' + data + '.png" alt="QR Code Image"/>';
                                            qrCodeHtml += '</a>';
                                            
                                            return qrCodeHtml;
								         
								     }
								     
								 },  
                                 { "data": "asset_category_name",
                                     render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
                                 },
                                 { "data": "asset_type_name",
                                     render: function ( data, type, rows, meta ) {
									  if (data === 'NA') {
											return '';
									  }	
									  return data;
									}
                                 },
                                 { "data": "customer_name",
            					   render: function ( data, type, rows, meta ) {
                					       if (data === 'NA') {
    											return 'No records available';
    									  }	
            						        return rows['customer_code']+'||'+rows['customer_name'];
            							 },                                                                                                                                         
                                     
                                 },
                                 { "data": "asset_location",
                                      render: function ( data, type, rows, meta ) {
                                          if (data === 'NA') {
											return '';
									        }	
            						        return rows['location_code']+'||'+rows['asset_location'];
            						 },  
                                 },
                                { "data": "asset_building",
            					   render: function ( data, type, rows, meta ) {
            					       if (data === 'NA') {
											return '';
									  }	
            						    return rows['building_code']+'||'+rows['asset_building'];
            							 },                                                                                                                                         
                                     
                                 }
                             ],
                             pageLength: 20,
            				 searching: true,
                             responsive: true,
                             
                             "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 0,1,2,3,4,5,6] }, 
            					
            				],

                             "initComplete": function( settings, json ) {
                                    var table = this.api();
									table.buttons('.excel-button').nodes().css('display', 'none');
                              },
                                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                //  $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                //  return nRow;
                              },
                              "drawCallback": function () {
                                   
                                }
                            
                     });  
                
                 } 
                  v_list_of_asset_codes_table.on( 'order.dt search.dt', function () {
                v_list_of_asset_codes_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i + 1;
                v_list_of_asset_codes_table.cell(cell).invalidate('dom'); 
                } );
                } ).draw();
                 
                
                
                $('#btn_asset_qr_pdf').on('click', function() {
                    
                    // Get the selected rows
                    var selectedRows = v_list_of_asset_codes_table.rows({ selected: true }).data().toArray();
                
                    // Extract the asset codes from the selected rows
                    var assetCodes = selectedRows.map(function(row) {
                        return row.asset_ref_no;
                    });
                    var assetids = selectedRows.map(function(row) {
                        return row.asset_id;
                    });
                
                    // Now, you have the asset codes in the 'assetCodes' array
                    //alert(assetCodes+','+assetids);
                
                    // Proceed with your logic, for example, open a new window with the asset codes
                    var filePath = '../printpdf/qr_code/generate_all_asset_qr.php?assetids=' + assetids;
                    window.open(filePath, '_blank');
    			}); 
    			
    			$('#btn_asset_code_pdf').on('click', function() {
    				//v_list_of_asset_codes_table.button('.pdf-button').trigger();
    				
    				var filePath='asset_code_download_print.php?customer_id='+v_customer_id+'&building_id='+v_building_id+'&category_id='+v_category_id;
    				window.open(filePath, '_blank'); 
    			});	
			
			
    			$('#btn_asset_code_excel').on('click', function() {
    				v_list_of_asset_codes_table.button('.excel-button').trigger();
    			});
                 
   
 

});