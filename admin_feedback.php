<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header('Location: kirjaudu.php');
    exit();
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
include "db_connect.php";

// Fetch all feedback
$sql = "SELECT f.id, u.username, f.message, f.feedback_date, f.created_at, f.updated_at 
        FROM feedback f 
        JOIN users u ON f.user_id = u.id 
        ORDER BY f.created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>All Feedback</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Message</th>
                    <th>Feedback Date</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['username'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['message'] ?? 'No message'); ?></td>
                <td><?php echo htmlspecialchars($row['feedback_date'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['created_at'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['updated_at'] ?? ''); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No feedback found.</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</body>
</html>