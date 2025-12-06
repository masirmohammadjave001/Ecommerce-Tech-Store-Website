<?php
require_once "header.php"; 
require_once "../db/conn.php"; 


$sql = "SELECT o.id, o.total_price, o.order_date, u.name, u.email 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        ORDER BY o.order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> Order deleted successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($_GET['msg'] == 'error'): ?>
            <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> Error deleting order.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <h2>All Customer Orders</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                            <div class="small text-muted"><?php echo htmlspecialchars($row['email']); ?></div>
                        </td>
                        <td><?php echo date("M j, Y", strtotime($row['order_date'])); ?></td>
                        <td class="fw-bold text-success">$<?php echo $row['total_price']; ?></td>
                        <td>
                            <a href="orderdetail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View Items</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>


<script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>