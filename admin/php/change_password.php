<?php
session_start();

include_once "../../common/php/authentication.php";

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    // Validate the input data
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the new password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            $success_message = "Password updated successfully.";
            header("Location: login_admin.php");
            // exit();
        } else {
            $error_message = "Error updating password.";
        }

        $stmt->close();
    }
    $conn->close();
}

$_SESSION['error_message'] = $error_message;
$_SESSION['success_message'] = $success_message;
