<?php
// Diagnostic file - DELETE after fixing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>PHP Version: " . phpversion() . "</h2>";
echo "<hr>";

// Test 1: DB Connection
echo "<h3>Test 1: Database Connection</h3>";
$con = @mysqli_connect("localhost", "root", "S@nds1@b", "db_thc");
if (!$con) {
    echo "<span style='color:red'>❌ DB Connection FAILED: " . mysqli_connect_error() . " (errno: " . mysqli_connect_errno() . ")</span><br>";
} else {
    echo "<span style='color:green'>✅ DB Connection OK</span><br>";
    mysqli_close($con);
}

echo "<hr>";

// Test 2: Include chain
echo "<h3>Test 2: Include Files</h3>";

$includes = [
    '../../model/db_connection/connection.php',
    '../../view/template/includes/en_de_header.inc',
    '../../qr/qrlib.php',
];

foreach ($includes as $inc) {
    $fullpath = realpath(__DIR__ . '/' . $inc);
    if ($fullpath && file_exists($fullpath)) {
        echo "<span style='color:green'>✅ Found: $inc</span><br>";
    } else {
        echo "<span style='color:red'>❌ Missing: $inc</span><br>";
    }
}

echo "<hr>";

// Test 3: Load common_functions
echo "<h3>Test 3: Load common_functions.php</h3>";
try {
    require_once('../../model/common/common_functions.php');
    echo "<span style='color:green'>✅ common_functions.php loaded OK</span><br>";
} catch (Throwable $e) {
    echo "<span style='color:red'>❌ Error: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine() . "</span><br>";
}

echo "<hr>";
echo "<p><b>Diagnostics complete. Delete this file after fixing!</b></p>";
?>
