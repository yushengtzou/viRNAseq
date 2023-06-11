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
        
        // Removed the database related code here...

        //Redirect to the index page after successful file upload
        header("Location: ../index.php"); // This line will redirect you to index.php
        exit; // Ensure no further output is sent
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

// <?php
//
// echo 'Login script accessed';
//
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//
// // Your database config might be different
// $servername = "localhost";
// $username = "root";   // default username for XAMPP is root
// $password = "";       // default password for XAMPP is blank
// $dbname = "viRNAseq"; // change this to your database name
//
// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
//
// // Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
//
// if(isset($_POST["submit"])) {
//     $target_dir = "../uploads/";
//     $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//
//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
//         
//         $file = fopen($target_file,"r");
//
//         $header = fgetcsv($file); // Get the header row
//         while (($data = fgetcsv($file)) !== FALSE) {
//             $species = mysqli_real_escape_string($conn, $data[0]);
//             $island = mysqli_real_escape_string($conn, $data[1]);
//             $culmen_length_mm = is_numeric($data[2]) ? mysqli_real_escape_string($conn, $data[2]) : 'NULL';
//             $culmen_depth_mm = is_numeric($data[3]) ? mysqli_real_escape_string($conn, $data[3]) : 'NULL';
//             $flipper_length_mm = is_numeric($data[4]) ? mysqli_real_escape_string($conn, $data[4]) : 'NULL';
//             $body_mass_g = is_numeric($data[5]) ? mysqli_real_escape_string($conn, $data[5]) : 'NULL';
//             $sex = mysqli_real_escape_string($conn, $data[6]);
//
//             $query = "INSERT INTO species_data(species, island, culmen_length_mm, culmen_depth_mm, flipper_length_mm, body_mass_g, sex)
//             VALUES ('$species', '$island', $culmen_length_mm, $culmen_depth_mm, $flipper_length_mm, $body_mass_g, '$sex')";
//
//             if (mysqli_query($conn, $query)) {
//                 // echo 'Row inserted!<br>';
//             } else {
//                 echo 'Error inserting row: ' . mysqli_error($conn) . '<br>';
//             }
//         }
//         fclose($file);
//         header("Location: ../index.php"); // This line will redirect you to index.php
//         exit; // Ensure no further output is sent
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
// }
// ?>
