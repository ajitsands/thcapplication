<?php
class DBConnection
{

    function ConnectToMYSQL()
    {
        $is_local = false;
        if (php_sapi_name() === 'cli') {
            $is_local = true;
        } else {
            $http_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
            $server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
            if (stripos($http_host, 'localhost') !== false || stripos($http_host, '127.0.0.1') !== false || stripos($server_name, 'localhost') !== false) {
                $is_local = true;
            }
        }

        if ($is_local) {
            $host = "localhost";
            $user = "root";
            $pass = "S@nds1@b";
            $db   = "db_thc";
        } else {
            $host = "localhost";
            $user = "thcfm_application_user";
            $pass = "S@nds1@b";
            $db   = "thcfm_application_db";
        }

        $con = @mysqli_connect($host, $user, $pass, $db);

        if (!$con) {
            if ($is_local) {
                $con = @mysqli_connect("localhost", "thcfm_application_user", "S@nds1@b", "thcfm_application_db");
            } else {
                $con = @mysqli_connect("localhost", "root", "S@nds1@b", "db_thc");
            }
        }

        if (!$con) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $con;
    }


}



?>
