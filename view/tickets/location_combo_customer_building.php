<?PHP //include(__DIR__ . '/../model/db_connection/connection.php');
//$DBConn = new DBConnection();
//$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_customer_building = mysqli_query($varDBConnection,"Select  building_id,building_name,building_code from  tbl_building where building_status='Active'");
?>


<div class="col-lg-4 col-md-6 col-sm-12" id="div_select_building">	
	<span class="form-text text-muted font-weight-bold"><font color="black">Building &nbsp;<span style="color:red;">*</span></font></span> 
     <select data-placeholder="Select Building" id="select_building_for_location" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Building</option>
         <option value="All">All</option>
        <?PHP 	while($row_customer_building=mysqli_fetch_assoc($result_customer_building)) { ?>
          <option value="<?PHP echo $row_customer_building['building_id']; ?>"><?PHP echo $row_customer_building['building_code']."--".$row_customer_building['building_name']; ?></option>
        
        <?PHP } ?>
      </select>
        
</div>