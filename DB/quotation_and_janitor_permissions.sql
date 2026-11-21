-- ===================================================================
-- THC Facility Management: Quotation Module Permission Configuration
-- Run this script on database (e.g. portal.thcfm.com) to:
-- 1. Enable single "Quotation" module access permission in Settings (module 16)
-- 2. Hide legacy quotation sub-menus (Create, View, Revision) from tree
-- 3. Remove Janitor Settings and Janitor Calendar from permissions
-- 4. Assign Quotation module privilege to Administrator & Managers
-- ===================================================================

-- 1. Ensure Quotation module exists and is Active in tbl_app_modules
INSERT INTO `tbl_app_modules` (`ids`, `module_name`, `module_classview_id`, `status`)
VALUES (16, 'Quotation', 151, 'Active')
ON DUPLICATE KEY UPDATE `status` = 'Active', `module_name` = 'Quotation';

-- 2. Enable single primary 'Quotation' permission in module_permissions
INSERT INTO `module_permissions` (`module_permission_name`, `module_id`, `module_status`, `role_id`)
VALUES ('Quotation', 16, 'Yes', 0)
ON DUPLICATE KEY UPDATE `module_status` = 'Yes';

-- Hide legacy sub-permissions so tree only shows single 'Quotation' entry
UPDATE `module_permissions`
SET `module_status` = 'No'
WHERE `module_id` = 16 AND `module_permission_name` IN ('CreateQuotation', 'ViewQuotation', 'ViewQuotationRevision', 'QuotationModule');

DELETE FROM `role_permissions_v1`
WHERE `module_id` = 16 AND `sub_module_name` IN ('CreateQuotation', 'ViewQuotation', 'ViewQuotationRevision', 'QuotationModule');

-- Ensure Janitor Settings & Calendar are hidden from permission settings
UPDATE `module_permissions`
SET `module_status` = 'No'
WHERE `module_id` = 21 AND `module_permission_name` IN ('JanitorSettings', 'JanitorCalendar');

DELETE FROM `role_permissions_v1`
WHERE `sub_module_name` IN ('JanitorSettings', 'JanitorCalendar');

-- 3. Ensure permissions table entries for fallback
INSERT IGNORE INTO `permissions` (`name`, `class_name`, `module_id`) VALUES
('Quotation', 'classQuotation', 16),
('QuotationModule', 'classQuotationModule', 16);

-- 4. Pre-assign Quotation permission to Administrator, Operation Coordinator, Operation Manager, and Operations Manager
-- (Admins can also assign/toggle via Permission Settings UI in roll_and_permissions.php)
INSERT IGNORE INTO `role_permissions_v1` (`role_id`, `permission_id`, `module_id`, `sub_module_name`, `module_name`)
SELECT r.role_id, mp.ids, 16, 'Quotation', 'Quotation'
FROM `module_permissions` mp
CROSS JOIN (
    SELECT 1 AS role_id UNION SELECT 2 UNION SELECT 5 UNION SELECT 11
) r
WHERE mp.module_id = 16 AND mp.module_permission_name = 'Quotation' AND mp.module_status = 'Yes';

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`, `module_id`)
SELECT r.role_id, mp.ids, 16
FROM `module_permissions` mp
CROSS JOIN (
    SELECT 1 AS role_id UNION SELECT 2 UNION SELECT 5 UNION SELECT 11
) r
WHERE mp.module_id = 16 AND mp.module_permission_name = 'Quotation' AND mp.module_status = 'Yes';
