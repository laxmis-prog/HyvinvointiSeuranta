<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: kirjaudu.php');
    exit();
}

// Database connection
include "db_connect.php";

// Fetch user's wellness entries
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM wellness_entries WHERE user_id = ? ORDER BY input_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();

// Include the sidebar component
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia - Hyvinvointiseuranta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #43cea2;
            color: white;
            font-weight: bold;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }
        .table th {
            background-color: #3ab793;
            color: white;
        }
    </style>
</head>
<body>
   <?php 
    include 'sidebar.php';
    renderSidebar('history');
    ?>

    <div class="main-content">
        <div class="container mt-4">
            <h1 class="mb-4">Historia</h1>
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Hyvinvointimerkinnät</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($entries)): ?>
                        <p>Ei merkintöjä vielä.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Päivämäärä</th>
                                        <th>Uni (h)</th>
                                        <th>Vesi (l)</th>
                                        <th>Liikunta (min)</th>
                                        <th>Liikuntatyyppi</th>
                                        <th>Mieliala</th>
                                        <th>Ravitsemus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entries as $entry): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($entry['input_date']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['sleep_hours']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['water_intake']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['exercise_duration']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['exercise_type']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['mood']); ?></td>
                                            <td><?php echo htmlspecialchars($entry['nutrition']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>