<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select customer_id,customer_name from tbl_customers ");
?>


<div class="col-lg-4 col-md-4 col-sm-4" id="div_customer_select"> 
    <span class="form-text text-muted font-weight-bold"><font color="black">Customer&nbsp;<span style="color:red;">*</span></font></span>	
     <select data-placeholder="Select Customer" id="select_customer_feedback" class="form-control form-control-select2" data-fouc>
         <option value="All">All</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['customer_id']; ?>"><?PHP echo $row['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
</div> 