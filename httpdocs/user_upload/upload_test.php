<?php
$folder = "../images/amc_attachements/";
$file = $folder . "test.txt";

$result = file_put_contents($file, "Hello World");

if ($result !== false) {
    echo "SUCCESS<br>";
    echo "Size: " . filesize($file);
} else {
    echo "FAILED";
}