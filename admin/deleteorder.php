<?php
session_start();
require_once "../db/conn.php"; 


if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1 || !isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

$sql_items = "DELETE FROM order_items WHERE order_id = ?";
if ($stmt = mysqli_prepare($conn, $sql_items)) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


$sql_order = "DELETE FROM orders WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql_order)) {
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        header("Location: dashboard.php?msg=deleted");
        exit();
    } else {

        header("Location: dashboard.php?msg=error");
        exit();
    }
    mysqli_stmt_close($stmt);
}
