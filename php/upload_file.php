<?php

echo 'Login script accessed';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["submit"])) {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        
        //Redirect to the index page after successful file upload
        header("Location: ../index.php"); // This line will redirect you to index.php
        exit; // Ensure no further output is sent
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<?php
