<?php
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
    $servername = "localhost";
    $userName   = "root";
    $dbPassword = "S@nds1@b";
    $dbName     = "db_thc";
} else {
    $servername = "localhost";
    $userName   = "thcfm_application_user";
    $dbPassword = "S@nds1@b";
    $dbName     = "thcfm_application_db";
}
?>