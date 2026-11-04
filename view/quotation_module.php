<?php
require_once __DIR__ . '/../model/common/session_init.php';
require_once __DIR__ . '/template/thc_logo.php';

// Check user session
$isLoggedIn = isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === "true" || $_SESSION["loggedin"] === true);
$currentUserCode = "MA";
$currentUserName = "Mohammed Ali";
$currentUserType = "Operations Manager";

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
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>THC FM – Quotations</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f3f5f8;
            --card: #ffffff;
            --ink: #14213d;
            --mut: #667189;
            --line: #e2e7ef;
            --side: #12192e;
            --acc: #0097b2;
            --accbg: #e1f5f9;
            --ok: #1b8a5a;
            --okbg: #e0f4ea;
            --warn: #b87400;
            --warnbg: #fdf0d5;
            --bad: #cf3f3f;
            --badbg: #fbe5e5;
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) {
                --bg: #0d1224;
                --card: #171e36;
                --ink: #e8ecf6;
                --mut: #8f9bb8;
                --line: #273050;
                --side: #0a0f1e;
                --acc: #2cc4e0;
                --accbg: #12323d;
                --okbg: #12382a;
                --warnbg: #3a2f10;
                --badbg: #3d1a1a;
            }
        }

        :root[data-theme="dark"] {
            --bg: #0d1224;
            --card: #171e36;
            --ink: #e8ecf6;
            --mut: #8f9bb8;
            --line: #273050;
            --side: #0a0f1e;
            --acc: #2cc4e0;
            --accbg: #12323d;
            --okbg: #12382a;
            --warnbg: #3a2f10;
            --badbg: #3d1a1a;
        }

        * { box-sizing: border-box; }
        html { scroll-padding-top: env(safe-area-inset-top, 0px); }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 14px/1.45 "Segoe UI", system-ui, -apple-system, sans-serif;
            display: flex;
            min-height: 100vh;
        }

        /* Top Bar within Side or Global Header */
        .portal-bar {
            background: #090e1d;
            padding: 8px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin: -18px -12px 14px -12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .portal-bar a {
            color: #8fa3c7;
            text-decoration: none;
            font-size: 11px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.15s;
        }
        .portal-bar a:hover {
            color: #ffffff;
        }

        /* Aside / Navigation */
        aside {
            width: 220px;
            background: var(--side);
            color: #c9d1e6;
            padding: 18px 12px;
            flex: none;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--line);
        }
        .brand-logo-container {
            margin: 2px 2px 14px 2px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }
        .brand-logo-container a {
            display: block;
            text-decoration: none;
        }
        .app-logo-img {
            width: 100%;
            max-width: 196px;
            height: auto;
            display: block;
            border-radius: 4px;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }
        .app-logo-img:hover {
            opacity: 0.94;
            transform: scale(1.01);
        }
        aside a[data-v] {
            padding: 9px 12px;
            border-radius: 8px;
            margin-bottom: 3px;
            cursor: pointer;
            color: #b3bdd6;
            text-decoration: none;
            transition: all 0.15s ease;
            display: block;
        }
        aside a[data-v]:hover {
            background: rgba(255,255,255,0.06);
            color: #ffffff;
        }
        aside a.on {
            background: var(--acc);
            color: #fff;
            font-weight: 600;
        }
        aside small {
            margin: 18px 8px 4px;
            color: #8f9bb8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        #us {
            margin-top: 4px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: #ffffff;
            font-size: 13px;
        }
        #us option {
            background: var(--side);
            color: #ffffff;
        }

        /* Main Workspace */
        main {
            flex: 1;
            min-width: 0;
            padding: 22px 28px;
            overflow-y: auto;
        }
        h1 { font-size: 21px; margin: 0; font-weight: 600; }
        h2 { font-size: 15px; margin: 0 0 6px; font-weight: 600; }

        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        /* Buttons */
        button {
            font: inherit;
            cursor: pointer;
            border: 1px solid var(--line);
            background: var(--card);
            color: var(--ink);
            padding: 7px 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        button:hover {
            filter: brightness(0.96);
        }
        button.p {
            background: var(--acc);
            border-color: var(--acc);
            color: #fff;
            font-weight: 600;
        }
        button.p:hover {
            filter: brightness(1.08);
        }
        button.d {
            color: var(--bad);
            border-color: rgba(207,63,63,0.3);
        }
        button.d:hover {
            background: var(--badbg);
        }

        /* Inputs & Controls */
        input, select, textarea {
            font: inherit;
            padding: 8px 11px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--bg);
            color: var(--ink);
            min-width: 0;
        }
        button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid var(--acc);
            outline-offset: 1px;
        }

        /* Cards & Grids */
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .pad { padding: 16px; margin-bottom: 14px; }
        .pad input, .pad select, .pad textarea {
            width: 100%;
            margin-top: 8px;
        }
        .g2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .g2 input, .g2 select { margin-top: 8px; }

        /* KPI Bar */
        .kpis {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            margin: 14px 0;
        }
        .kpi {
            padding: 12px 16px;
        }
        .kpi span {
            color: var(--mut);
            font-size: 12px;
            display: block;
            margin-bottom: 4px;
        }
        .kpi strong {
            font-size: 19px;
            font-weight: 700;
        }

        /* Filter Toolbar */
        .bar {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            flex-wrap: wrap;
            align-items: center;
        }
        .bar input { flex: 1; min-width: 190px; }
        .bar select { max-width: 180px; }
        .bar label { color: var(--mut); font-size: 13px; }

        /* Data Tables */
        .tw { overflow-x: auto; }
        .lg {
            width: 100%;
            border-collapse: collapse;
        }
        .lg th, .lg td {
            text-align: left;
            padding: 10px 14px;
            border-top: 1px solid var(--line);
            white-space: nowrap;
            vertical-align: middle;
        }
        .lg th {
            color: var(--mut);
            font-size: 12px;
            font-weight: 600;
            background: rgba(0,0,0,0.015);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .lg tbody tr { cursor: pointer; transition: background 0.12s; }
        .lg tbody tr:hover, .lg tr.me { background: var(--accbg); }
        .lg td.w { white-space: normal; min-width: 220px; }
        .lg small { color: var(--mut); font-size: 12px; }

        /* Status Tags */
        .tag {
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            background: var(--accbg);
            color: var(--acc);
            white-space: nowrap;
            display: inline-block;
        }
        .tag.Approved { background: var(--okbg); color: var(--ok); }
        .tag.Notapproved { background: var(--badbg); color: var(--bad); }
        .tag.Pending { background: var(--warnbg); color: var(--warn); }
        .tag.Draft, .tag.Superseded { background: var(--line); color: var(--mut); }

        /* Split Editor / Detail Layout */
        .two {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr);
            gap: 16px;
            align-items: start;
        }
        #pv {
            position: sticky;
            top: 12px;
            max-height: calc(100vh - 30px);
            overflow: auto;
            border-radius: 8px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        }

        /* Scope of Works Item Grid */
        .it {
            display: grid;
            grid-template-columns: 75px 1fr 100px 95px 32px;
            gap: 8px;
            margin-bottom: 8px;
            align-items: center;
        }
        .it input { margin: 0 !important; }
        .it.h { color: var(--mut); font-size: 12px; font-weight: 600; }
        .it b { text-align: right; }

        /* Terms & Conditions Rows */
        .tr {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }
        .tr textarea { flex: 1; margin: 0 !important; }

        /* Key-Value Details */
        .kv {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 7px 10px;
            font-size: 13px;
        }
        .kv span { color: var(--mut); }

        /* Letterhead Formatted Sheet */
        .sheet {
            background: #ffffff;
            color: #111111;
            font: 12px/1.45 Calibri, "Segoe UI", sans-serif;
            padding: 30px 34px;
            border: 1px solid var(--line);
            border-radius: 6px;
        }
        .sheet p { margin: 8px 0; }
        .sheet table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .sheet th, .sheet td {
            border: 1px solid #333333;
            padding: 4px 7px;
            text-align: left;
            color: #111111;
        }
        .sheet .r { text-align: right; }
        .sheet .c { text-align: center; }
        .lh {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }
        .lh img {
            max-height: 70px;
            height: auto;
            display: block;
        }
        .sheet ol { padding-left: 20px; margin: 6px 0; }
        .sheet ol li { margin-bottom: 2px; }
        .sg {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin-top: 18px;
        }
        .ap {
            border: 1px solid #333333;
            background: #f0f0f0;
            padding: 8px 12px;
            width: 44%;
            min-height: 80px;
        }
        .ft {
            margin-top: 18px;
            background: #2a2a72;
            color: #ffffff;
            padding: 8px 12px;
            font-size: 10px;
            border-radius: 3px;
            text-align: center;
        }

        /* Printable Sheet Styling */
        #ph { display: none; }
        @media print {
            body > *:not(#ph) { display: none !important; }
            #ph { display: block; }
            .sheet { border: 0; padding: 0; }
        }

        /* Toast Popup */
        #toast {
            position: fixed;
            left: 50%;
            bottom: 26px;
            transform: translateX(-50%);
            background: #14213d;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            display: none;
            z-index: 99999;
            box-shadow: 0 4px 18px rgba(0,0,0,0.25);
            font-size: 13px;
            font-weight: 500;
        }

        /* Mobile / Small Screens */
        @media (max-width: 860px) {
            body { flex-direction: column; }
            aside {
                width: auto;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 6px;
                padding: 10px;
                align-items: center;
            }
            .portal-bar { display: none; }
            .brand-logo-container { width: 100%; margin: 0 4px 8px; border-bottom: none; }
            .app-logo-img { max-width: 160px; }
            aside small { display: none; }
            #us { width: 100%; }
            main { padding: 14px; }
            .two { grid-template-columns: 1fr; }
            #pv { position: static; max-height: none; }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside>
        <div class="portal-bar">
            <a href="dashboard.php" title="Return to THC Portal">← THC Portal</a>
            <span style="font-size:10px;color:#6b7c9f;">v2.0</span>
        </div>

        <div class="brand-logo-container">
            <a href="dashboard.php" title="THC Facility Management Portal">
                <img src="<?= $thc_logo_src ?>" 
                     onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='global_assets/images/backgrounds/final_logo2.png';}else if(this.dataset.fb==1){this.dataset.fb=2;this.src='../httpdocs/images/final_logo2.png';}else if(this.dataset.fb==2){this.dataset.fb=3;this.src='<?= $thc_logo_base64 ?>';}" 
                     alt="THC Facility Management" 
                     class="app-logo-img">
            </a>
        </div>

        <a data-v="log" class="on">Quotation log</a>
        <a data-v="A">+ New quote · AMC</a>
        <a data-v="N">+ New quote · Non-AMC</a>
        <a data-v="perf">My performance</a>

        <small>Logged in profile</small>
        <select id="us" title="Select active user profile"></select>
    </aside>

    <!-- Main Content Area -->
    <main id="v"></main>

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

