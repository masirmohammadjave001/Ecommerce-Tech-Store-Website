<?php 
$title = "Cart";
require_once "./includes/header.php";
require_once "./db/conn.php";

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>location.href='loginform.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$cart_items = [];


$sql = "SELECT c.id as cart_id, c.quantity, p.id as product_id, p.name, p.price, p.image_url, p.category 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
    mysqli_stmt_close($stmt);
}

// 3. Calculate Totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += ($item['price'] * $item['quantity']);
}
$tax_rate = 0.13; // 13% HST
$tax = $subtotal * $tax_rate;
$total = $subtotal + $tax;
?>

<div class="container py-5">

    <h2 class="fw-bold mb-4">Shopping Cart <span class="text-muted fs-5 fw-normal ms-2">(<?php echo count($cart_items); ?> items)</span></h2>

    <?php if (empty($cart_items)): ?>
        <div class="text-center py-5">
            <h3 class="fw-bold">Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added any gear yet.</p>
            <a href="products.php" class="btn btn-warning fw-bold px-4 mt-2">Start Shopping</a>
        </div>
    <?php else: ?>

        <div class="row g-5">
            <div class="col-lg-8">
                <?php foreach ($cart_items as $item): ?>
                    <div class="card cart-card border-0 shadow-sm mb-3 overflow-hidden">
                        <div class="row g-0 align-items-center">

                            <div class="col-md-3 col-4 p-3 bg-light-subtle d-flex align-items-center justify-content-center h-100">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="img-fluid rounded" alt="Product" style="max-height: 100px; object-fit: contain;">
                            </div>

                            <div class="col-md-9 col-8">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;"><?php echo htmlspecialchars($item['category']); ?></small>
                                            <h5 class="card-title fw-bold mb-0">
                                                <a href="product.php?id=<?php echo $item['product_id']; ?>" class="text-decoration-none text-body">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </a>
                                            </h5>
                                        </div>
                                        <h5 class="fw-bold text-end">$<?php echo number_format($item['price'], 2); ?></h5>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <label class="small text-muted fw-bold">Qty:</label>
                                            <select class="form-select form-select-sm border-secondary-subtle" style="width: 70px;" disabled>
                                                <option selected><?php echo $item['quantity']; ?></option>
                                            </select>
                                        </div>

                                        <a href="remove.php?id=<?php echo $item['cart_id']; ?>" class="text-danger text-decoration-none small fw-bold remove-btn">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="card summary-card border-0 shadow-sm p-4 sticky-top" style="top: 100px; z-index: 1;">
                    <h5 class="fw-bold mb-4">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="text-success fw-bold">Free</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                        <span class="text-muted">Est. Tax (13%)</span>
                        <span class="fw-bold">$<?php echo number_format($tax, 2); ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-4 fw-bold text-warning">$<?php echo number_format($total, 2); ?></span>
                    </div>

                    <a class="btn btn-warning w-100 fw-bold py-2 shadow-sm mb-3" href="./checkout.php">Proceed to Checkout</a>

                    <div class="text-center">
                        <a href="products.php" class="text-decoration-none text-muted small fw-bold">
                            <i class="fas fa-arrow-left me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php require_once "./includes/footer.php" ?>