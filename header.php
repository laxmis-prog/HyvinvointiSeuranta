<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<<nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-heart-pulse me-2"></i>Hyvinvointiseuranta
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Ominaisuudet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Miten se toimii</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Arvostelut</a>
                    </li>
                    <?php if (isset($_SESSION['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="kirjaudu.php">Kirjaudu sisään</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2" href="rekisteroityminen.php">Rekisteröidy</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>