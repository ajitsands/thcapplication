$(document).ready(function(){
                 
    var v_btn_search_tickets = $('#btn_search_assets').ladda();
   
   $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
    $("#btn_search_assets").click(function(){
        
        var asset_code=$('#txt_asset_barcode').val();
		
		if(asset_code=='' )
		{
		    swal("Warning","Please provide the asset code ...", "warning");
          
            return false;  
		}

		else
		{
		   
          list_primary_details(asset_code);
		}
	
	
	}); 
	
	


    function list_primary_details(asset_code)
    {
        
	
		   
           $.ajax({
		type: "POST",
		url: "track_assets/track_assets_primary_info.php",
		data: {asset_code:asset_code} 
		 }).done(function(data){
		     
			$("#div_asset_basic_info").html(data);
		 });
	
    }
    
                   
                     
           
   
});