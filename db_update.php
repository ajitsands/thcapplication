<?php
include('model/db_connection/connection.php');
$DBConn = new DBConnection();
$varDBConnection = $DBConn->ConnectToMYSQL();

// 1. Add column if it doesn't exist
$col_check = mysqli_query($varDBConnection, "SHOW COLUMNS FROM `tbl_assets` LIKE 'is_janitor_asset'");
if (mysqli_num_rows($col_check) == 0) {
    mysqli_query($varDBConnection, "ALTER TABLE `tbl_assets` ADD `is_janitor_asset` VARCHAR(10) DEFAULT 'NO' COMMENT 'YES/NO'");
    echo "Column is_janitor_asset added.\n";
} else {
    echo "Column is_janitor_asset already exists.\n";
}

// 2. Drop and Recreate proc_amc_add_assets
mysqli_query($varDBConnection, "DROP PROCEDURE IF EXISTS proc_amc_add_assets");
$proc1 = "
CREATE PROCEDURE `proc_amc_add_assets`(IN `v_asset_ref_no` VARCHAR(200), IN `v_asset_category_id` INT, IN `v_asset_category_name` VARCHAR(2000), IN `v_asset_type_id` INT, IN `v_asset_type_name` VARCHAR(2000), IN `v_customer_id` INT, IN `v_customer_code` VARCHAR(200), IN `v_customer_name` VARCHAR(2000), IN `v_location_id` INT, IN `v_asset_location` VARCHAR(2000), IN `v_location_code` VARCHAR(200), IN `v_building_id` INT, IN `v_building_code` VARCHAR(100), IN `v_asset_building` VARCHAR(2000), IN `v_zone_or_floor` VARCHAR(1000), IN `v_flat_area_code` VARCHAR(100), IN `v_room_no` VARCHAR(1000), IN `v_asset_sp_des` VARCHAR(1000), IN `v_asset_serial_no` VARCHAR(2000), IN `v_asset_brand` VARCHAR(2000), IN `v_asset_capacity` VARCHAR(2000), IN `v_asset_cost` DECIMAL(18,2), IN `v_is_warentee` VARCHAR(10), IN `v_warentee_end_date` DATE, IN `v_asset_attachment` VARCHAR(2000), IN `v_asset_description` TEXT, IN `v_asset_status` VARCHAR(100), IN `v_created_id` INT, IN `v_created_name` VARCHAR(200), IN `v_created_date` DATE, IN `v_modified_id` INT, IN `v_modified_name` VARCHAR(200), IN `v_modified_date` DATE, IN `v_amc_ref_no` VARCHAR(500), IN `v_amc_start_date` DATE, IN `v_amc_end_date` DATE, IN `v_amc_id` INT, IN `v_is_janitor_asset` VARCHAR(10), OUT `v_inserted_id` INT)
    NO SQL
BEGIN
INSERT INTO `tbl_assets`(`asset_ref_no`, `asset_category_id`, `asset_category_name`, `asset_type_id`, `asset_type_name`, `customer_id`, `customer_code`, `customer_name`, `location_id`, `asset_location`,`building_code`, `asset_building`, `zone_floor`, `flat_area_code`, `room_no`, `asset_sp_des`, `asset_serial_no`, `asset_brand`, `asset_capacity`, `asset_cost`, `is_warentee`, `warentee_end_date`, `asset_attachment`, `asset_description`, `asset_status`, `created_id`, `created_name`, `created_date`, `modified_id`, `modified_name`, `modified_date`,`location_code`,`building_id`,`amc_ref_no`,`amc_start_date`,`amc_end_date`, `is_janitor_asset`) VALUES (v_asset_ref_no,v_asset_category_id,v_asset_category_name,v_asset_type_id,v_asset_type_name,v_customer_id,v_customer_code,v_customer_name,v_location_id,v_asset_location,v_building_code,v_asset_building,v_zone_or_floor,v_flat_area_code,v_room_no,v_asset_sp_des,v_asset_serial_no,v_asset_brand,v_asset_capacity,v_asset_cost,v_is_warentee,v_warentee_end_date,v_asset_attachment,v_asset_description,v_asset_status,v_created_id,v_created_name,v_created_date,v_modified_id,v_modified_name,v_modified_date,v_location_code,v_building_id,v_amc_ref_no,v_amc_start_date,v_amc_end_date, v_is_janitor_asset);
SET v_inserted_id=LAST_INSERT_ID(); 
INSERT INTO `tbl_amc_child` (`amc_master_id`, `amc_ref_no`, `category_id`, `category_name`, `asset_type_id`, `asset_type_name`, `asset_id`, `asset_ref_no`, `amc_child_status`) VALUES (v_amc_id,v_amc_ref_no, v_asset_category_id,v_asset_category_name,v_asset_type_id,v_asset_type_name,v_inserted_id,v_asset_ref_no, 'Active');
END
";
if(mysqli_query($varDBConnection, $proc1)){
    echo "Procedure proc_amc_add_assets updated.\n";
} else {
    echo "Error updating proc_amc_add_assets: " . mysqli_error($varDBConnection) . "\n";
}

