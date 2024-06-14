<?php
session_start();

// Include database connection
// include_once "../../common/php/db.php";
include_once "../../common/php/authentication.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    // Validation on the input data
    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } else {
        // Check if the email is already registered
        $existingUser = getUserByEmail($email);
        if ($existingUser instanceof User) {
            $_SESSION['error_message'] = "Email is already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $type = 1;
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $email, $hashedPassword, $type);
            $success = $stmt->execute();
            $stmt->close();

            if ($success) {
                $_SESSION['success_message'] = "Registration successful. Welcome, $name!";
                header("Location: ../dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Error registering user.";
            }
        }
    }
}
