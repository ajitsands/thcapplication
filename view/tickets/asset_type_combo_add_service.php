<?PHP


include "../../model/db_connection/connection.php" ;
 
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	//$result = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from   tbl_asset_type where asset_type_status='Active'");
 	
 	$result = mysqli_query($varDBConnection,"select asset_type_id,asset_type_name from   tbl_asset_type where asset_type_status='Active' and category_id=".$_GET["category_id"]);
	
?>

<span class="form-text text-muted font-weight-bold"><font color="black">Asset Type&nbsp;<span style="color:red;">*</span> </font></span>

     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
    <select class="form-control form-control-select2 typeservices" id="select_asset_type_add_services" data-placeholder="Select Type" data-fouc>
    
	    <option value="Select Type">Select Type</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['asset_type_id']; ?>"><?PHP echo $row['asset_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
 <script>
        
        $('.typeservices').select2();
        
        
              
    </script>