<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select contract_type_id ,contract_type_name from tbl_contract_types where contract_type_status='Active' ");
?>


<div class="col-lg-3 col-md-12 col-sm-12" id="div_contract_select"> 
    	 <span class="form-text text-muted font-weight-bold" style="color:black;"><font color="black">Category&nbsp;</font></span>
     <select data-placeholder="Select Category" id="select_category" class="form-control form-control-select2" data-fouc>
         <option value="0">Select</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['contract_type_id']; ?>"><?PHP echo $row['contract_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
   
</div> 