-- ==============================================================================
-- THC Facility Management: Quotation Module Incremental Migration Updates
-- Run this script on existing databases (e.g. portal.thcfm.com) to apply all
-- new schema updates, columns, starting sequence (9866), and settings.
-- Safe to execute repeatedly (idempotent).
-- ==============================================================================

-- 1. Create Settings table if not exists
CREATE TABLE IF NOT EXISTS `tbl_quotation_settings_v2` (
  `setting_key` VARCHAR(100) NOT NULL PRIMARY KEY,
  `setting_value` LONGTEXT NOT NULL,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Configure Quotation sequence numbering to commence from 9866
INSERT INTO `tbl_quotation_settings_v2` (`setting_key`, `setting_value`) 
VALUES ('quotation_starting_seq', '9866') 
ON DUPLICATE KEY UPDATE `setting_value` = IF(CAST(`setting_value` AS UNSIGNED) < 9866, '9866', `setting_value`);

-- 3. Create Units Master table if not exists & seed standard units
CREATE TABLE IF NOT EXISTS `tbl_quotation_units_master` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `unit_name` VARCHAR(50) NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unit_name` (`unit_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `tbl_quotation_units_master` (`unit_name`, `sort_order`) VALUES
('Lumpsum', 1), ('No.', 2), ('Nos', 3), ('Set', 4), ('Lot', 5), ('Job', 6), ('Pcs', 7),
('Trip', 8), ('Visit', 9), ('Hr', 10), ('Day', 11), ('Month', 12),
('m', 13), ('m²', 14), ('m³', 15), ('Kg', 16), ('Ltr', 17), ('Box', 18), ('Roll', 19), ('Pack', 20), ('Pair', 21);

-- 4. Upgrade tbl_quotations_v2 columns
-- (Add discount columns if not existing)
SET @has_discount = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'discount_amount');
SET @sql_discount = IF(@has_discount = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `discount_type` VARCHAR(20) NOT NULL DEFAULT \'amount\' AFTER `vat_rate`, ADD COLUMN `discount_value` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_type`, ADD COLUMN `discount_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `discount_value`', 
    'SELECT 1');
PREPARE stmt FROM @sql_discount; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add variation_no column if not existing)
SET @has_var = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'variation_no');
SET @sql_var = IF(@has_var = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `variation_no` INT(11) NOT NULL DEFAULT 0 AFTER `rev_no`', 
    'SELECT 1');
PREPARE stmt FROM @sql_var; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add internal_notes column if not existing)
SET @has_notes = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'internal_notes');
SET @sql_notes = IF(@has_notes = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `internal_notes` TEXT DEFAULT NULL AFTER `remark`', 
    'SELECT 1');
