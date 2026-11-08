<?php
/**
 * THC Facility Management - Quotation Module Controller
 * Handles quotations, revisions, line items, approvals, and performance metrics.
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}
require_once __DIR__ . '/../../model/common/session_init.php';
require_once __DIR__ . '/../../model/db_connection/connection.php';

if (!class_exists('QuotationModuleController')) {
class QuotationModuleController
{
    private $db;
    private $jsonFallbackFile;
    private $unitsFallbackFile;
    private $isDbConnected = false;

    // Standard Default Terms
    private $defaultTerms = [
        "Payment to be made in advance. (Cash/Cheque)",
        "Validity for the quotation 15 Days.",
        "Prices are valid for the above item/quantity. If there is any change in item/quantity, we reserve the right to revise prices.",
        "Items cannot be returned once purchased.",
        "Completion: 2-4 days from date of confirmed order.",
        "On opening the system further, unforeseen concerns may arise for which we may need to quote separately.",
        "Scaffolding excluded. If required an additional quote will be provided."
    ];

    // Standard Library Terms
    private $libraryTerms = [
        "Payment terms: 50% advance, balance on completion.",
        "Warranty: 12 months on workmanship from date of completion.",
        "Works to be carried out after normal working hours; night-work charges apply.",
        "Materials priced as of quotation date; subject to supplier price changes.",
        "Client to provide access, power and water at the work location.",
        "Prices exclude permits, approvals and authority fees."
    ];

    // Rejection Reasons
    private $rejectionReasons = [
        "Price too high",
        "Budget not approved",
        "Scope changed",
        "Went with another vendor",
        "No response / expired",
        "Other"
    ];

    // Default Fallback Users
    private $defaultUsers = [
        "ADM" => ["name" => "Administrator", "title" => "Administrator"],
        "MA" => ["name" => "Mohammed Ali", "title" => "Operations Manager"],
        "RM" => ["name" => "Reghilal Munambeth", "title" => "Operation Coordinator"],
        "SKP" => ["name" => "Satish Kumar Palanimuthu", "title" => "Operation Coordinator"]
    ];

    // Default Fallback AMC Clients
    private $defaultAmcClients = [
        ["code" => "C0179", "name" => "Zayani Motors", "address" => "P.O. Box 2399, Manama, Kingdom of Bahrain", "contact" => "+973 3944 1015"],
        ["code" => "C0178", "name" => "Black Fortune", "address" => "Bldg 12, Road 3815, Seef, Kingdom of Bahrain", "contact" => "+973 3728 3293"],
        ["code" => "C0175", "name" => "AK Venture", "address" => "Office 21, Bldg 5, Road 1702, Diplomatic Area, Manama", "contact" => "17212130"],
        ["code" => "C0173", "name" => "UAE Embassy", "address" => "Block 321, Road 2108, Juffair, Kingdom of Bahrain", "contact" => "17748333"],
        ["code" => "C0172", "name" => "Seef Entertainment W.L.L", "address" => "Block 428, Seef District, Kingdom of Bahrain", "contact" => "17000000"]
    ];

    // Default Units Master
    private $defaultUnits = [
        "Lumpsum", "No.", "Nos", "Set", "Lot", "Job", "Pcs", 
        "Trip", "Visit", "Hr", "Day", "Month", 
        "m", "m²", "m³", "Kg", "Ltr", "Box", "Roll", "Pack", "Pair"
    ];

    public function __construct()
    {
        $this->jsonFallbackFile = __DIR__ . '/../../scratch/quotations_data.json';
        $this->unitsFallbackFile = __DIR__ . '/../../scratch/quotation_units.json';
        $this->initDbConnection();
        $this->ensureSchemaAndData();
    }

    private function initDbConnection()
    {
        try {
            $dbConn = new DBConnection();
            $this->db = $dbConn->ConnectToMYSQL();
            if ($this->db && !mysqli_connect_errno()) {
                mysqli_set_charset($this->db, 'utf8mb4');
                $this->isDbConnected = true;
            }
        } catch (\Throwable $e) {
            $this->isDbConnected = false;
        }
    }

    private function ensureSchemaAndData()
    {
        if ($this->isDbConnected) {
            $tableSql = "CREATE TABLE IF NOT EXISTS `tbl_quotations_v2` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `seq_no` INT(11) DEFAULT NULL,
                `rev_no` INT(11) NOT NULL DEFAULT 0,
                `quotation_no` VARCHAR(100) DEFAULT '',
                `is_amc` TINYINT(1) NOT NULL DEFAULT 1,
                `client_code` VARCHAR(50) DEFAULT '',
                `client_name` VARCHAR(255) NOT NULL,
                `client_address` TEXT,
                `contact_no` VARCHAR(100) DEFAULT '',
                `attention` VARCHAR(255) DEFAULT '',
                `subject` TEXT NOT NULL,
                `quotation_date` DATE NOT NULL,
                `user_code` VARCHAR(50) NOT NULL,
                `user_name` VARCHAR(255) NOT NULL,
                `user_designation` VARCHAR(255) DEFAULT '',
                `vat_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
                `discount_type` VARCHAR(20) NOT NULL DEFAULT 'amount',
                `discount_value` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `discount_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `subtotal_excl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `vat_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `total_incl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `terms_json` LONGTEXT,
                `status` ENUM('Draft','Pending','Approved','Not approved','Superseded') NOT NULL DEFAULT 'Draft',
                `rejection_reason` VARCHAR(255) DEFAULT '',
                `remark` TEXT,
                `created_by_id` INT(11) DEFAULT 0,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_seq_rev` (`seq_no`, `rev_no`),
                KEY `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            @mysqli_query($this->db, $tableSql);

            // Migration check: Add discount columns if missing
            $chkDisc = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'discount_amount'");
            if ($chkDisc && mysqli_num_rows($chkDisc) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `discount_type` VARCHAR(20) NOT NULL DEFAULT 'amount' AFTER `vat_rate`,
                    ADD COLUMN `discount_value` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_type`,
                    ADD COLUMN `discount_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_value`");
            }

            $itemsSql = "CREATE TABLE IF NOT EXISTS `tbl_quotation_items_v2` (
                `item_id` INT(11) NOT NULL AUTO_INCREMENT,
                `quotation_id` INT(11) NOT NULL,
                `sort_order` INT(11) NOT NULL DEFAULT 1,
                `description` TEXT NOT NULL,
                `quantity` DECIMAL(18,3) NOT NULL DEFAULT 1.000,
                `unit` VARCHAR(50) NOT NULL DEFAULT 'Lumpsum',
                `unit_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                `total_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
                PRIMARY KEY (`item_id`),
                KEY `idx_quotation_id` (`quotation_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            @mysqli_query($this->db, $itemsSql);

            $unitsSql = "CREATE TABLE IF NOT EXISTS `tbl_quotation_units_master` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `unit_name` VARCHAR(50) NOT NULL,
                `sort_order` INT(11) NOT NULL DEFAULT 0,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `idx_unit_name` (`unit_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            @mysqli_query($this->db, $unitsSql);

            $cntRes = @mysqli_query($this->db, "SELECT COUNT(*) as cnt FROM `tbl_quotation_units_master`");
            $cntRow = $cntRes ? mysqli_fetch_assoc($cntRes) : null;
            if (!$cntRow || (int)$cntRow['cnt'] === 0) {
                $sort = 1;
                foreach ($this->defaultUnits as $u) {
                    $escU = mysqli_real_escape_string($this->db, $u);
                    @mysqli_query($this->db, "INSERT IGNORE INTO `tbl_quotation_units_master` (`unit_name`, `sort_order`) VALUES ('$escU', $sort)");
                    $sort++;
                }
            }

            // Do not automatically re-seed demo data if the administrator clears the table.
            // Demo data can be manually seeded by visiting with ?action=seed_demo_data if needed.
        } else {
            if (!file_exists($this->jsonFallbackFile)) {
                $this->seedInitialDataJson();
            }
        }
    }

    private function getInitialConceptQuotes()
    {
        return [
            [
                "seq" => 7065, "rev" => 0, "no" => "CG/THC/MA/QTN/7065/0825", "client" => "M/S Al Futtaim",
                "code" => "NA-0001", "amc" => 0, "addr" => "M/S Al Futtaim, Manama, Kingdom of Bahrain",
                "contact" => "+973 1712 3456", "attn" => "Facilities Manager",
                "subj" => "Supply & installation of access panel for M&S BCC.",
                "date" => "2025-08-11", "user" => "MA", "user_name" => "Mohammed Ali", "user_designation" => "Operations Manager",
                "vat" => 10.0, "st" => "Approved", "remark" => "",
                "items" => [
                    ["desc" => "Supply and installation of 60x60 access panel for reachable height ceiling", "qty" => 2, "unit" => "No.", "price" => 37.5]
                ]
            ],
            [
                "seq" => 7066, "rev" => 0, "no" => "CG/THC/MA/QTN/7066/1026", "client" => "Zayani Motors",
                "code" => "C0179", "amc" => 1, "addr" => "P.O. Box 2399, Manama, Kingdom of Bahrain",
                "contact" => "+973 3944 1015", "attn" => "Workshop In-charge",
                "subj" => "Chiller coil replacement – showroom",
                "date" => "2026-10-05", "user" => "MA", "user_name" => "Mohammed Ali", "user_designation" => "Operations Manager",
                "vat" => 10.0, "st" => "Superseded", "remark" => "Revised to R1 on 2026-10-08",
                "items" => [
                    ["desc" => "Chiller coil replacement incl. gas charging", "qty" => 1, "unit" => "Lumpsum", "price" => 1450.0]
                ]
            ],
            [
                "seq" => 7066, "rev" => 1, "no" => "CG/THC/MA/QTN/7066/1026", "client" => "Zayani Motors",
                "code" => "C0179", "amc" => 1, "addr" => "P.O. Box 2399, Manama, Kingdom of Bahrain",
                "contact" => "+973 3944 1015", "attn" => "Workshop In-charge",
                "subj" => "Chiller coil replacement – showroom",
                "date" => "2026-10-08", "user" => "MA", "user_name" => "Mohammed Ali", "user_designation" => "Operations Manager",
                "vat" => 10.0, "st" => "Approved", "remark" => "Discount approved by Operations Manager",
                "items" => [
                    ["desc" => "Chiller coil replacement incl. gas charging", "qty" => 1, "unit" => "Lumpsum", "price" => 1320.0]
                ]
            ],
            [
                "seq" => 7067, "rev" => 0, "no" => "CG/THC/RM/QTN/7067/1026", "client" => "Black Fortune",
                "code" => "C0178", "amc" => 1, "addr" => "Bldg 12, Road 3815, Seef, Kingdom of Bahrain",
                "contact" => "+973 3728 3293", "attn" => "Restaurant Manager",
                "subj" => "Kitchen hood & duct cleaning",
                "date" => "2026-10-12", "user" => "RM", "user_name" => "Reghilal Munambeth", "user_designation" => "Operation Coordinator",
                "vat" => 10.0, "st" => "Not approved", "remark" => "Price too high – client asked for a re-quote with reduced scope",
                "items" => [
                    ["desc" => "Kitchen hood degreasing", "qty" => 4, "unit" => "No.", "price" => 85.0],
                    ["desc" => "Duct cleaning", "qty" => 120, "unit" => "m", "price" => 6.5]
                ]
            ],
            [
                "seq" => 7068, "rev" => 0, "no" => "CG/THC/SKP/QTN/7068/1026", "client" => "UAE Embassy",
                "code" => "C0173", "amc" => 1, "addr" => "Block 321, Road 2108, Juffair, Kingdom of Bahrain",
                "contact" => "17748333", "attn" => "Admin Dept",
                "subj" => "Replacement of split AC units",
                "date" => "2026-10-14", "user" => "SKP", "user_name" => "Satish Kumar Palanimuthu", "user_designation" => "Operation Coordinator",
                "vat" => 10.0, "st" => "Pending", "remark" => "",
                "items" => [
                    ["desc" => "Supply & install 2TR split AC unit", "qty" => 3, "unit" => "Set", "price" => 410.0]
                ]
            ],
            [
                "seq" => 7069, "rev" => 0, "no" => "CG/THC/RM/QTN/7069/1026", "client" => "AK Venture",
                "code" => "C0175", "amc" => 1, "addr" => "Office 21, Bldg 5, Road 1702, Diplomatic Area, Manama",
                "contact" => "17212130", "attn" => "Operations Head",
                "subj" => "Repainting of reception area",
                "date" => "2026-10-20", "user" => "RM", "user_name" => "Reghilal Munambeth", "user_designation" => "Operation Coordinator",
                "vat" => 10.0, "st" => "Pending", "remark" => "",
                "items" => [
                    ["desc" => "Repainting of walls, two coats", "qty" => 85, "unit" => "m²", "price" => 3.2],
                    ["desc" => "Surface preparation", "qty" => 1, "unit" => "Lumpsum", "price" => 120.0]
                ]
            ],
            [
                "seq" => 7070, "rev" => 0, "no" => "CG/THC/SKP/QTN/7070/1026", "client" => "Mr. Rashid Thamer Al Dossary",
                "code" => "NA-0002", "amc" => 0, "addr" => "Villa 45, Saar, Kingdom of Bahrain",
                "contact" => "+973 3999 8888", "attn" => "Mr. Rashid",
                "subj" => "Water pump replacement – villa",
                "date" => "2026-10-02", "user" => "SKP", "user_name" => "Satish Kumar Palanimuthu", "user_designation" => "Operation Coordinator",
                "vat" => 10.0, "st" => "Approved", "remark" => "",
                "items" => [
                    ["desc" => "Supply & install booster pump", "qty" => 1, "unit" => "Lumpsum", "price" => 260.0]
                ]
            ],
            [
                "seq" => 7071, "rev" => 0, "no" => "CG/THC/MA/QTN/7071/0926", "client" => "Seef Entertainment W.L.L",
                "code" => "C0172", "amc" => 1, "addr" => "Block 428, Seef District, Kingdom of Bahrain",
                "contact" => "17000000", "attn" => "Maintenance Supervisor",
                "subj" => "Annual pest control",
                "date" => "2026-09-28", "user" => "MA", "user_name" => "Mohammed Ali", "user_designation" => "Operations Manager",
                "vat" => 10.0, "st" => "Not approved", "remark" => "Budget not approved – revisit in Q1 2027",
                "items" => [
                    ["desc" => "Monthly pest control visits", "qty" => 12, "unit" => "Month", "price" => 45.0]
                ]
            ],
            [
                "seq" => null, "rev" => 0, "no" => "", "client" => "Zayani Motors",
                "code" => "C0179", "amc" => 1, "addr" => "P.O. Box 2399, Manama, Kingdom of Bahrain",
                "contact" => "+973 3944 1015", "attn" => "Maintenance In-charge",
                "subj" => "Electrical panel inspection",
                "date" => "2026-10-27", "user" => "MA", "user_name" => "Mohammed Ali", "user_designation" => "Operations Manager",
                "vat" => 10.0, "st" => "Draft", "remark" => "",
                "items" => [
                    ["desc" => "Thermographic inspection of DB panels", "qty" => 1, "unit" => "Lumpsum", "price" => 180.0]
                ]
            ]
        ];
    }

    private function seedInitialData()
    {
        $quotes = $this->getInitialConceptQuotes();
        foreach ($quotes as $q) {
            $subtotal = 0;
            foreach ($q['items'] as $it) {
                $subtotal += ($it['qty'] * $it['price']);
            }
            $vat = ($subtotal * $q['vat']) / 100.0;
            $total = $subtotal + $vat;
            $termsJson = json_encode($this->defaultTerms);

            $seqVal = $q['seq'] !== null ? (int)$q['seq'] : "NULL";
            $revVal = (int)$q['rev'];
            $qNo = mysqli_real_escape_string($this->db, $q['no']);
            $isAmc = (int)$q['amc'];
            $cCode = mysqli_real_escape_string($this->db, $q['code']);
            $cName = mysqli_real_escape_string($this->db, $q['client']);
            $cAddr = mysqli_real_escape_string($this->db, $q['addr']);
            $cContact = mysqli_real_escape_string($this->db, $q['contact']);
            $cAttn = mysqli_real_escape_string($this->db, $q['attn']);
            $subj = mysqli_real_escape_string($this->db, $q['subj']);
            $qDate = mysqli_real_escape_string($this->db, $q['date']);
            $uCode = mysqli_real_escape_string($this->db, $q['user']);
            $uName = mysqli_real_escape_string($this->db, $q['user_name']);
            $uDesig = mysqli_real_escape_string($this->db, $q['user_designation']);
            $vatRate = (float)$q['vat'];
            $st = mysqli_real_escape_string($this->db, $q['st']);
            $rem = mysqli_real_escape_string($this->db, $q['remark']);
            $tJsonEsc = mysqli_real_escape_string($this->db, $termsJson);

            $ins = "INSERT INTO `tbl_quotations_v2` 
                (`seq_no`, `rev_no`, `quotation_no`, `is_amc`, `client_code`, `client_name`, `client_address`, 
                 `contact_no`, `attention`, `subject`, `quotation_date`, `user_code`, `user_name`, `user_designation`, 
                 `vat_rate`, `subtotal_excl_vat`, `vat_amount`, `total_incl_vat`, `terms_json`, `status`, `remark`)
                VALUES 
                ($seqVal, $revVal, '$qNo', $isAmc, '$cCode', '$cName', '$cAddr', 
                 '$cContact', '$cAttn', '$subj', '$qDate', '$uCode', '$uName', '$uDesig', 
                 $vatRate, $subtotal, $vat, $total, '$tJsonEsc', '$st', '$rem')";

            if (@mysqli_query($this->db, $ins)) {
                $qId = mysqli_insert_id($this->db);
                $order = 1;
                foreach ($q['items'] as $it) {
                    $desc = mysqli_real_escape_string($this->db, $it['desc']);
                    $qty = (float)$it['qty'];
                    $unit = mysqli_real_escape_string($this->db, $it['unit']);
                    $price = (float)$it['price'];
                    $tPrice = $qty * $price;
                    @mysqli_query($this->db, "INSERT INTO `tbl_quotation_items_v2` 
                        (`quotation_id`, `sort_order`, `description`, `quantity`, `unit`, `unit_price`, `total_price`)
                        VALUES ($qId, $order, '$desc', $qty, '$unit', $price, $tPrice)");
                    $order++;
                }
            }
        }
    }

    private function seedInitialDataJson()
    {
        $quotes = $this->getInitialConceptQuotes();
        $list = [];
        $id = 1;
        foreach ($quotes as $q) {
            $subtotal = 0;
            $items = [];
            $iId = 1;
            foreach ($q['items'] as $it) {
                $lineTotal = $it['qty'] * $it['price'];
                $subtotal += $lineTotal;
                $items[] = [
                    "item_id" => $iId++,
                    "description" => $it['desc'],
                    "quantity" => (float)$it['qty'],
                    "unit" => $it['unit'],
                    "unit_price" => (float)$it['price'],
                    "total_price" => $lineTotal
                ];
            }
            $vat = ($subtotal * $q['vat']) / 100.0;
            $list[] = [
                "id" => $id++,
                "seq_no" => $q['seq'],
                "rev_no" => $q['rev'],
                "quotation_no" => $q['no'],
                "is_amc" => $q['amc'],
                "client_code" => $q['code'],
                "client_name" => $q['client'],
                "client_address" => $q['addr'],
                "contact_no" => $q['contact'],
                "attention" => $q['attn'],
                "subject" => $q['subj'],
                "quotation_date" => $q['date'],
                "user_code" => $q['user'],
                "user_name" => $q['user_name'],
                "user_designation" => $q['user_designation'],
                "vat_rate" => (float)$q['vat'],
                "subtotal_excl_vat" => $subtotal,
                "vat_amount" => $vat,
                "total_incl_vat" => $subtotal + $vat,
                "terms" => $this->defaultTerms,
                "status" => $q['st'],
                "rejection_reason" => "",
                "remark" => $q['remark'],
                "items" => $items
            ];
        }
        $dir = dirname($this->jsonFallbackFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        file_put_contents($this->jsonFallbackFile, json_encode($list, JSON_PRETTY_PRINT));
    }

    private function getJsonQuotations()
    {
        if (!file_exists($this->jsonFallbackFile)) {
            $this->seedInitialDataJson();
        }
        $content = file_get_contents($this->jsonFallbackFile);
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    private function saveJsonQuotations(array $quotes)
    {
        $dir = dirname($this->jsonFallbackFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        file_put_contents($this->jsonFallbackFile, json_encode($quotes, JSON_PRETTY_PRINT));
    }

    private $parsedInput = null;

    private function getInputData(): array
    {
        if ($this->parsedInput !== null) {
            return $this->parsedInput;
        }

        $data = array_merge($_GET, $_POST, $_REQUEST);
        $raw = @file_get_contents('php://input');
        if (!empty($raw)) {
            $json = @json_decode($raw, true);
            if (is_array($json)) {
                $data = array_merge($data, $json);
            }
        }
        $this->parsedInput = $data;
        return $this->parsedInput;
    }

    private function getInputParam($key, $default = null)
    {
        $data = $this->getInputData();
        return isset($data[$key]) ? $data[$key] : $default;
    }

    public function handleRequest()
    {
        $data = $this->getInputData();
        $action = isset($data['action']) ? trim((string)$data['action']) : '';
        if ($action === '' && !empty($_GET['action'])) {
            $action = trim($_GET['action']);
        }

        try {
            switch ($action) {
                case 'get_initial_data':
                    $this->getInitialData();
                    break;

                case 'get_quotations':
                    $this->getQuotations();
                    break;

                case 'get_quotation':
                    $this->getQuotation();
                    break;

                case 'save_quotation':
                    $this->saveQuotation();
                    break;

                case 'update_status':
                    $this->updateStatus();
                    break;

                case 'delete_draft':
                    $this->deleteDraft();
                    break;

                case 'get_performance':
                    $this->getPerformance();
                    break;

                case 'get_units':
                    $this->getUnits();
                    break;

                case 'add_unit':
                    $this->addUnit();
                    break;

                case 'delete_unit':
                    $this->deleteUnit();
                    break;

                case 'check_grammar':
                    $this->checkGrammar();
                    break;

                case 'seed_demo_data':
                    $this->seedInitialData();
                    echo json_encode(["status" => "success", "message" => "Demo data seeded successfully"]);
                    break;

                default:
                    echo json_encode(["status" => "error", "message" => "Unknown action: " . htmlspecialchars($action)]);
                    break;
            }
        } catch (\Throwable $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    private function deriveUserInitials(string $userName, string $empCode = ''): string
    {
        $norm = strtolower(trim($userName));
        if ($norm === 'adminstrator' || $norm === 'administrator' || $norm === 'admin' || strtoupper($empCode) === 'CGTHCFM') {
            return 'ADM';
        }
        $words = preg_split('/[\s\-_]+/', trim($userName));
        $initials = '';
        foreach ($words as $w) {
            if ($w !== '') {
                $initials .= strtoupper(substr($w, 0, 1));
            }
        }
        if (strlen($initials) >= 2 && strlen($initials) <= 4) {
            return $initials;
        }
        return !empty($initials) ? $initials : 'ADM';
    }

    private function getCurrentSessionUser()
    {
        $userCode = "MA";
        $userName = "Mohammed Ali";
        $userTitle = "Operations Manager";
        $userId = 1;

        if (!empty($_SESSION['username'])) {
            $empCode = $_SESSION['username'];
            $userName = !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['username'];
            if (strtolower(trim($userName)) === 'adminstrator') {
                $userName = 'Administrator';
            }
            $userCode = $this->deriveUserInitials($userName, $empCode);
            $userTitle = !empty($_SESSION['user_type']) ? $_SESSION['user_type'] : "Operations Manager";
            $userId = !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1;
        }

        return [
            "code" => $userCode,
            "name" => $userName,
            "title" => $userTitle,
            "id" => $userId
        ];
    }

    private function getInitialData()
    {
        $curUser = $this->getCurrentSessionUser();

        // 1. Fetch AMC Customers
        $amcClients = [];
        if ($this->isDbConnected) {
            $cRes = @mysqli_query($this->db, "SELECT customer_id, customer_code, customer_name, customer_address, customer_contact_no FROM tbl_customers WHERE customer_status='Active' ORDER BY customer_name ASC");
            if ($cRes && mysqli_num_rows($cRes) > 0) {
                while ($c = mysqli_fetch_assoc($cRes)) {
                    $code = !empty($c['customer_code']) && $c['customer_code'] !== 'NA' ? $c['customer_code'] : 'C' . str_pad($c['customer_id'], 4, '0', STR_PAD_LEFT);
                    $amcClients[] = [
                        "code" => $code,
                        "name" => $c['customer_name'],
                        "address" => !empty($c['customer_address']) && $c['customer_address'] !== 'NA' ? $c['customer_address'] : "M/S " . $c['customer_name'] . ", Kingdom of Bahrain",
                        "contact" => !empty($c['customer_contact_no']) && $c['customer_contact_no'] !== 'NA' ? $c['customer_contact_no'] : ""
                    ];
                }
            }
        }
        if (empty($amcClients)) {
            $amcClients = $this->defaultAmcClients;
        }

        // 2. Fetch Users / Estimators (strictly users with Quotation permissions: Administrator, Operation Manager, Operation Coordinator)
        $users = [];
        if ($this->isDbConnected) {
            $uSql = "SELECT DISTINCT e.employee_id, e.employee_code, e.employee_name, e.employee_type_name 
                     FROM tbl_employees e 
                     WHERE e.employee_status='Active' 
                     AND (
                         LOWER(TRIM(e.employee_type_name)) IN (
                             'administrator', 
                             'operation manager', 
                             'operations manager', 
                             'operations manager (maintenance)', 
                             'operation coordinator', 
                             'operations coordinator'
                         )
                         OR e.employee_type_name LIKE 'Operation%Manager%'
                         OR e.employee_type_name LIKE 'Operation%Coordinator%'
                         OR EXISTS (
                             SELECT 1 FROM users u
                             INNER JOIN user_roles_v1 ur ON ur.user_id = u.id
                             INNER JOIN role_permissions_v1 rp ON rp.role_id = ur.role_id
                             WHERE u.username = e.employee_code AND rp.sub_module_name = 'Quotation'
                         )
                     )
                     ORDER BY e.employee_name ASC";
            $uRes = @mysqli_query($this->db, $uSql);
            if ($uRes && mysqli_num_rows($uRes) > 0) {
                while ($u = mysqli_fetch_assoc($uRes)) {
                    $initials = $this->deriveUserInitials($u['employee_name'], $u['employee_code'] ?? '');
                    $cleanName = (strtolower(trim($u['employee_name'])) === 'adminstrator') ? 'Administrator' : $u['employee_name'];
                    $title = $u['employee_type_name'] ?? '';
                    if (stripos($title, 'Operations Manager') !== false || stripos($title, 'Operation Manager') !== false) {
                        $title = 'Operations Manager';
                    } elseif (stripos($title, 'Coordinator') !== false) {
                        $title = 'Operation Coordinator';
                    } elseif (stripos($title, 'Admin') !== false) {
                        $title = 'Administrator';
                    } elseif (empty($title) || $title === 'NA') {
                        $title = 'Estimator';
                    }
                    $users[$initials] = [
                        "name" => $cleanName,
                        "title" => $title
                    ];
                }
            }
        }
        if (empty($users)) {
            $users = $this->defaultUsers;
        }

        // Ensure current session user is in user list
        if (!isset($users[$curUser['code']])) {
            $users[$curUser['code']] = [
                "name" => $curUser['name'],
                "title" => $curUser['title']
            ];
        }

        // 3. Fetch Quotations
        $quotations = $this->fetchQuotationsList();

        echo json_encode([
            "status" => "success",
            "current_user" => $curUser,
            "users" => $users,
            "amc_clients" => $amcClients,
            "default_terms" => $this->defaultTerms,
            "library_terms" => $this->libraryTerms,
            "rejection_reasons" => $this->rejectionReasons,
            "units" => $this->fetchUnitsList(),
            "quotations" => $quotations
        ]);
    }

    private function fetchQuotationsList()
    {
        if ($this->isDbConnected) {
            $list = [];
            $qRes = @mysqli_query($this->db, "SELECT * FROM tbl_quotations_v2 ORDER BY id DESC");
            if ($qRes) {
                $itemsByQuote = [];
                $iRes = @mysqli_query($this->db, "SELECT * FROM tbl_quotation_items_v2 ORDER BY quotation_id ASC, sort_order ASC, item_id ASC");
                if ($iRes) {
                    while ($it = mysqli_fetch_assoc($iRes)) {
                        $qId = (int)$it['quotation_id'];
                        $itemsByQuote[$qId][] = [
                            "item_id" => (int)$it['item_id'],
                            "description" => $it['description'],
                            "quantity" => (float)$it['quantity'],
                            "unit" => $it['unit'],
                            "unit_price" => (float)$it['unit_price'],
                            "total_price" => (float)$it['total_price']
                        ];
                    }
                }

                while ($r = mysqli_fetch_assoc($qRes)) {
                    $qId = (int)$r['id'];
                    $terms = json_decode($r['terms_json'] ?? '', true);
                    if (!is_array($terms)) $terms = $this->defaultTerms;
                    $items = $itemsByQuote[$qId] ?? [];

                    $list[] = [
                        "id" => (int)$r['id'],
                        "seq_no" => $r['seq_no'] !== null ? (int)$r['seq_no'] : null,
                        "rev_no" => (int)$r['rev_no'],
                        "quotation_no" => $r['quotation_no'],
                        "is_amc" => (int)$r['is_amc'],
                        "client_code" => $r['client_code'],
                        "client_name" => $r['client_name'],
                        "client_address" => $r['client_address'],
                        "contact_no" => $r['contact_no'],
                        "attention" => $r['attention'],
                        "subject" => $r['subject'],
                        "quotation_date" => $r['quotation_date'],
                        "user_code" => $r['user_code'],
                        "user_name" => $r['user_name'],
                        "user_designation" => $r['user_designation'],
                        "vat_rate" => (float)$r['vat_rate'],
                        "discount_type" => isset($r['discount_type']) ? $r['discount_type'] : 'amount',
                        "discount_value" => isset($r['discount_value']) ? (float)$r['discount_value'] : 0.0,
                        "discount_amount" => isset($r['discount_amount']) ? (float)$r['discount_amount'] : 0.0,
                        "subtotal_excl_vat" => (float)$r['subtotal_excl_vat'],
                        "vat_amount" => (float)$r['vat_amount'],
                        "total_incl_vat" => (float)$r['total_incl_vat'],
                        "terms" => $terms,
                        "status" => $r['status'],
                        "rejection_reason" => $r['rejection_reason'],
                        "remark" => $r['remark'],
                        "items" => $items
                    ];
                }
            }
            return $list;
        }

        return $this->getJsonQuotations();
    }

    public function fetchUnitsList(): array
    {
        if ($this->isDbConnected) {
            $units = [];
            $res = @mysqli_query($this->db, "SELECT id, unit_name FROM tbl_quotation_units_master ORDER BY sort_order ASC, unit_name ASC");
            if ($res && mysqli_num_rows($res) > 0) {
                while ($r = mysqli_fetch_assoc($res)) {
                    $units[] = [
                        "id" => (int)$r['id'],
                        "name" => $r['unit_name']
                    ];
                }
                return $units;
            }
        }

        // Fallback or JSON fallback
        if (file_exists($this->unitsFallbackFile)) {
            $json = @json_decode(file_get_contents($this->unitsFallbackFile), true);
            if (is_array($json) && !empty($json)) {
                return $json;
            }
        }

        $units = [];
        $id = 1;
        foreach ($this->defaultUnits as $u) {
            $units[] = ["id" => $id++, "name" => $u];
        }
        return $units;
    }

    private function getUnits()
    {
        $units = $this->fetchUnitsList();
        echo json_encode([
            "status" => "success",
            "units" => $units
        ]);
    }

    private function addUnit()
    {
        $data = $this->getInputData();
        $unitName = trim($data['unit_name'] ?? '');
        if ($unitName === '') {
            echo json_encode(["status" => "error", "message" => "Unit name cannot be empty."]);
            return;
        }
        if (mb_strlen($unitName) > 50) {
            echo json_encode(["status" => "error", "message" => "Unit name cannot exceed 50 characters."]);
            return;
        }

        if ($this->isDbConnected) {
            $escName = mysqli_real_escape_string($this->db, $unitName);
            $checkRes = @mysqli_query($this->db, "SELECT id, unit_name FROM tbl_quotation_units_master WHERE LOWER(unit_name) = LOWER('$escName')");
            if ($checkRes && mysqli_num_rows($checkRes) > 0) {
                echo json_encode(["status" => "error", "message" => "Unit '$unitName' already exists in the master."]);
                return;
            }

            $maxRes = @mysqli_query($this->db, "SELECT MAX(sort_order) as max_sort FROM tbl_quotation_units_master");
            $maxRow = $maxRes ? mysqli_fetch_assoc($maxRes) : null;
            $newSort = ($maxRow && isset($maxRow['max_sort'])) ? (int)$maxRow['max_sort'] + 1 : 1;

            $insertSql = "INSERT INTO tbl_quotation_units_master (unit_name, sort_order) VALUES ('$escName', $newSort)";
            if (@mysqli_query($this->db, $insertSql)) {
                $newId = (int)mysqli_insert_id($this->db);
                $units = $this->fetchUnitsList();
                echo json_encode([
                    "status" => "success",
                    "message" => "Unit '$unitName' added successfully.",
                    "unit" => ["id" => $newId, "name" => $unitName],
                    "units" => $units
                ]);
                return;
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($this->db)]);
                return;
            }
        }

        // Fallback JSON handling
        $units = $this->fetchUnitsList();
        foreach ($units as $u) {
            if (strcasecmp($u['name'], $unitName) === 0) {
                echo json_encode(["status" => "error", "message" => "Unit '$unitName' already exists."]);
                return;
            }
        }
        $maxId = 0;
        foreach ($units as $u) {
            if ($u['id'] > $maxId) $maxId = $u['id'];
        }
        $newUnit = ["id" => $maxId + 1, "name" => $unitName];
        $units[] = $newUnit;
        $this->saveUnitsToJson($units);

        echo json_encode([
            "status" => "success",
            "message" => "Unit '$unitName' added successfully.",
            "unit" => $newUnit,
            "units" => $units
        ]);
    }

    private function deleteUnit()
    {
        $data = $this->getInputData();
        $id = !empty($data['id']) ? (int)$data['id'] : 0;
        $unitName = trim($data['unit_name'] ?? '');

        if ($id <= 0 && $unitName === '') {
            echo json_encode(["status" => "error", "message" => "Unit ID or name required to delete."]);
            return;
        }

        if ($this->isDbConnected) {
            $whereClause = "";
            if ($id > 0) {
                $whereClause = "id = $id";
            } else {
                $escName = mysqli_real_escape_string($this->db, $unitName);
                $whereClause = "LOWER(unit_name) = LOWER('$escName')";
            }

            $selRes = @mysqli_query($this->db, "SELECT id, unit_name FROM tbl_quotation_units_master WHERE $whereClause LIMIT 1");
            $target = $selRes ? mysqli_fetch_assoc($selRes) : null;
            if (!$target) {
                echo json_encode(["status" => "error", "message" => "Unit not found in master."]);
                return;
            }

            $deletedName = $target['unit_name'];
            $targetId = (int)$target['id'];

            @mysqli_query($this->db, "DELETE FROM tbl_quotation_units_master WHERE id = $targetId");
            $units = $this->fetchUnitsList();

            echo json_encode([
                "status" => "success",
                "message" => "Unit '$deletedName' deleted successfully.",
                "units" => $units
            ]);
            return;
        }

        // Fallback JSON handling
        $units = $this->fetchUnitsList();
        $filtered = [];
        $deletedName = "";
        foreach ($units as $u) {
            if (($id > 0 && $u['id'] === $id) || ($unitName !== '' && strcasecmp($u['name'], $unitName) === 0)) {
                $deletedName = $u['name'];
                continue;
            }
            $filtered[] = $u;
        }

        if ($deletedName === '') {
            echo json_encode(["status" => "error", "message" => "Unit not found."]);
            return;
        }

        $this->saveUnitsToJson($filtered);
        echo json_encode([
            "status" => "success",
            "message" => "Unit '$deletedName' deleted successfully.",
            "units" => $filtered
        ]);
    }

    private function saveUnitsToJson(array $units)
    {
        $dir = dirname($this->unitsFallbackFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @file_put_contents($this->unitsFallbackFile, json_encode($units, JSON_PRETTY_PRINT));
    }

    private function getQuotations()
    {
        $quotations = $this->fetchQuotationsList();
        echo json_encode(["status" => "success", "quotations" => $quotations]);
    }

    private function getQuotation()
    {
        $id = (int)$this->getInputParam('id', 0);
        $quotes = $this->fetchQuotationsList();
        $target = null;
        $revisions = [];

        foreach ($quotes as $q) {
            if ($q['id'] === $id) {
                $target = $q;
                break;
            }
        }

        if (!$target) {
            echo json_encode(["status" => "error", "message" => "Quotation not found"]);
            return;
        }

        if ($target['seq_no'] !== null) {
            foreach ($quotes as $q) {
                if ($q['seq_no'] === $target['seq_no']) {
                    $revisions[] = $q;
                }
            }
            usort($revisions, function ($a, $b) {
                return $a['rev_no'] - $b['rev_no'];
            });
        }

        echo json_encode([
            "status" => "success",
            "quotation" => $target,
            "revisions" => $revisions
        ]);
    }

    private function saveQuotation()
    {
        $input = $this->getInputData();

        $id = isset($input['id']) ? (int)$input['id'] : 0;
        $isIssue = !empty($input['is_issue']);
        $isAmc = isset($input['is_amc']) ? (int)$input['is_amc'] : 1;
        $clientName = trim($input['client_name'] ?? '');
        $clientCode = trim($input['client_code'] ?? '');
        $clientAddress = trim($input['client_address'] ?? '');
        $contactNo = trim($input['contact_no'] ?? '');
        $attention = trim($input['attention'] ?? '');
        $subject = trim($input['subject'] ?? '');
        $quotationDate = trim($input['quotation_date'] ?? date('Y-m-d'));
        $userCode = trim($input['user_code'] ?? 'MA');
        $userName = trim($input['user_name'] ?? 'Mohammed Ali');
        $userDesignation = trim($input['user_designation'] ?? 'Operations Manager');
        $vatRate = isset($input['vat_rate']) ? (float)$input['vat_rate'] : 10.0;
        $terms = isset($input['terms']) && is_array($input['terms']) ? $input['terms'] : $this->defaultTerms;
        $items = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];
        $seqNo = isset($input['seq_no']) && $input['seq_no'] !== '' ? (int)$input['seq_no'] : null;
        $revNo = isset($input['rev_no']) ? (int)$input['rev_no'] : 0;

        // Validation
        if (empty($clientName)) {
            echo json_encode(["status" => "error", "message" => $isAmc ? "Select an AMC client" : "Enter client name"]);
            return;
        }
        if ($isIssue && empty($subject)) {
            echo json_encode(["status" => "error", "message" => "Subject is required to issue quotation"]);
            return;
        }
        if ($isIssue && empty($items)) {
            echo json_encode(["status" => "error", "message" => "At least one item is required"]);
            return;
        }

        // Calculate line items total
        $subtotal = 0;
        $cleanItems = [];
        foreach ($items as $it) {
            $desc = trim($it['description'] ?? ($it[0] ?? ''));
            $qty = (float)($it['quantity'] ?? ($it[1] ?? 1));
            $unit = trim($it['unit'] ?? ($it[2] ?? 'Lumpsum'));
            $price = (float)($it['unit_price'] ?? ($it[3] ?? 0));
            $lineTotal = $qty * $price;
            $subtotal += $lineTotal;

            $cleanItems[] = [
                "description" => $desc,
                "quantity" => $qty,
                "unit" => $unit,
                "unit_price" => $price,
                "total_price" => $lineTotal
            ];
        }

        $discountType = isset($input['discount_type']) && $input['discount_type'] === 'percent' ? 'percent' : 'amount';
        $discountValue = isset($input['discount_value']) ? max(0, (float)$input['discount_value']) : (isset($input['discount']) ? max(0, (float)$input['discount']) : 0.0);
        $discountAmount = isset($input['discount_amount']) ? max(0, (float)$input['discount_amount']) : 0.0;

        if ($discountAmount <= 0 && $discountValue > 0) {
            if ($discountType === 'percent') {
                $discountAmount = ($subtotal * $discountValue) / 100.0;
            } else {
                $discountAmount = $discountValue;
            }
        }
        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        $netSubtotal = max(0, $subtotal - $discountAmount);
        $vatAmount = ($netSubtotal * $vatRate) / 100.0;
        $totalInclVat = $netSubtotal + $vatAmount;

        // Quotation Number & Status Logic
        $status = $isIssue ? 'Pending' : 'Draft';
        $quotationNo = '';

        if ($this->isDbConnected) {
            if ($isIssue) {
                if ($seqNo === null) {
                    $maxRes = mysqli_query($this->db, "SELECT MAX(seq_no) as max_seq FROM tbl_quotations_v2");
                    $mRow = mysqli_fetch_assoc($maxRes);
                    $seqNo = !empty($mRow['max_seq']) ? ((int)$mRow['max_seq'] + 1) : 7073;
                }
                if (empty($clientCode) && !$isAmc) {
                    $cntRes = mysqli_query($this->db, "SELECT COUNT(*) as na_cnt FROM tbl_quotations_v2 WHERE is_amc = 0");
                    $naRow = mysqli_fetch_assoc($cntRes);
                    $clientCode = "NA-" . str_pad(((int)$naRow['na_cnt'] + 1), 4, "0", STR_PAD_LEFT);
                }

                $mmyy = date('my', strtotime($quotationDate));
                $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}";

                // Supersede older revisions of this quotation sequence
                if ($revNo > 0) {
                    $supSql = "UPDATE tbl_quotations_v2 SET status='Superseded' WHERE seq_no={$seqNo} AND rev_no < {$revNo}";
                    mysqli_query($this->db, $supSql);
                }
            } else {
                if ($seqNo !== null) {
                    $mmyy = date('my', strtotime($quotationDate));
                    $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}";
                }
            }

            $termsJson = mysqli_real_escape_string($this->db, json_encode($terms));
            $escClientName = mysqli_real_escape_string($this->db, $clientName);
            $escClientCode = mysqli_real_escape_string($this->db, $clientCode);
            $escClientAddress = mysqli_real_escape_string($this->db, $clientAddress);
            $escContact = mysqli_real_escape_string($this->db, $contactNo);
            $escAttn = mysqli_real_escape_string($this->db, $attention);
            $escSubj = mysqli_real_escape_string($this->db, $subject);
            $escDate = mysqli_real_escape_string($this->db, $quotationDate);
            $escUserCode = mysqli_real_escape_string($this->db, $userCode);
            $escUserName = mysqli_real_escape_string($this->db, $userName);
            $escUserDesig = mysqli_real_escape_string($this->db, $userDesignation);
            $escQNo = mysqli_real_escape_string($this->db, $quotationNo);
            $seqVal = $seqNo !== null ? (int)$seqNo : "NULL";

            if ($id > 0) {
                $upd = "UPDATE tbl_quotations_v2 SET 
                    seq_no = $seqVal,
                    rev_no = $revNo,
                    quotation_no = '$escQNo',
                    is_amc = $isAmc,
                    client_code = '$escClientCode',
                    client_name = '$escClientName',
                    client_address = '$escClientAddress',
                    contact_no = '$escContact',
                    attention = '$escAttn',
                    subject = '$escSubj',
                    quotation_date = '$escDate',
                    user_code = '$escUserCode',
                    user_name = '$escUserName',
                    user_designation = '$escUserDesig',
                    vat_rate = $vatRate,
                    discount_type = '$discountType',
                    discount_value = $discountValue,
                    discount_amount = $discountAmount,
                    subtotal_excl_vat = $subtotal,
                    vat_amount = $vatAmount,
                    total_incl_vat = $totalInclVat,
                    terms_json = '$termsJson',
                    status = '$status'
                    WHERE id = $id";
                mysqli_query($this->db, $upd);
                mysqli_query($this->db, "DELETE FROM tbl_quotation_items_v2 WHERE quotation_id = $id");
                $savedId = $id;
            } else {
                $ins = "INSERT INTO tbl_quotations_v2 
                    (seq_no, rev_no, quotation_no, is_amc, client_code, client_name, client_address,
                     contact_no, attention, subject, quotation_date, user_code, user_name, user_designation,
                     vat_rate, discount_type, discount_value, discount_amount, subtotal_excl_vat, vat_amount, total_incl_vat, terms_json, status)
                    VALUES 
                    ($seqVal, $revNo, '$escQNo', $isAmc, '$escClientCode', '$escClientName', '$escClientAddress',
                     '$escContact', '$escAttn', '$escSubj', '$escDate', '$escUserCode', '$escUserName', '$escUserDesig',
                     $vatRate, '$discountType', $discountValue, $discountAmount, $subtotal, $vatAmount, $totalInclVat, '$termsJson', '$status')";
                mysqli_query($this->db, $ins);
                $savedId = mysqli_insert_id($this->db);
            }

            // Insert Items
            $sort = 1;
            foreach ($cleanItems as $it) {
                $desc = mysqli_real_escape_string($this->db, $it['description']);
                $qty = (float)$it['quantity'];
                $unit = mysqli_real_escape_string($this->db, $it['unit']);
                $price = (float)$it['unit_price'];
                $tot = (float)$it['total_price'];
                mysqli_query($this->db, "INSERT INTO tbl_quotation_items_v2 
                    (quotation_id, sort_order, description, quantity, unit, unit_price, total_price)
                    VALUES ($savedId, $sort, '$desc', $qty, '$unit', $price, $tot)");
                $sort++;
            }
        } else {
            // JSON fallback persistence
            $quotes = $this->getJsonQuotations();

            if ($isIssue) {
                if ($seqNo === null) {
                    $maxSeq = 7072;
                    foreach ($quotes as $q) {
                        if (!empty($q['seq_no']) && $q['seq_no'] > $maxSeq) {
                            $maxSeq = (int)$q['seq_no'];
                        }
                    }
                    $seqNo = $maxSeq + 1;
                }
                if (empty($clientCode) && !$isAmc) {
                    $naCount = 0;
                    foreach ($quotes as $q) {
                        if (empty($q['is_amc'])) $naCount++;
                    }
                    $clientCode = "NA-" . str_pad($naCount + 1, 4, "0", STR_PAD_LEFT);
                }
                $mmyy = date('my', strtotime($quotationDate));
                $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}";

                if ($revNo > 0) {
                    foreach ($quotes as &$q) {
                        if (!empty($q['seq_no']) && $q['seq_no'] === $seqNo && $q['rev_no'] < $revNo) {
                            $q['status'] = 'Superseded';
                        }
                    }
                    unset($q);
                }
            } else {
                if ($seqNo !== null) {
                    $mmyy = date('my', strtotime($quotationDate));
                    $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}";
                }
            }

            $quoteObj = [
                "id" => $id > 0 ? $id : (time() . rand(10, 99)),
                "seq_no" => $seqNo,
                "rev_no" => $revNo,
                "quotation_no" => $quotationNo,
                "is_amc" => $isAmc,
                "client_code" => $clientCode,
                "client_name" => $clientName,
                "client_address" => $clientAddress,
                "contact_no" => $contactNo,
                "attention" => $attention,
                "subject" => $subject,
                "quotation_date" => $quotationDate,
                "user_code" => $userCode,
                "user_name" => $userName,
                "user_designation" => $userDesignation,
                "vat_rate" => $vatRate,
                "discount_type" => $discountType,
                "discount_value" => $discountValue,
                "discount_amount" => $discountAmount,
                "subtotal_excl_vat" => $subtotal,
                "vat_amount" => $vatAmount,
                "total_incl_vat" => $totalInclVat,
                "terms" => $terms,
                "status" => $status,
                "rejection_reason" => "",
                "remark" => "",
                "items" => $cleanItems
            ];

            if ($id > 0) {
                $found = false;
                foreach ($quotes as &$q) {
                    if ($q['id'] == $id) {
                        $q = $quoteObj;
                        $found = true;
                        break;
                    }
                }
                unset($q);
                if (!$found) $quotes[] = $quoteObj;
                $savedId = $id;
            } else {
                $quotes[] = $quoteObj;
                $savedId = $quoteObj['id'];
            }

            $this->saveJsonQuotations($quotes);
        }

        echo json_encode([
            "status" => "success",
            "message" => $isIssue ? "Quotation {$quotationNo} issued successfully" : "Draft saved successfully",
            "id" => $savedId,
            "quotation_no" => $quotationNo,
            "is_issued" => $isIssue
        ]);
    }

    private function updateStatus()
    {
        $id = (int)$this->getInputParam('id', 0);
        $status = trim((string)$this->getInputParam('status', ''));
        $reason = trim((string)$this->getInputParam('reason', ''));
        $remark = trim((string)$this->getInputParam('remark', ''));

        // Normalize status
        $stLower = strtolower($status);
        if ($stLower === 'approved') {
            $status = 'Approved';
        } elseif ($stLower === 'not approved' || $stLower === 'rejected' || $stLower === 'notapproved') {
            $status = 'Not approved';
        } elseif ($stLower === 'pending') {
            $status = 'Pending';
        } elseif ($stLower === 'draft') {
            $status = 'Draft';
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid status" . ($status !== '' ? ": " . htmlspecialchars($status) : '')]);
            return;
        }

        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid quotation ID"]);
            return;
        }

        if ($status === 'Not approved' && empty($reason)) {
            echo json_encode(["status" => "error", "message" => "A reason is required when marking not approved"]);
            return;
        }

        $fullRemark = $status === 'Not approved' ? ($reason . ($remark ? " – " . $remark : "")) : $remark;

        if ($this->isDbConnected) {
            $escSt = mysqli_real_escape_string($this->db, $status);
            $escReason = mysqli_real_escape_string($this->db, $reason);
            $escRem = mysqli_real_escape_string($this->db, $fullRemark);
            $sql = "UPDATE tbl_quotations_v2 SET 
                status = '$escSt',
                rejection_reason = '$escReason',
                remark = '$escRem'
                WHERE id = $id";
            $res = mysqli_query($this->db, $sql);
            if (!$res) {
                echo json_encode(["status" => "error", "message" => "Database update failed: " . mysqli_error($this->db)]);
                return;
            }
        } else {
            $quotes = $this->getJsonQuotations();
            foreach ($quotes as &$q) {
                if ($q['id'] == $id) {
                    $q['status'] = $status;
                    $q['rejection_reason'] = $reason;
                    $q['remark'] = $fullRemark;
                    break;
                }
            }
            unset($q);
            $this->saveJsonQuotations($quotes);
        }

        echo json_encode([
            "status" => "success",
            "message" => "Quotation marked as " . $status,
            "id" => $id,
            "new_status" => $status,
            "remark" => $fullRemark
        ]);
    }

    private function deleteDraft()
    {
        $id = (int)$this->getInputParam('id', 0);
        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid draft ID"]);
            return;
        }
        if ($this->isDbConnected) {
            mysqli_query($this->db, "DELETE FROM tbl_quotation_items_v2 WHERE quotation_id = $id");
            mysqli_query($this->db, "DELETE FROM tbl_quotations_v2 WHERE id = $id AND status = 'Draft'");
        } else {
            $quotes = $this->getJsonQuotations();
            $quotes = array_filter($quotes, function ($q) use ($id) {
                return !($q['id'] == $id && $q['status'] === 'Draft');
            });
            $this->saveJsonQuotations(array_values($quotes));
        }

        echo json_encode(["status" => "success", "message" => "Draft deleted"]);
    }

    private function getPerformance()
    {
        $quotes = $this->fetchQuotationsList();
        $curUser = $this->getCurrentSessionUser();

        $users = [];
        foreach ($quotes as $q) {
            $u = $q['user_code'];
            if (!isset($users[$u])) {
                $users[$u] = [
                    "code" => $u,
                    "name" => $q['user_name'],
                    "title" => $q['user_designation'],
                    "sent" => 0,
                    "approved" => 0,
                    "not_approved" => 0,
                    "pending" => 0,
                    "sent_excl_vat" => 0.0,
                    "sent_incl_vat" => 0.0,
                    "approved_incl_vat" => 0.0
                ];
            }

            if (in_array($q['status'], ['Pending', 'Approved', 'Not approved'])) {
                $users[$u]['sent']++;
                $sentExcl = max(0, (float)$q['subtotal_excl_vat'] - (float)($q['discount_amount'] ?? 0));
                $users[$u]['sent_excl_vat'] += $sentExcl;
                $users[$u]['sent_incl_vat'] += (float)$q['total_incl_vat'];

                if ($q['status'] === 'Approved') {
                    $users[$u]['approved']++;
                    $users[$u]['approved_incl_vat'] += (float)$q['total_incl_vat'];
                } elseif ($q['status'] === 'Not approved') {
                    $users[$u]['not_approved']++;
                } elseif ($q['status'] === 'Pending') {
                    $users[$u]['pending']++;
                }
            }
        }

        echo json_encode([
            "status" => "success",
            "current_user" => $curUser,
            "team" => array_values($users)
        ]);
    }

    private function checkGrammar()
    {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true) ?: [];
        $text = isset($data['text']) ? trim((string)$data['text']) : '';
        $language = isset($data['language']) ? trim((string)$data['language']) : 'en-US';

        if ($text === '') {
            echo json_encode([
                "status" => "success",
                "matches" => []
            ]);
            return;
        }

        $apiUrl = 'https://api.languagetool.org/v2/check';
        $postData = http_build_query([
            'text' => $text,
            'language' => $language
        ]);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 12);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'THCFM-Quotation-Module/1.0');

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            echo json_encode([
                "status" => "error",
                "message" => "Grammar check service temporarily unavailable" . ($curlError ? ": " . $curlError : ""),
                "matches" => []
            ]);
            return;
        }

        $result = json_decode($response, true);
        echo json_encode([
            "status" => "success",
            "matches" => isset($result['matches']) && is_array($result['matches']) ? $result['matches'] : []
        ]);
    }
}
}

$controller = new QuotationModuleController();
$controller->handleRequest();
