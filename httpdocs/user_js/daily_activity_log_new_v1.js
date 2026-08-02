$(document).ready(function(){
   
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    var from_date=today;
    var to_date=today;
    var status_sel='All';
   
   var list_of_services_details = $('#list_of_services').DataTable({});
   load_data_to_grid_product_list_first(status_sel,from_date);
   function load_data_to_grid_product_list_first(status_sel,from_date)
    {
			var i = 1;
			list_of_services_details.destroy();
				 
			list_of_services_details = $('#list_of_services').DataTable( {
                responsive: true,
                 "ajax": {
                     'type': 'POST',
                     'url': '../controller/daily_report/daily_log_controller.php',
                     'data': {
                        action: 'list_work_orders',status:status_sel,from_date:from_date
                        
                     }
                 },
                 "language": {
                     "zeroRecords": "No records available",
                     "infoEmpty": "No records available",
                  },
                "order": [[ 0, "asc" ]],
               
				"Paginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bInfo": true,
				"autoWidth": false,
				"bRetrieve":true,
			
                "columns": [
				 
			     { "data": null,className: "text-center",
                    "render": function(data, type, full, meta) {
                        return i++;
                      },
                },
				 { "data": "ticket_ref_code",
                        render: function ( data, type, rows, meta ) {
                           
                            return 'WO-'+rows["ticket_ref_code"]+'-'+rows["ticket_id"];
                        }
                    },
                    { "data": "service_description",
                        render: function ( data, type, rows, meta ) {
                           
                            return data;
                        }
                    },
                    { "data": "ticket_service_status",
                        render: function ( data, type, rows, meta ) {
                           switch(data)
                           {
                               case 'Pending':
                                   return '<span tyle="color:orange">'+data+'</span>';
                               break;
                               case 'Start':
                                   return '<span tyle="color:blue">'+data+'</span>';
                               break;
                               case 'Completed':
                                   return '<span tyle="color:green">'+data+'</span>';
                               break;
                               case 'Cancelled':
                                   return '<span tyle="color:red">'+data+'</span>';
                               break;
                               default:
                               return '<span tyle="color:brown">'+data+'</span>';
                               break;
                           }
                            
                        }
                    },
                     { "data": "ticket_ref_code",
                        render: function ( data, type, rows, meta ) {
                           
                            if(rows["start_emp_code"]!="NA" ){
                									
                								return rows["service_start_date_time1"]+'  by  '+rows["start_emp_code"];
                									}
                									else
                									{
                									    return '';
                									}
                        }
                    },
                     { "data": "ticket_ref_code",
                        render: function ( data, type, rows, meta ) {
                           
                             if(rows["finish_emp_code"]!="NA" ){
                									
                								return rows["service_complete_cancel_date_time1"]+'  by  '+rows["finish_emp_code"];
                									}
                										else
                									{
                									    return '';
                									}
                        }
                    },
				 
                    { "data": "difference_mins",
                        render: function ( data, type, rows, meta ) {
                           
                            return data;
                        }
                    },
                    { "data": "tech_remarks",
                        render: function ( data, type, rows, meta ) {
                           
                            return data;
                        }
                    },
                 ],
                  
                 pageLength: 20,
				 searching: true,
                 
                "aoColumnDefs": [
            					{ "bSortable": false, "aTargets": [ 1,2,3,4,5,6,7] }, 
            					
            				],
                 initComplete: function () {
         
                    },
                  "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    
                  }, 
                  "drawCallback": function () {
                       
                    }
                
         });  
    
    }
    
    
  
                									
                							
                								    
    
 $("#btn_go").click(function(){
	list_daily_teams();
	}); 
	
$("#btn_print").click(function(){
    var start_date=$('#txt_start_date').val();
    var status=$('#select_status').val();
    if(start_date=='' )
		{
		    swal("Warning","Please specify the date ...", "warning");
          
            return false;  
		}
	
	

		else
		{
		    var img_to_load=$("#hidden_image_show_add_entries2").val();
	         var filePath='http://thc.sianlab.com/view/daily_reports/daily_activity_log_print.php?status='+status+'&start_date='+start_date;
	    
		    window.open(filePath, '_blank');
		}
}); 

	
 

    function list_daily_teams()
    {
        
		var start_date=$('#txt_start_date').val();
		//var end_date=$('#txt_end_date').val();
		var status=$('#select_status').val();
		
// 		var start = new Date(start_date);
//         var end   = new Date(end_date);
//         var diff  = new Date(end - start);
//         var days  = diff/1000/60/60/24;

		
		if(start_date=='' )
		{
		    swal("Warning","Please specify the date ...", "warning");
          
            return false;  
		}
	
	

		else
		{
		   load_data_to_grid_product_list_first(status,start_date);

		}
	
    }
    
                    
           
});