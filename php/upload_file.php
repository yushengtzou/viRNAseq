<?php

session_start();
echo 'upload script accessed'; 

var_dump($_SESSION);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../php/db_config.php');

if(isset($_POST["submit"])) {
    var_dump($_FILES);
    $fileName = $_FILES['files']['name'];
    $userId = $_SESSION['user_id']; 

    $sql = "INSERT INTO UploadHistory (user_id, filename, upload_time) VALUES (?, ?, ?)";
    $stmt= $db->prepare($sql);
    
    if ($stmt === false) { die($conn->error); }
    
    $stmt->bind_param("sss", $userId, $fileName, date("Y-m-d H:i:s"));
    $stmt->execute();
  
    echo "Record saved successfully";
} else {
    echo "No file uploaded";
}
?>


