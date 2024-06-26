<?php
session_start();
include_once "../../common/php/authentication.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Password Changed Successfully. Let's Login $email";
            header("Location: login_admin.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Error updating password.";
        }

        $stmt->close();
    }
    $conn->close();
}
