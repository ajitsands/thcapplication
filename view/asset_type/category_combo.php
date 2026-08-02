<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");

	
			
	
?>


<div class="col-lg-6 col-md-6 col-sm-12" id="div_category_select">	
    
     <span class="form-text text-muted font-weight-bold"><font color="black">Category&nbsp;<span style="color:red;">*</span> </font></span>
     <select class="form-control form-control-select2" id="select_category" data-placeholder="Select Category" data-fouc tabindex=1>
	    <option value="select">Select Category</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['category_id']; ?>"><?PHP echo $row['category_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
</div>