<?php
function renderSidebar($activePage = '') {
    $menuItems = [
        'index' => ['icon' => 'bi-speedometer2', 'text' => 'Kojelauta'],
        'habit-entry' => ['icon' => 'bi-plus-circle', 'text' => 'Lisää merkintä'],
        'history' => ['icon' => 'bi-calendar3', 'text' => 'Historia'],
        'profile' => ['icon' => 'bi-person-circle', 'text' => 'Profiili'],
        'feedback' => ['icon' => 'bi-chat-left-text', 'text' => 'Anna palautetta'],
    ];
?>
<nav class="sidebar navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid flex-lg-column">
        <a class="navbar-brand" href="#">Hyvinvointiseuranta</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="sidebarMenu">
            <ul class="navbar-nav flex-column mt-3">
                <?php foreach ($menuItems as $page => $item): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activePage === $page) ? 'active' : ''; ?>" href="<?php echo $page; ?>.php">
                            <i class="bi <?php echo $item['icon']; ?> me-2"></i>
                            <?php echo $item['text']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item mt-5">
                    <a class="nav-link" href="kirjaudu_ulos.php">
                        <i class="bi bi-box-arrow-left me-2"></i>
                        Kirjaudu ulos
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

    .sidebar {
        display: flex;
        flex-direction: column;
        top: 0;
        left: 0;
        z-index: 100;
        padding: 20px 0;
        transition: all 0.3s;
    }

    body{
          font-family: "Outfit", sans-serif;
    }

    .sidebar .navbar-brand {
        padding: 15px 0px;
        font-size: 1.2rem;
    }

    .sidebar .nav-link {
        padding: 10px 20px;
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            width: 100%;
            position: static;
            height: auto;
        }

        .main-content {
            margin-left: 0;
        }
    }

        @media (min-width: 991.98px) {
        .sidebar {
            position: fixed;
            min-height: 100vh;
            width: 250px;
        }

    }
</style>