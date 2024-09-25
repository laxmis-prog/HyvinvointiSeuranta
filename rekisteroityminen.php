<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröitymissivu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Rekisteröidy</h1>
        <form id="registrationForm" action="sahkoposti_vahvistus.html" method="POST" onsubmit="return validateForm()">
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
    </div>

    <script src="validation.js"></script>
</body>

</html>