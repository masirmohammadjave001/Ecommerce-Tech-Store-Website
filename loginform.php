<?php session_start();
$title = "Log in";
require_once "./includes/header.php" ?>

<main class="d-flex align-items-center min-vh-100 py-5">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6 col-xl-5">

                <div class="card login-card border-0 shadow-lg">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="bg-warning-subtle text-warning d-inline-flex p-3 rounded-circle mb-3">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <h3 class="fw-bold">Welcome Back</h3>
                            <p class="text-muted small">Enter your credentials to access your account.</p>
                        </div>

                        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                            <div class="alert alert-danger d-flex align-items-center mb-4 small fw-bold" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>Invalid email or password. Please try again.</div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="login.php">

                            <div class="mb-3">
                                <label for="inputEmail" class="form-label small fw-bold text-muted">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0" id="inputEmail" name="email" placeholder="name@example.com" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="inputPassword" class="form-label small fw-bold text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="inputPassword" name="password" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-warning fw-bold py-3 shadow-sm text-uppercase letter-spacing-1">
                                    Login
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-0">Don't have an account?
                                    <a href="signupform.php" class="text-warning fw-bold text-decoration-none">Sign Up</a>
                                </p>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php require_once "./includes/footer.php" ?>