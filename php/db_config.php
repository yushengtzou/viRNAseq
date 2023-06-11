<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = ''; // default is empty for XAMPP
    $db_name = 'viRNAseq'; 

    // Just create one mysqli object
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check the connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
?>
