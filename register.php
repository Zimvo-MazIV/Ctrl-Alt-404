<?php
echo "
<style>
    .hope4paws-title {
        font-family: Calibri, Calibre, Arial, sans-serif;
        color: #0074D9;
        font-size: 2.5em;
        font-weight: bold;
        position: absolute;
        top: 20px;
        left: 30px;
        margin: 0;
        letter-spacing: 1px;
        z-index: 1000;
    }
    body { margin-top: 80px; }
</style>
<div class='hope4paws-title'>Hope4Paws</div>
";

include 'databaseConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<div class='error'>Passwords do not match. <a href='register.html'>Try again</a></div>";
        exit();
    }

    // Enforce strong password (at least 8 characters, one uppercase, one number)
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        echo "<div class='error'>Password must be at least 8 characters long, include an uppercase letter and a number. <a href='register.html'>Go back</a></div>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='error'>Email is already registered. <a href='register.html'>Try a different email</a></div>";
    } else {
        // Insert user into DB
        $insert = $conn->prepare("INSERT INTO users (name, surname, phone, email, password) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $name, $surname, $phone, $email, $hashed_password);

        if ($insert->execute()) {
            echo "<div class='success'>Registration successful!  Welcome to Hope4Paws </div>";
        } else {
            echo "<div class='error'>Error registering. Please try again later.</div>";
        }

        $insert->close();
    }

    $stmt->close();
    $conn->close();
}

/*<label for="availabilityStatus">Availability Status</label>
    <select name="availabilityStatus" id="availabilityStatus">
      <option value="">-- Select Status --</option>
      <option value="Available">Available</option>
      <option value="Adopted">Adopted</option>
      <option value="Pending">Pending</option>
    </select>*/
?>
