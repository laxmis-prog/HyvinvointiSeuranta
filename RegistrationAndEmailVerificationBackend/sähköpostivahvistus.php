<?php

include "config.php"; // Sisällytä tietokannan asetustiedosto

error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Sisällytä PHPMailer Composerin kautta

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Tarkista, onko pyyntö POST
    // Puhdista ja trimmaa sähköposti
    $sahkoposti = htmlspecialchars(trim($_POST['email'])); // Hanki ja puhdista sähköposti POST-pyynnöstä
    $vahvistustoken = bin2hex(random_bytes(50)); // Luo satunnainen token

    // Tallenna token tietokantaan
    $sql = "INSERT INTO email_verification (email, token) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $sahkoposti, $vahvistustoken);

    // Suorita lauseke ja tarkista, onnistuiko se
    if ($stmt->execute()) {
        // Kutsu funktiota lähettääksesi vahvistussähköposti vain jos token tallennettiin onnistuneesti
        if (lahetaVahvistusSahkoposti($sahkoposti, $vahvistustoken)) {
            echo "Vahvistussähköposti lähetettiin onnistuneesti.";
        } else {
            echo "Virhe vahvistussähköpostin lähettämisessä.";
        }
    } else {
        echo "Virhe tokenin tallentamisessa tietokantaan: " . $stmt->error; // Virheenkäsittely
    }
}

function lahetaVahvistusSahkoposti($sahkoposti, $vahvistustoken) {
    $mail = new PHPMailer(true); // Luo uusi PHPMailer-instanssi

    // SMTP asetukset
    // Verkkosivustosi domain (säädä tarpeen mukaan)
    $domain = "localhost";  // Korvata oikealla domainilla

    try {
        // Palvelinasetukset
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP-palvelin (käytä smtp.gmail.com Gmailille)
        $mail->SMTPAuth   = true; // Ota käyttöön SMTP-todennus
        $mail->Username   = 'r02481933@gmail.com'; // Sähköpostiosoitteesi
        $mail->Password   = 'lgsi jroj ihfs fnoc'; // Sovelluksen salasana
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // TCP-portti, johon yhdistetään

        // Vastaanottajat
        $mail->setFrom('r02481933@gmail.com', 'Sivustosi Nimi');
        $mail->addAddress($sahkoposti); // Lisää vastaanottaja

        // Sisältö
        $mail->isHTML(true); // Aseta sähköpostin muoto HTML:ksi
        $mail->Subject = 'Vahvista sähköpostiosoitteesi';
        $vahvistuslinkki = "http://$domain/verify.php?token=$vahvistustoken";
        $mail->Body    = "
            <html>
            <head>
                <title>Sähköpostin vahvistus</title>
            </head>
            <body>
                <p>Kiitos rekisteröitymisestä!</p>
                <p>Ole hyvä ja napsauta alla olevaa linkkiä vahvistaaksesi sähköpostiosoitteesi:</p>
                <a href='$vahvistuslinkki'>Vahvista sähköpostisi</a>
                <p>Jos linkki ei toimi, kopioi ja liitä seuraava URL-osoite selaimeesi:</p>
                <p>$vahvistuslinkki</p>
            </body>
            </html>
        ";

        $mail->AltBody = 'Vahvista sähköpostisi vierailemalla seuraavassa linkissä: ' . $vahvistuslinkki;

        // Lähetä sähköposti
        $mail->send();
        return true; // Palauta true, jos sähköposti lähetettiin onnistuneesti

    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}"); // Kirjaa virhe
        echo "Viestiä ei voitu lähettää. Yritä myöhemmin uudelleen.";
        return false; // Palauta false, jos sähköposti epäonnistui
    }
}
?>

