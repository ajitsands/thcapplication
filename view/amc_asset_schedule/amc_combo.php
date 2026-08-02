<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result_amc = mysqli_query($varDBConnection,"Select amc_id,amc_ref_no from  tbl_amc_master where amc_status='Active' and customer_code='".$_POST['v_amc_cust_code']."'");

?>


<!--<div class="col-lg-4 col-md-4 col-sm-6" style="padding-right:1px;">	-->
     <select data-placeholder="Select AMC" id="select_amc_for_schedule" class="form-control form-control-select2" data-fouc>
         <option value="select">Select AMC</option>
        <?PHP 	while($row_amc=mysqli_fetch_assoc($result_amc)) { ?>
          <option value="<?PHP echo $row_amc['amc_id']; ?>"><?PHP echo $row_amc['amc_id'].'-'.$row_amc['amc_ref_no']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">Select AMC&nbsp;<span style="color:red;">*</span></font></span>
<!--</div>-->