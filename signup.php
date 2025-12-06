<?php

require_once './db/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name = trim($_POST['fname']) . ' ' . trim($_POST['lname']); 
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    

    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    $postal_code = trim($_POST['postal_code']);


    if ($password !== $confirm_password) {
        die("Error: Passwords do not match.");
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO users (name, username, email, password, address, city, province, postal_code) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $username, $email, $hashed_password, $address, $city, $province, $postal_code);

        if (mysqli_stmt_execute($stmt)) {

            header("Location: loginform.php");
            exit();
        } else {
            echo "Error executing query: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
}
?>