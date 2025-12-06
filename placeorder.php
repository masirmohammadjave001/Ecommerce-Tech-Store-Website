<?php
$title = "Processing Order...";
require_once "./includes/header.php";
require_once "./db/conn.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>location.href='loginform.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$order_success = false;
$cart_items = [];
$final_total = 0;
$order_id = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- CAPTURE ADDRESS FROM FORM ---
    $address = $_POST['address'] ?? '';
    $city = $_POST['city'] ?? '';
    $zip = $_POST['zip'] ?? '';
    // ---------------------------------

    // 2. Fetch Cart Items
    $cart_sql = "SELECT c.product_id, p.name, p.price, c.quantity 
                 FROM cart c 
                 JOIN products p ON c.product_id = p.id 
                 WHERE c.user_id = ?";

    if ($cart_stmt = mysqli_prepare($conn, $cart_sql)) {
        mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
        mysqli_stmt_execute($cart_stmt);
        $result = mysqli_stmt_get_result($cart_stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
            $final_total += ($row['price'] * $row['quantity']);
        }
        mysqli_stmt_close($cart_stmt);
    }

    if (empty($cart_items)) {
        echo "<script>location.href='cart.php';</script>";
        exit();
    }

    $tax = $final_total * 0.13;
    $grand_total = $final_total + $tax;

    // 3. Insert into ORDERS Table (WITH ADDRESS SNAPSHOT)
    // We now save the address directly into the order record
    $insert_sql = "INSERT INTO orders (user_id, total_price, shipping_address, shipping_city, shipping_zip) VALUES (?, ?, ?, ?, ?)";

    if ($order_stmt = mysqli_prepare($conn, $insert_sql)) {
        mysqli_stmt_bind_param($order_stmt, "idsss", $user_id, $grand_total, $address, $city, $zip);

        if (mysqli_stmt_execute($order_stmt)) {
            $order_success = true;
            $order_id = mysqli_insert_id($conn);

            // 4. INSERT ORDER ITEMS
            $item_sql = "INSERT INTO order_items (order_id, product_id, product_name, price, quantity) VALUES (?, ?, ?, ?, ?)";
            if ($item_stmt = mysqli_prepare($conn, $item_sql)) {
                foreach ($cart_items as $item) {
                    mysqli_stmt_bind_param($item_stmt, "iisdi", $order_id, $item['product_id'], $item['name'], $item['price'], $item['quantity']);
                    mysqli_stmt_execute($item_stmt);
                }
                mysqli_stmt_close($item_stmt);
            }

            // 5. UPDATE INVENTORY STOCK
            $stock_sql = "UPDATE products SET stock = stock - ? WHERE id = ?";
            if ($stock_stmt = mysqli_prepare($conn, $stock_sql)) {
                foreach ($cart_items as $item) {
                    mysqli_stmt_bind_param($stock_stmt, "ii", $item['quantity'], $item['product_id']);
                    mysqli_stmt_execute($stock_stmt);
                }
                mysqli_stmt_close($stock_stmt);
            }

            // 6. CLEAR THE CART
            $clear_sql = "DELETE FROM cart WHERE user_id = ?";
            if ($clear_stmt = mysqli_prepare($conn, $clear_sql)) {
                mysqli_stmt_bind_param($clear_stmt, "i", $user_id);
                mysqli_stmt_execute($clear_stmt);
                mysqli_stmt_close($clear_stmt);
            }
        } else {
            echo "<div class='alert alert-danger'>Error placing order: " . mysqli_error($conn) . "</div>";
        }
        mysqli_stmt_close($order_stmt);
    }
} else {
    echo "<script>location.href='cart.php';</script>";
    exit();
}
?>

<div class="container py-5">
    <?php if ($order_success): ?>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg text-center p-5 mb-4">
                    <div class="mb-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                            <i class="fas fa-check fa-3x"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-success mb-2">Order Confirmed!</h2>
                    <p class="text-muted">Thank you for your purchase, <?php echo htmlspecialchars($_SESSION['name']); ?>.</p>
                    <p class="small text-muted mb-4">Your order <strong>#<?php echo $order_id; ?></strong> has been placed successfully.</p>

                    <div class="alert alert-light border small text-muted">
                        Shipping to: <strong><?php echo htmlspecialchars("$address, $city, $zip"); ?></strong>
                    </div>

                    <a href="index.php" class="btn btn-warning fw-bold px-5 rounded-pill shadow-sm text-uppercase">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once "./includes/footer.php" ?>