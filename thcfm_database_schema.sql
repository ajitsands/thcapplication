-- ========================================================
-- THC Database Schema (Structure & Procedures)
-- Database: thcfm_application_db
-- ========================================================

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `feedback_options`;
CREATE TABLE `feedback_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `option_text` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `feedback_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `feedback_questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `feedback_questions`;
CREATE TABLE `feedback_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` text NOT NULL,
  `type` varchar(30) NOT NULL,
  `category_id` int(11) DEFAULT '0',
  `category` varchar(1000) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `feedback_responses`;
CREATE TABLE `feedback_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `amc_ref_no` varchar(25) DEFAULT NULL,
  `customer_name` varchar(25) NOT NULL,
  `customer_email` varchar(25) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `contract_type` varchar(200) NOT NULL,
  `customer_code` varchar(10) NOT NULL,
  `main_customer_name` varchar(25) NOT NULL,
  `default_date` datetime NOT NULL,
  `category_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `feedback_responses_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `feedback_questions` (`id`),
  CONSTRAINT `feedback_responses_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `feedback_options` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `feedback_text_responses`;
CREATE TABLE `feedback_text_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `response_text` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `amc_no` varchar(50) NOT NULL,
  `main_customer_code` varchar(200) DEFAULT NULL,
  `main_customer_name` varchar(1000) DEFAULT NULL,
  `customer_name` varchar(1000) DEFAULT NULL,
  `customer_phone` varchar(200) DEFAULT NULL,
  `customer_email` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(500) DEFAULT NULL,
  `default_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `module_permissions`;
CREATE TABLE `module_permissions` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `module_permission_name` varchar(300) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_status` varchar(10) NOT NULL DEFAULT 'Yes',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `module_permissions_bkp`;
CREATE TABLE `module_permissions_bkp` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `module_permission_name` varchar(300) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_status` varchar(10) NOT NULL DEFAULT 'Yes',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `class_name` varchar(200) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `parent_status` varchar(10) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `role_permissions_v1`;
CREATE TABLE `role_permissions_v1` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `sub_module_name` varchar(100) NOT NULL DEFAULT 'No',
  `module_name` varchar(500) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_amc_child`;
