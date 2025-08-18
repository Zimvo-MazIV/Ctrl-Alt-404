<?php
header('Content-Type: text/html; charset=UTF-8');

session_start();
require_once __DIR__ . '/../databaseConnection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html?next=' . urlencode('donate.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo 'Invalid request.';
	exit;
}

$amount = (float)($_POST['amount'] ?? 0);
$date = date('Y-m-d');
$donorId = (int)$_SESSION['user_id'];

if ($amount <= 0) {
	echo 'Amount is required.';
	exit;
}

// Insert into donation; acknowledged false by default
$insert = "INSERT INTO donation(date, amount, acknowledged, donorID) VALUES ('{$conn->real_escape_string($date)}', {$amount}, 0, {$donorId})";

if ($conn->query($insert) === true) {
	echo 'Thank you for your donation!';
} else {
	echo 'Unable to record donation at this time.';
}

?>

