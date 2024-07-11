<?php
session_start();

require_once "../../../common/php/authentication.php";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = authenticateUser($email, $password, 1);

    if ($user instanceof User) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_type'] = $user->type;
        $_SESSION['user_image'] = $user->imageURL;
        $_SESSION['success_message'] = "Logged in successfully.";

        if ($user->type === 1) {
            header("Location: ../../dashboard.php");
        } else {
            $_SESSION['error_message'] = "Not an Admin!";
            header("Location: ../../login_admin.php");
        }
        exit();
    } else {
        if (getUserByEmail($email)) {
            $_SESSION['error_message'] = "Invalid email or password.";
        } else {
            $_SESSION['error_message'] = "Admin is not registered.";
        }
        header("Location: ../../login_admin.php");
        exit();
    }
}
