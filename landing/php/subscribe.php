<?php
require "../../common/php/authentication.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$smtpUsername = $_ENV['SMTP_USERNAME'];
$smtpPassword = $_ENV['SMTP_PASSWORD'];
$smtpHost = $_ENV['SMTP_HOST'];
$smtpPort = $_ENV['SMTP_PORT'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "INSERT INTO subscribers (name, email) VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUsername;
            $mail->Password = $smtpPassword;
            $mail->SMTPSecure = 'tls';
            $mail->Port = $smtpPort;

            $mail->setFrom('no-reply@convoconnect.com', 'ConvoConnect');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'ConvoConnect Subscription';
            $mail->Body = 'Dear ' . $name . ',<br><br>Thank you for subscribing to ConvoConnect!<br>We look forward to keeping you updated with our latest news and updates.<br><br>Best regards,<br>The ConvoConnect Team';

            $mail->send();
            echo 'Subscription successful and email sent.';
        } catch (Exception $e) {
            echo 'Subscription successful, but failed to send email. Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
