<?php
$servername = "localhost";   // Replace with your database server (usually "localhost")
$username = "root";          // Your MySQL username
$password = "";              // Your MySQL password
$dbname = "hyvinvointi"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>