<?php
/**
 * THC Facility Management - Standalone Printable Quotation Sheet
 */

require_once __DIR__ . '/../../model/common/session_init.php';
require_once __DIR__ . '/../../model/db_connection/connection.php';

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
    die("<h3>Quotation not found. Please verify the ID or Reference Number.</h3>");
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

$rev = (int)$q['rev_no'];
$qNo = !empty($q['quotation_no']) ? $q['quotation_no'] . ($rev > 0 ? "/R" . $rev : "") : "(Draft)";
$vatRate = (float)$q['vat_rate'];
$subtotal = (float)$q['subtotal_excl_vat'];
$vatAmt = (float)$q['vat_amount'];
$total = (float)$q['total_incl_vat'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($q['user_code'] . "-QTN-" . ($q['seq_no'] ?: "DRAFT") . ($rev ? "-R" . $rev : "")) ?></title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background: #f8fafc;
            color: #111;
            font: 12px/1.45 Calibri, "Segoe UI", sans-serif;
        }
        .container {
            max-width: 820px;
            margin: 0 auto;
            background: #fff;
            padding: 34px 40px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        .lh {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            color: #2a2a72;
            font-size: 11px;
        }
        .logo { font-size: 34px; font-weight: 800; letter-spacing: -1px; }
        p { margin: 8px 0; }
        table { width: 100%; border-collapse: collapse; margin: 12px 0; }
        th, td { border: 1px solid #333; padding: 4px 7px; text-align: left; }
        .r { text-align: right; }
        .c { text-align: center; }
        ol { padding-left: 20px; margin: 6px 0; }
        ol li { margin-bottom: 2px; }
        .sg {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin-top: 18px;
        }
        .ap {
            border: 1px solid #333;
            background: #f0f0f0;
            padding: 8px 12px;
            width: 44%;
            min-height: 80px;
        }
        .ft {
            margin-top: 20px;
            background: #2a2a72;
            color: #fff;
            padding: 8px 12px;
            font-size: 10px;
            border-radius: 3px;
            text-align: center;
        }
        .print-btn-bar {
            max-width: 820px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .print-btn-bar button {
            background: #0097b2;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        @media print {
            body { padding: 0; background: #fff; }
            .container { border: 0; box-shadow: none; padding: 0; max-width: 100%; }
            .print-btn-bar { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="print-btn-bar">
        <button onclick="window.print()">Print / Save as PDF</button>
        <button style="background:#555;" onclick="window.close()">Close</button>
    </div>

    <div class="container">
        <div class="lh">
            <b class="logo">thc.</b>
            <span>FACILITY<br>MANAGEMENT</span>
        </div>

        <p>
            <b>No: <?= htmlspecialchars($qNo) ?><br>
            Date: <?= fDate($q['quotation_date']) ?></b>
        </p>

        <p>
            <b>To,<br><?= htmlspecialchars($q['client_name']) ?><br>
            <?= nl2br(htmlspecialchars($q['client_address'])) ?></b>
            <?php if (!empty($q['client_code'])): ?>
                <br><span style="font-size:11px;color:#555;">Client code: <?= htmlspecialchars($q['client_code']) ?></span>
            <?php endif; ?>
        </p>

        <?php if (!empty($q['attention'])): ?>
            <p><b>Kind Attn: <?= htmlspecialchars($q['attention']) ?></b></p>
        <?php endif; ?>

        <p>
            <b><u>Sub: <?= htmlspecialchars($q['subject']) ?></u></b><br>
            With reference to subject job we are pleased to submit our offer as under: -
        </p>

        <table>
            <thead>
                <tr>
                    <th style="width:38px;text-align:center;">Sl.</th>
                    <th>Description</th>
                    <th style="width:65px;text-align:center;">Qty</th>
                    <th style="width:80px;text-align:center;">Unit</th>
                    <th style="width:100px;text-align:right;">Total (BD)</th>
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
                <tr>
                    <td colspan="4" class="c"><b>Amount Excluding VAT</b></td>
                    <td class="r"><b><?= number_format($subtotal, 3) ?></b></td>
                </tr>
                <tr>
                    <td colspan="4" class="c"><b>VAT <?= $vatRate ?>%</b></td>
                    <td class="r"><b><?= number_format($vatAmt, 3) ?></b></td>
                </tr>
                <tr>
                    <td colspan="4" class="c"><b>Total Amount (BD)</b></td>
                    <td class="r"><b><?= number_format($total, 3) ?></b></td>
                </tr>
            </tfoot>
        </table>

        <?php if (!empty($terms)): ?>
            <p><b><u>Terms and Condition:</u></b></p>
            <ol>
                <?php foreach ($terms as $t): ?>
                    <li><?= htmlspecialchars($t) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>

        <p>We hope you will find our offer quite competitive and in line with your requirements and look forward to receiving your valued order confirmation at the earliest.</p>

        <div class="sg">
            <div>
                <b>Thanking you,<br><br>
                Yours sincerely,<br>
                THC Facility Management W.L.L<br><br>
                <?= htmlspecialchars($q['user_name']) ?><br>
                <span style="font-weight:400;color:#444;"><?= htmlspecialchars($q['user_designation']) ?></span></b>
            </div>
            <div class="ap">
                <b>Approved By:</b><br><br>
                Name:<br><br>
                Date:
            </div>
        </div>

        <div class="ft">
            Tel: +973 17 100 190 | info@thc.com.bh | www.thc.com.bh · CR 88982-1 · YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain
        </div>
    </div>

    <?php if ($autoPrint): ?>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    <?php endif; ?>

</body>
</html>
