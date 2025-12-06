<?php
require_once "header.php";
require_once "../db/conn.php";


$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container-fluid px-4" style="max-width: 90%;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if (isset($_GET['msg'])): ?>
            <?php
            $msg = $_GET['msg'];
            $alertClass = "alert-success";
            $icon = "fa-check-circle";
            $text = "Operation successful!";

            if ($msg == 'updated') {
                $text = "Product updated successfully!";
            } elseif ($msg == 'added') {
                $text = "New product added successfully!";
            } elseif ($msg == 'deleted') {
                $alertClass = "alert-danger"; 
                $icon = "fa-trash";
                $text = "Product deleted successfully.";
            }
            ?>
            <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas <?php echo $icon; ?> me-2"></i> <?php echo $text; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2>Product Inventory</h2>

        <a href="addproduct.php" class="btn btn-success fw-bold">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="ps-4">#<?php echo $row['id']; ?></td>
                                <td>
                                    <img src="../<?php echo htmlspecialchars($row['image_url']); ?>"
                                        style="width: 50px; height: 50px; object-fit: contain;">
                                </td>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['category']); ?></span></td>
                                <td>$<?php echo $row['price']; ?></td>
                                <td>
                                    <?php if ($row['stock'] > 0): ?>
                                        <span class="text-success fw-bold"><?php echo $row['stock']; ?> in stock</span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold">Out of stock</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4 text-nowrap">
                                    <a href="editproduct.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="deleteproduct.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    </body>

    </html>