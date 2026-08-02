
<?PHP
include "../../model/db_connection/connection.php" ;

$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();
 	$result = mysqli_query($varDBConnection,"SELECT employee_name,employee_id  from tbl_employees where employee_id in (28)");
 	while($row=mysqli_fetch_assoc($result)) {
 	    echo $row['employee_name']."---".$row['employee_id'];
 	  //  $sql="call CapitalizeWords('".$row['employee_name']."',".$row['employee_id'].")";
 	    echo $sql;
 	  // mysqli_query($varDBConnection,$sql);
 	    
 	}

	?>

 
 
 
 
 
 
