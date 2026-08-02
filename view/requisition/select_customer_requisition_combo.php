<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_prdt_cat_master = mysqli_query($varDBConnection,"Select distinct customer_id,customer_name from tbl_mateial_requisition");
?>


	
     <select id="select_customer_name" class="form-control form-control-select2" data-fouc tabindex=3>
         <option value="all">All</option>
        <?PHP 	while($row_prdt_cat_master=mysqli_fetch_assoc($result_prdt_cat_master)) { ?>
          <option value="<?PHP echo $row_prdt_cat_master['customer_id']; ?>"><?PHP echo $row_prdt_cat_master['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Customer Name</font></span>
