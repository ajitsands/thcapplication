<?php
include('../../model/db_connection/connection.php');
$DBConn = new DBConnection();
$conn = $DBConn->ConnectToMYSQL();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'save_checklist') {
        $checklist_id = (int)$_POST['checklist_id'];
        $checklist_name = mysqli_real_escape_string($conn, $_POST['checklist_name']);
        
        // $_POST['categories'] is an array of categories, where each has 'name' and 'points' array
        $categories = isset($_POST['categories']) ? $_POST['categories'] : [];

        mysqli_autocommit($conn, FALSE);
        try {
            if ($checklist_id == 0) {
                // Insert New Checklist
                $sql = "INSERT INTO tbl_janitor_checklists (checklist_name) VALUES ('$checklist_name')";
                if (!mysqli_query($conn, $sql)) throw new Exception(mysqli_error($conn));
                $checklist_id = mysqli_insert_id($conn);
            } else {
                // Update Existing Checklist
                $sql = "UPDATE tbl_janitor_checklists SET checklist_name='$checklist_name' WHERE id=$checklist_id";
                if (!mysqli_query($conn, $sql)) throw new Exception(mysqli_error($conn));
                
                // Get old categories to delete their items
                $old_cats_res = mysqli_query($conn, "SELECT id FROM tbl_janitor_checklist_categories WHERE checklist_id=$checklist_id");
                while($old_cat = mysqli_fetch_assoc($old_cats_res)) {
                    $cid = $old_cat['id'];
                    mysqli_query($conn, "DELETE FROM tbl_janitor_checklist_items WHERE checklist_category_id=$cid");
                }
                // Delete old categories
                mysqli_query($conn, "DELETE FROM tbl_janitor_checklist_categories WHERE checklist_id=$checklist_id");
            }

            // Insert Categories and Points
            foreach ($categories as $cat) {
                $c_name = mysqli_real_escape_string($conn, $cat['name']);
                if (!empty($c_name)) {
                    $sql_cat = "INSERT INTO tbl_janitor_checklist_categories (checklist_id, category_name) VALUES ($checklist_id, '$c_name')";
                    if (!mysqli_query($conn, $sql_cat)) throw new Exception(mysqli_error($conn));
                    
                    $cat_id = mysqli_insert_id($conn);
                    
                    if (isset($cat['points']) && is_array($cat['points'])) {
                        foreach ($cat['points'] as $pt) {
                            $p_name = mysqli_real_escape_string($conn, $pt);
                            if (!empty($p_name)) {
                                $sql_pt = "INSERT INTO tbl_janitor_checklist_items (checklist_category_id, item_description) VALUES ($cat_id, '$p_name')";
                                if (!mysqli_query($conn, $sql_pt)) throw new Exception(mysqli_error($conn));
                            }
                        }
                    }
                }
            }

            mysqli_commit($conn);
            echo json_encode(["status" => "success", "message" => "Checklist saved successfully"]);
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
    else if ($action == 'list_checklists') {
        $data = [];
        // Count total categories and total points
        $sql = "SELECT c.*, 
                (SELECT COUNT(id) FROM tbl_janitor_checklist_categories WHERE checklist_id = c.id) as total_categories,
                (SELECT COUNT(i.id) FROM tbl_janitor_checklist_items i 
                 INNER JOIN tbl_janitor_checklist_categories cat ON i.checklist_category_id = cat.id 
                 WHERE cat.checklist_id = c.id) as total_points
                FROM tbl_janitor_checklists c ORDER BY c.id DESC";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        echo json_encode(["data" => $data]);
    }
    else if ($action == 'get_checklist') {
        $id = (int)$_POST['checklist_id'];
        
        $chk_res = mysqli_query($conn, "SELECT * FROM tbl_janitor_checklists WHERE id = $id");
        $chk = mysqli_fetch_assoc($chk_res);
        
        $categories = [];
        $cat_res = mysqli_query($conn, "SELECT * FROM tbl_janitor_checklist_categories WHERE checklist_id = $id ORDER BY id ASC");
        while ($cat_row = mysqli_fetch_assoc($cat_res)) {
            $cat_id = $cat_row['id'];
            
            $points = [];
            $pt_res = mysqli_query($conn, "SELECT * FROM tbl_janitor_checklist_items WHERE checklist_category_id = $cat_id ORDER BY id ASC");
            while ($pt_row = mysqli_fetch_assoc($pt_res)) {
                $points[] = $pt_row;
            }
            $cat_row['points'] = $points;
            $categories[] = $cat_row;
        }
        
        echo json_encode(["checklist" => $chk, "categories" => $categories]);
    }
    else if ($action == 'change_status') {
        $id = (int)$_POST['checklist_id'];
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        mysqli_query($conn, "UPDATE tbl_janitor_checklists SET status = '$status' WHERE id = $id");
        echo json_encode(["status" => "success"]);
    }
}
?>
