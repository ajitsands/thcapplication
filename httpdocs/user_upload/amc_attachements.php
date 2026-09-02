<?php

if ($_FILES['file']['error'] > 0) {

    echo 'Error: ' . $_FILES['file']['error'];

} else {

    $folder = __DIR__ . '/../images/amc_attachements/';
    if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
    }

    $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['file']['name']);

    $destination = $folder . $_GET['random_no'] . '_' . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {

        echo "Uploaded";
        echo "<br>Size: " . filesize($destination);

    } else {

        echo "Upload Failed";
    }
}
?>