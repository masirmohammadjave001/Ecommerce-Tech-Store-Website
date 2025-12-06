<?php
$title = "Products";
require_once "./includes/header.php";
require_once "./db/conn.php";




$sql = "SELECT * FROM products";
$where_clauses = [];
$params = [];
$types = ""; 


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
    $where_clauses[] = "name LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}


$category = isset($_GET['category']) ? $_GET['category'] : '';
if (!empty($category)) {
    $where_clauses[] = "category = ?";
    $params[] = $category;
    $types .= "s";
}


$min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? $_GET['max_price'] : 99999;


if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
    $where_clauses[] = "price BETWEEN ? AND ?";
    $params[] = $min_price;
    $params[] = $max_price;
    $types .= "dd"; 
}


if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// 6. Sorting Logic
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY price DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}


$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {

    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Discover Products</h2>
        <span class="text-muted small">Showing <?php echo mysqli_num_rows($result); ?> results</span>
    </div>

    <div class="card border-0 shadow-sm mb-5 filter-bar overflow-hidden">
        <div class="card-body p-4">
            <form action="products.php" method="GET">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label small fw-bold text-muted"><i class="fas fa-search me-1"></i> Search</label>
                        <input type="text" name="search" class="form-control" placeholder="What are you looking for?" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="fas fa-layer-group me-1"></i> Category</label>
                        <select name="category" class="form-select">
                            <option value="" <?php if ($category == "") echo "selected"; ?>>All Categories</option>
                            <option value="Laptops" <?php if ($category == "Laptops") echo "selected"; ?>>Laptops</option>
                            <option value="Desktops" <?php if ($category == "Desktops") echo "selected"; ?>>Desktops</option>
                            <option value="Components" <?php if ($category == "Components") echo "selected"; ?>>Components</option>
                            <option value="Accessories" <?php if ($category == "Accessories") echo "selected"; ?>>Accessories</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="fas fa-tag me-1"></i> Price Range</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent text-muted">$</span>
                            <input type="number" name="min_price" class="form-control" placeholder="Min" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                            <span class="input-group-text bg-transparent border-start-0 border-end-0">-</span>
                            <input type="number" name="max_price" class="form-control" placeholder="Max" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="fas fa-sort me-1"></i> Sort By</label>
                        <select name="sort" class="form-select">
                            <option value="newest" <?php if ($sort == "newest") echo "selected"; ?>>Newest Arrivals</option>
                            <option value="price_asc" <?php if ($sort == "price_asc") echo "selected"; ?>>Price: Low to High</option>
                            <option value="price_desc" <?php if ($sort == "price_desc") echo "selected"; ?>>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-4 pt-2 border-top border-light-subtle">
                        <a href="products.php" class="btn btn-link text-decoration-none text-muted fw-bold btn-sm">Reset Filters</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4 shadow-sm">Show Results</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm product-card">

                        <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-body">
                            <div class="p-4 bg-light-subtle text-center rounded-top">
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                                    class="img-fluid"
                                    style="height: 150px; object-fit: contain;"
                                    alt="<?php echo htmlspecialchars($row['name']); ?>">
                            </div>
                        </a>

                        <div class="card-body">
                            <small class="text-uppercase text-muted fw-bold">
                                <?php echo htmlspecialchars($row['category']); ?>
                            </small>

                            <h5 class="fw-bold mt-1">
                                <a href="product.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-body">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </a>
                            </h5>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold">$<?php echo $row['price']; ?></span>

                                <?php if ($row['stock'] > 0): ?>
                                    <form action="addtocart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-outline-warning btn-sm rounded-circle">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled style="font-size: 0.75rem;">
                                        Out of Stock
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h3>No products found!</h3></div>';
        }
        ?>
    </div>

</div>

<?php require_once "./includes/footer.php" ?>