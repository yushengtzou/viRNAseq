<?php
session_start(); // start the session

if(isset($_SESSION['username'])){ // check if session variable 'username' exists
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
}

header("Location: ../index.php"); // redirect to the index or login page
exit();
?>

