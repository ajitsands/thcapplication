-- THC Facility Management - Quotation Module Schema (v2)
-- Designed to support full concept workflow:
-- - AMC & Non-AMC Clients
-- - Quotation Numbering: CG/THC/{user}/QTN/{seq}/{MMYY}[/R{rev}]
-- - Full Revision History & Superseded State
-- - Detailed Line Items & Dynamic Terms
-- - Approval & Rejection Tracking with Reasons
-- - Performance Analytics

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `tbl_quotation_items_v2`;
DROP TABLE IF EXISTS `tbl_quotations_v2`;

CREATE TABLE IF NOT EXISTS `tbl_quotations_v2` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `seq_no` INT(11) DEFAULT NULL COMMENT 'Sequential quote number, e.g. 7065',
  `rev_no` INT(11) NOT NULL DEFAULT 0 COMMENT 'Revision number: 0 = Original, 1 = R1, etc.',
  `quotation_no` VARCHAR(100) DEFAULT '' COMMENT 'Formatted reference: CG/THC/MA/QTN/7065/0825',
  `is_amc` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = AMC client, 0 = Non-AMC client',
  `client_code` VARCHAR(50) DEFAULT '' COMMENT 'C0179 or NA-0001',
  `client_name` VARCHAR(255) NOT NULL,
  `client_address` TEXT,
  `contact_no` VARCHAR(100) DEFAULT '',
  `attention` VARCHAR(255) DEFAULT '',
  `subject` TEXT NOT NULL,
  `quotation_date` DATE NOT NULL,
  `user_code` VARCHAR(50) NOT NULL COMMENT 'User initials / code e.g. MA, FY, SH',
  `user_name` VARCHAR(255) NOT NULL COMMENT 'Preparer full name',
  `user_designation` VARCHAR(255) DEFAULT '' COMMENT 'Preparer title e.g. Operations Manager',
  `vat_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00 COMMENT 'VAT percentage: 10, 5, or 0',
  `subtotal_excl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `vat_amount` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `total_incl_vat` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `terms_json` LONGTEXT COMMENT 'JSON array of term clauses',
  `status` ENUM('Draft','Pending','Approved','Not approved','Superseded') NOT NULL DEFAULT 'Draft',
  `rejection_reason` VARCHAR(255) DEFAULT '' COMMENT 'Reason if rejected',
  `remark` TEXT COMMENT 'Additional remark or rejection note',
  `created_by_id` INT(11) DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_seq_rev` (`seq_no`, `rev_no`),
  KEY `idx_status` (`status`),
  KEY `idx_client_code` (`client_code`),
  KEY `idx_user_code` (`user_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tbl_quotation_items_v2` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` INT(11) NOT NULL,
  `sort_order` INT(11) NOT NULL DEFAULT 1,
  `description` TEXT NOT NULL,
  `quantity` DECIMAL(18,3) NOT NULL DEFAULT 1.000,
  `unit` VARCHAR(50) NOT NULL DEFAULT 'Lumpsum',
  `unit_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  `total_price` DECIMAL(18,3) NOT NULL DEFAULT 0.000,
  PRIMARY KEY (`item_id`),
  KEY `idx_quotation_id` (`quotation_id`),
  CONSTRAINT `fk_quotation_items_quotation` FOREIGN KEY (`quotation_id`) REFERENCES `tbl_quotations_v2` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS=1;

