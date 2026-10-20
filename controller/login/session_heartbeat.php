<?php
/**
 * THC-FM Session Heartbeat
 * Keeps the session alive in the background while the user has the application open,
 * and notifies the client if the session has been purposefully destroyed/logged out.
 */
if (!headers_sent()) {
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
}

require_once __DIR__ . '/../../model/common/session_init.php';

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === 'true';
$username = $_SESSION['username'] ?? '';

// Close session explicitly before sending response
@session_write_close();

if (!$isLoggedIn) {
    echo json_encode([
        'status'  => 'expired',
        'message' => 'Session has expired or was terminated.'
    ]);
    exit();
}

echo json_encode([
    'status'   => 'active',
    'username' => $username,
    'time'     => date('Y-m-d H:i:s')
]);

