<?php

$dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME , DB_USER , DB_PASS);

// Get new instance of PDO object
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>