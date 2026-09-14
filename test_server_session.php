<?php
if (session_status() == PHP_SESSION_NONE) {
    $savePath = session_save_path();
    if (empty($savePath) || !is_dir($savePath) || !is_writable($savePath)) {
        session_save_path(sys_get_temp_dir());
    }
    session_start();
}
echo "session_id: " . session_id() . "\n";
echo "session_save_path: " . session_save_path() . "\n";
echo "is_dir: " . (is_dir(session_save_path()) ? 'yes' : 'no') . "\n";
echo "is_writable: " . (is_writable(session_save_path()) ? 'yes' : 'no') . "\n";
