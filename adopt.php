<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $next = 'adopt.php';
    if (!empty($_SERVER['QUERY_STRING'])) {
        $next .= '?' . $_SERVER['QUERY_STRING'];
    }
    header('Location: login.html?next=' . urlencode($next));
    exit;
}

include 'db.php'; // your DB connection

$userId = $_SESSION['user_id'];
$animalId = isset($_GET['animalId']) ? (int)$_GET['animalId'] : 0;

if ($animalId <= 0) {
    die("Invalid animal selected.");
}

// Check if animal exists
$stmt = $conn->prepare("SELECT aname, availabilityStatus FROM Animal WHERE animalID = ? AND isDeleted = 0");
$stmt->bind_param("i", $animalId);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();
$stmt->close();

if (!$animal) {
    die("Animal not found.");
}

// Fetch user details for default application fields
$stmt = $conn->prepare("SELECT name, phone FROM User WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}

// Insert adoption application
$stmt = $conn->prepare("
    INSERT INTO AdoptionApplication
    (applicationName, applicationContact, applicationDate, status, animalID, userID)
    VALUES (?, ?, NOW(), 'Pending', ?, ?)
");

$stmt->bind_param(
    "ssii",
    $user['name'],
    $user['phone'],
    $animalId,
    $userId
);

if ($stmt->execute()) {
    echo "<p>Your adoption application for <strong>{$animal['aname']}</strong> has been submitted successfully!</p>";
    echo '<p><a href="index.html">Back to adoption list</a></p>';
} else {
    echo "<p>Error submitting adoption application. Please try again.</p>";
}

$stmt->close();
?>
