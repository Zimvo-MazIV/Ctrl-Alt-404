<?php
// registerUser.php - Handles user registration for our SPCA project
// Hope4Paws

require 'databaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (!$name || !$surname || !$email || !$phone || !$username || !$password) {
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
    $sql = "INSERT INTO users(`name`, `surname`, email, phone, username, password) 
            VALUES('$name', '$surname', '$email', '$phone', '$username', '$hashedPassword')";

    $result = $conn->query($sql);
    if ($result === false) {
        die("<br>Unable to register user: " . $conn->error);
    } else {
        echo '<div style="
            max-width: 400px;
            margin: 40px auto;
            background: #e6fff2;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #b2dfdb;
            color: #00695c;
            font-family: Arial, sans-serif;
            text-align: center;
            border: 1px solid #b2dfdb;
        ">
            <h3 style="margin-top:0;">Registration Successful!</h3>
            <p>User successfully registered! You can now <a href="login.html" style="color:#0287a8;text-decoration:underline;">login</a>.</p>
        </div>';
    }
    $conn->close();
} else {
    echo "<p>Invalid request.</p>";
}
?>
