-- THC Facility Management - Quotation Module Schema (v2 Complete)
-- Aligned with THC Corporate Reporting Design System & Business Logic:
-- - AMC & Non-AMC Clients
-- - Quotation Numbering commencing at 9866: CG/THC/{user}/QTN/{seq}/{MMYY}[/V{var}][/R{rev}]
-- - Full Variation & Revision Chains (V1, V2... / R1, R2...)
-- - Detailed Line Items, Sub-item Merging, Bullet Items
-- - Multi-tier Discounting (Amount or Percentage)
-- - Dynamic Units Master Management
-- - Client Approval, PO Ref, Rejection Tracking, Completion, Revival, and Activity Logging
-- - Header / Footer & Stamp / Signature Configuration

SET FOREIGN_KEY_CHECKS=0;

-- 1. Main Quotations Table
CREATE TABLE IF NOT EXISTS `tbl_quotations_v2` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `seq_no` INT(11) DEFAULT NULL COMMENT 'Sequential quote number, commencing at 9866',
  `rev_no` INT(11) NOT NULL DEFAULT 0 COMMENT 'Revision number: 0 = Original, 1 = R1, etc.',
  `variation_no` INT(11) NOT NULL DEFAULT 0 COMMENT 'Variation number: 0 = Base, 1 = V1, etc.',
  `quotation_no` VARCHAR(100) DEFAULT '' COMMENT 'Formatted reference: CG/THC/MA/QTN/9866/1126',
  `is_amc` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = AMC client, 0 = Non-AMC client',
  `client_code` VARCHAR(50) DEFAULT '' COMMENT 'Client Code e.g. C0179',
  `client_name` VARCHAR(255) NOT NULL COMMENT 'M/S Client Name',
  `client_address` TEXT COMMENT 'Client physical/postal address',
  `contact_no` VARCHAR(100) DEFAULT '' COMMENT 'Client phone/telephone',
  `attention` VARCHAR(255) DEFAULT '' COMMENT 'Kind attention person',
  `subject` TEXT NOT NULL COMMENT 'Quotation subject',
  `quotation_date` DATE NOT NULL COMMENT 'Issue date of quotation',
  `validity_days` INT(11) NOT NULL DEFAULT 30 COMMENT 'Quotation validity period in days',
  `user_code` VARCHAR(50) NOT NULL COMMENT 'Estimator user initials/code e.g. MA, SKP, ADM',
  `user_name` VARCHAR(255) NOT NULL COMMENT 'Preparer / Estimator full name',
  `user_designation` VARCHAR(255) DEFAULT '' COMMENT 'Preparer designation title',
  `user_phone` VARCHAR(50) DEFAULT '' COMMENT 'Preparer contact/mobile phone number',
  `include_user_phone` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = Display mobile under name in PDF, 0 = Hide',
  `vat_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00 COMMENT 'VAT percentage: 10, 5, or 0',
  `discount_type` VARCHAR(20) NOT NULL DEFAULT 'amount' COMMENT 'Discount type: amount or percent',
  `discount_value` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Discount input value',
  `discount_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Calculated discount deduction (BD)',
  `subtotal_excl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Gross amount before discount and VAT',
  `vat_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Calculated VAT amount (BD)',
  `total_incl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Grand total amount including VAT (BD)',
  `merge_items` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = Merge line items into single lump sum rate',
  `merge_qty` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = Merge quantity into single 1 Lumpsum',
  `merged_lump_sum_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000 COMMENT 'Custom lump sum rate if overridden',
  `bullet_items` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = Display bullet points instead of numbers',
  `terms_json` LONGTEXT COMMENT 'JSON array of contractual terms & conditions clauses',
  `status` ENUM('Draft','Pending','Approved','Not approved','Superseded','Void','Completed','Expired') NOT NULL DEFAULT 'Draft',
  `approval_by` VARCHAR(255) DEFAULT '' COMMENT 'Client approver contact name',
  `approval_date` DATE DEFAULT NULL COMMENT 'Date client approved quotation',
  `client_po_ref` VARCHAR(100) DEFAULT '' COMMENT 'Client LPO / PO reference number',
  `completion_date` DATETIME DEFAULT NULL COMMENT 'Date work order / project completed',
  `completion_by` VARCHAR(255) DEFAULT '' COMMENT 'User who marked quotation completed',
  `completion_notes` TEXT DEFAULT NULL COMMENT 'Completion closing notes / sign-off',
  `completion_attachment` VARCHAR(500) DEFAULT '' COMMENT 'Attachment path for completion certificate',
  `revived_at` DATETIME DEFAULT NULL COMMENT 'Timestamp if reopened/revived from expired/void',
  `revived_by` VARCHAR(255) DEFAULT '' COMMENT 'User who revived quotation',
  `rejection_reason` VARCHAR(255) DEFAULT '' COMMENT 'Categorized reason if rejected by client',
  `remark` TEXT COMMENT 'Additional remarks / client feedback',
  `internal_notes` TEXT DEFAULT NULL COMMENT 'Private internal reference notes (never printed on PDF)',
  `activity_json` LONGTEXT DEFAULT NULL COMMENT 'JSON audit log array of state transitions',
  `created_by_id` INT(11) DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_seq_rev_var` (`seq_no`, `variation_no`, `rev_no`),
  KEY `idx_status` (`status`),
  KEY `idx_client_code` (`client_code`),
  KEY `idx_user_code` (`user_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Quotation Line Items Table
