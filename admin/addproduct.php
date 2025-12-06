<?php
require_once "header.php";
require_once "../db/conn.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    $target_dir = "../media/";

    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;

    $db_image_url = "media/" . $file_name;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO products (name, description, price, category, stock, image_url) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssdsis", $name, $desc, $price, $category, $stock, $db_image_url);

            if (mysqli_stmt_execute($stmt)) {

                header("Location: products.php?msg=added");
                exit();
            } else {
                $message = "Database Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $message = "Error uploading image. Make sure the 'media' folder exists!";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-10">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Product</h2>
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
                            <input type="text" name="name" class="form-control" placeholder="e.g. Gaming Mouse" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category</label>
                            <select name="category" class="form-select">
                                <option>Laptops</option>
                                <option>Desktops</option>
                                <option>Components</option>
                                <option>Accessories</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="10" placeholder="Enter product details..." required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Price ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Stock Quantity</label>
                            <input type="number" name="stock" class="form-control" value="10" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Product Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">Save Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>

</html>