<?php
/**
 * THC-FM Centralized Persistent Session Manager
 *
 * Configures persistent session storage and long-lived cookies (30 days)
 * so users remain logged in across pages and browser restarts until they
 * explicitly click Logout or session values are purposefully destroyed.
 */

require_once __DIR__ . '/json_polyfill.php';

if (!function_exists('thc_session_start')) {
    function thc_session_start() {
        // 30 days session lifetime in seconds (30 * 24 * 60 * 60)
        $lifetime = 2592000;

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            if (!headers_sent()) {
                ini_set('session.gc_maxlifetime', (string)$lifetime);
                ini_set('session.cookie_lifetime', (string)$lifetime);

                // Dedicated session directory in project root to prevent OS temp cleanup
                $sessionDir = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'sessions';
                $useProjectSessionDir = false;

                if (!is_dir($sessionDir)) {
                    @mkdir($sessionDir, 0777, true);
                    @chmod($sessionDir, 0777);
                }

                if (is_dir($sessionDir)) {
                    // Physical write test to verify Apache/PHP user can create files here
                    $testFile = $sessionDir . DIRECTORY_SEPARATOR . '.test_' . uniqid('', true);
                    if (@file_put_contents($testFile, '1') !== false) {
                        @unlink($testFile);
                        $useProjectSessionDir = true;
                    }
                }

                if ($useProjectSessionDir) {
                    session_save_path($sessionDir);
                } else {
                    // Keep server's configured session_save_path if it is already valid and writable
                    $currentPath = session_save_path();
                    $isCurrentValid = !empty($currentPath) && @is_dir($currentPath);
                    if (!$isCurrentValid) {
                        $tempDir = sys_get_temp_dir();
                        $testTemp = $tempDir . DIRECTORY_SEPARATOR . '.test_' . uniqid('', true);
                        if (@file_put_contents($testTemp, '1') !== false) {
                            @unlink($testTemp);
                            session_save_path($tempDir);
                        }
                    }
                }

                $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                    || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

                if (PHP_VERSION_ID >= 70300) {
                    session_set_cookie_params([
                        'lifetime' => $lifetime,
                        'path'     => '/',
                        'domain'   => '',
                        'secure'   => $isSecure,
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                } else {
                    session_set_cookie_params($lifetime, '/; samesite=Lax', '', $isSecure, true);
                }
            }

            @session_start();
        }

        // Rolling renewal: refresh cookie expiration once per active request
        static $cookieRenewed = false;
        if (!$cookieRenewed && session_status() === PHP_SESSION_ACTIVE && !headers_sent() && session_id() !== '') {
            $cookieRenewed = true;
            $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

            if (PHP_VERSION_ID >= 70300) {
                setcookie(session_name(), session_id(), [
                    'expires'  => time() + $lifetime,
                    'path'     => '/',
                    'domain'   => '',
                    'secure'   => $isSecure,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            } else {
                setcookie(session_name(), session_id(), time() + $lifetime, '/; samesite=Lax', '', $isSecure, true);
            }
        }
    }
}

// Auto-initialize persistent session
thc_session_start();

// Ensure clean session shutdown without unhandled fatal errors
if (!defined('THC_SESSION_SHUTDOWN_REGISTERED')) {
    define('THC_SESSION_SHUTDOWN_REGISTERED', true);
    register_shutdown_function(function() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            @session_write_close();
        }
    });
}

