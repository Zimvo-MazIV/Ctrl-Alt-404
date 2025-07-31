<?php
// loginUser.php - Handles user login for SPCA

require 'databaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        echo "<p>Both fields are required.</p>";
        exit;
    }

    // Get user by username
    $sql = "SELECT * FROM users WHERE username = '" . $conn->real_escape_string($username) . "' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "<p>Login successful! Welcome, " . htmlspecialchars($user['fullname']) . ".</p>";
            // Here you can start a session, redirect, etc.
        } else {
            echo "<p>Incorrect password.</p>";
        }
    } else {
        echo "<p>User not found.</p>";
    }
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
