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

$hasQuotationAccess = true;

if ($isLoggedIn) {
    if (!empty($_SESSION["username"])) {
        $currentUserCode = strtoupper(substr($_SESSION["username"], 0, 4));
    }
    if (!empty($_SESSION["user_name"])) {
        $currentUserName = $_SESSION["user_name"];
    }
    if (!empty($_SESSION["user_type"])) {
        $currentUserType = $_SESSION["user_type"];
    }

    // Role-based quotation permission check
    if (isset($_SESSION['USERROLLID'])) {
        $userRoleId = (int)$_SESSION['USERROLLID'];
        // Administrator (Role 1) always has full privilege
        if ($userRoleId !== 1 && isset($obj) && method_exists($obj, 'getUserPermissionsByUserID')) {
            $userPerms = $obj->getUserPermissionsByUserID($userRoleId);
            if (is_array($userPerms) && !empty($userPerms)) {
                $hasQuotationAccess = in_array('Quotation', $userPerms) ||
                                      in_array('QuotationModule', $userPerms) ||
                                      in_array('ViewQuotation', $userPerms) ||
                                      in_array('CreateQuotation', $userPerms);
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

    <!-- Main Navigation Topnav & Icons -->
    <link href="assets/css/thc_topnav.css" rel="stylesheet" type="text/css">
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
        .card.bar input#fq,
        .filter-toolbar input#fq {
            flex: 2 1 200px !important;
            min-width: 180px !important;
            max-width: 320px !important;
            height: 38px !important;
            margin: 0 !important;
            padding: 7px 14px !important;
            font-size: 13.5px !important;
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
        .tag.Draft, .tag.Superseded {
            background: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1;
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
        .it input { margin: 0 !important; }
        .it.h {
            color: var(--q-navy-dark);
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }
        .it b { text-align: right; }

        /* Terms Rows */
        .tr {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            align-items: flex-start;
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
            text-align: left;
        }
        .sheet td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            font-size: 11.5px;
            color: #1e293b;
            vertical-align: middle;
        }
        .sheet tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .sheet .r { text-align: right; }
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
            body { background: #ffffff !important; padding: 0 !important; }
            .thc-topnav, .thc-quotation-nav-card, .content-wrapper, footer, .navbar-top {
                display: none !important;
            }
            #ph {
                display: block !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                background: #ffffff !important;
                z-index: 9999999 !important;
            }
            .sheet {
                border: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
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

    <!-- Client-side Application Script -->
    <script src="../httpdocs/user_js/quotation_module.js"></script>

</body>
</html>
