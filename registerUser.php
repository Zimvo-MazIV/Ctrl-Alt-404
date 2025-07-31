<?php
// registerUser.php - Handles user registration for our SPCA project
// Hope4Paws

require 'databaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!$fullname || !$email || !$phone || !$username || !$password) {
        echo "<p>All fields are required.</p>";
        exit;
    }

    // Check if username or email already exists
    $sqli = "SELECT id FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
    $resulti = $conn->query($sqli);
    if ($resulti && $resulti->num_rows > 0) {
        echo "<p>Username or email already exists. Please try another.</p>";
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user 
    $sql = "INSERT INTO users(fullname, email, phone, username, password) 
            VALUES('$fullname', '$email', '$phone', '$username', '$hashedPassword')";

    $result = $conn->query($sql);
    if ($result === false) {
        die("<br>Unable to register user: " . $conn->error);
    } else {
        echo "<br>User successfully registered! You can now <a href='login.html'>login</a>.";
    }
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
