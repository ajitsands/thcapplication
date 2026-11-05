-- ===================================================================
-- THC Facility Management: Quotation & Janitor Operations Permissions
-- Run this script on database (e.g. portal.thcfm.com) to enable:
-- 1. Quotation in Permissions & Settings (module 16)
-- 2. Janitor Settings & Janitor Calendar in Permissions & Settings (module 21)
-- 3. Pre-assign permissions to Admin (role 1) and Operations Managers
-- ===================================================================

-- 1. Ensure modules exist and are Active in tbl_app_modules
INSERT INTO `tbl_app_modules` (`ids`, `module_name`, `module_classview_id`, `status`)
VALUES (16, 'Quotation', 151, 'Active')
ON DUPLICATE KEY UPDATE `status` = 'Active', `module_name` = 'Quotation';

INSERT INTO `tbl_app_modules` (`ids`, `module_name`, `module_classview_id`, `status`)
VALUES (21, 'Janitor Operations', 0, 'Active')
ON DUPLICATE KEY UPDATE `status` = 'Active', `module_name` = 'Janitor Operations';

-- 2. Enable / Insert module_permissions
-- Quotation module permissions (Module 16)
INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('Quotation', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('QuotationModule', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('CreateQuotation', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('ViewQuotation', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('ViewQuotationRevision', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

-- Janitor operations permissions (Module 21)
INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('JanitorModule', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('ChecklistMaster', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('JanitorAssignment', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('JanitorExecutionReport', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('JanitorSettings', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('JanitorCalendar', 21, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

-- 3. Ensure permissions table entries for fallback
INSERT IGNORE INTO `permissions` (`name`, `class_name`, `module_id`) VALUES
('Quotation', 'classQuotation', 16),
('QuotationModule', 'classQuotationModule', 16),
('CreateQuotation', 'classCreateQuotation', 16),
('ViewQuotation', 'classViewQuotation', 16),
('ViewQuotationRevision', 'classViewQuotationRevision', 16),
('JanitorSettings', 'classJanitorSettings', 21),
('JanitorCalendar', 'classJanitorCalendar', 21);

-- 4. Pre-assign permissions to Administrator (Role 1), Operation Manager (Role 5), etc.
-- Dynamic join insertion to match assigned permission IDs automatically
INSERT IGNORE INTO `role_permissions_v1` (`role_id`, `permission_id`, `module_id`, `sub_module_name`, `module_name`)
SELECT 1, mp.ids, mp.module_id, mp.module_permission_name, 'Quotation'
FROM `module_permissions` mp
WHERE mp.module_id = 16 AND mp.module_status = 'Yes';

INSERT IGNORE INTO `role_permissions_v1` (`role_id`, `permission_id`, `module_id`, `sub_module_name`, `module_name`)
SELECT 1, mp.ids, mp.module_id, mp.module_permission_name, 'Janitor Operations'
FROM `module_permissions` mp
WHERE mp.module_id = 21 AND mp.module_status = 'Yes';

-- Also assign to Operation Manager (Role 5)
INSERT IGNORE INTO `role_permissions_v1` (`role_id`, `permission_id`, `module_id`, `sub_module_name`, `module_name`)
SELECT 5, mp.ids, mp.module_id, mp.module_permission_name, 'Quotation'
FROM `module_permissions` mp
WHERE mp.module_id = 16 AND mp.module_status = 'Yes';

INSERT IGNORE INTO `role_permissions_v1` (`role_id`, `permission_id`, `module_id`, `sub_module_name`, `module_name`)
SELECT 5, mp.ids, mp.module_id, mp.module_permission_name, 'Janitor Operations'
FROM `module_permissions` mp
WHERE mp.module_id = 21 AND mp.module_status = 'Yes';
