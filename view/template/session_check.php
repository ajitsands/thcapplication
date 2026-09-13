<?php
if (session_status() == PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== "true")
{
    echo "<script type='text/javascript'>window.location.href='login.php';</script>";
    exit();
}
?>