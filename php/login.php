<?php
ob_start(); // start output buffering

echo 'Login script accessed';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db_config.php');
session_start();

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $query = "SELECT * FROM users WHERE username='$username'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_assoc($results);
            // Verify the password with the hashed password in the database
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are now logged in";
                header('location: ../php/history.php');
                exit(); // use exit after redirection to prevent further script execution
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "User does not exist");
        }
    }

    if (count($errors) > 0) {
        echo "Errors:<br>";
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

ob_end_flush(); // send output buffer and turn off output buffering
?>
