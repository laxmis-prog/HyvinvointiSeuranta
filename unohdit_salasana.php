<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include "db_connect.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sähköposti = $_POST['email'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $sähköposti);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50)); // Generate a random token

        // Store the token in the database
        $stmt = $conn->prepare("INSERT INTO password_reset_requests (user_id, token, expiry) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR)) ON DUPLICATE KEY UPDATE token = VALUES(token),expiry = VALUES(expiry)");
        $stmt->bind_param("is", $row['id'], $token);
        $stmt->execute();
        // Send the reset email
        try {
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set your SMTP server here
            $mail->SMTPAuth = true;
            $mail->Username = 'sapanadkl786@gmail.com'; // SMTP username
            $mail->Password = 'rbvw ilwp hthh hgdg'; // SMTP password or App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('sapanadkl786@gmail.com', 'Hyvinvointiseuranta');
            $mail->addAddress($sähköposti); // Add the user's email

            // Construct the reset link
            $baseURL = 'http://localhost/clone/Hyvinvointiseuranta';
            $resetLink = $baseURL . '/salasanan_nollaus.php?token=' . urlencode($token);

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Salasanan palautus';
            $mail->Body = 'Klikkaa seuraavaa linkkiä palauttaaksesi salasanasi: <a href="' . $resetLink . '">Palauta salasana</a>';
            $mail->AltBody = 'Klikkaa seuraavaa linkkiä palauttaaksesi salasanasi: ' . $resetLink;

            $mail->send();
            echo 'Palautuslinkki on lähetetty sähköpostiisi.';
        } catch (Exception $e) {
            echo "Viestiä ei voitu lähettää. Virhe: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Sähköpostiosoitetta ei löytynyt.";
    }

    $stmt->close();
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirjaudu sisään - Daily Wellness Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="row g-0">
                        <div class="col-md-6 card-left">
                            <h1 class="display-4 mb-4">Hyvinvointi Seuranta</h1>
                            <p class="lead mb-4">Tervetuloa ! Anna sähköpostiosoitteesi.</p>
                            
                        </div>
                        <div class="col-md-6 card-right">
                            <h2 class="text-center mb-4">Unohdit Salasana</h2>
                            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                            <form action="unohdit_salasana.php" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Sähköposti:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                               
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Lähetä palautuslinkki</button>
                                </div>
                               
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

