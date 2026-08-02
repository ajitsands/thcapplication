<?php
$mysqli = new mysqli("localhost","sianlab_thc_user","s@nds1@b","sianlab_db_thc");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
else echo "Success!";
?>
