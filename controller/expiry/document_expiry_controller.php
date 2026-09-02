<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);

require_once(__DIR__ . '/../../model/common/common_functions.php');

class DocumentExpiryController
{
    public $varModelObj;
    public $varDBConnection;
    public $actionevents;

    public function __construct()
    {
        $this->varModelObj = new CommonModel();
        $this->varDBConnection = $this->varModelObj->varDBConnection;
        $this->actionevents = isset($_POST['action']) ? trim($_POST['action']) : (isset($_GET['action']) ? trim($_GET['action']) : '');
        date_default_timezone_set('Asia/Bahrain');
    }

    public function RequestAccept($action)
    {
        switch ($action) {
            case 'list_document_expiries':
                $this->listDocumentExpiries();
                break;

            case 'get_distinct_doc_types':
                $this->getDistinctDocTypes();
                break;

            case 'get_employee_types':
                $this->getEmployeeTypes();
                break;

            default:
                echo json_encode(array('status' => 'error', 'message' => 'No Action Found!'));
                break;
        }
    }

    private function listDocumentExpiries()
    {
        $conn = $this->varDBConnection;

        $from_date = isset($_POST['from_date']) ? trim($_POST['from_date']) : '';
        $to_date = isset($_POST['to_date']) ? trim($_POST['to_date']) : '';
        $days_filter = isset($_POST['days_filter']) ? trim($_POST['days_filter']) : 'all';
        $custom_days = isset($_POST['custom_days']) ? intval($_POST['custom_days']) : 0;
        $doc_name = isset($_POST['doc_name']) ? mysqli_real_escape_string($conn, trim($_POST['doc_name'])) : 'all';
        $emp_type_id = isset($_POST['emp_type_id']) ? mysqli_real_escape_string($conn, trim($_POST['emp_type_id'])) : 'all';
        $emp_status = isset($_POST['emp_status']) ? mysqli_real_escape_string($conn, trim($_POST['emp_status'])) : 'Active';

        $where = array();
        $where[] = "a.status = 'Active'";
        $where[] = "a.expiry_date IS NOT NULL";
        $where[] = "a.expiry_date != '0000-00-00'";
        $where[] = "a.expiry_date != '1970-01-01'";

        // Date Range Filter
        if (!empty($from_date) && !empty($to_date)) {
            $from_esc = mysqli_real_escape_string($conn, $from_date);
            $to_esc = mysqli_real_escape_string($conn, $to_date);
            $where[] = "a.expiry_date BETWEEN '$from_esc' AND '$to_esc'";
        } elseif (!empty($from_date)) {
            $from_esc = mysqli_real_escape_string($conn, $from_date);
            $where[] = "a.expiry_date >= '$from_esc'";
        } elseif (!empty($to_date)) {
            $to_esc = mysqli_real_escape_string($conn, $to_date);
            $where[] = "a.expiry_date <= '$to_esc'";
        }

        // Days Filter
        if ($days_filter == 'expired') {
            $where[] = "a.expiry_date < CURDATE()";
        } elseif ($days_filter == '7') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
        } elseif ($days_filter == '15') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)";
        } elseif ($days_filter == '30') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
        } elseif ($days_filter == '60') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 60 DAY)";
        } elseif ($days_filter == '90') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 90 DAY)";
        } elseif ($days_filter == '180') {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 180 DAY)";
        } elseif ($days_filter == 'custom' && $custom_days > 0) {
            $where[] = "a.expiry_date >= CURDATE() AND a.expiry_date <= DATE_ADD(CURDATE(), INTERVAL $custom_days DAY)";
        }

        // Document Type Filter
        if (!empty($doc_name) && $doc_name != 'all') {
            $where[] = "a.document_name = '$doc_name'";
        }

        // Employee Type Filter
        if (!empty($emp_type_id) && $emp_type_id != 'all') {
            $where[] = "(e.employee_type_id = '$emp_type_id' OR e.employee_type_name = '$emp_type_id')";
        }

        // Employee Status Filter
        if (!empty($emp_status) && $emp_status != 'all') {
            $where[] = "e.employee_status = '$emp_status'";
        }

        $whereClause = implode(" AND ", $where);

        $sql = "SELECT 
            a.attachment_id,
            a.employee_id,
            a.employee_code,
            a.document_name,
            a.expiry_date,
            a.file_path,
            a.original_file_name,
            a.remarks,
            a.created_at,
            e.employee_name,
            e.employee_type_name,
            e.employee_type_id,
            e.employee_image,
            e.employee_contact_no,
            e.employee_status,
            e.cpr_no,
            DATE_FORMAT(a.expiry_date, '%d/%m/%Y') AS formatted_expiry_date,
            DATE_FORMAT(a.created_at, '%d/%m/%Y') AS formatted_created_at,
            DATEDIFF(a.expiry_date, CURDATE()) AS days_to_expire,
            CASE 
                WHEN a.expiry_date < CURDATE() THEN 'Expired'
                WHEN DATEDIFF(a.expiry_date, CURDATE()) <= 30 THEN 'Expiring Soon'
                ELSE 'Valid'
            END AS expiry_status_label
        FROM tbl_employee_attachments a
        LEFT JOIN tbl_employees e ON a.employee_id = e.employee_id
        WHERE $whereClause
        ORDER BY a.expiry_date ASC, e.employee_name ASC";

        $result = mysqli_query($conn, $sql);

        $data = array();
        $stats = array(
            'total' => 0,
            'expired' => 0,
            'expiring_soon' => 0,
            'valid' => 0
        );

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $days = intval($row['days_to_expire']);
                
                $stats['total']++;
                if ($days < 0) {
                    $stats['expired']++;
                } elseif ($days <= 30) {
                    $stats['expiring_soon']++;
                } else {
                    $stats['valid']++;
                }

                // Format employee image
                $empImg = (!empty($row['employee_image']) && $row['employee_image'] != 'null' && strpos($row['employee_image'], 'fakepath') === false) 
                    ? trim($row['employee_image']) 
                    : 'default.jpg';
                $row['employee_image_formatted'] = $empImg;

                $data[] = $row;
            }
        }

        echo json_encode(array(
            'data' => $data,
            'stats' => $stats
        ));
    }

    private function getDistinctDocTypes()
    {
        $conn = $this->varDBConnection;
        $sql = "SELECT DISTINCT document_name FROM tbl_employee_attachments WHERE status = 'Active' AND document_name IS NOT NULL AND document_name != '' ORDER BY document_name ASC";
        $result = mysqli_query($conn, $sql);
        $types = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $types[] = $row['document_name'];
            }
        }
        echo json_encode(array('status' => 'success', 'data' => $types));
    }

    private function getEmployeeTypes()
    {
        $conn = $this->varDBConnection;
        $sql = "SELECT user_type_id AS employee_type_id, user_type_name AS employee_type_name FROM tbl_user_types WHERE user_type_status = 'Active' ORDER BY user_type_name ASC";
        $result = mysqli_query($conn, $sql);
        $types = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $types[] = $row;
            }
        }
        if (empty($types)) {
            $sql2 = "SELECT DISTINCT employee_type_id, employee_type_name FROM tbl_employees WHERE employee_type_name IS NOT NULL AND employee_type_name != '' AND employee_type_name != 'NA' ORDER BY employee_type_name ASC";
            $res2 = mysqli_query($conn, $sql2);
            if ($res2) {
                while ($r2 = mysqli_fetch_assoc($res2)) {
                    $types[] = $r2;
                }
            }
        }
        echo json_encode(array('status' => 'success', 'data' => $types));
    }
}

$controller = new DocumentExpiryController();
$controller->RequestAccept($controller->actionevents);
