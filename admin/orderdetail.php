<?php
require_once "header.php";
require_once "../db/conn.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$order_id = $_GET['id'];


$order_sql = "SELECT o.*, u.name, u.email 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              WHERE o.id = ?";
$stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));


$items_sql = "SELECT * FROM order_items WHERE order_id = ?";
$stmt = mysqli_prepare($conn, $items_sql);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$items = mysqli_stmt_get_result($stmt);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Order #<?php echo $order_id; ?> Details</h2>
    <div>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
        <a href="deleteorder.php?id=<?php echo $order_id; ?>"
            class="btn btn-danger fw-bold ms-2">
            <i class="fas fa-trash me-2"></i> Delete Order
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">Customer Info</div>
            <div class="card-body">
                <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>

                <p class="mb-1">
                    <strong>Address:</strong>
                    <?php echo htmlspecialchars($order['shipping_address'] . ', ' . $order['shipping_city'] . ' ' . $order['shipping_zip']); ?>
                </p>

                <p class="mb-0"><strong>Date:</strong> <?php echo date("M j, Y g:i A", strtotime($order['order_date'])); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">Items Purchased</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($items)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>$<?php echo $item['price']; ?></td>
                                <td>x<?php echo $item['quantity']; ?></td>
                                <td class="text-end fw-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr class="bg-light">
                            <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                            <td class="text-end fw-bold text-success fs-5">$<?php echo $order['total_price']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>

</html>