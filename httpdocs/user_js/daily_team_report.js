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
		
		if(start_date=='' )
		{
		    swal("Warning","Please specify the date ...", "warning");
          
            return false;  
		}

		else
		{
		   
           $.ajax({
		type: "POST",
		url: "daily_reports/list_daily_teams.php",
		data: {start_date:start_date} 
		 }).done(function(data){
		     
			$("#div_list_teams").html(data);
		 });
		}
	
    }
    
                   
                     
           
});