<?php
class DBConnection
{

    function ConnectToMYSQL()
    {
      $con = mysqli_connect("localhost","sianlab_thc_user","s@nds1@b","sianlab_db_thc");

      if (mysqli_connect_errno())
        {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $con;
    }


}



?>
