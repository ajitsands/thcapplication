<?php
/**
 * THC Facility Management - Quotation Module
 * Fully styled with THC Modern Design System & Limitless Theme Stack
 */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

require_once __DIR__ . '/../model/common/session_init.php';
require_once __DIR__ . '/template/thc_logo.php';
include_once __DIR__ . '/template/includes/en_de_header.inc';
include_once __DIR__ . '/user_permission/permission_class/class_permission.php';

if (class_exists('URLEncription')) {
    $OBJ = new URLEncription();
    $OBJ->URLEncode('head=quotation');
}

// User session handling
$isLoggedIn = isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === "true" || $_SESSION["loggedin"] === true);
$currentUserCode = "MA";
$currentUserName = "Mohammed Ali";
$currentUserType = "Operations Manager";

$hasQuotationAccess = !$isLoggedIn; // Default true in dev without session; strictly enforced when logged in

if ($isLoggedIn) {
    if (!empty($_SESSION["user_name"])) {
        $currentUserName = $_SESSION["user_name"];
    }
    if (strtolower(trim($currentUserName)) === 'adminstrator') {
        $currentUserName = 'Administrator';
    }
    if (!empty($_SESSION["user_type"])) {
        $currentUserType = $_SESSION["user_type"];
    }
    if (!empty($_SESSION["username"])) {
        $empCode = $_SESSION["username"];
        $norm = strtolower(trim($currentUserName));
        if ($norm === 'adminstrator' || $norm === 'administrator' || $norm === 'admin' || strtoupper($empCode) === 'CGTHCFM') {
            $currentUserCode = 'ADM';
        } else {
            $words = preg_split('/[\s\-_]+/', trim($currentUserName));
            $inits = '';
            foreach ($words as $w) {
                if ($w !== '') $inits .= strtoupper(substr($w, 0, 1));
            }
            $currentUserCode = (strlen($inits) >= 2 && strlen($inits) <= 4) ? $inits : 'ADM';
        }
    }

    // Role-based quotation permission check:
    // Only accessible to: Administrator, Operation Manager, Operations Manager, and Operation Coordinator
    $allowedUserTypes = [
        'administrator',
        'operation manager',
        'operations manager',
        'operations manager (maintenance)',
        'operations manager (maint)',
        'operation coordinator',
        'operations coordinator',
        'operations cordinator'
    ];
    $normUserType = strtolower(trim($currentUserType));

    $hasQuotationAccess = in_array($normUserType, $allowedUserTypes);

    // Also check dynamic database permissions via UserPermisssion if assigned
    if (!$hasQuotationAccess && isset($_SESSION['USERROLLID'])) {
        $userId = (int)$_SESSION['USERROLLID'];
        if (!isset($obj) && class_exists('UserPermisssion')) {
            $obj = new UserPermisssion($userId);
        }
        if (isset($obj) && method_exists($obj, 'getUserPermissionsByUserID')) {
            $userPerms = $obj->getUserPermissionsByUserID($userId);
            if (is_array($userPerms)) {
                if (in_array('Quotation', $userPerms) || in_array('QuotationModule', $userPerms)) {
                    $hasQuotationAccess = true;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>THC FM – Quotations Management</title>

    <!-- Main Application Core & Theme CSS Stack -->
    <?PHP include_once('template/head.inc'); ?>
    <?PHP include_once('template/date_time.inc'); ?>

    <!-- Main Navigation Topnav & Icons -->
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
    <link href="assets/css/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        /* ==============================================================
           THC Modern Quotation Module Styling
           Inherits and extends THC Modern Theme & Limitless Bootstrap
           ============================================================== */

        :root {
            --q-navy-dark: #001D39;
            --q-navy-main: #0A4174;
            --q-navy-mid: #49769F;
            --q-blue-ice: #BDD8E9;
            --q-sky: #7BBDE8;
            --q-bg-soft: #f4f8fb;
            --q-border: #d4e4f0;
            --q-text-dark: #001D39;
            --q-text-muted: #5a6e85;
            --q-success: #059669;
            --q-warning: #d97706;
            --q-danger: #dc2626;
        }

        body {
            background-color: var(--q-bg-soft) !important;
            color: var(--q-text-dark) !important;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        /* Sub-navigation Header Toolbar */
        .thc-quotation-nav-card {
            background: #ffffff !important;
            border: 1px solid var(--q-border) !important;
            border-radius: 14px !important;
            box-shadow: 0 4px 18px rgba(0, 29, 57, 0.05) !important;
            margin-bottom: 22px !important;
        }

        aside.thc-subnav-aside,
        .thc-quotation-nav-card aside {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            background: transparent !important;
            border: none !important;
            width: 100% !important;
            padding: 4px 6px !important;
            box-shadow: none !important;
        }

        .thc-subnav-btn,
        aside a[data-v] {
            border-radius: 10px !important;
            padding: 9px 18px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            color: var(--q-navy-main) !important;
            background: #f0f6fa !important;
            border: 1.5px solid #d4e4f0 !important;
            text-decoration: none !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: all 0.2s ease !important;
        }
        .thc-subnav-btn:hover,
        aside a[data-v]:hover {
            background: #e2eef7 !important;
            color: var(--q-navy-dark) !important;
            transform: translateY(-1px) !important;
        }
        .thc-subnav-btn.on,
        aside a[data-v].on {
            background: linear-gradient(135deg, #001D39 0%, #0A4174 100%) !important;
            color: #ffffff !important;
            border-color: #001D39 !important;
            box-shadow: 0 4px 14px rgba(0, 29, 57, 0.25) !important;
        }

        #us {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: var(--q-navy-dark) !important;
            background-color: #f8fafc !important;
            border: 1.5px solid #c2daeb !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }

        /* Top Bar within View */
        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .top h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--q-navy-dark);
            margin: 0;
            font-family: 'Outfit', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.2px;
        }
        .top div {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Modern Action Buttons */
        button, .btn-action {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border: 1.5px solid #c2daeb;
            background: #ffffff;
            color: var(--q-navy-dark);
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 29, 57, 0.04);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        button:hover, .btn-action:hover {
            background: #f0f6fa;
            border-color: var(--q-navy-main);
            color: var(--q-navy-main);
            transform: translateY(-1px);
        }
        button.p {
            background: linear-gradient(135deg, #0A4174 0%, #49769F 100%) !important;
            border: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(10, 65, 116, 0.25) !important;
        }
        button.p:hover {
            background: linear-gradient(135deg, #49769F 0%, #4E8EA2 100%) !important;
            box-shadow: 0 6px 20px rgba(10, 65, 116, 0.35) !important;
            color: #ffffff !important;
        }
        button.d {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
            border: none !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25) !important;
        }
        button.d:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35) !important;
            color: #ffffff !important;
        }

        /* Ladda Progress Buttons */
        .ladda-button {
            position: relative !important;
        }
        .ladda-button .ladda-spinner {
            position: absolute !important;
            z-index: 2 !important;
            display: inline-block !important;
            width: 32px !important;
            height: 32px !important;
            top: 50% !important;
            margin-top: -16px !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
        .ladda-button[data-style="expand-right"][data-loading] {
            padding-right: 48px !important;
        }
        .ladda-button[data-style="expand-right"] .ladda-spinner {
            right: 12px !important;
        }
        .ladda-button[data-loading] {
            cursor: wait !important;
            opacity: 0.88 !important;
        }

        /* Modernized Form Inputs & Selects */
        input:not([type="checkbox"]):not([type="radio"]), select, textarea {
            font-family: 'Outfit', sans-serif !important;
            border-radius: 10px !important;
            border: 1.5px solid #c2daeb !important;
            padding: 9px 14px !important;
            font-size: 13.5px !important;
            background: #ffffff !important;
            color: var(--q-text-dark) !important;
            transition: all 0.2s ease !important;
        }
        input:not([type="checkbox"]):not([type="radio"]):focus, select:focus, textarea:focus {
            border-color: var(--q-navy-main) !important;
            box-shadow: 0 0 0 4px rgba(123, 189, 232, 0.3) !important;
            outline: none !important;
        }

        /* Select2 Searchable Dropdown Styling */
        .card.pad .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            font-family: 'Outfit', sans-serif !important;
            border-radius: 10px !important;
            border: 1.5px solid #c2daeb !important;
            height: 42px !important;
            background: #ffffff !important;
            padding: 5px 12px !important;
            display: flex !important;
            align-items: center !important;
            transition: all 0.2s ease !important;
        }
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--q-navy-main) !important;
            box-shadow: 0 0 0 4px rgba(123, 189, 232, 0.3) !important;
            outline: none !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 13.5px !important;
            color: var(--q-text-dark) !important;
            line-height: normal !important;
            padding-left: 0 !important;
            font-weight: 500 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #889bb0 !important;
            font-weight: 400 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 10px !important;
            display: flex !important;
            align-items: center !important;
        }
        .select2-dropdown {
            border: 1.5px solid #c2daeb !important;
            border-radius: 10px !important;
            box-shadow: 0 10px 30px rgba(0, 29, 57, 0.15) !important;
            background: #ffffff !important;
            z-index: 10050 !important;
            overflow: hidden !important;
        }
        .select2-container--default .select2-search--dropdown {
            padding: 8px 10px !important;
            background: #f8fafc !important;
            border-bottom: 1px solid #e2eef7 !important;
        }
        .select2-search--dropdown:after,
        .select2-search--dropdown:before,
        .select2-search:after,
        .select2-search:before {
            content: none !important;
            display: none !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1.5px solid #c2daeb !important;
            border-radius: 8px !important;
            padding: 7px 12px !important;
            padding-left: 12px !important;
            background-image: none !important;
            font-size: 13.5px !important;
            font-family: 'Outfit', sans-serif !important;
            outline: none !important;
            width: 100% !important;
            background-color: #ffffff !important;
            box-sizing: border-box !important;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: var(--q-navy-main) !important;
            box-shadow: 0 0 0 3px rgba(123, 189, 232, 0.3) !important;
        }
        .select2-results__option {
            padding: 9px 14px !important;
            font-size: 13.5px !important;
            font-family: 'Outfit', sans-serif !important;
            color: var(--q-text-dark) !important;
            transition: background 0.15s ease !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eaf3fb !important;
            color: var(--q-navy-dark) !important;
            font-weight: 600 !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #0A4174 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }

        /* Filter Toolbar Card - Enforced Single Horizontal Row */
        .card.bar,
        .filter-toolbar {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 10px !important;
            padding: 12px 18px !important;
            background: #ffffff !important;
            border: 1px solid var(--q-border) !important;
            border-radius: 12px !important;
            box-shadow: 0 3px 12px rgba(0, 29, 57, 0.05) !important;
            margin-bottom: 22px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }
        .card.bar .search-input-wrapper,
        .filter-toolbar .search-input-wrapper {
            position: relative !important;
            display: inline-flex !important;
            align-items: center !important;
            flex: 2 1 200px !important;
            min-width: 180px !important;
            max-width: 320px !important;
            height: 38px !important;
            margin: 0 !important;
        }
        .card.bar input#fq,
        .filter-toolbar input#fq {
            width: 100% !important;
            height: 38px !important;
            margin: 0 !important;
            padding: 7px 30px 7px 32px !important;
            font-size: 13.5px !important;
            border: 1.5px solid #c2daeb !important;
            border-radius: 10px !important;
            background: #ffffff !important;
            color: var(--q-navy-dark) !important;
            outline: none !important;
            transition: all 0.2s ease !important;
        }
        .card.bar input#fq:focus,
        .filter-toolbar input#fq:focus {
            border-color: #0A4174 !important;
            box-shadow: 0 0 0 3px rgba(10, 65, 116, 0.12) !important;
        }
        .card.bar input#fq::-webkit-search-cancel-button,
        .filter-toolbar input#fq::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
            display: none;
        }
        .card.bar #btn_clear_search,
        .filter-toolbar #btn_clear_search {
            position: absolute !important;
            right: 8px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            background: none !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 22px !important;
            height: 22px !important;
            border-radius: 50% !important;
            display: none;
            align-items: center !important;
            justify-content: center !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
            box-shadow: none !important;
            transition: all 0.15s ease !important;
            z-index: 5 !important;
        }
        .card.bar #btn_clear_search:hover,
        .filter-toolbar #btn_clear_search:hover {
            color: #ef4444 !important;
            background: #fee2e2 !important;
        }
        /* Prevent autofill styling on search box */
        input#fq:-webkit-autofill,
        input#fq:-webkit-autofill:hover, 
        input#fq:-webkit-autofill:focus,
        .filter-toolbar input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #001D39 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .tag-completed {
            background: #d1fae5 !important;
            color: #065f46 !important;
            border: 1px solid #a7f3d0 !important;
            font-weight: 600 !important;
        }
        .tag-expired {
            background: #ffedd5 !important;
            color: #9a3412 !important;
            border: 1px solid #fed7aa !important;
            font-weight: 600 !important;
        }
        .card.bar select,
        .filter-toolbar select {
            flex: 1 1 135px !important;
            min-width: 125px !important;
            max-width: 175px !important;
            height: 38px !important;
            margin: 0 !important;
            padding: 7px 12px !important;
            font-size: 13px !important;
            background-color: #ffffff !important;
        }
        .card.bar .select2-container,
        .filter-toolbar .select2-container {
            flex: 1 1 155px !important;
            min-width: 135px !important;
            max-width: 210px !important;
            width: auto !important;
            margin: 0 !important;
        }
        .card.bar .select2-container--default .select2-selection--single,
        .filter-toolbar .select2-container--default .select2-selection--single {
            height: 38px !important;
            padding: 2px 10px !important;
            border-radius: 10px !important;
            background: #ffffff !important;
        }
        .card.bar .select2-container--default .select2-selection--single .select2-selection__rendered,
        .filter-toolbar .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-size: 13px !important;
            line-height: normal !important;
            padding-right: 18px !important;
        }
        .card.bar .select2-container--default .select2-selection--single .select2-selection__arrow,
        .filter-toolbar .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            right: 6px !important;
        }
        .card.bar .select2-container--default .select2-selection--single .select2-selection__clear,
        .filter-toolbar .select2-container--default .select2-selection--single .select2-selection__clear {
            margin-right: 18px !important;
            color: #889bb0 !important;
            font-size: 16px !important;
        }
        .card.bar label,
        .filter-toolbar label {
            display: inline-flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 7px !important;
            margin: 0 0 0 auto !important;
            padding: 0 4px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: var(--q-text-muted) !important;
            cursor: pointer !important;
            white-space: nowrap !important;
            height: 38px !important;
        }
        .card.bar label input[type="checkbox"],
        .filter-toolbar label input[type="checkbox"] {
            width: 16px !important;
            height: 16px !important;
            min-width: 16px !important;
            max-width: 16px !important;
            margin: 0 !important;
            padding: 0 !important;
            accent-color: var(--q-navy-main) !important;
            cursor: pointer !important;
            flex: none !important;
        }

        /* KPI Metric Cards matching THC Dashboard Aesthetic */
        .kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }
        .kpi {
            border-radius: 14px !important;
            padding: 16px 20px !important;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease !important;
            box-shadow: 0 6px 20px rgba(0, 29, 57, 0.07) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            min-height: 95px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .kpi:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0, 29, 57, 0.15) !important;
        }
        .kpi span {
            font-size: 11.5px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            display: block;
            margin-bottom: 5px;
        }
        .kpi strong {
            font-size: 21px !important;
            font-weight: 700 !important;
            line-height: 1.1;
        }

        /* Distinct THC Dash Gradient Variations */
        .kpi:nth-child(1) {
            background: linear-gradient(135deg, #001D39 0%, #0A4174 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #7BBDE8 !important;
        }
        .kpi:nth-child(1) span { color: #d0dded !important; }

        .kpi:nth-child(2) {
            background: linear-gradient(135deg, #0A4174 0%, #49769F 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #BDD8E9 !important;
        }
        .kpi:nth-child(2) span { color: #e1f0fa !important; }

        .kpi:nth-child(3) {
            background: linear-gradient(135deg, #112240 0%, #001D39 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #64ffda !important;
        }
        .kpi:nth-child(3) span { color: #cbd5e1 !important; }

        .kpi:nth-child(4) {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #a7f3d0 !important;
        }
        .kpi:nth-child(4) span { color: #d1fae5 !important; }

        .kpi:nth-child(5) {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #99f6e4 !important;
        }
        .kpi:nth-child(5) span { color: #ccfbf1 !important; }

        .kpi:nth-child(6) {
            background: linear-gradient(135deg, #047857 0%, #064e3b 100%) !important;
            color: #ffffff !important;
            border-left: 5px solid #6ee7b7 !important;
        }
        .kpi:nth-child(6) span { color: #d1fae5 !important; }

        /* Data Tables Styling */
        .card.tw {
            background: #ffffff !important;
            border: 1px solid var(--q-border) !important;
            border-radius: 14px !important;
            box-shadow: 0 6px 24px rgba(0, 29, 57, 0.06) !important;
            overflow-x: auto;
            margin-bottom: 22px !important;
        }
        .lg {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .lg th {
            background: #f4f8fb !important;
            color: var(--q-navy-dark) !important;
            font-weight: 700 !important;
            font-size: 11.5px !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase !important;
            padding: 14px 16px !important;
            border-bottom: 2px solid var(--q-sky) !important;
            border-top: none !important;
            white-space: nowrap;
        }
        .lg td {
            padding: 13px 16px !important;
            border-bottom: 1px solid #e8f0f6 !important;
            border-top: none !important;
            font-size: 13px !important;
            vertical-align: middle !important;
            color: var(--q-navy-dark) !important;
        }
        .lg tbody tr {
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .lg tbody tr:hover {
            background: #f0f7fc !important;
        }
        .lg tbody tr:nth-child(even) {
            background: #fafcfe;
        }
        .lg td.w { white-space: normal; min-width: 220px; }
        .lg small { color: var(--q-text-muted); font-size: 12px; }

        /* Status Badges */
        .tag {
            padding: 4px 11px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            display: inline-block;
            white-space: nowrap;
        }
        .tag.Approved {
            background: #d1fae5 !important;
            color: #065f46 !important;
            border: 1px solid #a7f3d0;
        }
        .tag.Pending {
            background: #fef3c7 !important;
            color: #92400e !important;
            border: 1px solid #fde68a;
        }
        .tag.Notapproved {
            background: #fee2e2 !important;
            color: #991b1b !important;
            border: 1px solid #fecaca;
        }
        .tag.Draft, .tag.Superseded, .tag.Void {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1;
        }
        .tag.Void {
            text-decoration: line-through;
            color: #94a3b8 !important;
            background: #f8fafc !important;
        }

        .lock {
            background: #e8f5e9 !important;
            color: #1b5e20 !important;
            border: 1px solid #a5d6a7 !important;
            padding: 12px 18px !important;
            border-radius: 8px !important;
            margin-bottom: 16px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .rl {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .rl th, .rl td {
            padding: 10px 12px;
            border-top: 1px solid var(--q-border-subtle);
            text-align: left;
            vertical-align: middle;
        }
        .rl th {
            color: var(--q-text-muted);
            font-size: 12px;
            background: #f8fafc;
            font-weight: 700;
        }
        .rl tr:hover td {
            background: #f8fafc;
        }
        .y { color: #16a34a; font-weight: 700; font-size: 15px; }
        .n { color: #cbd5e1; font-size: 15px; }
        .m { color: #d97706; font-weight: 600; }
        ul.r { padding-left: 20px; }
        ul.r li { margin: 8px 0; font-size: 13px; line-height: 1.5; color: #334155; }
        ul.r li b { color: var(--q-navy-dark); }
        pre.data-model {
            background: #0f172a;
            color: #38bdf8;
            border-radius: 8px;
            padding: 16px;
            font-size: 12px;
            line-height: 1.6;
            overflow-x: auto;
        }

        /* Split Editor / Detail View */
        .two {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr);
            gap: 22px;
            align-items: start;
            margin-bottom: 30px;
        }
        .card.pad {
            background: #ffffff !important;
            border: 1px solid var(--q-border) !important;
            border-radius: 14px !important;
            box-shadow: 0 4px 18px rgba(0, 29, 57, 0.05) !important;
            padding: 22px !important;
            margin-bottom: 18px !important;
        }
        .card.pad h2 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--q-navy-dark);
            margin: 0 0 14px 0;
            font-family: 'Outfit', sans-serif;
            border-bottom: 2px solid var(--q-blue-ice);
            padding-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card.pad input, .card.pad select, .card.pad textarea {
            width: 100%;
            margin-top: 10px;
        }
        .g2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .g2 input, .g2 select { margin-top: 10px; }

        /* Key-Value Details */
        .kv {
            display: grid;
            grid-template-columns: 130px 1fr;
            gap: 10px 14px;
            font-size: 13.5px;
        }
        .kv span {
            color: var(--q-text-muted);
            font-weight: 600;
        }

        /* Items Grid */
        .it {
            display: grid;
            grid-template-columns: 80px 1fr 110px 105px 36px;
            gap: 8px;
            margin-bottom: 10px;
            align-items: center;
        }
        #its .it {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        #its .it:focus-within {
            border-color: #7BBDE8;
            box-shadow: 0 0 0 3px rgba(123, 189, 232, 0.15);
        }
        .it input, .it select, .it textarea {
            margin: 0 !important;
        }
        .it textarea {
            width: 100% !important;
            min-height: 48px;
            line-height: 1.45;
            padding: 7px 10px !important;
            font-size: 13px !important;
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 6px !important;
            resize: vertical !important;
            font-family: inherit !important;
            box-sizing: border-box !important;
            background: #ffffff !important;
            color: #1e293b !important;
        }
        .it textarea:focus {
            border-color: #0A4174 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(10, 65, 116, 0.12) !important;
        }
        .btn-toggle-bold, .btn-toggle-underline, .btn-toggle-bullet {
            transition: all 0.15s ease;
            user-select: none;
        }
        .btn-toggle-bold:hover, .btn-toggle-underline:hover {
            background: #e2e8f0 !important;
            border-color: #0A4174 !important;
            color: #0A4174 !important;
        }
        .btn-toggle-bullet:hover {
            background: #e0f0fc !important;
            border-color: #0A4174 !important;
            color: #0A4174 !important;
        }
        .it select {
            height: 38px !important;
            padding: 6px 10px !important;
            cursor: pointer;
            background-color: #ffffff !important;
        }
        .it.h {
            color: var(--q-navy-dark);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }
        .it input[data-f="qty"],
        .it select[data-f="unit"],
        .it input[data-f="price"],
        .it b {
            text-align: center;
            text-align-last: center;
        }

        /* Terms Rows */
        .tr {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-items: flex-start;
        }
        #dropzone_import_file.dragover {
            background-color: #dbeafe !important;
            border-color: #2563eb !important;
        }

        #tbody_import_preview tr.selected-row {
            background-color: #f0f7fc;
        }

        .import-quote-item {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .import-quote-item:hover {
            background-color: #f0f7fc !important;
        }

        .import-quote-item.active {
            background-color: #e0f2fe !important;
            border-left: 4px solid #0284c7 !important;
        }

        .tr textarea { flex: 1; margin: 0 !important; }

        /* Live Preview Sticky Container */
        #pv {
            position: sticky;
            top: 75px;
            max-height: calc(100vh - 95px);
            overflow-y: auto;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 29, 57, 0.12);
            border: 1px solid #cbd5e1;
        }

        /* Right-Click Spell Check Context Menu */
        .spell-context-menu {
            position: fixed;
            z-index: 1000000;
            min-width: 210px;
            max-width: 320px;
            background: #ffffff;
            border: 1.5px solid #c2daeb;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 29, 57, 0.22);
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 6px 0;
            user-select: none;
            animation: spellMenuFadeIn 0.15s ease-out;
        }
        @keyframes spellMenuFadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }
        .spell-context-header {
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #49769F;
            border-bottom: 1px solid #eef4f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .spell-context-target {
            font-weight: 700;
            color: #001D39;
            background: #eef6fc;
            padding: 1px 7px;
            border-radius: 5px;
            max-width: 130px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 11.5px;
        }
        .spell-context-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 14px;
            font-size: 13.5px;
            color: #001D39;
            cursor: pointer;
            transition: background 0.12s ease;
            font-weight: 600;
        }
        .spell-context-item:hover {
            background: #eaf3fb;
            color: #0A4174;
        }
        .spell-context-item.suggest-item {
            font-weight: 700;
            color: #0A4174;
            padding: 7px 14px;
        }
        .spell-context-item.suggest-item:hover {
            background: #e1effa;
            color: #001D39;
        }
        .spell-context-divider {
            height: 1px;
            background: #eef4f9;
            margin: 5px 0;
        }
        .spell-context-loading {
            padding: 10px 14px;
            font-size: 12.5px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .spell-context-badge {
            padding: 7px 12px;
            font-size: 12px;
            color: #15803d;
            background: #f0fdf4;
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 4px 8px;
            border-radius: 6px;
            border: 1px solid #bbf7d0;
        }

        /* ==============================================================
           Quotation Letterhead Sheet Template
           Strictly aligned with THC corporate report standards
           (Matching not_assigned_workorder_print.php & work_order_print.php)
           ============================================================== */
        .sheet {
            background: #ffffff;
            color: #1e293b;
            font-family: 'Montserrat', 'Calibri', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            padding: 34px 38px;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .sheet p { margin: 8px 0; }
        .sheet .lh {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            border-bottom: 2px solid #2e2e79;
            padding-bottom: 12px;
        }
        .sheet .lh img {
            max-height: 65px;
            height: auto;
            display: block;
        }
        .sheet table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            border: 1px solid #cbd5e1;
        }
        .sheet th {
            background-color: #2e2e79 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 8px 10px;
            font-size: 11px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 1px solid #2e2e79;
            text-align: center;
        }
        .sheet td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            font-size: 11.5px;
            color: #1e293b;
            vertical-align: middle;
        }
        .sheet td:first-child,
        .sheet td:nth-child(3),
        .sheet td:nth-child(4) {
            text-align: center;
        }
        .sheet td:nth-child(2) {
            text-align: left;
        }
        .sheet tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .sheet .r { text-align: center; }
        .sheet .c { text-align: center; }
        .sheet ol { padding-left: 20px; margin: 6px 0; }
        .sheet ol li { margin-bottom: 3px; }
        .sheet .sg {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 22px;
        }
        .sheet .ap {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 6px;
            padding: 10px 14px;
            width: 46%;
            min-height: 90px;
        }
        .sheet .ft {
            margin-top: 22px;
            background: #2e2e79;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 10px;
            border-radius: 4px;
            text-align: center;
            letter-spacing: 0.4px;
        }

        /* Toast Popup */
        #toast {
            position: fixed;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            background: var(--q-navy-dark);
            color: #ffffff;
            border-left: 4px solid var(--q-sky);
            padding: 12px 24px;
            border-radius: 10px;
            display: none;
            z-index: 999999;
            box-shadow: 0 10px 30px rgba(0, 29, 57, 0.35);
            font-size: 13.5px;
            font-weight: 600;
        }

        /* Printable Sheet Container */
        #ph { display: none; }
        @media print {
            html, body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
                overflow: visible !important;
            }
            body.navbar-top {
                padding-top: 0 !important;
            }
            .thc-topnav,
            .thc-quotation-nav-card,
            .content-wrapper,
            footer,
            .navbar,
            .modal,
            .swal2-container,
            #toast,
            datalist {
                display: none !important;
            }
            #ph {
                display: block !important;
                position: static !important;
                width: 100% !important;
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            #ph .sheet {
                border: 0 !important;
                padding: 16px 20px !important;
                box-shadow: none !important;
                background: #ffffff !important;
                color: #111111 !important;
                display: block !important;
            }
            body, table, td, th {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Responsive Layouts */
        @media (max-width: 991px) {
            .two { grid-template-columns: 1fr; }
            #pv { position: static; max-height: none; }
        }
        @media (max-width: 767px) {
            .card.bar label, .filter-toolbar label {
                margin: 0 !important;
            }
        }
        @media (max-width: 575px) {
            .card.bar, .filter-toolbar {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .card.bar .search-input-wrapper,
            .filter-toolbar .search-input-wrapper,
            .card.bar input#fq, .card.bar select,
            .filter-toolbar input#fq, .filter-toolbar select {
                max-width: 100% !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body class="navbar-top">

    <!-- ===== THC Horizontal Top Navigation ===== -->
    <?PHP include_once('template/top_menu_new.inc'); ?>
    <!-- ===== /THC Horizontal Top Navigation ===== -->

    <!-- Main Application Content Wrapper -->
    <div class="content-wrapper" style="margin-left:0;padding:20px 24px 0;">

        <!-- Content Area -->
        <div class="content pt-0">

            <?php if (!$hasQuotationAccess): ?>
                <!-- Access Restricted Notice -->
                <div class="card p-4 text-center mt-4" style="max-width:540px;margin:40px auto;border-radius:14px;border:1px solid #d4e4f0;box-shadow:0 4px 18px rgba(0,29,57,0.06);">
                    <div style="width:68px;height:68px;border-radius:50%;background:#fee2e2;color:#dc2626;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:30px;">
                        <i class="icon-lock5"></i>
                    </div>
                    <h3 class="font-weight-bold" style="color:var(--q-navy-dark);margin-bottom:8px;">Access Restricted</h3>
                    <p class="text-muted" style="font-size:13.5px;line-height:1.6;">You do not have the required permissions to access the Quotation Module. Please contact your system administrator to assign the Quotation privilege.</p>
                    <div class="mt-3">
                        <a href="dashboard.php" class="btn" style="background:var(--q-navy-main);color:#ffffff;border-radius:8px;font-weight:600;padding:8px 20px;">
                            <i class="icon-home2 mr-1"></i> Return to Dashboard
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Quotation Sub-Navigation Header Bar -->
                <div class="card thc-quotation-nav-card p-2 mb-3">
                    <aside class="thc-subnav-aside">
                        <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                            <a data-v="log" class="thc-subnav-btn on">
                                <i class="icon-list3"></i> Quotation Log
                            </a>
                            <a data-v="A" class="thc-subnav-btn">
                                <i class="icon-plus2"></i> New Quote · AMC
                            </a>
                            <a data-v="N" class="thc-subnav-btn">
                                <i class="icon-plus2"></i> New Quote · Non-AMC
                            </a>
                            <a data-v="perf" class="thc-subnav-btn">
                                <i class="icon-stats-growth"></i> Performance
                            </a>
                            <a data-v="rules" class="thc-subnav-btn">
                                <i class="icon-file-check"></i> Business Rules (dev)
                            </a>
                            <a id="btn_open_unit_master" class="thc-subnav-btn" style="cursor:pointer;" title="Manage Units in Master">
                                <i class="icon-stack2"></i> Unit Master
                            </a>
                            <a id="btn_open_footer_settings" class="thc-subnav-btn" style="cursor:pointer;" title="Configure PDF & Print Footer">
                                <i class="icon-file-text2"></i> Footer Settings
                            </a>
                            <a id="btn_open_stamp_sign" class="thc-subnav-btn" style="cursor:pointer;" title="Upload & Configure Stamp and Signature">
                                <i class="icon-stamp"></i> Stamp & Sign
                            </a>
                        </div>

                        <div class="d-flex align-items-center ml-auto flex-wrap" style="gap:10px;">
                            <span class="text-muted font-size-sm font-weight-semibold" style="letter-spacing:0.3px;">
                                <i class="icon-user mr-1"></i> Estimator:
                            </span>
                            <select id="us" class="form-control form-control-sm" style="width:auto;min-width:190px;" title="Select active user profile"></select>
                        </div>
                    </aside>
                </div>

                <!-- Dynamic Workspace View Container -->
                <main id="v" style="padding:0;min-height:70vh;"></main>
            <?php endif; ?>

        </div>
        <!-- /content -->

        <?PHP include_once('template/reset_password_modal.php'); ?>

        <!-- Quotation Footer Settings Modal -->
        <div id="modal_footer_settings" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="footerSettingsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:760px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="footerSettingsModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-file-text2 mr-2" style="font-size:20px;color:#7BBDE8;"></i> Quotation PDF & Print Footer Settings
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;max-height:calc(85vh - 120px);overflow-y:auto;">
                        <p class="text-muted mb-3" style="font-size:12px;">
                            Configure the corporate contact details, commercial registration, addresses, and accreditation badges displayed on all quotation PDF downloads and printable sheets.
                        </p>

                        <!-- Live Interactive Preview Box -->
                        <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px solid #c2daeb;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold text-dark" style="font-size:12.5px;">
                                    <i class="icon-eye mr-1 text-primary"></i> Live Footer Preview
                                </span>
                                <span class="badge badge-info" style="font-size:11px;">Real-time</span>
                            </div>
                            <div style="background:#f1f5f9;border:1px dashed #cbd5e1;border-radius:6px;padding:12px;">
                                <div id="footer_preview_top" style="display:flex;justify-content:space-between;align-items:center;font-size:11px;color:#475569;margin-bottom:4px;font-family:'Montserrat',sans-serif;">
                                    <div id="footer_preview_page">Page 1 of 2</div>
                                    <div id="footer_preview_ref">CINQO/THC/QTN/01/2020/REV3</div>
                                </div>
                                <div id="footer_preview_bar" style="background:#1e2560;border-radius:4px;padding:10px 14px;color:#ffffff;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                    <div id="footer_preview_text" style="font-size:10px;line-height:1.5;color:#ffffff;font-family:'Montserrat',sans-serif;">
                                        <div>Tel: <b id="fp_phone">+973 17 100 190</b> | <span id="fp_email">info@thc.com.bh</span> | <span id="fp_website">www.thc.com.bh</span></div>
                                        <div>CR : <b id="fp_cr">88982-1</b> | <span id="fp_addr1">Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317</span></div>
                                        <div><b id="fp_addr2">YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain</b></div>
                                    </div>
                                    <div id="footer_preview_badges" style="flex-shrink:0;">
                                        <img src="global_assets/images/a.png" onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='../view/global_assets/images/a.png';}" alt="Bureau Veritas" style="max-height:36px;display:block;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Settings -->
                        <div class="card p-3 mb-0" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Telephone / Mobile</label>
                                    <input type="text" id="cfg_footer_phone" class="form-control form-control-sm" placeholder="+973 17 100 190" value="+973 17 100 190">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Email Address</label>
                                    <input type="email" id="cfg_footer_email" class="form-control form-control-sm" placeholder="info@thc.com.bh" value="info@thc.com.bh">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Official Website</label>
                                    <input type="text" id="cfg_footer_website" class="form-control form-control-sm" placeholder="www.thc.com.bh" value="www.thc.com.bh">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Commercial Reg. (CR)</label>
                                    <input type="text" id="cfg_footer_cr" class="form-control form-control-sm" placeholder="88982-1" value="88982-1">
                                </div>
                                <div class="col-md-8 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Office Address (Line 1)</label>
                                    <input type="text" id="cfg_footer_addr1" class="form-control form-control-sm" placeholder="Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317" value="Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Building & Area (Line 2)</label>
                                    <input type="text" id="cfg_footer_addr2" class="form-control form-control-sm" placeholder="YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain" value="YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Document Number (Constant on all pages)</label>
                                    <input type="text" id="cfg_footer_doc_number" class="form-control form-control-sm" placeholder="CINQO/THC/QTN/01/2020/REV3" value="CINQO/THC/QTN/01/2020/REV3">
                                    <small class="text-muted d-block" style="font-size:11px;">Standard document number displayed on bottom right above footer bar</small>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="font-weight-semibold text-dark mb-1" style="font-size:12px;">Footer Background Color</label>
                                    <div class="d-flex align-items-center" style="gap:8px;">
                                        <input type="color" id="cfg_footer_color" class="form-control form-control-sm p-1" value="#1e2560" style="width:45px;height:34px;cursor:pointer;">
                                        <input type="text" id="cfg_footer_color_hex" class="form-control form-control-sm" value="#1e2560" style="font-family:monospace;font-size:12px;">
                                    </div>
                                </div>
                            </div>

                            <hr style="margin:12px 0;border-color:#e2e8f0;">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cfg_footer_badges" checked>
                                        <label class="custom-control-label font-weight-semibold" for="cfg_footer_badges" style="font-size:12px;">Show ISO Accreditation Badges</label>
                                    </div>
                                    <small class="text-muted d-block" style="font-size:11px;">Bureau Veritas ISO 41001 & ISO 9001</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cfg_footer_page_no" checked>
                                        <label class="custom-control-label font-weight-semibold" for="cfg_footer_page_no" style="font-size:12px;">Show Page Numbers</label>
                                    </div>
                                    <small class="text-muted d-block" style="font-size:11px;">"Page X of Y" above footer bar</small>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="cfg_footer_ref_no" checked>
                                        <label class="custom-control-label font-weight-semibold" for="cfg_footer_ref_no" style="font-size:12px;">Show Document Number</label>
                                    </div>
                                    <small class="text-muted d-block" style="font-size:11px;">Document number on bottom right (CINQO/THC/QTN/01/2020/REV3)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 20px;">
                        <button type="button" id="btn_reset_footer_cfg" class="btn btn-outline-secondary btn-sm font-weight-semibold" style="border-radius:8px;">
                            <i class="icon-reset mr-1"></i> Reset to Default
                        </button>
                        <div style="display:flex;gap:8px;">
                            <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:8px;padding:6px 16px;">
                                Cancel
                            </button>
                            <button type="button" id="btn_save_footer_cfg" class="btn btn-primary btn-sm font-weight-semibold" style="border-radius:8px;padding:6px 20px;background:linear-gradient(135deg, #0A4174 0%, #001D39 100%);border:none;">
                                <i class="icon-floppy-disk mr-1"></i> Save Footer Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stamp & Signature Management Modal -->
        <div id="modal_stamp_sign_settings" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="stampSignModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:760px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="stampSignModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-stamp mr-2" style="font-size:20px;color:#7BBDE8;"></i> Quotation Stamp & Signature Management
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;max-height:calc(85vh - 120px);overflow-y:auto;">
                        <p class="text-muted mb-3" style="font-size:12px;">
                            Upload official company seal/stamp and estimator signatures to reflect automatically on quotation sheets and downloaded PDFs (aligned with corporate reporting).
                        </p>

                        <div class="row">
                            <!-- Company Stamp Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 p-3" style="border:1.5px solid #c2daeb;border-radius:10px;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:1px solid #e2e8f0;">
                                        <h6 class="font-weight-bold mb-0" style="color:#0A4174;font-size:13px;">
                                            <i class="icon-stamp mr-1"></i> Company Stamp / Seal
                                        </h6>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cfg_show_stamp" checked>
                                            <label class="custom-control-label font-weight-semibold font-size-xs" for="cfg_show_stamp">Display Stamp</label>
                                        </div>
                                    </div>
                                    <div class="text-center my-3 p-2" style="background:#f8fafc;border:1px dashed #cbd5e1;border-radius:8px;min-height:130px;display:flex;align-items:center;justify-content:center;">
                                        <img id="stamp_preview_img" src="uploads/quotation_signatures/default_thc_stamp.png" onerror="this.src='../view/uploads/quotation_signatures/default_thc_stamp.png';" alt="THC Stamp" style="max-height:110px;max-width:150px;object-fit:contain;">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="font-weight-semibold font-size-xs text-muted mb-1">Upload New Stamp (PNG / JPG):</label>
                                        <input type="file" id="upload_stamp_input" class="form-control-file form-control-sm" accept="image/png,image/jpeg,image/webp">
                                    </div>
                                </div>
                            </div>

                            <!-- Estimator Signature Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 p-3" style="border:1.5px solid #c2daeb;border-radius:10px;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                    <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:1px solid #e2e8f0;">
                                        <h6 class="font-weight-bold mb-0" style="color:#0A4174;font-size:13px;">
                                            <i class="icon-pencil7 mr-1"></i> Estimator Signature
                                        </h6>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cfg_show_signature" checked>
                                            <label class="custom-control-label font-weight-semibold font-size-xs" for="cfg_show_signature">Display Sign</label>
                                        </div>
                                    </div>
                                    <div class="text-center my-3 p-2" style="background:#f8fafc;border:1px dashed #cbd5e1;border-radius:8px;min-height:130px;display:flex;align-items:center;justify-content:center;">
                                        <img id="sig_preview_img" src="uploads/quotation_signatures/default_signature.png" onerror="this.src='../view/uploads/quotation_signatures/default_signature.png';" alt="Signature" style="max-height:80px;max-width:170px;object-fit:contain;">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="font-weight-semibold font-size-xs text-muted mb-1">Upload Signature for Current Estimator (PNG / JPG):</label>
                                        <input type="file" id="upload_sig_input" class="form-control-file form-control-sm" accept="image/png,image/jpeg,image/webp">
                                    </div>
                                    <div class="form-group mb-0 pt-2" style="border-top:1px dashed #cbd5e1;">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <label class="font-weight-semibold font-size-xs text-muted mb-0">Estimator Mobile Number:</label>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cfg_show_user_phone" checked>
                                                <label class="custom-control-label font-weight-semibold font-size-xs" for="cfg_show_user_phone">Display Mobile</label>
                                            </div>
                                        </div>
                                        <input type="text" id="cfg_user_phone" class="form-control form-control-sm" placeholder="e.g. +973 3944 1015" style="font-size:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Live Footer Signature Preview -->
                        <div class="card p-3 mb-0" style="background:#ffffff;border:1.5px solid #d4e4f0;border-radius:10px;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                            <div class="font-weight-bold text-dark mb-2" style="font-size:12.5px;">
                                <i class="icon-eye mr-1 text-primary"></i> Live Signature & Stamp Appearance (as rendered on quote):
                            </div>
                            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:14px;max-width:380px;">
                                <div style="font-size:12px;line-height:1.5;color:#1e293b;">
                                    <div><b>Thanking you,</b></div>
                                    <div class="mt-2"><b>Yours sincerely,</b></div>
                                    <div><b>THC Facility Management W.L.L</b></div>
                                    <div style="display:flex;align-items:center;gap:12px;margin:8px 0;min-height:55px;">
                                        <img id="live_prev_sig" src="uploads/quotation_signatures/default_signature.png" onerror="this.src='../view/uploads/quotation_signatures/default_signature.png';" style="max-height:46px;max-width:130px;object-fit:contain;">
                                        <img id="live_prev_stamp" src="uploads/quotation_signatures/default_thc_stamp.png" onerror="this.src='../view/uploads/quotation_signatures/default_thc_stamp.png';" style="max-height:65px;max-width:130px;object-fit:contain;margin-left:-8px;">
                                    </div>
                                    <div id="live_prev_user_name" class="font-weight-bold">Parthiban Jayaraman</div>
                                    <div id="live_prev_user_title" class="text-muted font-size-xs">Operations Engineer</div>
                                    <div id="live_prev_user_phone" class="font-size-xs" style="color:#0A4174;font-weight:600;display:none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 20px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:8px;padding:6px 16px;">
                            Close
                        </button>
                        <button type="button" id="btn_save_stamp_sign_cfg" class="btn btn-primary btn-sm font-weight-semibold" style="border-radius:8px;padding:6px 20px;background:linear-gradient(135deg, #0A4174 0%, #001D39 100%);border:none;">
                            <i class="icon-floppy-disk mr-1"></i> Save & Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unit Master Modal -->
        <div id="modal_unit_master" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="unitMasterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:520px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="unitMasterModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-stack2 mr-2" style="font-size:20px;color:#7BBDE8;"></i> Quotation Unit Master
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;">
                        <!-- Add Unit Card -->
                        <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);margin-bottom:14px !important;">
                            <label class="font-weight-bold text-dark mb-1" style="font-size:12.5px;">Add New Unit</label>
                            <div class="input-group">
                                <input type="text" id="input_new_unit" class="form-control" placeholder="e.g. Coil, Drum, Sq.ft, Bundle" maxlength="50" style="border-radius:8px 0 0 8px !important;font-size:13.5px;height:38px;border:1.5px solid #c2daeb;margin:0 !important;" spellcheck="true" autocorrect="on">
                                <div class="input-group-append">
                                    <button type="button" id="btn_save_unit" class="btn btn-primary" style="border-radius:0 8px 8px 0 !important;background:linear-gradient(135deg, #0A4174 0%, #001D39 100%);font-weight:600;padding:0 16px;height:38px;margin:0 !important;border:none;">
                                        <i class="icon-plus2 mr-1"></i> Add Unit
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted mt-1" style="font-size:11.5px;line-height:1.4;">Newly added units will be immediately available in the quotation item dropdown.</small>
                        </div>

                        <!-- Unit List Card -->
                        <div class="card p-3" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);margin-bottom:0 !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="font-weight-bold text-dark" style="font-size:12.5px;">
                                    Available Units (<span id="unit_count_badge">0</span>)
                                </span>
                                <input type="text" id="filter_unit_list" class="form-control form-control-sm" placeholder="Search units…" style="width:150px;height:28px;font-size:12px;border-radius:6px;border:1px solid #c2daeb;margin:0 !important;padding:4px 8px;" spellcheck="true" autocorrect="on">
                            </div>
                            <div id="unit_master_list_container" style="max-height:280px;overflow-y:auto;border:1px solid #e2e8f0;border-radius:8px;background:#ffffff;">
                                <!-- Dynamically populated unit list -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:10px 20px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Line Items Modal -->
        <div id="modal_import_items" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="importItemsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:920px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <h5 class="modal-title font-weight-bold d-flex align-items-center" id="importItemsModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                                <i class="icon-file-download2 mr-2" style="font-size:20px;color:#7BBDE8;"></i> Import Line Items
                            </h5>
                            <small style="color:#b2d5f0;font-size:11.5px;">Import scope of work line items from Excel / CSV, paste from clipboard, or copy from an existing quotation</small>
                        </div>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;margin:0;padding:0;line-height:1;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;min-height:520px;max-height:calc(85vh - 120px);overflow-y:auto;">
                        <!-- Tab Pills -->
                        <ul class="nav nav-pills mb-3" id="import_tabs" role="tablist" style="background:#e2e8f0;padding:4px;border-radius:10px;gap:4px;">
                            <li class="nav-item flex-fill text-center" role="presentation">
                                <a class="nav-link active font-weight-bold py-2" id="tab_import_file_btn" data-toggle="pill" href="#tab_import_file" role="tab" style="border-radius:8px;font-size:13px;">
                                    <i class="icon-file-excel mr-1"></i> From Excel / CSV File or Paste
                                </a>
                            </li>
                            <li class="nav-item flex-fill text-center" role="presentation">
                                <a class="nav-link font-weight-bold py-2" id="tab_import_quote_btn" data-toggle="pill" href="#tab_import_quote" role="tab" style="border-radius:8px;font-size:13px;">
                                    <i class="icon-copy3 mr-1"></i> From Existing Quotation
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="import_tab_content">
                            <!-- Tab 1: File / Paste -->
                            <div class="tab-pane fade show active" id="tab_import_file" role="tabpanel">
                                <!-- Upload Box -->
                                <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px dashed #7BBDE8;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="font-weight-bold text-dark" style="font-size:12.5px;">
                                            <i class="icon-upload mr-1 text-primary"></i> Upload File (.xlsx, .xls, .csv, .txt)
                                        </span>
                                        <button type="button" id="btn_download_sample_template" class="btn btn-sm btn-outline-primary" style="font-size:11.5px;padding:3px 12px;border-radius:6px;font-weight:600;">
                                            <i class="icon-download4 mr-1"></i> Download Sample CSV Template
                                        </button>
                                    </div>
                                    <div id="dropzone_import_file" style="background:#f0f7fc;border:1px dashed #93c5fd;border-radius:8px;padding:22px;text-align:center;cursor:pointer;transition:all 0.2s ease;">
                                        <i class="icon-file-upload2 text-primary mb-2" style="font-size:32px;display:block;"></i>
                                        <span class="d-block font-weight-semibold text-dark" style="font-size:13px;">Click to browse file or drag & drop here</span>
                                        <small class="text-muted d-block mt-1" style="font-size:11.5px;">Expected columns: <b>Description, Quantity, Unit, Unit Price</b> (with or without Sl No)</small>
                                        <input type="file" id="input_import_file" accept=".xlsx,.xls,.csv,.tsv,.txt" style="display:none;">
                                    </div>
                                    <div id="file_selected_info" class="mt-2 text-success font-weight-semibold" style="font-size:12px;display:none;"></div>
                                </div>

                                <!-- Paste Area Box -->
                                <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="font-weight-bold text-dark mb-0" style="font-size:12.5px;">
                                            <i class="icon-paste mr-1 text-secondary"></i> Or Paste Copied Spreadsheet Cells Directly
                                        </label>
                                        <small class="text-muted" style="font-size:11px;">Copy rows from Excel or Google Sheets and paste below</small>
                                    </div>
                                    <textarea id="import_paste_area" rows="3" class="form-control" placeholder="Paste copied spreadsheet rows here... (Columns: Description [tab] Qty [tab] Unit [tab] Unit Price)" style="font-family:monospace;font-size:12px;border:1.5px solid #c2daeb;border-radius:6px;"></textarea>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" id="btn_parse_pasted_data" class="btn btn-sm btn-secondary font-weight-semibold" style="font-size:12px;padding:4px 16px;border-radius:6px;">
                                            <i class="icon-cog3 mr-1"></i> Parse Pasted Data
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: Existing Quote -->
                            <div class="tab-pane fade" id="tab_import_quote" role="tabpanel">
                                <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="font-weight-bold text-dark mb-0" style="font-size:12.5px;">
                                            <i class="icon-search4 mr-1 text-primary"></i> Select Existing Quotation to Copy Line Items
                                        </label>
                                        <span class="text-muted font-weight-semibold" style="font-size:11.5px;" id="import_quote_count_label">0 quotations</span>
                                    </div>

                                    <!-- Quick Search Input -->
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0" style="border-color:#c2daeb;border-radius:6px 0 0 6px;">
                                                <i class="icon-search4 text-muted" style="font-size:12px;"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="import_quote_search_input" class="form-control border-left-0" placeholder="Type to filter quotations (e.g. quote #, client name, subject)..." style="height:36px;font-size:12.5px;border-color:#c2daeb;border-radius:0 6px 6px 0;padding-left:0;">
                                    </div>

                                    <!-- Interactive list of quotations -->
                                    <div id="import_quote_list_container" style="max-height:190px;overflow-y:auto;border:1.5px solid #e2e8f0;border-radius:8px;background:#ffffff;margin-bottom:6px;">
                                        <!-- Dynamically populated quote items -->
                                    </div>

                                    <!-- Synchronized dropdown (hidden fallback) -->
                                    <div style="display:none;">
                                        <select id="select_import_quote_source" class="form-control">
                                            <option value="">-- Choose a quotation --</option>
                                        </select>
                                    </div>

                                    <small class="text-muted d-block" style="font-size:11px;">
                                        <i class="icon-info22 mr-1 text-info"></i> Click any quotation above to preview and select its line items.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Section -->
                        <div id="import_preview_container" style="display:none;">
                            <div class="card p-3 mb-3" style="border-radius:10px;border:1.5px solid #c2daeb;background:#ffffff;box-shadow:0 2px 8px rgba(0,29,57,0.04);">
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1" style="border-bottom:1px solid #e2e8f0;">
                                    <span class="font-weight-bold text-dark" style="font-size:13px;">
                                        <i class="icon-list-numbered mr-1 text-success"></i> Items Preview (<span id="import_items_count_badge">0</span> selected)
                                    </span>
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        <span class="badge badge-primary px-2 py-1" style="font-size:12px;font-weight:600;background:#0A4174;" id="import_subtotal_badge">Total: 0.000 BD</span>
                                        <button type="button" id="btn_clear_imported_preview" class="btn btn-sm btn-outline-danger" style="font-size:11px;padding:2px 8px;border-radius:4px;">
                                            Clear
                                        </button>
                                    </div>
                                </div>

                                <div style="max-height:280px;overflow-y:auto;border:1px solid #e2e8f0;border-radius:8px;">
                                    <table class="table table-sm table-bordered table-striped mb-0" id="table_import_preview" style="font-size:12px;">
                                        <thead style="background:#0A4174;color:#ffffff;position:sticky;top:0;z-index:2;">
                                            <tr>
                                                <th style="width:36px;text-align:center;">
                                                    <input type="checkbox" id="chk_import_select_all" checked style="cursor:pointer;">
                                                </th>
                                                <th style="width:40px;text-align:center;">#</th>
                                                <th>Description</th>
                                                <th style="width:80px;text-align:center;">Qty</th>
                                                <th style="width:110px;text-align:center;">Unit</th>
                                                <th style="width:115px;text-align:center;">Unit Price (BD)</th>
                                                <th style="width:115px;text-align:center;">Total (BD)</th>
                                                <th style="width:36px;text-align:center;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_import_preview">
                                            <!-- Dynamically populated rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Import Mode: Append vs Replace -->
                            <div class="card p-3 mb-0" style="border-radius:10px;border:1.5px solid #d4e4f0;background:#ffffff;">
                                <span class="font-weight-bold text-dark mb-2 d-block" style="font-size:12.5px;">Choose Import Action:</span>
                                <div class="d-flex align-items-center" style="gap:24px;">
                                    <label style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:#0A4174;margin:0;">
                                        <input type="radio" name="import_mode" value="append" checked style="cursor:pointer;width:16px;height:16px;">
                                        <span>Append to current quotation items</span>
                                    </label>
                                    <label style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:#b91c1c;margin:0;">
                                        <input type="radio" name="import_mode" value="replace" style="cursor:pointer;width:16px;height:16px;">
                                        <span>Replace existing quotation items</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between align-items-center" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 22px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Cancel
                        </button>
                        <button type="button" id="btn_confirm_import_items" class="btn btn-primary btn-sm font-weight-semibold" disabled style="background:linear-gradient(135deg, #0A4174 0%, #001D39 100%);border:none;border-radius:6px;padding:7px 22px;box-shadow:0 2px 6px rgba(10,65,116,0.3);">
                            <i class="icon-checkmark3 mr-1"></i> <span id="btn_confirm_import_label">Import Line Items</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spelling & Grammar Review Modal -->
        <div id="modal_grammar_check" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="grammarCheckModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:720px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;display:flex;align-items:center;justify-content:space-between;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="grammarCheckModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-spell-check mr-2" style="font-size:20px;color:#7BBDE8;"></i> Spelling & Grammar Review
                        </h5>
                        <div class="d-flex align-items-center">
                            <span id="grammar_issue_badge" class="badge badge-warning mr-3" style="font-size:12px;padding:5px 11px;border-radius:12px;font-weight:600;background:#ffc107;color:#212529;">0 Issues</span>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;margin:0;padding:0;line-height:1;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;max-height:68vh;overflow-y:auto;">
                        <div id="grammar_check_intro" class="alert alert-info py-2 px-3 mb-3 d-flex align-items-center justify-content-between" style="border-radius:8px;font-size:13px;border:1.5px solid #b8daff;background:#eef6fc;color:#0c5460;">
                            <div>
                                <i class="icon-info22 mr-1"></i> Review suggestions below. Click a suggested word to apply it, or click <b>Accept All</b>.
                            </div>
                            <button type="button" id="btn_grammar_accept_all" class="btn btn-sm btn-success ml-2 font-weight-bold text-nowrap" style="border-radius:6px;box-shadow:0 2px 4px rgba(40,167,69,0.25);padding:4px 12px;font-size:12px;">
                                <i class="icon-checkmark3 mr-1"></i> Accept All
                            </button>
                        </div>

                        <!-- Issues list container -->
                        <div id="grammar_issues_list">
                            <!-- Populated dynamically -->
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:10px 20px;">
                        <small class="text-muted" style="font-size:11.5px;">
                            <i class="icon-shield-check mr-1 text-success"></i> Checks spelling, grammar, punctuation & agreement
                        </small>
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Master Modal (Add / Edit Customer from Quotation Module) -->
        <div id="modal_customer_master" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="customerMasterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:760px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #001D39 0%, #0A4174 100%);color:#ffffff;padding:16px 22px;border:none;display:flex;align-items:center;justify-content:space-between;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="customerMasterModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-user-plus mr-2" style="font-size:20px;color:#7BBDE8;"></i> <span id="modal_customer_title">Add Customer</span>
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;margin:0;padding:0;line-height:1;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;max-height:72vh;overflow-y:auto;">
                        <form id="form_customer_master" onsubmit="return false;" autocomplete="off">
                            <input type="hidden" id="cust_modal_id" value="0">
                            
                            <!-- Category & Code Row -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Customer Category <span class="text-danger">*</span></label>
                                    <select id="cust_modal_type" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                        <option value="Non AMC">Non AMC Customer</option>
                                        <option value="AMC">AMC Customer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Customer Code</label>
                                    <input type="text" id="cust_modal_code" class="form-control" readonly style="height:36px;font-size:13px;border-radius:6px;background:#eef3f7;border:1.5px solid #d4e4f0;color:#0A4174;font-weight:600;">
                                </div>
                            </div>

                            <!-- Name & Primary Contact Row -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Customer / Company Name <span class="text-danger">*</span></label>
                                    <input type="text" id="cust_modal_name" class="form-control" required style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;" spellcheck="true">
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" id="cust_modal_contact" class="form-control" required style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                            </div>

                            <!-- Email & Alternate Contact Row -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Email Address</label>
                                    <input type="email" id="cust_modal_email" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                                <div class="col-md-6 form-md form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Alternate Contact / Location</label>
                                    <input type="text" id="cust_modal_alt_contact" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                            </div>

                            <!-- Contact Person Name & Number Row -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Attention / Contact Person</label>
                                    <input type="text" id="cust_modal_person" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;" spellcheck="true">
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Contact Person Mobile</label>
                                    <input type="text" id="cust_modal_person_no" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                            </div>

                            <!-- CPR/CR & VAT No Row -->
                            <div class="row">
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">CPR / CR Number</label>
                                    <input type="text" id="cust_modal_cpr" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                                <div class="col-md-6 form-group mb-2">
                                    <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">VAT Number</label>
                                    <input type="text" id="cust_modal_vat" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                </div>
                            </div>

                            <!-- Customer Address -->
                            <div class="form-group mb-2">
                                <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Customer Address</label>
                                <textarea id="cust_modal_address" rows="2" class="form-control" style="font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;" spellcheck="true"></textarea>
                            </div>

                            <!-- Description / Notes -->
                            <div class="form-group mb-0">
                                <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Description / Notes</label>
                                <textarea id="cust_modal_description" rows="2" class="form-control" style="font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;" spellcheck="true"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 22px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Cancel
                        </button>
                        <button type="button" id="btn_save_customer_master" class="btn btn-primary btn-sm font-weight-semibold" style="background:linear-gradient(135deg, #0A4174 0%, #001D39 100%);border:none;border-radius:6px;padding:7px 20px;box-shadow:0 2px 6px rgba(10,65,116,0.3);">
                            <i class="icon-checkmark3 mr-1"></i> Save Customer
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quotation Work Completion Modal -->
        <div id="modal_quote_completion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="completionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:540px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #065f46 0%, #059669 100%);color:#ffffff;padding:16px 22px;border:none;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="completionModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-checkmark-circle2 mr-2" style="font-size:20px;color:#6ee7b7;"></i> Record Work Completion
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;">
                        <p class="text-muted mb-3" style="font-size:12.5px;">
                            Record that the physical work for this approved quotation is completed. You can attach a completion certificate, signed work order, or site inspection photos.
                        </p>
                        <form id="form_quote_completion" enctype="multipart/form-data" onsubmit="return false;">
                            <input type="hidden" id="comp_quote_id" value="0">
                            
                            <div class="card p-2 mb-3" style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;">
                                <div style="font-size:11.5px;color:#166534;font-weight:600;" id="comp_quote_summary">
                                    Quotation: —
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Completion Date <span class="text-danger">*</span></label>
                                <input type="date" id="comp_date" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Completion Attachment (Certificate / Work Order / Site Photos)</label>
                                <input type="file" id="comp_attachment" class="form-control-file" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx,.xls,.xlsx" style="font-size:12px;padding:4px 0;">
                                <small class="text-muted" style="font-size:11px;">Supported formats: PDF, PNG, JPG, DOC, DOCX, XLSX (Max 15MB)</small>
                            </div>

                            <div class="form-group mb-1">
                                <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Completion Notes / Remarks</label>
                                <textarea id="comp_notes" rows="3" class="form-control" placeholder="e.g. Work completed on site as per scope. Client signed job sheet." style="font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;" spellcheck="true"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 22px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Cancel
                        </button>
                        <button type="button" id="btn_confirm_completion" class="btn btn-success btn-sm font-weight-semibold" style="background:linear-gradient(135deg, #059669 0%, #047857 100%);border:none;border-radius:6px;padding:7px 20px;box-shadow:0 2px 6px rgba(5,150,105,0.3);">
                            <i class="icon-checkmark4 mr-1"></i> Confirm Completed
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quotation Revive Modal -->
        <div id="modal_revive_quote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="reviveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:480px;">
                <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 12px 40px rgba(0,29,57,0.22);overflow:hidden;">
                    <div class="modal-header" style="background:linear-gradient(135deg, #9a3412 0%, #ea580c 100%);color:#ffffff;padding:16px 22px;border:none;">
                        <h5 class="modal-title font-weight-bold d-flex align-items-center" id="reviveModalLabel" style="font-size:16px;letter-spacing:0.3px;color:#ffffff;margin:0;">
                            <i class="icon-history mr-2" style="font-size:20px;color:#fdba74;"></i> Revive Expired Quotation
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;font-size:22px;outline:none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="background:#f8fafc;">
                        <p class="text-muted mb-3" style="font-size:12.5px;">
                            This quotation has expired. Reviving it will restore its status back to <b>Pending</b> and refresh its quotation date so the client can approve it.
                        </p>
                        <input type="hidden" id="revive_quote_id" value="0">
                        <div class="card p-2 mb-3" style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;">
                            <div style="font-size:11.5px;color:#9a3412;font-weight:600;" id="revive_quote_summary">
                                Quotation: —
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-semibold text-dark" style="font-size:12px;margin-bottom:4px;">Extend Validity Period (Days)</label>
                            <select id="revive_validity_days" class="form-control" style="height:36px;font-size:13px;border-radius:6px;border:1.5px solid #c2daeb;">
                                <option value="15">15 Days</option>
                                <option value="30" selected>30 Days (Recommended)</option>
                                <option value="45">45 Days</option>
                                <option value="60">60 Days</option>
                                <option value="90">90 Days</option>
                            </select>
                        </div>

                        <div class="form-check mb-2">
                            <label class="form-check-label" style="font-size:12.5px;cursor:pointer;color:#334155;">
                                <input type="checkbox" id="revive_reset_date" class="form-check-input" checked style="cursor:pointer;">
                                Refresh Quotation Date to Today (<b id="revive_today_label"></b>)
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center" style="background:#ffffff;border-top:1px solid #e8f0f6;padding:12px 22px;">
                        <button type="button" class="btn btn-light btn-sm font-weight-semibold" data-dismiss="modal" style="border-radius:6px;padding:6px 16px;">
                            Cancel
                        </button>
                        <button type="button" id="btn_confirm_revive" class="btn btn-warning btn-sm font-weight-semibold text-white" style="background:linear-gradient(135deg, #ea580c 0%, #c2410c 100%);border:none;border-radius:6px;padding:7px 20px;box-shadow:0 2px 6px rgba(234,88,12,0.3);">
                            <i class="icon-history mr-1"></i> Confirm Revive
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global permissions fallback to prevent permission.js ReferenceError -->
        <script>
            if (typeof permissions === 'undefined') {
                var permissions = [];
            }
        </script>

        <!-- Footer -->
        <?PHP include_once('template/footer.inc'); ?>
        <!-- /footer -->

    </div>
    <!-- /content-wrapper -->

    <!-- Print Canvas -->
    <div id="ph"></div>

    <!-- Notification Toast -->
    <div id="toast"></div>

    <!-- Units Datalist -->
    <datalist id="uom">
        <option>Lumpsum</option>
        <option>No.</option>
        <option>Set</option>
        <option>m</option>
        <option>m²</option>
        <option>m³</option>
        <option>Hr</option>
        <option>Day</option>
        <option>Month</option>
        <option>Visit</option>
        <option>Kg</option>
        <option>Ltr</option>
    </datalist>

    <!-- SheetJS XLSX Library for Excel File Parsing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- Select2 (Ensured for Searchable Dropdowns) -->
    <script src="global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <!-- SweetAlert Notification Library -->
    <script src="global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Ladda Button Spinners -->
    <script src="assets/js/ladda/spin.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.min.js" type="text/javascript"></script>
    <script src="assets/js/ladda/ladda.jquery.min.js" type="text/javascript"></script>

    <!-- Client-side Application Script -->
    <script src="../httpdocs/user_js/quotation_module.js?v=<?= @filemtime(__DIR__ . '/../httpdocs/user_js/quotation_module.js') ?: time() ?>"></script>

</body>
</html>
