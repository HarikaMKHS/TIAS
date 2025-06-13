<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? 'No Subject');
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '8f8c59001@smtp-brevo.com';        // 🔁 Replace with your Gmail
        $mail->Password   = 'm0DPIM1ABF4OX7GY';           // 🔁 Paste your 16-digit app password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('harika@tattvainvestmentadvisory.com', $name);
        $mail->addReplyTo($email, $name);
        $mail->addAddress('harika@tattvainvestmentadvisory.com');         // ✅ Where you want to receive messages
        $mail->Subject = $subject;
        $mail->Body    = "From: $name <$email>\n\nMessage:\n$message";

        $mail->send();
        echo "success";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
?>
