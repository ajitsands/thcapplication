<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../images/subcontractors_reg_form/' .$_GET["random_no"].'_'.  $_FILES['file']['name']);
       // echo "Uploaded";
    }

?>
