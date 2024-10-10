<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: kirjaudu.php');
    exit();
}

// Database connection
include "db_connect.php";

$user_id = $_SESSION['id'];
$success = $error = "";

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($name) || empty($email)) {
        $error = "Nimi ja sähköposti ovat pakollisia kenttiä.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = "Uusi salasana ja vahvistus eivät täsmää.";
    } else {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $email, $user_id);
        
        if ($stmt->execute()) {
            if (!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $hashed_password, $user_id);
                $stmt->execute();
            }
            $success = "Profiili päivitetty onnistuneesti.";
            // Update session data
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
        } else {
            $error = "Virhe päivitettäessä profiilia: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();

// Include the sidebar component
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiili - Hyvinvointiseuranta</title>
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
    renderSidebar('profile');
    ?>

    <div class="main-content">
        <div class="container mt-4">
            <h1 class="mb-4">Profiili</h1>
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Muokkaa profiilia</h2>
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nimi</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Sähköposti</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Uusi salasana (jätä tyhjäksi, jos et halua vaihtaa)</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Vahvista uusi salasana</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                        <button type="submit" class="btn btn-primary">Päivitä profiili</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>