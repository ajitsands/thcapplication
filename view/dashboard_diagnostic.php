<?php
// Dashboard Diagnostic - DELETE after fixing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>PHP " . phpversion() . " - Dashboard Diagnostic</h2>";

// Simulate session (fake login)
if (session_status() == PHP_SESSION_NONE) session_start();
$_SESSION['loggedin'] = true;
$_SESSION['username'] = 'TEST';
$_SESSION['user_id'] = 1;
$_SESSION['user_type'] = 'Admin';

echo "<hr><h3>Step 1: en_de_header.inc</h3>";
try {
    include_once('template/includes/en_de_header.inc');
    echo "<span style='color:green'>✅ OK</span><br>";
    
    $OBJ = new URLEncription();
    $encoded = $OBJ->URLEncode('head=dashboard');
    echo "Encoded URL param: <b>$encoded</b><br>";
    
    $decoded = $OBJ->URLDecode($encoded);
    echo "Decoded back: <b>" . print_r($decoded, true) . "</b><br>";
} catch (Throwable $e) {
    echo "<span style='color:red'>❌ " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr><h3>Step 2: session_check.php</h3>";
try {
    ob_start();
    include_once('template/session_check.php');
    $out = ob_get_clean();
    echo "<span style='color:green'>✅ OK</span> Output: " . htmlspecialchars($out) . "<br>";
} catch (Throwable $e) {
    ob_end_clean();
    echo "<span style='color:red'>❌ " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr><h3>Step 3: head.inc</h3>";
try {
    ob_start();
    include_once('template/head.inc');
    $out = ob_get_clean();
    echo "<span style='color:green'>✅ OK (" . strlen($out) . " bytes)</span><br>";
} catch (Throwable $e) {
    ob_end_clean();
    echo "<span style='color:red'>❌ " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr><h3>Step 4: left_menu.inc</h3>";
try {
    ob_start();
    include_once('template/left_menu.inc');
    $out = ob_get_clean();
    echo "<span style='color:green'>✅ OK (" . strlen($out) . " bytes)</span><br>";
} catch (Throwable $e) {
    ob_end_clean();
    echo "<span style='color:red'>❌ " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr><h3>Step 5: common_functions.php (DB)</h3>";
try {
    require_once(__DIR__ . '/../model/common/common_functions.php');
    $model = new CommonModel();
    echo "<span style='color:green'>✅ DB Connected OK</span><br>";
} catch (Throwable $e) {
    echo "<span style='color:red'>❌ " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr><p><b>Done! Delete this file after fixing.</b></p>";
?>
