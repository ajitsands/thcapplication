<?php
// Diagnostic file - DELETE after fixing
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>PHP Version: " . phpversion() . "</h2>";
echo "<hr>";

// Test 0: Git Commit / Branch Info
echo "<h3>Test 0: Git Branch & Commit</h3>";
$headFile = dirname(__DIR__, 2) . '/.git/HEAD';
if (file_exists($headFile)) {
    $head = trim(file_get_contents($headFile));
    echo "HEAD: <b>" . htmlspecialchars($head) . "</b><br>";
    if (strpos($head, 'ref:') === 0) {
        $refPath = dirname(__DIR__, 2) . '/.git/' . trim(substr($head, 4));
        if (file_exists($refPath)) {
            echo "Commit: <b>" . trim(file_get_contents($refPath)) . "</b><br>";
        }
    }
} else {
    echo "No .git/HEAD found.<br>";
}

echo "<hr>";

// Test 1: Sessions Check
echo "<h3>Test 1: Session Directory & Save Path</h3>";
$sessionDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'sessions';
echo "Project sessions dir: $sessionDir<br>";
echo "is_dir: " . (is_dir($sessionDir) ? 'YES' : 'NO') . "<br>";
if (is_dir($sessionDir)) {
    echo "is_writable: " . (is_writable($sessionDir) ? 'YES' : 'NO') . "<br>";
    $testFile = $sessionDir . DIRECTORY_SEPARATOR . '.test_' . uniqid('', true);
    $canWrite = @file_put_contents($testFile, '1');
    echo "Physical file write test: " . ($canWrite !== false ? "<span style='color:green'>✅ SUCCEEDED</span>" : "<span style='color:red'>❌ FAILED</span>") . "<br>";
    if ($canWrite !== false) {
        @unlink($testFile);
    }
}
echo "session_save_path(): " . session_save_path() . "<br>";
echo "sys_get_temp_dir(): " . sys_get_temp_dir() . "<br>";
echo "open_basedir: " . ini_get('open_basedir') . "<br>";

echo "<hr>";

// Test 2: Error Logs
echo "<h3>Test 2: Server Error Logs</h3>";
$logFiles = [
    __DIR__ . '/error_log',
    dirname(__DIR__, 2) . '/error_log',
    ini_get('error_log')
];
foreach ($logFiles as $logFile) {
    if (!empty($logFile) && file_exists($logFile)) {
        echo "<b>Found: $logFile</b> (" . filesize($logFile) . " bytes)<br>";
        $lines = file($logFile);
        $lastLines = array_slice($lines, -15);
        echo "<pre style='background:#f4f4f4;padding:8px;border:1px solid #ccc;max-height:200px;overflow:auto;'>" . htmlspecialchars(implode("", $lastLines)) . "</pre>";
    }
}

echo "<hr>";

// Test 3: Load common_functions & loginController
echo "<h3>Test 3: Execute loginController with Test Credentials</h3>";
try {
    require_once('../../model/common/common_functions.php');
    echo "<span style='color:green'>✅ common_functions.php loaded OK</span><br>";

    $_POST['action'] = 'login';
    $_POST['v_username'] = 'CGTHCFM';
    $_POST['v_password'] = 'wrongpass_test';

    require_once(__DIR__ . '/login_controller.php');
    echo "<span style='color:green'>✅ login_controller.php executed OK</span><br>";
} catch (Throwable $e) {
    echo "<span style='color:red'>❌ EXCEPTION: " . htmlspecialchars($e->getMessage()) . "<br>File: " . $e->getFile() . ":" . $e->getLine() . "<br><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></span>";
}

echo "<hr>";
echo "<p><b>Diagnostics complete. Delete this file after fixing!</b></p>";
?>
