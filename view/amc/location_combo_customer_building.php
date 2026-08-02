<?PHP //include(__DIR__ . '/../../model/db_connection/connection.php');
//$DBConn = new DBConnection();
//$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_customer_building = mysqli_query($varDBConnection,"Select distinct building_name,building_code from  tbl_customer_location ");
?>


<div class="col-lg-5 col-md-5 col-sm-11" id="div_select_building">	
	<span class="form-text text-muted font-weight_bold"><font color="black">Select Facility &nbsp;<span style="color:red;">*</span></font></span>  
     <select data-placeholder="Select Building" id="select_building_for_location" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Facility</option>
        <?PHP 	while($row_customer_building=mysqli_fetch_assoc($result_customer_building)) { ?>
          <option value="<?PHP echo $row_customer_building['building_code']; ?>"><?PHP echo $row_customer_building['building_code']."--".$row_customer_building['building_name']; ?></option>
        
        <?PHP } ?>
      </select>
       
</div>