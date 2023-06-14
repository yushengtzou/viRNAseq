<?php

session_start();
echo 'upload script accessed'; 

var_dump($_SESSION);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Taipei');

include('../php/db_config.php');

if(isset($_POST["submit"])) {
    var_dump($_FILES);
    $fileName = $_FILES['files']['name'];
    $username = $_SESSION['username']; 

    $sql = "INSERT INTO UploadHistory (username, filename, upload_time) VALUES (?, ?, ?)";
    $stmt= $db->prepare($sql);
    
    if ($stmt === false) { die($conn->error); }
    
    $stmt->bind_param("sss", $username, $fileName, date("Y-m-d H:i:s"));
    $stmt->execute();
  
    echo "Record saved successfully";
} else {
    echo "No file uploaded";
}
?>


