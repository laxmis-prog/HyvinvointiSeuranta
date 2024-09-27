<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer via Composer

function sendVerificationEmail($email, $verification_token) {
    $mail = new PHPMailer(true);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Your website domain (adjust as needed)
    $domain = "localhost";  // Replace with your actual domain

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

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Verify Your Email Address';
        $verification_link = "http://$domain/verify.php?token=$verification_token";
        $mail->Body    = "
            <html>
            <head>
                <title>Email Verification</title>
            </head>
            <body>
                <p>Thank you for registering!</p>
                <p>Please click the link below to verify your email address:</p>
                <a href='$verification_link'>Verify your email</a>
                <p>If the link does not work, copy and paste the following URL into your browser:</p>
                <p>$verification_link</p>
            </body>
            </html>
        ";

        $mail->AltBody = 'Please verify your email by visiting the following link: ' . $verification_link;


        // Send the email
        $mail->send();
        echo 'Verification email has been sent.';

    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error
        echo "Message could not be sent. Please try again later.";
    }
}

?>
