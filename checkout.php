<?php
$title = "Checkout";
require_once "./includes/header.php";
require_once "./db/conn.php";

// 1. Check Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>location.href='loginform.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];

// 2. Fetch User's Saved Info (Address, etc.)
$saved_user = [];
$user_sql = "SELECT name, email, address, city, province, postal_code FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $user_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $saved_user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

// Helper: Split full name back into First/Last for the form
$name_parts = explode(" ", $saved_user['name'], 2);
$saved_fname = $name_parts[0] ?? '';
$saved_lname = $name_parts[1] ?? '';

// 3. Fetch Cart Items
$cart_items = [];
$sql = "SELECT c.quantity, p.name, p.price, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
    mysqli_stmt_close($stmt);
}

if (empty($cart_items)) {
    echo "<script>location.href='cart.php';</script>";
    exit();
}

// 4. Calculations
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += ($item['price'] * $item['quantity']);
}
$tax = $subtotal * 0.13;
$total = $subtotal + $tax;

$min_expiry = date('Y-m');
?>

<div class="container py-5">
    <div class="mb-4">
        <a href="cart.php" class="text-decoration-none text-muted small fw-bold">
            <i class="fas fa-arrow-left me-1"></i> Back to Cart
        </a>
    </div>

    <form action="placeorder.php" method="POST" id="checkoutForm">
        <div class="row g-5">

            <div class="col-lg-8">
                <h2 class="fw-bold mb-4">Checkout</h2>

                <div class="card checkout-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="fw-bold m-0"><i class="fas fa-truck me-2 text-warning"></i> Shipping Information</h5>
                    </div>
                    <div class="card-body p-4">

                        <?php if (!empty($saved_user['address'])): ?>
                            <div class="mb-4 p-3 bg-light-subtle rounded border border-secondary-subtle">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="address_option" id="useSaved" value="saved" checked>
                                    <label class="form-check-label fw-bold" for="useSaved">
                                        Use Saved Address
                                    </label>
                                    <div class="text-muted small ms-2 mt-1">
                                        <?php echo htmlspecialchars($saved_user['address'] . ', ' . $saved_user['city'] . ', ' . $saved_user['province']); ?>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="address_option" id="useNew" value="new">
                                    <label class="form-check-label" for="useNew">
                                        Use a Different Shipping Address
                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div id="address-fields" class="<?php echo !empty($saved_user['address']) ? 'd-none' : ''; ?>">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Address</label>
                                    <input type="text" name="address" id="address" class="form-control" required
                                        value="<?php echo htmlspecialchars($saved_user['address']); ?>">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted">Province</label>
                                    <input type="text" name="province" id="province" class="form-control" required
                                        value="<?php echo htmlspecialchars($saved_user['province']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted">City</label>
                                    <input type="text" name="city" id="city" class="form-control" required
                                        value="<?php echo htmlspecialchars($saved_user['city']); ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold text-muted">Zip</label>
                                    <input type="text" name="zip" id="zip" class="form-control" required
                                        value="<?php echo htmlspecialchars($saved_user['postal_code']); ?>">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card checkout-card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="fw-bold m-0"><i class="fas fa-credit-card me-2 text-warning"></i> Payment Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex gap-2 mb-3">
                            <i class="fab fa-cc-visa fa-2x text-primary"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-danger"></i>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Name on Card</label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Card Number</label>
                                <input type="text" id="cardNumber" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Expiration</label>
                                <div class="input-group">
                                    <input type="text" name="exp_month" id="expMonth" class="form-control text-center"
                                        placeholder="MM" maxlength="2" required>

                                    <span class="input-group-text bg-light text-muted px-2">/</span>

                                    <input type="text" name="exp_year" id="expYear" class="form-control text-center"
                                        placeholder="YYYY" maxlength="4" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">CVV</label>
                                <input type="text" id="cardCvv" class="form-control" placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card summary-card border-0 shadow-sm p-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4">Your Order</h5>
                    <div class="mb-4">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light-subtle rounded p-2 me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-semibold text-truncate-2" style="font-size: 0.9rem;">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </h6>
                                    <small class="text-muted">x<?php echo $item['quantity']; ?></small>
                                </div>
                                <div class="fw-bold">
                                    $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax (13%)</span>
                            <span class="fw-bold">$<?php echo number_format($tax, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                            <span class="fs-5 fw-bold">Total</span>
                            <span class="fs-4 fw-bold text-warning">$<?php echo number_format($total, 2); ?></span>
                        </div>
                        <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-3 mt-4 shadow-sm text-uppercase letter-spacing-1">
                        Pay $<?php echo number_format($total, 2); ?>
                    </button>
                    <div class="mt-3 text-center text-muted small">
                        <i class="fas fa-lock me-1"></i> Payments are SSL encrypted
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const radioSaved = document.getElementById('useSaved');
    const radioNew = document.getElementById('useNew');
    const formContainer = document.getElementById('address-fields');

    // Data from PHP to JS so we can refill the form if they switch back to "Saved"
    const savedData = {
        fname: "<?php echo htmlspecialchars($saved_fname); ?>",
        lname: "<?php echo htmlspecialchars($saved_lname); ?>",
        email: "<?php echo htmlspecialchars($saved_user['email']); ?>",
        address: "<?php echo htmlspecialchars($saved_user['address']); ?>",
        city: "<?php echo htmlspecialchars($saved_user['city']); ?>",
        province: "<?php echo htmlspecialchars($saved_user['province']); ?>",
        zip: "<?php echo htmlspecialchars($saved_user['postal_code']); ?>"
    };

    if (radioSaved && radioNew) {
        radioSaved.addEventListener('change', function() {
            if (this.checked) {
                // Hide form, but refill inputs so they submit correctly
                formContainer.classList.add('d-none');
                document.getElementById('fname').value = savedData.fname;
                document.getElementById('lname').value = savedData.lname;
                document.getElementById('email').value = savedData.email;
                document.getElementById('address').value = savedData.address;
                document.getElementById('city').value = savedData.city;
                document.getElementById('province').value = savedData.province;
                document.getElementById('zip').value = savedData.zip;
            }
        });

        radioNew.addEventListener('change', function() {
            if (this.checked) {
                // Show form and clear inputs
                formContainer.classList.remove('d-none');
                const inputs = formContainer.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
            }
        });
    }
</script>

<?php require_once "./includes/footer.php" ?>