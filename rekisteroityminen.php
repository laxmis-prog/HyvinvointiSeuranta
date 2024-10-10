<?php

// Load Composer's autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Define the base URL of your website
$baseURL = 'http://localhost/clone/Hyvinvointiseuranta'; // Replace with your actual base URL



// Include database connection
include('db_connect.php');



//check if form is submitted

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $käyttäjänimi = $_POST['username'];
    $sähköposti = $_POST['email'];
    $salasana= $_POST['password'];
    $vahvistasalasana = $_POST['confirmPassword'];



    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $sähköposti);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Sähköposti on jo rekisteröity.";
        exit;
    }

// Store the submitted data in the database
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $käyttäjänimi, $sähköposti, password_hash($salasana, PASSWORD_DEFAULT));

if ($stmt->execute()) {
// If everything is valid, send the confirmation email
try {
    $mail = new PHPMailer(true);

    //Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set your SMTP server here
    $mail->SMTPAuth = true;
    $mail->Username = 'sapanadkl786@gmail.com'; // SMTP username
    $mail->Password = 'rbvw ilwp hthh hgdg'; // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encryption
    $mail->Port = 587; // TCP port to connect to
    

    //Recipients
    $mail->setFrom('sapanadkl786@gmail.com', 'Hyvinvointiseuranta');
    $mail->addAddress($sähköposti, $käyttäjänimi); // Add the user's email and name

// Construct the confirmation link
$confirmationLink = $baseURL . '/sähköpostivahvistus.php?email=' . urlencode($sähköposti);
    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Sähköpostin vahvistus';
    $mail->Body = 'Kiitos rekisteröitymisestä. Vahvista sähköpostisi napsauttamalla seuraavaa linkkiä: <a href="' . $confirmationLink . '">Vahvista sähköposti </a>';
    $mail->AltBody = 'Vahvista sähköpostisi käymällä seuraavassa linkissä: ' . $confirmationLink;

    $mail->send();
    echo 'Vahvistussähköposti on lähetetty.';
} catch (Exception $e) {
    echo "Viestiä ei voitu lähettää. Virhe: {$mail->ErrorInfo}";
}

    // Redirect email confirmation page
    header('Location: sähköpostivahvistus.php');
    exit();
} else {
    echo "Virhe tietojen tallentamisessa: " . $stmt->error;
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
    <title>Rekisteröidy - Hyvinvointi Seuranta</title>
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
                            <p class="lead mb-4">Seuraa hyvinvointiasi päivittäin ja ota askel kohti terveellisempää elämää.</p>
                            <div class="d-flex align-items-center mb-4">
                                <p class="fst-italic mb-0">"Tämä sovellus on muuttanut päivittäisen rutiinini ja parantanut yleistä hyvinvointiani!"</p>
                            </div>
                        </div>
                        <div class="col-md-6 card-right">
                            <h2 class="text-center mb-4">Rekisteröidy</h2>
                            <form action="rekisteroityminen.php" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Käyttäjänimi:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Sähköposti:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Salasana:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <span id="passwordStrength" class="form-text"></span>
                                </div>
                                <div class="mb-4">
                                    <label for="confirmPassword" class="form-label">Vahvista salasana:</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Rekisteröidy</button>
                                </div>
                            </form>
                            <p class="text-center mt-3">
                                Onko sinulla jo tili? <a href="kirjaudu.php">Kirjaudu sisään</a>.
                            </p>
                            <p class="text-center mt-3">
                                Rekisteröitymisen jälkeen, ole hyvä ja <a href="sähköpostivahvistus.php">tarkista sähköpostisi vahvistusta varten</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>