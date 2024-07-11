<?php
session_start();
require_once "../../../common/php/authentication.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ? and type = 1")) {
            $stmt->bind_param("ss", $hashedPassword, $email);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Password changed successfully. Please login with your new password.";
                $stmt->close();
                header("Location: ../../login_admin.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Error updating password.";
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Failed to prepare the database query.";
        }
    }
    $conn->close();
    header("Location: change_password.php");
    exit();
}
