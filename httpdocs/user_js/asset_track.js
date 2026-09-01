$(document).ready(function(){
    var v_btn_search_assets = $('#btn_search_assets').ladda();
   
    $(":input:not(:hidden)").each(function (i) { $(this).attr('tabindex', i + 1); });
    
    $("#btn_search_assets").click(function(){
        var asset_code = $.trim($('#txt_asset_barcode').val());
		
		if (asset_code === '') {
		    swal("Warning", "Please provide the asset barcode ...", "warning");
            return false;  
		} else {
            list_primary_details(asset_code);
		}
	}); 

    $('#txt_asset_barcode').keypress(function(e) {
        if (e.which == 13) {
            $("#btn_search_assets").click();
            return false;
        }
    });

    function list_primary_details(asset_code) {
        v_btn_search_assets.ladda('start');
        $.ajax({
            type: "POST",
            url: "track_assets/track_assets_primary_info.php",
            data: { asset_code: asset_code } 
        }).done(function(data){
            v_btn_search_assets.ladda('stop');
            $("#div_asset_basic_info").html(data);
        }).fail(function(){
            v_btn_search_assets.ladda('stop');
            swal("Error", "Failed to fetch asset details. Please try again.", "error");
        });
    }
});