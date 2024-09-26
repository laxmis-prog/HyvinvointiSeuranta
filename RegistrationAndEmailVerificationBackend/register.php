
<?php
// Start session
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Hyvinvointi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);  

    // Validate passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Validate username uniqueness
    $usernameCheckQuery = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($usernameCheckQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username is already taken.";
        $result->free();  // Free the result set
        exit;
    }
    $result->free();  // Free the result set

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate email uniqueness
    $emailCheckQuery = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email is already registered.";
        $result->free();  // Free the result set
        exit;
    }
    $result->free();  // Free the result set

    // Validate password strength
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W]/', $password)) {
        echo "Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Generate a secure random verification token
    $verification_token = bin2hex(random_bytes(16));

    // Set a token expiry time (optional, here set to expire in 24 hours)
    $token_expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

    // Insert data into database, including role, verified, created_at fields and verification token
    $insertQuery = "INSERT INTO Users (username, email, password, role, verified, verification_token, token_expiry, created_at) 
                    VALUES (?, ?, ?, 'user', 0, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $username, $email, $hashedPassword, $verification_token, $token_expiry);

    if ($stmt->execute()) {
        echo "Registration successful!";

        // Send verification email
        sendVerificationEmail($email, $verification_token); // Call the function to send the email

        echo "Please check your email to verify your account.";
        session_regenerate_id(true);  // Secure session regeneration


        session_regenerate_id(true);  // Secure session regeneration
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
}

// PHPMailer function to send verification email
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
        $mail->Username   = 'your-email@example.com'; // SMTP username
        $mail->Password   = 'your-password'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('your-email@example.com', 'Your Site Name');
        $mail->addAddress($email); // Add the recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Verify Your Email Address';
        
        // Create the verification link
        $verificationLink = "http://yourdomain.com/verify.php?token=$verification_token";
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
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
