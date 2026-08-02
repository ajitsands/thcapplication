$(document).ready(function(){
    
    var v_amc_asset_service_list = $('#tbl_amc_asset_list').DataTable({});  
   
    load_data_to_grid_amc_asset_service_list();
    
        $('#tbl_amc_asset_list tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
            $('#selected_items').html(v_amc_asset_service_list.rows('.selected').data().length +' asset(s) selected' );
        });
 
    
                function load_data_to_grid_amc_asset_service_list()
                 {
                     
                    v_amc_asset_service_list.destroy();
                         
                     v_amc_asset_service_list = $('#tbl_amc_asset_list').DataTable( {
                           
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_asset_service_controller.php',
                                 'data': {
                                    action: 'amc_asset_service_list'
                                    
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
            				select: true,
            				"autoWidth": false,
            				
            				
            			
                            "columns": [
                               
                                 { "data": null},
                                
                                 { "data": "asset_id","visible":false },
                                 { "data": "asset_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                           
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Created By </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['created_name']+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Modified By : </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['modified_name'] +'</div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "asset_category_name"},
                                 { "data": "asset_type_name"},
                                 { "data": "flat_area_code"},
                                 
                                //  { "data": "asset_spgen",
                                //       render: function ( data, type, rows, meta ) {
                                            
                                //             struct = '<div class="border-left-1 border-left-primary rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" ><div class="col-lg-12 col-md-12 col-sm-12" >'+rows['asset_sp_des']+'</div></div></div>';
                                //             str_active_status="<span class='badge badge-primary'> <a href='#' data-popup='popover' class='popoverButton' title='Description' data-placement='top' data-trigger='hover' data-html='true' data-content=' "+ struct +"    ' style='color:white;'>";
                                //             str_active_status  = str_active_status + data+"</a></span>";
                                       
                                //          return str_active_status;
                                          
                                //       }   
                                //  },
                               
                                 { "data": "asset_brand",
                                      render: function ( data, type, rows, meta ) {
                                         
                                      
                                       // struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Serial No </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['asset_serial_no']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Capacity </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['asset_capacity']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Cost </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['asset_cost']+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Is Warentee </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['is_warentee']+'</div></div> <div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Warentee End Date </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['warentee_end_date']+'</div></div></div>';
                                        str_ref="<a href='#' data-popup='popover' class='popoverButton' data-popup='popover' title='Other Details' data-trigger='hover' data-html='true'  data-content=' SAMPLE    '>";
                                        str_ref  = str_ref + data+"</a>";
                                        return str_ref;
                                      }   
                                 },
                                 { "data": "asset_attachment","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                         
                                      
                                        // struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body">   <div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Description </b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+rows['asset_description']+'</div></div></div>';
                                        // str_ref="<a href='#' data-popup='popover' class='popoverButton' title='"+data+"' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                        // str_ref  = str_ref + "<i class='icon-attachment'></i></a>";
                                        str_ref = "Sheduled<br> <font style='font-size:9px;'>12-12-2021</font>"
                                        return str_ref;
                                      }   
                                 },
                                 { "data": "asset_status","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                          
                                            if(data=='Active')
                                            {
                                     	        return str_ref= '<span class="badge badge-success">'+data+'</span>';
                                            }
                                            else
                                            {
                                                return str_ref= '<span class="badge badge-danger">'+data+'</span>';
                                            }
                                
                                       
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
                              
                              drawCallback : function() {
                                  
                                }
                            
                     });  
                
                 }
                 
});