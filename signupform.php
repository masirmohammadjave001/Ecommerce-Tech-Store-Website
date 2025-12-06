<?php $title = "Sign Up";
require_once "./includes/header.php" ?>

<main class="py-5 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                <div class="card login-card border-0 shadow-lg overflow-hidden">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-5">
                            <h2 class="fw-bold text-uppercase letter-spacing-1">Create Account</h2>
                            <p class="text-muted">Join the club and build your dream setup.</p>
                        </div>

                        <form class="row g-4" method="POST" action="signup.php" onsubmit="return validatePassword()">

                            <div class="col-12 mb-2">
                                <h6 class="fw-bold text-warning text-uppercase small border-bottom pb-2 mb-3">
                                    <i class="fas fa-user-circle me-2"></i> Account Details
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label small fw-bold text-muted">First Name</label>
                                <input type="text" class="form-control" id="inputFirstName" name="fname" placeholder="John" required>
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label small fw-bold text-muted">Last Name</label>
                                <input type="text" class="form-control" id="inputLastName" name="lname" placeholder="Doe" required>
                            </div>

                            <div class="col-md-6">
                                <label for="inputUsername" class="form-label small fw-bold text-muted">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-muted"><i class="fas fa-at"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="inputUsername" name="username" placeholder="johndoe123" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label small fw-bold text-muted">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-muted"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0" id="inputEmail" name="email" placeholder="john@example.com" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label small fw-bold text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label small fw-bold text-muted">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-muted"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-0" id="confirm_password" name="confirmpassword" placeholder="••••••••" required>
                                </div>
                                <div id="passwordError" class="text-danger small fw-bold mt-1" style="display:none;">
                                    <i class="fas fa-exclamation-circle me-1"></i> Passwords do not match!
                                </div>
                            </div>

                            <div class="col-12 mt-4 mb-2">
                                <h6 class="fw-bold text-warning text-uppercase small border-bottom pb-2 mb-3">
                                    <i class="fas fa-truck me-2"></i> Shipping Details
                                </h6>
                            </div>

                            <div class="col-12">
                                <label for="inputAddress" class="form-label small fw-bold text-muted">Street Address</label>
                                <input type="text" class="form-control" id="inputAddress" name="address" placeholder="123 Gaming Lane, Apt 4" required>
                            </div>

                            <div class="col-md-5">
                                <label for="inputCity" class="form-label small fw-bold text-muted">City</label>
                                <input type="text" class="form-control" id="inputCity" name="city" placeholder="Toronto" required>
                            </div>
                            <div class="col-md-4">
                                <label for="inputState" class="form-label small fw-bold text-muted">Province</label>
                                <select id="inputState" class="form-select" name="province" required>
                                    <option value="" selected disabled>Choose...</option>
                                    <option>Alberta</option>
                                    <option>British Columbia</option>
                                    <option>Manitoba</option>
                                    <option>New Brunswick</option>
                                    <option>Newfoundland and Labrador</option>
                                    <option>Northwest Territories</option>
                                    <option>Nova Scotia</option>
                                    <option>Nunavut</option>
                                    <option>Ontario</option>
                                    <option>Prince Edward Island</option>
                                    <option>Quebec</option>
                                    <option>Saskatchewan</option>
                                    <option>Yukon</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="inputZip" class="form-label small fw-bold text-muted">Postal Code</label>
                                <input type="text" class="form-control" id="inputZip" name="postal_code" placeholder="A1A 1A1" required>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-warning w-100 fw-bold py-3 shadow-sm text-uppercase">
                                    Create Account
                                </button>
                                <p class="text-center mt-3 small text-muted">
                                    Already have an account? <a href="loginform.php" class="text-warning fw-bold text-decoration-none">Login</a>
                                </p>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<script src="./js/passwordcheck.js"></script>

<?php require_once "./includes/footer.php" ?>