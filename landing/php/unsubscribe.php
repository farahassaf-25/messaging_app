<?php

// Update the details below with your MySQL details
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '2510';
$DATABASE_NAME = 'convoconnect_db';
try {
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    // Output all connection errors. We want to know what went wrong...
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to database!');
}


if (isset($_GET['email'], $_GET['code'])) {
    // Validate email address
    if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        exit('Please provide a valid email address!');
    }
    // Check if email exists in database
    $stmt = $pdo->prepare('SELECT * FROM subscribers WHERE email = ?');
    $stmt->execute([$_GET['email']]);
    $subscriber = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($subscriber) {
        // Verify code
        if (sha1($subscriber['id'] . $subscriber['email']) == $_GET['code']) {
            // Delete the email from the subscribers list
            $stmt = $pdo->prepare('DELETE FROM subscribers WHERE email = ?');
            $stmt->execute([$_GET['email']]);
            // Output success response
            exit('You\'ve successfully unsubscribed!');
        } else {
            exit('Incorrect code provided!');
        }
    } else {
        exit('You\'re not a subscriber or you\'ve already unsubscribed!');
    }
} else {
    exit('No email address and/or code specified!');
}
