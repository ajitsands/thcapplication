<?php

require('../model/db_connection/connection.php');
require('converttohtml.php');
require('datafromdb.php');



$pdf = new createPDF($out_put);

$pdf->run();


?>