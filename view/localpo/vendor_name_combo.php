<?PHP  include(__DIR__ . '/../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select DISTINCT vendor_id,vendor_name from tbl_vendors");
	
			
	
?>


<div class="col-lg-4 col-md-6 col-sm-12" id="div_vendor_select">	
     <select data-placeholder="Select Vendor Name" id="select_vendor" class="form-control form-control-select2" data-fouc tabindex=2>
         <option value="select">Select Vendor Name</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['vendor_id']; ?>"><?PHP echo $row['vendor_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">VENDOR NAME</font></span>
</div>