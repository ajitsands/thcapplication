<?PHP include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

 	$result = mysqli_query($varDBConnection,"select employee_id,employee_code,employee_name, group_concat(expertise_id) as expertise_id , group_concat(expertise_name) as expertise_name from tbl_technician_expertise q where employee_id NOT IN (SELECT employee_id from tbl_team )  group by employee_id, employee_name");

?>


<!--<div class="col-lg-6 col-md-6 col-sm-12" id="div_technician_select">	
     <select data-placeholder="Select expertise" id="select_expertise" class="form-control form-control-select2" data-fouc>-->
    <div class="col-lg-12 col-md-12 col-sm-12" id="div_technician_select">
     <select class="form-control form-control-multiselect" id="select_technician"  data-placeholder="Click to Select Technicians"  multiple="multiple" data-fouc>
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['employee_id'].'-->'.$row['employee_code']; ?>"><?PHP echo $row['employee_name'].'-->'.$row['expertise_name']; ?></option>
        
        <?PHP } ?>
      </select>
     
     	<span class="form-text text-muted"><font color="black">TECHNICIANS</font></span>
    </div> 	
<!--</div>-->

              
							