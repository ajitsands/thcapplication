<?php
/**
 * THC Facility Management - Standalone Printable Quotation Sheet
 * Aligned with THC Corporate Reporting Design System (not_assigned_workorder_print.php)
 */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

require_once __DIR__ . '/../../model/common/session_init.php';
require_once __DIR__ . '/../../model/db_connection/connection.php';
require_once __DIR__ . '/../template/thc_logo.php';

$quoteId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$refNo = isset($_GET['ref_no']) ? trim($_GET['ref_no']) : '';
$autoPrint = isset($_GET['autoprint']) && $_GET['autoprint'] == '1';

$q = null;
$items = [];
$terms = [];

// Try DB
try {
    $dbConn = new DBConnection();
    $db = $dbConn->ConnectToMYSQL();
    if ($db && !mysqli_connect_errno()) {
        mysqli_set_charset($db, 'utf8mb4');

        // Safety check: Ensure discount columns exist if accessed directly
        $chkDisc = @mysqli_query($db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'discount_amount'");
        if ($chkDisc && mysqli_num_rows($chkDisc) === 0) {
            @mysqli_query($db, "ALTER TABLE `tbl_quotations_v2` 
                ADD COLUMN `discount_type` VARCHAR(20) NOT NULL DEFAULT 'amount' AFTER `vat_rate`,
                ADD COLUMN `discount_value` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_type`,
                ADD COLUMN `discount_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_value`");
        }
        if ($quoteId > 0) {
            $qRes = mysqli_query($db, "SELECT * FROM tbl_quotations_v2 WHERE id = {$quoteId}");
        } elseif ($refNo !== '') {
            $escRef = mysqli_real_escape_string($db, $refNo);
            $qRes = mysqli_query($db, "SELECT * FROM tbl_quotations_v2 WHERE quotation_no = '{$escRef}' ORDER BY rev_no DESC LIMIT 1");
        } else {
            $qRes = null;
        }

        if ($qRes && ($row = mysqli_fetch_assoc($qRes))) {
            $q = $row;
            $iRes = mysqli_query($db, "SELECT * FROM tbl_quotation_items_v2 WHERE quotation_id = {$q['id']} ORDER BY sort_order ASC, item_id ASC");
            if ($iRes) {
                while ($it = mysqli_fetch_assoc($iRes)) {
                    $items[] = $it;
                }
            }
            $terms = json_decode($q['terms_json'], true);
        }
    }
} catch (\Throwable $e) {}

// Fallback to JSON if not found in DB
if (!$q) {
    $jsonFile = __DIR__ . '/../../scratch/quotations_data.json';
    if (file_exists($jsonFile)) {
        $data = json_decode(file_get_contents($jsonFile), true);
        if (is_array($data)) {
            foreach ($data as $item) {
                if (($quoteId > 0 && $item['id'] == $quoteId) || ($refNo !== '' && $item['quotation_no'] == $refNo)) {
                    $q = [
                        'id' => $item['id'],
                        'seq_no' => $item['seq_no'],
                        'rev_no' => $item['rev_no'],
                        'quotation_no' => $item['quotation_no'],
                        'client_name' => $item['client_name'],
                        'client_code' => $item['client_code'],
                        'client_address' => $item['client_address'],
                        'attention' => $item['attention'],
                        'subject' => $item['subject'],
                        'quotation_date' => $item['quotation_date'],
                        'user_code' => $item['user_code'],
                        'user_name' => $item['user_name'],
                        'user_designation' => $item['user_designation'],
                        'vat_rate' => $item['vat_rate'],
                        'discount_type' => $item['discount_type'] ?? 'amount',
                        'discount_value' => $item['discount_value'] ?? 0,
                        'discount_amount' => $item['discount_amount'] ?? 0,
                        'subtotal_excl_vat' => $item['subtotal_excl_vat'],
                        'vat_amount' => $item['vat_amount'],
                        'total_incl_vat' => $item['total_incl_vat']
                    ];
                    $items = $item['items'];
                    $terms = $item['terms'];
                    break;
                }
            }
        }
    }
}

if (!$q) {
    die("<div style='font-family:sans-serif;padding:30px;color:#c00;'><h3>Quotation not found. Please verify the ID or Reference Number.</h3></div>");
}

function fDate($str) {
    if (!$str) return "—";
    $parts = explode("-", $str);
    if (count($parts) < 3) return $str;
    $time = mktime(0, 0, 0, (int)$parts[1], (int)$parts[2], (int)$parts[0]);
    $day = date('j', $time);
    $suffix = date('S', $time);
    $month = date('F', $time);
    $year = date('Y', $time);
    return "{$day}{$suffix} {$month} {$year}";
}

$calcSubtotal = 0.0;
foreach ($items as $it) {
    $itQty = isset($it['quantity']) ? (float)$it['quantity'] : (isset($it[1]) ? (float)$it[1] : 0.0);
    $itPrice = isset($it['unit_price']) ? (float)$it['unit_price'] : (isset($it[3]) ? (float)$it[3] : 0.0);
    $itTotal = isset($it['total_price']) && (float)$it['total_price'] > 0 ? (float)$it['total_price'] : ($itQty * $itPrice);
    $calcSubtotal += $itTotal;
}

$rev = (int)$q['rev_no'];
$qNo = !empty($q['quotation_no']) ? $q['quotation_no'] . ($rev > 0 ? "/R" . $rev : "") : "(Draft)";
$vatRate = (float)$q['vat_rate'];
$subtotal = (float)$q['subtotal_excl_vat'];
if ($subtotal <= 0 && $calcSubtotal > 0) {
    $subtotal = $calcSubtotal;
}

$discountType = isset($q['discount_type']) && $q['discount_type'] === 'percent' ? 'percent' : 'amount';
$discountVal = isset($q['discount_value']) ? (float)$q['discount_value'] : (isset($q['discount']) ? (float)$q['discount'] : 0.0);
$discountAmt = isset($q['discount_amount']) ? (float)$q['discount_amount'] : 0.0;
if ($discountAmt <= 0 && $discountVal > 0) {
    if ($discountType === 'percent') {
        $discountAmt = ($subtotal * $discountVal) / 100.0;
    } else {
        $discountAmt = $discountVal;
    }
}
if ($discountAmt > $subtotal) {
    $discountAmt = $subtotal;
}

$netSubtotal = max(0, $subtotal - $discountAmt);
$vatAmt = ($netSubtotal * $vatRate) / 100.0;
$total = $netSubtotal + $vatAmt;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($q['user_code'] . "-QTN-" . ($q['seq_no'] ?: "DRAFT") . ($rev ? "-R" . $rev : "")) ?></title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-size: 12px;
            color: #1e293b;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 0 40px 0;
        }

        .report-container {
            width: 860px;
            margin: 0 auto;
            background: #ffffff;
            padding: 34px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            border: 1px solid #cbd5e1;
        }

        .no-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 14px;
        }

        .btn-action {
            background: #2e2e79;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background-color 0.2s;
            font-family: inherit;
        }

        .btn-action:hover {
            background: #1e1e59;
            color: #ffffff;
        }

        .btn-excel {
            background: #0f766e;
        }

        .btn-excel:hover {
            background: #115e59;
        }

        .lh {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            border-bottom: 2px solid #2e2e79;
            padding-bottom: 14px;
        }

        .lh img {
            max-height: 70px;
            height: auto;
            display: block;
        }

        p { margin: 8px 0; }

        table.tbl-quotation {
            width: 100%;
            border-collapse: collapse;
            margin: 14px 0;
            border: 1px solid #cbd5e1;
            background: #ffffff;
        }

        table.tbl-quotation th {
            background-color: #2e2e79 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 9px 10px;
            font-size: 11px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 1px solid #2e2e79;
            vertical-align: middle;
            text-align: left;
        }

        table.tbl-quotation td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            font-size: 11.5px;
            vertical-align: middle;
            color: #1e293b;
        }

        table.tbl-quotation tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .r { text-align: right; }
        .c { text-align: center; }

        ol { padding-left: 20px; margin: 8px 0; }
        ol li { margin-bottom: 3px; }

        .sg {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 24px;
        }

        .ap {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 6px;
            padding: 10px 14px;
            width: 46%;
            min-height: 90px;
        }

        .ft {
            margin-top: 24px;
            background: #2e2e79;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 10px;
            border-radius: 4px;
            text-align: center;
            letter-spacing: 0.4px;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .report-container {
                width: 100% !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            body, table, td, th {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

<div class="report-container">

    <!-- Top Action Bar (No Print) -->
    <div class="no-print">
        <div style="font-size: 12px; color: #64748b;">
            Document: <strong>Quotation Sheet</strong> &nbsp;|&nbsp; Ref: <strong><?= htmlspecialchars($qNo) ?></strong>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" class="btn-action" onclick="window.print();">
                <span>&#128438;</span> Print Quotation
            </button>
            <button type="button" class="btn-action" style="background:#475569;" onclick="window.close();">
                Close
            </button>
        </div>
    </div>

    <!-- Letterhead Header -->
    <div class="lh">
        <div>
            <img src="../global_assets/images/logo_print.png" 
                 onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='../../view/global_assets/images/logo_print.png';}else if(this.dataset.fb==1){this.dataset.fb=2;this.src='data:image/png;base64,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';}" 
                 alt="THC Facility Management" 
                 style="max-height: 65px; height: auto;">
        </div>

    </div>

    <!-- Quotation Reference & Date -->
    <p>
        <b>No: <?= htmlspecialchars($qNo) ?><br>
        Date: <?= fDate($q['quotation_date']) ?></b>
    </p>

    <!-- Client Info -->
    <p>
        <b>To,<br><?= htmlspecialchars($q['client_name']) ?><br>
        <?= nl2br(htmlspecialchars($q['client_address'])) ?></b>
        <?php if (!empty($q['client_code'])): ?>
            <br><span style="font-size: 11px; color: #555;">Client code: <?= htmlspecialchars($q['client_code']) ?></span>
        <?php endif; ?>
    </p>

    <?php if (!empty($q['attention'])): ?>
        <p><b>Kind Attn: <?= htmlspecialchars($q['attention']) ?></b></p>
    <?php endif; ?>

    <p style="margin-top: 14px;">
        <b><u>Sub: <?= htmlspecialchars($q['subject']) ?></u></b><br>
        With reference to subject job we are pleased to submit our offer as under: -
    </p>

    <!-- Line Items Table -->
    <table class="tbl-quotation">
        <thead>
            <tr>
                <th style="width: 38px; text-align: center;">Sl.</th>
                <th>Description</th>
                <th style="width: 65px; text-align: center;">Qty</th>
                <th style="width: 80px; text-align: center;">Unit</th>
                <th style="width: 100px; text-align: right;">Total (BD)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $it): 
                $qty = isset($it['quantity']) ? (float)$it['quantity'] : (float)($it[1] ?? 1);
                $price = isset($it['unit_price']) ? (float)$it['unit_price'] : (float)($it[3] ?? 0);
                $lineTot = isset($it['total_price']) ? (float)$it['total_price'] : ($qty * $price);
                $desc = isset($it['description']) ? $it['description'] : ($it[0] ?? '');
                $unit = isset($it['unit']) ? $it['unit'] : ($it[2] ?? 'Lumpsum');
            ?>
            <tr>
                <td class="c"><?= ($idx + 1) ?>.</td>
                <td><?= htmlspecialchars($desc) ?></td>
                <td class="c"><?= $qty ?></td>
                <td class="c"><?= htmlspecialchars($unit) ?></td>
                <td class="r"><?= number_format($lineTot, 3) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <?php if ($discountAmt > 0): ?>
            <tr style="background: #ffffff;">
                <td colspan="4" class="c"><b>Gross Amount Excluding VAT</b></td>
                <td class="r"><b><?= number_format($subtotal, 3) ?></b></td>
            </tr>
            <tr style="background: #ffffff; color: #b91c1c;">
                <td colspan="4" class="c"><b>Discount <?= $discountType === 'percent' ? "({$discountVal}%)" : "" ?></b></td>
                <td class="r"><b>-<?= number_format($discountAmt, 3) ?></b></td>
            </tr>
            <tr style="background: #ffffff;">
                <td colspan="4" class="c"><b>Net Amount Excluding VAT</b></td>
                <td class="r"><b><?= number_format($netSubtotal, 3) ?></b></td>
            </tr>
            <?php else: ?>
            <tr style="background: #ffffff;">
                <td colspan="4" class="c"><b>Amount Excluding VAT</b></td>
                <td class="r"><b><?= number_format($subtotal, 3) ?></b></td>
            </tr>
            <?php endif; ?>
            <tr style="background: #ffffff;">
                <td colspan="4" class="c"><b>VAT <?= $vatRate ?>%</b></td>
                <td class="r"><b><?= number_format($vatAmt, 3) ?></b></td>
            </tr>
            <tr style="background: #f1f5f9; font-weight: 700;">
                <td colspan="4" class="c"><b>Total Amount (BD)</b></td>
                <td class="r"><b><?= number_format($total, 3) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <!-- Terms & Conditions -->
    <?php if (!empty($terms)): ?>
        <p style="margin-top: 16px;"><b><u>Terms and Condition:</u></b></p>
        <ol>
            <?php foreach ($terms as $t): ?>
                <li><?= htmlspecialchars($t) ?></li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <p style="margin-top: 14px;">We hope you will find our offer quite competitive and in line with your requirements and look forward to receiving your valued order confirmation at the earliest.</p>

    <!-- Signatures -->
    <div class="sg">
        <div>
            <b>Thanking you,<br><br>
            Yours sincerely,<br>
            THC Facility Management W.L.L<br><br>
            <?php
            $signer = $q['user_name'] ?? '';
            if (strtolower(trim($signer)) === 'adminstrator') {
                $signer = 'Administrator';
            }
            ?>
            <?= htmlspecialchars($signer) ?><br>
            <span style="font-weight: 400; color: #475569;"><?= htmlspecialchars($q['user_designation']) ?></span></b>
        </div>
        <div class="ap">
            <b>Approved By:</b><br><br>
            Name:<br><br>
            Date:
        </div>
    </div>

    <!-- Corporate Footer -->
    <div class="ft">
        Tel: +973 17 100 190 | info@thc.com.bh | www.thc.com.bh · CR 88982-1 · YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain
    </div>

</div>

<?php if ($autoPrint): ?>
<script>
    function triggerPrint() {
        setTimeout(function() {
            window.print();
        }, 250);
    }
    if (document.readyState === 'complete') {
        triggerPrint();
    } else {
        window.addEventListener('load', triggerPrint);
    }
</script>
<?php endif; ?>

</body>
</html>
