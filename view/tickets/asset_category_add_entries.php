<?PHP
include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select category_id,category_name from  tbl_category where category_status='Active'");
	
?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Category&nbsp;<span style="color:red;">*</span> </font></span>
   
     <select class="form-control form-control-select2 classcategory_add_entries" id="select_category_add_entries" name="select_category_add_entries" data-placeholder="Select Category" data-fouc>
	    <option value="select">Select Category</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
	    
         <option value="<?PHP echo $row['category_id']; ?>" ><?PHP echo $row['category_name']; ?></option>
        <?PHP } ?>
      </select>
     


