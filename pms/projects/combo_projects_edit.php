<?PHP
include "../../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"select project_id,project_name from  tbl_project where project_status='Active'");
	
?>


	<span class="form-text text-muted font-weight-bold"><font color="black">Select Project&nbsp;<span style="color:red;">*</span> </font></span>

   
     <select class="form-control form-control-select2 " id="select_project_edit" name="select_project_edit" data-placeholder="Select Project" data-fouc>
	    <option value="0" >Select Project</option>
	    
	    <?PHP 	while($row=mysqli_fetch_assoc($result)) { 
	    if($_POST['project_ids']==$row['project_id'])
	    { ?>
	        <option value="<?PHP echo $row['project_id']; ?>" selected><?PHP echo $row['project_name']; ?></option>
	    <?php }
	    else
	    { ?>
	    <option value="<?PHP echo $row['project_id']; ?>" ><?PHP echo $row['project_name']; ?></option>
	    <?php }?>
          
        <?php } ?>
      </select>
     

