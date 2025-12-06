<?php
require_once "header.php";
require_once "../db/conn.php";

// 1. Check if ID is provided in URL (e.g. edit_product.php?id=5)
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];
$message = "";

// 2. Handle Form Submission (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // --- SMART IMAGE UPDATE LOGIC ---
    // Check if a NEW image was uploaded
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../media/";
        $file_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $db_image_url = "media/" . $file_name;

        // Upload the new file
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // SQL: Update EVERYTHING including the image
        $sql = "UPDATE products SET name=?, description=?, price=?, category=?, stock=?, image_url=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsisi", $name, $desc, $price, $category, $stock, $db_image_url, $id);
    } else {
        // SQL: Update details BUT KEEP OLD IMAGE
        $sql = "UPDATE products SET name=?, description=?, price=?, category=?, stock=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdsii", $name, $desc, $price, $category, $stock, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        // Success! Redirect with a 'msg' parameter so products.php knows to show the green bar
        header("Location: products.php?msg=updated");
        exit();
    } else {
        $message = "Error updating record: " . mysqli_error($conn);
    }
}

// 3. Fetch Current Product Data (To fill the form)
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found!";
    exit();
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Product</h2>
            <a href="products.php" class="btn btn-outline-secondary">Back to List</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Product Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select">
                                <option <?php echo ($product['category'] == 'Laptops') ? 'selected' : ''; ?>>Laptops</option>
                                <option <?php echo ($product['category'] == 'Desktops') ? 'selected' : ''; ?>>Desktops</option>
                                <option <?php echo ($product['category'] == 'Components') ? 'selected' : ''; ?>>Components</option>
                                <option <?php echo ($product['category'] == 'Accessories') ? 'selected' : ''; ?>>Accessories</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stock Quantity</label>
                            <input type="number" name="stock" class="form-control" value="<?php echo $product['stock']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Update Image</label>
                            <input type="file" name="image" class="form-control">
                            <div class="form-text text-muted">Leave empty to keep current image.</div>
                        </div>

                        <div class="col-12 mt-3 text-center">
                            <p class="text-muted small mb-1">Current Image:</p>
                            <img src="../<?php echo $product['image_url']; ?>" style="height: 100px; object-fit: contain; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Update Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>

</html>