// 3. Drop and Recreate proc_amc_edit_assets
mysqli_query($varDBConnection, "DROP PROCEDURE IF EXISTS proc_amc_edit_assets");
$proc2 = "
CREATE PROCEDURE `proc_amc_edit_assets`(IN `v_assets_id` INT, IN `v_asset_ref_no` VARCHAR(200), IN `v_asset_category_id` INT, IN `v_asset_category_name` VARCHAR(2000), IN `v_asset_type_id` INT, IN `v_asset_type_name` VARCHAR(2000), IN `v_cust_id` INT, IN `v_cust_code` VARCHAR(200), IN `v_cust_name` VARCHAR(2000), IN `v_location_id` INT, IN `v_asset_location_code` VARCHAR(200), IN `v_asset_location` VARCHAR(2000), IN `v_asset_building_id` INT, IN `v_asset_building_code` VARCHAR(200), IN `v_asset_building` VARCHAR(2000), IN `v_zone_or_floor_no` VARCHAR(500), IN `v_flat_area_code` VARCHAR(1000), IN `v_asset_roon_no` VARCHAR(1000), IN `v_asset_specify_description` VARCHAR(2000), IN `v_asset_serial_no` VARCHAR(1000), IN `v_asset_brand` VARCHAR(2000), IN `v_asset_capacity` VARCHAR(2000), IN `v_asset_cost` DECIMAL(18,3), IN `v_is_warentee` VARCHAR(200), IN `v_warentee_end_date` DATE, IN `assets_attachment_file` VARCHAR(20000), IN `v_asset_description` TEXT, IN `v_modified_date` DATE, IN `v_is_janitor_asset` VARCHAR(10), OUT `ret` VARCHAR(20))
    NO SQL
BEGIN
UPDATE `tbl_assets` SET `asset_ref_no`=v_asset_ref_no,`asset_category_id`=v_asset_category_id,`asset_category_name`=v_asset_category_name,`asset_type_id`=v_asset_type_id,`asset_type_name`=v_asset_type_name,`customer_id`=v_cust_id,`customer_code`=v_cust_code,`customer_name`=v_cust_name,`location_id`=v_location_id,`location_code`=v_asset_location_code,`asset_location`=v_asset_location,`building_id`=v_asset_building_id,`building_code`=v_asset_building_code,`asset_building`=v_asset_building,`zone_floor`=v_zone_or_floor_no,`flat_area_code`=v_flat_area_code,`room_no`=v_asset_roon_no,`asset_sp_des`=v_asset_specify_description,`asset_serial_no`=v_asset_serial_no,`asset_brand`=v_asset_brand,`asset_capacity`=v_asset_capacity,`asset_cost`=v_asset_cost,`is_warentee`=v_is_warentee,`warentee_end_date`=v_warentee_end_date,`asset_attachment`=assets_attachment_file,`asset_description`=v_asset_description,`modified_date`=v_modified_date, `is_janitor_asset`=v_is_janitor_asset WHERE `asset_id`=v_assets_id;	
SET ret=\"success\";   
END
";
if(mysqli_query($varDBConnection, $proc2)){
    echo "Procedure proc_amc_edit_assets updated.\n";
} else {
    echo "Error updating proc_amc_edit_assets: " . mysqli_error($varDBConnection) . "\n";
}
?>
