<?php
require_once __DIR__ . '/../../model/common/session_init.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== "true")
{
    echo "<script type='text/javascript'>window.location.href='login.php';</script>";
    exit();
}
?>