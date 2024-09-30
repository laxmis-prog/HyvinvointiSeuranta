
<?php

include "sähköpostivahvistus.php"; // Liitetään sähköpostivahvistus-skripti

// Aloitetaan istunto
session_start();

// Otetaan virheiden raportointi käyttöön virheiden korjaamista varten
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tietokantayhteys
$servername = "localhost"; // Tietokannan palvelimen osoite
$username = "root"; // Tietokannan käyttäjänimi
$password = ""; // Tietokannan salasana
$dbname = "Hyvinvointi"; // Tietokannan nimi

// Luodaan yhteys
$conn = new mysqli($servername, $username, $password, $dbname);

// Tarkistetaan yhteys
if ($conn->connect_error) {
    die("Yhteyden muodostaminen epäonnistui: " . $conn->connect_error);
}

// Tarkistetaan, onko lomake lähetetty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']); // Käyttäjänimi
    $email = trim($_POST['email']); // Sähköposti
    $password = trim($_POST['password']); // Salasana
    $confirm_password = trim($_POST['confirm_password']); // Vahvistussalasana  

    // Tarkistetaan, että salasanat täsmäävät
    if ($password !== $confirm_password) {
        echo "Salasanat eivät täsmää.";
        exit;
    }

    // Tarkistetaan käyttäjänimen ainutlaatuisuus
    $usernameCheckQuery = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($usernameCheckQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Käyttäjänimi on jo varattu.";
        $result->free();  // Vapautetaan tulosjoukko
        exit;
    }
    $result->free();  // Vapautetaan tulosjoukko

    // Tarkistetaan sähköpostin muoto
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Virheellinen sähköpostimuoto.";
        exit;
    }

    // Tarkistetaan sähköpostin ainutlaatuisuus
    $emailCheckQuery = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Sähköposti on jo rekisteröity.";
        $result->free();  // Vapautetaan tulosjoukko
        exit;
    }
    $result->free();  // Vapautetaan tulosjoukko

    // Tarkistetaan salasanan vahvuus
    if (strlen($password) < 8 || 
        !preg_match('/[A-Z]/', $password) || 
        !preg_match('/[a-z]/', $password) || 
        !preg_match('/[0-9]/', $password) || 
        !preg_match('/[\W]/', $password)) {
        echo "Salasanan on oltava vähintään 8 merkkiä pitkä ja sisältävä isoja ja pieniä kirjaimia, numeroita ja erikoismerkkejä.";
        exit;
    }

    // Hashtoidaan salasana
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Luodaan turvallinen satunnaisluku vahvistustokeniksi
    $verification_token = bin2hex(random_bytes(16));

    // Asetetaan tokenin voimassaoloaika (valinnainen, tässä 24 tunniksi)
    $token_expiry = date('Y-m-d H:i:s', strtotime('+1 day'));

    // Lisätään tiedot tietokantaan
    $insertQuery = "INSERT INTO Users (username, email, password, role, verified, verification_token, token_expiry, created_at) 
                    VALUES (?, ?, ?, 'user', 0, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $username, $email, $hashedPassword, $verification_token, $token_expiry);

    if ($stmt->execute()) {
        echo "Rekisteröinti onnistui!";

        // Lähetetään vahvistussähköposti
        if (lahetaVahvistusSahkoposti($email, $verification_token)) { // Kutsutaan sähköpostin lähetysfunkti

            echo "Tarkista sähköpostisi vahvistaaksesi tilisi.";
            session_regenerate_id(true);  // Turvallinen istunnon uudistaminen
        } else {
            echo "Virhe: " . $stmt->error;
        }

        // Suljetaan lausunnot ja yhteys
        $stmt->close();
        $conn->close();
    }
}
?>
