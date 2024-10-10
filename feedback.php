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
    $feedback = trim($_POST["feedback"]);

    // Validate form fields
    if (empty($feedback)) {
        $errors[] = "Palaute on pakollinen.";
    }

    if (empty($errors)) {
        // Insert data into the Feedback table
        $sql = "INSERT INTO feedback (user_id, message, feedback_date, created_at, updated_at) VALUES (?, ?, NOW(), NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $feedback);

        if ($stmt->execute()) {
            $success = "Palautteesi on lähetetty onnistuneesti!";
        } else {
            $errors[] = "Virhe: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anna palautetta - Hyvinvointiseuranta</title>
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
        }
        .card-header {
            background-color: #43cea2;
            color: white;
            font-weight: bold;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }
        .btn-primary {
            background-color: #43cea2;
            border-color: #43cea2;
        }
        .btn-primary:hover {
            background-color: #3ab793;
            border-color: #3ab793;
        }
    </style>
</head>
<body>
   <?php 
    include 'sidebar.php';
    renderSidebar('index');
    ?>

    <div class="main-content">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="mb-0">Anna palautetta</h2>
                        </div>
                        <div class="card-body">
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
                            <form id="feedbackForm" method="POST" action="feedback.php">
                                <div class="mb-3">
                                    <label for="feedback" class="form-label">Palautteesi</label>
                                    <textarea class="form-control" id="feedback" name="feedback" rows="6" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Lähetä palaute</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>