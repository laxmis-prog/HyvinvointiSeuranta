<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: kirjaudu.php');
    exit();
}

// Database connection
include "db_connect.php";

// Fetch user data
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];

// Fetch date range (default to today)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Fetch entries for the selected date range
$sql = "SELECT * FROM wellness_entries WHERE user_id = ? AND input_date BETWEEN ? AND ? ORDER BY input_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $user_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch stats
$sql = "SELECT 
            COUNT(*) as total_entries,
            AVG(sleep_hours) as avg_sleep,
            AVG(water_intake) as avg_water,
            AVG(exercise_duration) as avg_exercise
        FROM wellness_entries 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hyvinvointiseuranta - Kojelauta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #43cea2;
            --secondary-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --text-color: #333333;
        }
        body {
            background-color: #f4f7f6;
            color: var(--text-color);
        }
       
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 15px;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #3ab793;
            border-color: #3ab793;
        }
        .stats-card {
            background-color: var(--dark-color);
            color: var(--light-color);
        }
        .stats-card .card-body {
            padding: 20px;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0;
        }
        .stats-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .entry-card {
            border-left: 5px solid var(--primary-color);
        }
        .date-selector {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php 
    include 'sidebar.php';
    renderSidebar('index');
    ?>
    <div class="main-content">
        <h1 class="mb-4">Tervetuloa, <?php echo htmlspecialchars($username); ?>!</h1>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <h5 class="card-title">Kokonaismerkinnät</h5>
                        <p class="stats-number"><?php echo $stats['total_entries']; ?></p>
                        <p class="stats-label">merkintää</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <h5 class="card-title">Keskimääräinen uni</h5>
                        <p class="stats-number"><?php echo round($stats['avg_sleep'], 1); ?></p>
                        <p class="stats-label">tuntia</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <h5 class="card-title">Keskimääräinen vesi</h5>
                        <p class="stats-number"><?php echo round($stats['avg_water'], 1); ?></p>
                        <p class="stats-label">litraa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body">
                        <h5 class="card-title">Keskimääräinen liikunta</h5>
                        <p class="stats-number"><?php echo round($stats['avg_exercise'], 0); ?></p>
                        <p class="stats-label">minuuttia</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="date-selector">
            <form action="" method="GET" class="row g-3">
                <div class="col-auto">
                    <label for="start_date" class="form-label">Alkupäivämäärä</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                </div>
                <div class="col-auto">
                    <label for="end_date" class="form-label">Loppupäivämäärä</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                </div>
                <div class="col-auto align-self-end">
                    <button type="submit" class="btn btn-primary">Hae</button>
                </div>
            </form>
        </div>

        <h2 class="mb-3">Merkinnät</h2>
        <?php foreach ($entries as $entry): ?>
            <div class="card entry-card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $entry['input_date']; ?></h5>
                    <div class="row">
                        <div class="col-md-3">
                            <p><strong>Uni:</strong> <?php echo $entry['sleep_hours']; ?> tuntia</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Vesi:</strong> <?php echo $entry['water_intake']; ?> litraa</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Liikunta:</strong> <?php echo $entry['exercise_duration']; ?> minuuttia</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Mieliala:</strong> <?php echo $entry['mood']; ?></p>
                        </div>
                    </div>
                    <p><strong>Liikuntatyyppi:</strong> <?php echo $entry['exercise_type']; ?></p>
                    <p><strong>Ravitsemus:</strong> <?php echo $entry['nutrition']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($entries)): ?>
            <div class="alert alert-info">
                Ei merkintöjä valitulla aikavälillä.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>