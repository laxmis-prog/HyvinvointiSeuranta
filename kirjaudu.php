<?php
session_start();

include "db_connect.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
   $sähköposti =trim($_POST['email']);
   $salasana =trim($_POST['password']);
   $remember = isset($_POST["remember"]);

   //prepare and execute query
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $sähköposti);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if(password_verify($salasana, $row['password'])) {
            session_start();
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['is_admin'] = $row['is_admin']; // Set admin status

            if ($remember) {
                setcookie('user_id', $row['id'], time() + (86400 * 30), "/"); // 30 days
                setcookie('username', $row['username'], time() + (86400 * 30), "/");
                setcookie('email', $row['email'], time() + (86400 * 30), "/");
                setcookie('is_admin', $row['is_admin'], time() + (86400 * 30), "/");
                
            }
            if ($row['is_admin']) {
                header("Location: admin_feedback.php"); // Redirect to admin page
            } else {
            header("Location: index.php");
            }
            exit();
        } else {
            $message = "Väärä salasana";
        }
    } else {
        $message = "Sähköpostia ei löytynyt";
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
                            <p class="lead mb-4">Tervetuloa takaisin! Kirjaudu sisään seurataksesi hyvinvointiasi ja jatkaaksesi matkaa kohti terveellisempää elämää.</p>
                            <div class="d-flex align-items-center mb-4">
                                <p class="fst-italic mb-0">"Päivittäinen kirjautuminen auttaa minua pysymään tavoitteissani!"</p>
                            </div>
                        </div>
                        <div class="col-md-6 card-right">
                            <h2 class="text-center mb-4">Kirjaudu sisään</h2>
                            <form action="kirjaudu.php" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Sähköposti:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Salasana:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Muista minut</label>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Kirjaudu sisään</button>
                                </div>
                                <div class="text-center">
                                    <a href="unohdit_salasana.php" class="forgot-password">Unohditko salasanasi?</a>
                                </div>
                            </form>
                            <p class="text-center mt-3">
                                Eikö sinulla ole tiliä? <a href="rekisteroityminen.php" class="forgot-password">Rekisteröidy</a>.
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