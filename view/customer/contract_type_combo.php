<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select contract_type_id ,contract_type_name from tbl_contract_types where contract_type_status='Active' ");
?>


<div class="col-lg-3 col-md-6 col-sm-12" id="div_contract_select"> 
     <label class="font-weight-bold text-dark">Category</label>
     <select data-placeholder="Select Category" id="select_category" class="form-control form-control-select2" data-fouc>
         <option value="0">Select</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['contract_type_id']; ?>"><?PHP echo $row['contract_type_name']; ?></option>
        
        <?PHP } ?>
      </select>
   
</div> 