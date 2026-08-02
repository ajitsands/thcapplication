/*
 * myClass
 */
var amc_list = function(options){
 
    var vars = {
        myVar  : 'original Value',
        myVar1  : 'original Value New'
    };
 
  
    /*
     * Can access this.method
     * inside other methods using
     * root.method()
     */
    var root = this;
 
    /*
     * Constructor
     */
    this.construct = function(options){
        $.extend(vars , options);
         this.v_amc_list_table =$('#tbl_amc_list').DataTable({});
       
    };
    
	  this.amcList = function(action_word){
	     // alert(action_word);
	     
	     this.load_data_to_grid_amc_list(action_word);
		
	  };
	  
	   this.load_data_to_grid_amc_list = function(action_word){
                 this.v_amc_list_table.destroy();
                         alert(action_word);
                         $.post("../controller/amc/amc_controller.php",{action:action_word},function(){
                             
                         });
                     $('#tbl_amc_list').DataTable( {
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc/amc_controller.php',
                                 'data': {
                                    action: action_word
                                    
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
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='Other Details' data-trigger='hover' data-html='true' data-content=' "+ struct +"    '>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                     
                                 },
                                 { "data": "customer_name"},
                                 { "data": "contract_type_name"},
                                 { "data": "amc_signed_date"},
                                 
                                 { "data": "amc_start_date",
                                      render: function ( data, type, rows, meta ) {
                                          str_amc_date = rows['amc_start_date']+'  -  '+rows['amc_end_date'];
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
                                 { "data": "amc_id","className":"text-center",
                                      render: function ( data, type, rows, meta ) {
                                          
                                     	        return str_actions='<div class="list-icons"><div class="dropdown"><a href="#" class="list-icons-item" data-toggle="dropdown"><i class="icon-menu9"></i></a><div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item" data-toggle="modal" name="amc_change_status" data-target="#modal_change_status"><i class="icon-pencil5"></i> Change Status</a><a href="#" class="dropdown-item" name="Edit_data"><i class="icon-quill4"></i> Edit</a><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_amc_renew"><i class="icon-reload-alt"></i> Renew</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_add_assets"><i class="icon-barcode2"></i> Add Assets </a><a href="#" class="dropdown-item"><i class="icon-pen-plus"></i> Add Services</a><a href="#" class="dropdown-item"><i class="icon-list-numbered"></i> Add Services History</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_backdrop_amc_schedule" name="a_schedule_visits"><i class="icon-calendar"></i> Schedule  Visits</a><a href="#" class="dropdown-item"><i class="icon-calculator3"></i> Payment Collection</a><div class="dropdown-divider"></div><a href="#" class="dropdown-item"><i class="icon-file-eye"></i> View History</a></div></div></div>';
                                       
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
                                alert(action_word);
                            }
                            
                     });  
            }
	  
                  
		  
    this.construct(options);
 
};
 
 