CREATE TABLE `tbl_amc_child` (
  `amc_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `amc_master_id` int(11) DEFAULT '0' COMMENT 'amc_master_id from tbl_amc_master',
  `amc_ref_no` varchar(100) DEFAULT 'NA',
  `category_id` int(11) DEFAULT '0' COMMENT 'category_id from tbl_category',
  `category_name` varchar(2000) DEFAULT 'NA' COMMENT 'category_name from tbl_category',
  `asset_type_id` int(11) DEFAULT '0' COMMENT 'asset_type_id from tbl_asset_type',
  `asset_type_name` varchar(2000) DEFAULT 'NA' COMMENT 'asset_type-name from tbl_asset_type',
  `asset_id` int(11) DEFAULT '0' COMMENT 'asset_id from tbl_assets',
  `asset_ref_no` varchar(200) DEFAULT 'NA' COMMENT 'asset_ref_no from tbl_assets',
  `amc_child_status` varchar(100) DEFAULT 'Active' COMMENT 'Active,Deacitve',
  `amc_service_report_image` varchar(2000) DEFAULT 'default.jpg',
  PRIMARY KEY (`amc_child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_amc_log`;
CREATE TABLE `tbl_amc_log` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `jsondata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `amc_ref_no` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `default_date` datetime NOT NULL,
  `event_type` varchar(500) NOT NULL,
  `ip_address` varchar(300) NOT NULL,
  `modules` varchar(500) NOT NULL,
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_amc_log_chk_1` CHECK (json_valid(`jsondata`))
) ENGINE=MyISAM AUTO_INCREMENT=377 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_amc_master`;
CREATE TABLE `tbl_amc_master` (
  `amc_id` int(11) NOT NULL AUTO_INCREMENT,
  `amc_ref_no` varchar(1000) DEFAULT 'NA' COMMENT 'unique',
  `customer_id` int(11) DEFAULT '0' COMMENT 'customer_id from tbl_customers',
  `customer_name` varchar(2000) DEFAULT 'NA' COMMENT 'customer_name from tbl_customers',
  `customer_code` varchar(200) DEFAULT 'NA' COMMENT 'customer_code from tbl_customers',
  `contract_type_id` int(11) DEFAULT '0' COMMENT 'contract_type_id from tbl_contract_types',
  `contract_type_name` varchar(2000) DEFAULT 'NA' COMMENT 'contract_type_name from tbl_contract_types',
  `amc_signed_date` date DEFAULT '0000-00-00',
  `amc_start_date` date DEFAULT '0000-00-00',
  `amc_end_date` date DEFAULT '0000-00-00' COMMENT 'validate amc_end_date  > amc_start_date',
  `amc_amount` decimal(18,3) DEFAULT '0.000',
  `total_amc_amount` decimal(18,3) NOT NULL,
  `amc_vat_perct` decimal(18,3) DEFAULT '0.000',
  `amc_vat_amt` decimal(18,3) DEFAULT '0.000',
  `is_rfp` varchar(100) DEFAULT 'No' COMMENT 'Yes,No',
  `amc_description` text,
  `amc_status` varchar(200) DEFAULT 'Active' COMMENT 'Active,Cancelled,Hold',
  `hold_description` text,
  `created_id` int(11) DEFAULT '0',
  `modified_id` int(11) NOT NULL DEFAULT '0',
  `cancelled_on` date DEFAULT '0000-00-00',
  `cancelled_description` text,
  `amc_parent_ref_no` varchar(200) DEFAULT '0' COMMENT 'when renewal amc_ref_no is maintained',
  `amc_parent_parent_ref_no` varchar(100) DEFAULT 'NA',
  `renewal_status` varchar(10) DEFAULT 'NO',
  `amc_attachment1` varchar(2000) DEFAULT 'default.jpg',
  `amc_attachment1_desc` varchar(2000) DEFAULT 'NA',
  `amc_attachment2` varchar(2000) DEFAULT 'default.jpg',
  `amc_attachment2_desc` varchar(2000) DEFAULT 'NA',
  `amc_attachment3` varchar(2000) DEFAULT 'default.jpg',
  `amc_attachment3_desc` varchar(2000) DEFAULT 'NA',
  `amc_renewal_attachment` varchar(1000) DEFAULT 'default.jpg',
  `amc_renewal_notes` varchar(2000) DEFAULT 'NA',
  PRIMARY KEY (`amc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=372 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_amc_services`;
CREATE TABLE `tbl_amc_services` (
  `amc_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `amc_visit_id` int(11) DEFAULT '0',
  `amc_child_id` int(11) DEFAULT '0',
  `amc_ref_code` varchar(2000) DEFAULT NULL,
  `asset_id` int(11) DEFAULT '0',
  `asset_code` varchar(2000) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `service_description` text,
  `amc_service_status` varchar(200) DEFAULT 'Pending',
  `tech_remarks` text,
  `tech_audio_file` varchar(2000) DEFAULT 'NA',
  `service_start_date_time` datetime DEFAULT NULL,
  `service_start_by_emp_code` varchar(200) DEFAULT 'NA',
  `service_complete_cancel_date_time` datetime DEFAULT NULL,
  `service_complete_cancel_by_emp_code` varchar(200) DEFAULT 'NA',
  PRIMARY KEY (`amc_service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_amc_subcontractors`;
CREATE TABLE `tbl_amc_subcontractors` (
  `amc_subcontractor_ids` int(11) NOT NULL AUTO_INCREMENT,
  `amc_id` int(11) NOT NULL,
  `amc_number` varchar(1000) NOT NULL,
  `subcontractor_id` int(11) NOT NULL,
  `subcontractor_name` varchar(500) NOT NULL,
  `contractor_description` text NOT NULL,
  `contract_amount` decimal(18,3) NOT NULL,
  `contract_vat` decimal(18,3) NOT NULL,
  `contract_total_amount` decimal(18,3) NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `file_name` varchar(1000) NOT NULL,
  `amc_subcontractor_status` varchar(100) NOT NULL DEFAULT 'Active',
  `contractor_deactive_reason` text NOT NULL,
  `contractor_deactive_date` date NOT NULL,
  PRIMARY KEY (`amc_subcontractor_ids`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_app_modules`;
CREATE TABLE `tbl_app_modules` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) NOT NULL,
  `module_classview_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_asset_schedule`;
CREATE TABLE `tbl_asset_schedule` (
  `asset_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_id` int(11) DEFAULT '0',
  `amc_id` int(11) DEFAULT '0',
  `amc_ref_no` varchar(100) DEFAULT 'NA',
  `asset_id` int(11) DEFAULT '0',
  `asset_code` varchar(100) DEFAULT 'NA',
  `building_id` int(11) DEFAULT '0',
  `building_name` varchar(100) DEFAULT 'NA',
  `location_id` int(11) DEFAULT '0',
  `location_name` varchar(100) DEFAULT 'NA',
  `category_id` int(11) DEFAULT '0',
  `category_name` varchar(100) DEFAULT 'NA',
  `asset_type_id` int(11) DEFAULT '0',
  `asset_type_name` varchar(100) DEFAULT 'NA',
  `customer_id` int(11) DEFAULT '0',
  `customer_code` varchar(100) DEFAULT 'NA',
  `customer_name` varchar(100) DEFAULT 'NA',
  `date_of_visit` date DEFAULT NULL,
  `time_of_visit` time DEFAULT NULL,
  `schedule_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`asset_schedule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_asset_type`;
CREATE TABLE `tbl_asset_type` (
  `asset_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_type_name` varchar(1000) DEFAULT 'NA',
  `category_id` int(11) DEFAULT '0' COMMENT 'category_id from tbl_category',
  `category_name` varchar(1000) DEFAULT 'NA' COMMENT 'category_name from tbl_category',
  `asset_type_status` varchar(50) DEFAULT 'Active' COMMENT 'Active, Deactive',
  PRIMARY KEY (`asset_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_assets`;
CREATE TABLE `tbl_assets` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_ref_no` varchar(200) DEFAULT 'NA' COMMENT 'Unique,Auto generate',
  `asset_category_id` int(11) DEFAULT '0' COMMENT 'category_id from tbl_category',
  `asset_category_name` varchar(2000) DEFAULT 'NA' COMMENT 'category_name from tbl_category',
  `asset_type_id` int(11) DEFAULT '0' COMMENT 'asset_type_id from tbl_asset_type',
  `asset_type_name` varchar(2000) DEFAULT 'NA' COMMENT 'asset_type_name from tbl_asset_type',
  `customer_id` int(11) DEFAULT '0' COMMENT 'customer_id from tbl_customers',
  `customer_code` varchar(200) DEFAULT 'NA' COMMENT 'customer_code from tbl_customers',
  `customer_name` varchar(2000) DEFAULT 'NA' COMMENT 'customer_name from tbl_customers',
  `location_id` int(11) DEFAULT '0',
  `location_code` varchar(100) DEFAULT NULL,
  `asset_location` varchar(2000) DEFAULT 'NA',
  `building_id` int(11) DEFAULT NULL,
  `building_code` varchar(500) DEFAULT '0',
  `asset_building` varchar(2000) DEFAULT 'NA',
  `zone_floor` varchar(1000) DEFAULT 'NA',
  `flat_area_code` varchar(100) NOT NULL DEFAULT 'NA',
  `room_no` varchar(1000) DEFAULT 'NA',
  `asset_sp_des` varchar(1000) DEFAULT 'NA',
  `asset_serial_no` varchar(2000) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `asset_brand` varchar(2000) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `asset_capacity` varchar(2000) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `asset_cost` decimal(18,3) DEFAULT '0.000' COMMENT 'Not Mandatory',
  `is_warentee` varchar(10) NOT NULL DEFAULT 'NA' COMMENT 'YES/NO/NA',
  `warentee_end_date` date DEFAULT NULL,
  `asset_attachment` varchar(2000) DEFAULT 'default.jpg' COMMENT 'Not Mandatory',
  `asset_description` text,
  `asset_status` varchar(100) DEFAULT 'Active' COMMENT 'Active,Deactive',
  `created_id` int(11) DEFAULT '0',
  `created_name` varchar(200) DEFAULT 'NA',
  `created_date` date DEFAULT NULL,
  `modified_id` int(11) DEFAULT '0',
  `modified_name` varchar(200) DEFAULT 'NA',
  `modified_date` date DEFAULT NULL,
  `amc_ref_no` varchar(500) DEFAULT 'NA',
  `amc_renewal_ref_no` varchar(500) DEFAULT 'NA',
  `amc_start_date` date DEFAULT NULL,
  `amc_end_date` date DEFAULT NULL,
  `amc_renewal_start_date` date DEFAULT NULL,
  `amc_renewal_end_date` date DEFAULT NULL,
  PRIMARY KEY (`asset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_building`;
CREATE TABLE `tbl_building` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_code` varchar(500) DEFAULT NULL,
  `building_name` varchar(500) DEFAULT NULL,
  `building_address` text,
  `building_status` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=377 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(1000) DEFAULT 'NA',
  `category_status` varchar(50) DEFAULT 'Active' COMMENT 'Active, Deactive',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_contract_types`;
CREATE TABLE `tbl_contract_types` (
  `contract_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `contract_type_name` varchar(2000) NOT NULL DEFAULT 'NA',
  `contract_type_status` varchar(100) NOT NULL DEFAULT 'Active' COMMENT 'Active, Deactive',
  PRIMARY KEY (`contract_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_customer_feedback`;
CREATE TABLE `tbl_customer_feedback` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_type` varchar(1000) NOT NULL,
  `question_name` varchar(1000) NOT NULL,
  `q1` varchar(200) NOT NULL,
  `q2` varchar(200) NOT NULL,
  `q3` varchar(200) NOT NULL,
  `q4` varchar(200) NOT NULL,
  `q5` varchar(200) NOT NULL,
  `q6` varchar(200) NOT NULL,
  `question_status` varchar(100) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_customer_feedback_details`;
CREATE TABLE `tbl_customer_feedback_details` (
  `customer_feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_number` varchar(500) NOT NULL,
  `customer_name` varchar(500) NOT NULL,
  `customer_email` varchar(500) NOT NULL,
  `customer_phone` varchar(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `feedback` varchar(11) NOT NULL,
  `amc_ref_no` varchar(500) NOT NULL,
  `main_customer_code` varchar(1000) NOT NULL,
  `main_customer_name` varchar(1000) NOT NULL,
  `contract_type` varchar(500) NOT NULL,
  `default_date` datetime NOT NULL,
  PRIMARY KEY (`customer_feedback_id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_customer_location`;
CREATE TABLE `tbl_customer_location` (
  `customer_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customer_code` varchar(1000) DEFAULT '0',
  `customer_name` varchar(1000) NOT NULL,
  `location_id` int(11) NOT NULL,
  `location_name` varchar(1000) NOT NULL,
  `location_code` varchar(500) NOT NULL,
  `building_id` int(11) NOT NULL,
  `building_name` varchar(1000) NOT NULL,
  `building_code` varchar(100) NOT NULL DEFAULT '0000',
  `building_address` varchar(1000) NOT NULL DEFAULT 'NA',
  `building_image` varchar(2000) DEFAULT 'default.jpg',
  `contact_person_name` varchar(1000) NOT NULL DEFAULT 'NA',
  `contact_person_no` varchar(100) NOT NULL DEFAULT 'NA',
  `customer_location_status` varchar(50) NOT NULL,
  PRIMARY KEY (`customer_location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_customer_payments`;
CREATE TABLE `tbl_customer_payments` (
  `amc_payments_ids` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT '01',
  `ppm_cm` varchar(50) DEFAULT 'NA',
  `amc_id` int(11) DEFAULT '0',
  `amc_ref_no` varchar(100) DEFAULT '0',
  `ticket_id` int(11) DEFAULT '0',
  `ticket_ref_no` varchar(100) DEFAULT '0',
  `date_of_payment` date DEFAULT '0000-00-00',
  `invoice_ref_no` varchar(200) DEFAULT '0',
  `payable_amt` decimal(18,3) DEFAULT '0.000',
  `payable_total_amc_amnt` decimal(18,3) NOT NULL,
  `payable_vat_perct` decimal(18,2) DEFAULT '0.00',
  `payable_vat_amt` decimal(18,3) DEFAULT '0.000',
  `total_payable_amt` decimal(18,3) DEFAULT '0.000',
  `paid_amount` decimal(18,3) DEFAULT '0.000',
  `paid_vat_perct` decimal(18,2) DEFAULT '0.00',
  `paid_vat_amt` decimal(18,3) DEFAULT '0.000',
  `total_paid_amt` decimal(18,3) DEFAULT '0.000',
  `company_closing_entry` varchar(50) DEFAULT 'No',
  `description` text,
  `payment_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`amc_payments_ids`)
) ENGINE=MyISAM AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_customer_teams`;
CREATE TABLE `tbl_customer_teams` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `team_ref` varchar(500) COLLATE utf8mb4_general_ci DEFAULT '0',
  `customer_ids` int(11) DEFAULT '0',
  `employee_ids` int(11) DEFAULT NULL,
  `is_leader` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'No',
  `status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `tbl_customers`;
CREATE TABLE `tbl_customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(2000) DEFAULT 'NA' COMMENT 'Unique',
  `customer_password` varchar(100) DEFAULT '12345' COMMENT 'no user input, maintain default value',
  `customer_name` varchar(2000) NOT NULL DEFAULT 'NA',
  `customer_contact_no` varchar(200) NOT NULL DEFAULT 'NA',
  `customer_email_id` varchar(1000) NOT NULL DEFAULT 'NA' COMMENT 'not mandatory',
  `customer_po_box` varchar(100) NOT NULL DEFAULT 'NA',
  `customer_location` varchar(2000) NOT NULL DEFAULT 'NA' COMMENT 'The input is alternate contact number, not location',
  `customer_contact_person_name` varchar(2000) NOT NULL DEFAULT 'NA' COMMENT 'not mandatory',
  `customer_contact_person_no` varchar(100) DEFAULT 'NA' COMMENT 'not mandatory',
  `customer_cpr_cr_no` varchar(200) NOT NULL DEFAULT 'NA',
  `customer_vat_no` varchar(500) NOT NULL DEFAULT 'NA',
  `customer_address` text NOT NULL COMMENT 'not mandatory',
  `customer_description` text NOT NULL COMMENT 'not mandatory',
  `customer_status` varchar(100) NOT NULL DEFAULT 'Active' COMMENT 'Active, Deactive',
  `date_active` datetime DEFAULT NULL,
  `date_deactive` datetime DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_employee_attachments`;
CREATE TABLE `tbl_employee_attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT '0',
  `employee_code` varchar(100) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `original_file_name` varchar(255) DEFAULT NULL,
  `remarks` text,
  `status` varchar(20) DEFAULT 'Active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_employee_leave`;
CREATE TABLE `tbl_employee_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(100) DEFAULT NULL,
  `employee_name` varchar(100) DEFAULT NULL,
  `leave_type` varchar(100) DEFAULT 'NA',
  `leave_reason` text,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_employee_short_leave`;
CREATE TABLE `tbl_employee_short_leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employee_code` varchar(100) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date NOT NULL,
  `leave_duration` enum('Full Day','Half Day') NOT NULL,
  `leave_reason` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_employees`;
CREATE TABLE `tbl_employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_type_id` int(11) DEFAULT NULL COMMENT 'user_type_id from tbl_user_types',
  `employee_type_name` varchar(1000) DEFAULT 'NA' COMMENT 'user_type_name from tbl_user_types',
  `employee_code` varchar(100) DEFAULT 'NA' COMMENT 'Used as username to login',
  `employee_password` varchar(100) DEFAULT 'NA',
  `employee_name` varchar(2000) DEFAULT 'NA',
  `employee_contact_no` varchar(100) DEFAULT 'NA',
  `cpr_no` varchar(100) DEFAULT 'NA',
  `blood_group` varchar(100) DEFAULT 'NA',
  `passport_no` varchar(100) DEFAULT 'NA',
  `joining_date` date DEFAULT '0000-00-00',
  `cpr_expiry_date` date DEFAULT '0000-00-00',
  `visa_validity_on` date DEFAULT '0000-00-00',
  `is_driving_license` varchar(100) DEFAULT 'No' COMMENT 'Yes,No',
  `employee_email_id` varchar(200) DEFAULT 'NA',
  `employee_address` text,
  `employee_image` varchar(2000) DEFAULT 'default.jpg',
  `technician_type` varchar(1000) DEFAULT 'NA' COMMENT 'Floating,Resident/Stationed',
  `native_number` varchar(100) DEFAULT 'NA',
  `native_address` text,
  `visa_type` varchar(100) DEFAULT 'NA',
  `employee_status` varchar(100) DEFAULT 'Active',
  `emergency_contact_no` varchar(50) DEFAULT 'NA',
  PRIMARY KEY (`employee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=288 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_expertise`;
CREATE TABLE `tbl_expertise` (
  `expertise_id` int(11) NOT NULL AUTO_INCREMENT,
  `expertise_name` varchar(1000) DEFAULT NULL,
  `expertise_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`expertise_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_feedback_response_text`;
CREATE TABLE `tbl_feedback_response_text` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `form_number` int(11) NOT NULL,
  `response_text` text NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `amc_ref_no` varchar(25) NOT NULL,
  `main_customer_code` varchar(10) NOT NULL,
  `default_date` datetime NOT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_location`;
CREATE TABLE `tbl_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(500) NOT NULL,
  `location_code` varchar(100) NOT NULL DEFAULT '00',
  `location_status` varchar(50) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_login_logout_log`;
CREATE TABLE `tbl_login_logout_log` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `jsondata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(200) NOT NULL,
  `default_date` datetime NOT NULL,
  `event_type` varchar(500) NOT NULL,
  `ip_address` varchar(200) NOT NULL,
  `modules` varchar(500) NOT NULL,
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_login_logout_log_chk_1` CHECK (json_valid(`jsondata`))
) ENGINE=MyISAM AUTO_INCREMENT=3935 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_lpo_child`;
CREATE TABLE `tbl_lpo_child` (
  `lpo_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `lpo_master_id` int(11) NOT NULL,
  `lpo_ref_no` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `unit_price` decimal(18,3) NOT NULL,
  `total_price` decimal(18,3) NOT NULL,
  `tax` decimal(18,3) NOT NULL,
  `discount` decimal(18,3) NOT NULL,
  `grand_total` decimal(18,3) NOT NULL,
  PRIMARY KEY (`lpo_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_lpo_master`;
CREATE TABLE `tbl_lpo_master` (
  `lpo_master_id` int(11) NOT NULL AUTO_INCREMENT,
  `lpo_ref_no` varchar(100) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `vendor_name` varchar(200) DEFAULT NULL,
  `vendor_vat_no` varchar(200) DEFAULT NULL,
  `vendor_po` varchar(100) DEFAULT NULL,
  `vendor_tel` varchar(50) DEFAULT NULL,
  `vendor_fax` varchar(50) DEFAULT NULL,
  `quotation_ref_no` varchar(100) DEFAULT NULL,
  `lpo_date` date DEFAULT NULL,
  `subject` text,
  `terms_and_conditions` text,
  `prepared_by` varchar(100) DEFAULT NULL,
  `prepaired_id` int(11) NOT NULL,
  `checked_by` varchar(100) DEFAULT NULL,
  `checked_by_id` int(11) NOT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approved_by_id` int(11) NOT NULL,
  `lpo_status` varchar(50) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`lpo_master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_mateial_requisition`;
CREATE TABLE `tbl_mateial_requisition` (
  `requisition_id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_serial_no` varchar(100) DEFAULT NULL,
  `requisition_date` datetime DEFAULT NULL,
  `requisition_mode` varchar(50) DEFAULT NULL COMMENT 'AMC/TKT',
  `amc_tkt_ref_no` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `prepared_by` varchar(100) DEFAULT NULL,
  `prepared_by_id` int(11) DEFAULT NULL,
  `raised_by` varchar(100) DEFAULT NULL,
  `raised_by_id` int(11) DEFAULT NULL,
  `procurement_by` varchar(100) DEFAULT NULL,
  `procurement_by_id` int(11) DEFAULT NULL,
  `checked_by` varchar(100) DEFAULT NULL,
  `checked_by_id` int(11) DEFAULT NULL,
  `status` varchar(1000) DEFAULT 'Pending',
  PRIMARY KEY (`requisition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_modules`;
CREATE TABLE `tbl_modules` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(500) DEFAULT NULL,
  `module_status` varchar(100) DEFAULT 'Status',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_permissions`;
CREATE TABLE `tbl_permissions` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `role_name` varchar(1000) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `module_name` varchar(1000) DEFAULT NULL,
  `per_view` int(11) NOT NULL DEFAULT '0',
  `per_modify` int(11) NOT NULL DEFAULT '0',
  `per_export` int(11) NOT NULL DEFAULT '0',
  `per_reveal_price` int(11) NOT NULL DEFAULT '0',
  `status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_product_category`;
CREATE TABLE `tbl_product_category` (
  `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_name` varchar(2000) DEFAULT 'NA',
  `product_category_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`product_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_product_items`;
CREATE TABLE `tbl_product_items` (
  `product_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_item_name` varchar(2000) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_type_name` varchar(2000) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_category_name` varchar(2000) DEFAULT NULL,
  `item_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`product_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_product_master`;
CREATE TABLE `tbl_product_master` (
  `product_master_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_brand_name` varchar(2000) DEFAULT 'NA',
  `product_unit_rate` decimal(18,3) DEFAULT '0.000',
  `product_unit` varchar(500) DEFAULT NULL,
  `product_item_id` int(11) DEFAULT NULL,
  `product_item_name` varchar(2000) DEFAULT 'NA',
  `product_type_id` int(11) DEFAULT NULL,
  `product_type_name` varchar(2000) DEFAULT 'NA',
  `product_category_id` int(11) DEFAULT NULL,
  `product_category_name` varchar(2000) DEFAULT 'NA',
  `status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`product_master_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_product_type`;
CREATE TABLE `tbl_product_type` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(2000) DEFAULT 'NA',
  `product_category_id` int(11) DEFAULT NULL,
  `product_category_name` varchar(2000) DEFAULT 'NA',
  `product_type_status` varchar(50) DEFAULT 'Active',
  PRIMARY KEY (`product_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_project`;
CREATE TABLE `tbl_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(1000) DEFAULT NULL,
  `project_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_project_entries`;
CREATE TABLE `tbl_project_entries` (
  `project_entries_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `project_name` varchar(1000) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `location` varchar(2000) DEFAULT NULL,
  `place` varchar(2000) DEFAULT NULL,
  `parts` varchar(2000) DEFAULT NULL,
  `category` varchar(2000) DEFAULT NULL,
  `comments` varchar(2000) DEFAULT NULL,
  `priority` varchar(200) DEFAULT NULL,
  `pic_name` varchar(2000) DEFAULT 'default.jpg',
  `inserted_date` date DEFAULT '0000-00-00',
  `inserted_id` int(11) DEFAULT NULL,
  `inserted_name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`project_entries_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_quotation_child`;
CREATE TABLE `tbl_quotation_child` (
  `quotation_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT '0',
  `quotation_ref_no` varchar(100) DEFAULT 'NA',
  `description` text,
  `quantity` decimal(18,3) DEFAULT '0.000',
  `unit` varchar(100) DEFAULT 'NA',
  `rate` decimal(18,3) DEFAULT '0.000',
  `total` decimal(18,3) DEFAULT '0.000',
  `discount` decimal(18,3) DEFAULT '0.000',
  `vat` decimal(18,3) DEFAULT '0.000',
  `grant_total` decimal(18,3) DEFAULT '0.000',
  PRIMARY KEY (`quotation_child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_quotation_child_riv`;
CREATE TABLE `tbl_quotation_child_riv` (
  `quotation_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT '0',
  `quotation_ref_no` varchar(500) DEFAULT NULL,
  `quotation_ref_no_riv` varchar(100) DEFAULT 'NA',
  `description` text,
  `quantity` decimal(18,3) DEFAULT '0.000',
  `unit` varchar(100) DEFAULT 'NA',
  `rate` decimal(18,3) DEFAULT '0.000',
  `total` decimal(18,3) DEFAULT '0.000',
  `discount` decimal(18,3) DEFAULT '0.000',
  `vat` decimal(18,3) DEFAULT '0.000',
  `grant_total` decimal(18,3) DEFAULT '0.000',
  PRIMARY KEY (`quotation_child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_quotation_master`;
CREATE TABLE `tbl_quotation_master` (
  `quotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_ref_no` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT '0',
  `customer_name` varchar(100) DEFAULT 'NA',
  `po_box` varchar(100) DEFAULT 'NA',
  `contact_no` varchar(100) DEFAULT 'NA',
  `address` varchar(2000) DEFAULT 'NA',
  `attention` varchar(500) DEFAULT 'NA',
  `date` date DEFAULT NULL,
  `subject` text,
  `vat_content` int(11) DEFAULT '5',
  `terms_and_condition` text,
  `created_by_id` int(11) DEFAULT '0',
  `created_by_name` varchar(100) DEFAULT 'NA',
  `approved_by_id` int(11) DEFAULT '0',
  `approved_by_name` varchar(100) DEFAULT 'NA',
  `quotation_status` varchar(100) DEFAULT 'Pending',
  PRIMARY KEY (`quotation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_quotation_master_riv`;
CREATE TABLE `tbl_quotation_master_riv` (
  `quotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_ref_no` varchar(500) DEFAULT NULL,
  `quotation_ref_no_riv` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT '0',
  `customer_name` varchar(100) DEFAULT 'NA',
  `po_box` varchar(100) DEFAULT 'NA',
  `contact_no` varchar(100) DEFAULT 'NA',
  `address` varchar(2000) DEFAULT 'NA',
  `attention` varchar(500) DEFAULT 'NA',
  `date` date DEFAULT NULL,
  `subject` text,
  `terms_and_condition` text,
  `created_by_id` int(11) DEFAULT '0',
  `created_by_name` varchar(100) DEFAULT 'NA',
  `approved_by_id` int(11) DEFAULT '0',
  `approved_by_name` varchar(100) DEFAULT 'NA',
  `quotation_status` varchar(100) DEFAULT 'Pending',
  PRIMARY KEY (`quotation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_requision_child`;
CREATE TABLE `tbl_requision_child` (
  `requisition_child_id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition_id` int(11) DEFAULT NULL,
  `asset_ref_no` varchar(500) DEFAULT 'NA',
  `amc_ticket_ids` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `location_name` varchar(200) DEFAULT 'NA',
  `building_id` int(11) DEFAULT '0',
  `building_name` varchar(500) DEFAULT NULL,
  `requisition_serial_no` varchar(100) DEFAULT NULL,
  `product_category_name` varchar(2000) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_type_name` varchar(2000) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_item_name` varchar(2000) DEFAULT NULL,
  `product_item_id` int(11) DEFAULT NULL,
  `product_unit_rate` decimal(18,3) DEFAULT NULL,
  `product_unit` varchar(200) DEFAULT NULL,
  `product_quantity` decimal(18,3) DEFAULT NULL,
  `product_brand` varchar(500) DEFAULT 'NA',
  `grant_total` decimal(18,3) DEFAULT NULL,
  PRIMARY KEY (`requisition_child_id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tbl_service_images`;
CREATE TABLE `tbl_service_images` (
  `service_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `amc_ticket` varchar(200) DEFAULT 'TKT',
  `service_image_name` varchar(2000) DEFAULT 'no_image.jpg',
  `ticket_amc_ref_code` varchar(2000) DEFAULT 'NA',
  `ticket_amc_id` int(11) DEFAULT NULL,
  `visit_id` int(11) DEFAULT '0',
  `asset_code` varchar(2000) DEFAULT 'NA',
  `uploaded_user_code` varchar(1000) DEFAULT '0',
  `uploaded_date_time` datetime DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`service_image_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6849 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_services`;
CREATE TABLE `tbl_services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_description` text,
  `category_id` int(11) DEFAULT '0' COMMENT 'category_id from tbl_category',
  `category_name` varchar(1000) DEFAULT 'NA' COMMENT 'category_name from tbl_category',
  `asset_type_id` int(11) DEFAULT '0' COMMENT 'asset_type_id from tbl_asset_type',
  `asset_type_name` varchar(1000) DEFAULT 'NA' COMMENT 'asset_type_name from tbl_asset_type',
  `service_status` varchar(50) DEFAULT 'Active' COMMENT 'Active,Deactive',
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_spare_parts_categories`;
CREATE TABLE `tbl_spare_parts_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tbl_spare_parts_issues`;
CREATE TABLE `tbl_spare_parts_issues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_item_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `issued_qty` int(11) NOT NULL,
  `issued_date` datetime NOT NULL,
  `issued_by_username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tbl_spare_parts_master`;
CREATE TABLE `tbl_spare_parts_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `excel_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `item_name` text,
  `description` text,
  `type_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tbl_spare_parts_request_items`;
CREATE TABLE `tbl_spare_parts_request_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tbl_spare_parts_requests`;
CREATE TABLE `tbl_spare_parts_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `workorder_id` int(11) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `tbl_subcontractors`;
CREATE TABLE `tbl_subcontractors` (
  `subcontractor_ids` int(11) NOT NULL AUTO_INCREMENT,
  `subcontractor_name` varchar(500) DEFAULT NULL,
  `subcontractor_cr_no` varchar(100) DEFAULT NULL,
  `subcontractor_address` varchar(2000) DEFAULT NULL,
  `subcontratcor_contact_person_name` varchar(500) DEFAULT NULL,
  `contact_no1` varchar(200) DEFAULT NULL,
  `contact_no2` varchar(200) DEFAULT NULL,
  `vendor_reg_form` varchar(1000) DEFAULT NULL,
  `subcontactor_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`subcontractor_ids`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_team`;
CREATE TABLE `tbl_team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `team_code` varchar(200) DEFAULT 'NA' COMMENT 'Should be unique',
  `team_name` varchar(1000) NOT NULL,
  `employee_id` int(11) DEFAULT NULL COMMENT 'employee_id from tbl_employees',
  `employee_code` varchar(200) DEFAULT 'NA' COMMENT 'employee_code from tbl_employees',
  `employee_name` varchar(2000) DEFAULT 'NA' COMMENT 'employee_code from tbl_employees',
  `employee_type_id` int(11) DEFAULT NULL COMMENT 'employee_type_id from tbl_employees',
  `employee_type_name` varchar(200) DEFAULT 'NA' COMMENT 'employee_type_name from tbl_employees',
  `expertise_name` varchar(1000) DEFAULT 'NA',
  `team_status` varchar(100) DEFAULT 'Active' COMMENT 'Active/ Deactive',
  PRIMARY KEY (`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_technician_expertise`;
CREATE TABLE `tbl_technician_expertise` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL COMMENT 'employee_id from tbl_employees',
  `employee_code` varchar(100) DEFAULT 'NA' COMMENT 'employee_code from tbl_employees',
  `employee_name` varchar(2000) DEFAULT 'NA' COMMENT 'employee_name from tbl_employees',
  `expertise_id` int(11) DEFAULT NULL COMMENT 'expertise_id from tbl_expertise',
  `expertise_name` varchar(1000) DEFAULT 'NA' COMMENT 'expertise_name from tbl_expertise',
  `status` varchar(100) DEFAULT 'Active' COMMENT 'Active / Deactive',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_technician_slots`;
CREATE TABLE `tbl_technician_slots` (
  `slot_ids` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT '0',
  `employee_code` varchar(1000) DEFAULT '0',
  `employee_name` varchar(2000) DEFAULT 'NA',
  `employee_contact_no` varchar(1000) DEFAULT '0',
  `slot_date` date DEFAULT NULL,
  `slot_1` varchar(500) DEFAULT '0',
  `slot_2` varchar(200) DEFAULT '0',
  `slot_3` varchar(200) DEFAULT '0',
  `slot_4` varchar(200) DEFAULT '0',
  `slot_5` varchar(200) DEFAULT '0',
  `slot_6` varchar(200) DEFAULT '0',
  `slot_7` varchar(200) DEFAULT '0',
  `slot_8` varchar(200) DEFAULT '0',
  `slot_9` varchar(200) DEFAULT '0',
  `slot_10` varchar(200) DEFAULT '0',
  `slot_11` varchar(200) DEFAULT '0',
  `slot_12` varchar(200) DEFAULT '0',
  `slot_13` varchar(200) DEFAULT '0',
  `slot_14` varchar(200) DEFAULT '0',
  `slot_15` varchar(200) DEFAULT '0',
  `slot_16` varchar(200) DEFAULT '0',
  `slot_17` varchar(200) DEFAULT '0',
  `slot_18` varchar(200) DEFAULT '0',
  `slot_19` varchar(200) DEFAULT '0',
  `slot_20` varchar(200) DEFAULT '0',
  `slot_21` varchar(200) DEFAULT '0',
  `slot_22` varchar(200) DEFAULT '0',
  `slot_23` varchar(200) DEFAULT '0',
  `slot_24` varchar(200) DEFAULT '0',
  `slot_status` varchar(500) DEFAULT 'Active',
  PRIMARY KEY (`slot_ids`)
) ENGINE=MyISAM AUTO_INCREMENT=4547 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_thc_details`;
CREATE TABLE `tbl_thc_details` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `thc_name` varchar(2000) DEFAULT 'NA',
  `vat_no` varchar(500) DEFAULT 'NA',
  `po_box` varchar(200) DEFAULT 'NA',
  `tel_no` varchar(200) DEFAULT 'NA',
  `fax_no` varchar(200) DEFAULT 'NA',
  `thc_address` text,
  `thc_email` varchar(1000) DEFAULT 'NA',
  `thc_website` varchar(2000) DEFAULT 'NA',
  `thc_logo` varchar(2000) DEFAULT 'default.jpg',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_ticket_services`;
CREATE TABLE `tbl_ticket_services` (
  `ticket_service_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT '0',
  `ticket_ref_code` varchar(2000) DEFAULT NULL,
  `asset_id` int(11) DEFAULT '0',
  `asset_code` varchar(2000) DEFAULT '0',
  `service_id` int(11) DEFAULT '0',
  `service_description` text,
  `ticket_service_status` varchar(200) DEFAULT 'Pending',
  `tech_remarks` text,
  `tech_audio_file` varchar(2000) DEFAULT 'NA',
  `service_start_date_time` datetime DEFAULT NULL,
  `service_start_by_emp_code` varchar(200) DEFAULT 'NA',
  `service_complete_cancel_date_time` datetime DEFAULT NULL,
  `service_complete_cancel_by_emp_code` varchar(200) DEFAULT 'NA',
  PRIMARY KEY (`ticket_service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8600 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_ticket_teams`;
CREATE TABLE `tbl_ticket_teams` (
  `ticket_team_ids` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `ticket_ref_no` varchar(1000) DEFAULT '0',
  `visit_id` int(11) DEFAULT '0',
  `customer_id` int(11) DEFAULT '0',
  `customer_code` varchar(500) DEFAULT 'NA',
  `customer_name` varchar(5000) DEFAULT 'NA',
  `location_id` int(11) DEFAULT NULL,
  `location_code` varchar(500) DEFAULT NULL,
  `location_name` varchar(5000) DEFAULT NULL,
  `building_id` int(11) DEFAULT NULL,
  `building_code` varchar(500) DEFAULT NULL,
  `building_name` varchar(5000) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visit_time` varchar(100) DEFAULT NULL,
  `additional_slots` int(11) DEFAULT '0',
  `employee_id` int(11) DEFAULT '0',
  `employee_code` varchar(1000) DEFAULT 'NA',
  `employee_name` varchar(5000) DEFAULT 'NA',
  `employee_contact_no` varchar(100) DEFAULT '00000000',
  `is_leader` varchar(100) DEFAULT 'No',
  `ticket_team_status` varchar(500) DEFAULT 'Active',
  `amc_ticket` varchar(100) DEFAULT 'TKT',
  `visit_start_time` time DEFAULT NULL,
  `is_attend` varchar(50) DEFAULT 'No',
  `attend_mark_by_empcode` varchar(100) DEFAULT '0',
  `attend_mark_date_time` datetime DEFAULT NULL,
  `escalated_status` varchar(100) DEFAULT 'No',
  PRIMARY KEY (`ticket_team_ids`)
) ENGINE=MyISAM AUTO_INCREMENT=14375 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_tickets`;
CREATE TABLE `tbl_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_ref_no` int(11) DEFAULT '0',
  `ticket_ref_code` varchar(1000) DEFAULT NULL,
  `book_year` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT '0',
  `customer_code` varchar(200) DEFAULT '0',
  `customer_name` varchar(2000) DEFAULT 'NA',
  `customer_contact_no` varchar(200) DEFAULT NULL,
  `location_id` int(11) DEFAULT '0',
  `location_code` varchar(200) DEFAULT '0',
  `location_name` varchar(2000) DEFAULT 'NA',
  `building_id` int(11) DEFAULT '0',
  `building_code` varchar(200) DEFAULT '0',
  `building_name` varchar(2000) DEFAULT 'NA',
  `category_id` int(11) DEFAULT '0',
  `category_name` varchar(2000) DEFAULT 'NA',
  `type_id` int(11) DEFAULT '0',
  `type_name` varchar(2000) DEFAULT 'NA',
  `asset_id` int(11) DEFAULT '0',
  `asset_code` varchar(200) DEFAULT '0',
  `additional_info` text,
  `complaints_description` text,
  `ticket_priority` varchar(1000) DEFAULT 'Normal',
  `quote_required` varchar(200) DEFAULT 'No',
  `service_request` varchar(1000) DEFAULT NULL,
  `job_category` varchar(1000) DEFAULT NULL,
  `quote_date` date DEFAULT '0000-00-00',
  `quote_ref_no` varchar(1000) DEFAULT NULL,
  `date_needed` date DEFAULT '0000-00-00',
  `ticket_image` varchar(5000) DEFAULT 'default.jpg',
  `ticket_image2` varchar(2000) DEFAULT 'default.jpg',
  `created_by_id` int(11) DEFAULT '0',
  `created_by_name` varchar(2000) DEFAULT 'NA',
  `cancelled_by_id` int(11) DEFAULT '0',
  `cancelled_by_name` varchar(2000) DEFAULT 'NA',
  `cancelled_reason` varchar(2000) DEFAULT 'NA',
  `created_date_time` datetime DEFAULT NULL,
  `cancelled_date_time` datetime DEFAULT NULL,
  `completed_by_id` int(11) DEFAULT '0',
  `completed_date_time` datetime DEFAULT NULL,
  `closed_by_id` int(11) DEFAULT '0',
  `closed_by_name` varchar(1000) DEFAULT 'NA',
  `closed_on` datetime DEFAULT NULL,
  `closed_reason` text,
  `closed_file` varchar(2000) DEFAULT 'default.jpg',
  `ticket_status` varchar(200) DEFAULT 'Opened',
  `service_report_image` varchar(2000) DEFAULT 'NA',
  `service_report_no` varchar(1000) DEFAULT 'NA',
  `service_report_upload_by_code` varchar(500) DEFAULT '0',
  `service_report_upload_date_time` datetime DEFAULT NULL,
  `foc` varchar(100) DEFAULT 'No',
  `escalated_status` varchar(100) DEFAULT 'No',
  `escalated_reason` text,
  `escalated_id` int(11) DEFAULT '0',
  `escalated_date_time` datetime DEFAULT NULL,
  `service_report_remarks` text,
  `entry_through` varchar(50) DEFAULT 'Offline',
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8479 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_user_types`;
CREATE TABLE `tbl_user_types` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(200) DEFAULT 'NA',
  `user_type_status` varchar(50) DEFAULT 'Active',
  PRIMARY KEY (`user_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_status` varchar(10) NOT NULL DEFAULT 'NA',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_vendors`;
CREATE TABLE `tbl_vendors` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(2000) DEFAULT 'NA',
  `vendor_tel_no` varchar(200) DEFAULT 'NA',
  `vendor_fax` varchar(200) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `vendor_vat_reg_no` varchar(200) DEFAULT 'NA',
  `vendor_po_box` varchar(255) DEFAULT NULL,
  `vendor_address` text,
  `vendor_contact_person_name` varchar(200) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `vendor_contact_person_no` varchar(2000) DEFAULT 'NA' COMMENT 'Not Mandatory',
  `vendor_email` varchar(1000) DEFAULT 'NA' COMMENT 'Not mandatory',
  `vendor_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tbl_visits`;
CREATE TABLE `tbl_visits` (
  `amc_visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `amc_tkt_id` int(11) DEFAULT '0',
  `amc_tkt_ref_no` varchar(200) DEFAULT 'NA',
  `amc_ticket` varchar(100) DEFAULT 'AMC' COMMENT 'AMC,TKT',
  `customer_id` int(11) DEFAULT '0',
  `customer_code` varchar(200) DEFAULT '0',
  `customer_name` varchar(2000) DEFAULT 'NA',
  `location_id` int(11) DEFAULT '0',
  `location_code` varchar(1000) DEFAULT '0',
  `location_name` varchar(2000) DEFAULT '0',
  `building_id` int(11) DEFAULT '0',
  `building_code` varchar(1000) DEFAULT '0',
  `building_name` varchar(2000) DEFAULT '0',
  `visit_mode` varchar(2000) DEFAULT 'NA',
  `date_of_visits` date DEFAULT '0000-00-00',
  `time_of_visit` varchar(100) DEFAULT '0',
  `additional_slots` int(11) DEFAULT '0',
  `amc_visit_status` varchar(100) DEFAULT 'Scheduled' COMMENT 'Scheduled,Assigned,Completed,Closed,Cancelled',
  `amc_schedule_color` varchar(200) DEFAULT NULL,
  `reschedule_by_id` int(11) DEFAULT NULL,
  `visit_start_time` time DEFAULT NULL,
  `amc_service_report_no` varchar(100) DEFAULT '0',
  `amc_service_report_image` varchar(2000) DEFAULT 'default.jpg',
  `amc_service_report_uploaded_by_code` varchar(200) DEFAULT '0',
  `amc_service_report_uploaded_date_time` datetime DEFAULT '0000-00-00 00:00:00',
  `amc_close_remarks` varchar(5000) DEFAULT 'NA',
  `amc_close_code` varchar(100) DEFAULT '0',
  `amc_close_date_time` datetime DEFAULT NULL,
  `escalated_status` varchar(100) DEFAULT 'No',
  PRIMARY KEY (`amc_visit_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8655 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `text` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user_roles_v1`;
CREATE TABLE `user_roles_v1` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

DROP VIEW IF EXISTS `view_amc_asset_details`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_amc_asset_details` AS select `tbl_amc_child`.`amc_child_id` AS `amc_child_id`,`tbl_amc_child`.`amc_master_id` AS `amc_master_id`,`tbl_amc_child`.`amc_ref_no` AS `amc_ref_no`,`tbl_amc_child`.`category_id` AS `category_id`,`tbl_amc_child`.`category_name` AS `category_name`,`tbl_amc_child`.`asset_type_id` AS `asset_type_id`,`tbl_amc_child`.`asset_type_name` AS `asset_type_name`,`tbl_amc_child`.`asset_ref_no` AS `asset_ref_no`,`tbl_amc_child`.`amc_child_status` AS `amc_child_status`,`tbl_assets`.`customer_id` AS `customer_id`,`tbl_assets`.`customer_code` AS `customer_code`,`tbl_assets`.`customer_name` AS `customer_name`,`tbl_assets`.`location_id` AS `location_id`,`tbl_assets`.`location_code` AS `location_code`,`tbl_assets`.`asset_location` AS `asset_location`,`tbl_assets`.`building_id` AS `building_id`,`tbl_assets`.`building_code` AS `building_code`,`tbl_assets`.`asset_building` AS `asset_building`,`tbl_assets`.`zone_floor` AS `zone_floor`,`tbl_assets`.`flat_area_code` AS `flat_area_code`,`tbl_assets`.`room_no` AS `room_no`,`tbl_assets`.`asset_sp_des` AS `asset_sp_des`,`tbl_assets`.`asset_serial_no` AS `asset_serial_no`,`tbl_assets`.`asset_brand` AS `asset_brand`,`tbl_assets`.`asset_capacity` AS `asset_capacity`,`tbl_assets`.`asset_cost` AS `asset_cost`,`tbl_assets`.`is_warentee` AS `is_warentee`,`tbl_assets`.`warentee_end_date` AS `warentee_end_date`,`tbl_assets`.`asset_attachment` AS `asset_attachment`,`tbl_assets`.`asset_description` AS `asset_description`,`tbl_assets`.`asset_status` AS `asset_status`,`tbl_assets`.`asset_id` AS `asset_id` from (`tbl_amc_child` join `tbl_assets` on((`tbl_amc_child`.`asset_id` = `tbl_assets`.`asset_id`)));

DROP VIEW IF EXISTS `view_amc_payment_report`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_amc_payment_report` AS select `tbl_customer_payments`.`amc_payments_ids` AS `amc_payments_ids`,`tbl_customer_payments`.`amc_id` AS `amc_id`,`tbl_customer_payments`.`date_of_payment` AS `date_of_payment`,`tbl_customer_payments`.`invoice_ref_no` AS `invoice_ref_no`,`tbl_customer_payments`.`payable_amt` AS `payable_amt`,`tbl_customer_payments`.`payable_vat_perct` AS `payable_vat_perct`,`tbl_customer_payments`.`payable_vat_amt` AS `payable_vat_amt`,`tbl_customer_payments`.`total_payable_amt` AS `total_payable_amt`,`tbl_customer_payments`.`paid_amount` AS `paid_amount`,`tbl_customer_payments`.`paid_vat_perct` AS `paid_vat_perct`,`tbl_customer_payments`.`paid_vat_amt` AS `paid_vat_amt`,`tbl_customer_payments`.`total_paid_amt` AS `total_paid_amt`,`tbl_customer_payments`.`company_closing_entry` AS `company_closing_entry`,`tbl_customer_payments`.`description` AS `description`,`tbl_customer_payments`.`payment_status` AS `payment_status`,`tbl_amc_master`.`amc_ref_no` AS `amc_ref_no`,`tbl_amc_master`.`customer_id` AS `customer_id`,`tbl_customers`.`customer_code` AS `customer_code`,`tbl_customers`.`customer_name` AS `customer_name`,`tbl_customers`.`customer_contact_no` AS `customer_contact_no`,`tbl_customers`.`customer_email_id` AS `customer_email_id`,`tbl_customers`.`customer_po_box` AS `customer_po_box`,`tbl_customers`.`customer_location` AS `customer_location`,`tbl_customers`.`customer_contact_person_name` AS `customer_contact_person_name`,`tbl_customers`.`customer_contact_person_no` AS `customer_contact_person_no`,`tbl_customers`.`customer_cpr_cr_no` AS `customer_cpr_cr_no`,`tbl_customers`.`customer_vat_no` AS `customer_vat_no`,`tbl_customers`.`customer_address` AS `customer_address`,`tbl_customers`.`customer_description` AS `customer_description`,`tbl_customers`.`customer_status` AS `customer_status`,`tbl_amc_master`.`contract_type_name` AS `contract_type_name`,`tbl_amc_master`.`amc_signed_date` AS `amc_signed_date`,`tbl_amc_master`.`amc_start_date` AS `amc_start_date`,`tbl_amc_master`.`amc_end_date` AS `amc_end_date`,`tbl_amc_master`.`amc_amount` AS `amc_amount`,`tbl_amc_master`.`amc_vat_perct` AS `amc_vat_perct`,`tbl_amc_master`.`amc_vat_amt` AS `amc_vat_amt`,`tbl_amc_master`.`is_rfp` AS `is_rfp`,`tbl_amc_master`.`amc_description` AS `amc_description`,`tbl_amc_master`.`amc_status` AS `amc_status`,`tbl_amc_master`.`hold_description` AS `hold_description`,`tbl_amc_master`.`cancelled_description` AS `cancelled_description`,`tbl_amc_master`.`amc_parent_ref_no` AS `amc_parent_ref_no`,`tbl_amc_master`.`amc_parent_parent_ref_no` AS `amc_parent_parent_ref_no`,`tbl_amc_master`.`renewal_status` AS `renewal_status`,`tbl_amc_master`.`amc_attachment1` AS `amc_attachment1`,`tbl_amc_master`.`amc_attachment1_desc` AS `amc_attachment1_desc`,`tbl_amc_master`.`amc_attachment2` AS `amc_attachment2`,`tbl_amc_master`.`amc_attachment2_desc` AS `amc_attachment2_desc`,`tbl_amc_master`.`amc_attachment3` AS `amc_attachment3`,`tbl_amc_master`.`amc_attachment3_desc` AS `amc_attachment3_desc` from (`tbl_customer_payments` left join (`tbl_amc_master` left join `tbl_customers` on((`tbl_amc_master`.`customer_id` = `tbl_customers`.`customer_id`))) on((`tbl_customer_payments`.`amc_id` = `tbl_amc_master`.`amc_id`)));

DROP VIEW IF EXISTS `view_amc_visits`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_amc_visits` AS select `tbl_visits`.`amc_visit_id` AS `amc_visit_id`,`tbl_visits`.`amc_tkt_id` AS `amc_tkt_id`,`tbl_amc_child`.`amc_master_id` AS `amc_master_id`,`tbl_amc_child`.`amc_ref_no` AS `amc_ref_no`,`tbl_amc_child`.`category_id` AS `category_id`,`tbl_amc_child`.`category_name` AS `category_name`,`tbl_amc_child`.`asset_type_id` AS `asset_type_id`,`tbl_amc_child`.`asset_type_name` AS `asset_type_name`,`tbl_amc_child`.`asset_id` AS `asset_id`,`tbl_amc_child`.`asset_ref_no` AS `asset_ref_no`,`tbl_amc_child`.`amc_child_status` AS `amc_child_status`,`tbl_visits`.`amc_tkt_ref_no` AS `amc_tkt_ref_no`,`tbl_visits`.`amc_close_date_time` AS `amc_close_date_time`,`tbl_visits`.`amc_ticket` AS `amc_ticket`,`tbl_visits`.`customer_id` AS `customer_id`,`tbl_visits`.`customer_code` AS `customer_code`,`tbl_visits`.`customer_name` AS `customer_name`,`tbl_visits`.`location_id` AS `location_id`,`tbl_visits`.`location_code` AS `location_code`,`tbl_visits`.`location_name` AS `location_name`,`tbl_visits`.`building_id` AS `building_id`,`tbl_visits`.`building_code` AS `building_code`,`tbl_visits`.`building_name` AS `building_name`,`tbl_visits`.`visit_mode` AS `visit_mode`,`tbl_visits`.`date_of_visits` AS `date_of_visits`,`tbl_visits`.`time_of_visit` AS `time_of_visit`,`tbl_visits`.`additional_slots` AS `additional_slots`,`tbl_visits`.`amc_visit_status` AS `amc_visit_status`,`tbl_visits`.`amc_schedule_color` AS `amc_schedule_color`,`tbl_visits`.`reschedule_by_id` AS `reschedule_by_id`,`tbl_visits`.`visit_start_time` AS `visit_start_time`,`tbl_visits`.`amc_service_report_no` AS `amc_service_report_no`,`tbl_visits`.`amc_service_report_image` AS `amc_service_report_image`,`tbl_visits`.`amc_service_report_uploaded_by_code` AS `amc_service_report_uploaded_by_code`,`tbl_visits`.`amc_service_report_uploaded_date_time` AS `amc_service_report_uploaded_date_time` from (`tbl_visits` left join `tbl_amc_child` on((`tbl_visits`.`amc_tkt_id` = `tbl_amc_child`.`amc_child_id`))) where (`tbl_visits`.`amc_ticket` = 'AMC');

DROP VIEW IF EXISTS `view_employee_expertiser_list`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_employee_expertiser_list` AS select `u`.`employee_id` AS `employee_id`,`u`.`employee_name` AS `employee_name`,`u`.`employee_type_id` AS `employee_type_id`,`u`.`employee_type_name` AS `employee_type_name`,`u`.`employee_code` AS `employee_code`,`u`.`employee_password` AS `employee_password`,`u`.`employee_contact_no` AS `employee_contact_no`,`u`.`employee_email_id` AS `employee_email_id`,`u`.`employee_address` AS `employee_address`,`u`.`employee_image` AS `employee_image`,`u`.`employee_status` AS `employee_status`,`u`.`cpr_no` AS `cpr_no`,`u`.`blood_group` AS `blood_group`,`u`.`passport_no` AS `passport_no`,`u`.`joining_date` AS `joining_date`,`u`.`cpr_expiry_date` AS `cpr_expiry_date`,`u`.`visa_validity_on` AS `visa_validity_on`,`u`.`is_driving_license` AS `is_driving_license`,`u`.`technician_type` AS `technician_type`,`u`.`native_number` AS `native_number`,`u`.`native_address` AS `native_address`,`u`.`visa_type` AS `visa_type`,group_concat(`us`.`expertise_id` separator ',') AS `expertise_id`,group_concat(`us`.`expertise_name` separator ',') AS `expertise_name` from (`tbl_employees` `u` left join `tbl_technician_expertise` `us` on((`u`.`employee_id` = `us`.`employee_id`))) group by `u`.`employee_id`,`u`.`employee_name`;

DROP VIEW IF EXISTS `view_modules_and_sub_mobules`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_modules_and_sub_mobules` AS select `tbl_app_modules`.`ids` AS `ids`,`tbl_app_modules`.`module_name` AS `module_name`,`module_permissions`.`ids` AS `subModuleID`,`module_permissions`.`module_permission_name` AS `module_permission_name` from (`tbl_app_modules` left join `module_permissions` on((`tbl_app_modules`.`ids` = `module_permissions`.`module_id`))) where (`module_permissions`.`module_status` = 'Yes') group by `tbl_app_modules`.`ids`,`tbl_app_modules`.`module_name`,`module_permissions`.`ids`,`module_permissions`.`module_permission_name`;

DROP VIEW IF EXISTS `view_ticket_team`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_ticket_team` AS select `tbl_ticket_teams`.`ticket_team_ids` AS `ticket_team_ids`,`tbl_ticket_teams`.`ticket_id` AS `ticket_id`,`tbl_ticket_teams`.`ticket_ref_no` AS `ticket_ref_no`,`tbl_ticket_teams`.`visit_id` AS `visit_id`,`tbl_tickets`.`book_year` AS `book_year`,`tbl_tickets`.`customer_id` AS `customer_id`,`tbl_tickets`.`customer_code` AS `customer_code`,`tbl_tickets`.`customer_name` AS `customer_name`,`tbl_tickets`.`location_id` AS `location_id`,`tbl_tickets`.`location_code` AS `location_code`,`tbl_tickets`.`location_name` AS `location_name`,`tbl_tickets`.`building_id` AS `building_id`,`tbl_tickets`.`building_code` AS `building_code`,`tbl_tickets`.`building_name` AS `building_name`,`tbl_tickets`.`category_id` AS `category_id`,`tbl_tickets`.`category_name` AS `category_name`,`tbl_tickets`.`type_id` AS `type_id`,`tbl_tickets`.`type_name` AS `type_name`,`tbl_tickets`.`asset_id` AS `asset_id`,`tbl_tickets`.`asset_code` AS `asset_code`,`tbl_tickets`.`additional_info` AS `additional_info`,`tbl_tickets`.`complaints_description` AS `complaints_description`,`tbl_tickets`.`ticket_priority` AS `ticket_priority`,`tbl_tickets`.`quote_required` AS `quote_required`,`tbl_tickets`.`service_request` AS `service_request`,`tbl_tickets`.`job_category` AS `job_category`,`tbl_tickets`.`quote_date` AS `quote_date`,`tbl_tickets`.`date_needed` AS `date_needed`,`tbl_tickets`.`ticket_image` AS `ticket_image`,`tbl_tickets`.`created_by_id` AS `created_by_id`,`tbl_tickets`.`created_by_name` AS `created_by_name`,`tbl_tickets`.`cancelled_by_id` AS `cancelled_by_id`,`tbl_tickets`.`cancelled_by_name` AS `cancelled_by_name`,`tbl_tickets`.`cancelled_reason` AS `cancelled_reason`,`tbl_tickets`.`created_date_time` AS `created_date_time`,`tbl_tickets`.`cancelled_date_time` AS `cancelled_date_time`,`tbl_tickets`.`ticket_status` AS `ticket_status`,`tbl_ticket_teams`.`visit_date` AS `visit_date`,`tbl_ticket_teams`.`visit_time` AS `visit_time`,`tbl_ticket_teams`.`additional_slots` AS `additional_slots`,`tbl_ticket_teams`.`employee_id` AS `employee_id`,`tbl_ticket_teams`.`employee_code` AS `employee_code`,`tbl_ticket_teams`.`employee_name` AS `employee_name`,`tbl_ticket_teams`.`is_leader` AS `is_leader`,`tbl_ticket_teams`.`ticket_team_status` AS `ticket_team_status` from (`tbl_ticket_teams` left join `tbl_tickets` on((`tbl_ticket_teams`.`ticket_id` = `tbl_tickets`.`ticket_id`)));

DROP VIEW IF EXISTS `view_ticket_visits`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_ticket_visits` AS select `tbl_visits`.`amc_visit_id` AS `amc_visit_id`,`tbl_visits`.`amc_tkt_id` AS `amc_tkt_id`,`tbl_visits`.`amc_tkt_ref_no` AS `amc_tkt_ref_no`,`tbl_visits`.`amc_ticket` AS `amc_ticket`,`tbl_visits`.`customer_id` AS `customer_id`,`tbl_visits`.`customer_code` AS `customer_code`,`tbl_visits`.`customer_name` AS `customer_name`,`tbl_visits`.`visit_mode` AS `visit_mode`,`tbl_visits`.`date_of_visits` AS `date_of_visits`,`tbl_visits`.`time_of_visit` AS `time_of_visit`,`tbl_visits`.`amc_visit_status` AS `amc_visit_status`,`tbl_visits`.`additional_slots` AS `additional_slots`,`tbl_visits`.`visit_start_time` AS `visit_start_time`,`tbl_tickets`.`ticket_id` AS `ticket_id`,`tbl_tickets`.`ticket_ref_no` AS `ticket_ref_no`,`tbl_tickets`.`ticket_ref_code` AS `ticket_ref_code`,`tbl_tickets`.`book_year` AS `book_year`,`tbl_tickets`.`location_id` AS `location_id`,`tbl_tickets`.`location_code` AS `location_code`,`tbl_tickets`.`location_name` AS `location_name`,`tbl_tickets`.`building_id` AS `building_id`,`tbl_tickets`.`building_code` AS `building_code`,`tbl_tickets`.`building_name` AS `building_name`,`tbl_tickets`.`category_id` AS `category_id`,`tbl_tickets`.`category_name` AS `category_name`,`tbl_tickets`.`type_id` AS `type_id`,`tbl_tickets`.`type_name` AS `type_name`,`tbl_tickets`.`asset_id` AS `asset_id`,`tbl_tickets`.`asset_code` AS `asset_code`,`tbl_tickets`.`additional_info` AS `additional_info`,`tbl_tickets`.`complaints_description` AS `complaints_description`,`tbl_tickets`.`ticket_priority` AS `ticket_priority`,`tbl_tickets`.`quote_required` AS `quote_required`,`tbl_tickets`.`created_by_id` AS `created_by_id`,`tbl_tickets`.`created_by_name` AS `created_by_name`,`tbl_tickets`.`cancelled_by_id` AS `cancelled_by_id`,`tbl_tickets`.`cancelled_by_name` AS `cancelled_by_name`,`tbl_tickets`.`cancelled_reason` AS `cancelled_reason`,`tbl_tickets`.`created_date_time` AS `created_date_time`,`tbl_tickets`.`cancelled_date_time` AS `cancelled_date_time`,`tbl_tickets`.`ticket_status` AS `ticket_status` from (`tbl_visits` left join `tbl_tickets` on(((`tbl_visits`.`amc_tkt_id` = `tbl_tickets`.`ticket_id`) and (`tbl_visits`.`amc_ticket` = 'TKT'))));

DROP PROCEDURE IF EXISTS `acc_proc_book_ticket`;
DELIMITER ;;
CREATE PROCEDURE `acc_proc_book_ticket`(IN `customer_id` INT, IN `customer_code` VARCHAR(200), IN `customer_name` VARCHAR(2000), IN `location_id` INT, IN `location_code` VARCHAR(200), IN `location_name` VARCHAR(2000), IN `building_id` INT, IN `building_code` VARCHAR(200), IN `building_name` VARCHAR(2000), IN `asset_id` INT, IN `asset_code` VARCHAR(200), IN `category_id` INT, IN `category_name` VARCHAR(1000), IN `type_id` INT, IN `type_name` VARCHAR(2000), IN `additional_info` TEXT, IN `complaint_description` TEXT, IN `priority_val` VARCHAR(200), IN `quote_val` VARCHAR(200), IN `ticket_ref_val` INT, IN `ticket_ref_code` VARCHAR(200), IN `created_date_in` DATE, IN `created_date_time_in` DATETIME, IN `created_id_in` INT, IN `created_by_name` VARCHAR(200), IN `service_request` VARCHAR(200), IN `job_category` VARCHAR(200), IN `quote_date` DATE, IN `date_needed` DATE, IN `v_session_image` VARCHAR(5000), IN `v_quote_ref_no` VARCHAR(1000), IN `v_session_image2` VARCHAR(5000), IN `v_contatct_no` VARCHAR(200), OUT `msg` VARCHAR(200), OUT `p_ids` INT, OUT `t_ids` INT)
    NO SQL
BEGIN
DECLARE new_ticket_ref_val int;
DECLARE new_ticket_code varchar(200);
DECLARE v_inserted_id int;
DECLARE x int;
  DECLARE exit handler for sqlexception
  BEGIN
   GET DIAGNOSTICS CONDITION 1
    @p21 = MESSAGE_TEXT;
    set msg = @p21;
      ROLLBACK;
END;
DECLARE exit handler for sqlwarning
 BEGIN
  GET DIAGNOSTICS CONDITION 1
    @p2 = MESSAGE_TEXT;
    set msg = @p2;
     ROLLBACK;
END;
START TRANSACTION;
IF(ticket_ref_val=0) THEN
       
       SELECT COALESCE(max(ticket_ref_no)+1,101) into @new_ticket_ref_val from tbl_tickets;
       SET @new_ticket_code=CONCAT('THC-',@new_ticket_ref_val);
       insert into tbl_tickets(ticket_ref_no,ticket_ref_code,book_year,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,category_id,category_name,type_id,type_name,asset_id,asset_code,additional_info,complaints_description,ticket_priority,quote_required,created_by_id,created_by_name,created_date_time,service_request,job_category,quote_date,date_needed,ticket_image,quote_ref_no,ticket_image2,customer_contact_no) values(@new_ticket_ref_val,@new_ticket_code,YEAR(created_date_in),customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,category_id,category_name,type_id,type_name,asset_id,asset_code,additional_info,complaint_description,priority_val,quote_val,created_id_in,created_by_name,created_date_time_in,service_request,job_category,quote_date,date_needed,v_session_image,v_quote_ref_no,v_session_image2,v_contatct_no);
        SET @v_inserted_id=LAST_INSERT_ID();
        set msg= @new_ticket_code;
        set p_ids=@new_ticket_ref_val;
         set t_ids=@v_inserted_id;
  END IF;
IF(ticket_ref_val!=0) THEN
      insert into tbl_tickets(ticket_ref_no,ticket_ref_code,book_year,customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,category_id,category_name,type_id,type_name,asset_id,asset_code,additional_info,complaints_description,ticket_priority,quote_required,created_by_id,created_by_name,created_date_time,service_request,job_category,quote_date,date_needed,ticket_image,quote_ref_no,ticket_image2,customer_contact_no) values(ticket_ref_val,ticket_ref_code,YEAR(created_date_in),customer_id,customer_code,customer_name,location_id,location_code,location_name,building_id,building_code,building_name,category_id,category_name,type_id,type_name,asset_id,asset_code,additional_info,complaint_description,priority_val,quote_val,created_id_in,created_by_name,created_date_time_in,service_request,job_category,quote_date,date_needed,v_session_image,v_quote_ref_no,v_session_image2,v_contatct_no);
         SET @v_inserted_id=LAST_INSERT_ID();
        set msg=ticket_ref_code;
        set p_ids=ticket_ref_val;
         set t_ids=@v_inserted_id;
  END IF;
    COMMIT;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `acc_proc_book_ticket_new`;
DELIMITER ;;
CREATE PROCEDURE `acc_proc_book_ticket_new`(IN `customer_id` INT, IN `customer_code` VARCHAR(200), IN `customer_name` VARCHAR(2000), IN `location_id` INT, IN `location_code` VARCHAR(200), IN `location_name` VARCHAR(2000), IN `building_id` INT, IN `building_code` VARCHAR(200), IN `building_name` VARCHAR(2000), IN `asset_id` INT, IN `asset_code` VARCHAR(200), IN `category_id` INT, IN `category_name` VARCHAR(1000), IN `type_id` INT, IN `type_name` VARCHAR(2000), IN `additional_info` TEXT, IN `complaint_description` TEXT, IN `priority_val` VARCHAR(200), IN `quote_val` VARCHAR(200), IN `ticket_ref_val` INT, IN `ticket_ref_code` VARCHAR(200), IN `created_date_in` DATE, IN `created_date_time_in` DATETIME, IN `created_id_in` INT, IN `created_by_name` VARCHAR(200), IN `service_request` VARCHAR(200), IN `job_category` VARCHAR(200), IN `quote_date` DATE, IN `date_needed` DATE, IN `v_session_image` VARCHAR(5000), IN `v_quote_ref_no` VARCHAR(1000), IN `v_session_image2` VARCHAR(5000), IN `v_contatct_no` VARCHAR(200), IN `entry_through` VARCHAR(20), OUT `msg` VARCHAR(200), OUT `p_ids` INT, OUT `t_ids` INT)
    NO SQL
BEGIN
    DECLARE new_ticket_ref_val INT;
    DECLARE new_ticket_code VARCHAR(200);
    DECLARE v_inserted_id INT;
    DECLARE x INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1 @p21 = MESSAGE_TEXT;
        SET msg = @p21;
        ROLLBACK;
    END;
    DECLARE EXIT HANDLER FOR SQLWARNING
    BEGIN
        GET DIAGNOSTICS CONDITION 1 @p2 = MESSAGE_TEXT;
        SET msg = @p2;
        ROLLBACK;
    END;
    START TRANSACTION;
    IF (ticket_ref_val = 0) THEN
        SELECT COALESCE(MAX(ticket_ref_no) + 1, 101) INTO @new_ticket_ref_val FROM tbl_tickets;
        SET @new_ticket_code = CONCAT('THC-', @new_ticket_ref_val);
        INSERT INTO tbl_tickets(
            ticket_ref_no, ticket_ref_code, book_year,
            customer_id, customer_code, customer_name,
            location_id, location_code, location_name,
            building_id, building_code, building_name,
            category_id, category_name, type_id, type_name,
            asset_id, asset_code,
            additional_info, complaints_description,
            ticket_priority, quote_required,
            created_by_id, created_by_name, created_date_time,
            service_request, job_category,
            quote_date, date_needed,
            ticket_image, quote_ref_no, ticket_image2,
            customer_contact_no, entry_through 
        )
        VALUES (
            @new_ticket_ref_val, @new_ticket_code, YEAR(created_date_in),
            customer_id, customer_code, customer_name,
            location_id, location_code, location_name,
            building_id, building_code, building_name,
            category_id, category_name, type_id, type_name,
            asset_id, asset_code,
            additional_info, complaint_description,
            priority_val, quote_val,
            created_id_in, created_by_name, created_date_time_in,
            service_request, job_category,
            quote_date, date_needed,
            v_session_image, v_quote_ref_no, v_session_image2,
            v_contatct_no, entry_through 
        );
        SET @v_inserted_id = LAST_INSERT_ID();
        SET msg = @new_ticket_code;
        SET p_ids = @new_ticket_ref_val;
        SET t_ids = @v_inserted_id;
    END IF;
    IF (ticket_ref_val != 0) THEN
        INSERT INTO tbl_tickets(
            ticket_ref_no, ticket_ref_code, book_year,
            customer_id, customer_code, customer_name,
            location_id, location_code, location_name,
            building_id, building_code, building_name,
            category_id, category_name, type_id, type_name,
            asset_id, asset_code,
            additional_info, complaints_description,
            ticket_priority, quote_required,
            created_by_id, created_by_name, created_date_time,
            service_request, job_category,
            quote_date, date_needed,
            ticket_image, quote_ref_no, ticket_image2,
            customer_contact_no, entry_through
        )
        VALUES (
            ticket_ref_val, ticket_ref_code, YEAR(created_date_in),
            customer_id, customer_code, customer_name,
            location_id, location_code, location_name,
            building_id, building_code, building_name,
            category_id, category_name, type_id, type_name,
            asset_id, asset_code,
            additional_info, complaint_description,
            priority_val, quote_val,
            created_id_in, created_by_name, created_date_time_in,
            service_request, job_category,
            quote_date, date_needed,
            v_session_image, v_quote_ref_no, v_session_image2,
            v_contatct_no, entry_through 
        );
        SET @v_inserted_id = LAST_INSERT_ID();
        SET msg = ticket_ref_code;
        SET p_ids = ticket_ref_val;
        SET t_ids = @v_inserted_id;
    END IF;
    COMMIT;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `CapitalizeWords`;
DELIMITER ;;
CREATE PROCEDURE `CapitalizeWords`(IN `input_string` TEXT, IN `ids` INT)
BEGIN
    DECLARE result_string TEXT;
    DECLARE word_count INT DEFAULT 0;
    DECLARE current_word VARCHAR(255);
    SET result_string = '';
    SET input_string = CONCAT(input_string, ' '); 
    WHILE LENGTH(input_string) > 0 DO
        SET current_word = TRIM(SUBSTRING_INDEX(input_string, ' ', 1));
        SET input_string = TRIM(SUBSTRING(input_string, LENGTH(current_word) + 1));
        IF LENGTH(current_word) > 0 THEN
            SET result_string = CONCAT(result_string, ' ', UCASE(SUBSTRING(current_word, 1, 1)), LCASE(SUBSTRING(current_word, 2)));
            SET word_count = word_count + 1;
        END IF;
    END WHILE;
    SELECT TRIM(result_string) AS capitalized_string, word_count AS number_of_words;
    update tbl_technician_slots set employee_name=TRIM(result_string) where employee_id=ids;
    update tbl_ticket_teams set employee_name=TRIM(result_string) where employee_id=ids;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `delete_amc`;
DELIMITER ;;
CREATE PROCEDURE `delete_amc`(IN `amc_number` VARCHAR(30))
BEGIN
DELETE FROM tbl_amc_master WHERE amc_ref_no = amc_number;
DELETE FROM tbl_amc_child WHERE amc_ref_no = amc_number;
DELETE FROM tbl_amc_services WHERE amc_ref_code = amc_number;
DELETE FROM tbl_asset_schedule WHERE amc_ref_no = amc_number;
DELETE FROM tbl_customer_payments WHERE amc_ref_no = amc_number;
DELETE FROM tbl_service_images WHERE amc_ticket = 'AMC' AND ticket_amc_ref_code = amc_number;
DELETE FROM tbl_ticket_teams WHERE ticket_ref_no = amc_number;
DELETE FROM tbl_requision_child
WHERE requisition_id IN(SELECT requisition_id FROM tbl_mateial_requisition
WHERE amc_tkt_ref_no = amc_number AND requisition_mode = 'AMC');
DELETE FROM tbl_mateial_requisition
WHERE amc_tkt_ref_no = amc_number AND requisition_mode = 'AMC';
DELETE FROM tbl_visits WHERE amc_ticket = 'AMC' AND amc_tkt_ref_no = amc_number;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_amc_details`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_amc_details`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(1000), IN `v_customer_code` VARCHAR(200), IN `v_contract_type_id` INT, IN `v_contract_type_name` VARCHAR(1000), IN `v_amc_signed_date` DATE, IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_amount` DECIMAL(18,3), IN `v_amc_vat_perct` DECIMAL(18,3), IN `v_amc_vat_amt` DECIMAL(18,3), IN `v_is_rfp` VARCHAR(100), IN `v_amc_description` TEXT, IN `v_amc_status` VARCHAR(100), IN `v_hold_description` TEXT, IN `v_created_id` INT, IN `v_modified_id` INT, IN `v_cancelled_on` DATE, IN `v_cancelled_description` TEXT, IN `v_amc_parent_ref_no` VARCHAR(1000), IN `v_amc_attachment1` VARCHAR(2000), IN `v_amc_attachment1_desc` VARCHAR(2000), IN `v_amc_attachment2` VARCHAR(2000), IN `v_amc_attachment2_desc` VARCHAR(2000), IN `v_amc_attachment3` VARCHAR(2000), IN `v_amc_attachment3_desc` VARCHAR(2000), OUT `v_amc_ref_no` VARCHAR(100), IN `v_ppm_cm` VARCHAR(50), IN `v_ticket_id` INT, IN `v_ticket_ref_no` VARCHAR(100), IN `v_invoice_ref_no` VARCHAR(200), IN `v_total_payable_amt` DECIMAL(18,3), IN `v_paid_vat_perct` DECIMAL(18,2), IN `v_paid_vat_amt` DECIMAL(18,3), IN `v_total_paid_amt` DECIMAL(18,3), IN `v_company_closing_entry` VARCHAR(50), IN `v_description` TEXT, IN `v_payment_status` VARCHAR(100))
    NO SQL
BEGIN
INSERT INTO `tbl_amc_master`( `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`, `amc_signed_date`, `amc_start_date`, `amc_end_date`, `amc_amount`, `amc_vat_perct`, `amc_vat_amt`, `is_rfp`, `amc_description`, `amc_status`, `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`, `amc_parent_ref_no`, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc`) VALUES (v_customer_id,v_customer_name,v_customer_code,v_contract_type_id,v_contract_type_name,v_amc_signed_date,v_amc_start_date,v_amc_end_date,v_amc_amount,v_amc_vat_perct,v_amc_vat_amt,v_is_rfp,v_amc_description,v_amc_status,v_hold_description,v_created_id,v_modified_id,v_cancelled_on,v_cancelled_description,v_amc_parent_ref_no,v_amc_attachment1,v_amc_attachment1_desc,v_amc_attachment2,v_amc_attachment2_desc,v_amc_attachment3,v_amc_attachment3_desc);
SET @v_inserted_id=LAST_INSERT_ID();                            
if(@v_inserted_id>=1 and @v_inserted_id<=9)
then
	SET @v_amc_no=CONCAT('AMC000',@v_inserted_id);
end if;
if(@v_inserted_id>=10 and @v_inserted_id<=99)
then
	SET @v_amc_no= CONCAT('AMC00',@v_inserted_id);
end if;
if(@v_inserted_id>=100 and @v_inserted_id<=999)
then
	SET @v_amc_no= CONCAT('AMC0',@v_inserted_id);
end if;
if(@v_inserted_id>=1000 )
then
	SET @v_amc_no= CONCAT('AMC',@v_inserted_id);
end if;
UPDATE `tbl_amc_master` SET `amc_ref_no`=@v_amc_no WHERE `amc_id`=@v_inserted_id;
SET v_amc_ref_no=@v_amc_no;
insert into tbl_customer_payments(customer_id,customer_code,ppm_cm,amc_id,amc_ref_no,ticket_id,ticket_ref_no,date_of_payment,invoice_ref_no,payable_amt,payable_vat_perct,payable_vat_amt,total_payable_amt,paid_vat_perct,paid_vat_amt,total_paid_amt,company_closing_entry,description,payment_status)values(v_customer_id,v_customer_code,v_ppm_cm,@v_inserted_id,@v_amc_no,v_ticket_id,v_ticket_ref_no,v_amc_signed_date,v_invoice_ref_no,v_amc_amount,v_amc_vat_perct,v_amc_vat_amt,v_total_payable_amt,v_paid_vat_perct,v_paid_vat_amt,v_total_paid_amt,v_company_closing_entry,v_description,v_payment_status);  
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_amc_details_v1`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_amc_details_v1`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(1000), IN `v_customer_code` VARCHAR(200), IN `v_contract_type_id` INT, IN `v_contract_type_name` VARCHAR(1000), IN `v_amc_signed_date` DATE, IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_amount` DECIMAL(18,3), IN `v_total_amc_amnt` DECIMAL(18,3), IN `v_amc_vat_perct` DECIMAL(18,3), IN `v_amc_vat_amt` DECIMAL(18,3), IN `v_is_rfp` VARCHAR(100), IN `v_amc_description` TEXT, IN `v_amc_status` VARCHAR(100), IN `v_hold_description` TEXT, IN `v_created_id` INT, IN `v_modified_id` INT, IN `v_cancelled_on` DATE, IN `v_cancelled_description` TEXT, IN `v_amc_parent_ref_no` VARCHAR(1000), IN `v_amc_attachment1` VARCHAR(2000), IN `v_amc_attachment1_desc` VARCHAR(2000), IN `v_amc_attachment2` VARCHAR(2000), IN `v_amc_attachment2_desc` VARCHAR(2000), IN `v_amc_attachment3` VARCHAR(2000), IN `v_amc_attachment3_desc` VARCHAR(2000), OUT `v_amc_ref_no` VARCHAR(100), IN `v_ppm_cm` VARCHAR(50), IN `v_ticket_id` INT, IN `v_ticket_ref_no` VARCHAR(100), IN `v_invoice_ref_no` VARCHAR(200), IN `v_total_payable_amt` DECIMAL(18,3), IN `v_paid_vat_perct` DECIMAL(18,2), IN `v_paid_vat_amt` DECIMAL(18,3), IN `v_total_paid_amt` DECIMAL(18,3), IN `v_company_closing_entry` VARCHAR(50), IN `v_description` TEXT, IN `v_payment_status` VARCHAR(100))
    NO SQL
BEGIN
INSERT INTO `tbl_amc_master`( `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`, `amc_signed_date`, `amc_start_date`, `amc_end_date`, `amc_amount`, `total_amc_amount`, `amc_vat_perct`, `amc_vat_amt`, `is_rfp`, `amc_description`, `amc_status`, `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`, `amc_parent_ref_no`, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc`) VALUES (v_customer_id,v_customer_name,v_customer_code,v_contract_type_id,v_contract_type_name,v_amc_signed_date,v_amc_start_date,v_amc_end_date,v_amc_amount,v_amc_vat_perct,v_amc_vat_amt,v_is_rfp,v_amc_description,v_amc_status,v_hold_description,v_created_id,v_modified_id,v_cancelled_on,v_cancelled_description,v_amc_parent_ref_no,v_amc_attachment1,v_amc_attachment1_desc,v_amc_attachment2,v_amc_attachment2_desc,v_amc_attachment3,v_amc_attachment3_desc);
SET @v_inserted_id=LAST_INSERT_ID();                            
if(@v_inserted_id>=1 and @v_inserted_id<=9)
then
	SET @v_amc_no=CONCAT('AMC000',@v_inserted_id);
end if;
if(@v_inserted_id>=10 and @v_inserted_id<=99)
then
	SET @v_amc_no= CONCAT('AMC00',@v_inserted_id);
end if;
if(@v_inserted_id>=100 and @v_inserted_id<=999)
then
	SET @v_amc_no= CONCAT('AMC0',@v_inserted_id);
end if;
if(@v_inserted_id>=1000 )
then
	SET @v_amc_no= CONCAT('AMC',@v_inserted_id);
end if;
UPDATE `tbl_amc_master` SET `amc_ref_no`=@v_amc_no WHERE `amc_id`=@v_inserted_id;
SET v_amc_ref_no=@v_amc_no;
insert into tbl_customer_payments(customer_id,customer_code,ppm_cm,amc_id,amc_ref_no,ticket_id,ticket_ref_no,date_of_payment,invoice_ref_no,payable_amt,payable_total_amc_amnt,payable_vat_perct,payable_vat_amt,total_payable_amt,paid_vat_perct,paid_vat_amt,total_paid_amt,company_closing_entry,description,payment_status)values(v_customer_id,v_customer_code,v_ppm_cm,@v_inserted_id,@v_amc_no,v_ticket_id,v_ticket_ref_no,v_amc_signed_date,v_invoice_ref_no,v_amc_amount,v_total_amc_amnt,v_amc_vat_perct,v_amc_vat_amt,v_total_payable_amt,v_paid_vat_perct,v_paid_vat_amt,v_total_paid_amt,v_company_closing_entry,v_description,v_payment_status);  
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_amc_details_v2`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_amc_details_v2`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(1000), IN `v_customer_code` VARCHAR(200), IN `v_contract_type_id` INT, IN `v_contract_type_name` VARCHAR(1000), IN `v_amc_signed_date` DATE, IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_amount` DECIMAL(18,3), IN `v_total_amc_amount` DECIMAL(18,3), IN `v_amc_vat_perct` DECIMAL(18,3), IN `v_amc_vat_amt` DECIMAL(18,3), IN `v_is_rfp` VARCHAR(100), IN `v_amc_description` TEXT, IN `v_amc_status` VARCHAR(100), IN `v_hold_description` TEXT, IN `v_created_id` INT, IN `v_modified_id` INT, IN `v_cancelled_on` DATE, IN `v_cancelled_description` TEXT, IN `v_amc_parent_ref_no` VARCHAR(1000), IN `v_amc_attachment1` VARCHAR(2000), IN `v_amc_attachment1_desc` VARCHAR(2000), IN `v_amc_attachment2` VARCHAR(2000), IN `v_amc_attachment2_desc` VARCHAR(2000), IN `v_amc_attachment3` VARCHAR(2000), IN `v_amc_attachment3_desc` VARCHAR(2000), OUT `v_amc_ref_no` VARCHAR(100), IN `v_ppm_cm` VARCHAR(50), IN `v_ticket_id` INT, IN `v_ticket_ref_no` VARCHAR(100), IN `v_invoice_ref_no` VARCHAR(200), IN `v_total_payable_amt` DECIMAL(18,3), IN `v_paid_vat_perct` DECIMAL(18,2), IN `v_paid_vat_amt` DECIMAL(18,3), IN `v_total_paid_amt` DECIMAL(18,3), IN `v_company_closing_entry` VARCHAR(50), IN `v_description` TEXT, IN `v_payment_status` VARCHAR(100))
    NO SQL
BEGIN
INSERT INTO `tbl_amc_master`( `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`, `amc_signed_date`, `amc_start_date`, `amc_end_date`, `amc_amount`,`total_amc_amount`, `amc_vat_perct`, `amc_vat_amt`, `is_rfp`, `amc_description`, `amc_status`, `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`, `amc_parent_ref_no`, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc`) VALUES (v_customer_id,v_customer_name,v_customer_code,v_contract_type_id,v_contract_type_name,v_amc_signed_date,v_amc_start_date,v_amc_end_date,v_amc_amount,v_total_amc_amount,v_amc_vat_perct,v_amc_vat_amt,v_is_rfp,v_amc_description,v_amc_status,v_hold_description,v_created_id,v_modified_id,v_cancelled_on,v_cancelled_description,v_amc_parent_ref_no,v_amc_attachment1,v_amc_attachment1_desc,v_amc_attachment2,v_amc_attachment2_desc,v_amc_attachment3,v_amc_attachment3_desc);
SET @v_inserted_id=LAST_INSERT_ID();                            
if(@v_inserted_id>=1 and @v_inserted_id<=9)
then
	SET @v_amc_no=CONCAT('AMC000',@v_inserted_id);
end if;
if(@v_inserted_id>=10 and @v_inserted_id<=99)
then
	SET @v_amc_no= CONCAT('AMC00',@v_inserted_id);
end if;
if(@v_inserted_id>=100 and @v_inserted_id<=999)
then
	SET @v_amc_no= CONCAT('AMC0',@v_inserted_id);
end if;
if(@v_inserted_id>=1000 )
then
	SET @v_amc_no= CONCAT('AMC',@v_inserted_id);
end if;
UPDATE `tbl_amc_master` SET `amc_ref_no`=@v_amc_no WHERE `amc_id`=@v_inserted_id;
SET v_amc_ref_no=@v_amc_no;
insert into tbl_customer_payments(customer_id,customer_code,ppm_cm,amc_id,amc_ref_no,ticket_id,ticket_ref_no,date_of_payment,invoice_ref_no,payable_amt,payable_total_amc_amnt,payable_vat_perct,payable_vat_amt,total_payable_amt,paid_vat_perct,paid_vat_amt,total_paid_amt,company_closing_entry,description,payment_status)values(v_customer_id,v_customer_code,v_ppm_cm,@v_inserted_id,@v_amc_no,v_ticket_id,v_ticket_ref_no,v_amc_signed_date,v_invoice_ref_no,v_amc_amount,v_total_amc_amount,v_amc_vat_perct,v_amc_vat_amt,v_total_payable_amt,v_paid_vat_perct,v_paid_vat_amt,v_total_paid_amt,v_company_closing_entry,v_description,v_payment_status);  
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_child_amc_new`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_child_amc_new`(IN `sqlString` TEXT, OUT `ret_val` VARCHAR(10))
BEGIN
SET @ret_msg = CONCAT("INSERT INTO `tbl_amc_services`(`amc_ref_code`,`amc_child_id`, `asset_id`,
 `asset_code`, `service_id`, `service_description`) 
VALUES ",sqlString,"");
 			SET @p_sql1=@ret_msg;
            PREPARE s FROM  @p_sql1;
            EXECUTE s;
            DEALLOCATE PREPARE s;
SET ret_val='TRUE'; 
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_employee_details`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_employee_details`(IN `v_employee_type_id` INT, IN `v_employee_type_name` VARCHAR(100), IN `v_employee_password` VARCHAR(20), IN `v_employee_name` VARCHAR(100), IN `v_employee_contact_no` VARCHAR(100), IN `v_employee_email_id` VARCHAR(100), IN `v_employee_address` VARCHAR(50), IN `v_employee_image` VARCHAR(100), IN `v_expertise_id` VARCHAR(20), IN `v_expertise_name` VARCHAR(1000), IN `v_cpr_no` VARCHAR(100), IN `v_blood_group` VARCHAR(100), IN `v_passport_no` VARCHAR(100), IN `v_joining_date` DATE, IN `v_cpr_expiry_date` DATE, IN `v_visa_validity_on` DATE, IN `v_is_driving_license` VARCHAR(100), IN `v_technician_type` VARCHAR(1000), IN `v_native_no` VARCHAR(100), IN `v_native_address` TEXT, IN `v_visa_type` VARCHAR(100), OUT `ret` VARCHAR(20))
BEGIN
DECLARE exit handler for sqlexception
  BEGIN
   GET DIAGNOSTICS CONDITION 1
    @p21 = MESSAGE_TEXT;
    set ret = @p21;
      ROLLBACK;
END;
select exists(select 1 from tbl_employees) INTO @emp_count;
  SELECT employee_code ,employee_id into @employee_code,@employee_id FROM tbl_employees  ORDER BY employee_id DESC LIMIT 1;
 INSERT INTO `tbl_employees` (`employee_type_id`, `employee_type_name`,  `employee_password`, `employee_name`, `employee_contact_no`, `employee_email_id`, `employee_address`, `employee_image`, `cpr_no`, `blood_group`, `passport_no`, `joining_date`, `cpr_expiry_date`, `visa_validity_on`, `is_driving_license`, `technician_type`, `native_number`, `native_address`, `visa_type`) VALUES (v_employee_type_id,v_employee_type_name,v_employee_password,v_employee_name,v_employee_contact_no,v_employee_email_id,v_employee_address,v_employee_image,v_cpr_no,v_blood_group,v_passport_no,v_joining_date,v_cpr_expiry_date,v_visa_validity_on,v_is_driving_license,v_technician_type,v_native_no,v_native_address,v_visa_type);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids ;
SET @last_id=LAST_INSERT_ID();
SET ret=@last_id;
IF (@last_id >=0) and (@last_id<=9) THEN
	SET @v_employee_code=CONCAT('CG-THC-000',@last_id);
ELSEIF (@last_id >=10) and (@last_id<=99) THEN
	SET @v_employee_code=CONCAT('CG-THC-00',@last_id);
 ELSEIF (@last_id >=100) and (@last_id<=999) THEN
	SET @v_employee_code=CONCAT('CG-THC-0',@last_id);
ELSE
	SET @v_employee_code=CONCAT('CG-THC-',@last_id);
END IF;
UPDATE `tbl_employees` SET `employee_code`=@v_employee_code WHERE `employee_id`=@last_id;
IF v_employee_type_name='Technician' THEN
  INSERT INTO `tbl_technician_expertise` (`employee_id`, `employee_code`, `employee_name`, `expertise_id`, `expertise_name`) VALUES(@v_ret_last_insert_ids,@v_employee_code,v_employee_name,v_expertise_id,v_expertise_name);
END IF;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_employee_details_v1`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_employee_details_v1`(IN `v_employee_type_id` INT, IN `v_employee_type_name` VARCHAR(100), IN `v_employee_password` VARCHAR(20), IN `v_employee_name` VARCHAR(100), IN `v_employee_contact_no` VARCHAR(100), IN `v_employee_email_id` VARCHAR(100), IN `v_employee_address` VARCHAR(50), IN `v_employee_image` VARCHAR(100), IN `v_expertise_id` VARCHAR(20), IN `v_expertise_name` VARCHAR(1000), IN `v_cpr_no` VARCHAR(100), IN `v_blood_group` VARCHAR(100), IN `v_passport_no` VARCHAR(100), IN `v_joining_date` DATE, IN `v_cpr_expiry_date` DATE, IN `v_visa_validity_on` DATE, IN `v_is_driving_license` VARCHAR(100), IN `v_technician_type` VARCHAR(1000), IN `v_native_no` VARCHAR(100), IN `v_native_address` TEXT, IN `v_visa_type` VARCHAR(100), OUT `ret` VARCHAR(20))
BEGIN
DECLARE exit handler for sqlexception
  BEGIN
   GET DIAGNOSTICS CONDITION 1
    @p21 = MESSAGE_TEXT;
    set ret = @p21;
      ROLLBACK;
END;
select exists(select 1 from tbl_employees) INTO @emp_count;
  SELECT employee_code ,employee_id into @employee_code,@employee_id FROM tbl_employees  ORDER BY employee_id DESC LIMIT 1;
 INSERT INTO `tbl_employees` (`employee_type_id`, `employee_type_name`,  `employee_password`, `employee_name`, `employee_contact_no`, `employee_email_id`, `employee_address`, `employee_image`, `cpr_no`, `blood_group`, `passport_no`, `joining_date`, `cpr_expiry_date`, `visa_validity_on`, `is_driving_license`, `technician_type`, `native_number`, `native_address`, `visa_type`) VALUES (v_employee_type_id,v_employee_type_name,v_employee_password,v_employee_name,v_employee_contact_no,v_employee_email_id,v_employee_address,v_employee_image,v_cpr_no,v_blood_group,v_passport_no,v_joining_date,v_cpr_expiry_date,v_visa_validity_on,v_is_driving_license,v_technician_type,v_native_no,v_native_address,v_visa_type);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids ;
SET @last_id=LAST_INSERT_ID();
SET ret=@last_id;
IF (@last_id >=0) and (@last_id<=9) THEN
	SET @v_employee_code=CONCAT('CG-THC-000',@last_id);
ELSEIF (@last_id >=10) and (@last_id<=99) THEN
	SET @v_employee_code=CONCAT('CG-THC-00',@last_id);
 ELSEIF (@last_id >=100) and (@last_id<=999) THEN
	SET @v_employee_code=CONCAT('CG-THC-0',@last_id);
ELSE
	SET @v_employee_code=CONCAT('CG-THC-',@last_id);
END IF;
UPDATE `tbl_employees` SET `employee_code`=@v_employee_code WHERE `employee_id`=@last_id;
IF v_employee_type_name='Technician' THEN
  INSERT INTO `tbl_technician_expertise` (`employee_id`, `employee_code`, `employee_name`, `expertise_id`, `expertise_name`) VALUES(@v_ret_last_insert_ids,@v_employee_code,v_employee_name,v_expertise_id,v_expertise_name);
END IF;
INSERT INTO users(`username`, `password`, `role_id`) VALUES(@v_employee_code, v_employee_password, 1);
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_employee_leave`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_employee_leave`(IN `v_employee_code` VARCHAR(100), IN `v_employee_name` VARCHAR(100), IN `v_leave_type` VARCHAR(100), IN `v_leave_reason` TEXT, IN `v_start_time` DATETIME, IN `v_end_time` DATETIME)
    NO SQL
BEGIN
INSERT INTO `tbl_employee_leave`(`employee_code`, `employee_name`, `leave_type`, `leave_reason`, `start_time`, `end_time`) VALUES (v_employee_code,v_employee_name,v_leave_type,v_leave_reason,v_start_time,v_end_time);
UPDATE `tbl_employees` SET `employee_status`='Deactive' WHERE `employee_code`=v_employee_code;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_employee_short_leave`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_employee_short_leave`(
    IN `v_employee_id` INT,
    IN `v_employee_code` VARCHAR(100), 
    IN `v_employee_name` VARCHAR(100), 
    IN `v_leave_type` VARCHAR(100), 
    IN `v_leave_start_date` DATE,
    IN `v_leave_end_date` DATE, 
    IN `v_leave_duration` VARCHAR(50),
    IN `v_leave_reason` TEXT,
    OUT `msg` VARCHAR(255)
)
BEGIN
    INSERT INTO `tbl_employee_short_leave`(
        `employee_id`, 
        `employee_code`, 
        `employee_name`, 
        `leave_type`, 
        `leave_start_date`, 
        `leave_end_date`,
        `leave_duration`, 
        `leave_reason`
    ) VALUES (
        v_employee_id,
        v_employee_code,
        v_employee_name,
        v_leave_type,
        v_leave_start_date,
        v_leave_end_date,
        v_leave_duration,
        v_leave_reason
    );
    
    SET msg = 'Success';
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_lpo`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_lpo`(IN `v_vendor_id_val` INT, IN `v_vendor_name` VARCHAR(255), IN `v_lpo_ref_no` VARCHAR(255), IN `v_po_box` VARCHAR(255), IN `v_fax_no` VARCHAR(255), IN `v_vat_no` VARCHAR(255), IN `v_qtn_ref_no` VARCHAR(255), IN `v_tele_ph` VARCHAR(255), IN `v_lpo_date` DATE, IN `v_lpo_subject` TEXT, IN `v_item_name` TEXT, IN `v_item_qty` INT, IN `v_item_unit` VARCHAR(100), IN `v_unit_price` DECIMAL(18,3), IN `v_discount_percent` DECIMAL(18,3), IN `v_tax_percent` DECIMAL(18,3), IN `v_total_amount` DECIMAL(18,3), IN `v_grand_total` DECIMAL(18,3), IN `prepared_by_id` INT, IN `prepared_by_name` VARCHAR(200), OUT `msg` VARCHAR(100))
    NO SQL
BEGIN
IF v_lpo_ref_no = '' THEN 
insert into tbl_lpo_master(`vendor_id`, `vendor_name`, `vendor_vat_no`, `vendor_po`, `vendor_tel`, `vendor_fax`,`quotation_ref_no`,`lpo_date`, `subject`,`prepaired_id`,`prepared_by`) values(v_vendor_id_val,v_vendor_name,v_vat_no,v_po_box,v_tele_ph,v_fax_no,v_qtn_ref_no,v_lpo_date,v_lpo_subject,prepared_by_id,prepared_by_name);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
IF @v_ret_last_insert_ids >=0 and @v_ret_last_insert_ids<=9 THEN
	SET @reference_no=CONCAT('LPO-00',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=10 and @v_ret_last_insert_ids<=99 THEN
	SET @reference_no=CONCAT('LPO-0',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=100 and @v_ret_last_insert_ids<=909 THEN
	SET @reference_no=CONCAT('LPO-',@v_ret_last_insert_ids);
END IF;
UPDATE tbl_lpo_master SET lpo_ref_no=@reference_no where lpo_master_id=@v_ret_last_insert_ids;
INSERT INTO `tbl_lpo_child` (`lpo_master_id`, `lpo_ref_no`, `description`, `quantity`, `unit`, `unit_price`,`total_price`,`tax`,`discount`,`grand_total`) VALUES(@v_ret_last_insert_ids,@reference_no,v_item_name,v_item_qty,v_item_unit,v_unit_price,v_total_amount,v_tax_percent,v_discount_percent,v_grand_total);
  set msg= @reference_no;
 ELSE
SELECT lpo_master_id INTO @last_lpo_master_id FROM tbl_lpo_master WHERE lpo_ref_no=v_lpo_ref_no;
INSERT INTO `tbl_lpo_child` (`lpo_master_id`, `lpo_ref_no`, `description`, `quantity`, `unit`, `unit_price`,`total_price`, `tax`,`discount`,`grand_total`) VALUES
(@last_lpo_master_id,v_lpo_ref_no,v_item_name,v_item_qty,v_item_unit,v_unit_price,v_total_amount,v_tax_percent,v_discount_percent,v_grand_total);
set msg=v_lpo_ref_no;
 END IF;
 END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_quotation`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_quotation`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(100), IN `v_po_box` VARCHAR(100), IN `v_address` TEXT, IN `v_contact_no` VARCHAR(100), IN `v_attention` VARCHAR(1000), IN `v_quotation_date` DATE, IN `v_subject` TEXT, IN `v_description` TEXT, IN `v_created_by_id` INT, IN `v_created_by_name` VARCHAR(100), IN `v_approved_by_id` INT, IN `v_approved_by_name` VARCHAR(100), IN `v_ref_no` VARCHAR(100), IN `v_quantity` DECIMAL(18,3), IN `v_unit` VARCHAR(100), IN `v_rate` DECIMAL(18,3), IN `v_total` DECIMAL(18,3), IN `v_vat_content` INT, IN `v_reference_number_date` VARCHAR(100), OUT `ret` VARCHAR(100))
    NO SQL
    DETERMINISTIC
BEGIN
DECLARE exit handler for sqlexception
  BEGIN
   GET DIAGNOSTICS CONDITION 1
    @p21 = MESSAGE_TEXT;
    set ret = @p21;
      ROLLBACK;
END;
IF v_ref_no = '' THEN 
insert into tbl_quotation_master(`customer_id`, `customer_name`, `po_box`, `address`, `contact_no`, `attention`, `date`,`vat_content`, `subject`, `created_by_id`,`created_by_name`,`approved_by_id`,`approved_by_name`) values(v_customer_id,v_customer_name,v_po_box,v_address,v_contact_no,v_attention,v_quotation_date,v_vat_content,v_subject,v_created_by_id,v_created_by_name,v_approved_by_id,v_approved_by_name);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
IF @v_ret_last_insert_ids >=0 and @v_ret_last_insert_ids<=9 THEN
	SET @reference_no=CONCAT('CG/THC/',v_created_by_name,'/QTN/00',@v_ret_last_insert_ids,'/',v_reference_number_date);
END IF;
IF @v_ret_last_insert_ids >=10 and @v_ret_last_insert_ids<=99 THEN
	SET @reference_no=CONCAT('CG/THC/',v_created_by_name,'/QTN/0',@v_ret_last_insert_ids,'/',v_reference_number_date);
END IF;
IF @v_ret_last_insert_ids >=100 and @v_ret_last_insert_ids<=909 THEN
	SET @reference_no=CONCAT('CG/THC/',v_created_by_name,'/QTN/',@v_ret_last_insert_ids,'/',v_reference_number_date);
END IF;
UPDATE tbl_quotation_master SET quotation_ref_no=@reference_no where quotation_id=@v_ret_last_insert_ids;
INSERT INTO `tbl_quotation_child` (`quotation_id`, `quotation_ref_no`, `description`, `quantity`, `unit`, `rate`,`total`) VALUES(@v_ret_last_insert_ids,@reference_no,v_description,v_quantity,v_unit,v_rate,v_total);
  set ret= @reference_no;
 ELSE
SELECT quotation_id INTO @last_quotation_id FROM tbl_quotation_master WHERE quotation_ref_no=v_ref_no;
INSERT INTO `tbl_quotation_child` (`quotation_id`, `quotation_ref_no`, `description`, `quantity`, `unit`, `rate`,`total`) VALUES
(@last_quotation_id,v_ref_no,v_description,v_quantity,v_unit,v_rate,v_total);
set ret=v_ref_no;
 END IF;
 END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_quotation_rivision`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_quotation_rivision`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(100), IN `v_po_box` VARCHAR(100), IN `v_address` TEXT, IN `v_contact_no` VARCHAR(100), IN `v_attention` VARCHAR(1000), IN `v_quotation_date` DATE, IN `v_subject` TEXT, IN `v_description` TEXT, IN `v_created_by_id` INT, IN `v_created_by_name` VARCHAR(100), IN `v_approved_by_id` INT, IN `v_approved_by_name` VARCHAR(100), IN `v_quantity` DECIMAL(18,3), IN `v_unit` VARCHAR(100), IN `v_rate` DECIMAL(18,3), IN `v_total` DECIMAL(18,3), IN `v_discount` DECIMAL(18,3), IN `v_vat` DECIMAL(18,3), IN `v_grant_total` DECIMAL(18,3), IN `v_quotation_number` VARCHAR(100), IN `v_terms_and_condition` TEXT, IN `v_quotation_rivision_no` VARCHAR(100))
    NO SQL
    DETERMINISTIC
BEGIN 
SELECT COUNT(*) INTO @quotation_number_count FROM tbl_quotation_master_riv where `quotation_ref_no`=v_quotation_number;
IF @quotation_number_count = 0 THEN 
SET @reference_no_riv=CONCAT(v_quotation_rivision_no,'1');
insert into tbl_quotation_master_riv(`quotation_ref_no`,`quotation_ref_no_riv`,`customer_id`, `customer_name`, `po_box`, `address`, `contact_no`, `attention`, `date`, `subject`, `terms_and_condition`, `created_by_id`,`created_by_name`,`approved_by_id`,`approved_by_name`) values(v_quotation_number,@reference_no_riv,v_customer_id,v_customer_name,v_po_box,v_address,v_contact_no,v_attention,v_quotation_date,v_subject,v_terms_and_condition,v_created_by_id,v_created_by_name,v_approved_by_id,v_approved_by_name);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
INSERT INTO `tbl_quotation_child_riv` (`quotation_id`, `quotation_ref_no`,`quotation_ref_no_riv`, `description`, `quantity`, `unit`, `rate`,`total`, `discount`, `vat`, `grant_total`) VALUES(@v_ret_last_insert_ids,v_quotation_number,@reference_no_riv,v_description,v_quantity,v_unit,v_rate,v_total,v_discount,v_vat,v_grant_total);
ELSE 
SET @rivision_number = @quotation_number_count + 1;
SET @reference_no_riv=CONCAT(v_quotation_rivision_no,@rivision_number);
insert into tbl_quotation_master_riv(`quotation_ref_no`,`quotation_ref_no_riv`,`customer_id`, `customer_name`, `po_box`, `address`, `contact_no`, `attention`, `date`, `subject`, `terms_and_condition`, `created_by_id`,`created_by_name`,`approved_by_id`,`approved_by_name`) values(v_quotation_number,@reference_no_riv,v_customer_id,v_customer_name,v_po_box,v_address,v_contact_no,v_attention,v_quotation_date,v_subject,v_terms_and_condition,v_created_by_id,v_created_by_name,v_approved_by_id,v_approved_by_name);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
INSERT INTO `tbl_quotation_child_riv` (`quotation_id`, `quotation_ref_no`,`quotation_ref_no_riv`, `description`, `quantity`, `unit`, `rate`,`total`, `discount`, `vat`, `grant_total`) VALUES(@v_ret_last_insert_ids,v_quotation_number,@reference_no_riv,v_description,v_quantity,v_unit,v_rate,v_total,v_discount,v_vat,v_grant_total);
END IF;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_add_service_details`;
DELIMITER ;;
CREATE PROCEDURE `proc_add_service_details`(IN `v_category_type_id` INT, IN `v_category_type_name` VARCHAR(1000), IN `v_category_asset_type_id` INT, IN `v_category_asset_type_name` VARCHAR(1000), IN `v_service_desc` VARCHAR(1000), OUT `v_ret` VARCHAR(20))
    NO SQL
BEGIN
insert into tbl_services(service_description,category_id,category_name,asset_type_id,asset_type_name)values(v_service_desc,v_category_type_id,v_category_type_name,v_category_asset_type_id,v_category_asset_type_name);
SET v_ret="success";
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_amc_add_assets`;
DELIMITER ;;
CREATE PROCEDURE `proc_amc_add_assets`(IN `v_asset_ref_no` VARCHAR(200), IN `v_asset_category_id` INT, IN `v_asset_category_name` VARCHAR(2000), IN `v_asset_type_id` INT, IN `v_asset_type_name` VARCHAR(2000), IN `v_customer_id` INT, IN `v_customer_code` VARCHAR(200), IN `v_customer_name` VARCHAR(2000), IN `v_location_id` INT, IN `v_asset_location` VARCHAR(2000), IN `v_location_code` VARCHAR(200), IN `v_building_id` INT, IN `v_building_code` VARCHAR(100), IN `v_asset_building` VARCHAR(2000), IN `v_zone_or_floor` VARCHAR(1000), IN `v_flat_area_code` VARCHAR(100), IN `v_room_no` VARCHAR(1000), IN `v_asset_sp_des` VARCHAR(1000), IN `v_asset_serial_no` VARCHAR(2000), IN `v_asset_brand` VARCHAR(2000), IN `v_asset_capacity` VARCHAR(2000), IN `v_asset_cost` DECIMAL(18,2), IN `v_is_warentee` VARCHAR(10), IN `v_warentee_end_date` DATE, IN `v_asset_attachment` VARCHAR(2000), IN `v_asset_description` TEXT, IN `v_asset_status` VARCHAR(100), IN `v_created_id` INT, IN `v_created_name` VARCHAR(200), IN `v_created_date` DATE, IN `v_modified_id` INT, IN `v_modified_name` VARCHAR(200), IN `v_modified_date` DATE, IN `v_amc_ref_no` VARCHAR(500), IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_id` INT, OUT `v_inserted_id` INT)
    NO SQL
BEGIN
INSERT INTO `tbl_assets`(`asset_ref_no`, `asset_category_id`, `asset_category_name`, `asset_type_id`, `asset_type_name`, `customer_id`, `customer_code`, `customer_name`, `location_id`, `asset_location`,`building_code`, `asset_building`, `zone_floor`, `flat_area_code`, `room_no`, `asset_sp_des`, `asset_serial_no`, `asset_brand`, `asset_capacity`, `asset_cost`, `is_warentee`, `warentee_end_date`, `asset_attachment`, `asset_description`, `asset_status`, `created_id`, `created_name`, `created_date`, `modified_id`, `modified_name`, `modified_date`,`location_code`,`building_id`,`amc_ref_no`,`amc_start_date`,`amc_end_date`) VALUES (v_asset_ref_no,v_asset_category_id,v_asset_category_name,v_asset_type_id,v_asset_type_name,v_customer_id,v_customer_code,v_customer_name,v_location_id,v_asset_location,v_building_code,v_asset_building,v_zone_or_floor,v_flat_area_code,v_room_no,v_asset_sp_des,v_asset_serial_no,v_asset_brand,v_asset_capacity,v_asset_cost,v_is_warentee,v_warentee_end_date,v_asset_attachment,v_asset_description,v_asset_status,v_created_id,v_created_name,v_created_date,v_modified_id,v_modified_name,v_modified_date,v_location_code,v_building_id,v_amc_ref_no,v_amc_start_date,v_amc_end_date);
SET v_inserted_id=LAST_INSERT_ID(); 
INSERT INTO `tbl_amc_child` (`amc_master_id`, `amc_ref_no`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`, `amc_child_status`) VALUES (v_amc_id,v_amc_ref_no, v_asset_category_id,v_asset_category_name,v_asset_type_id,v_asset_type_name,v_inserted_id,v_asset_ref_no, 'Active');
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_amc_add_customer_payments`;
DELIMITER ;;
CREATE PROCEDURE `proc_amc_add_customer_payments`(IN `v_customer_id` INT, IN `v_customer_code` VARCHAR(100), IN `v_ppm_cm` VARCHAR(50), IN `v_amc_id` INT, IN `v_amc_ref_no` VARCHAR(100), IN `v_ticket_id` INT, IN `v_ticket_ref_no` VARCHAR(100), IN `v_date_of_payment` DATE, IN `v_invoice_ref_no` VARCHAR(100), IN `v_payable_amt` DECIMAL(18,3), IN `v_payable_vat_perct` DECIMAL(18,3), IN `v_payable_vat_amt` DECIMAL(18,3), IN `v_total_payable_amt` DECIMAL(18,3), IN `v_paid_amount` DECIMAL(18,3), IN `v_paid_vat_perct` DECIMAL(18,3), IN `v_paid_vat_amt` DECIMAL(18,3), IN `v_total_paid_amt` DECIMAL(18,3), IN `v_company_closing_entry` VARCHAR(50), IN `v_description` TEXT, OUT `v_inserted_id` INT)
    NO SQL
BEGIN
INSERT INTO tbl_customer_payments(`customer_id`,`customer_code`,`ppm_cm`,`amc_id`,`amc_ref_no`,`ticket_id`,`ticket_ref_no`,`date_of_payment`,`invoice_ref_no`,`payable_amt`,`payable_vat_perct`,`payable_vat_amt`,`total_payable_amt`,`paid_amount`,`paid_vat_perct`,`paid_vat_amt`,`total_paid_amt`,`company_closing_entry`,`description`) VALUES (v_customer_id,v_customer_code,v_ppm_cm,v_amc_id,v_amc_ref_no,v_ticket_id,v_ticket_ref_no,v_date_of_payment,v_invoice_ref_no,v_payable_amt,v_payable_vat_perct,v_payable_vat_amt,v_total_payable_amt,v_paid_amount,v_paid_vat_perct,v_paid_vat_amt,v_total_paid_amt,v_company_closing_entry,v_description);
SET v_inserted_id=LAST_INSERT_ID(); 
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_amc_edit_assets`;
DELIMITER ;;
CREATE PROCEDURE `proc_amc_edit_assets`(IN `v_assets_id` INT, IN `v_asset_ref_no` VARCHAR(200), IN `v_asset_category_id` INT, IN `v_asset_category_name` VARCHAR(2000), IN `v_asset_type_id` INT, IN `v_asset_type_name` VARCHAR(2000), IN `v_cust_id` INT, IN `v_cust_code` VARCHAR(200), IN `v_cust_name` VARCHAR(2000), IN `v_location_id` INT, IN `v_asset_location_code` VARCHAR(200), IN `v_asset_location` VARCHAR(2000), IN `v_asset_building_id` INT, IN `v_asset_building_code` VARCHAR(200), IN `v_asset_building` VARCHAR(2000), IN `v_zone_or_floor_no` VARCHAR(500), IN `v_flat_area_code` VARCHAR(1000), IN `v_asset_roon_no` VARCHAR(1000), IN `v_asset_specify_description` VARCHAR(2000), IN `v_asset_serial_no` VARCHAR(1000), IN `v_asset_brand` VARCHAR(2000), IN `v_asset_capacity` VARCHAR(2000), IN `v_asset_cost` DECIMAL(18,3), IN `v_is_warentee` VARCHAR(200), IN `v_warentee_end_date` DATE, IN `assets_attachment_file` VARCHAR(20000), IN `v_asset_description` TEXT, IN `v_modified_date` DATE, OUT `ret` VARCHAR(20))
    NO SQL
BEGIN
UPDATE `tbl_assets` SET `asset_ref_no`=v_asset_ref_no,`asset_category_id`=v_asset_category_id,`asset_category_name`=v_asset_category_name,`asset_type_id`=v_asset_type_id,`asset_type_name`=v_asset_type_name,`customer_id`=v_cust_id,`customer_code`=v_cust_code,`customer_name`=v_cust_name,`location_id`=v_location_id,`location_code`=v_asset_location_code,`asset_location`=v_asset_location,`building_id`=v_asset_building_id,`building_code`=v_asset_building_code,`asset_building`=v_asset_building,`zone_floor`=v_zone_or_floor_no,`flat_area_code`=v_flat_area_code,`room_no`=v_asset_roon_no,`asset_sp_des`=v_asset_specify_description,`asset_serial_no`=v_asset_serial_no,`asset_brand`=v_asset_brand,`asset_capacity`=v_asset_capacity,`asset_cost`=v_asset_cost,`is_warentee`=v_is_warentee,`warentee_end_date`=v_warentee_end_date,`asset_attachment`=assets_attachment_file,`asset_description`=v_asset_description,`modified_date`=v_modified_date WHERE `asset_id`=v_assets_id;	
SET ret="success";   
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_amc_update_customer_payments`;
DELIMITER ;;
CREATE PROCEDURE `proc_amc_update_customer_payments`(IN `v_amc_payments_ids` INT, IN `v_date_of_payment` DATE, IN `v_invoice_ref_no` VARCHAR(200), IN `v_paid_amount` DECIMAL(18,3), IN `v_paid_vat_perct` DECIMAL(18,3), IN `v_paid_vat_amt` DECIMAL(18,3), IN `v_total_paid_amt` DECIMAL(18,3), IN `v_company_closing_entry` VARCHAR(50), IN `v_description` TEXT, IN `ret` VARCHAR(20))
    NO SQL
BEGIN
UPDATE tbl_customer_payments set date_of_payment=v_date_of_payment,invoice_ref_no=v_invoice_ref_no,paid_amount=v_paid_amount,paid_vat_perct=v_paid_vat_perct,paid_vat_amt=v_paid_vat_amt,total_paid_amt=v_total_paid_amt,company_closing_entry=v_company_closing_entry,description=v_description where amc_payments_ids=v_amc_payments_ids; 
SET ret="success";
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_app_insert_requisitions`;
DELIMITER ;;
CREATE PROCEDURE `proc_app_insert_requisitions`(IN `amc_asset_code` VARCHAR(100), IN `amc_customer_name` VARCHAR(100), IN `amc_building_name` VARCHAR(500), IN `amc_location_name` VARCHAR(500), IN `amc_building_id` INT, IN `amc_customer_id` INT, IN `amc_location_id` INT, IN `requisition_mode` VARCHAR(50), IN `v_requ_serial_no` VARCHAR(100), IN `v_product_category_name` VARCHAR(2000), IN `v_product_category_id` INT, IN `v_product_type_name` VARCHAR(2000), IN `v_product_type_id` INT, IN `v_product_item_name` VARCHAR(2000), IN `v_product_item_id` INT, IN `v_product_quantity` DECIMAL(18,3), IN `v_employee_id` INT, IN `v_employee_name` VARCHAR(200), IN `v_requisition_date` DATETIME, IN `tickets_code` VARCHAR(100), IN `v_amc_ticket_ids` INT, OUT `ret` VARCHAR(100))
BEGIN
select product_unit_rate,product_brand_name,product_unit into @v_product_unit_rate,@v_product_brand_name,@product_unit from tbl_product_master where product_item_id=v_product_item_id and product_type_id=v_product_type_id and product_category_id=v_product_category_id   limit 1;
set @v_product_grand_total = v_product_quantity * @v_product_unit_rate;
IF v_requ_serial_no = '' THEN 
insert into tbl_mateial_requisition(`amc_tkt_ref_no`, 
`customer_name`, `customer_id`,  
`requisition_mode`,`requisition_date`,`prepared_by`,`prepared_by_id`,status) values(tickets_code,amc_customer_name,amc_customer_id,requisition_mode,v_requisition_date,v_employee_name,v_employee_id,'Generated');
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
IF @v_ret_last_insert_ids >=0 AND @v_ret_last_insert_ids<=9 THEN
	SET @v_requisition_serial_no=CONCAT('R000',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=10 AND @v_ret_last_insert_ids<=99 THEN
	SET @v_requisition_serial_no=CONCAT('R00',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=100 AND @v_ret_last_insert_ids<=999 THEN
	SET @v_requisition_serial_no=CONCAT('R0',@v_ret_last_insert_ids);
END IF;
IF (@v_ret_last_insert_ids>=1000 AND @v_ret_last_insert_ids<=9999) THEN
	SET @v_requisition_serial_no= CONCAT('R',@v_ret_last_insert_ids);
END IF;
UPDATE tbl_mateial_requisition SET requisition_serial_no=@v_requisition_serial_no where requisition_id=@v_ret_last_insert_ids;
INSERT INTO tbl_requision_child (`requisition_id`, `requisition_serial_no`,`asset_ref_no`, `building_name`, `location_name`, `building_id`, `location_id`,`amc_ticket_ids`, `product_category_name`, `product_category_id`, `product_type_name`, `product_type_id`,`product_item_name`, `product_item_id`, `product_unit_rate`,`product_quantity`,`product_unit`, `grant_total`)VALUES(@v_ret_last_insert_ids,@v_requisition_serial_no,amc_asset_code,amc_building_name,amc_location_name,amc_building_id,amc_location_id,v_amc_ticket_ids,v_product_category_name,v_product_category_id,
v_product_type_name,v_product_type_id,v_product_item_name,v_product_item_id,@v_product_unit_rate,
v_product_quantity,@product_unit,@v_product_grand_total);
 set ret= @v_requisition_serial_no;
 ELSE
 SELECT requisition_id INTO @last_requisition_id FROM tbl_mateial_requisition WHERE requisition_serial_no=v_requ_serial_no;
 INSERT INTO tbl_requision_child (`requisition_id`, `requisition_serial_no`,`asset_ref_no`, `building_name`, `location_name`, `building_id`, `location_id`,`amc_ticket_ids`, `product_category_name`, `product_category_id`, `product_type_name`, `product_type_id`,`product_item_name`, `product_item_id`, `product_unit_rate`,`product_quantity`,`product_unit`, `grant_total`)
VALUES(@last_requisition_id,v_requ_serial_no,amc_asset_code,amc_building_name,amc_location_name,amc_building_id,amc_location_id,v_amc_ticket_ids,v_product_category_name,v_product_category_id,v_product_type_name,v_product_type_id,v_product_item_name,v_product_item_id,@v_product_unit_rate,
 v_product_quantity,@product_unit,@v_product_grand_total);
set ret= v_requ_serial_no;
 END IF;
 END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_customer_payment_collection_report`;
DELIMITER ;;
CREATE PROCEDURE `proc_customer_payment_collection_report`(IN `customer_id` INT, IN `amc_code` VARCHAR(20))
    NO SQL
BEGIN
SET @variable = 0;
SELECT    `amc_payments_ids`,customer_code, amc_code,date_format(date_of_payment,'%d-%m-%Y') as date_of_payment,invoice_ref_no, payable_vat_perct,  `total_payable_amt`, `paid_amount`, @variable := @variable + (`total_payable_amt` - `paid_amount`) `Balance`, description,`invoice_ref_no`,`paid_vat_amt`,`total_paid_amt`,`company_closing_entry`,paid_vat_perct
FROM          tbl_customer_payments where customer_id = customer_id and `amc_ref_no` = amc_code
ORDER BY      amc_payments_ids ASC;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_edit_employee_details`;
DELIMITER ;;
CREATE PROCEDURE `proc_edit_employee_details`(IN `v_employee_type_id` INT, IN `v_employee_type_name` VARCHAR(20), IN `v_employee_code` VARCHAR(20), IN `v_employee_password` VARCHAR(20), IN `v_employee_name` VARCHAR(100), IN `v_employee_contact_no` VARCHAR(100), IN `v_employee_email_id` VARCHAR(100), IN `v_employee_address` VARCHAR(50), IN `v_employee_image` VARCHAR(20), IN `v_expertise_id` INT, IN `v_expertise_name` VARCHAR(100), IN `v_employee_id` INT, IN `v_cpr_no` VARCHAR(100), IN `v_blood_group` VARCHAR(100), IN `v_passport_no` VARCHAR(100), IN `v_joining_date` DATE, IN `v_cpr_expiry_date` DATE, IN `v_visa_validity_on` DATE, IN `v_is_driving_license` VARCHAR(100), IN `v_technician_type` VARCHAR(100), IN `v_native_no` VARCHAR(100), IN `v_native_address` TEXT, IN `v_visa_type` VARCHAR(100), OUT `ret` VARCHAR(20))
BEGIN
DECLARE exit handler for sqlexception
  BEGIN
   GET DIAGNOSTICS CONDITION 1
    @p21 = MESSAGE_TEXT;
    set ret = @p21;
      ROLLBACK;
END;
 UPDATE `tbl_employees` SET `employee_type_id`=v_employee_type_id , `employee_type_name`=v_employee_type_name, `employee_code`=v_employee_code, `employee_password`=v_employee_password, `employee_name`=v_employee_name, `employee_contact_no`=v_employee_contact_no, `employee_email_id`=v_employee_email_id, `employee_address`=v_employee_address, `employee_image`=v_employee_image,
`cpr_no`=v_cpr_no,`blood_group`=v_blood_group,`passport_no`=v_passport_no,`joining_date`=v_joining_date,`cpr_expiry_date`=v_cpr_expiry_date,`visa_validity_on`=v_visa_validity_on,`is_driving_license`=v_is_driving_license,`technician_type`=v_technician_type, `native_number`=v_native_no, `native_address`=v_native_address, `visa_type`=v_visa_type where employee_id=v_employee_id;
IF v_employee_type_name='Technician' THEN
 INSERT INTO `tbl_technician_expertise` (`employee_id`, `employee_code`, `employee_name`, `expertise_id`, `expertise_name`) VALUES(v_employee_id,v_employee_code,v_employee_name,v_expertise_id,v_expertise_name);
END IF;
SET ret="success";   
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_edit_lpo`;
DELIMITER ;;
CREATE PROCEDURE `proc_edit_lpo`(IN `v_item_name` VARCHAR(255), IN `v_item_qty` INT, IN `v_item_unit` VARCHAR(100), IN `v_unit_price` DECIMAL(18,3), IN `v_total` DECIMAL(18,3), IN `v_discount_percent` DECIMAL(18,3), IN `v_tax_percent` DECIMAL(18,3), IN `v_grand_total` DECIMAL(18,3), IN `v_lpo_child_id` INT)
    NO SQL
BEGIN
UPDATE tbl_lpo_child set description=v_item_name,quantity=v_item_qty,unit=v_item_unit,unit_price=v_unit_price,total_price=v_total,discount=v_discount_percent,tax=v_tax_percent,grand_total=v_grand_total where lpo_child_id=v_lpo_child_id; 
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_edit_quotation`;
DELIMITER ;;
CREATE PROCEDURE `proc_edit_quotation`(OUT `ret` VARCHAR(100))
    NO SQL
BEGIN
SELECT `quotation_ref_no`, `customer_name`, `po_box`, `contact_no`, `address`, `attention`, `date`, `subject`, `terms_and_condition` from tbl_quotation_master;
SELECT `description`, `quantity`, `unit`, `rate`, `discount`, `vat`,`grant_total` from tbl_quotation_child where quotation_ref_no=quotation_ref_no;
 set ret='Success'; 
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_edit_service_details`;
DELIMITER ;;
CREATE PROCEDURE `proc_edit_service_details`(IN `v_service_id` INT, IN `v_service_description` TEXT, IN `v_category_id` INT, IN `v_category_name` VARCHAR(1000), IN `v_asset_type_id` INT, IN `v_asset_type_name` VARCHAR(100))
    NO SQL
BEGIN
UPDATE `tbl_services` SET `service_description`=v_service_description,`category_id`=v_category_id,`category_name`=v_category_name,`asset_type_id`=v_asset_type_id,`asset_type_name`=v_asset_type_name WHERE `service_id`=v_service_id;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_generate_quotation`;
DELIMITER ;;
CREATE PROCEDURE `proc_generate_quotation`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(100), IN `v_po_box` VARCHAR(100), IN `v_address` TEXT, IN `v_contact_no` VARCHAR(100), IN `v_attension` VARCHAR(1000), IN `v_quotation_date` DATE, IN `v_subject` TEXT, IN `v_description` TEXT, IN `v_quantity` DECIMAL(18,3), IN `v_unit` VARCHAR(100), IN `v_rate` DECIMAL(18,3), IN `v_discount` DECIMAL(18,3), IN `v_tax` DECIMAL(18,3), IN `v_total` DECIMAL(18,3), IN `v_grand_total` DECIMAL(18,3), IN `v_created_by_id` INT, IN `v_created_by_name` VARCHAR(100), IN `v_approved_by_id` INT, IN `v_approved_by_name` VARCHAR(100), IN `v_quotation_number` VARCHAR(100), IN `v_terms_and_condition` TEXT)
    NO SQL
BEGIN
UPDATE `tbl_quotation_master` SET `customer_id`=v_customer_id,`customer_name`=v_customer_name,`po_box`=v_po_box,`contact_no`=v_contact_no,`address`=v_address,`attention`=v_attension,`date`=v_quotation_date,`subject`=v_subject,`terms_and_condition`=v_terms_and_condition,`created_by_id`=v_created_by_id,`created_by_name`=v_created_by_name,`approved_by_id`=v_approved_by_id,`approved_by_name`=v_approved_by_name,`quotation_status`='Generated' WHERE quotation_ref_no=v_quotation_number;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_insert_requisitions`;
DELIMITER ;;
CREATE PROCEDURE `proc_insert_requisitions`(IN `amc_asset_code` VARCHAR(100), IN `amc_customer_name` VARCHAR(100), IN `amc_building_name` VARCHAR(500), IN `amc_location_name` VARCHAR(500), IN `amc_building_id` INT, IN `amc_customer_id` INT, IN `amc_location_id` INT, IN `requisition_mode` VARCHAR(50), IN `v_requ_serial_no` VARCHAR(100), IN `v_product_category_name` VARCHAR(2000), IN `v_product_category_id` INT, IN `v_product_type_name` VARCHAR(2000), IN `v_product_type_id` INT, IN `v_product_item_name` VARCHAR(2000), IN `v_product_item_id` INT, IN `v_product_unit_rate` DECIMAL(18,3), IN `v_product_quantity` DECIMAL(18,3), IN `v_grant_total` DECIMAL(18,3), IN `v_requisition_date` DATETIME, IN `tickets_code` VARCHAR(100), IN `v_amc_tck_id` INT, IN `v_product_unit` VARCHAR(500), IN `v_prepaired_by` VARCHAR(500), IN `v_prepaired_by_id` VARCHAR(500), IN `v_product_brand` VARCHAR(500), OUT `ret` VARCHAR(100))
BEGIN
IF v_requ_serial_no = '' THEN 
insert into tbl_mateial_requisition(`amc_tkt_ref_no`, 
`customer_name`, `customer_id`, 
`requisition_mode`,`requisition_date`,`prepared_by`,`prepared_by_id`) values(tickets_code,amc_customer_name,amc_customer_id,requisition_mode,v_requisition_date,v_prepaired_by,v_prepaired_by_id);
SELECT LAST_INSERT_ID() into  @v_ret_last_insert_ids;
IF @v_ret_last_insert_ids >=0 AND @v_ret_last_insert_ids<=9 THEN
	SET @v_requisition_serial_no=CONCAT('R000',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=10 AND @v_ret_last_insert_ids<=99 THEN
	SET @v_requisition_serial_no=CONCAT('R00',@v_ret_last_insert_ids);
END IF;
IF @v_ret_last_insert_ids >=100 AND @v_ret_last_insert_ids<=999 THEN
	SET @v_requisition_serial_no=CONCAT('R0',@v_ret_last_insert_ids);
END IF;
IF (@v_ret_last_insert_ids>=1000 AND @v_ret_last_insert_ids<=9999) THEN
	SET @v_requisition_serial_no= CONCAT('R',@v_ret_last_insert_ids);
END IF;
UPDATE tbl_mateial_requisition SET requisition_serial_no=@v_requisition_serial_no where requisition_id=@v_ret_last_insert_ids;
INSERT INTO tbl_requision_child (`requisition_id`, `requisition_serial_no`,`asset_ref_no`, `building_name`, `location_name`, `building_id`, `location_id`,`amc_ticket_ids`, `product_category_name`, `product_category_id`, `product_type_name`, `product_type_id`,`product_item_name`, `product_item_id`, `product_unit_rate`,`product_unit`,`product_quantity`,`product_brand`, `grant_total`)VALUES(@v_ret_last_insert_ids,@v_requisition_serial_no,amc_asset_code,amc_building_name,amc_location_name,amc_building_id,amc_location_id,v_amc_tck_id,v_product_category_name,v_product_category_id,
v_product_type_name,v_product_type_id,v_product_item_name,v_product_item_id,v_product_unit_rate,v_product_unit,
v_product_quantity,v_product_brand,v_grant_total);
 set ret= @v_requisition_serial_no;
 ELSE
 SELECT requisition_id INTO @last_requisition_id FROM tbl_mateial_requisition WHERE requisition_serial_no=v_requ_serial_no;
INSERT INTO tbl_requision_child (`requisition_id`, `requisition_serial_no`,`asset_ref_no`, `building_name`, `location_name`, `building_id`, `location_id`,`amc_ticket_ids`, `product_category_name`, `product_category_id`, `product_type_name`, `product_type_id`,`product_item_name`, `product_item_id`, `product_unit_rate`,`product_unit`,`product_quantity`,`product_brand`,`grant_total`)
VALUES(@last_requisition_id,v_requ_serial_no,amc_asset_code,amc_building_name,amc_location_name,amc_building_id,amc_location_id,v_amc_tck_id,v_product_category_name,v_product_category_id,v_product_type_name,v_product_type_id,v_product_item_name,v_product_item_id,v_product_unit_rate,v_product_unit,v_product_quantity,v_product_brand,v_grant_total);
set ret= v_requ_serial_no;
 END IF;
 END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_renewal_amc`;
DELIMITER ;;
CREATE PROCEDURE `proc_renewal_amc`(IN `v_amc_renewal_amount` INT, IN `v_amc_renewal_vat_percentage` VARCHAR(1000), IN `v_amc_renewal_vat_per_amount` INT, IN `v_amc_renewal_start_date` DATE, IN `v_amc_renewal_end_date` DATE, IN `v_amc_renewal_signed_date` DATE, IN `v_amc_ref_no` VARCHAR(100), IN `v_renew_image` VARCHAR(1000), IN `v_renew_notes` VARCHAR(2000), OUT `msg` VARCHAR(200), OUT `p_ids` INT)
    NO SQL
BEGIN
select amc_parent_ref_no into @amc_parent_ref_no from tbl_amc_master where amc_ref_no=v_amc_ref_no LIMIT 1;
 IF @amc_parent_ref_no = '0' THEN
UPDATE tbl_amc_master SET amc_parent_parent_ref_no = v_amc_ref_no WHERE amc_ref_no=v_amc_ref_no;
  INSERT INTO tbl_amc_master ( `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`, `amc_signed_date`, `amc_start_date`, `amc_end_date`, `amc_amount`, `amc_vat_perct`, `amc_vat_amt`, `is_rfp`, `amc_description`, `amc_status`, `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`, `amc_parent_ref_no`,`amc_parent_parent_ref_no`, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc`) SELECT  `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`,v_amc_renewal_signed_date,v_amc_renewal_start_date, v_amc_renewal_end_date,v_amc_renewal_amount,v_amc_renewal_vat_percentage, v_amc_renewal_vat_per_amount, `is_rfp`, `amc_description`, 'Active' , `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`,v_amc_ref_no,v_amc_ref_no, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc` FROM tbl_amc_master WHERE amc_ref_no=v_amc_ref_no ;
 SET @v_inserted_id=LAST_INSERT_ID();                            
 if(@v_inserted_id>=1 and @v_inserted_id<=9)
 then
 	SET @v_amc_no=CONCAT('AMC000',@v_inserted_id);
 end if;
 if(@v_inserted_id>=10 and @v_inserted_id<=99)
 then
 	SET @v_amc_no= CONCAT('AMC00',@v_inserted_id);
 end if;
 if(@v_inserted_id>=100 and @v_inserted_id<=999)
 then
 	SET @v_amc_no= CONCAT('AMC0',@v_inserted_id);
 end if;
 if(@v_inserted_id>=1000 )
 then
 	SET @v_amc_no= CONCAT('AMC',@v_inserted_id);
 end if;
 UPDATE `tbl_amc_master` SET `amc_ref_no`=@v_amc_no, `amc_renewal_attachment`=v_renew_image, `amc_renewal_notes`=v_renew_notes WHERE `amc_id`=@v_inserted_id;
 ELSE 
SELECT amc_parent_parent_ref_no into @amc_parent_parent_ref_no FROM tbl_amc_master WHERE amc_ref_no=v_amc_ref_no LIMIT 1;
 INSERT INTO tbl_amc_master ( `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`, `amc_signed_date`, `amc_start_date`, `amc_end_date`, `amc_amount`, `amc_vat_perct`, `amc_vat_amt`, `is_rfp`, `amc_description`, `amc_status`, `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`, `amc_parent_ref_no`,`amc_parent_parent_ref_no`, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc`) SELECT  `customer_id`, `customer_name`, `customer_code`, `contract_type_id`, `contract_type_name`,v_amc_renewal_signed_date,v_amc_renewal_start_date, v_amc_renewal_end_date,v_amc_renewal_amount,v_amc_renewal_vat_percentage, v_amc_renewal_vat_per_amount, `is_rfp`, `amc_description`, 'Active' , `hold_description`, `created_id`, `modified_id`, `cancelled_on`, `cancelled_description`,v_amc_ref_no,@amc_parent_parent_ref_no, `amc_attachment1`, `amc_attachment1_desc`, `amc_attachment2`, `amc_attachment2_desc`, `amc_attachment3`, `amc_attachment3_desc` FROM tbl_amc_master WHERE amc_ref_no=v_amc_ref_no;
  SET @v_inserted_id=LAST_INSERT_ID();                            
 if(@v_inserted_id>=1 and @v_inserted_id<=9)
 then
 	SET @v_amc_no=CONCAT('AMC000',@v_inserted_id);
 end if;
 if(@v_inserted_id>=10 and @v_inserted_id<=99)
 then
 	SET @v_amc_no= CONCAT('AMC00',@v_inserted_id);
 end if;
 if(@v_inserted_id>=100 and @v_inserted_id<=999)
 then
 	SET @v_amc_no= CONCAT('AMC0',@v_inserted_id);
 end if;
 if(@v_inserted_id>=1000 )
 then
 	SET @v_amc_no= CONCAT('AMC',@v_inserted_id);
 end if;
 UPDATE `tbl_amc_master` SET `amc_ref_no`=@v_amc_no, `amc_renewal_attachment`=v_renew_image, `amc_renewal_notes`=v_renew_notes WHERE `amc_id`=@v_inserted_id;
END IF;
INSERT INTO `tbl_amc_child` ( `amc_master_id`, `amc_ref_no`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`, `amc_child_status`) SELECT  @v_inserted_id, @v_amc_no, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`,  `amc_child_status` from tbl_amc_child where amc_ref_no=v_amc_ref_no ;
set @v_amc_total_amount=v_amc_renewal_amount+v_amc_renewal_vat_per_amount;
 INSERT INTO `tbl_customer_payments` ( `customer_id`, `customer_code`, `ppm_cm`, `amc_id`, `amc_ref_no`, `ticket_id`, `ticket_ref_no`, `date_of_payment`, `invoice_ref_no`, `payable_amt`, `payable_vat_perct`, `payable_vat_amt`, `total_payable_amt`, `paid_amount`, `paid_vat_perct`, `paid_vat_amt`, `total_paid_amt`, `company_closing_entry`, `description`, `payment_status`) SELECT `customer_id`, `customer_code`, `ppm_cm`,@v_inserted_id, @v_amc_no, `ticket_id`, `ticket_ref_no`, v_amc_renewal_signed_date, `invoice_ref_no`, v_amc_renewal_amount, v_amc_renewal_vat_percentage, v_amc_renewal_vat_per_amount, @v_amc_total_amount, `paid_amount`, `paid_vat_perct`, `paid_vat_amt`, `total_paid_amt`, `company_closing_entry`, `description`, `payment_status` FROM tbl_customer_payments where amc_ref_no=v_amc_ref_no and paid_amount = 0;
SET msg=@v_amc_no;
 SET p_ids=@v_inserted_id;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_test`;
DELIMITER ;;
CREATE PROCEDURE `proc_test`(IN `invar` VARCHAR(1000), OUT `msg` VARCHAR(200), OUT `p_ids` INT)
    NO SQL
BEGIN
SET msg='hai';
 SET p_ids=1;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_update_amc`;
DELIMITER ;;
CREATE PROCEDURE `proc_update_amc`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(1000), IN `v_customer_code` VARCHAR(200), IN `v_contract_type_id` INT, IN `v_contract_type_name` VARCHAR(1000), IN `v_amc_signed_date` DATE, IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_amount` DECIMAL(18,3), IN `v_amc_vat_perct` DECIMAL(18,3), IN `v_amc_vat_amt` DECIMAL(18,3), IN `v_is_rfp` VARCHAR(100), IN `v_amc_description` TEXT, IN `v_amc_status` VARCHAR(100), IN `v_hold_description` TEXT, IN `v_created_id` INT, IN `v_modified_id` INT, IN `v_cancelled_on` DATE, IN `v_cancelled_description` TEXT, IN `v_amc_parent_ref_no` VARCHAR(1000), IN `v_amc_attachment1` VARCHAR(2000), IN `v_amc_attachment1_desc` VARCHAR(2000), IN `v_amc_attachment2` VARCHAR(2000), IN `v_amc_attachment2_desc` VARCHAR(2000), IN `v_amc_attachment3` VARCHAR(2000), IN `v_amc_attachment3_desc` VARCHAR(2000), IN `amc_update_id` INT, IN `v_total_payable_amt` DECIMAL(18,3))
BEGIN update tbl_amc_master SET customer_id=v_customer_id,customer_name=v_customer_name,customer_code=v_customer_code,contract_type_id=v_contract_type_id,contract_type_name=v_contract_type_name,amc_signed_date=v_amc_signed_date,amc_start_date=v_amc_start_date,amc_end_date=v_amc_end_date,amc_amount=v_amc_amount,amc_vat_perct=v_amc_vat_perct,amc_vat_amt=v_amc_vat_amt,is_rfp=v_is_rfp,amc_description=v_amc_description,amc_status=v_amc_status,hold_description=v_hold_description,created_id=v_created_id,modified_id=v_modified_id,cancelled_on=v_cancelled_on,cancelled_description=v_cancelled_description,amc_parent_ref_no=v_amc_parent_ref_no,amc_attachment1=v_amc_attachment1,amc_attachment1_desc=v_amc_attachment1_desc,amc_attachment2=v_amc_attachment2,amc_attachment2_desc=v_amc_attachment2_desc,amc_attachment3=v_amc_attachment3,amc_attachment3_desc=v_amc_attachment3_desc where amc_id=amc_update_id;
update tbl_customer_payments SET customer_id=v_customer_id,customer_code=v_customer_code,date_of_payment=v_amc_signed_date,payable_amt=v_amc_amount,payable_vat_perct=v_amc_vat_perct,payable_vat_amt=v_amc_vat_amt,total_payable_amt=v_total_payable_amt where amc_id=amc_update_id and payable_amt != '' ;
END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `proc_update_amc_v1`;
DELIMITER ;;
CREATE PROCEDURE `proc_update_amc_v1`(IN `v_customer_id` INT, IN `v_customer_name` VARCHAR(1000), IN `v_customer_code` VARCHAR(200), IN `v_contract_type_id` INT, IN `v_contract_type_name` VARCHAR(1000), IN `v_amc_signed_date` DATE, IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_amount` DECIMAL(18,3), IN `v_amc_vat_perct` DECIMAL(18,3), IN `v_amc_vat_amt` DECIMAL(18,3), IN `v_is_rfp` VARCHAR(100), IN `v_amc_description` TEXT, IN `v_amc_status` VARCHAR(100), IN `v_hold_description` TEXT, IN `v_created_id` INT, IN `v_modified_id` INT, IN `v_cancelled_on` DATE, IN `v_cancelled_description` TEXT, IN `v_amc_parent_ref_no` VARCHAR(1000), IN `v_amc_attachment1` VARCHAR(2000), IN `v_amc_attachment1_desc` VARCHAR(2000), IN `v_amc_attachment2` VARCHAR(2000), IN `v_amc_attachment2_desc` VARCHAR(2000), IN `v_amc_attachment3` VARCHAR(2000), IN `v_amc_attachment3_desc` VARCHAR(2000), IN `amc_update_id` INT, IN `v_total_payable_amt` DECIMAL(18,3), IN `v_total_amc_amnt` DECIMAL(18,3))
BEGIN update tbl_amc_master SET customer_id=v_customer_id,customer_name=v_customer_name,customer_code=v_customer_code,contract_type_id=v_contract_type_id,contract_type_name=v_contract_type_name,amc_signed_date=v_amc_signed_date,amc_start_date=v_amc_start_date,amc_end_date=v_amc_end_date,amc_amount=v_amc_amount,amc_vat_perct=v_amc_vat_perct,amc_vat_amt=v_amc_vat_amt,total_amc_amount=v_total_amc_amnt,is_rfp=v_is_rfp,amc_description=v_amc_description,amc_status=v_amc_status,hold_description=v_hold_description,created_id=v_created_id,modified_id=v_modified_id,cancelled_on=v_cancelled_on,cancelled_description=v_cancelled_description,amc_parent_ref_no=v_amc_parent_ref_no,amc_attachment1=v_amc_attachment1,amc_attachment1_desc=v_amc_attachment1_desc,amc_attachment2=v_amc_attachment2,amc_attachment2_desc=v_amc_attachment2_desc,amc_attachment3=v_amc_attachment3,amc_attachment3_desc=v_amc_attachment3_desc where amc_id=amc_update_id;
update tbl_customer_payments SET customer_id=v_customer_id,customer_code=v_customer_code,date_of_payment=v_amc_signed_date,payable_amt=v_amc_amount,payable_vat_perct=v_amc_vat_perct,payable_vat_amt=v_amc_vat_amt,total_payable_amt=v_total_payable_amt,payable_total_amc_amnt=v_total_amc_amnt where amc_id=amc_update_id and payable_amt != '' ;
END ;;
DELIMITER ;

SET FOREIGN_KEY_CHECKS=1;
