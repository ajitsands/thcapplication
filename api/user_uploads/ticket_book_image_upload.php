<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $folder = __DIR__ . '/../images/ticket_book_image/';
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $folder . $_GET["random_no"] . '_' . $_FILES['file']['name']);
       // echo "Uploaded";
    }

?>