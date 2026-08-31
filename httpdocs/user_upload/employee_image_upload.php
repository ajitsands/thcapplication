<?php

    if (isset($_FILES['file']) && 0 < $_FILES['file']['error']) {
        echo json_encode(['status' => 'error', 'message' => 'Upload error: ' . $_FILES['file']['error']]);
        exit;
    }

    if (isset($_FILES['file'])) {
        $target_dir = __DIR__ . '/../images/employee_image/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $random_no = isset($_GET["random_no"]) ? preg_replace('/[^0-9]/', '', $_GET["random_no"]) : rand(100000, 999999);
        $clean_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $_FILES['file']['name']);
        $filename = $random_no . '_' . $clean_name;
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $filename)) {
            echo json_encode(['status' => 'success', 'filename' => $filename]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save uploaded file']);
        }
    }
?>
