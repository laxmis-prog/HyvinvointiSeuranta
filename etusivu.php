
<!DOCTYPE html>
<html lang="fi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Päivittäinen Hyvinvointiseuranta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php
  
    $welcomeMessage = "Tervetuloa Päivittäiseen Hyvinvointiseurantaan";
    $description = "Seuraa päivittäisiä tapojasi, paranna elämäntapojasi ja pysy terveenä hyvinvointiseurantamme avulla.";
    $buttonText = "Aloita nyt";
    $buttonLink = "rekisteroityminen.php";
    ?>

    <!-- Hero-Section-->
    <section class="hero">
        <div class="hero-image">
            <div class="hero-content">
                <h1><?php echo $welcomeMessage; ?></h1>
                <p><?php echo $description; ?></p>
                <a href="<?php echo $buttonLink; ?>" class="btn"><?php echo $buttonText; ?></a>
            </div>
        </div>
    </section>

    <!-- Characteristics Features-->
    <section class="features">
        <h2>Miksi käyttää seurantaamme?</h2>
        <div class="feature-list">
            <div class="feature-item">
                <h3>Seuraa tapojasi</h3>
                <p>Kirjaa päivittäiset rutiinisi ja seuraa edistymistäsi ajan myötä.</p>
            </div>
            <div class="feature-item">
                <h3>Saa oivalluksia</h3>
                <p>Analysoi tietojasi ja saat henkilökohtaista palautetta.</p>
            </div>
            <div class="feature-item">
                <h3>Pysy motivoituneena</h3>
                <p>Aseta tavoitteita ja vastaanota muistutuksia pysyäksesi kurssissa.</p>
            </div>
        </div>
    </section>

     <!-- Include Footer -->
     <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!-- Navigointipalkki -->
<!-- <header>
        <nav class="navbar">
            <div class="logo">Hyvinvointiseuranta</div>
            <ul class="nav-links">
                <li><a href="login.html">Kirjaudu sisään</a></li>
                <li><a href="register.html">Rekisteröidy</a></li>
            </ul>
        </nav>
    </header> -->
    