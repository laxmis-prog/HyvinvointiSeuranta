<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Add your form validation and processing logic here
    // For example, save to a database or send a confirmation email

    // Redirect email confirmation page
    header('Location: sähköpostivahvistus.php');
    exit();
}
?>




<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröitymissivu</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Rekisteröidy</h1>
        <form action="rekisteroityminen.php"  method="POST" >
            <label for="username">Käyttäjänimi:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Sähköposti:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Salasana:</label>
            <input type="password" id="password" name="password" required>
            <span id="passwordStrength" class="strength"></span>

            <label for="confirmPassword">Vahvista salasana:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Rekisteröidy</button>
           </form>

        <div class="login-link">
            <p>Onko sinulla jo tili? <a href="kirjaudu.php">Kirjaudu sisään</a>.</p>
        </div>
    </div>

    <!-- email confirmation page -->
<!-- -- <div class="confirmation-link">
    <p>Rekisteröitymisen jälkeen, ole hyvä ja <a href="sähköpostivahvistus.php">tarkista sähköpostisi vahvistusta varten</a>.</p>
</div>  -->


<?php include 'footer.php'; ?>
    <script src="validation.js"></script>
  
</body>

</html>