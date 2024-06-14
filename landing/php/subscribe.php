<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "2510";
$dbname = "convoconnect_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email is set and not empty
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO subscriptions (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp-relay.sendinblue.com'; // Sendinblue SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your_sendinblue_username'; // Sendinblue SMTP username
            $mail->Password   = 'your_sendinblue_smtp_password'; // Sendinblue SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('your-email@example.com', 'ConvoConnect'); // Replace with your email
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to ConvoConnect!';
            $mail->Body    = 'Thank you for subscribing to ConvoConnect Messaging App! We are excited to have you on board.';

            $mail->send();
            echo "<div class='alert alert-success'>Thank you for subscribing! A confirmation email has been sent to your email address.</div>";
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<div class='alert alert-danger'>Error: Email address is required.</div>";
}
