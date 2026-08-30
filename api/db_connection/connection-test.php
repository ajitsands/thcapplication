<?php
$mysqli = new mysqli("localhost","root","S@nds1@b","db_thc");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
else echo "Success!";
?>
