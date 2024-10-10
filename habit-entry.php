<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: kirjaudu.php');
    exit();
}

$errors = [];
$success = "";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include "db_connect.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['id'];
    $input_date = date('Y-m-d');
    $sleep_hours = trim($_POST["sleep_hours"]);
    $mood = trim($_POST["mood"]);
    $water_intake = trim($_POST["water_intake"]);
    $exercise_type = trim($_POST["exercise_type"]);
    $exercise_duration = trim($_POST["exercise_duration"]);
    $nutrition = trim($_POST["nutrition"]);

    // Validate form fields
    if (empty($sleep_hours) || empty($mood) || empty($water_intake) || empty($exercise_type) || empty($exercise_duration) || empty($nutrition)) {
        $errors[] = "Kaikki kentät ovat pakollisia.";
    }

    if (empty($errors)) {
        // Insert data into the wellness_entries table
        $sql = "INSERT INTO wellness_entries (user_id, input_date, sleep_hours, mood, water_intake, exercise_type, exercise_duration, nutrition) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdiisis", $user_id, $input_date, $sleep_hours, $mood, $water_intake, $exercise_type, $exercise_duration, $nutrition);

        if ($stmt->execute()) {
            $success = "Tietojen tallennus onnistui!";
        } else {
            $errors[] = "Virhe: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch previous day's entry
$previous_day = date('Y-m-d', strtotime('-1 day'));
$sql = "SELECT * FROM wellness_entries WHERE user_id = ? AND input_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $_SESSION['id'], $previous_day);
$stmt->execute();
$result = $stmt->get_result();
$previous_entry = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Päivittäinen Hyvinvointiseuranta - Merkintä</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #3ab793;
            border-color: #3ab793;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 206, 162, 0.25);
        }
        .icon-input {
            position: relative;
        }
        .icon-input i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        .icon-input input {
            padding-left: 35px;
        }
    </style>
</head>
<body>
    <?php 
    include 'sidebar.php';
    renderSidebar('habit-entry');
    ?>

    <div class="main-content">
        <h1 class="mb-4">Päivittäinen Hyvinvointiseuranta</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Lisää uusi merkintä</h2>
            </div>
            <div class="card-body">
                <form id="healthForm" method="POST" action="habit-entry.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sleep_hours" class="form-label">Unitunnit</label>
                            <div class="icon-input">
                                <i class="bi bi-moon"></i>
                                <input type="number" step="0.5" class="form-control" id="sleep_hours" name="sleep_hours" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mood" class="form-label">Mieliala</label>
                            <div class="icon-input">
                                <i class="bi bi-emoji-smile"></i>
                                <input type="text" class="form-control" id="mood" name="mood" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="water_intake" class="form-label">Vedenjuonti (litroina)</label>
                            <div class="icon-input">
                                <i class="bi bi-droplet"></i>
                                <input type="number" step="0.1" class="form-control" id="water_intake" name="water_intake" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exercise_type" class="form-label">Liikuntatyyppi</label>
                            <div class="icon-input">
                                <i class="bi bi-bicycle"></i>
                                <input type="text" class="form-control" id="exercise_type" name="exercise_type" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exercise_duration" class="form-label">Liikunta kesto (minuuttia)</label>
                            <div class="icon-input">
                                <i class="bi bi-stopwatch"></i>
                                <input type="number" class="form-control" id="exercise_duration" name="exercise_duration" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nutrition" class="form-label">Ravitsemus</label>
                            <div class="icon-input">
                                <i class="bi bi-apple"></i>
                                <input type="text" class="form-control" id="nutrition" name="nutrition" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lähetä</button>
                </form>
            </div>
        </div>

        <?php if ($previous_entry): ?>
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="mb-0">Edellisen päivän merkintä</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Uni:</strong> <?php echo $previous_entry['sleep_hours']; ?> tuntia</p>
                        <p><strong>Mieliala:</strong> <?php echo $previous_entry['mood']; ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Vesi:</strong> <?php echo $previous_entry['water_intake']; ?> litraa</p>
                        <p><strong>Liikunta:</strong> <?php echo $previous_entry['exercise_duration']; ?> minuuttia (<?php echo $previous_entry['exercise_type']; ?>)</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Ravitsemus:</strong> <?php echo $previous_entry['nutrition']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>