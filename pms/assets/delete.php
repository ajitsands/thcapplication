<?PHP



$servername = "localhost";
	$username = "sianlab_sianlab";
	$password = "s@nds1@b";
	$dbname = "sianlab_blogger";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if($_POST['value']=='0')
	{

	$sql = " UPDATE tbl_customer set status='Pending',event_color='#ff7800' WHERE customer_id=".$_POST['id'];
	}
	else if($_POST['value']=='1')
	{
	$sql = " UPDATE tbl_customer set status='Confirmed',event_color='#70bf00' WHERE customer_id=".$_POST['id'];
	
	}
	else if($_POST['value']=='2')
	{
	$sql = " UPDATE tbl_customer set status='Completed',event_color='#1672dc' WHERE customer_id=".$_POST['id'];
	
	}
    else if($_POST['value']=='3')
	{
	$sql = " UPDATE tbl_customer set status='Cancelled',event_color='#fc0307' WHERE customer_id=".$_POST['id'];
	
	}
	if ($conn->query($sql) === TRUE) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	?>