<?php

header("Access-Control-Allow-Origin: *"); // Ideally restrict to your domain
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $upload_dir = '../images/ticket_book_image/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filename = rand(100000, 999999) . '_' . basename($_FILES['file']['name']);
    $target = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        echo json_encode(['status' => 'success', 'filename' => $filename]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Upload failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file received']);
}

?>