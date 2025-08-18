<?php
header('Content-Type: application/json');
session_start();

$loggedIn = isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id']);

echo json_encode([
	'loggedIn' => $loggedIn,
	'userId' => $loggedIn ? (int)$_SESSION['user_id'] : null,
	'email' => $loggedIn && isset($_SESSION['email']) ? $_SESSION['email'] : null,
]);

?>

