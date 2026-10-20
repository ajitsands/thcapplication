<?php
require_once __DIR__ . '/model/common/session_init.php';
thc_session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true") {
    require_once __DIR__ . '/view/template/includes/en_de_header.inc';
    $OBJ = new URLEncription();
    $varEncode = $OBJ->URLEncode('title=dashboard');
    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'Customer') {
        header("Location: view/dashboard_customer.php?param=" . $varEncode);
    } else {
        header("Location: view/dashboard.php?param=" . $varEncode);
    }
    exit();
}

header("Location: view/login.php");
exit();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=view/login.php">
    <script>window.location.href = "view/login.php";</script>
</head>
<body>
    <p>Redirecting to <a href="view/login.php">Login</a>...</p>
</body>
</html>