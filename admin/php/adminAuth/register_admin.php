<?php
session_start();
require_once "../../../common/php/authentication.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];

    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
    } else {
        $passwordErrors = validatePassword($password);

        if (!empty($passwordErrors)) {
            $_SESSION['error_message'] = implode(' ', $passwordErrors);
        } elseif ($password !== $confirmPassword) {
            $_SESSION['error_message'] = "Passwords do not match.";
        } else {
            $existingUser = getUserByEmail($email);
            if ($existingUser instanceof User) {
                $_SESSION['error_message'] = "Email is already registered.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $type = 1;
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $name, $email, $hashedPassword, $type);
                $success = $stmt->execute();
                $stmt->close();

                if ($success) {
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_type'] = $type;
                    $_SESSION['user_image'] = '../assets/defaultProfile.webp'; // set default profile image
                    $_SESSION['success_message'] = "Registered Successfully. Hello $name!";
                    header("Location: ../../../admin/dashboard.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Error registering user.";
                }
            }
        }
    }

    header("Location: ../../../admin/register_admin.php");
    exit();
} else {
    header("Location: ../../../admin/register_admin.php");
    exit();
}

// validate password
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
