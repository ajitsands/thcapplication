<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select product_item_id,product_item_name from tbl_product_items");
	
			
	
?>


<div class="col-lg-6 col-md-6 col-sm-12" id="div_item_select">	
     <select data-placeholder="Select Item Name" id="select_item" class="form-control form-control-select2" data-fouc>
         <option value="select">SELECT ITEM NAME</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['product_item_id']; ?>"><?PHP echo $row['product_item_name']; ?></option>
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">ITEM NAME</font></span>
</div>