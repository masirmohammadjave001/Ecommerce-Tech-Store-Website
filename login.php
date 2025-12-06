<?php
session_start();
require_once './db/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, name, password, is_admin FROM users WHERE email = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $email);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password, $is_admin);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {

                        // Success!
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["name"] = $name;
                        $_SESSION["email"] = $email;
                        $_SESSION["is_admin"] = $is_admin;

                        header("location: index.php");
                        exit();
                    } else {
                        // Wrong Password -> Redirect with error=1
                        header("location: loginform.php?error=1");
                        exit();
                    }
                }
            } else {
                // Wrong Email -> Redirect with error=1
                header("location: loginform.php?error=1");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
