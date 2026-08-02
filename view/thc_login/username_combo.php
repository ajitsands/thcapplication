<?PHP include "../model/db_connection/connection.php" ;
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"Select DISTINCT username from tbl_login_logout_log ");
?>


<div class="col-lg-4 col-md-4 col-sm-4" id="div_username_select">
    	<span class="form-text text-muted font-weight-bold"><font color="black">Username</font></span>	
     <select data-placeholder="Select Employee Type" id="select_username" class="form-control form-control-select2" data-fouc>
         <option value="All">All</option>
        <?PHP 	while($row=mysqli_fetch_assoc($result)) { ?>
          <option value="<?PHP echo $row['username']; ?>"><?PHP echo $row['username']; ?></option>
        
        <?PHP } ?>
      </select>
     
</div> 