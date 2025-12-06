<?php
$title = "My Account";
require_once "./includes/header.php";
require_once "./db/conn.php";

// 1. Check Login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>location.href='loginform.php';</script>";
    exit();
}

$user_id = $_SESSION['id'];
$message = "";
$message_type = ""; 



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    $zip = trim($_POST['zip']);

    $sql = "UPDATE users SET name=?, email=?, address=?, city=?, province=?, postal_code=? WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssi", $name, $email, $address, $city, $province, $zip, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Profile updated successfully!";
            $message_type = "success";
            $_SESSION['name'] = $name; 
        } else {
            $message = "Error updating profile.";
            $message_type = "danger";
        }
        mysqli_stmt_close($stmt);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass === $confirm_pass) {
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password=? WHERE id=?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
            if (mysqli_stmt_execute($stmt)) {
                $message = "Password changed successfully!";
                $message_type = "success";
            } else {
                $message = "Error changing password.";
                $message_type = "danger";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $message = "New passwords do not match.";
        $message_type = "danger";
    }
}


$user_sql = "SELECT name, email, username, address, city, province, postal_code FROM users WHERE id = ?";
$user_data = [];
if ($stmt = mysqli_prepare($conn, $user_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}


$orders_sql = "SELECT id, total_price, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$orders = [];
if ($stmt = mysqli_prepare($conn, $orders_sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    mysqli_stmt_close($stmt);
}
?>

<div class="container py-5">

    <div class="d-flex align-items-center gap-3 mb-4">
        <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 60px; height: 60px;">
            <?php echo strtoupper(substr($user_data['name'], 0, 1)); ?>
        </div>
        <div>
            <h2 class="fw-bold m-0"><?php echo htmlspecialchars($user_data['name']); ?></h2>
            <p class="text-muted m-0">@<?php echo htmlspecialchars($user_data['username']); ?></p>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-5">

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action active fw-bold py-3" data-bs-toggle="list" href="#profile">
                        <i class="fas fa-user-circle me-2"></i> My Profile
                    </a>
                    <a class="list-group-item list-group-item-action fw-bold py-3" data-bs-toggle="list" href="#orders">
                        <i class="fas fa-box-open me-2"></i> Order History
                    </a>
                    <a class="list-group-item list-group-item-action fw-bold py-3" data-bs-toggle="list" href="#settings">
                        <i class="fas fa-lock me-2"></i> Security
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger fw-bold py-3">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content">

                <div class="tab-pane fade show active" id="profile">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h5 class="fw-bold m-0">Edit Profile</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Address</label>
                                        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user_data['address']); ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label small fw-bold text-muted">City</label>
                                        <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($user_data['city']); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Province</label>
                                        <input type="text" name="province" class="form-control" value="<?php echo htmlspecialchars($user_data['province']); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted">Postal Code</label>
                                        <input type="text" name="zip" class="form-control" value="<?php echo htmlspecialchars($user_data['postal_code']); ?>">
                                    </div>
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" name="update_profile" class="btn btn-warning fw-bold px-4 shadow-sm">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="orders">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h5 class="fw-bold m-0">Past Orders</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($orders)): ?>
                                <div class="text-center py-5">
                                    <p class="text-muted">You haven't placed any orders yet.</p>
                                    <a href="products.php" class="btn btn-outline-warning btn-sm">Go Shopping</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-3 ps-4">Order ID</th>
                                                <th class="py-3">Date</th>
                                                <th class="py-3">Total</th>
                                                <th class="py-3 text-end pe-4">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold">#<?php echo $order['id']; ?></td>
                                                    <td class="text-muted small">
                                                        <?php echo date("M j, Y, g:i a", strtotime($order['order_date'])); ?>
                                                    </td>
                                                    <td class="fw-bold text-success">$<?php echo $order['total_price']; ?></td>
                                                    <td class="text-end pe-4">
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Completed</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="settings">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-bottom py-3">
                            <h5 class="fw-bold m-0">Security Settings</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required placeholder="••••••••">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted">Confirm New Password</label>
                                    <input type="password" name="confirm_password" class="form-control" required placeholder="••••••••">
                                </div>
                                <div class="text-end">
                                    <button type="submit" name="change_password" class="btn btn-danger fw-bold px-4 shadow-sm">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once "./includes/footer.php" ?>