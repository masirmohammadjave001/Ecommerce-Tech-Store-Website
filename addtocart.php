<?php
session_start();
// Use your specific path (ensure this file exists)
require_once "./db/conn.php";

// 1. Check Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: loginform.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Get data
    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity <= 0) $quantity = 1;

    // --- SECURITY CHECK: VERIFY STOCK LEVEL FIRST ---
    $stock_sql = "SELECT stock FROM products WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $stock_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $current_stock);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt); 


        if ($quantity > $current_stock) {
            echo "<script>alert('Sorry! Not enough stock available.'); window.history.back();</script>";
            exit();
        }
    }

    $check_sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    if ($stmt = mysqli_prepare($conn, $check_sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            mysqli_stmt_bind_result($stmt, $cart_id, $current_qty);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt); 

            $new_quantity = $current_qty + $quantity;


            if ($new_quantity > $current_stock) {
                echo "<script>alert('You already have this item in your cart. Adding more would exceed stock limits.'); window.history.back();</script>";
                exit();
            }

            $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
            if ($update_stmt = mysqli_prepare($conn, $update_sql)) {
                mysqli_stmt_bind_param($update_stmt, "ii", $new_quantity, $cart_id);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }
        } else {
     
            mysqli_stmt_close($stmt); 

            $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            if ($insert_stmt = mysqli_prepare($conn, $insert_sql)) {
                mysqli_stmt_bind_param($insert_stmt, "iii", $user_id, $product_id, $quantity);
                mysqli_stmt_execute($insert_stmt);
                mysqli_stmt_close($insert_stmt);
            }
        }
    }


    header("Location: cart.php");
    exit();
} else {
    header("Location: products.php");
    exit();
}
