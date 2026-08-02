<?PHP  
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();


	$result_customer_building = mysqli_query($varDBConnection,"Select building_id,building_name,building_code from  tbl_building where building_status='Active' ");
 	


 	
?>
<span class="form-text text-muted font-weight-bold"><font color="black">Select Facility &nbsp;<span style="color:red;">*</span></font></span> 
	
                                 <select data-placeholder="Select Building" id="select_building_for_location" name="select_building_for_location" class="form-control form-control-select2" data-fouc>
                                     <option value="select">Select Facility</option>
                                    <?PHP 	
                                    
                                    while($row_customer_building=mysqli_fetch_assoc($result_customer_building)) { ?>
                                      <option value="<?PHP echo $row_customer_building['building_id']; ?>"><?PHP echo $row_customer_building['building_code']."--".$row_customer_building['building_name']; ?></option>
                                    
                                    <?PHP } ?>
                                  </select>
     	
