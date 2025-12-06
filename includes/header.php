<?php
// 1. Start the session on every page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Store</title>

    <link rel="icon" type="image/png" href="./media/logo.png">

    <link rel="stylesheet" href="./css/bootstrap.css" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <header class="shadow-sm sticky-top bg-body-tertiary" style="z-index: 1000;">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid px-4">

                <a class="navbar-brand fw-bold text-uppercase d-flex align-items-center gap-2" href="index.php">
                    <i class="fas fa-microchip text-warning fs-4"></i>
                    <span class="text-body" style="letter-spacing: 1px;">Computer Store</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link px-3 fw-semibold <?php echo (isset($page) && $page == 'index.php') ? 'active text-warning' : 'text-body'; ?>"
                                href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 fw-semibold <?php echo (isset($page) && $page == 'products.php') ? 'active text-warning' : 'text-body'; ?>"
                                href="products.php">PRODUCTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 fw-semibold <?php echo (isset($page) && $page == 'cart.php') ? 'active text-warning' : 'text-body'; ?>"
                                href="cart.php">
                                <i class="fas fa-shopping-cart me-1"></i> CART
                            </a>
                        </li>
                    </div>

                    <div class="d-flex align-items-center gap-3">

                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>

                            <div class="d-flex align-items-center gap-2 border-end pe-3 border-secondary">
                                <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white" style="width: 35px; height: 35px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <span class="navbar-text fw-bold text-body">
                                    Hi, <?php echo htmlspecialchars($_SESSION['name']); ?>
                                </span>
                            </div>

                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <a href="admin/dashboard.php" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold">
                                    <i class="fas fa-tools me-1"></i> Admin
                                </a>
                            <?php endif; ?>

                            <a href="account.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Account</a>
                            <a href="logout.php" class="btn btn-outline-danger rounded-pill px-3 btn-sm fw-bold">Logout</a>

                        <?php else: ?>

                            <div class="d-flex gap-2">
                                <a href="loginform.php" class="btn btn-link text-decoration-none fw-semibold text-body">Login</a>
                                <a href="signupform.php" class="btn btn-warning rounded-pill px-4 fw-bold text-dark shadow-sm">Sign Up</a>
                            </div>

                        <?php endif; ?>

                        <div class="btn-group shadow-sm bg-dark rounded-pill p-1 border border-secondary" role="group">
                            <button class="btn btn-sm text-white rounded-circle" data-bs-theme-value="dark" title="Dark Mode">
                                <i class="fas fa-moon"></i>
                            </button>
                            <button class="btn btn-sm text-white rounded-circle" data-bs-theme-value="light" title="Light Mode">
                                <i class="fas fa-sun"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
    </header>