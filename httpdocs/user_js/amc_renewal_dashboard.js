$(document).ready(function(){
       
        var tbl_amc_renwalsDashboard = $('#tbl_amc_renwalsDashboard').DataTable({});
    
        load_tbl_amc_renwalsDashboard();
       
         function load_tbl_amc_renwalsDashboard()
                 {
                    var i = 1;
                    tbl_amc_renwalsDashboard.destroy();
                         
                     tbl_amc_renwalsDashboard = $('#tbl_amc_renwalsDashboard').DataTable( {
                           		
                             "ajax": {
                                 'type': 'POST',
                                 'url': '../controller/amc_renewal/amc_renewal_controller.php',
                                 'data': {
                                    action: 'list_amc_renwalsDashboard'
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
                                 { "data": null ,"width": "3%" },
                                 { "data": "amc_ref_no",
                                     render: function ( data, type, rows, meta ) {
                                            str_net_amount=parseFloat(rows['amc_vat_amt'])+parseFloat(rows['amc_amount']);
                                            struct = '<div class="border-left-1 border-left-warning rounded-left-0" style="padding-bottom:0px;padding-top:0px;"> <div class="card-body"><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_amount'])+'</div></div><div class="row"style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>VAT %</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(rows['amc_vat_perct'])+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-6 col-md-6 col-sm-6" ><b>NET Amount</b></div><div class="col-lg-6 col-md-6 col-sm-6 text-right" style="text-align:right;" >'+$.fn.dataTable.render.number(',', '.', 3, '').display(str_net_amount)+'</div></div><div class="row" style="padding-bottom:10px;"><div class="col-lg-12 col-md-12 col-sm-12" ><b> Description </b>: '+rows['amc_description']+'</div></div></div></div>';
                                            str_ref="<a href='#' data-popup='popover' class='popoverButton' title='' data-original-title='Other Details' data-trigger='hover' data-html='true' data-content='"+ struct +"'>";
                                            str_ref  = str_ref + data+"</a>";
                                         return str_ref;
                                     }     
                                 },
                                 { "data": "customer_name" },
                                 { "data": "contract_type_name" },
                                 { "data": "amc_signed_date" },
                                 { "data": "amc_start_date",
                                    render: function ( data, type, rows, meta ) {
                                        return data+' - '+rows['amc_end_date'];
                                    }   
                                 },
                                 {  "data": "amc_status",
                                    "render": function(data, type, rows, meta) {
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0');
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                                        var yyyy = today.getFullYear();
                                        
                                        today = new Date(yyyy + '-' + mm + '-' + dd);
                                        
                                        console.log("Today:", today);
                                        console.log("AMC End Date:", rows['amc_end_date']);
                                
                                        var amcEndDateParts = rows['amc_end_date'].split("/");
                                        var day = parseInt(amcEndDateParts[0], 10);
                                        var month = parseInt(amcEndDateParts[1], 10);
                                        var year = parseInt(amcEndDateParts[2], 10);
                                
                                        var amcEndDate = new Date(year, month - 1, day);
                                
                                        if (isNaN(amcEndDate.getTime())) {
                                            console.error("Invalid date format for AMC End Date:", rows['amc_end_date']);
                                            return '';
                                        }
                                
                                        if (amcEndDate < today) {
                                            return '<span class="badge badge-danger">Expired</span>';
                                        } else {
                                            var millisecondsPerDay = 1000 * 60 * 60 * 24;
                                            var millisBetween = amcEndDate.getTime() - today.getTime();
                                            var days = millisBetween / millisecondsPerDay;
                                            return '<span class="badge badge-primary">Expiring After ' + Math.floor(days) + ' Days</span>';
                                        }
                                    }
                                }
                             ],
                             pageLength: 50,
            				 searching: true,
                             responsive: true,
                             "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                 $("td:eq(0)", nRow).html(iDisplayIndex + 1);
                                 return nRow;
                             }
                     });  
                
                 }     
    
        $('#tbl_amc_renwalsDashboard tbody').on('click', 'tr', function(e){
            if($('.popoverButton').length>1)
            $('.popoverButton').popover('hide');
            $(e.target).popover('toggle'); 
        });
    
    
});