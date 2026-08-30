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
            // Turn off default fatal exception throwing in PHP 8.1+ so errors can be handled smoothly
            mysqli_report(MYSQLI_REPORT_OFF);

            // Detect if running on localhost / development or production server (portal.thcfm.com)
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
                // Local Development Environment
                $host = "localhost";
                $user = "root";
                $pass = "S@nds1@b";
                $db   = "db_thc";
            } else {
                // Production Server: portal.thcfm.com
                $host = "localhost";
                $user = "thcfm_application_user";
                $pass = "S@nds1@b";
                $db   = "thcfm_application_db";
            }

            $con = @mysqli_connect($host, $user, $pass, $db);

            // Fallback between localhost / 127.0.0.1 and environments if initial attempt fails
            if (!$con) {
                if ($is_local) {
                    $con = @mysqli_connect("127.0.0.1", "root", "S@nds1@b", "db_thc");
                    if (!$con) {
                        $con = @mysqli_connect("localhost", "thcfm_application_user", "S@nds1@b", "thcfm_application_db");
                    }
                } else {
                    $con = @mysqli_connect("127.0.0.1", "thcfm_application_user", "S@nds1@b", "thcfm_application_db");
                    if (!$con) {
                        $con = @mysqli_connect("localhost", "root", "S@nds1@b", "db_thc");
                    }
                }
            }

            return $con;
        }


    }
}
