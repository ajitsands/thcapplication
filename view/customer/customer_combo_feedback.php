<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select customer_code,customer_name from tbl_customers ");
 	$result_contract = mysqli_query($varDBConnection,"Select contract_type_id ,contract_type_name from tbl_contract_types where contract_type_status='Active' ");
?>

<div class="col-lg-4 col-md-12 col-sm-12" id="div_contract_select"> 
    	 <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Category&nbsp;</font></span>
     <select data-placeholder="Select Category" id="select_category" class="form-control form-control-select2" data-fouc>
         <option value="All">All</option>
        <?PHP 	while($row_contract=mysqli_fetch_assoc($result_contract)) { ?>
          <option value="<?PHP echo $row_contract['contract_type_id']; ?>"><?PHP echo $row_contract['contract_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
   
</div> 
<div class="col-lg-4 col-md-12 col-sm-12" id="div_customer_select"> 
    	 <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Customer&nbsp;</font></span>
     <select data-placeholder="Select Customer" id="select_customer" class="form-control form-control-select2" data-fouc>
         <option value="All">All</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['customer_code']; ?>"><?PHP echo $row['customer_name']; ?></option>
        
        <?PHP } ?>
      </select>
   
</div> 