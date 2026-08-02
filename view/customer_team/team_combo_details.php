<?PHP include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$result_team = mysqli_query($varDBConnection,"SELECT `employee_id`,`employee_code`,`employee_name`,`employee_type_name` FROM `tbl_employees` WHERE `employee_type_id`='8' OR `employee_type_id`='6' AND `employee_status`='Active';");
?>
<span class="form-text text-muted font-weight-bold"><font color="black">Teams &nbsp;<span style="color:red;">*</span></font></span>  
    <select data-placeholder="Select Customer Name" id="select_customer_team" class="form-control form-control-select2" multiple>
         <option value="select" disabled>Select Team</option>
        <?PHP 	while($row_team=mysqli_fetch_assoc($result_team)) { ?>
          <option value="<?PHP echo $row_team['employee_id']; ?>"><?PHP echo $row_team['employee_code'].'--'.$row_team['employee_name']; ?></option>
        <?PHP } ?>
    </select>