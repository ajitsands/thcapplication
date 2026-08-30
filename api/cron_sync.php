<?php
/**
 * Cron Job Data Sync Runner
 * Usage in cPanel Cron:
 * php /home/thcfm/public_html/portal.thcfm.com/api/cron_sync.php
 */

$_GET['action'] = 'run_sync';
$_GET['token']  = 'thc_sync_secure_key_2026_x89';
$_GET['json']   = '1';

require_once __DIR__ . '/sync_import.php';
