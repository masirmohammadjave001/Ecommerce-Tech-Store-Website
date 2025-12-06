<?php
// 1. Setup and Connection
require_once "./includes/header.php";
require_once "./db/conn.php";

// 2. Check if ID is in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Use Prepared Statement
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $product = $row;
    } else {
        echo "<div class='container py-5'><h2>Product not found!</h2></div>";
        require_once "./includes/footer.php";
        exit();
    }
} else {
    header("Location: products.php");
    exit();
}
?>

<div class="container py-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="products.php" class="text-decoration-none text-muted">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['category']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-3 bg-white d-flex align-items-center justify-content-center" style="min-height: 400px;">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                    class="img-fluid"
                    style="max-height: 500px; width: auto; object-fit: contain;"
                    alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
        </div>

        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px; z-index: 1;">

                <span class="badge bg-warning text-dark mb-2"><?php echo htmlspecialchars($product['category']); ?></span>
                <h1 class="fw-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
                <h2 class="text-warning fw-bold mb-3 display-5">$<?php echo $product['price']; ?></h2>

                <div class="mb-4 border-bottom pb-4">
                    <?php if ($product['stock'] > 0): ?>
                        <div class="text-success fw-bold mb-1"><i class="fas fa-check-circle me-1"></i> In Stock</div>
                        <small class="text-muted">Ships within 24 hours</small>
                    <?php else: ?>
                        <div class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Out of Stock</div>
                    <?php endif; ?>
                </div>

                <form action="addtocart.php" method="POST" class="mb-4">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                    <label class="small fw-bold text-muted mb-1">Quantity</label>
                    <div class="input-group">
                        <select name="quantity" class="form-select border-secondary text-center"
                            style="max-width: 80px; cursor: pointer;"
                            <?php if ($product['stock'] == 0) echo 'disabled'; ?>>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>

                        <button type="submit"
                            class="btn btn-warning fw-bold shadow-sm flex-grow-1"
                            <?php if ($product['stock'] <= 0) echo 'disabled'; ?>> <?php if ($product['stock'] > 0): ?>
                                <i class="fas fa-shopping-cart me-2"></i> Add to Cart
                            <?php else: ?>
                                <i class="fas fa-times-circle me-2"></i> Sold Out
                            <?php endif; ?>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">

            <div class="accordion shadow-sm" id="productInfo">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                            <i class="fas fa-align-left me-2 text-warning"></i> Product Description
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#productInfo">
                        <div class="accordion-body text-muted">
                            <div class="lead fs-6">
                                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            <i class="fas fa-truck me-2 text-warning"></i> Shipping & Returns
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#productInfo">
                        <div class="accordion-body small text-muted">
                            <strong>Free Shipping:</strong> On all orders over $50.<br>
                            <strong>Returns:</strong> 30-day money-back guarantee if the item is unopened.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<?php require_once "./includes/footer.php" ?>