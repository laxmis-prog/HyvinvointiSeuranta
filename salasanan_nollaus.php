<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db_connect.php";
$token = isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        // Check if the token is valid and not expired
        $stmt = $conn->prepare("SELECT * FROM password_reset_requests WHERE token = ? AND expiry > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['user_id'];
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);


        // Update the password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $userId);
        $stmt->execute();

            // delete the password in the database
            $stmt = $conn->prepare("DELETE FROM password_reset_requests WHERE  token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            echo 'Salasana on päivitetty onnistuneesti.';
        } 

        $stmt->close();
    } else {
        echo 'Salasanat eivät täsmää.';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirjaudu sisään - Daily Wellness Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
          <!-- Display the error message at the top -->
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger mt-3">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success mt-3">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                  
                <div class="card shadow-lg">
                    <div class="row g-0">
                        <div class="col-md-6 card-left">
                            <h1 class="display-4 mb-4">Hyvinvointi Seuranta</h1>
                            <p class="lead mb-4">Aseta uusi salasanasi ja seuraa päivittäistä hyvinvointiasi.</p>
                            
                        </div>
                        <div class="col-md-6 card-right">
                            <h2 class="text-center mb-4">Palauta salasana</h2>
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                        
                            <form action="salasanan_nollaus.php" method="POST">
                                <div class="mb-3">
                                <label for="new_password" class="form-label">Uusi salasana</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                             <label for="confirm_password" class="form-label">Vahvista uusi salasana</label>
                          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                         </div>
                               
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Päivitä Salasana</button>
                                </div>
                               
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


