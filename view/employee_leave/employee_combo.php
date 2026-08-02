 <?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$result_customer = mysqli_query($varDBConnection,"Select employee_id,employee_name,employee_code from tbl_employees where employee_status='Active'");

?>


<!--<div class="col-lg-4 col-md-4 col-sm-12" style="padding-right:1px;">	-->
<span class="form-text text-muted font-weight-bold"><font color="black">Select Employee&nbsp;<span style="color:red;">*</span></font></span>
     <select data-placeholder="Select Employee" id="select_employee_for_leave" class="form-control form-control-select2" data-fouc>
         <option value="select">Select Employee</option>
        <?PHP 	while($row_employee=mysqli_fetch_assoc($result_customer)) { ?>
          <option value="<?PHP echo $row_employee['employee_id']; ?>"><?PHP echo $row_employee['employee_code'].' - '. $row_employee['employee_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	
<!--</div>-->