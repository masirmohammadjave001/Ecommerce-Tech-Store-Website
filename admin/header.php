<?php
session_start();

// 1. SECURITY CHECK
// If user is NOT logged in OR they are NOT an admin...
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['is_admin'] != 1) {
    // ...kick them back to the main login page
    header("Location: ../loginform.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" type="image/png" href="../media/logo.png">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">ADMIN PANEL</a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="dashboard.php">Orders</a>
                <a class="nav-link text-white" href="products.php">Products</a>
                <a class="nav-link text-warning fw-bold" href="../index.php" target="_blank">View Live Site</a>
                <a class="nav-link text-danger" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">