PREPARE stmt FROM @sql_notes; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add merge items and lump sum columns if not existing)
SET @has_merge = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'merge_items');
SET @sql_merge = IF(@has_merge = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `merge_items` TINYINT(1) NOT NULL DEFAULT 0 AFTER `discount_amount`, ADD COLUMN `merge_qty` TINYINT(1) NOT NULL DEFAULT 0 AFTER `merge_items`, ADD COLUMN `merged_lump_sum_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000 AFTER `merge_qty`', 
    'SELECT 1');
PREPARE stmt FROM @sql_merge; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add bullet_items column if not existing)
SET @has_bullet = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'bullet_items');
SET @sql_bullet = IF(@has_bullet = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `bullet_items` TINYINT(1) NOT NULL DEFAULT 0 AFTER `merged_lump_sum_price`', 
    'SELECT 1');
PREPARE stmt FROM @sql_bullet; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add user_phone and include_user_phone columns if not existing, or ensure DEFAULT 1)
SET @has_phone = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'user_phone');
SET @sql_phone = IF(@has_phone = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `user_phone` VARCHAR(50) DEFAULT \'\' AFTER `user_designation`, ADD COLUMN `include_user_phone` TINYINT(1) NOT NULL DEFAULT 1 AFTER `user_phone`', 
    'ALTER TABLE `tbl_quotations_v2` ALTER COLUMN `include_user_phone` SET DEFAULT 1');
PREPARE stmt FROM @sql_phone; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Ensure all existing quotations display sender phone by default
UPDATE `tbl_quotations_v2` SET `include_user_phone` = 1 WHERE `include_user_phone` = 0;

-- (Add approval fields if not existing)
SET @has_appr = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'approval_by');
SET @sql_appr = IF(@has_appr = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `approval_by` VARCHAR(255) DEFAULT \'\' AFTER `status`, ADD COLUMN `approval_date` DATE DEFAULT NULL AFTER `approval_by`, ADD COLUMN `client_po_ref` VARCHAR(100) DEFAULT \'\' AFTER `approval_date`', 
    'SELECT 1');
PREPARE stmt FROM @sql_appr; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add completion fields if not existing)
SET @has_comp = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'completion_date');
SET @sql_comp = IF(@has_comp = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `completion_date` DATETIME DEFAULT NULL AFTER `approval_date`, ADD COLUMN `completion_by` VARCHAR(255) DEFAULT \'\' AFTER `completion_date`, ADD COLUMN `completion_notes` TEXT DEFAULT NULL AFTER `completion_by`, ADD COLUMN `completion_attachment` VARCHAR(500) DEFAULT \'\' AFTER `completion_notes`', 
    'SELECT 1');
PREPARE stmt FROM @sql_comp; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add validity_days and revival fields if not existing)
SET @has_validity = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'validity_days');
SET @sql_validity = IF(@has_validity = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `validity_days` INT(11) NOT NULL DEFAULT 30 AFTER `quotation_date`, ADD COLUMN `revived_at` DATETIME DEFAULT NULL AFTER `validity_days`, ADD COLUMN `revived_by` VARCHAR(255) DEFAULT \'\' AFTER `revived_at`', 
    'SELECT 1');
PREPARE stmt FROM @sql_validity; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Add activity_json audit column if not existing)
SET @has_act = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'activity_json');
SET @sql_act = IF(@has_act = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `activity_json` LONGTEXT DEFAULT NULL AFTER `remark`', 
    'SELECT 1');
PREPARE stmt FROM @sql_act; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- (Update status enum to support Pending approval and void/completed/expired transitions)
ALTER TABLE `tbl_quotations_v2` MODIFY COLUMN `status` ENUM('Draft','Pending','Pending approval','Approved','Not approved','Superseded','Void','Completed','Expired') NOT NULL DEFAULT 'Draft';
UPDATE `tbl_quotations_v2` SET `status` = 'Pending approval' WHERE `status` = 'Pending';

-- (Add is_autosaved column if not existing)
SET @has_auto = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'is_autosaved');
SET @sql_auto = IF(@has_auto = 0, 
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `is_autosaved` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`', 
    'SELECT 1');
PREPARE stmt FROM @sql_auto; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 5. Upgrade tbl_quotation_items_v2 columns
SET @has_itm_merge = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotation_items_v2' AND COLUMN_NAME = 'merge_with_prev');
SET @sql_itm_merge = IF(@has_itm_merge = 0, 
    'ALTER TABLE `tbl_quotation_items_v2` ADD COLUMN `merge_with_prev` TINYINT(1) NOT NULL DEFAULT 0 AFTER `total_price`', 
    'SELECT 1');
PREPARE stmt FROM @sql_itm_merge; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 6. Add optional PO / confirmation document attachment column
SET @has_appr_att = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_quotations_v2' AND COLUMN_NAME = 'approval_attachment');
SET @sql_appr_att = IF(@has_appr_att = 0,
    'ALTER TABLE `tbl_quotations_v2` ADD COLUMN `approval_attachment` VARCHAR(500) DEFAULT '''' AFTER `client_po_ref`',
    'SELECT 1');
PREPARE stmt FROM @sql_appr_att; EXECUTE stmt; DEALLOCATE PREPARE stmt;
