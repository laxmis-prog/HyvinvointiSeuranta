<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Päivittäinen Hyvinvointiseuranta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

        :root {
            --primary-color: #43cea2;
            --secondary-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --text-color: #333333;
        }
        body {
         font-family: "Outfit", sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }
        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
        }
        .nav-link:hover {
            color: var(--primary-color) !important;
        }            padding: 10px;

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #3ab793;
            border-color: #3ab793;
        }
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .section-title {
            position: relative;
            margin-bottom: 3rem;
            font-weight: bold;
            color: var(--dark-color);
        }
        .section-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            margin: 10px auto 0;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .card {
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .testimonial-card {
            background-color: var(--light-color);
            border-radius: 15px;
            width: 100%;
            height: 100%;
        }
        .testimonial-card img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        .cta-section {
            background-color: var(--secondary-color);
            color: white;
        }
        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
        }
        .social-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: var(--light-color);
            transition: color 0.3s ease;
        }
        .social-icon:hover {
            color: var(--primary-color);
        }
        #back-to-top {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99;
        }
        @media (max-width: 768px) {
            .hero {
                padding: 60px 0;
            }
            .navbar-nav {
                background-color: rgba(255, 255, 255, 0.95);
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary ms-2" href="kirjaudu.php">Kirjaudu sisään</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2" href="rekisteroityminen.php">Rekisteröidy</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Päivittäinen Hyvinvointiseuranta</h1>
                    <p class="lead mb-4">Seuraa päivittäisiä tapojasi, paranna elämäntapojasi ja pysy terveenä hyvinvointiseurantamme avulla.</p>
                    <a href="rekisteroityminen.php" class="btn btn-light btn-lg me-2 mb-2">Aloita nyt</a>
                    <a href="#features" class="btn btn-outline-light btn-lg mb-2">Lue lisää</a>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <img src="./Kuva/image.jpeg" alt="Hyvinvointiseuranta sovellus" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Miksi valita Hyvinvointiseuranta?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h3 class="h5">Seuraa tapojasi</h3>
                        <p>Kirjaa päivittäiset rutiinisi ja seuraa edistymistäsi ajan myötä.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-lightbulb feature-icon"></i>
                        <h3 class="h5">Saa oivalluksia</h3>
                        <p>Analysoi tietojasi ja saat henkilökohtaista palautetta.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-trophy feature-icon"></i>
                        <h3 class="h5">Pysy motivoituneena</h3>
                        <p>Aseta tavoitteita ja vastaanota muistutuksia pysyäksesi kurssissa.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center p-4">
                        <i class="bi bi-trophy feature-icon"></i>
                        <h3 class="h5">Paranna hyvinvointiasi</h3>
                        <p>Seuraa edistymistäsi ja tee tietoisia päätöksiä terveytesi parantamiseksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center section-title">Kuinka se toimii?</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 text-center p-4">
                        <div class="display-4 mb-3 text-primary">1</div>
                        <h5 class="card-title">Rekisteröidy ilmaiseksi</h5>
                        <p class="card-text">Luo tili muutamassa minuutissa ja aloita 14 päivän ilmainen kokeilu.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center p-4">
                        <div class="display-4 mb-3 text-primary">2</div>
                        <h5 class="card-title">Aseta tavoitteesi</h5>
                        <p class="card-text">Määritä henkilökohtaiset hyvinvointitavoitteesi ja seurattavat tavat.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center p-4">
                        <div class="display-4 mb-3 text-primary">3</div>
                        <h5 class="card-title">Seuraa päivittäin</h5>
                        <p class="card-text">Kirjaa päivittäiset tapasi ja aktiviteettisi helposti sovelluksessa.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center p-4">
                        <div class="display-4 mb-3 text-primary">4</div>
                        <h5 class="card-title">Saa oivalluksia</h5>
                        <p class="card-text">Analysoi edistymistäsi ja saa räätälöityjä vinkkejä hyvinvointisi parantamiseksi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Mitä käyttäjämme sanovat</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="testimonial-card p-4">
                        <img src="/placeholder.svg?height=60&width=60" alt="Maija M." class="mb-3">
                        <p class="mb-2">"Tämä sovellus on muuttanut elämäni! Olen nyt paljon tietoisempi päivittäisistä tavoistani ja terveydestäni."</p>
                        <strong>Maija M.</strong>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testimonial-card p-4">
                        <img src="/placeholder.svg?height=60&width=60" alt="Jukka K." class="mb-3">
                        <p class="mb-2">"Helppokäyttöinen ja erittäin hyödyllinen. Suosittelen lämpimästi kaikille, jotka haluavat parantaa hyvinvointiaan."</p>
                        <strong>Jukka K.</strong>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testimonial-card p-4">
                        <img src="/placeholder.svg?height=60&width=60" alt="Liisa R." class="mb-3">
                        <p class="mb-2">"Oivallukset ja analyysit ovat todella hyödyllisiä. Olen oppinut paljon itsestäni tämän sovelluksen avulla."</p>
                        <strong>Liisa R.</strong>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="testimonial-card p-4">
                        <img src="/placeholder.svg?height=60&width=60" alt="Pekka S." class="mb-3">
                        <p class="mb-2">"Motivoiva ja helppokäyttöinen. Olen onnistunut parantamaan unitottumuksiani ja stressinhallintaani."</p>
                        <strong>Pekka S.</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <
    <section class="cta-section py-5">
        <div class="container text-center">
           <a href="rekisteroityminen.php" class="btn btn-light btn-lg">Aloita 14 päivän ilmainen kokeilu</a>
        </div>
    </section>

    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5>Tietoa meistä</h5>
                    <p>Päivittäinen Hyvinvointiseuranta on sitoutunut auttamaan ihmisiä saavuttamaan terveellisemmän ja tasapainoisemman elämän helppokäyttöisen seurannan ja henkilökohtaisten oivallusten avulla.</p>
                </div>
                <div class="col-md-4 col-lg-2">
                    <h5>Pikavalikko</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-light">Ominaisuudet</a></li>
                        <li><a href="#how-it-works" class="text-light">Miten se toimii</a></li>
                        <li><a href="#testimonials" class="text-light">Arvostelut</a></li>
                        
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h5>Ota yhteyttä</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope me-2"></i> info@hyvinvointiseuranta.fi</li>
                        <li><i class="bi bi-telephone me-2"></i> +358 50 123 4567</li>
                        <li><i class="bi bi-geo-alt me-2"></i> Esimerkkikatu 123, 00100 Helsinki</li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-3">
                    <h5>Seuraa meitä</h5>
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <hr class="mt-4 mb-3">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2023 Päivittäinen Hyvinvointiseuranta. Kaikki oikeudet pidätetään.</p>
                </div>
                
            </div>
        </div>
    </footer>

    <a href="#" class="btn btn-primary btn-lg rounded-circle position-fixed bottom-0 end-0 m-4" id="back-to-top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbar = document.querySelector('.navbar');
            var backToTop = document.getElementById('back-to-top');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                    backToTop.style.display = 'block';
                } else {
                    navbar.classList.remove('scrolled');
                    backToTop.style.display = 'none';
                }
            });

            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });
    </script>
</body>
</html>