CREATE TABLE IF NOT EXISTS `tbl_quotation_items_v2` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` INT(11) NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 1,
  `description` TEXT NOT NULL,
  `quantity` DECIMAL(18,3) NOT NULL DEFAULT 1.000,
  `unit` VARCHAR(50) NOT NULL DEFAULT 'Lumpsum',
  `unit_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `total_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `merge_with_prev` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = Sub-item bundled into previous item rate',
  PRIMARY KEY (`item_id`),
  KEY `idx_quotation_id` (`quotation_id`),
  CONSTRAINT `fk_quotation_items_quotation` FOREIGN KEY (`quotation_id`) REFERENCES `tbl_quotations_v2` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Quotation Units Master Table
CREATE TABLE IF NOT EXISTS `tbl_quotation_units_master` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `unit_name` VARCHAR(50) NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit_name` (`unit_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Standard Units
INSERT IGNORE INTO `tbl_quotation_units_master` (`unit_name`, `sort_order`) VALUES
('Lumpsum', 1), ('No.', 2), ('Nos', 3), ('Set', 4), ('Lot', 5), ('Job', 6), ('Pcs', 7),
('Trip', 8), ('Visit', 9), ('Hr', 10), ('Day', 11), ('Month', 12),
('m', 13), ('m²', 14), ('m³', 15), ('Kg', 16), ('Ltr', 17), ('Box', 18), ('Roll', 19), ('Pack', 20), ('Pair', 21);

-- 4. Quotation Module Settings Table
CREATE TABLE IF NOT EXISTS `tbl_quotation_settings_v2` (
  `setting_key` VARCHAR(100) NOT NULL PRIMARY KEY,
  `setting_value` LONGTEXT NOT NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Starting Sequence Commencing from 9866
INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
VALUES ('quotation_starting_seq', '9866') 
ON DUPLICATE KEY UPDATE `setting_value` = IF(CAST(`setting_value` AS UNSIGNED) < 9866, '9866', `setting_value`);

-- Seed Default Footer Settings
INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`)
VALUES ('quotation_footer_config', '{"phone":"+973 17 100 190","email":"info@thc.com.bh","website":"www.thc.com.bh","cr_no":"88982-1","address_line1":"Level 14, Office 1403/1404, Bldg 155, Road 1703, Block 317","address_line2":"YBA Kanoo Tower, Diplomatic Area, Kingdom of Bahrain","bg_color":"#1e2560","show_badges":1,"badges_image":"global_assets/images/a.png","show_page_no":1,"show_ref_no":1,"doc_number":"CINQO/THC/QTN/01/2020/REV3"}')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

-- Seed Default Stamp & Signature Settings
INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`)
VALUES ('quotation_stamp_sign_config', '{"show_stamp":1,"show_signature":1,"show_user_phone":1,"company_stamp_url":"uploads/quotation_signatures/default_thc_stamp.png","default_signature_url":"uploads/quotation_signatures/default_signature.png","user_signatures":{},"user_phones":{"ADM":"+973 17 100 190","MA":"+973 3944 1015","RM":"+973 3728 3293","SKP":"+973 3689 8333"}}')
ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`);

SET FOREIGN_KEY_CHECKS=1;
