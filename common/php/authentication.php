<?php
include __DIR__ . '/models/User.php';
include_once "db.php";

/** Authenticate user by email and password */
function authenticateUser($email, $password, $type)
{
    global $conn;

    // retrieve user from database by email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND type = ?");
    $stmt->bind_param("si", $email, $type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // verify password
        if (password_verify($password, $user['password'])) {
            return User::fromObject($user);
        }
    }

    return null;
}

/** Get user by email */
function getUserByEmail($email)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        return User::fromObject($user);
    }

    return null;
}

/** Register new user */
function registerUser($name, $email, $password, $type)
{
    global $conn;

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $password, $type);
    $success = $stmt->execute();

    return $success;
}

function isAuthenticated()
{
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    } elseif (isset($_SESSION['admin'])) {
        return $_SESSION['admin'];
    } else {
        return ["code" => 401, "error" => "Unauthorized"];
    }
}
