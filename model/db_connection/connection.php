<?php

// -------------------------------------------------------
// APP_ROOT: Absolute path to the application root (thc/)
// Defined here so all files that include connection.php
// can rely on it for their own relative includes.
// -------------------------------------------------------
if (!defined('APP_ROOT')) {
    define('APP_ROOT', realpath(__DIR__ . '/../../'));
}

// Set include_path so PHP can find files relative to APP_ROOT
// This fixes "No such file or directory" errors when files are
// included from a different working directory (e.g. view/dashboard.php
// including view/dashboard/dashboard_bar_chart.php which then tries
// to include ../../model/... )
set_include_path(get_include_path() . PATH_SEPARATOR . APP_ROOT);

if (!class_exists('DBConnection')) {
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
}
