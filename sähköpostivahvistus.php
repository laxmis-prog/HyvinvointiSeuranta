<?php
$errors=[];
$success= '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email =trim($_POST['email']);

    // Validate email
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] = "Virheellinen sähköpostiosoite.";
}else{
    $success = "vahvistusviesti lähetetty sähköpostiisi.";
}
}
?>




<!DOCTYPE html>
<html lang="fi

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sähköpostivahvistus</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class= "sub-container">
        <h1>Sähköpostivahvistus</h1>
        <p>Ole hyvä ja tarkista sähköpostisi vahvistaaksesi rekisteröitymisen.</p>
     
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
               <p> <?php echo htmlspecialchars( $success); ?></p>
            </div>
        <?php endif; ?>

    <form action="sähköpostivahvistus.php" method="post">
            <label for="email">Sähköposti:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Lähetä Vahvistus</button>
        </form>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>