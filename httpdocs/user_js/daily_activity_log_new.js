$(document).ready(function(){
    
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });             
    var v_btn_go = $('#btn_go').ladda();
   
    
    list_daily_teams();
    
    $("#btn_go").click(function(){
	list_daily_teams();
	}); 
	
	


    function list_daily_teams()
    {
        
		var start_date=$('#txt_start_date').val();
		var end_date=$('#txt_end_date').val();
		var start = new Date(start_date);
        var end   = new Date(end_date);
        var diff  = new Date(end - start);
        var days  = diff/1000/60/60/24;

		
		if(start_date=='' )
		{
		    swal("Warning","Please specify the start date ...", "warning");
          
            return false;  
		}
	
		
		else if(end_date=='' )
		{
		    swal("Warning","Please specify the end date ...", "warning");
          
            return false;  
		}
		else if(days<0)
		{
		    swal("Warning","Please provide a valid date range ...", "warning");
          
            return false; 
		}

		else
		{
		   
           $.ajax({
		type: "POST",
		url: "daily_reports/list_activity_log_new.php",
		data: {start_date:start_date,end_date:end_date} 
		 }).done(function(data){
		     
			$("#div_list_teams").html(data);
		 });
		}
	
    }
    
                   
                     
           
});