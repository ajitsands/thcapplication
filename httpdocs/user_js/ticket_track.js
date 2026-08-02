$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
                 
    var v_btn_search_tickets = $('#btn_search_tickets').ladda();
    // var v_list_of_tickets_not_assigned=$('#tbl_of_scheduled_not_assigned_tickets').DataTable({});
    
    
    list_level1_ref_nos();
    
    $("#btn_search_tickets").click(function(){
	list_level1_ref_nos();
	}); 
	
	


    function list_level1_ref_nos()
    {
        
		var start_date=$('#txt_start_date').val();
		//var end_date=$('#txt_end_date').val();
		
		if(start_date=='' )
		{
		    swal("Warning","Please specify the date ...", "warning");
          
            return false;  
		}
// 		if(end_date<start_date)
// 		{
// 		    swal("Warning","Please provide valid date range...", "warning");
           
//             return false; 
// 		}
		else
		{
		   
           $.ajax({
		type: "POST",
		url: "tickets/track_ticket_level1_tkt_ref_nos.php",
		data: {start_date:start_date} 
		 }).done(function(data){
		     
			$("#div_level1_ref_nos_list").html(data);
		 });
		}
	
    }
    
                   
                     
           
});