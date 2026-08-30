<?php
class DBConnection
{

    function ConnectToMYSQL()
    {
      $con = mysqli_connect("localhost","root","S@nds1@b","db_thc");

      if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $con;
    }


}



?>
