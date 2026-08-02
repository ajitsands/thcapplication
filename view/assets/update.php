<?PHP
     include "../../model/db_connection/connection.php" ;
     $DBConn = new DBConnection();
     $varDBConnection = $DBConn->ConnectToMYSQL();


   $result_amc = mysqli_query($varDBConnection,"UPDATE tbl_visits SET  date_of_visits='".$_POST['start']."' WHERE amc_visit_id=".$_POST['id']);
	

	$varDBConnection->close();
	?>