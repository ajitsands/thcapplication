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
// class AcntConnection
// {

//     function ConnectToMYSQLAcnts()
//     {
        
//       $acnt_con = mysqli_connect("localhost","sianlab_accountsuser","s@nds1@b","sianlab_accounts");

//       if (mysqli_connect_errno())
//         {
//         echo "Failed to connect to MySQL: " . mysqli_connect_error();
//         }
//         return $acnt_con;
//     }


// }


?>
