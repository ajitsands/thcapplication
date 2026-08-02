<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_SESSION["loggedin"]!="true")
{
    //header("Location: ../index.php"); /* Redirect browser */
    //echo '<script>window.location="http://"'+location.hostname+'"/index.php"</script>';
        $URL="http://".$_SERVER['SERVER_NAME']."/index.php";
        echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    
    exit();
}


?>