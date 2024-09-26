<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer via Composer

function sendVerificationEmail($email, $verification_token) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // SMTP server (use smtp.gmail.com for Gmail)
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USERNAME'); // Use environment variable or config
        $mail->Password   = getenv('SMTP_PASSWORD'); // Use environment variable or config
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('your-email@example.com', 'Your Site Name');
        $mail->addAddress($email); // Add the recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Verify Your Email Address';  

        // Create the verification link
        $verificationLink = "http://yourdomain.com/verify.php?token=" . urlencode($verification_token);

        $mailContent = "
            <h1>Email Verification</h1>
            <p>Thank you for registering. Please click the link below to verify your email address:</p>
            <a href='$verificationLink'>Verify Email</a>
            <p>This link will expire in 24 hours.</p>
        ";

        $mail->Body = $mailContent;

        // Send the email
        $mail->send();
        echo 'Verification email has been sent.';

    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error
        echo "Message could not be sent. Please try again later.";
    }
}

?>
