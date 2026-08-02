<?php

//insert.php

/*$connect = new PDO('mysql:host=localhost;dbname=sandsl23_invoice', 'sandsl23_invoice', 's@nds1@b');

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events 
 (title, start_event, end_event,backgroundColor) 
 VALUES (:title, :start_event, :end_event,:backgroundColor)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => $_POST['title'],
   ':start_event' => $_POST['start'],
   ':end_event' => $_POST['end'],
   ':backgroundColor' => $_POST['bgColor']
  )
 );
 
 echo $_POST['start'];
}

*/



	$servername = "localhost";
	$username = "sandsl23_invoice";
	$password = "s@nds1@b";
	$dbname = "sandsl23_invoice";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO events (title, start_event, end_event,backgroundColor)
	VALUES ('".trim($_POST['title'])."', '".trim($_POST['start'])."', '".trim($_POST['end'])."','".$_POST['bgColor']."')";

	if ($conn->query($sql) === TRUE) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();



?>