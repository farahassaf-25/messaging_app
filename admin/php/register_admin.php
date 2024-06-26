<?php
session_start();
include_once "../../common/php/authentication.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    // Validate passwords
    $passwordErrors = validatePassword($password);

    if (!empty($passwordErrors)) {
        $_SESSION['error_message'] = implode(' ', $passwordErrors);
        header("Location: ../register_admin.php");
        exit();
    } elseif ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match.";
        header("Location: ../register_admin.php");
        exit();
    } else {
        // Check if the email is already registered
        $existingUser = getUserByEmail($email);
        if ($existingUser instanceof User) {
            $_SESSION['error_message'] = "Email is already registered.";
            header("Location: ../register_admin.php");
            exit();
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
                $_SESSION['user_name'] = $name;
                $_SESSION['success_message'] = "Registration successful. Welcome, $name!";
                header("Location: ../dashboard.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Error registering user.";
                header("Location: ../register_admin.php");
                exit();
            }
        }
    }
} else {
    header("Location: ../register_admin.php");
    exit();
}

function validatePassword($password)
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }

    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }

    if (!preg_match('/[@#$%&]/', $password)) {
        $errors[] = "Password must contain at least one special character (@, #, $, %, &).";
    }

    return $errors;
}
