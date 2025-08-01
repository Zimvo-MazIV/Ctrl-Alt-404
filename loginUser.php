<?php
// loginUser.php - Handles user login for SPCA
// The css within a php script was learnt from W3Schools
require 'databaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        echo '<div style="
            max-width: 400px;
            margin: 40px auto;
            background: #fff3f3;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ffcdd2;
            color: #c62828;
            font-family: Arial, sans-serif;
            text-align: center;
            border: 1px solid #ffcdd2;
        ">
            <h3 style="margin-top:0;">Error</h3>
            <p>Both fields are required.</p>
        </div>';
        exit;
    }

    // Get user by username
    $sql = "SELECT * FROM users WHERE username = '" . $conn->real_escape_string($username) . "' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $fullName = htmlspecialchars($user['name'] . ' ' . $user['surname']);
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
                <h3 style="margin-top:0;">Login Successful!</h3>
                <p>Welcome, ' . $fullName . '.</p>
            </div>';
            // Here you can start a session, redirect, etc.
        } else {
            echo '<div style="
                max-width: 400px;
                margin: 40px auto;
                background: #fff3f3;
                padding: 24px;
                border-radius: 8px;
                box-shadow: 0 2px 8px #ffcdd2;
                color: #c62828;
                font-family: Arial, sans-serif;
                text-align: center;
                border: 1px solid #ffcdd2;
            ">
                <h3 style="margin-top:0;">Error</h3>
                <p>Incorrect password.</p>
            </div>';
        }
    } else {
        echo '<div style="
            max-width: 400px;
            margin: 40px auto;
            background: #fff3f3;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #ffcdd2;
            color: #c62828;
            font-family: Arial, sans-serif;
            text-align: center;
            border: 1px solid #ffcdd2;
        ">
            <h3 style="margin-top:0;">Error</h3>
            <p>User not found.</p>
        </div>';
    }
    $conn->close();
} else {
    echo '<div style="
        max-width: 400px;
        margin: 40px auto;
        background: #fff3f3;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 2px 8px #ffcdd2;
        color: #c62828;
        font-family: Arial, sans-serif;
        text-align: center;
        border: 1px solid #ffcdd2;
    ">
        <h3 style="margin-top:0;">Error</h3>
        <p>Invalid request.</p>
    </div>';
}
?>
