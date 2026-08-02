<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

$cus_id=$_POST['v_cust_id'];
 $result_building = mysqli_query($varDBConnection,"select DISTINCT location_id,asset_building from  tbl_assets where customer_id='".$cus_id."'");
	
?>



     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_building" data-placeholder="Select Building" data-fouc>
	    <option>Select Building</option>
	    
	   <?PHP 	while($row_building=mysqli_fetch_assoc($result_building)) { ?>
          <option value="<?PHP echo $row_building['location_id']; ?>"><?PHP echo $row_building['asset_building']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">BUILDING&nbsp;<span style="color:red;">*</span> </font></span>
