<?php
include __DIR__ . '/models/User.php';
include_once "db.php";

/** Authenticate user by email and password */
function authenticateUser($email, $password, $type)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, name, email, password, type, imageURL, createdAt FROM users WHERE email = ? AND type = ?");
    $stmt->bind_param("si", $email, $type);
    $stmt->execute();
    $stmt->bind_result($id, $name, $email, $hashed_password, $type, $imageURL, $createdAt);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            return new User($id, $email, $hashed_password, $name, $imageURL, $type, $createdAt);
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
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $type);
    $success = $stmt->execute();

    return $success;
}

function isAuthenticated()
{
    //TODO: THIS RETURN IS FOR TESTING ONLY
    //// non-admin in group ID=15
    //return new User(27, 'david.thomas@example.com', 'catlover', 'David Thomas', 'https://cataas.com/cat?bust=718.607203772857&width=64&height=64', 0, '2024-06-15 12:06:24');
    return new User(909090, "example@domain.com", "pass", "example", "https://cataas.com/cat?size=64", 0, date('Y-m-d H:i:s'),);

    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    } elseif (isset($_SESSION['admin'])) {
        return $_SESSION['admin'];
    } else {
        return ["code" => 401, "error" => "Unauthorized"];
    }
}
