<?php
session_start();
require_once "./db/conn.php";

// 1. Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: loginform.php");
    exit();
}

// 2. Check if an ID was passed in the URL
if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    // 3. Security Check: Only delete if the cart item belongs to THIS user
    // We use "AND user_id = ?" to ensure they can't delete someone else's item
    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $cart_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            // Success!
        } else {
            // Optional: Log error
        }
        mysqli_stmt_close($stmt);
    }
}

// 4. Redirect back to the cart page
header("Location: cart.php");
exit();
