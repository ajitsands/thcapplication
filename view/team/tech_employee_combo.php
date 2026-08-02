<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select employee_id,employee_type_id,employee_type_name,employee_code,employee_name from tbl_employees where employee_type_name='Team Leader' and employee_status='Active' and employee_id NOT IN ( select employee_id from tbl_team where team_status='Active')");

	
			
	
?>


<div class="col-lg-6 col-md-6 col-sm-12" id="div_team_leader_select">	
     <!--<select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
     <select class="form-control form-control-select2" id="select_team_leader" data-placeholder="Select Team Leader" data-fouc>
	    <option value="select">Select Team Leader</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['employee_id'].'-'.$row['employee_code']; ?>"><?PHP echo $row['employee_name']; ?></option>
        
        <?PHP } ?>
      </select>
     	<span class="form-text text-muted"><font color="black">TEAM LEADER</font></span>
</div>