<?php
$title = "Home";
require_once "./includes/header.php";
require_once "./db/conn.php"; // Connect to DB

// Fetch 4 newest products for "Trending"
$trending_sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$trending_result = mysqli_query($conn, $trending_sql);
?>
<main class="flex-grow-1">

    <section class="hero-section text-center text-md-start">
        <div class="container-fluid p-0 overflow-hidden">
            <div class="row g-0 align-items-center" style="min-height: 55vh;">
                <div class="col-md-5 p-4">
                    <div class="px-lg-5">
                        <h5 class="text-warning fw-bold text-uppercase mb-3">Power Your Potential</h5>
                        <h1 class="display-3 fw-bold mb-4">Build Your Dream <br>Battlestation.</h1>
                        <p class="lead hero-desc mb-5">
                            Discover the latest components, laptops, and peripherals at unbeatable prices.
                        </p>
                        <div class="d-flex gap-3 justify-content-center justify-content-md-start">
                            <a href="products.php" class="btn btn-warning btn-lg px-4 fw-bold shadow-sm">Shop Now</a>
                            <a href="signupform.php" class="btn btn-outline-secondary btn-lg px-4" id="join-btn">Join Club</a>
                        </div>
                    </div>
                </div>
                <div class="vid col-md-7 p-5 h-100">
                    <div class="video-container h-100">
                        <video class="w-100 h-100" autoplay loop muted playsinline style="object-fit: cover;">
                            <source src="media/home-video.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 bg-dark text-white border-top border-bottom border-secondary">
        <div class="container-fluid">
            <div class="row text-center g-4 benefits-bar">
                <div class="col-md-4">
                    <h5 class="fw-bold text-warning"><i class="fas fa-truck me-2"></i> Fast Delivery</h5>
                    <p class="text-white-50 small m-0">Get your gear in 2-3 days.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold text-warning"><i class="fas fa-shield-alt me-2"></i> 2-Year Warranty</h5>
                    <p class="text-white-50 small m-0">On all pre-built systems.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold text-warning"><i class="fas fa-undo me-2"></i> Easy Returns</h5>
                    <p class="text-white-50 small m-0">30-day money-back guarantee.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container-fluid py-5" style="padding-left: 5%; padding-right: 5%;">
        <h3 class="fw-bold mb-4 ps-2">Shop by Category</h3>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <a href="products.php?category=Laptops" class="text-decoration-none">
                    <div class="card h-100 cat-card text-center p-4">
                        <img src="media/laptop.png" class="img-fluid mb-3 cat-img" alt="Laptops" style="height: 320px; object-fit: contain;">
                        <h5 class="fw-bold mb-0">Laptops</h5>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="products.php?category=Desktops" class="text-decoration-none">
                    <div class="card h-100 cat-card text-center p-4">
                        <img src="media/desktop.png" class="img-fluid mb-3 cat-img" alt="Desktops" style="height: 280px; object-fit: contain;">
                        <h5 class="fw-bold mb-0">Desktops</h5>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="products.php?category=Components" class="text-decoration-none">
                    <div class="card h-100 cat-card text-center p-4">
                        <img src="media/component.png" class="img-fluid mb-3 cat-img" alt="Components" style="height: 280px; object-fit: contain;">
                        <h5 class="fw-bold mb-0">Components</h5>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="products.php?category=Accessories" class="text-decoration-none">
                    <div class="card h-100 cat-card text-center p-4">
                        <img src="media/accessory.png" class="img-fluid mb-3 cat-img" alt="Accessories" style="height: 320px; object-fit: contain;">
                        <h5 class="fw-bold mb-0">Accessories</h5>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="container-fluid py-5" style="padding-left: 5%; padding-right: 5%;">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h3 class="fw-bold mb-0 border-start border-4 border-warning ps-3">Trending Now</h3>
            <a href="products.php" class="text-warning text-decoration-none fw-bold">View All &rarr;</a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php while ($item = mysqli_fetch_assoc($trending_result)): ?>
                <div class="col">
                    <div class="card h-100 border border-light-subtle shadow-sm product-card">

                        <a href="product.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-body">
                            <div class="p-4 d-flex align-items-center justify-content-center position-relative" style="height: 220px;">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>"
                                    class="img-fluid"
                                    style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                        </a>

                        <div class="card-body border-top border-light-subtle">
                            <small class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">
                                <?php echo htmlspecialchars($item['category']); ?>
                            </small>

                            <h6 class="card-title fw-bold mt-2 mb-3 text-truncate">
                                <a href="product.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-body">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            </h6>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning fw-bold fs-5">$<?php echo $item['price']; ?></span>

                                <?php if ($item['stock'] > 0): ?>
                                    <form action="addtocart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-outline-warning btn-sm rounded-circle shadow-sm" title="Add to Cart">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge bg-secondary text-white">Sold Out</span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

</main>

<?php require_once "./includes/footer.php" ?>