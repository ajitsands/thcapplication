<?php include(__DIR__ . '/../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
$result = mysqli_query($varDBConnection,"Select DISTINCT username from tbl_login_logout_log ");
?>

<div class="col-lg-4 col-md-4 col-sm-12" id="div_username_select">
    <label class="font-weight-bold text-dark">Username</label>	
    <select data-placeholder="Select Username" id="select_username" class="form-control form-control-select2" data-fouc>
        <option value="All">All</option>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
        <?php } ?>
    </select>
</div> 