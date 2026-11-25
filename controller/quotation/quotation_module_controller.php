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
        "ADM" => ["name" => "Administrator", "title" => "Administrator", "phone" => "+973 17 100 190"],
        "MA" => ["name" => "Mohammed Ali", "title" => "Operations Manager", "phone" => "+973 3944 1015"],
        "RM" => ["name" => "Reghilal Munambeth", "title" => "Operation Coordinator", "phone" => "+973 3728 3293"],
        "SKP" => ["name" => "Satish Kumar Palanimuthu", "title" => "Operation Coordinator", "phone" => "+973 3689 8333"]
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

    private $footerConfigFile;
    private $defaultFooterConfig = [
        'phone' => '+973 17 100 190',
        'email' => 'info@thc.com.bh',
        'website' => 'www.thc.com.bh',
        'cr_no' => '88982-1',
        'address_line1' => 'Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317',
        'address_line2' => 'YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain',
        'bg_color' => '#1e2560',
        'show_badges' => 1,
        'badges_image' => 'global_assets/images/a.png',
        'show_page_no' => 1,
        'show_ref_no' => 1,
        'doc_number' => 'CINQO/THC/QTN/01/2020/REV3'
    ];

    private $stampSignConfigFile;
    private $defaultStampSignConfig = [
        'show_stamp' => 1,
        'show_signature' => 1,
        'show_user_phone' => 1,
        'company_stamp_url' => 'uploads/quotation_signatures/default_thc_stamp.png',
        'default_signature_url' => 'uploads/quotation_signatures/default_signature.png',
        'user_signatures' => [],
        'user_phones' => []
    ];

    public function __construct()
    {
        @date_default_timezone_set('Asia/Bahrain');
        $this->jsonFallbackFile = __DIR__ . '/../../scratch/quotations_data.json';
        $this->unitsFallbackFile = __DIR__ . '/../../scratch/quotation_units.json';
        $this->footerConfigFile = __DIR__ . '/../../scratch/quotation_footer_config.json';
        $this->stampSignConfigFile = __DIR__ . '/../../scratch/quotation_stamp_sign_config.json';
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
                `status` ENUM('Draft','Pending','Pending approval','Approved','Not approved','Superseded','Void','Completed','Expired') NOT NULL DEFAULT 'Draft',
                `is_autosaved` TINYINT(1) NOT NULL DEFAULT 0,
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

            // Migration check: Add variation_no column if missing
            $chkVar = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'variation_no'");
            if ($chkVar && mysqli_num_rows($chkVar) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `variation_no` INT(11) NOT NULL DEFAULT 0 AFTER `rev_no`");
            }

            // Migration check: Update status enum to include 'Pending approval', 'Void', 'Completed', 'Expired'
            $chkStatus = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'status'");
            if ($chkStatus && ($col = mysqli_fetch_assoc($chkStatus))) {
                if (strpos($col['Type'], 'Pending approval') === false || strpos($col['Type'], 'Completed') === false || strpos($col['Type'], 'Expired') === false || strpos($col['Type'], 'Void') === false) {
                    @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` MODIFY COLUMN `status` ENUM('Draft','Pending','Pending approval','Approved','Not approved','Superseded','Void','Completed','Expired') NOT NULL DEFAULT 'Draft'");
                    @mysqli_query($this->db, "UPDATE `tbl_quotations_v2` SET `status` = 'Pending approval' WHERE `status` = 'Pending'");
                }
            }

            // Migration check: Add approval fields if missing
            $chkAppr = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'approval_by'");
            if ($chkAppr && mysqli_num_rows($chkAppr) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `approval_by` VARCHAR(255) DEFAULT '' AFTER `status`,
                    ADD COLUMN `approval_date` DATE DEFAULT NULL AFTER `approval_by`,
                    ADD COLUMN `client_po_ref` VARCHAR(100) DEFAULT '' AFTER `approval_date`,
                    ADD COLUMN `approval_attachment` VARCHAR(500) DEFAULT '' AFTER `client_po_ref`");
            } else {
                $chkApprAtt = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'approval_attachment'");
                if ($chkApprAtt && mysqli_num_rows($chkApprAtt) == 0) {
                    @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `approval_attachment` VARCHAR(500) DEFAULT '' AFTER `client_po_ref`");
                }
            }

            // Migration check: Add completion fields if missing
            $chkComp = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'completion_date'");
            if ($chkComp && mysqli_num_rows($chkComp) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `completion_date` DATETIME DEFAULT NULL AFTER `approval_date`,
                    ADD COLUMN `completion_by` VARCHAR(255) DEFAULT '' AFTER `completion_date`,
                    ADD COLUMN `completion_notes` TEXT DEFAULT NULL AFTER `completion_by`,
                    ADD COLUMN `completion_attachment` VARCHAR(500) DEFAULT '' AFTER `completion_notes`");
            }

            // Migration check: Add validity_days and revival fields if missing
            $chkVal = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'validity_days'");
            if ($chkVal && mysqli_num_rows($chkVal) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `validity_days` INT(11) NOT NULL DEFAULT 30 AFTER `quotation_date`,
                    ADD COLUMN `revived_at` DATETIME DEFAULT NULL AFTER `validity_days`,
                    ADD COLUMN `revived_by` VARCHAR(255) DEFAULT '' AFTER `revived_at`");
            }

            // Migration check: Add activity_json column if missing
            $chkAct = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'activity_json'");
            if ($chkAct && mysqli_num_rows($chkAct) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `activity_json` LONGTEXT DEFAULT NULL AFTER `remark`");
            }

            // Migration check: Add internal_notes column if missing
            $chkNotes = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'internal_notes'");
            if ($chkNotes && mysqli_num_rows($chkNotes) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `internal_notes` TEXT DEFAULT NULL AFTER `remark`");
            }

            // Migration check: Add merge_items, merge_qty, merged_lump_sum_price columns if missing
            $chkMerge = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'merge_items'");
            if ($chkMerge && mysqli_num_rows($chkMerge) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `merge_items` TINYINT(1) NOT NULL DEFAULT 0 AFTER `discount_amount`,
                    ADD COLUMN `merge_qty` TINYINT(1) NOT NULL DEFAULT 0 AFTER `merge_items`,
                    ADD COLUMN `merged_lump_sum_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `merge_qty`");
            }

            // Migration check: Add bullet_items column if missing
            $chkBullet = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'bullet_items'");
            if ($chkBullet && mysqli_num_rows($chkBullet) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `bullet_items` TINYINT(1) NOT NULL DEFAULT 0 AFTER `merged_lump_sum_price`");
            }

            // Migration check: Add user_phone and include_user_phone columns if missing
            $chkPhone = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'user_phone'");
            if ($chkPhone && mysqli_num_rows($chkPhone) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` 
                    ADD COLUMN `user_phone` VARCHAR(50) DEFAULT '' AFTER `user_designation`,
                    ADD COLUMN `include_user_phone` TINYINT(1) NOT NULL DEFAULT 1 AFTER `user_phone`");
            } else {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ALTER COLUMN `include_user_phone` SET DEFAULT 1");
                @mysqli_query($this->db, "UPDATE `tbl_quotations_v2` SET `include_user_phone` = 1 WHERE `include_user_phone` = 0");
            }

            // Migration check: Add is_autosaved column if missing
            $chkAuto = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotations_v2` LIKE 'is_autosaved'");
            if ($chkAuto && mysqli_num_rows($chkAuto) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotations_v2` ADD COLUMN `is_autosaved` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`");
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
                `merge_with_prev` TINYINT(1) NOT NULL DEFAULT 0,
                PRIMARY KEY (`item_id`),
                KEY `idx_quotation_id` (`quotation_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            @mysqli_query($this->db, $itemsSql);

            // Migration check: Add merge_with_prev in tbl_quotation_items_v2 if missing
            $chkItmMerge = @mysqli_query($this->db, "SHOW COLUMNS FROM `tbl_quotation_items_v2` LIKE 'merge_with_prev'");
            if ($chkItmMerge && mysqli_num_rows($chkItmMerge) == 0) {
                @mysqli_query($this->db, "ALTER TABLE `tbl_quotation_items_v2` ADD COLUMN `merge_with_prev` TINYINT(1) NOT NULL DEFAULT 0 AFTER `total_price`");
            }

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

            $settingsSql = "CREATE TABLE IF NOT EXISTS `tbl_quotation_settings_v2` (
                `setting_key` VARCHAR(100) NOT NULL PRIMARY KEY,
                `setting_value` LONGTEXT NOT NULL,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            @mysqli_query($this->db, $settingsSql);

            // Ensure starting sequence setting commences from 9866
            @mysqli_query($this->db, "INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
                VALUES ('quotation_starting_seq', '9866') 
                ON DUPLICATE KEY UPDATE `setting_value` = IF(CAST(`setting_value` AS UNSIGNED) < 9866, '9866', `setting_value`)");

            // Do not automatically re-seed demo data if the administrator clears the table.
            // Demo data can be manually seeded by visiting with ?action=seed_demo_data if needed.
        } else {
            if (!file_exists($this->jsonFallbackFile)) {
                $this->seedInitialDataJson();
            }
        }

        // Ensure default stamp & signature files exist in uploads
        $upDir = __DIR__ . '/../../view/uploads/quotation_signatures/';
        if (!file_exists($upDir)) {
            @mkdir($upDir, 0777, true);
        }
        $assetDir = __DIR__ . '/../../view/global_assets/images/quotation_signatures/';
        if (file_exists($assetDir . 'default_thc_stamp.png') && !file_exists($upDir . 'default_thc_stamp.png')) {
            @copy($assetDir . 'default_thc_stamp.png', $upDir . 'default_thc_stamp.png');
        }
        if (file_exists($assetDir . 'default_signature.png') && !file_exists($upDir . 'default_signature.png')) {
            @copy($assetDir . 'default_signature.png', $upDir . 'default_signature.png');
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
        $quotes = is_array($data) ? $data : [];

        $todayStr = date('Y-m-d');
        $changed = false;
        foreach ($quotes as &$q) {
            if (in_array($q['status'] ?? '', ['Pending', 'Pending approval'])) {
                $qDate = $q['quotation_date'] ?? $q['date'] ?? $todayStr;
                $valDays = isset($q['validity_days']) ? (int)$q['validity_days'] : 30;
                $expDate = date('Y-m-d', strtotime($qDate . " + {$valDays} days"));
                if ($expDate < $todayStr) {
                    $q['status'] = 'Expired';
                    $q['remark'] = (!empty($q['remark']) ? $q['remark'] . ' | ' : '') . 'Expired: validity period exceeded';
                    $changed = true;
                }
            }
        }
        unset($q);
        if ($changed) {
            $this->saveJsonQuotations($quotes);
        }

        return $quotes;
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
        $action = '';
        if (!empty($_GET['action'])) {
            $action = trim($_GET['action']);
        }
        if ($action === '' && isset($data['action'])) {
            $action = trim((string)$data['action']);
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
                case 'reopen':
                case 'void':
                case 'mark_void':
                    $this->updateStatus();
                    break;

                case 'mark_completed':
                    $this->markCompleted();
                    break;

                case 'revive_quotation':
                    $this->reviveQuotation();
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

                case 'get_customers':
                    $this->getCustomers();
                    break;

                case 'save_customer_master':
                    $this->saveCustomerMaster();
                    break;

                case 'get_footer_config':
                    $this->handleGetFooterConfig();
                    break;

                case 'save_footer_config':
                    $this->handleSaveFooterConfig();
                    break;

                case 'get_stamp_sign_config':
                    $this->handleGetStampSignConfig();
                    break;

                case 'save_stamp_sign_config':
                    $this->handleSaveStampSignConfig();
                    break;

                case 'upload_stamp_sign':
                    $this->handleUploadStampSign();
                    break;

                case 'export_excel':
                    $this->exportQuotationsExcel();
                    break;

                case 'parse_import_items_file':
                    $this->parseImportItemsFile();
                    break;

                case 'download_import_template':
                    $this->downloadImportTemplate();
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

    public function isSessionUserAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $sessUserType = strtolower(trim($_SESSION['user_type'] ?? ''));
        $sessUserName = strtolower(trim($_SESSION['user_name'] ?? ''));
        $sessUsername = strtoupper(trim($_SESSION['username'] ?? ''));

        if (in_array($sessUserType, ['administrator', 'admin']) ||
            in_array($sessUserName, ['administrator', 'admin', 'adminstrator']) ||
            $sessUsername === 'CGTHCFM') {
            return true;
        }

        $userTitle = !empty($_SESSION['user_type']) ? strtolower(trim($_SESSION['user_type'])) : '';
        if (in_array($userTitle, ['administrator', 'admin'])) {
            return true;
        }

        return false;
    }

    public function isSessionUserManager(): bool
    {
        if ($this->isSessionUserAdmin()) {
            return true;
        }
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $sessUserType = strtolower(trim($_SESSION['user_type'] ?? ''));
        if (preg_match('/manager|head|director/i', $sessUserType)) {
            return true;
        }

        return false;
    }

    private function getCurrentSessionUser()
    {
        $userCode = "MA";
        $userName = "Mohammed Ali";
        $userTitle = "Operations Manager";
        $userId = 1;
        $isAdmin = false;
        $isManager = true;
        $userPhone = "";

        if (!empty($_SESSION['username'])) {
            $empCode = $_SESSION['username'];
            $userName = !empty($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['username'];
            if (strtolower(trim($userName)) === 'adminstrator') {
                $userName = 'Administrator';
            }
            $userCode = $this->deriveUserInitials($userName, $empCode);
            $userTitle = !empty($_SESSION['user_type']) ? $_SESSION['user_type'] : "Operations Manager";
            $userId = !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1;

            if ($this->isDbConnected) {
                $cRes = @mysqli_query($this->db, "SELECT employee_contact_no FROM tbl_employees WHERE employee_code = '" . mysqli_real_escape_string($this->db, $empCode) . "' LIMIT 1");
                if ($cRes && ($cRow = mysqli_fetch_assoc($cRes))) {
                    $userPhone = trim($cRow['employee_contact_no'] ?? '');
                }
                if (empty($userPhone) && !empty($userName)) {
                    $cRes2 = @mysqli_query($this->db, "SELECT employee_contact_no FROM tbl_employees WHERE employee_name = '" . mysqli_real_escape_string($this->db, $userName) . "' AND employee_contact_no != '' LIMIT 1");
                    if ($cRes2 && ($cRow2 = mysqli_fetch_assoc($cRes2))) {
                        $userPhone = trim($cRow2['employee_contact_no'] ?? '');
                    }
                }
            }
            if (empty($userPhone) && !empty($_SESSION['user_phone'])) {
                $userPhone = trim($_SESSION['user_phone']);
            }
            if (empty($userPhone)) {
                if ($userCode === 'ADM' || stripos($userName, 'Admin') !== false) {
                    $userPhone = '+973 17 100 190';
                } elseif ($userCode === 'MA' || stripos($userName, 'Mohammed Ali') !== false) {
                    $userPhone = '+973 3944 1015';
                }
            }

            $sessUserType = strtolower(trim($_SESSION['user_type'] ?? ''));
            $sessUserName = strtolower(trim($_SESSION['user_name'] ?? ''));
            $sessUsername = strtoupper(trim($_SESSION['username'] ?? ''));
            $isAdmin = in_array($sessUserType, ['administrator', 'admin']) ||
                in_array($sessUserName, ['administrator', 'admin', 'adminstrator']) ||
                $sessUsername === 'CGTHCFM';
            $isManager = $isAdmin || (bool)preg_match('/manager|head|director/i', $sessUserType);
        } else {
            $isAdmin = in_array(strtolower(trim($userTitle)), ['administrator', 'admin']) || $userCode === 'ADM';
            $isManager = $isAdmin || (bool)preg_match('/manager|head|director/i', $userTitle);
        }

        return [
            "code" => $userCode,
            "name" => $userName,
            "title" => $userTitle,
            "phone" => $userPhone,
            "id" => $userId,
            "is_admin" => $isAdmin,
            "is_manager" => $isManager
        ];
    }

    private function getEffectiveActingUser(): array
    {
        $curUser = $this->getCurrentSessionUser();
        $actCode = trim((string)$this->getInputParam('acting_user_code', ''));
        $actName = trim((string)$this->getInputParam('acting_user_name', ''));
        $actTitle = trim((string)$this->getInputParam('acting_user_title', ''));

        if ($actCode !== '') {
            if (strtolower($actName) === 'adminstrator') {
                $actName = 'Administrator';
            }
            $isAdmin = (strtoupper($actCode) === 'ADM') ||
                in_array(strtolower($actTitle), ['administrator', 'admin']) ||
                in_array(strtolower($actName), ['administrator', 'admin', 'adminstrator']);
            $isManager = $isAdmin || (bool)preg_match('/manager|head|director/i', $actTitle);

            return [
                "code" => $actCode,
                "name" => $actName !== '' ? $actName : $curUser['name'],
                "title" => $actTitle !== '' ? $actTitle : $curUser['title'],
                "is_admin" => $isAdmin,
                "is_manager" => $isManager
            ];
        }

        return $curUser;
    }

    private function getInitialData()
    {
        $curUser = $this->getCurrentSessionUser();

        // 1. Fetch AMC and Non-AMC Customers
        $custData = $this->fetchCustomersList();
        $amcClients = $custData['amc_clients'];
        $nonAmcClients = $custData['non_amc_clients'];

        // 2. Fetch Users / Estimators (strictly users with Quotation permissions: Administrator, Operation Manager, Operation Coordinator)
        $users = [];
        if ($this->isDbConnected) {
            $uSql = "SELECT DISTINCT e.employee_id, e.employee_code, e.employee_name, e.employee_type_name, e.employee_contact_no 
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
                        "title" => $title,
                        "phone" => trim($u['employee_contact_no'] ?? '')
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
                "title" => $curUser['title'],
                "phone" => $curUser['phone'] ?? ''
            ];
        }

        // 3. Fetch Quotations
        $quotations = $this->fetchQuotationsList();

        echo json_encode([
            "status" => "success",
            "current_user" => $curUser,
            "users" => $users,
            "amc_clients" => $amcClients,
            "non_amc_clients" => $nonAmcClients,
            "default_terms" => $this->defaultTerms,
            "library_terms" => $this->libraryTerms,
            "rejection_reasons" => $this->rejectionReasons,
            "units" => $this->fetchUnitsList(),
            "footer_config" => $this->getFooterConfig(),
            "stamp_sign_config" => $this->getStampSignConfig(),
            "quotations" => $quotations
        ]);
    }

    private function fetchCustomersList(): array
    {
        $amcClients = [];
        $nonAmcClients = [];

        if ($this->isDbConnected) {
            $cRes = @mysqli_query($this->db, "SELECT customer_id, customer_code, customer_name, customer_address, customer_contact_no, customer_contact_person_name, customer_contact_person_no, customer_email_id, customer_cpr_cr_no, customer_vat_no, customer_location, customer_description, is_amc, customer_type FROM tbl_customers WHERE customer_status='Active' ORDER BY customer_name ASC");
            if ($cRes && mysqli_num_rows($cRes) > 0) {
                while ($c = mysqli_fetch_assoc($cRes)) {
                    $code = !empty($c['customer_code']) && $c['customer_code'] !== 'NA' ? $c['customer_code'] : 'C' . str_pad($c['customer_id'], 4, '0', STR_PAD_LEFT);
                    $isAmc = ((int)$c['is_amc'] === 0 || $c['customer_type'] === 'Non AMC') ? 0 : 1;
                    $cObj = [
                        "id" => (int)$c['customer_id'],
                        "code" => $code,
                        "name" => $c['customer_name'],
                        "address" => !empty($c['customer_address']) && $c['customer_address'] !== 'NA' ? $c['customer_address'] : "M/S " . $c['customer_name'] . ", Kingdom of Bahrain",
                        "contact" => !empty($c['customer_contact_no']) && $c['customer_contact_no'] !== 'NA' ? $c['customer_contact_no'] : "",
                        "contact_person" => !empty($c['customer_contact_person_name']) && $c['customer_contact_person_name'] !== 'NA' ? $c['customer_contact_person_name'] : "",
                        "contact_person_no" => !empty($c['customer_contact_person_no']) && $c['customer_contact_person_no'] !== 'NA' ? $c['customer_contact_person_no'] : "",
                        "email" => !empty($c['customer_email_id']) && $c['customer_email_id'] !== 'NA' ? $c['customer_email_id'] : "",
                        "alternate_contact" => !empty($c['customer_location']) && $c['customer_location'] !== 'NA' ? $c['customer_location'] : "",
                        "cpr_cr" => !empty($c['customer_cpr_cr_no']) && $c['customer_cpr_cr_no'] !== 'NA' ? $c['customer_cpr_cr_no'] : "",
                        "vat_no" => !empty($c['customer_vat_no']) && $c['customer_vat_no'] !== 'NA' ? $c['customer_vat_no'] : "",
                        "description" => !empty($c['customer_description']) && $c['customer_description'] !== 'NA' ? $c['customer_description'] : "",
                        "is_amc" => $isAmc,
                        "customer_type" => $isAmc ? 'AMC' : 'Non AMC'
                    ];

                    if ($isAmc === 1) {
                        $amcClients[] = $cObj;
                    } else {
                        $nonAmcClients[] = $cObj;
                    }
                }
            }
        }

        if (empty($amcClients)) {
            $amcClients = $this->defaultAmcClients;
        }

        return [
            "amc_clients" => $amcClients,
            "non_amc_clients" => $nonAmcClients
        ];
    }

    private function getCustomers()
    {
        $custData = $this->fetchCustomersList();
        echo json_encode([
            "status" => "success",
            "amc_clients" => $custData['amc_clients'],
            "non_amc_clients" => $custData['non_amc_clients']
        ]);
    }

    private function saveCustomerMaster()
    {
        if (!$this->isDbConnected) {
            echo json_encode(["status" => "error", "message" => "Database connection not available."]);
            return;
        }

        $input = $this->getInputData();
        $custId = isset($input['customer_id']) ? (int)$input['customer_id'] : 0;
        $name = trim($input['customer_name'] ?? '');
        $contact = trim($input['customer_contact_no'] ?? '');
        $email = trim($input['customer_email_id'] ?? '');
        $altContact = trim($input['alternate_contact_no'] ?? '');
        $contactPerson = trim($input['contact_person'] ?? '');
        $contactPersonNo = trim($input['contact_person_number'] ?? '');
        $cprCr = trim($input['cpr_cr_number'] ?? '');
        $vatNo = trim($input['vat_number'] ?? '');
        $address = trim($input['customer_address'] ?? '');
        $description = trim($input['customer_description'] ?? '');
        $customerType = (isset($input['customer_type']) && trim($input['customer_type']) === 'Non AMC') ? 'Non AMC' : 'AMC';
        if (isset($input['is_amc'])) {
            $isAmc = ((int)$input['is_amc'] === 0 || $input['is_amc'] === '0') ? 0 : 1;
            $customerType = ($isAmc === 1) ? 'AMC' : 'Non AMC';
        } else {
            $isAmc = ($customerType === 'AMC') ? 1 : 0;
        }

        if ($name === '') {
            echo json_encode(["status" => "error", "message" => "Customer name is required."]);
            return;
        }
        if ($contact === '') {
            echo json_encode(["status" => "error", "message" => "Customer contact number is required."]);
            return;
        }

        $escName = mysqli_real_escape_string($this->db, $name);
        $escContact = mysqli_real_escape_string($this->db, $contact);
        $escEmail = mysqli_real_escape_string($this->db, $email);
        $escAltContact = mysqli_real_escape_string($this->db, $altContact);
        $escPerson = mysqli_real_escape_string($this->db, $contactPerson);
        $escPersonNo = mysqli_real_escape_string($this->db, $contactPersonNo);
        $escCpr = mysqli_real_escape_string($this->db, $cprCr);
        $escVat = mysqli_real_escape_string($this->db, $vatNo);
        $escAddress = mysqli_real_escape_string($this->db, $address);
        $escDesc = mysqli_real_escape_string($this->db, $description);

        // Check contact uniqueness
        $chkContactSql = "SELECT customer_id, customer_name FROM tbl_customers WHERE customer_contact_no = '$escContact' AND customer_id != $custId LIMIT 1";
        $chkContactRes = @mysqli_query($this->db, $chkContactSql);
        if ($chkContactRes && mysqli_num_rows($chkContactRes) > 0) {
            $existing = mysqli_fetch_assoc($chkContactRes);
            echo json_encode(["status" => "error", "message" => "Contact number '$contact' already belongs to '" . $existing['customer_name'] . "'."]);
            return;
        }

        // Check CPR/CR uniqueness if provided
        if ($cprCr !== '') {
            $chkCprSql = "SELECT customer_id, customer_name FROM tbl_customers WHERE customer_cpr_cr_no = '$escCpr' AND customer_id != $custId AND customer_cpr_cr_no != '' LIMIT 1";
            $chkCprRes = @mysqli_query($this->db, $chkCprSql);
            if ($chkCprRes && mysqli_num_rows($chkCprRes) > 0) {
                $existing = mysqli_fetch_assoc($chkCprRes);
                echo json_encode(["status" => "error", "message" => "CPR/CR number '$cprCr' already belongs to '" . $existing['customer_name'] . "'."]);
                return;
            }
        }

        $custCode = '';
        if ($custId > 0) {
            $updateSql = "UPDATE `tbl_customers` SET 
                `customer_name` = '$escName',
                `customer_contact_no` = '$escContact',
                `customer_email_id` = '$escEmail',
                `customer_location` = '$escAltContact',
                `customer_contact_person_name` = '$escPerson',
                `customer_contact_person_no` = '$escPersonNo',
                `customer_cpr_cr_no` = '$escCpr',
                `customer_vat_no` = '$escVat',
                `customer_address` = '$escAddress',
                `customer_description` = '$escDesc',
                `is_amc` = $isAmc,
                `customer_type` = '$customerType'
                WHERE `customer_id` = $custId";
            $res = @mysqli_query($this->db, $updateSql);
            if (!$res) {
                echo json_encode(["status" => "error", "message" => "Failed to update customer: " . mysqli_error($this->db)]);
                return;
            }

            $cCodeRes = @mysqli_query($this->db, "SELECT customer_code FROM tbl_customers WHERE customer_id = $custId LIMIT 1");
            if ($cCodeRes && $row = mysqli_fetch_assoc($cCodeRes)) {
                $custCode = !empty($row['customer_code']) && $row['customer_code'] !== 'NA' ? $row['customer_code'] : 'C' . str_pad($custId, 4, '0', STR_PAD_LEFT);
            }
        } else {
            $insertSql = "INSERT INTO `tbl_customers` (
                `customer_name`, `customer_contact_no`, `customer_email_id`, `customer_location`,
                `customer_contact_person_name`, `customer_contact_person_no`, `customer_cpr_cr_no`, `customer_vat_no`,
                `customer_address`, `customer_description`, `customer_status`, `is_amc`, `customer_type`, `date_active`
            ) VALUES (
                '$escName', '$escContact', '$escEmail', '$escAltContact',
                '$escPerson', '$escPersonNo', '$escCpr', '$escVat',
                '$escAddress', '$escDesc', 'Active', $isAmc, '$customerType', NOW()
            )";
            $res = @mysqli_query($this->db, $insertSql);
            if (!$res) {
                echo json_encode(["status" => "error", "message" => "Failed to create customer: " . mysqli_error($this->db)]);
                return;
            }

            $custId = (int)mysqli_insert_id($this->db);
            $custCode = 'C' . str_pad($custId, 4, '0', STR_PAD_LEFT);
            @mysqli_query($this->db, "UPDATE `tbl_customers` SET `customer_code` = '$custCode' WHERE `customer_id` = $custId");
        }

        $fresh = $this->fetchCustomersList();

        $savedCust = [
            "id" => $custId,
            "code" => $custCode,
            "name" => $name,
            "address" => !empty($address) ? $address : "M/S " . $name . ", Kingdom of Bahrain",
            "contact" => $contact,
            "contact_person" => $contactPerson,
            "contact_person_no" => $contactPersonNo,
            "email" => $email,
            "alternate_contact" => $altContact,
            "cpr_cr" => $cprCr,
            "vat_no" => $vatNo,
            "description" => $description,
            "is_amc" => $isAmc,
            "customer_type" => $customerType
        ];

        echo json_encode([
            "status" => "success",
            "message" => "Customer '$name' ($custCode) saved successfully.",
            "customer" => $savedCust,
            "amc_clients" => $fresh['amc_clients'],
            "non_amc_clients" => $fresh['non_amc_clients']
        ]);
    }

    private function fetchQuotationsList()
    {
        if ($this->isDbConnected) {
            $list = [];

            // Auto-expire pending quotations that exceeded their validity period
            @mysqli_query($this->db, "UPDATE tbl_quotations_v2 
                SET status = 'Expired', 
                    remark = CONCAT(IF(remark IS NOT NULL AND remark != '', CONCAT(remark, ' | '), ''), 'Expired: validity period exceeded')
                WHERE status IN ('Pending', 'Pending approval') 
                AND DATE_ADD(quotation_date, INTERVAL COALESCE(validity_days, 30) DAY) < CURDATE()");

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
                            "total_price" => (float)$it['total_price'],
                            "merge_with_prev" => (int)($it['merge_with_prev'] ?? 0)
                        ];
                    }
                }

                while ($r = mysqli_fetch_assoc($qRes)) {
                    $qId = (int)$r['id'];
                    $terms = json_decode($r['terms_json'] ?? '', true);
                    if (!is_array($terms)) $terms = $this->defaultTerms;
                    $items = $itemsByQuote[$qId] ?? [];

                    $appr = null;
                    if (!empty($r['approval_by'])) {
                        $appr = [
                            "by" => $r['approval_by'],
                            "on" => !empty($r['approval_date']) ? $r['approval_date'] : $r['quotation_date'],
                            "po" => $r['client_po_ref'] ?? '',
                            "attachment" => $r['approval_attachment'] ?? ''
                        ];
                    }
                    $activity = json_decode($r['activity_json'] ?? '', true);
                    if (!is_array($activity)) $activity = [];

                    $list[] = [
                        "id" => (int)$r['id'],
                        "seq_no" => $r['seq_no'] !== null ? (int)$r['seq_no'] : null,
                        "rev_no" => (int)$r['rev_no'],
                        "variation_no" => (int)($r['variation_no'] ?? 0),
                        "vn" => (int)($r['variation_no'] ?? 0),
                        "quotation_no" => $r['quotation_no'],
                        "is_amc" => (int)$r['is_amc'],
                        "client_code" => $r['client_code'],
                        "client_name" => $r['client_name'],
                        "client_address" => $r['client_address'],
                        "contact_no" => $r['contact_no'],
                        "attention" => $r['attention'],
                        "subject" => $r['subject'],
                        "quotation_date" => $r['quotation_date'],
                        "validity_days" => (int)($r['validity_days'] ?? 30),
                        "completion_date" => $r['completion_date'] ?? null,
                        "completion_by" => $r['completion_by'] ?? '',
                        "completion_notes" => $r['completion_notes'] ?? '',
                        "completion_attachment" => $r['completion_attachment'] ?? '',
                        "approval_attachment" => $r['approval_attachment'] ?? '',
                        "revived_at" => $r['revived_at'] ?? null,
                        "revived_by" => $r['revived_by'] ?? '',
                        "user_code" => $r['user_code'],
                        "user_name" => $r['user_name'],
                        "user_designation" => $r['user_designation'],
                        "user_phone" => !empty($r['user_phone']) ? $r['user_phone'] : ($users[$r['user_code']]['phone'] ?? ($r['user_code'] === 'ADM' ? '+973 17 100 190' : ($r['user_code'] === 'MA' ? '+973 3944 1015' : ''))),
                        "include_user_phone" => (!isset($r['include_user_phone']) || (int)$r['include_user_phone'] === 1 || empty($r['user_phone'])) ? 1 : (int)$r['include_user_phone'],
                        "vat_rate" => (float)$r['vat_rate'],
                        "discount_type" => isset($r['discount_type']) ? $r['discount_type'] : 'amount',
                        "discount_value" => isset($r['discount_value']) ? (float)$r['discount_value'] : 0.0,
                        "discount_amount" => isset($r['discount_amount']) ? (float)$r['discount_amount'] : 0.0,
                        "subtotal_excl_vat" => (float)$r['subtotal_excl_vat'],
                        "vat_amount" => (float)$r['vat_amount'],
                        "total_incl_vat" => (float)$r['total_incl_vat'],
                        "internal_notes" => $r['internal_notes'] ?? '',
                        "merge_items" => (int)($r['merge_items'] ?? 0),
                        "merge_qty" => (int)($r['merge_qty'] ?? 0),
                        "merged_lump_sum_price" => (float)($r['merged_lump_sum_price'] ?? 0.0),
                        "bullet_items" => (int)($r['bullet_items'] ?? 0),
                        "terms" => $terms,
                        "status" => $r['status'],
                        "is_autosaved" => (int)($r['is_autosaved'] ?? 0),
                        "rejection_reason" => $r['rejection_reason'],
                        "remark" => $r['remark'],
                        "appr" => $appr,
                        "approval" => $appr,
                        "log" => $activity,
                        "activity" => $activity,
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

    public function getFooterConfig(): array
    {
        $cfg = $this->defaultFooterConfig;
        if ($this->isDbConnected) {
            $sRes = @mysqli_query($this->db, "SELECT `setting_value` FROM `tbl_quotation_settings_v2` WHERE `setting_key` = 'quotation_footer_config' LIMIT 1");
            if ($sRes && ($row = mysqli_fetch_assoc($sRes))) {
                $dbVal = json_decode($row['setting_value'], true);
                if (is_array($dbVal)) {
                    $cfg = array_merge($cfg, $dbVal);
                }
            }
        } elseif (file_exists($this->footerConfigFile)) {
            $fVal = json_decode(@file_get_contents($this->footerConfigFile), true);
            if (is_array($fVal)) {
                $cfg = array_merge($cfg, $fVal);
            }
        }
        return $cfg;
    }

    private function handleGetFooterConfig()
    {
        echo json_encode([
            "status" => "success",
            "footer_config" => $this->getFooterConfig()
        ]);
    }

    private function handleSaveFooterConfig()
    {
        $input = $this->getInputData();
        $curCfg = $this->getFooterConfig();

        $updated = [
            'phone' => isset($input['phone']) ? trim((string)$input['phone']) : $curCfg['phone'],
            'email' => isset($input['email']) ? trim((string)$input['email']) : $curCfg['email'],
            'website' => isset($input['website']) ? trim((string)$input['website']) : $curCfg['website'],
            'cr_no' => isset($input['cr_no']) ? trim((string)$input['cr_no']) : $curCfg['cr_no'],
            'address_line1' => isset($input['address_line1']) ? trim((string)$input['address_line1']) : $curCfg['address_line1'],
            'address_line2' => isset($input['address_line2']) ? trim((string)$input['address_line2']) : $curCfg['address_line2'],
            'bg_color' => !empty($input['bg_color']) ? trim((string)$input['bg_color']) : $curCfg['bg_color'],
            'show_badges' => isset($input['show_badges']) ? (int)(bool)$input['show_badges'] : $curCfg['show_badges'],
            'badges_image' => !empty($input['badges_image']) ? trim((string)$input['badges_image']) : $curCfg['badges_image'],
            'show_page_no' => isset($input['show_page_no']) ? (int)(bool)$input['show_page_no'] : $curCfg['show_page_no'],
            'show_ref_no' => isset($input['show_ref_no']) ? (int)(bool)$input['show_ref_no'] : $curCfg['show_ref_no'],
            'doc_number' => !empty($input['doc_number']) ? trim((string)$input['doc_number']) : ($curCfg['doc_number'] ?? 'CINQO/THC/QTN/01/2020/REV3')
        ];

        $jsonStr = json_encode($updated, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($this->isDbConnected) {
            $escKey = 'quotation_footer_config';
            $escVal = mysqli_real_escape_string($this->db, $jsonStr);
            @mysqli_query($this->db, "INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
                VALUES ('$escKey', '$escVal') 
                ON DUPLICATE KEY UPDATE `setting_value` = '$escVal'");
        }

        // Always save fallback JSON
        $dir = dirname($this->footerConfigFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @file_put_contents($this->footerConfigFile, $jsonStr);

        echo json_encode([
            "status" => "success",
            "message" => "Quotation footer configuration saved successfully.",
            "footer_config" => $updated
        ]);
    }

    public function getStampSignConfig(): array
    {
        $cfg = $this->defaultStampSignConfig;
        $loadedFromDb = false;
        if ($this->isDbConnected) {
            $res = @mysqli_query($this->db, "SELECT `setting_value` FROM `tbl_quotation_settings_v2` WHERE `setting_key` = 'quotation_stamp_sign_config' LIMIT 1");
            if ($res && ($row = mysqli_fetch_assoc($res))) {
                $dbCfg = json_decode($row['setting_value'], true);
                if (is_array($dbCfg)) {
                    $cfg = array_merge($cfg, $dbCfg);
                    $loadedFromDb = true;
                }
            }
        }
        if (!$loadedFromDb && file_exists($this->stampSignConfigFile)) {
            $fJson = json_decode(@file_get_contents($this->stampSignConfigFile), true);
            if (is_array($fJson)) {
                $cfg = array_merge($cfg, $fJson);
            }
        }
        if (!is_array($cfg['user_signatures'] ?? null)) $cfg['user_signatures'] = [];
        if (!is_array($cfg['user_phones'] ?? null)) $cfg['user_phones'] = [];
        return $cfg;
    }

    private function handleGetStampSignConfig()
    {
        echo json_encode([
            "status" => "success",
            "stamp_sign_config" => $this->getStampSignConfig()
        ]);
    }

    private function handleSaveStampSignConfig()
    {
        $input = $this->getInputData();
        $curCfg = $this->getStampSignConfig();

        if (isset($input['show_stamp'])) {
            $curCfg['show_stamp'] = (int)(bool)$input['show_stamp'];
        }
        if (isset($input['show_signature'])) {
            $curCfg['show_signature'] = (int)(bool)$input['show_signature'];
        }
        if (isset($input['show_user_phone'])) {
            $curCfg['show_user_phone'] = (int)(bool)$input['show_user_phone'];
        }
        if (isset($input['user_phones']) && is_array($input['user_phones'])) {
            $curCfg['user_phones'] = array_merge($curCfg['user_phones'] ?? [], $input['user_phones']);
        }
        if (!empty($input['company_stamp_url'])) {
            $curCfg['company_stamp_url'] = trim((string)$input['company_stamp_url']);
        }
        if (!empty($input['default_signature_url'])) {
            $curCfg['default_signature_url'] = trim((string)$input['default_signature_url']);
        }

        $saveCfg = $curCfg;
        if (empty($saveCfg['user_signatures'])) $saveCfg['user_signatures'] = new \stdClass();
        if (empty($saveCfg['user_phones'])) $saveCfg['user_phones'] = new \stdClass();
        $jsonStr = json_encode($saveCfg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($this->isDbConnected) {
            $escKey = 'quotation_stamp_sign_config';
            $escVal = mysqli_real_escape_string($this->db, $jsonStr);
            @mysqli_query($this->db, "INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
                VALUES ('$escKey', '$escVal') 
                ON DUPLICATE KEY UPDATE `setting_value` = '$escVal'");
        }

        $dir = dirname($this->stampSignConfigFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @file_put_contents($this->stampSignConfigFile, $jsonStr);

        echo json_encode([
            "status" => "success",
            "message" => "Stamp and signature settings saved successfully.",
            "stamp_sign_config" => $curCfg
        ]);
    }

    private function handleUploadStampSign()
    {
        $uploadDir = __DIR__ . '/../../view/uploads/quotation_signatures/';
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $curCfg = $this->getStampSignConfig();
        $showStamp = isset($_POST['show_stamp']) ? (int)(bool)$_POST['show_stamp'] : $curCfg['show_stamp'];
        $showSignature = isset($_POST['show_signature']) ? (int)(bool)$_POST['show_signature'] : $curCfg['show_signature'];
        $userCode = isset($_POST['user_code']) ? trim((string)$_POST['user_code']) : '';

        $allowedExts = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
        $uploaded = [];

        // Handle Stamp Upload
        if (!empty($_FILES['stamp_file']['name']) && $_FILES['stamp_file']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['stamp_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowedExts)) {
                $newFileName = 'thc_stamp_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $target = $uploadDir . $newFileName;
                if (move_uploaded_file($_FILES['stamp_file']['tmp_name'], $target)) {
                    $curCfg['company_stamp_url'] = 'uploads/quotation_signatures/' . $newFileName;
                    $showStamp = 1;
                    $uploaded[] = 'Company Stamp';
                }
            }
        }

        // Handle Signature Upload
        if (!empty($_FILES['signature_file']['name']) && $_FILES['signature_file']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['signature_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowedExts)) {
                $prefix = !empty($userCode) ? preg_replace('/[^a-zA-Z0-9_\-]/', '', $userCode) : 'sig';
                $newFileName = 'sig_' . $prefix . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
                $target = $uploadDir . $newFileName;
                if (move_uploaded_file($_FILES['signature_file']['tmp_name'], $target)) {
                    $relUrl = 'uploads/quotation_signatures/' . $newFileName;
                    $curCfg['default_signature_url'] = $relUrl;
                    if (!empty($userCode)) {
                        if (!isset($curCfg['user_signatures']) || !is_array($curCfg['user_signatures'])) {
                            $curCfg['user_signatures'] = [];
                        }
                        $curCfg['user_signatures'][$userCode] = $relUrl;
                    }
                    $showSignature = 1;
                    $uploaded[] = 'Estimator Signature';
                }
            }
        }

        $curCfg['show_stamp'] = $showStamp;
        $curCfg['show_signature'] = $showSignature;

        $saveCfg = $curCfg;
        if (empty($saveCfg['user_signatures'])) $saveCfg['user_signatures'] = new \stdClass();
        if (empty($saveCfg['user_phones'])) $saveCfg['user_phones'] = new \stdClass();
        $jsonStr = json_encode($saveCfg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($this->isDbConnected) {
            $escKey = 'quotation_stamp_sign_config';
            $escVal = mysqli_real_escape_string($this->db, $jsonStr);
            @mysqli_query($this->db, "INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
                VALUES ('$escKey', '$escVal') 
                ON DUPLICATE KEY UPDATE `setting_value` = '$escVal'");
        }

        $dir = dirname($this->stampSignConfigFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @file_put_contents($this->stampSignConfigFile, $jsonStr);

        $msg = !empty($uploaded) ? (implode(' and ', $uploaded) . " uploaded and settings applied successfully.") : "Stamp and signature settings updated successfully.";

        echo json_encode([
            "status" => "success",
            "message" => $msg,
            "stamp_sign_config" => $curCfg
        ]);
    }

    private function handleClearQuotations()
    {
        if ($this->isDbConnected) {
            @mysqli_query($this->db, "TRUNCATE TABLE `tbl_quotation_items_v2`");
            @mysqli_query($this->db, "TRUNCATE TABLE `tbl_quotations_v2`");
        }
        @file_put_contents($this->jsonFallbackFile, json_encode([], JSON_PRETTY_PRINT));
        echo json_encode([
            "status" => "success",
            "message" => "All quotation records and line items have been cleared successfully. Masters and settings remain untouched."
        ]);
    }

    private function getQuotations()
    {
        $quotations = $this->fetchQuotationsList();
        echo json_encode(["status" => "success", "quotations" => $quotations]);
    }

    private function exportQuotationsExcel()
    {
        $quotes = $this->fetchQuotationsList();
        
        $clientFilter = trim($_REQUEST['client'] ?? '');
        $statusFilter = trim($_REQUEST['status'] ?? '');
        $typeFilter = trim($_REQUEST['type'] ?? '');
        $userFilter = trim($_REQUEST['user'] ?? '');
        $searchFilter = strtolower(trim($_REQUEST['q'] ?? ''));
        $showSuperseded = !empty($_REQUEST['show_superseded']) && ($_REQUEST['show_superseded'] === '1' || $_REQUEST['show_superseded'] === 'true');

        $filtered = [];
        foreach ($quotes as $q) {
            $st = $q['status'] ?? 'Draft';
            $client = $q['client_name'] ?? '';
            $isAmc = !empty($q['is_amc']);
            $uCode = $q['user_code'] ?? '';
            $qNo = $q['quotation_no'] ?? '';
            $subj = $q['subject'] ?? '';

            if (!$showSuperseded && in_array($st, ['Superseded', 'Void'])) {
                continue;
            }
            if ($statusFilter !== '') {
                if (($statusFilter === 'Pending' || $statusFilter === 'Pending approval') && ($st === 'Pending' || $st === 'Pending approval')) {
                    // match pending approval
                } elseif ($st !== $statusFilter) {
                    continue;
                }
            }
            if ($clientFilter !== '' && $client !== $clientFilter) {
                continue;
            }
            if ($typeFilter === 'AMC' && !$isAmc) {
                continue;
            }
            if ($typeFilter === 'Non-AMC' && $isAmc) {
                continue;
            }
            if ($userFilter !== '' && $uCode !== $userFilter) {
                continue;
            }
            if ($searchFilter !== '') {
                $haystack = strtolower($qNo . ' ' . $client . ' ' . $subj);
                if (strpos($haystack, $searchFilter) === false) {
                    continue;
                }
            }
            $filtered[] = $q;
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        $filename = 'THC_Quotation_Log_' . date('Y-m-d') . '.xls';
        if (!headers_sent()) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        }

        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <style>
                body { font-family: Calibri, Arial, sans-serif; font-size: 11pt; color: #1e293b; }
                table { border-collapse: collapse; width: 100%; }
                th { background-color: #0A4174; color: #ffffff; font-weight: bold; border: 1px solid #7BBDE8; padding: 8px 10px; font-size: 11pt; }
                td { border: 1px solid #cbd5e1; padding: 6px 10px; font-size: 10.5pt; vertical-align: middle; }
            </style>
        </head>
        <body>
            <table>
                <tr>
                    <th colspan="23" style="background:#001D39;color:#ffffff;font-size:15pt;padding:12px;text-align:left;">
                        THC FACILITY MANAGEMENT — QUOTATION LOG EXPORT
                    </th>
                </tr>
                <tr>
                    <td colspan="23" style="background:#f8fafc;color:#475569;font-size:10pt;padding:6px 10px;border-bottom:1.5px solid #0A4174;">
                        <b>Export Date:</b> ' . date('d-m-Y H:i:s') . ' &nbsp;|&nbsp; <b>Total Records:</b> ' . count($filtered) . '
                    </td>
                </tr>
                <tr style="height:12px;"><td colspan="23" style="border:none;"></td></tr>
                <thead>
                    <tr>
                        <th style="width:45px;">Sl.</th>
                        <th style="width:180px;">Quote No.</th>
                        <th style="width:80px;">Version</th>
                        <th style="width:95px;">Date</th>
                        <th style="width:190px;">Client Name</th>
                        <th style="width:85px;">Client Code</th>
                        <th style="width:85px;">Type</th>
                        <th style="width:110px;">Contact No.</th>
                        <th style="width:140px;">Attention</th>
                        <th style="width:230px;">Subject</th>
                        <th style="width:150px;">Prepared By</th>
                        <th style="width:140px;">Designation</th>
                        <th style="width:115px;text-align:right;">Gross Excl. VAT (BHD)</th>
                        <th style="width:105px;text-align:right;">Discount (BHD)</th>
                        <th style="width:115px;text-align:right;">Net Excl. VAT (BHD)</th>
                        <th style="width:75px;text-align:center;">VAT %</th>
                        <th style="width:105px;text-align:right;">VAT Amount (BHD)</th>
                        <th style="width:125px;text-align:right;">Total Incl. VAT (BHD)</th>
                        <th style="width:70px;text-align:center;">Merged?</th>
                        <th style="width:95px;text-align:center;">Status</th>
                        <th style="width:200px;">Decision / Remark</th>
                        <th style="width:220px;">Internal Notes (Office Ref)</th>
                        <th style="width:300px;">Scope of Works Summary</th>
                    </tr>
                </thead>
                <tbody>';

        $totalGross = 0.0;
        $totalDisc = 0.0;
        $totalNet = 0.0;
        $totalVat = 0.0;
        $grandTotal = 0.0;

        foreach ($filtered as $idx => $x) {
            $qNo = $x['quotation_no'] ?: 'Draft';
            $vn = (int)($x['variation_no'] ?? 0);
            $rev = (int)($x['rev_no'] ?? 0);
            $version = 'Original';
            if ($vn > 0 && $rev > 0) $version = "V{$vn} / R{$rev}";
            elseif ($vn > 0) $version = "V{$vn}";
            elseif ($rev > 0) $version = "R{$rev}";

            $date = $x['quotation_date'] ?? '';
            $clientName = $x['client_name'] ?? '';
            $clientCode = $x['client_code'] ?? '';
            $isAmc = !empty($x['is_amc']) ? 'AMC' : 'Non-AMC';
            $contactNo = $x['contact_no'] ?? '';
            $attention = $x['attention'] ?? '';
            $subject = $x['subject'] ?? '';
            $userName = $x['user_name'] ?? '';
            if (strtolower(trim($userName)) === 'adminstrator') $userName = 'Administrator';
            $userTitle = $x['user_designation'] ?? '';

            $isMerged = !empty($x['merge_items']);
            $mergedPrice = (float)($x['merged_lump_sum_price'] ?? 0);
            $grossAmt = (float)($x['subtotal_excl_vat'] ?? 0);
            if ($isMerged && $mergedPrice > 0) {
                $grossAmt = $mergedPrice;
            }
            $discAmt = (float)($x['discount_amount'] ?? 0);
            $netAmt = max(0, $grossAmt - $discAmt);
            $vatRate = (float)($x['vat_rate'] ?? 10);
            $vatAmt = ($netAmt * $vatRate) / 100.0;
            $totAmt = $netAmt + $vatAmt;

            $status = $x['status'] ?? 'Draft';
            if ($status === 'Draft' && !empty($x['is_autosaved'])) {
                $status = 'Draft (Auto saved)';
            }
            $decisionInfo = '';
            if ($status === 'Completed') {
                $compBy = $x['completion_by'] ?? '';
                $compDate = $x['completion_date'] ?? '';
                $compNotes = $x['completion_notes'] ?? '';
                $decisionInfo = 'Completed' . ($compDate ? ' on ' . $compDate : '') . ($compBy ? ' by ' . $compBy : '') . ($compNotes ? ' (' . $compNotes . ')' : '');
            } elseif ($status === 'Expired') {
                $valDays = $x['validity_days'] ?? 30;
                $decisionInfo = 'Expired (Validity: ' . $valDays . ' days)' . (!empty($x['remark']) ? ' - ' . $x['remark'] : '');
            } elseif ($status === 'Approved') {
                $apprBy = $x['approval_by'] ?? '';
                $apprDate = $x['approval_date'] ?? '';
                $poRef = $x['client_po_ref'] ?? '';
                $decisionInfo = 'Approved by ' . $apprBy . ($apprDate ? ' on ' . $apprDate : '') . ($poRef ? ' (PO: ' . $poRef . ')' : '');
            } elseif ($status === 'Not approved') {
                $decisionInfo = 'Rejected: ' . ($x['rejection_reason'] ?: $x['remark']);
            } elseif (!empty($x['remark'])) {
                $decisionInfo = $x['remark'];
            }

            $internalNotes = $x['internal_notes'] ?? '';

            $itemsSummary = [];
            foreach (($x['items'] ?? []) as $i => $it) {
                $desc = strip_tags(str_replace(['**', '__'], '', $it['description'] ?? ($it[0] ?? '')));
                $unit = $it['unit'] ?? ($it[2] ?? 'Lumpsum');
                $isLump = (stripos($unit, 'lump') !== false || strcasecmp(trim($unit), 'ls') === 0);
                $qty = $it['quantity'] ?? ($it[1] ?? 1);
                $price = $it['unit_price'] ?? ($it[3] ?? 0);
                $unitLabel = $isLump ? $unit : ($qty . ' ' . $unit);
                $itemsSummary[] = ($i + 1) . '. ' . $desc . ' (' . $unitLabel . ' @ ' . number_format((float)$price, 3) . ')';
            }
            $itemsSummaryStr = implode(' | ', $itemsSummary);

            $totalGross += $grossAmt;
            $totalDisc += $discAmt;
            $totalNet += $netAmt;
            $totalVat += $vatAmt;
            $grandTotal += $totAmt;

            echo '<tr>
                <td style="text-align:center;">' . ($idx + 1) . '</td>
                <td style="font-weight:bold;mso-number-format:\'\@\';">' . htmlspecialchars($qNo) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($version) . '</td>
                <td style="text-align:center;mso-number-format:\'yyyy-mm-dd\';">' . htmlspecialchars($date) . '</td>
                <td>' . htmlspecialchars($clientName) . '</td>
                <td style="text-align:center;mso-number-format:\'\@\';">' . htmlspecialchars($clientCode) . '</td>
                <td style="text-align:center;">' . htmlspecialchars($isAmc) . '</td>
                <td style="mso-number-format:\'\@\';">' . htmlspecialchars($contactNo) . '</td>
                <td>' . htmlspecialchars($attention) . '</td>
                <td>' . htmlspecialchars($subject) . '</td>
                <td>' . htmlspecialchars($userName) . '</td>
                <td>' . htmlspecialchars($userTitle) . '</td>
                <td style="text-align:right;mso-number-format:\'#,##0.000\';">' . number_format($grossAmt, 3, '.', '') . '</td>
                <td style="text-align:right;mso-number-format:\'#,##0.000\';color:#b91c1c;">' . ($discAmt > 0 ? '-' . number_format($discAmt, 3, '.', '') : '0.000') . '</td>
                <td style="text-align:right;font-weight:bold;mso-number-format:\'#,##0.000\';">' . number_format($netAmt, 3, '.', '') . '</td>
                <td style="text-align:center;">' . $vatRate . '%</td>
                <td style="text-align:right;mso-number-format:\'#,##0.000\';">' . number_format($vatAmt, 3, '.', '') . '</td>
                <td style="text-align:right;font-weight:bold;color:#0A4174;mso-number-format:\'#,##0.000\';">' . number_format($totAmt, 3, '.', '') . '</td>
                <td style="text-align:center;">' . ($isMerged ? 'Yes' : 'No') . '</td>
                <td style="text-align:center;font-weight:bold;">' . htmlspecialchars($status) . '</td>
                <td>' . htmlspecialchars($decisionInfo) . '</td>
                <td style="background:#fffbeb;color:#92400e;">' . htmlspecialchars($internalNotes) . '</td>
                <td style="font-size:10pt;color:#475569;">' . htmlspecialchars($itemsSummaryStr) . '</td>
            </tr>';
        }

        echo '</tbody>
            <tfoot>
                <tr style="background:#f1f5f9;font-weight:bold;border-top:2px solid #0A4174;">
                    <td colspan="12" style="text-align:right;padding:8px 12px;font-size:11pt;color:#001D39;">TOTALS (' . count($filtered) . ' Quotes):</td>
                    <td style="text-align:right;mso-number-format:\'#,##0.000\';">' . number_format($totalGross, 3, '.', '') . '</td>
                    <td style="text-align:right;mso-number-format:\'#,##0.000\';color:#b91c1c;">' . ($totalDisc > 0 ? '-' . number_format($totalDisc, 3, '.', '') : '0.000') . '</td>
                    <td style="text-align:right;mso-number-format:\'#,##0.000\';">' . number_format($totalNet, 3, '.', '') . '</td>
                    <td style="text-align:center;">—</td>
                    <td style="text-align:right;mso-number-format:\'#,##0.000\';">' . number_format($totalVat, 3, '.', '') . '</td>
                    <td style="text-align:right;font-weight:bold;color:#0A4174;mso-number-format:\'#,##0.000\';">' . number_format($grandTotal, 3, '.', '') . '</td>
                    <td colspan="5"></td>
                </tr>
            </tfoot>
        </table>
        </body>
        </html>';
        exit;
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

    private function getNextSequenceNumber(): int
    {
        $startSeq = 9866;
        if ($this->isDbConnected) {
            $sRes = @mysqli_query($this->db, "SELECT `setting_value` FROM `tbl_quotation_settings_v2` WHERE `setting_key` = 'quotation_starting_seq' LIMIT 1");
            if ($sRes && ($sRow = mysqli_fetch_assoc($sRes))) {
                $customStart = (int)$sRow['setting_value'];
                if ($customStart > 0) $startSeq = $customStart;
            }

            $maxRes = @mysqli_query($this->db, "SELECT MAX(seq_no) as max_seq FROM tbl_quotations_v2");
            if ($maxRes && ($mRow = mysqli_fetch_assoc($maxRes))) {
                $dbMax = !empty($mRow['max_seq']) ? (int)$mRow['max_seq'] : 0;
                return ($dbMax >= $startSeq) ? ($dbMax + 1) : $startSeq;
            }
            return $startSeq;
        }

        // JSON fallback persistence
        $quotes = $this->getJsonQuotations();
        $maxSeq = $startSeq - 1;
        foreach ($quotes as $q) {
            if (!empty($q['seq_no']) && (int)$q['seq_no'] > $maxSeq) {
                $maxSeq = (int)$q['seq_no'];
            }
        }
        return $maxSeq + 1;
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
        $userPhone = trim($input['user_phone'] ?? '');
        $includeUserPhone = !empty($input['include_user_phone']) ? 1 : 0;
        $vatRate = isset($input['vat_rate']) ? (float)$input['vat_rate'] : 10.0;
        $terms = isset($input['terms']) && is_array($input['terms']) ? $input['terms'] : $this->defaultTerms;
        $items = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];
        $seqNo = isset($input['seq_no']) && $input['seq_no'] !== '' ? (int)$input['seq_no'] : null;
        $revNo = isset($input['rev_no']) ? (int)$input['rev_no'] : 0;
        $variationNo = isset($input['variation_no']) ? (int)$input['variation_no'] : (isset($input['vn']) ? (int)$input['vn'] : 0);
        $internalNotes = trim($input['internal_notes'] ?? '');
        $mergeItems = !empty($input['merge_items']) ? 1 : 0;
        $mergeQty = !empty($input['merge_qty']) ? 1 : 0;
        $mergedLumpSumPrice = isset($input['merged_lump_sum_price']) ? (float)$input['merged_lump_sum_price'] : 0.0;
        $bulletItems = !empty($input['bullet_items']) ? 1 : 0;
        $isAutosave = !empty($input['is_autosave']);

        // Rule 1: Issued quotes are immutable. Edit exists only for Draft.
        if ($id > 0) {
            $chkStatusVal = null;
            if ($this->isDbConnected) {
                $chkRes = mysqli_query($this->db, "SELECT status, quotation_no FROM tbl_quotations_v2 WHERE id = $id");
                if ($chkRes && ($chkRow = mysqli_fetch_assoc($chkRes))) {
                    $chkStatusVal = $chkRow['status'];
                }
            } else {
                $quotes = $this->getJsonQuotations();
                foreach ($quotes as $q) {
                    if ($q['id'] == $id) { $chkStatusVal = $q['status']; break; }
                }
            }

            if ($chkStatusVal !== null && $chkStatusVal !== 'Draft') {
                if ($chkStatusVal === 'Approved') {
                    echo json_encode(["status" => "error", "message" => "This quotation is Approved and locked. It cannot be edited unless reopened by Admin."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Issued quotations are immutable. Only drafts can be edited. Changes to an issued quote must be created as a new revision or variation."]);
                }
                return;
            }
        }

        // Rule 2: Approved quotes are final. Revisions of approved quotes are rejected.
        if ($seqNo !== null && $revNo > 0) {
            $hasApprovedInSeq = false;
            if ($this->isDbConnected) {
                $chkAppr = mysqli_query($this->db, "SELECT id FROM tbl_quotations_v2 WHERE seq_no = $seqNo AND variation_no = $variationNo AND status = 'Approved' LIMIT 1");
                if ($chkAppr && mysqli_num_rows($chkAppr) > 0) {
                    $hasApprovedInSeq = true;
                }
            } else {
                $quotes = $this->getJsonQuotations();
                foreach ($quotes as $q) {
                    if (($q['seq_no'] ?? null) == $seqNo && ($q['variation_no'] ?? 0) == $variationNo && ($q['status'] ?? '') === 'Approved') {
                        $hasApprovedInSeq = true;
                        break;
                    }
                }
            }

            if ($hasApprovedInSeq) {
                echo json_encode(["status" => "error", "message" => "Approved quotations are final and locked. They cannot be revised. Please create a variation (V1, V2...) for any changes after approval."]);
                return;
            }
        }

        // Validation: For issuance, strict checks. For drafts, allow saving midway progress.
        if ($isIssue && empty($clientName)) {
            echo json_encode(["status" => "error", "message" => $isAmc ? "Select an AMC client" : "Enter client name"]);
            return;
        }
        if (!$isIssue && empty($clientName)) {
            $clientName = $isAmc ? "Draft (AMC Client Pending)" : "Draft Customer";
        }
        if (!$isIssue && empty($subject)) {
            $subject = "Draft Quotation";
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
            $unit = trim($it['unit'] ?? ($it[2] ?? 'Lumpsum'));
            $isLump = (stripos($unit, 'lump') !== false || strcasecmp($unit, 'ls') === 0);
            $qtyRaw = $it['quantity'] ?? ($it[1] ?? ($isLump ? 1 : 0));
            $qty = (float)$qtyRaw;
            if ($isLump && $qty <= 0) {
                $qty = 1.0;
            }
            $price = (float)($it['unit_price'] ?? ($it[3] ?? 0));
            $calculatedLineTotal = $qty * $price;
            $lineTotal = ($calculatedLineTotal > 0 || !isset($it['total_price'])) ? $calculatedLineTotal : (float)$it['total_price'];
            $subtotal += $lineTotal;

            $cleanItems[] = [
                "description" => $desc,
                "quantity" => $qty,
                "unit" => $unit,
                "unit_price" => $price,
                "total_price" => $lineTotal,
                "merge_with_prev" => !empty($it['merge_with_prev']) ? 1 : 0
            ];
        }

        // If merge line items option is selected with a lump sum price
        if ($mergeItems) {
            if ($mergedLumpSumPrice > 0) {
                $subtotal = $mergedLumpSumPrice;
            } elseif ($subtotal > 0 && $mergedLumpSumPrice <= 0) {
                $mergedLumpSumPrice = $subtotal;
            }
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
        $status = $isIssue ? 'Pending approval' : 'Draft';
        $quotationNo = '';

        if ($this->isDbConnected) {
            if ($isIssue) {
                if ($seqNo === null) {
                    $seqNo = $this->getNextSequenceNumber();
                }
                if (empty($clientCode) && !$isAmc) {
                    $cntRes = mysqli_query($this->db, "SELECT COUNT(*) as na_cnt FROM tbl_quotations_v2 WHERE is_amc = 0");
                    $naRow = mysqli_fetch_assoc($cntRes);
                    $clientCode = "NA-" . str_pad(((int)$naRow['na_cnt'] + 1), 4, "0", STR_PAD_LEFT);
                }

                $mmyy = date('my', strtotime($quotationDate));
                $varSuffix = $variationNo > 0 ? "/V{$variationNo}" : "";
                $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}{$varSuffix}";

                // Rule 3: Supersede older revisions in the same sequence and variation
                if ($revNo > 0) {
                    $supSql = "UPDATE tbl_quotations_v2 SET status='Superseded', remark='Revised to R{$revNo} on " . date('Y-m-d') . "' 
                               WHERE seq_no={$seqNo} AND variation_no={$variationNo} AND rev_no < {$revNo} AND status NOT IN ('Approved', 'Void')";
                    mysqli_query($this->db, $supSql);
                }
            } else {
                if ($seqNo !== null) {
                    $mmyy = date('my', strtotime($quotationDate));
                    $varSuffix = $variationNo > 0 ? "/V{$variationNo}" : "";
                    $quotationNo = "CG/THC/{$userCode}/QTN/{$seqNo}/{$mmyy}{$varSuffix}";
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
            $escUserPhone = mysqli_real_escape_string($this->db, $userPhone);
            $escQNo = mysqli_real_escape_string($this->db, $quotationNo);
            $escNotes = mysqli_real_escape_string($this->db, $internalNotes);
            $seqVal = $seqNo !== null ? (int)$seqNo : "NULL";

            // Activity Log
            $activity = [];
            if ($id > 0) {
                $chkAct = mysqli_query($this->db, "SELECT activity_json FROM tbl_quotations_v2 WHERE id = $id");
                if ($chkAct && ($aRow = mysqli_fetch_assoc($chkAct))) {
                    $activity = json_decode($aRow['activity_json'] ?? '', true);
                    if (!is_array($activity)) $activity = [];
                }
            }
            $actUser = $this->getEffectiveActingUser();
            $actUserName = $actUser['name'];
            $actNote = $isIssue ? ("Issued quotation " . $quotationNo . ($revNo ? "/R" . $revNo : "")) : ($isAutosave ? "Draft auto-saved" : "Draft saved");
            $lastAct = !empty($activity) ? end($activity) : null;
            if (!($isAutosave && $lastAct && ($lastAct['t'] ?? '') === 'Draft auto-saved')) {
                $activity[] = ["d" => date('Y-m-d H:i'), "u" => $actUserName, "t" => $actNote];
            }
            $actJson = mysqli_real_escape_string($this->db, json_encode($activity));
            $isAutosaveVal = (!$isIssue && $isAutosave) ? 1 : 0;

            if ($id > 0) {
                $upd = "UPDATE tbl_quotations_v2 SET 
                    seq_no = $seqVal,
                    rev_no = $revNo,
                    variation_no = $variationNo,
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
                    user_phone = '$escUserPhone',
                    include_user_phone = $includeUserPhone,
                    vat_rate = $vatRate,
                    discount_type = '$discountType',
                    discount_value = $discountValue,
                    discount_amount = $discountAmount,
                    subtotal_excl_vat = $subtotal,
                    vat_amount = $vatAmount,
                    total_incl_vat = $totalInclVat,
                    internal_notes = '$escNotes',
                    merge_items = $mergeItems,
                    merge_qty = $mergeQty,
                    merged_lump_sum_price = $mergedLumpSumPrice,
                    bullet_items = $bulletItems,
                    terms_json = '$termsJson',
                    status = '$status',
                    is_autosaved = $isAutosaveVal,
                    activity_json = '$actJson'
                    WHERE id = $id";
                mysqli_query($this->db, $upd);
                mysqli_query($this->db, "DELETE FROM tbl_quotation_items_v2 WHERE quotation_id = $id");
                $savedId = $id;
            } else {
                $ins = "INSERT INTO tbl_quotations_v2 
                    (seq_no, rev_no, variation_no, quotation_no, is_amc, client_code, client_name, client_address,
                     contact_no, attention, subject, quotation_date, user_code, user_name, user_designation, user_phone, include_user_phone,
                     vat_rate, discount_type, discount_value, discount_amount, subtotal_excl_vat, vat_amount, total_incl_vat,
                     internal_notes, merge_items, merge_qty, merged_lump_sum_price, bullet_items, terms_json, status, is_autosaved, activity_json)
                    VALUES 
                    ($seqVal, $revNo, $variationNo, '$escQNo', $isAmc, '$escClientCode', '$escClientName', '$escClientAddress',
                     '$escContact', '$escAttn', '$escSubj', '$escDate', '$escUserCode', '$escUserName', '$escUserDesig', '$escUserPhone', $includeUserPhone,
                     $vatRate, '$discountType', $discountValue, $discountAmount, $subtotal, $vatAmount, $totalInclVat,
                     '$escNotes', $mergeItems, $mergeQty, $mergedLumpSumPrice, $bulletItems, '$termsJson', '$status', $isAutosaveVal, '$actJson')";
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
                $mPrev = (int)$it['merge_with_prev'];
                mysqli_query($this->db, "INSERT INTO tbl_quotation_items_v2 
                    (quotation_id, sort_order, description, quantity, unit, unit_price, total_price, merge_with_prev)
                    VALUES ($savedId, $sort, '$desc', $qty, '$unit', $price, $tot, $mPrev)");
                $sort++;
            }
        } else {
            // JSON fallback persistence
            $quotes = $this->getJsonQuotations();

            if ($isIssue) {
                if ($seqNo === null) {
                    $seqNo = $this->getNextSequenceNumber();
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
                "user_phone" => $userPhone,
                "include_user_phone" => $includeUserPhone,
                "vat_rate" => $vatRate,
                "discount_type" => $discountType,
                "discount_value" => $discountValue,
                "discount_amount" => $discountAmount,
                "subtotal_excl_vat" => $subtotal,
                "vat_amount" => $vatAmount,
                "total_incl_vat" => $totalInclVat,
                "internal_notes" => $internalNotes,
                "merge_items" => $mergeItems,
                "merge_qty" => $mergeQty,
                "merged_lump_sum_price" => $mergedLumpSumPrice,
                "bullet_items" => $bulletItems,
                "terms" => $terms,
                "status" => $status,
                "is_autosaved" => $isAutosaveVal,
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
            "is_issued" => $isIssue,
            "is_autosaved" => $isAutosaveVal
        ]);
    }

    private function updateStatus()
    {
        $id = (int)$this->getInputParam('id', 0);
        $status = trim((string)$this->getInputParam('status', ''));
        $action = trim((string)$this->getInputParam('action', ''));
        $reason = trim((string)$this->getInputParam('reason', ''));
        $remark = trim((string)$this->getInputParam('remark', ''));
        $approvedBy = trim((string)$this->getInputParam('approved_by', ''));
        $approvedOn = trim((string)$this->getInputParam('approved_on', ''));
        $clientPo = trim((string)$this->getInputParam('client_po', ''));

        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid quotation ID"]);
            return;
        }

        // Support fallback if reason was passed in remark or vice-versa
        if (empty($reason) && !empty($remark)) {
            $reason = $remark;
        }
        if (empty($remark) && !empty($reason)) {
            $remark = $reason;
        }

        $curUser = $this->getEffectiveActingUser();
        $userName = $curUser['name'];
        $userTitle = $curUser['title'];
        $today = date('Y-m-d');

        $qRow = null;
        if ($this->isDbConnected) {
            $qRes = mysqli_query($this->db, "SELECT * FROM tbl_quotations_v2 WHERE id = $id");
            if ($qRes) $qRow = mysqli_fetch_assoc($qRes);
        } else {
            $quotes = $this->getJsonQuotations();
            foreach ($quotes as $q) {
                if ($q['id'] == $id) {
                    $qRow = $q;
                    break;
                }
            }
        }

        if (!$qRow) {
            echo json_encode(["status" => "error", "message" => "Quotation not found"]);
            return;
        }

        $seqNo = (int)($qRow['seq_no'] ?? 0);
        $revNo = (int)($qRow['rev_no'] ?? 0);
        $varNo = (int)($qRow['variation_no'] ?? 0);
        $qLabel = ($varNo ? "V" . $varNo : "") . ($revNo ? ($varNo ? "/" : "") . "R" . $revNo : "") ?: "Original";
        $currentStatus = $qRow['status'];

        $activity = json_decode($qRow['activity_json'] ?? '', true);
        if (!is_array($activity)) $activity = [];

        // Rule 6: Reopen approval (Administrator permission required)
        if ($action === 'reopen' || (in_array($currentStatus, ['Approved', 'Void']) && in_array(strtolower($status), ['draft', 'pending', 'pending approval']))) {
            if (empty($curUser['is_admin'])) {
                echo json_encode(["status" => "error", "message" => "Permission denied. Only Administrator can reopen an approved or voided quotation."]);
                return;
            }
            if (empty($reason)) {
                echo json_encode(["status" => "error", "message" => "A reason is required to reopen a quotation (logged for auditing)."]);
                return;
            }

            $prevApprover = !empty($qRow['approval_by']) ? $qRow['approval_by'] : "Client representative";
            $statusLabel = $currentStatus === 'Void' ? "void status" : "approval by {$prevApprover}";
            $logMsg = "Reopened by Administrator. Previous {$statusLabel} cleared. Reason: {$reason}";
            $activity[] = ["d" => date('Y-m-d H:i:s'), "u" => $userName, "t" => $logMsg];
            $actJson = json_encode($activity);
            $fullRemark = "Reopened by Admin: " . $reason;

            if ($this->isDbConnected) {
                $escRem = mysqli_real_escape_string($this->db, $fullRemark);
                $escAct = mysqli_real_escape_string($this->db, $actJson);
                mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                    status = 'Draft',
                    is_autosaved = 0,
                    approval_by = NULL,
                    approval_date = NULL,
                    client_po_ref = '',
                    approval_attachment = '',
                    remark = '$escRem',
                    activity_json = '$escAct'
                    WHERE id = $id");
            } else {
                foreach ($quotes as &$q) {
                    if ($q['id'] == $id) {
                        $q['status'] = 'Draft';
                        $q['is_autosaved'] = 0;
                        $q['appr'] = null;
                        $q['approval_by'] = null;
                        $q['approval_date'] = null;
                        $q['client_po_ref'] = '';
                        $q['remark'] = $fullRemark;
                        $q['activity'] = $activity;
                        break;
                    }
                }
                unset($q);
                $this->saveJsonQuotations($quotes);
            }

            echo json_encode([
                "status" => "success",
                "message" => "Approval reopened by Administrator. Status returned to Draft for authorized editing.",
                "id" => $id,
                "new_status" => "Draft",
                "remark" => $fullRemark
            ]);
            return;
        }

        // Prevent unauthorized status modification of an Approved quote
        if ($currentStatus === 'Approved' && strtolower($status) !== 'completed') {
            echo json_encode(["status" => "error", "message" => "This quotation is Approved and locked. It cannot be modified without Administrator reopening."]);
            return;
        }

        // Rule 4: Mark Approved & Void other open revisions in group
        if (strtolower($status) === 'approved') {
            if (empty($approvedBy)) {
                echo json_encode(["status" => "error", "message" => "Client approver name is mandatory to confirm approval."]);
                return;
            }
            $approvalAttachment = '';
            if (!empty($_FILES['approval_attachment']['name'])) {
                $file = $_FILES['approval_attachment'];
                if ($file['error'] === UPLOAD_ERR_OK) {
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'xls', 'xlsx'];
                    if (!in_array($ext, $allowed)) {
                        echo json_encode(["status" => "error", "message" => "Invalid file format. Allowed: PDF, PNG, JPG, DOC, DOCX, XLS, XLSX"]);
                        return;
                    }
                    $uploadDir = __DIR__ . '/../../uploads/quotation_approvals/';
                    if (!is_dir($uploadDir)) {
                        @mkdir($uploadDir, 0777, true);
                    }
                    $safeName = 'po_' . $id . '_' . time() . '.' . $ext;
                    if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
                        $approvalAttachment = 'uploads/quotation_approvals/' . $safeName;
                    }
                }
            }
            $appDate = !empty($approvedOn) ? $approvedOn : $today;
            $logMsg = "Approved by " . $approvedBy . ($clientPo ? " (" . $clientPo . ")" : "") . ($approvalAttachment ? " [Doc: " . basename($approvalAttachment) . "]" : "");
            $activity[] = ["d" => date('Y-m-d H:i:s'), "u" => $userName, "t" => $logMsg];
            $actJson = json_encode($activity);

            if ($this->isDbConnected) {
                $escBy = mysqli_real_escape_string($this->db, $approvedBy);
                $escDate = mysqli_real_escape_string($this->db, $appDate);
                $escPo = mysqli_real_escape_string($this->db, $clientPo);
                $escAtt = mysqli_real_escape_string($this->db, $approvalAttachment);
                $escAct = mysqli_real_escape_string($this->db, $actJson);

                mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                    status = 'Approved',
                    approval_by = '$escBy',
                    approval_date = '$escDate',
                    client_po_ref = '$escPo',
                    approval_attachment = '$escAtt',
                    rejection_reason = '',
                    remark = '',
                    activity_json = '$escAct'
                    WHERE id = $id");

                // Void other open (Pending/Draft) revisions in the same sequence and variation
                if ($seqNo > 0) {
                    $voidReason = "Voided: " . $qLabel . " was approved";
                    $escVoidRem = mysqli_real_escape_string($this->db, $voidReason);

                    $otherRes = mysqli_query($this->db, "SELECT id, activity_json FROM tbl_quotations_v2 
                        WHERE seq_no = $seqNo AND variation_no = $varNo AND id != $id AND status IN ('Pending', 'Pending approval', 'Draft')");
                    if ($otherRes) {
                        while ($oth = mysqli_fetch_assoc($otherRes)) {
                            $othId = (int)$oth['id'];
                            $othAct = json_decode($oth['activity_json'] ?? '', true);
                            if (!is_array($othAct)) $othAct = [];
                            $othAct[] = ["d" => $today, "u" => "System", "t" => $voidReason];
                            $escOthAct = mysqli_real_escape_string($this->db, json_encode($othAct));
                            mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                                status = 'Void',
                                remark = '$escVoidRem',
                                activity_json = '$escOthAct'
                                WHERE id = $othId");
                        }
                    }
                }
            } else {
                foreach ($quotes as &$q) {
                    if ($q['id'] == $id) {
                        $q['status'] = 'Approved';
                        $q['approval_attachment'] = $approvalAttachment;
                        $q['appr'] = ["by" => $approvedBy, "on" => $appDate, "po" => $clientPo, "attachment" => $approvalAttachment];
                        $q['remark'] = '';
                        $q['activity'] = $activity;
                    } elseif (($q['seq_no'] ?? null) == $seqNo && ($q['variation_no'] ?? 0) == $varNo && in_array($q['status'] ?? '', ['Pending', 'Pending approval', 'Draft'])) {
                        $q['status'] = 'Void';
                        $q['remark'] = "Voided: " . $qLabel . " was approved";
                    }
                }
                unset($q);
                $this->saveJsonQuotations($quotes);
            }

            echo json_encode([
                "status" => "success",
                "message" => "Quotation approved and locked. Other open revisions in this group were voided.",
                "id" => $id,
                "new_status" => "Approved",
                "remark" => "",
                "appr" => ["by" => $approvedBy, "on" => $appDate, "po" => $clientPo, "attachment" => $approvalAttachment]
            ]);
            return;
        }

        // Rule 7: Not approved
        if (strtolower($status) === 'not approved' || strtolower($status) === 'rejected') {
            if (empty($reason)) {
                echo json_encode(["status" => "error", "message" => "A reason is required when marking not approved."]);
                return;
            }
            $fullRemark = $reason . ($remark ? " – " . $remark : "");
            $logMsg = "Not approved: " . $fullRemark;
            $activity[] = ["d" => date('Y-m-d H:i:s'), "u" => $userName, "t" => $logMsg];
            $actJson = json_encode($activity);

            if ($this->isDbConnected) {
                $escReason = mysqli_real_escape_string($this->db, $reason);
                $escRem = mysqli_real_escape_string($this->db, $fullRemark);
                $escAct = mysqli_real_escape_string($this->db, $actJson);

                mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                    status = 'Not approved',
                    rejection_reason = '$escReason',
                    remark = '$escRem',
                    activity_json = '$escAct'
                    WHERE id = $id");
            } else {
                foreach ($quotes as &$q) {
                    if ($q['id'] == $id) {
                        $q['status'] = 'Not approved';
                        $q['rejection_reason'] = $reason;
                        $q['remark'] = $fullRemark;
                        $q['activity'] = $activity;
                        break;
                    }
                }
                unset($q);
                $this->saveJsonQuotations($quotes);
            }

            echo json_encode([
                "status" => "success",
                "message" => "Quotation marked as Not approved",
                "id" => $id,
                "new_status" => "Not approved",
                "remark" => $fullRemark
            ]);
            return;
        }

        // Void quotation (Requires mandatory reason / remark, logged in activity)
        if (strtolower($status) === 'void' || $action === 'void') {
            if (empty($reason)) {
                echo json_encode(["status" => "error", "message" => "A remark / reason is required to void the quotation."]);
                return;
            }
            $fullRemark = "Voided: " . $reason;
            $logMsg = "Marked as Void by " . $userName . ". Remark: " . $reason;
            $activity[] = ["d" => date('Y-m-d H:i:s'), "u" => $userName, "t" => $logMsg];
            $actJson = json_encode($activity);

            if ($this->isDbConnected) {
                $escRem = mysqli_real_escape_string($this->db, $fullRemark);
                $escAct = mysqli_real_escape_string($this->db, $actJson);
                mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                    status = 'Void',
                    remark = '$escRem',
                    activity_json = '$escAct'
                    WHERE id = $id");
            } else {
                foreach ($quotes as &$q) {
                    if ($q['id'] == $id) {
                        $q['status'] = 'Void';
                        $q['remark'] = $fullRemark;
                        $q['activity'] = $activity;
                        break;
                    }
                }
                unset($q);
                $this->saveJsonQuotations($quotes);
            }

            echo json_encode([
                "status" => "success",
                "message" => "Quotation marked as Void",
                "id" => $id,
                "new_status" => "Void",
                "remark" => $fullRemark
            ]);
            return;
        }

        // Other status update (e.g. Void or Draft)
        $escSt = $status;
        $escRem = $remark;
        if ($this->isDbConnected) {
            $escSt = mysqli_real_escape_string($this->db, $status);
            $escRem = mysqli_real_escape_string($this->db, $remark);
            mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET status = '$escSt', remark = '$escRem' WHERE id = $id");
        } else {
            foreach ($quotes as &$q) {
                if ($q['id'] == $id) {
                    $q['status'] = $status;
                    $q['remark'] = $remark;
                    break;
                }
            }
            unset($q);
            $this->saveJsonQuotations($quotes);
        }

        echo json_encode([
            "status" => "success",
            "message" => "Quotation status updated to " . $status,
            "id" => $id,
            "new_status" => $status,
            "remark" => $remark
        ]);
    }

    private function markCompleted()
    {
        $id = (int)$this->getInputParam('id', 0);
        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid quotation ID"]);
            return;
        }

        $curUser = $this->getEffectiveActingUser();
        $userName = $curUser['name'];
        $notes = trim((string)$this->getInputParam('completion_notes', ''));
        $compDate = trim((string)$this->getInputParam('completion_date', date('Y-m-d H:i:s')));
        if (strlen($compDate) === 10) {
            $compDate .= ' ' . date('H:i:s');
        }

        // Handle attachment file upload
        $attachmentPath = '';
        if (!empty($_FILES['completion_attachment']['name'])) {
            $file = $_FILES['completion_attachment'];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowed = ['pdf', 'png', 'jpg', 'jpeg', 'gif', 'doc', 'docx', 'xls', 'xlsx'];
                if (!in_array($ext, $allowed)) {
                    echo json_encode(["status" => "error", "message" => "Invalid file format. Allowed: PDF, PNG, JPG, DOCX, XLSX"]);
                    return;
                }
                $uploadDir = __DIR__ . '/../../uploads/quotation_completions/';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0777, true);
                }
                $safeName = 'comp_' . $id . '_' . time() . '.' . $ext;
                $targetFile = $uploadDir . $safeName;
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    $attachmentPath = 'uploads/quotation_completions/' . $safeName;
                }
            }
        }

        $qRow = null;
        if ($this->isDbConnected) {
            $qRes = mysqli_query($this->db, "SELECT * FROM tbl_quotations_v2 WHERE id = $id");
            if ($qRes) $qRow = mysqli_fetch_assoc($qRes);
        } else {
            $quotes = $this->getJsonQuotations();
            foreach ($quotes as $q) {
                if ($q['id'] == $id) { $qRow = $q; break; }
            }
        }

        if (!$qRow) {
            echo json_encode(["status" => "error", "message" => "Quotation not found"]);
            return;
        }

        if ($qRow['status'] !== 'Approved' && $qRow['status'] !== 'Completed') {
            echo json_encode(["status" => "error", "message" => "Only approved quotations can be marked as completed."]);
            return;
        }

        if (empty($attachmentPath) && !empty($qRow['completion_attachment'])) {
            $attachmentPath = $qRow['completion_attachment'];
        }

        $activity = json_decode($qRow['activity_json'] ?? '', true);
        if (!is_array($activity)) $activity = [];
        $todayStr = date('Y-m-d');
        $logMsg = "Work marked as Completed by {$userName}" . ($attachmentPath ? " with attachment (" . basename($attachmentPath) . ")" : "") . ($notes ? ". Notes: {$notes}" : "");
        $activity[] = ["d" => $todayStr, "u" => $userName, "t" => $logMsg];
        $actJson = json_encode($activity);

        if ($this->isDbConnected) {
            $escBy = mysqli_real_escape_string($this->db, $userName);
            $escDate = mysqli_real_escape_string($this->db, $compDate);
            $escNotes = mysqli_real_escape_string($this->db, $notes);
            $escAtt = mysqli_real_escape_string($this->db, $attachmentPath);
            $escAct = mysqli_real_escape_string($this->db, $actJson);

            $upd = mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                status = 'Completed',
                completion_date = '$escDate',
                completion_by = '$escBy',
                completion_notes = '$escNotes',
                completion_attachment = '$escAtt',
                activity_json = '$escAct'
                WHERE id = $id");

            if (!$upd) {
                echo json_encode(["status" => "error", "message" => "Failed to update quotation: " . mysqli_error($this->db)]);
                return;
            }
        } else {
            foreach ($quotes as &$q) {
                if ($q['id'] == $id) {
                    $q['status'] = 'Completed';
                    $q['completion_date'] = $compDate;
                    $q['completion_by'] = $userName;
                    $q['completion_notes'] = $notes;
                    $q['completion_attachment'] = $attachmentPath;
                    $q['activity'] = $activity;
                    break;
                }
            }
            unset($q);
            $this->saveJsonQuotations($quotes);
        }

        echo json_encode([
            "status" => "success",
            "message" => "Quotation marked as Completed successfully.",
            "id" => $id,
            "new_status" => "Completed",
            "completion_date" => $compDate,
            "completion_by" => $userName,
            "completion_notes" => $notes,
            "completion_attachment" => $attachmentPath
        ]);
    }

    private function reviveQuotation()
    {
        $id = (int)$this->getInputParam('id', 0);
        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid quotation ID"]);
            return;
        }

        $validityDays = (int)$this->getInputParam('validity_days', 30);
        if ($validityDays <= 0) $validityDays = 30;
        $resetDate = !empty($this->getInputParam('reset_date', 1));

        $curUser = $this->getEffectiveActingUser();
        $userName = $curUser['name'];
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');

        $qRow = null;
        if ($this->isDbConnected) {
            $qRes = mysqli_query($this->db, "SELECT * FROM tbl_quotations_v2 WHERE id = $id");
            if ($qRes) $qRow = mysqli_fetch_assoc($qRes);
        } else {
            $quotes = $this->getJsonQuotations();
            foreach ($quotes as $q) {
                if ($q['id'] == $id) { $qRow = $q; break; }
            }
        }

        if (!$qRow) {
            echo json_encode(["status" => "error", "message" => "Quotation not found"]);
            return;
        }

        if ($qRow['status'] !== 'Expired') {
            echo json_encode(["status" => "error", "message" => "Only expired quotations can be revived."]);
            return;
        }

        $activity = json_decode($qRow['activity_json'] ?? '', true);
        if (!is_array($activity)) $activity = [];
        $logMsg = "Quotation revived from Expired status by {$userName}. Validity: {$validityDays} days." . ($resetDate ? " Quotation date refreshed to {$today}." : "");
        $activity[] = ["d" => $today, "u" => $userName, "t" => $logMsg];
        $actJson = json_encode($activity);

        if ($this->isDbConnected) {
            $escBy = mysqli_real_escape_string($this->db, $userName);
            $escNow = mysqli_real_escape_string($this->db, $now);
            $escAct = mysqli_real_escape_string($this->db, $actJson);
            $dateClause = $resetDate ? ", quotation_date = '$today'" : "";

            $upd = mysqli_query($this->db, "UPDATE tbl_quotations_v2 SET 
                status = 'Pending approval',
                validity_days = $validityDays,
                revived_at = '$escNow',
                revived_by = '$escBy',
                remark = CONCAT(IF(remark IS NOT NULL AND remark != '', CONCAT(remark, ' | '), ''), 'Revived on $today'),
                activity_json = '$escAct'
                $dateClause
                WHERE id = $id");

            if (!$upd) {
                echo json_encode(["status" => "error", "message" => "Failed to revive quotation: " . mysqli_error($this->db)]);
                return;
            }
        } else {
            foreach ($quotes as &$q) {
                if ($q['id'] == $id) {
                    $q['status'] = 'Pending approval';
                    $q['validity_days'] = $validityDays;
                    $q['revived_at'] = $now;
                    $q['revived_by'] = $userName;
                    if ($resetDate) $q['quotation_date'] = $today;
                    $q['activity'] = $activity;
                    break;
                }
            }
            unset($q);
            $this->saveJsonQuotations($quotes);
        }

        echo json_encode([
            "status" => "success",
            "message" => "Quotation successfully revived and restored to Pending approval status.",
            "id" => $id,
            "new_status" => "Pending approval",
            "quotation_date" => $resetDate ? $today : ($qRow['quotation_date'] ?? $today),
            "validity_days" => $validityDays
        ]);
    }

    private function deleteDraft()
    {
        $id = (int)$this->getInputParam('id', 0);
        if ($id <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid draft ID"]);
            return;
        }
        $actUser = $this->getEffectiveActingUser();
        if (empty($actUser['is_admin'])) {
            echo json_encode(["status" => "error", "message" => "Permission denied. Only Administrator can delete draft quotations."]);
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

            if (in_array($q['status'], ['Pending', 'Pending approval', 'Approved', 'Not approved', 'Completed'])) {
                $users[$u]['sent']++;
                $sentExcl = max(0, (float)$q['subtotal_excl_vat'] - (float)($q['discount_amount'] ?? 0));
                $users[$u]['sent_excl_vat'] += $sentExcl;
                $users[$u]['sent_incl_vat'] += (float)$q['total_incl_vat'];

                if ($q['status'] === 'Approved') {
                    $users[$u]['approved']++;
                    $users[$u]['approved_incl_vat'] += (float)$q['total_incl_vat'];
                } elseif ($q['status'] === 'Not approved') {
                    $users[$u]['not_approved']++;
                } elseif ($q['status'] === 'Pending' || $q['status'] === 'Pending approval') {
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

    private function downloadImportTemplate()
    {
        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="thc_quotation_line_items_template.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        // Add UTF-8 BOM so Excel opens it with proper UTF-8 encoding
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['Sl No', 'Description', 'Quantity', 'Unit', 'Unit Price (BD)']);
        fputcsv($out, [1, 'Supply and installation of 2.0 TR Split AC unit including copper piping and brackets', 2, 'Set', '280.000']);
        fputcsv($out, [2, 'Deep cleaning, chemical washing and disinfection of evaporator and condenser coils', 2, 'No.', '35.000']);
        fputcsv($out, [3, 'Replacement of 45uF dual run capacitor and testing compressor load current', 1, 'No.', '18.500']);
        fputcsv($out, [4, 'Preventive maintenance and inspection visit of main distribution board (DB panels)', 1, 'Visit', '45.000']);
        fclose($out);
        exit;
    }

    private function parseImportItemsFile()
    {
        $rawRows = [];

        // Check if uploaded as file
        if (!empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $tmpFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'] ?? '';
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, ['csv', 'txt', 'tsv'])) {
                $handle = fopen($tmpFile, 'r');
                $firstLine = fgets($handle);
                rewind($handle);
                $delim = ',';
                if (strpos($firstLine, "\t") !== false) {
                    $delim = "\t";
                } elseif (strpos($firstLine, ';') !== false && strpos($firstLine, ',') === false) {
                    $delim = ';';
                }

                while (($row = fgetcsv($handle, 4096, $delim)) !== false) {
                    if (!empty(array_filter($row, function ($c) { return trim((string)$c) !== ''; }))) {
                        $rawRows[] = $row;
                    }
                }
                fclose($handle);
            }
        } elseif (!empty($_POST['content'])) {
            $lines = preg_split('/\r?\n/', trim($_POST['content']));
            foreach ($lines as $line) {
                if (trim($line) === '') continue;
                $delim = (strpos($line, "\t") !== false) ? "\t" : (strpos($line, ';') !== false && strpos($line, ',') === false ? ';' : ',');
                $rawRows[] = str_getcsv($line, $delim);
            }
        }

        if (empty($rawRows)) {
            echo json_encode(["status" => "error", "message" => "No readable line items found in file or pasted content"]);
            return;
        }

        $items = $this->extractItemsFromRawRows($rawRows);
        if (empty($items)) {
            echo json_encode(["status" => "error", "message" => "Could not extract valid line items. Please ensure columns include Description and Unit Price."]);
            return;
        }

        echo json_encode([
            "status" => "success",
            "count" => count($items),
            "items" => $items
        ]);
    }

    private function extractItemsFromRawRows($rawRows)
    {
        if (empty($rawRows)) return [];

        $colDesc = -1;
        $colQty = -1;
        $colUnit = -1;
        $colPrice = -1;

        $firstRow = $rawRows[0];
        $isHeader = false;

        foreach ($firstRow as $idx => $cell) {
            $c = strtolower(trim((string)$cell));
            if (preg_match('/desc|particular|scope|work|item/i', $c) && $colDesc === -1) {
                $colDesc = $idx;
                $isHeader = true;
            } elseif (preg_match('/qty|quantity|count|nos/i', $c) && $colQty === -1) {
                $colQty = $idx;
                $isHeader = true;
            } elseif (preg_match('/unit|uom|measure/i', $c) && $colUnit === -1) {
                $colUnit = $idx;
                $isHeader = true;
            } elseif (preg_match('/price|rate|amount|cost/i', $c) && $colPrice === -1) {
                $colPrice = $idx;
                $isHeader = true;
            }
        }

        $startIdx = $isHeader ? 1 : 0;
        $items = [];

        for ($i = $startIdx; $i < count($rawRows); $i++) {
            $row = $rawRows[$i];
            if (empty(array_filter($row, function ($c) { return trim((string)$c) !== ''; }))) {
                continue;
            }

            $desc = '';
            $qty = 1.0;
            $unit = 'Lumpsum';
            $price = 0.0;

            if ($colDesc !== -1) {
                $desc = trim((string)($row[$colDesc] ?? ''));
                if ($colQty !== -1 && isset($row[$colQty])) {
                    $qVal = (float)filter_var(trim((string)$row[$colQty]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    if ($qVal > 0) $qty = $qVal;
                }
                if ($colUnit !== -1 && isset($row[$colUnit]) && trim((string)$row[$colUnit]) !== '') {
                    $unit = trim((string)$row[$colUnit]);
                }
                if ($colPrice !== -1 && isset($row[$colPrice])) {
                    $cleanP = preg_replace('/[^0-9.]/', '', trim((string)$row[$colPrice]));
                    $price = (float)$cleanP;
                }
            } else {
                $cellCount = count($row);
                if ($cellCount >= 5) {
                    $desc = trim((string)($row[1] ?? ''));
                    $qty = (float)filter_var(trim((string)($row[2] ?? 1)), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: 1;
                    $unit = trim((string)($row[3] ?? 'Lumpsum')) ?: 'Lumpsum';
                    $price = (float)preg_replace('/[^0-9.]/', '', trim((string)($row[4] ?? 0)));
                } elseif ($cellCount == 4) {
                    if (is_numeric(trim((string)$row[0])) && !is_numeric(trim((string)$row[1]))) {
                        $desc = trim((string)$row[1]);
                        $qty = (float)filter_var(trim((string)$row[2]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: 1;
                        $price = (float)preg_replace('/[^0-9.]/', '', trim((string)$row[3]));
                    } else {
                        $desc = trim((string)$row[0]);
                        $qty = (float)filter_var(trim((string)$row[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: 1;
                        $unit = trim((string)$row[2]) ?: 'Lumpsum';
                        $price = (float)preg_replace('/[^0-9.]/', '', trim((string)$row[3]));
                    }
                } elseif ($cellCount == 3) {
                    $desc = trim((string)$row[0]);
                    $qty = (float)filter_var(trim((string)$row[1]), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) ?: 1;
                    $price = (float)preg_replace('/[^0-9.]/', '', trim((string)$row[2]));
                } elseif ($cellCount >= 1) {
                    $desc = trim((string)$row[0]);
                }
            }

            if ($desc === '') continue;

            $items[] = [
                'description' => $desc,
                'quantity' => $qty > 0 ? $qty : 1,
                'unit' => $unit !== '' ? $unit : 'Lumpsum',
                'unit_price' => $price >= 0 ? $price : 0,
                'total_price' => ($qty > 0 ? $qty : 1) * ($price >= 0 ? $price : 0)
            ];
        }

        return $items;
    }
}
}

$controller = new QuotationModuleController();
$controller->handleRequest();
