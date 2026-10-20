<?php
/**
 * THC-FM Centralized Persistent Session Manager
 *
 * Configures persistent session storage and long-lived cookies (30 days)
 * so users remain logged in across pages and browser restarts until they
 * explicitly click Logout or session values are purposefully destroyed.
 */

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
                if (!is_dir($sessionDir)) {
                    @mkdir($sessionDir, 0777, true);
                }

                if (is_dir($sessionDir) && is_writable($sessionDir)) {
                    session_save_path($sessionDir);
                } else {
                    $savePath = session_save_path();
                    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
                        session_save_path(sys_get_temp_dir());
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

        // Rolling renewal: refresh cookie expiration on each active request
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
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
